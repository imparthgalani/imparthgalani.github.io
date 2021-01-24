<?php

add_filter(
	'woocommerce_format_sale_price',
	function ($price, $regular_price, $sale_price) {
		return '<span class="sale-price">' . $price . '</span>';
	},
	10,
	3
);

add_action(
	'woocommerce_before_quantity_input_field',
	function () {
		if ((is_product() || wp_doing_ajax()) && blocksy_get_post_editor() === 'brizy') {
			return;
		}

		echo '<span class="ct-increase"></span>';
		echo '<span class="ct-decrease"></span>';
	}
);

add_action(
	'woocommerce_before_main_content',
	function () {
		$prefix = blocksy_manager()->screen->get_prefix();

		if ($prefix === 'woo_categories' || $prefix === 'search') {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_output_hero_section() used here escapes the value properly.
			 */
			echo blocksy_output_hero_section([
				'type' => 'type-2'
			]);
		}

		$attr = [
			'class' => 'ct-container'
		];

		if (blocksy_get_page_structure() === 'narrow') {
			$attr['class'] = 'ct-container-narrow';
		}

		if (is_product()) {
			$attr['data-structure'] = get_theme_mod(
				'product_content_style',
				'wide'
			);
		}

		if ($prefix === 'product') {
			echo blocksy_output_hero_section([
				'type' => 'type-2'
			]);
		}

		echo '<div ' . blocksy_attr_to_html($attr) . ' ' . wp_kses(blocksy_sidebar_position_attr(), []) . ' ' . blocksy_get_v_spacing() . '>';
		echo '<section>';

		if (
			$prefix === 'woo_categories'
			||
			$prefix === 'search'
			||
			$prefix === 'product'
		) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_output_hero_section() used here escapes the value properly.
			 */
			echo blocksy_output_hero_section([
				'type' => 'type-1'
			]);

		}
	}
);

add_action(
	'woocommerce_after_main_content',
	function () {
		echo '</section>';
		get_sidebar();
		echo '</div>';
	}
);

