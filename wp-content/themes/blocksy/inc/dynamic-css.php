<?php
/**
 * Dynamic CSS helpers
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

class Blocksy_Dynamic_Css {
	public function __construct() {
		add_action(
			'wp_print_styles',
			[$this, 'load_frontend_css'],
			9999
		);

		add_filter(
			'customize_render_partials_response',
			function ($response, $obj, $partials) {
				$joined_keys = implode('', array_keys($partials));

				$css_output = blocksy_get_all_dynamic_styles_for([
					'context' => 'inline'
				]);

				$css = $css_output['css'];
				$tablet_css = $css_output['tablet_css'];
				$mobile_css = $css_output['mobile_css'];

				$response['ct_dynamic_css'] = [
					'desktop' => $css->build_css_structure(),
					'tablet' => $tablet_css->build_css_structure(),
					'mobile' => $mobile_css->build_css_structure()
				];

				return $response;
			},
			10, 3
		);

		/*
		add_action(
			'customize_controls_print_scripts',
			[$this, 'load_backend_dynamic_css']
		);
		 */

		add_action('wp_print_scripts', function () {
			if (! is_admin()) {
				return;
			}

			$this->load_backend_dynamic_css();
		});
	}

	public function load_frontend_css() {
		$css_output = blocksy_get_all_dynamic_styles_for([
			'context' => 'inline'
		]);

		$css = $css_output['css'];
		$tablet_css = $css_output['tablet_css'];
		$mobile_css = $css_output['mobile_css'];

		$no_script_url = get_template_directory_uri() . '/static/bundle/no-scripts.css';

		echo "<noscript><link rel='stylesheet' href='" . $no_script_url . "' type='text/css' /></noscript>\n";

		$all_global_css = trim($css->build_css_structure());

		if (! empty($all_global_css)) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-inline-css">';
			echo $all_global_css;
			echo "</style>\n";
		}

		$tablet_css = trim($tablet_css->build_css_structure());
		$mobile_css = trim($mobile_css->build_css_structure());

		if (! empty(trim($tablet_css))) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-tablet-inline-css" media="(max-width: 999.98px)">';
			echo $tablet_css;
			echo "</style>\n";
		}

		if (! empty(trim($mobile_css))) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-mobile-inline-css" media="(max-width: 689.98px)">';
			echo $mobile_css;
			echo "</style>\n";
		}
	}

	public function load_backend_dynamic_css() {
		$css = new Blocksy_Css_Injector();
		$tablet_css = new Blocksy_Css_Injector();
		$mobile_css = new Blocksy_Css_Injector();

		do_action(
			'blocksy:admin-dynamic-css:enqueue',
			[
				'context' => 'inline',
				'css' => $css,
				'tablet_css' => $tablet_css,
				'mobile_css' => $mobile_css
			]
		);

		blocksy_theme_get_dynamic_styles([
			'name' => 'admin-global',
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'context' => 'inline',
			'chunk' => 'admin'
		]);

		$all_global_css = trim($css->build_css_structure());

		if (! empty($all_global_css)) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-inline-css">';
			echo $all_global_css;
			echo "</style>\n";
		}
	}
}

if (! function_exists('blocksy_has_css_in_files')) {
	function blocksy_has_css_in_files() {
		return apply_filters('blocksy:dynamic-css:has_files_cache', false);
	}
}

if (! function_exists('blocksy_get_all_dynamic_styles_for')) {
	function blocksy_get_all_dynamic_styles_for($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
			]
		);

		$css = new Blocksy_Css_Injector();
		$mobile_css = new Blocksy_Css_Injector();
		$tablet_css = new Blocksy_Css_Injector();

		blocksy_theme_get_dynamic_styles([
			'name' => 'global',
			'css' => $css,
			'mobile_css' => $mobile_css,
			'tablet_css' => $tablet_css,
			'context' => $args['context'],
			'chunk' => 'global',
			'forced_call' => true
		]);

		do_action(
			'blocksy:global-dynamic-css:enqueue',
			[
				'context' => $args['context'],
				'css' => $css,
				'tablet_css' => $tablet_css,
				'mobile_css' => $mobile_css
			]
		);

		return [
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css
		];
	}
}

if (! function_exists('blocksy_get_dynamic_css_file_content')) {
	function blocksy_get_dynamic_css_file_content($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
			]
		);

		$css_output = blocksy_get_all_dynamic_styles_for([
			'context' => $args['context']
		]);

		$css = $css_output['css'];
		$tablet_css = $css_output['tablet_css'];
		$mobile_css = $css_output['mobile_css'];

		// $content = "/* Desktop CSS */";
		$content = '';
		$content .= trim($css->build_css_structure());

		// $content .= "\n\n/* Tablet CSS */\n";
		$content .= "@media (max-width: 999.98px) {";
		$content .= "  " . trim($tablet_css->build_css_structure());
		$content .= "}";

		// $content .= "\n\n/* Mobile CSS */\n";
		$content .= "@media (max-width: 689.98px) {";
		$content .= trim($mobile_css->build_css_structure());
		$content .= "}";

		return $content;
	}
}

if (! function_exists('blocksy_dynamic_styles_should_call')) {
	function blocksy_dynamic_styles_should_call($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
				'chunk' => null,
				'forced_call' => false
			]
		);

		if (! $args['context']) {
			throw new Error('$context not provided. This is required!');
		}

		if (! $args['chunk']) {
			throw new Error('$chunk not provided. This is required!');
		}

		if (!$args['forced_call'] && blocksy_has_css_in_files()) {
			if ($args['context'] === 'inline') {
				if ($args['chunk'] === 'global' || $args['chunk'] === 'woocommerce') {
					return false;
				}
			}

			if ($args['context'] === 'files:global') {
				if ($args['chunk'] === 'woocommerce') {
					if (! class_exists('WooCommerce')) {
						return false;
					}
				} else {
					if ($args['chunk'] !== 'global') {
						return false;
					}
				}
			}
		}

		return true;
	}
}

/**
 * Evaluate a file with dynamic styles.
 *
 * @param string $name Name of dynamic CSS file.
 * @param array $variables list of data to pass in file.
 * @throws Error When $css not provided.
 */
if (! function_exists('blocksy_theme_get_dynamic_styles')) {
	function blocksy_theme_get_dynamic_styles($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'path' => null,
				'name' => '',
				'css' => null,

				'context' => null,
				'chunk' => null,
				'forced_call' => false,
				'prefixes' => null
			]
		);

		if (! isset($args['css'])) {
			throw new Error('$css instance not provided. This is required!');
		}

		if (! blocksy_dynamic_styles_should_call($args)) {
			return;
		}

		if (! $args['path']) {
			$args['path'] = get_template_directory() . '/inc/dynamic-styles/' . $args['name'] . '.php';
		}

		if (! $args['prefixes']) {
			blocksy_get_variables_from_file($args['path'], [], $args);
		} else {
			foreach ($args['prefixes'] as $prefix) {
				blocksy_get_variables_from_file(
					$args['path'],
					[],
					array_merge($args, [
						'prefix' => $prefix
					])
				);
			}
		}
	}
}

