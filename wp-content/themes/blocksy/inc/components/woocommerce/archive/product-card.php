<?php

function blocksy_get_product_card_categories() {
	if (
		get_theme_mod('has_product_categories', 'no') === 'yes'
	) {
		return blocksy_post_meta([
			[
				'id' => 'categories',
				'enabled' => true
			]
		], [
			'attr' => get_theme_mod(
				'has_product_categories', 'no'
			) !== 'yes' ? ['data-customize-hide' => ''] : []
		]);
	}

	return '';
}

$action_to_hook = 'wp';

if (wp_doing_ajax()) {
	$action_to_hook = 'init';
}

add_action($action_to_hook, function () {
	if (! get_option('woocommerce_thumbnail_cropping', null)) {
		update_option('woocommerce_thumbnail_cropping', 'predefined');
		update_option('woocommerce_thumbnail_cropping_custom_width', 3);
		update_option('woocommerce_thumbnail_cropping_custom_height', 4);
	}

	$products_layout = blocksy_get_products_listing_layout();

	if (
		get_theme_mod('has_star_rating', 'yes') !== 'yes'
		&&
		!is_product()
	) {
		add_filter(
			'woocommerce_product_get_rating_html',
			function ($html) {
				return str_replace(
					'class="star-rating"',
					'class="star-rating" data-customize-hide',
					$html
				);
			}
		);
	}

	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

	if ($products_layout !== 'type-1') {
		// Products cards
		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

		// Category cards
		remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail');
	}

	// Cards type 1
	if ($products_layout === 'type-1') {
		// Products cards
		remove_action(
			'woocommerce_before_shop_loop_item_title',
			'woocommerce_template_loop_product_thumbnail'
		);


		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

		add_action('woocommerce_before_shop_loop_item_title', function () {

			global $product;

			if ($product->is_in_stock()) {
				if (get_theme_mod('has_sale_badge', 'yes') === 'yes') {
					woocommerce_show_product_loop_sale_flash();
				}
			} else {
				echo '<span class="out-of-stock-badge">' . __('Out of stock', 'blocksy') . '</span>';
			}
		});

		if (get_theme_mod('has_star_rating', 'yes') === 'yes') {
			add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 20);
		}

		add_action(
			'woocommerce_before_shop_loop_item_title',
			function () {
				global $product;

				$gallery_images = $product->get_gallery_image_ids();
				$hover_value = get_theme_mod('product_image_hover', 'none');

				echo blocksy_image([
					'no_image_type' => 'woo',
					'attachment_id' => $product->get_image_id(),
					'other_images' => count($gallery_images) > 0 && $hover_value === 'swap' ? [
						$gallery_images[0]
					] : [],
					'size' => 'woocommerce_thumbnail',
					'ratio' => blocksy_get_woocommerce_ratio(),
					'tag_name' => 'span'
				]);
			}
		);

		add_action(
			'woocommerce_after_shop_loop_item',
			function () {
				echo blocksy_get_product_card_categories();
				echo '<div class="ct-woo-card-actions">';
			},
			6
		);

		add_action(
			'woocommerce_after_shop_loop_item',
			function () {
				echo '</div>';

				if (function_exists('blocksy_output_quick_view_link')) {
					echo blocksy_output_quick_view_link();
				}

				if (function_exists('blocksy_output_add_to_wish_list')) {
					echo blocksy_output_add_to_wish_list();
				}
			},
			20
		);

		// Categories cards
		remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail');

		add_action(
			'woocommerce_before_subcategory_title',
			function ($category) {
				$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );

				echo blocksy_image([
					'attachment_id' => $thumbnail_id,
					'size' => 'woocommerce_thumbnail',
					'ratio' => blocksy_get_woocommerce_ratio(),
					'tag_name' => 'span'
				]);
			}
		);
	}

	// Cards type 2
	if ($products_layout === 'type-2') {
		add_action(
			'woocommerce_before_shop_loop_item',
			function () {
				global $product;

				echo '<figure>';

				if ($product->is_in_stock()) {
					woocommerce_show_product_loop_sale_flash();
				} else {
					echo '<span class="out-of-stock-badge">' . __('Out of stock', 'blocksy') . '</span>';
				}

				if (function_exists('blocksy_output_quick_view_link')) {
					echo blocksy_output_quick_view_link();
				}

				if (function_exists('blocksy_output_add_to_wish_list')) {
					echo blocksy_output_add_to_wish_list();
				}

				$gallery_images = $product->get_gallery_image_ids();
				$hover_value = get_theme_mod('product_image_hover', 'none');

				echo blocksy_image([
					'attachment_id' => $product->get_image_id(),
					'other_images' => count($gallery_images) > 0 && $hover_value === 'swap' ? [
						$gallery_images[0]
					] : [],
					'size' => 'woocommerce_thumbnail',
					'ratio' => blocksy_get_woocommerce_ratio(),
					'tag_name' => 'a',
					'html_atts' => [
						'href' => apply_filters(
							'woocommerce_loop_product_link',
							get_permalink($product->get_id()),
							$product
						)
					]
				]);

				echo '</figure>';

				do_action('blocksy:woocommerce:product-card:title:before');

				woocommerce_template_loop_product_link_open();
				woocommerce_template_loop_product_title();
				woocommerce_template_loop_product_link_close();

				do_action('blocksy:woocommerce:product-card:title:after');

				echo blocksy_get_product_card_categories();

				if (
					get_theme_mod('has_star_rating', 'yes') === 'yes'
				) {
					woocommerce_template_loop_rating();
				}

				echo '<div class="ct-woo-card-actions">';

				woocommerce_template_loop_price();
				woocommerce_template_loop_add_to_cart();

				echo '</div>';
			}
		);

		add_action(
			'woocommerce_before_subcategory',
			function ($category) {
				$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);

				echo '<figure>';

				echo blocksy_image([
					'attachment_id' => $thumbnail_id,
					'size' => 'woocommerce_thumbnail',
					'ratio' => blocksy_get_woocommerce_ratio(),
					'tag_name' => 'a',
					'html_atts' => [
						'href' => get_term_link($category, 'product_cat')
					]
				]);

				echo '</figure>';
			},
			5
		);
	}
});

