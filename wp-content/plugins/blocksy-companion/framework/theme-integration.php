<?php

namespace Blocksy;

class ThemeIntegration {
	public function __construct() {
		add_shortcode('blocksy_posts', function ($args, $content) {
			$args = wp_parse_args(
				$args,
				[
					'post_type' => 'post',
					'limit' => 5,

					// post_date | comment_count
					'orderby' => 'post_date',

					// yes | no
					'has_pagination' => 'yes'
				]
			);

			$file_path = dirname(__FILE__) . '/views/blocksy-posts.php';

			return blc_call_fn(
				['fn' => 'blocksy_render_view'],
				$file_path,
				[
					'args' => $args
				]
			);
		});

		add_action('wp_ajax_blocksy_conditions_get_all_taxonomies', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			$cpts = blocksy_manager()->post_types->get_supported_post_types();

			$cpts[] = 'post';
			$cpts[] = 'page';
			$cpts[] = 'product';

			$taxonomies = [];

			foreach ($cpts as $cpt) {
				$taxonomies = array_merge($taxonomies, array_values(array_diff(
					get_object_taxonomies($cpt),
					['post_format']
				)));
			}

			$terms = [];

			foreach ($taxonomies as $taxonomy) {
				$local_terms = array_map(function ($tax) {
					return [
						'id' => $tax->term_id,
						'name' => $tax->name
					];
				}, get_terms(['taxonomy' => $taxonomy]));

				if (empty($local_terms)) {
					continue;
				}

				$terms[] = [
					'id' => $taxonomy,
					'name' => $taxonomy,
					'group' => get_taxonomy($taxonomy)->label
				];

				$terms = array_merge($terms, $local_terms);
			}

			wp_send_json_success([
				'taxonomies' => $terms
			]);
		});

		add_filter(
			'blocksy_add_menu_page',
			function ($res, $options) {
				add_menu_page(
					$options['title'],
					$options['menu-title'],
					$options['permision'],
					$options['top-level-handle'],
					$options['callback'],
					$options['icon-url'],
					2
				);

				return true;
			},
			10, 2
		);

		add_action('rest_api_init', function () {
			return;

			register_rest_field('post', 'images', [
				'get_callback' => function () {
					return wp_prepare_attachment_for_js($object->id);
				},
				'update_callback' => null,
				'schema' => null,
			]);
		});

		add_filter(
			'user_contactmethods',
			function ( $field ) {
				$fields['facebook'] = __( 'Facebook', 'blc' );
				$fields['twitter'] = __( 'Twitter', 'blc' );
				$fields['linkedin'] = __( 'LinkedIn', 'blc' );
				$fields['dribbble'] = __( 'Dribbble', 'blc' );
				$fields['instagram'] = __( 'Instagram', 'blc' );
				$fields['pinterest'] = __( 'Pinterest', 'blc' );
				$fields['wordpress'] = __( 'WordPress', 'blc' );
				$fields['github'] = __( 'GitHub', 'blc' );
				$fields['medium'] = __( 'Medium', 'blc' );
				$fields['youtube'] = __( 'YouTube', 'blc' );
				$fields['vimeo'] = __( 'Vimeo', 'blc' );
				$fields['vkontakte'] = __( 'VKontakte', 'blc' );
				$fields['odnoklassniki'] = __( 'Odnoklassniki', 'blc' );
				$fields['tiktok'] = __( 'TikTok', 'blc' );

				return $fields;
			}
		);

		add_filter(
			'wp_check_filetype_and_ext',
			function ($data=null, $file=null, $filename=null, $mimes=null) {
				if (strpos($filename, '.svg') !== false) {
					$data['type'] = 'image/svg+xml';
					$data['ext'] = 'svg';
				}

				return $data;
			},
			75, 4
		);

