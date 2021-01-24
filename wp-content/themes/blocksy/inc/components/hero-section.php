<?php

if (! function_exists('blocksy_is_page_title_default')) {
	function blocksy_is_page_title_default() {
		if (blocksy_is_page() || is_single()) {
			$post_options = blocksy_get_post_options();

			$mode = blocksy_akg('has_hero_section', $post_options, 'default');

			if ($mode !== 'default') {
				return false;
			}
		}

		return true;
	}
}

if (! function_exists('blocksy_get_page_title_source')) {
	function blocksy_get_page_title_source() {
		static $result = null;

		if (! is_null($result)) {
			if (! is_customize_preview()) {
				return $result;
			}
		}

		$prefix = blocksy_manager()->screen->get_prefix();

		if ($prefix === 'ct_content_block_single') {
			$result = false;
			return $result;
		}

		if (strpos($prefix, 'single') !== false || (
			function_exists('is_shop') && is_shop()
		) && ! is_search()) {
			$post_options = blocksy_get_post_options();

			$mode = blocksy_akg('has_hero_section', $post_options, 'default');

			if ($mode === 'disabled') {
				$result = false;
				return $result;
			}

			if ($mode === 'enabled')  {
				$result = [
					'strategy' => $post_options
				];
				return $result;
			}
		}

		$default_value = 'yes';

		if ($prefix === 'blog') {
			$default_value = 'no';
		}

		if (get_theme_mod($prefix . '_hero_enabled', $default_value) === 'no') {
			$result = false;
			return $result;
		}

		$result = [
			'strategy' => 'customizer',
			'prefix' => $prefix
		];

		return $result;
	}
}

if (! function_exists('blocksy_first_level_deep_link')) {
	function blocksy_first_level_deep_link($prefix) {
		if ($prefix === 'blog') {
			return 'blog_posts';
		}

		if ($prefix === 'author') {
			return 'author_page';
		}

		if ($prefix === 'search') {
			return 'search_page';
		}

		if ($prefix === 'woo_categories') {
			return 'woocomerrce_posts_archives';
		}

		if ($prefix === 'categories') {
			return 'archive_blog_posts_categories';
		}

		if ($prefix === 'single_page') {
			return 'single_pages';
		}

		if ($prefix === 'single_blog_post') {
			return 'single_blog_posts';
		}

		if ($prefix === 'product') {
			return 'woocomerrce_single';
		}

		return null;
	}
}

if (! function_exists('blocksy_hero_get_deep_link')) {
	function blocksy_hero_get_deep_link($source) {
		if (! $source) {
			return null;
		}

		if (! isset($source['prefix'])) {
			return null;
		}

		$first_level = blocksy_first_level_deep_link($source['prefix']);

		if (! $first_level) {
			return null;
		}

		return $first_level . ':' . $source['prefix'] . '_hero_enabled';
	}
}

if (! function_exists('blocksy_output_hero_section')) {
	function blocksy_output_hero_section($args = []) {
		$args = wp_parse_args($args, [
			'type' => 'type-1',
			'source' => false,
			'elements' => null
		]);

		$type = $args['type'];

		if (! blocksy_get_page_title_source()) {
			return '';
		}

		$default_type = 'type-1';

		if (
			blocksy_get_page_title_source()['strategy'] === 'customizer'
			&& (
				blocksy_get_page_title_source()['prefix'] === 'woo_categories'
				||
				blocksy_get_page_title_source()['prefix'] === 'author'
			)
		) {
			$default_type = 'type-2';
		}

		$actual_type = blocksy_akg_or_customizer(
			'hero_section',
			blocksy_get_page_title_source(),
			$default_type
		);

		if (! $type) {
			$type = $actual_type;
		}

		if ($type !== $actual_type) {
			return '';
		}

		$elements = $args['elements'];

		if (! $elements) {
			$elements = blocksy_render_view(
				dirname(__FILE__) . '/hero/elements.php',
				[
					'type' => $type
				]
			);
		}

		if ($type !== 'type-1' && $type !== 'type-2') {
			return '';
		}

		ob_start();

		do_action('blocksy:hero:before');

		$attr = [
			'class' => 'hero-section',
			'data-type' => $type
		];

		if (
			is_customize_preview()
			&&
			blocksy_is_page_title_default()
			&&
			blocksy_hero_get_deep_link(blocksy_get_page_title_source())
		) {
			$attr['data-shortcut'] = 'border';
			$attr['data-location'] = blocksy_hero_get_deep_link(blocksy_get_page_title_source());
		}

		echo blocksy_render_view(
			dirname(__FILE__) . '/hero/' . $type . '.php',
			[
				'type' => $type,
				'elements' => $elements,
				'attr' => $attr
			]
		);

		do_action('blocksy:hero:after');

		return ob_get_clean();
	}
}

