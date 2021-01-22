<?php
/**
 * Plugin Name: Simple Custom CSS and JS
 * Plugin URI: https://wordpress.org/plugins/custom-css-js/
 * Description: Easily add Custom CSS or JS to your website with an awesome editor.
 * Version: 3.35
 * Author: SilkyPress.com
 * Author URI: https://www.silkypress.com
 * License: GPL2
 *
 * Text Domain: custom-css-js
 * Domain Path: /languages/
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'CustomCSSandJS' ) ) :
	/**
	 * Main CustomCSSandJS Class
	 *
	 * @class CustomCSSandJS
	 */
	final class CustomCSSandJS {

		public $search_tree         = false;
		protected static $_instance = null;
		private $settings           = array();


		/**
		 * Main CustomCSSandJS Instance
		 *
		 * Ensures only one instance of CustomCSSandJS is loaded or can be loaded
		 *
		 * @static
		 * @return CustomCSSandJS - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'An error has occurred. Please reload the page and try again.' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'An error has occurred. Please reload the page and try again.' ), '1.0' );
		}

		/**
		 * CustomCSSandJS Constructor
		 *
		 * @access public
		 */
		public function __construct() {

			include_once 'includes/admin-install.php';
			register_activation_hook( __FILE__, array( 'CustomCSSandJS_Install', 'install' ) );
			add_action( 'init', array( 'CustomCSSandJS_Install', 'register_post_type' ) );

			$this->set_constants();

			if ( is_admin() ) {
				add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
				include_once 'includes/admin-screens.php';
				include_once 'includes/admin-config.php';
				include_once 'includes/admin-addons.php';
				include_once 'includes/admin-warnings.php';
				include_once 'includes/admin-notices.php';
			}

			$this->search_tree = get_option( 'custom-css-js-tree' );
			$this->settings    = get_option( 'ccj_settings' );
			if ( ! isset( $this->settings['remove_comments'] ) ) {
				$this->settings['remove_comments'] = false;
			}

			if ( ! $this->search_tree || count( $this->search_tree ) == 0 ) {
				return false;
			}

			if ( is_null( self::$_instance ) ) {
				$this->print_code_actions();
				if ( isset ( $this->search_tree['jquery'] ) && $this->search_tree['jquery'] === true ) {
					add_action( 'wp_enqueue_scripts', 'CustomCSSandJS::wp_enqueue_scripts' );
				}
			}
		}

		/**
		 * Add the appropriate wp actions
		 */
		function print_code_actions() {
			foreach ( $this->search_tree as $_key => $_value ) {
				$action = 'wp_';
				if ( strpos( $_key, 'admin' ) !== false ) {
					$action = 'admin_';
				}
				if ( strpos( $_key, 'login' ) !== false ) {
					$action = 'login_';
				}
				if ( strpos( $_key, 'header' ) !== false ) {
					$action .= 'head';
				} elseif ( strpos( $_key, 'body_open' ) !== false ) {
					$action .= 'body_open';
				} else {
					$action .= 'footer';
				}

				$priority = ( $action == 'wp_footer' ) ? 40 : 10;

				add_action( $action, array( $this, 'print_' . $_key ), $priority );
			}
		}

		/**
		 * Print the custom code.
		 */
		public function __call( $function, $args ) {

			if ( strpos( $function, 'print_' ) === false ) {
				return false;
			}

			$function = str_replace( 'print_', '', $function );

			if ( ! isset( $this->search_tree[ $function ] ) ) {
				return false;
			}

			$args = $this->search_tree[ $function ];

			if ( ! is_array( $args ) || count( $args ) == 0 ) {
				return false;
			}

			$where = strpos( $function, 'external' ) !== false ? 'external' : 'internal';
			$type  = strpos( $function, 'css' ) !== false ? 'css' : '';
			$type  = strpos( $function, 'js' ) !== false ? 'js' : $type;
			$type  = strpos( $function, 'html' ) !== false ? 'html' : $type;
			$tag   = array( 'css' => 'style', 'js' => 'script' );

			$type_attr = ( $type === 'js' && ! current_theme_supports( 'html5', 'script' ) ) ? ' type="text/javascript"' : '';
			$type_attr = ( $type === 'css' && ! current_theme_supports( 'html5', 'style' ) ) ? ' type="text/css"' : $type_attr;

			$upload_url = str_replace( array( 'https://', 'http://' ), '//', CCJ_UPLOAD_URL ) . '/';

			if ( $where === 'internal' ) {

				$before = $this->settings['remove_comments'] ? '' : '<!-- start Simple Custom CSS and JS -->' . PHP_EOL;
				$after  = $this->settings['remove_comments'] ? '' : '<!-- end Simple Custom CSS and JS -->' . PHP_EOL;

				if ( $type === 'css' || $type === 'js' ) {
					$before .= '<' . $tag[ $type ] . ' ' . $type_attr . '>' . PHP_EOL;
					$after   = '</' . $tag[ $type ] . '>' . PHP_EOL . $after;
				}

			}

			foreach ( $args as $_filename ) {

				if ( $where === 'internal' && ( strstr( $_filename, 'css' ) || strstr( $_filename, 'js' ) ) ) {
					if ( $this->settings['remove_comments'] || empty( $type_attr ) ) {
						$custom_code = @file_get_contents( CCJ_UPLOAD_DIR . '/' . $_filename );
						if ( $this->settings['remove_comments'] ) {
								$custom_code = str_replace( array( 
										'<!-- start Simple Custom CSS and JS -->' . PHP_EOL, 
										'<!-- end Simple Custom CSS and JS -->' . PHP_EOL 
								), '', $custom_code );
						}
						if ( empty( $type_attr ) ) {
							$custom_code = str_replace( array( ' type="text/javascript"', ' type="text/css"' ), '', $custom_code );
						}
						echo $custom_code;
					} else {
						echo @file_get_contents( CCJ_UPLOAD_DIR . '/' . $_filename );
					}
				}

				if ( $where === 'internal' && ! strstr( $_filename, 'css' ) && ! strstr( $_filename, 'js' ) ) {
					$post = get_post( $_filename );
					echo $before . $post->post_content . $after;
				}

				if ( $where === 'external' && $type === 'js' ) {
					echo PHP_EOL . "<script{$type_attr} src='{$upload_url}{$_filename}'></script>" . PHP_EOL;
				}

				if ( $where === 'external' && $type === 'css' ) {
					$shortfilename = preg_replace( '@\.css\?v=.*$@', '', $_filename );
					echo PHP_EOL . "<link rel='stylesheet' id='{$shortfilename}-css' href='{$upload_url}{$_filename}'{$type_attr} media='all' />" . PHP_EOL;
				}

				if ( $where === 'external' && $type === 'html' ) {
					$_filename = str_replace( '.html', '', $_filename );
					$post      = get_post( $_filename );
					echo $post->post_content . PHP_EOL;
				}
			}
		}


		/**
		 * Enqueue the jQuery library, if necessary
		 */
		public static function wp_enqueue_scripts() {
			wp_enqueue_script( 'jquery' );
		}


		/**
		 * Set constants for later use
		 */
		function set_constants() {
			$dir       = wp_upload_dir();
			$constants = array(
				'CCJ_VERSION'     => '3.35',
				'CCJ_UPLOAD_DIR'  => $dir['basedir'] . '/custom-css-js',
				'CCJ_UPLOAD_URL'  => $dir['baseurl'] . '/custom-css-js',
				'CCJ_PLUGIN_FILE' => __FILE__,
			);
			foreach ( $constants as $_key => $_value ) {
				if ( ! defined( $_key ) ) {
					define( $_key, $_value );
				}
			}
		}


		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'custom-css-js', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

	}