		add_filter('upload_mimes', function ($mimes) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		});

		add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size = 'thumbnail') {
			if (! isset($attachment->ID)) {
				return $attr;
			}

			$mime = get_post_mime_type($attachment->ID);

			if ('image/svg+xml' === $mime) {
				$default_height = 100;
				$default_width  = 100;

				$dimensions = $this->svg_dimensions(get_attached_file($attachment->ID));

				if ($dimensions) {
					$default_height = $dimensions['height'];
					$default_width = $dimensions['width'];
				}

				$attr['height'] = $default_height;
				$attr['width'] = $default_width;
			}

			return $attr;
		}, 10, 3);

		add_filter('blocksy_changelogs_list', function ($changelogs) {
			$changelog = null;
			$access_type = get_filesystem_method();

			if ($access_type === 'direct') {
				$creds = request_filesystem_credentials(
					site_url() . '/wp-admin/',
					'', false, false,
					[]
				);

				if ( WP_Filesystem($creds) ) {
					global $wp_filesystem;

					$readme = $wp_filesystem->get_contents(
						BLOCKSY_PATH . '/readme.txt'
					);

					if ($readme) {
						$readme = explode('== Changelog ==', $readme);

						if (isset($readme[1])) {
							$changelogs[] = [
								'title' => __('Companion', 'blc'),
								'changelog' => trim($readme[1])
							];
						}
					}

					if (
						blc_fs()->is__premium_only()
						&&
						BLOCKSY_PATH . '/framework/premium/changelog.txt'
					) {
						$pro_changelog = $wp_filesystem->get_contents(
							BLOCKSY_PATH . '/framework/premium/changelog.txt'
						);

						$changelogs[] = [
							'title' => __('PRO', 'blc'),
							'changelog' => trim($pro_changelog)
						];
					}
				}
			}

			return $changelogs;
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			/*
			wp_enqueue_style(
				'blocksy-companion-styles',
				BLOCKSY_URL . 'static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);
			 */

			wp_enqueue_script(
				'blocksy-companion-scripts',
				BLOCKSY_URL . 'static/bundle/main.js',
				['ct-scripts'],
				$data['Version'],
				true
			);

			$data = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'public_url' => BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/',
			];

			wp_localize_script(
				'blocksy-ext-instagram-scripts',
				'blocksy_ext_instagram_localization',
				$data
			);
		});

		add_action(
			'customize_preview_init',
			function () {
				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-companion-sync-scripts',
					BLOCKSY_URL . 'static/bundle/sync.js',
					['customize-preview', 'wp-date', 'ct-events'],
					$data['Version'],
					true
				);
			}
		);

		if (get_theme_mod('emoji_scripts', 'no') !== 'yes') {
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('admin_print_scripts', 'print_emoji_detection_script');
			remove_action('wp_print_styles', 'print_emoji_styles');
			remove_action('admin_print_styles', 'print_emoji_styles');
			remove_filter('the_content_feed', 'wp_staticize_emoji');
			remove_filter('comment_text_rss', 'wp_staticize_emoji');
			remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

			add_filter('tiny_mce_plugins', function ($plugins) {
				if (is_array($plugins)) {
					return array_diff($plugins, array('wpemoji'));
				} else {
					return array();
				}
			});

			add_filter('wp_resource_hints', function ($urls, $relation_type) {
				if ('dns-prefetch' === $relation_type) {
					/** This filter is documented in wp-includes/formatting.php */
					$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

					$urls = array_diff($urls, array($emoji_svg_url));
				}

				return $urls;
			}, 10, 2);
		}
	}

	protected function svg_dimensions($svg) {
		$svg = @simplexml_load_file($svg);
		$width = 0;
		$height = 0;

		if ($svg) {
			$attributes = $svg->attributes();

			if (
				isset($attributes->width, $attributes->height)
				&&
				is_numeric($attributes->width)
				&&
				is_numeric($attributes->height)
			) {
				$width = floatval($attributes->width);
				$height = floatval($attributes->height);
			} elseif (isset($attributes->viewBox)) {
				$sizes = explode(' ', $attributes->viewBox);

				if (isset($sizes[2], $sizes[3])) {
					$width = floatval($sizes[2]);
					$height = floatval($sizes[3]);
				}
			} else {
				return false;
			}
		}

		return array(
			'width' => $width,
			'height' => $height,
			'orientation' => ($width > $height) ? 'landscape' : 'portrait'
		);
	}
}
