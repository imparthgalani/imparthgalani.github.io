<?php
/*
Plugin Name:  Conditional Menus
Plugin URI:   https://themify.me/conditional-menus
Version:      1.1.9
Author:       Themify
Author URI:   https://themify.me/
Description:  This plugin enables you to set conditional menus per posts, pages, categories, archive pages, etc.
Text Domain:  themify-cm
Domain Path:  /languages
License:      GNU General Public License v2.0
License URI:  http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 */

if ( !defined( 'ABSPATH' ) ) exit;

register_activation_hook( __FILE__, array( 'Themify_Conditional_Menus', 'activate' ) );

class Themify_Conditional_Menus {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 5 );
		add_action( 'plugins_loaded', array( $this, 'setup' ), 10 );
		add_action( 'wpml_after_startup', array( $this, 'wpml_after_startup' ) );
		add_filter( 'plugin_row_meta', array( $this, 'themify_plugin_meta'), 10, 2 );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'action_links') );
	}

	public function constants() {
		if( ! defined( 'THEMIFY_CM_DIR' ) )
			define( 'THEMIFY_CM_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		if( ! defined( 'THEMIFY_CM_URI' ) )
			define( 'THEMIFY_CM_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		if( ! defined( 'THEMIFY_CM_VERSION' ) )
			define( 'THEMIFY_CM_VERSION', '1.0.1' );
	}

	public function themify_plugin_meta( $links, $file ) {
		if ( plugin_basename( __FILE__ ) === $file ) {
			$row_meta = array(
			  'changelogs'    => '<a href="' . esc_url( 'https://themify.me/changelogs/' ) . basename( dirname( $file ) ) .'.txt" target="_blank" aria-label="' . esc_attr__( 'Plugin Changelogs', 'themify-cm' ) . '">' . esc_html__( 'View Changelogs', 'themify-cm' ) . '</a>'
			);
	 
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
	public function action_links( $links ) {
		if ( is_plugin_active( 'themify-updater/themify-updater.php' ) ) {
			$tlinks = array(
			 '<a href="' . admin_url( 'index.php?page=themify-license' ) . '">'.__('Themify License', 'themify-cm') .'</a>',
			 );
		} else {
			$tlinks = array(
			 '<a href="' . esc_url('https://themify.me/docs/themify-updater-documentation') . '">'. __('Themify Updater', 'themify-cm') .'</a>',
			 );
		}
		return array_merge( $links, $tlinks );
	}
	public function i18n() {
		load_plugin_textdomain( 'themify-cm', false, '/languages' );
	}

	public function setup() {
		if( is_admin() ) {
			add_action( 'load-nav-menus.php', array( $this, 'init' ) );
			add_action( 'after_menu_locations_table', array( $this, 'conditions_dialog' ) );
			add_filter( 'themify_cm_conditions_post_types', array( $this, 'exclude_attachments_from_conditions' ) );
			add_action( 'wp_ajax_themify_cm_get_conditions', array( $this, 'ajax_get_conditions' ) );
			add_action( 'wp_ajax_themify_create_inner_page', array( $this, 'ajax_create_inner_page' ) );
			add_action( 'wp_ajax_themify_create_page_pagination', array( $this, 'ajax_create_page_pagination' ) );
			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'activation_redirect' ) );
			add_action( 'wp_delete_nav_menu', array( $this, 'wp_delete_nav_menu' ) );
		} else {
			add_filter( 'wp_nav_menu_args', array( $this, 'setup_menus' ) );
			add_filter( 'theme_mod_nav_menu_locations', array( $this, 'theme_mod_nav_menu_locations' ), 99 );
		}
	}

	public function get_options() {
		remove_filter( 'theme_mod_nav_menu_locations', array( $this, 'theme_mod_nav_menu_locations' ), 99 );
		$options = get_theme_mod( 'themify_conditional_menus', array() );
		$options = wp_parse_args( $options, get_nav_menu_locations() );
		if( ! is_admin() ) {
			add_filter( 'theme_mod_nav_menu_locations', array( $this, 'theme_mod_nav_menu_locations' ), 99 );
		}
		return $options;
	}

	public function theme_mod_nav_menu_locations( $locations = array() ) {
		if( ! empty( $locations ) ) {
			$menu_assignments = $this->get_options();
			$hasLng=function_exists( 'pll_current_language' ) && function_exists( 'pll_default_language' );
			foreach( $locations as $location => $menu_id ) {
				if( empty( $menu_assignments[$location] ) ) continue;

				$menus = $menu_assignments[$location];

				// PolyLang support
				if( $hasLng===true ) {
					if( pll_current_language() !== pll_default_language() ) {
						$polylang_location = $location . '___' . pll_current_language();
						
						if( ! empty( $menu_assignments[$polylang_location] ) ) {
							$menus = $menu_assignments[$polylang_location];
						}
					}
				}

				if( is_array( $menus ) ) {
					foreach( $menus as $id => $new_menu ) {
						if( $new_menu['menu'] == '' || $new_menu['condition'] == '' ) {
							continue;
						}
						if( $this->check_visibility( $new_menu['condition'] ) ) {
							if( $new_menu[ 'menu' ] == 0 ) {
								unset( $locations[$location] );
							} else {
								$locations[$location] = $new_menu[ 'menu' ];
							}
							continue;
						}
					}
				}
			}
		}

		return $locations;
	}

	/**
	 * Where magic happens.
	 * Filters wp_nav_menu_args to dynamically swap parameters sent to it to change what menu displayed.
	 *
	 * @return array
	 */
	public function setup_menus( $args ) {
		$menu_assignments = $this->get_options();
		if (
			! isset( $args['menu'] ) // if $args['menu'] is set, bail. Only swap menus in nav menu locations.
			&& ! empty( $args['theme_location'] ) && isset( $menu_assignments[ $args['theme_location'] ] )
		) {
			if( is_array( $menu_assignments[$args['theme_location']] ) && ! empty( $menu_assignments[$args['theme_location']] ) ) {
				foreach( $menu_assignments[$args['theme_location']] as $id => $new_menu ) {
					if( $new_menu['menu'] == '' || $new_menu['condition'] == '' ) {
						continue;
					}
					if( $this->check_visibility( $new_menu['condition'] ) ) {
						if( $new_menu[ 'menu' ] == 0 ) {
							add_filter( 'pre_wp_nav_menu', array( $this, 'disable_menu' ), 10, 2 );
							$args['echo'] = false;
						} else {
							$args['menu'] = $new_menu[ 'menu' ];
							/* reset theme_location arg, add filter for 3rd party plugins */
							$args['theme_location'] = apply_filters( 'conditional_menus_theme_location', '', $new_menu, $args );
						}
						continue;
					}
				}
			}
		}

		return $args;
	}

	public function disable_menu( $output, $args ) {
		remove_filter( 'pre_wp_nav_menu', array( $this, 'disable_menu' ), 10, 2 );
		return '';
	}

	public function init() {
		if( isset( $_GET['action'] ) && 'locations' === $_GET['action'] ) {
			$this->save_options();
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue' ) );
		}
	}

	public function save_options() {
		if( isset( $_POST['menu-locations'] ) ) {
		    $themify_cm = isset( $_POST['themify_cm'] ) ? $_POST['themify_cm'] : array();
		    set_theme_mod( 'themify_conditional_menus', $themify_cm );
		}
	}

	public function ajax_get_conditions() {
		$selected = array();
		if( isset( $_POST['selected'] ) ) {
		    parse_str( $_POST['selected'], $selected );
		}
		echo $this->get_visibility_options( $selected );
		die;
	}

	public function admin_enqueue() {
		global $_wp_registered_nav_menus;
		self::themify_enque_style( 'themify-conditional-menus', THEMIFY_CM_URI . 'assets/admin.css', null, THEMIFY_CM_VERSION );
		wp_enqueue_script( 'themify-conditional-menus', self::themify_enque(THEMIFY_CM_URI . 'assets/admin.js'), array( 'jquery', 'jquery-ui-tabs' ), THEMIFY_CM_VERSION, true );
		wp_localize_script( 'themify-conditional-menus', 'themify_cm', array(
			'nav_menus' => array_keys( $_wp_registered_nav_menus ),
			'options' => $this->get_options(),
			'lang' => array(
				'conditions' => __( '+ Conditions', 'themify-cm' ),
				'add_assignment' => __( '+ Conditional Menu', 'themify-cm' ),
				'disable_menu' => __( 'Disable Menu', 'themify-cm' ),
			),
		) );
	}

	public function get_conditions_dialog() {
		$output = '
			<div id="themify-cm-conditions" class="themify-cm-conditions-container themify-admin-lightbox clearfix" style="display: none;" data-item="">
				<h3 class="themify-cm-title">' . __( 'Condition', 'themify-cm' ) . '</h3>
				<a href="#" class="themify-cm-close">x</a>
				<div class="lightbox_container">
				</div>
				<a href="#" class="button uncheck-all">'. __( 'Uncheck All', 'themify-cm' ) .'</a>
				<a href="#" class="button button-primary themify-cm-save alignright">' . __( 'Save', 'themify-cm' ) . '</a>
			</div>
			<div id="themify-cm-overlay"></div>
		';

		return $output;
	}

	public function conditions_dialog() {
		echo $this->get_conditions_dialog(),
		    '<span id="themify-cm-about">' , sprintf( __( 'About <a href="%s">Conditional Menus</a>', 'themify-cm' ), admin_url( 'admin.php?page=conditional-menus' ) ) , '</span>';
	}

	function exclude_attachments_from_conditions( $post_types ) {
		unset( $post_types['attachment'] );
		return $post_types;
	}

	/**
	 * Check if an item is visible for the current context
	 *
	 * @return bool
	 */
	public function check_visibility( $logic ) {
		parse_str( $logic, $logic );
		$query_object = get_queried_object();

		// Logged-in check
		if( isset( $logic['general']['logged'] ) ) {
			if( ! is_user_logged_in() ) {
				return false;
			}
			unset( $logic['general']['logged'] );
			if( empty( $logic['general'] ) ) {
			    unset( $logic['general'] );
			}
		}

		// User role check
		if ( ! empty( $logic['roles'] )
			// check if *any* of user's role(s) matches
			&& ! count( array_intersect( wp_get_current_user()->roles, array_keys( $logic['roles'], true ) ) )
		) {
			return false; // bail early.
		}
		unset( $logic['roles'] );

		if( ! empty( $logic ) ) {
			if( ( isset( $logic['general']['home'] ) && is_front_page())
				|| (isset( $logic['general']['404'] ) &&  is_404() )
				|| (isset( $logic['general']['page'] ) &&  is_page() &&  ! is_front_page() )
				|| (isset( $logic['general']['single'] ) && is_single() )
				|| ( isset( $logic['general']['search'] )  && is_search() )
				|| ( isset( $logic['general']['author'] ) && is_author() )
				|| ( isset( $logic['general']['category'] ) && is_category())
				|| ( isset($logic['general']['tag']) && is_tag() )
				|| ( isset($logic['general']['date']) && is_date() )
				|| ( isset($logic['general']['year'])  && is_year())
				|| ( isset($logic['general']['month']) && is_month())
				|| (isset($logic['general']['day']) && is_day())
				|| ( is_singular() && isset( $logic['general'][$query_object->post_type] ) && $query_object->post_type !== 'page' && $query_object->post_type !== 'post' )
				|| ( is_tax() && isset( $logic['general'][$query_object->taxonomy] ) )
			) {
				return true;
			} else { // let's dig deeper into more specific visibility rules
				if( ! empty( $logic['tax'] ) ) {
					if(is_singular()){
						if( !empty($logic['tax']['category_single'])){
							if ( empty( $logic['tax']['category_single']['category'] ) ) {
								$cat = get_the_category();
								if(!empty($cat)){
									foreach($cat as $c){
										if($c->taxonomy === 'category' && isset($logic['tax']['category_single']['category'][$c->slug])){
											return true;
										}
									}
								}
								unset($logic['tax']['category_single']['category']);
							}
							foreach ($logic['tax']['category_single'] as $key => $tax) {
								$terms = get_the_terms( get_the_ID(), $key);
								if ( $terms !== false && !is_wp_error($terms) && is_array($terms) ) {
									foreach ( $terms as $term ) {
										if( isset($logic['tax']['category_single'][$key][$term->slug]) ){
											return true;
										}
									}
								}
							}
						}
					} else {
						foreach( $logic['tax'] as $tax => $terms ) {
							$terms = array_keys( $terms );
							if( ( $tax === 'category' && is_category( $terms ) )
								|| ( $tax === 'post_tag' && is_tag( $terms ) )
								|| ( is_tax( $tax, $terms ) )
							) {
								return true;
							}
						}
					}
				}

				if ( ! empty( $logic['post_type'] ) ) {

					foreach( $logic['post_type'] as $post_type => $posts ) {
						$posts = array_keys( $posts );

						if (
							// Post single
							( $post_type === 'post' && is_single( $posts ) )
							// Page view
							|| ( $post_type === 'page' && (
								( 
									( is_page( $posts )
									// check for pages that have a Parent, the slug for these pages are stored differently.
									|| ( isset( $query_object->post_parent ) && $query_object->post_parent > 0 &&
									     ( in_array( '/' . str_replace( strtok( get_home_url(), '?'), '', remove_query_arg( 'lang', get_permalink( $query_object->ID ) ) ), $posts ) ||
									     in_array( str_replace( strtok( get_home_url(), '?'), '', remove_query_arg( 'lang', get_permalink( $query_object->ID ) ) ), $posts ) ||
									     in_array( '/'.$this->child_post_name($query_object).'/', $posts ) )
									  )
								) )
								|| ( ! is_front_page() && is_home() &&  in_array( get_post_field( 'post_name', get_option( 'page_for_posts' ) ), $posts,true ) ) // check for Posts page
								|| ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) && is_shop() && in_array( get_post_field( 'post_name', wc_get_page_id( 'shop' ) ), $posts )  ) // check for WC Shop page
							) )
							// Custom Post Types single view check
							|| ( is_singular( $post_type ) && in_array( $query_object->post_name, $posts,true ) )
							|| ( is_singular( $post_type ) && isset( $query_object->post_parent ) && $query_object->post_parent > 0 && in_array( '/'.$this->child_post_name($query_object).'/', $posts,true ) )
							// for all posts of a post type.
							|| ( is_singular( $post_type ) && get_post_type() === $post_type && in_array( 'E_ALL', $posts ) )
						) {
							return true;
						}
					}
				}
			}
			return false;
		}

		return true;
	}

	function ajax_create_page_pagination() {
		$current_page = isset( $_POST['current_page'] ) ? $_POST['current_page'] : 1;
		$num_of_pages = isset( $_POST['num_of_pages'] ) ? $_POST['num_of_pages'] : 0;
		echo $this->create_page_pagination($current_page, $num_of_pages);
		die;
	}

	/**
	 * Render pagination for specific page.
	 *
	 * @param Integer $current_page The current page that needs to be rendered.
	 * @param Integer $num_of_pages The number of all pages.
	 *
	 * @return String The HTML with pagination.
	 */
	function create_page_pagination( $current_page, $num_of_pages ) {
		$links_in_the_middle = 4;
		$links_in_the_middle_min_1 = $links_in_the_middle - 1;
		$first_link_in_the_middle   = $current_page - floor( $links_in_the_middle_min_1 / 2 );
		$last_link_in_the_middle    = $current_page + ceil( $links_in_the_middle_min_1 / 2 );
		if ( $first_link_in_the_middle <= 0 ) {
			$first_link_in_the_middle = 1;
		}
		if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_min_1 ) {
			$last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_min_1;
		}
		if ( $last_link_in_the_middle > $num_of_pages ) {
			$first_link_in_the_middle = $num_of_pages - $links_in_the_middle_min_1;
			$last_link_in_the_middle  = (int) $num_of_pages;
		}
		if ( $first_link_in_the_middle <= 0 ) {
			$first_link_in_the_middle = 1;
		}
		$pagination = '';
		if ( $current_page != 1 ) {
			$pagination .= '<a href="/page/' . ( $current_page - 1 ) . '" class="prev page-numbers ti-angle-left"/>';
		}
		if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $num_of_pages ) {
			$pagination .= '<a href="/page/" class="page-numbers">1</a>';

			if ( $first_link_in_the_middle != 2 ) {
				$pagination .= '<span class="page-numbers extend">...</span>';
			}
		}
		for ( $i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i ++ ) {
			if ( $i == $current_page ) {
				$pagination .= '<span class="page-numbers current">' . $i . '</span>';
			} else {
				$pagination .= '<a href="/page/' . $i . '" class="page-numbers">' . $i . '</a>';
			}
		}
		if ( $last_link_in_the_middle < $num_of_pages ) {
			if ( $last_link_in_the_middle != ( $num_of_pages - 1 ) ) {
				$pagination .= '<span class="page-numbers extend">...</span>';
			}
			$pagination .= '<a href="/page/' . $num_of_pages . '" class="page-numbers">' . $num_of_pages . '</a>';
		}
		if ( $current_page != $last_link_in_the_middle ) {
			$pagination .= '<a href="/page/' . ( $current_page + $i ) . '" class="next page-numbers ti-angle-right"></a>';
		}

		return $pagination;
	}

	function ajax_create_inner_page() {
		$selected = array();
		if ( isset( $_POST['selected'] ) ) {
			parse_str( $_POST['selected'], $selected );
		}
		$type= isset( $_POST['type'] ) ? $_POST['type'] : 'pages';
		echo $this->create_inner_page($type, $selected);
		die;
	}

	/**
	 * Renders pages, posts types and categories items based on current page.
	 *
	 * @param string $type The type of items to render.
	 * @param array $selected The array of all selected options.
	 *
	 * @return array The HTML to render items as HTML and original values.
	 */
	function create_inner_page( $type, $selected ) {
		$posts_per_page = 26;
		$output = '';
		$new_checked = array();
		switch ($type) {
			case 'page':
				$key = 'page';
				$posts = get_posts( array( 'post_type' => $key, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true) );
				if( ! empty( $posts ) ) {
					$i = 1;
					$page_id = 1;
					$num_of_single_pages = count($posts);
					$num_of_pages = (int) ceil( $num_of_single_pages / $posts_per_page );
					$output .= '<div class="themify-visibility-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
					$output .= '<label class="tf_cm_select_sub"><input data-type="page" type="checkbox" />'.__('Auto apply sub-pages','themify').'</label>';
					$output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . '">';
					foreach ( $posts as $post ) :
						$data = ' data-slug="'.$post->post_name.'"';
						$post->post_name = $this->child_post_name($post);
					if ( $post->post_parent > 0 ) {
							$post->post_name = '/' . $post->post_name . '/';
							$parent = get_post($post->post_parent);
							$data .= ' data-parent="'.$parent->post_name.'"';
						}
						$checked = isset( $selected['post_type'][ $key ][ $post->post_name ] ) ? checked( $selected['post_type'][ $key ][ $post->post_name ], 'on', false ) : '';
						if(!empty($checked)){
							$new_checked[] = urlencode("post_type[$key][$post->post_name]").'=on';
						}
						/* note: slugs are more reliable than IDs, they stay unique after export/import */

						$output .= '<label><input'.$data.' type="checkbox" name="post_type[' . $key . '][' . $post->post_name . ']"' . $checked . ' /><span data-tooltip="'.get_permalink($post->ID).'">' . $post->post_title . '</span></label>';
						if ( $i === ($page_id * $posts_per_page) ) {
							$output .= '</div>';
							++$page_id;
							$output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . ' is-hidden">';
						}
						++$i;
					endforeach;
					$output .= '</div>';
					if ( $num_of_pages > 1 ) {
						$output .= '<div class="themify-visibility-pagination">';
						$output .= $this->create_page_pagination( 1, $num_of_pages );
						$output .= '</div>';
					}
					$output .= '</div>';
				}
				break;

			case 'category_single':
				$m_key = 'category_single';
				$taxonomies = get_taxonomies( array( 'public' => true ) );

				if ( ! empty( $taxonomies ) ) {
					$post_id = 1;
					foreach ( $taxonomies  as $key => $tax) {
						$terms = get_terms( $key, array( 'hide_empty' => true ) );
						$output .= '<div id="visibility-tab-' . $key . '" class="themify-visibility-inner-tab '. ($post_id > 1 ? 'is-hidden' : '') .'">';
						if ( ! empty( $terms ) ) {
							$i                   = 1;
							$page_id             = 1;
							$num_of_single_pages = count( $terms );
							$num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
							$output              .= '<div class="themify-visibility-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
							$output              .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . '">';
							foreach ( $terms as $term ) :
								$checked = isset( $selected['tax'][$m_key][$key][ $term->slug ] ) ? checked( $selected['tax'][$m_key][$key][ $term->slug ], 'on', false ) : '';
								if(!empty($checked)){
									$new_checked[] = urlencode("tax[$m_key][$key][$term->slug]").'=on';
								}
								$output  .= '<label><input type="checkbox" name="tax[' . $m_key . '][' . $key . '][' . $term->slug . ']" ' . $checked . ' /><span data-tooltip="'.get_term_link($term).'">' . $term->name . '</span></label>';
								if ( $i === ( $page_id * $posts_per_page ) ) {
									$output .= '</div>';
									$page_id ++;
									$output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . ' is-hidden">';
								}
								++$i;
							endforeach;
							$output .= '</div>';
							if ( $num_of_pages > 1 ) {
								$output .= '<div class="themify-visibility-pagination">';
								$output .= $this->create_page_pagination( 1, $num_of_pages );
								$output .= '</div>';
							}
							$output .= '</div>';
						}
						$output .= '</div></div></div>';
						++$post_id;
					}
					$output .= '</div>';
				}
				break;

			case 'category':
				$key = 'category';
				$terms = get_terms( 'category', array( 'hide_empty' => true ) );
				if ( ! empty( $terms ) ) {
					$i                   = 1;
					$page_id             = 1;
					$num_of_single_pages = count( $terms );
					$num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
					$output              .= '<div class="themify-visibility-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
					$output		   		 .= '<label class="tf_cm_select_sub"><input data-type="category" type="checkbox" />'.__('Auto apply sub-categories','themify').'</label>';
					$output              .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . '">';
					foreach ( $terms as $term ) :
						$data = ' data-slug="'.$term->slug.'"';
						if ( $term->parent != '0' ) {
							$parent  = get_term( $term->parent, $key);
							$data .= ' data-parent="'.$parent->slug.'"';
						}
						$checked = isset( $selected['tax'][ $key ][ $term->slug ] ) ? checked( $selected['tax'][ $key ][ $term->slug ], 'on', false ) : '';
						if(!empty($checked)){
							$new_checked[] = urlencode("tax[$key][$term->slug]").'=on';
						}
						$output  .= '<label><input'.$data.' type="checkbox" name="tax[' . $key . '][' . $term->slug . ']" ' . $checked . ' /><span data-tooltip="'.get_term_link($term).'">' . $term->name . '</span></label>';
						if ( $i === ( $page_id * $posts_per_page ) ) {
							$output .= '</div>';
							$page_id ++;
							$output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . ' is-hidden">';
						}
						$i++;
					endforeach;
					$output .= '</div>';
					if ( $num_of_pages > 1 ) {
						$output .= '<div class="themify-visibility-pagination">';
						$output .= $this->create_page_pagination( 1, $num_of_pages );
						$output .= '</div>';
					}
					$output .= '</div>';
				}
				break;

			default :
				$post_types = apply_filters( 'themify_hooks_visibility_post_types', get_post_types( array( 'public' => true ) ) );
				unset( $post_types['page'] );
				$post_types = array_map( 'get_post_type_object', $post_types );
				$post_id = 1;
				foreach ( $post_types as $key => $post_type ) {
					$output .= '<div id="visibility-tab-' . $key . '" class="themify-visibility-inner-tab '. ($post_id > 1 ? 'is-hidden' : '') .'">';
					$posts = get_posts( array( 'post_type' => $key, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true ) );
					$checked = isset( $selected['post_type'][ $key ][ 'E_ALL' ] ) ? checked( $selected['post_type'][ $key ][ 'E_ALL' ], 'on', false ) : '';
					if(!empty($checked)){
						$new_checked[] = urlencode("post_type[$key][E_ALL]").'=on';
					}
					$output .= '<p><input type="checkbox" name="' . esc_attr( 'post_type[' . $key . '][E_ALL]' ) . '" ' . $checked . ' />' . __( 'Apply all', 'themify-cm' ) . '</p><br>';
					if ( ! empty( $posts ) ) {
						$i                   = 1;
						$page_id             = 1;
						$num_of_single_pages = count( $posts );
						$num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
						$output              .= '<div class="themify-visibility-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
						$output              .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . '">';
						foreach ( $posts as $post ) :
							$post->post_name = $this->child_post_name($post);
							if ( $post->post_parent > 0 ) {
								$post->post_name = '/' . $post->post_name . '/';
							}
							$checked = isset( $selected['post_type'][ $key ][ $post->post_name ] ) ? checked( $selected['post_type'][ $key ][ $post->post_name ], 'on', false ) : '';
							if(!empty($checked)){
								$new_checked[] = urlencode("post_type[$key][$post->post_name]").'=on';
							}
						/* note: slugs are more reliable than IDs, they stay unique after export/import */
							$output .= '<label><input type="checkbox" name="' . esc_attr( 'post_type[' . $key . '][' . $post->post_name . ']' ) . '" ' . $checked . ' /><span data-tooltip="'.get_permalink($post->ID).'">' . esc_html( $post->post_title ) . '</span></label>';
							if ( $i === ( $page_id * $posts_per_page ) ) {
								$output .= '</div>';
								$page_id ++;
								$output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $page_id . ' is-hidden">';
							}
							++$i;
						endforeach;
						$output .= '</div>';
						if ( $num_of_pages > 1 ) {
							$output .= '<div class="themify-visibility-pagination">';
							$output .= $this->create_page_pagination( 1, $num_of_pages );
							$output .= '</div>';
						}
					}
					$output .= '</div></div></div>';
					++$post_id;
				}
				$output .= '</div>';
				break;
		}
		wp_reset_postdata();
		// Update original values
		$values = explode('&',$_POST['original_values']);
		if(!empty($values) && is_array($values)){
			$values = array_diff($values,$new_checked);
		}
		$values = empty($values) ? '' : implode('&',$values);
		$result = json_encode(array('original_values'=>$values,'html'=>$output));
		return $result;
	}

	private function child_post_name($post) {
		$str = $post->post_name;

		if ( $post->post_parent > 0 ) {
			$parent = get_post($post->post_parent);
			$parent->post_name = $this->child_post_name($parent);
			$str = $parent->post_name . '/' . $str;
		}

		return $str;
	}
	public function get_visibility_options( $selected = array() ) {
		$post_types = apply_filters( 'themify_hooks_visibility_post_types', get_post_types( array( 'public' => true ) ) );
		unset( $post_types['page'] );
		$post_types = array_map( 'get_post_type_object', $post_types );

		$taxonomies = apply_filters( 'themify_hooks_visibility_taxonomies', get_taxonomies( array( 'public' => true ) ) );
		$taxonomies = array_map( 'get_taxonomy', $taxonomies );


		$output = '<form id="visibility-tabs" class="ui-tabs"><ul class="clearfix">';

		/* build the tab links */
		$output .= '<li><a href="#visibility-tab-general">' . __( 'General', 'themify-cm' ) . '</a></li>';
		$output .= '<li><a href="#visibility-tab-pages" class="themify-visibility-tab" data-type="page">' . __( 'Pages', 'themify-cm' ) . '</a></li>';
			$output .= '<li><a href="#visibility-tab-categories-singles" class="themify-visibility-tab" data-type="category_single">' . __( 'In Categories', 'themify-cm' ) . '</a></li>';
		$output .= '<li><a href="#visibility-tab-categories" class="themify-visibility-tab" data-type="category">' . __( 'Categories', 'themify-cm' ) . '</a></li>';
		$output .= '<li><a href="#visibility-tab-post-types" class="themify-visibility-tab" data-type="post">' . __( 'Post Types', 'themify-cm' ) . '</a></li>';
		$output .= '<li><a href="#visibility-tab-taxonomies">' . __( 'Taxonomies', 'themify-cm' ) . '</a></li>';
		$output .= '<li><a href="#visibility-tab-userroles">' . __( 'User Roles', 'themify-cm' ) . '</a></li>';
		$output .= '</ul>';

		/* build the tab items */
		$output .= '<div id="visibility-tab-general" class="themify-visibility-options clearfix">';
			$checked = isset( $selected['general']['home'] ) ? checked( $selected['general']['home'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[home]" '. $checked .' /><span data-tooltip="'.get_home_url().'">' . __( 'Home page', 'themify-cm' ) . '</span></label>';
			$checked = isset( $selected['general']['404'] ) ? checked( $selected['general']['404'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[404]" '. $checked .' />' . __( '404 page', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['page'] ) ? checked( $selected['general']['page'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[page]" '. $checked .' />' . __( 'Page views', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['single'] ) ? checked( $selected['general']['single'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[single]" '. $checked .' />' . __( 'Single post views', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['search'] ) ? checked( $selected['general']['search'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[search]" '. $checked .' />' . __( 'Search pages', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['category'] ) ? checked( $selected['general']['category'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[category]" '. $checked .' />' . __( 'Category archive', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['tag'] ) ? checked( $selected['general']['tag'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[tag]" '. $checked .' />' . __( 'Tag archive', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['author'] ) ? checked( $selected['general']['author'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[author]" '. $checked .' />' . __( 'Author pages', 'themify-cm' ) . '</label>';
			$checked = isset($selected['general']['date']) ? checked($selected['general']['date'], 'on', false) : '';
			$output .= '<label><input type="checkbox" name="general[date]" ' . $checked . ' />' . __( 'Date archive pages', 'themify-cm' ) . '</label>';
			$checked = isset($selected['general']['year']) ? checked($selected['general']['year'], 'on', false) : '';
			$output .= '<label><input type="checkbox" name="general[year]" ' . $checked . ' />' . __( 'Year based archive', 'themify-cm' ) . '</label>';
			$checked = isset($selected['general']['month']) ? checked($selected['general']['month'], 'on', false) : '';
			$output .= '<label><input type="checkbox" name="general[month]" ' . $checked . ' />' . __( 'Month based archive', 'themify-cm' ) . '</label>';
			$checked = isset($selected['general']['day']) ? checked($selected['general']['day'], 'on', false) : '';
			$output .= '<label><input type="checkbox" name="general[day]" ' . $checked . ' />' . __( 'Day based archive', 'themify-cm' ) . '</label>';
			$checked = isset( $selected['general']['logged'] ) ? checked( $selected['general']['logged'], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="general[logged]" '. $checked .' />' . __( 'User logged in', 'themify-cm' ) . '</label>';

			/* General views for CPT */
			foreach( get_post_types( array( 'public' => true, 'exclude_from_search' => false, '_builtin' => false ) ) as $key => $post_type ) {
				$post_type = get_post_type_object( $key );
				$checked = isset( $selected['general'][$key] ) ? checked( $selected['general'][$key], 'on', false ) : '';
				$output .= '<label><input type="checkbox" name="general['. $key .']" '. $checked .' />' . sprintf( __( 'Single %s View', 'themify-cm' ), $post_type->labels->singular_name ) . '</label>';
			}

			/* Custom taxonomies archive view */
			foreach( get_taxonomies( array( 'public' => true, '_builtin' => false ) ) as $key => $tax ) {
				$tax = get_taxonomy( $key );
				$checked = isset( $selected['general'][$key] ) ? checked( $selected['general'][$key], 'on', false ) : '';
				$output .= '<label><input type="checkbox" name="general['. $key .']" '. $checked .' />' . sprintf( __( '%s Archive View', 'themify-cm' ), $tax->label ) . '</label>';
			}

		$output .= '</div>'; // tab-general
		   
		// Pages tab
		wp_reset_postdata();
		$output .= '<div id="visibility-tab-pages" class="themify-visibility-options themify-visibility-type-options clearfix" data-type="page">';
		$output .= '</div>'; // tab-pages
				
		// Category Singles tab
		$output .= '<div id="visibility-tab-categories-singles" class="themify-visibility-options clearfix" data-type="category_single">';
		$output .= '<div id="themify-visibility-category-single-inner-tabs" class="themify-visibility-inner-tabs">';
		$output .= '<ul class="inline-tabs clearfix">';
		foreach( $taxonomies as $key => $tax ) {
			$output .= '<li><a href="#visibility-tab-' . $key . '">' . $tax->label . '</a></li>';
		}
		$output .= '</ul>';
		$output .= '<div class="themify-visibility-type-options clearfix" data-type="category_single"></div>';
		$output .= '</div>';
		$output .= '</div>'; // tab-post-typesz
				//
		// Categories tab
		$output .= '<div id="visibility-tab-categories" class="themify-visibility-options themify-visibility-type-options clearfix" data-type="category">';
		$output .= '</div>'; // tab-categories

		// Post types tab
		$output .= '<div id="visibility-tab-post-types" class="themify-visibility-options clearfix" data-type="post">';
			$output .= '<div id="themify-visibility-post-types-inner-tabs" class="themify-visibility-inner-tabs">';
			$output .= '<ul class="inline-tabs clearfix">';
				foreach( $post_types as $key => $post_type ) {
					$output .= '<li><a href="#visibility-tab-' . $key . '">' . $post_type->label . '</a></li>';
				}
			$output .= '</ul>';
		$output .= '<div class="themify-visibility-type-options clearfix" data-type="post"></div>';
			$output .= '</div>';
		$output .= '</div>'; // tab-post-types

		unset( $taxonomies['category'] );
		// Taxonomies tab
		$output .= '<div id="visibility-tab-taxonomies" class="themify-visibility-options clearfix">';
			$output .= '<div id="themify-visibility-taxonomies-inner-tabs" class="themify-visibility-inner-tabs">';
			$output .= '<ul class="inline-tabs clearfix">';
				foreach( $taxonomies as $key => $tax ) {
					$output .= '<li><a href="#visibility-tab-' . $key . '">' . $tax->label . '</a></li>';
				}
			$output .= '</ul>';
			foreach( $taxonomies as $key => $tax ) {
				$output .= '<div id="visibility-tab-'. $key .'" class="clearfix">';
				$terms = get_terms( $key, array( 'hide_empty' => true ) );
				if( ! empty( $terms ) ) : foreach( $terms as $term ) :
					$checked = isset( $selected['tax'][$key][$term->slug] ) ? checked( $selected['tax'][$key][$term->slug], 'on', false ) : '';
					$output .= '<label><input type="checkbox" name="tax['. $key .']['. $term->slug .']" '. $checked .' /><span data-tooltip="'.get_term_link($term).'">' . $term->name . '</span></label>';
				endforeach; endif;
				$output .= '</div>';
			}
			$output .= '</div>';
		$output .= '</div>'; // tab-taxonomies

		// User Roles tab
		$output .= '<div id="visibility-tab-userroles" class="themify-visibility-options clearfix">';
		foreach( $GLOBALS['wp_roles']->roles as $key => $role ) {
			$checked = isset( $selected['roles'][$key] ) ? checked( $selected['roles'][$key], 'on', false ) : '';
			$output .= '<label><input type="checkbox" name="roles['. $key .']" '. $checked .' />' . $role['name'] . '</label>';
		}
		$output .= '</div>'; // tab-userroles

		$output .= '</form>';
		// keep original values
		$values = explode('&',$_POST['selected']);
		if(!empty($values) && is_array($values)){
			foreach ($values as $k=>$val){
				if(0 === strpos($val,'general') || 0 === strpos($val,'tax%5Bpost_tag%5D') || 0 === strpos($val,'roles')){
					unset($values[$k]);
				}
			}
			$values = implode('&',$values);
		}else{
			$values = '';
		}
		$output .= '<input type="hidden" id="themify-cm-original-conditions" value="'.$values.'"/>';
		return $output;
	}

	public function add_plugin_page() {
		add_management_page(
			__( 'Themify Conditional Menus', 'themify-cm' ),
			__( 'Conditional Menus', 'themify-cm' ),
			'manage_options',
			'conditional-menus',
			array( $this, 'create_admin_page' ),
			99
		);
	}

	public function create_admin_page() {
		include( THEMIFY_CM_DIR . '/docs/index.html' );
	}

	public static function activate( $network_wide ) {
		if( version_compare( get_bloginfo( 'version' ), '3.9', '<' ) ) {
			/* the plugin requires at least 3.9 */
			deactivate_plugins( basename( __FILE__ ) ); // Deactivate the plugin
		} else {
			if( ! $network_wide && ! isset( $_GET['activate-multi'] ) ) {
				add_option( 'themify_conditional_menus_activation_redirect', true );
			}
		}
	}

	public function activation_redirect() {
		if( get_option( 'themify_conditional_menus_activation_redirect', false ) ) {
			delete_option( 'themify_conditional_menus_activation_redirect' );
			wp_redirect( admin_url( 'admin.php?page=conditional-menus' ) );
		}
	}

	/**
	 * Disable WPML nav menu filtering in the Menu Locations manager
	 *
	 * @since 1.0.2
	 */
	public function wpml_after_startup() {
		global $pagenow;
		if( isset( $_GET['action'] ) && 'locations' === $_GET['action'] && is_admin() && $pagenow === 'nav-menus.php' ) {
		    remove_all_filters( 'get_terms', 1 );
		}
	}

	/**
	 * Remove menu assignments when the menu gets deleted
	 *
	 * @since 1.0.7
	 */
	function wp_delete_nav_menu( $menu_id ) {
		$options = get_theme_mod( 'themify_conditional_menus', array() );
		if( ! empty( $options ) ) {
			foreach( $options as $location => $assignments ) {
				if( is_array( $assignments ) && ! empty( $assignments ) ) {
					foreach( $assignments as $key => $menu ) {
						if( $menu['menu'] == $menu_id ) {
							unset( $options[$location][$key] );
						}
					}
				}
			}
		}
		set_theme_mod( 'themify_conditional_menus', $options );
	}
	
	private static function themify_enque($url){
	    static $is=null;
	    if($is===null){
		$is=  function_exists('themify_enque');
	    }
	    if($is===true){
		return themify_enque($url);
	    }
	    return $url;
	}
	
	private static function themify_enque_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all' ){
	    static $is=null;
	    if($is===null){
		$is=  function_exists('themify_enque_style');
	    }
	    if($is===true){
		themify_enque_style($handle,$src,$deps,$ver,$media);
	    }
	    else{
		wp_enqueue_style($handle,$src,$deps,$ver,$media);
	    }
	}
}
$themify_cm = new Themify_Conditional_Menus;
