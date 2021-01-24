<?php

if (! function_exists('blocksy_has_schema_org_markup')) {
	function blocksy_has_schema_org_markup() {
		return get_theme_mod('enable_schema_org_markup', 'yes') === 'yes';
	}
}

if (! function_exists('blocksy_schema_org_definitions')) {
	function blocksy_schema_org_definitions($place, $args = []) {
		$args = wp_parse_args(
			$args,
			[
				'array' => false
			]
		);

		$value = [];

		if (!blocksy_has_schema_org_markup()) {
			if ($args['array']) {
				return $value;
			}

			return blocksy_attr_to_html($value);
		}

		if ($place === 'single') {
			if ( is_page() ) {
				$value = [
					'itemscope' => 'itemscope',
					'itemtype' => 'http://schema.org/WebPage'
				];
			} else if (is_single()) {
				$value = [
					'itemscope' => 'itemscope',
					'itemtype' => 'https://schema.org/Blog'
				];
			}
		}

		if ($place === 'creative_work') {
			if (is_single()) {
				$value = [
					'itemscope' => 'itemscope',
					'itemtype' => 'https://schema.org/CreativeWork'
				];
			} else {
				if (is_home() || is_archive()) {
					$value = [
						'itemscope' => 'itemscope',
						'itemtype' => 'https://schema.org/CreativeWork'
					];
				}
			}
		}

		if ($place === 'header') {
			$value = [
				'itemscope' => '',
				'itemtype' => 'https://schema.org/WPHeader'
			];
		}

		if ($place === 'logo') {
			$value = [
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/Organization'
			];
		}

		// Navigation
		if ($place === 'navigation') {
			$value = [
				'itemscope' => '',
				'itemtype' => 'http://schema.org/SiteNavigationElement'
			];
		}

		// Main
		if ($place === 'blog') {
			// return '';
			// return 'itemtype="http://schema.org/Blog" itemscope';
		}

		if ($place === 'breadcrumb') {
			$value = [
				'itemscope' => '',
				'itemtype' => 'http://schema.org/BreadcrumbList'
			];
		}

		if ( $place === 'breadcrumb_list') {
			$value = [
				'itemprop' => 'itemListElement',
				'itemscope' => '',
				'itemtype' => 'http://schema.org/ListItem'
			];
		}

		if ($place === 'breadcrumb_itemprop') {
			$value = [
				'itemprop' => 'breadcrumb',
			];
		}

		if ($place === 'sidebar') {
			$value = [
				'itemtype' => 'https://schema.org/WPSideBar',
				'itemscope' => 'itemscope',
				'role' => 'complementary'
			];
		}

		if ($place === 'footer') {
			$value = [
				'itemscope' => '',
				'itemtype' => 'https://schema.org/WPFooter'
			];
		}

		if ($place === 'headline') {
			$value = [
				'itemprop' => 'headline'
			];
		}

		if ( $place === 'entry_content') {
			$value = [
				'itemprop' => 'text'
			];
		}

		if ($place === 'publish_date') {
			$value = [
				'itemprop' => 'datePublished'
			];
		}

		if ($place === 'modified_date') {
			$value = [
				'itemprop' => 'dateModified'
			];
		}

		if ($place === 'author_name') {
			$value = [
				'itemprop' => 'name'
			];
		}

		if ($place === 'author_link') {
			$value = [
				'itemprop' => 'author',
			];
		}

		if ($place === 'publisher') {
			$value = [
				'itemprop' => 'publisher'
			];
		}

		if ($place === 'item') {
			$value = [
				'itemprop' => 'item'
			];
		}

		if ($place === 'url') {
			$value = [
				'itemprop' => 'url'
			];
		}

		if ($place === 'name') {
			$value = [
				'itemprop' => 'name'
			];
		}

		if ($place === 'description') {
			$value = [
				'itemprop' => 'description'
			];
		}

		if ($place === 'position') {
			$value = [
				'itemprop' => 'position'
			];
		}

		if ($place === 'image') {
			$value = [
				'itemprop' => 'image'
			];
		}

		if ($place === 'breadcrumb_list') {
			$value = [
				'itemscope' => '',
				'itemtype' => "http://schema.org/BreadcrumbList"
			];
		}

		if ($place === 'breadcrumb_item') {
			$value = [
				'itemscope' => '',
				'itemprop' => "itemListElement",
				'itemtype' => "http://schema.org/ListItem"
			];
		}

		if ($args['array']) {
			return $value;
		}

		return blocksy_attr_to_html($value);
	}
}

