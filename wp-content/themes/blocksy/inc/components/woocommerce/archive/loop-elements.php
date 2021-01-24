<?php

add_action(
	'wp',
	function () {
		if (get_theme_mod('has_shop_sort', 'yes') !== 'yes') {
			remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
		}

		if (get_theme_mod('has_shop_results_count', 'yes') !== 'yes') {
			remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		}

		if (is_customize_preview()) {
			blocksy_add_customizer_preview_cache(
				blocksy_html_tag(
					'div',
					['data-id' => 'shop-sort'],
					blocksy_collect_and_return(function () {
						woocommerce_catalog_ordering();
					})
				)
			);

			blocksy_add_customizer_preview_cache(
				blocksy_html_tag(
					'div',
					['data-id' => 'shop-results-count'],
					blocksy_collect_and_return(function () {
						woocommerce_result_count();
					})
				)
			);
		}
	},
	5
);

