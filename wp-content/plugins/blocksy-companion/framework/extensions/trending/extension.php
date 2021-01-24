<?php

require_once dirname(__FILE__) . '/helpers.php';

class BlocksyExtensionTrending {
	public function __construct() {
		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			wp_enqueue_script(
				'blocksy-ext-trending-scripts',
				BLOCKSY_URL . 'framework/extensions/trending/static/bundle/main.js',
				['ct-events'],
				$data['Version'],
				true
			);
		});

		add_filter(
			'blocksy_extensions_customizer_options',
			function ($opts) {
				$opts['trending_posts_ext'] = blc_call_fn(
					[
						'fn' => 'blocksy_get_options',
						'default' => 'array'
					],
					dirname( __FILE__ ) . '/customizer.php',
					[], false
				);

				return $opts;
			}
		);

		add_action(
			'blocksy:template:after',
			function () {
				echo blc_get_trending_block();
			}
		);

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-trending-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/trending/static/bundle/sync.js',
					['customize-preview', 'ct-events', 'ct-customizer'],
					$data['Version'],
					true
				);
			}
		);

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname( __FILE__ ) . '/global.php',
				'chunk' => 'global'
			], $args));
		}, 10, 3);
	}
}