endif;

/**
 * Returns the main instance of CustomCSSandJS
 *
 * @return CustomCSSandJS
 */
if ( ! function_exists( 'CustomCSSandJS' ) ) {
	function CustomCSSandJS() {
		return CustomCSSandJS::instance();
	}

	CustomCSSandJS();
}


/**
 * Plugin action link to Settings page
*/
if ( ! function_exists( 'custom_css_js_plugin_action_links' ) ) {
	function custom_css_js_plugin_action_links( $links ) {

		$settings_link = '<a href="edit.php?post_type=custom-css-js">' .
		esc_html( __( 'Settings', 'custom-css-js' ) ) . '</a>';

		return array_merge( array( $settings_link ), $links );

	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'custom_css_js_plugin_action_links' );
}



/**
 * Compatibility with the WP Quads Pro plugin,
 * otherwise on a Custom Code save there is a
 * "The link you followed has expired." page shown.
 */
if ( ! function_exists( 'custom_css_js_quads_pro_compat' ) ) {
	function custom_css_js_quads_pro_compat( $post_types ) {
		$match = array_search( 'custom-css-js', $post_types );
		if ( $match ) {
			unset( $post_types[ $match ] );
		}
		return $post_types;
	}
	add_filter( 'quads_meta_box_post_types', 'custom_css_js_quads_pro_compat', 20 );
}

