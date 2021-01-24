<?php

add_action(
	'woocommerce_before_template_part',
	function ($template_name, $template_path, $located, $args) {
		if ($template_name !== 'single-product/product-image.php') {
			return;
		}

		if (
			(is_product() || wp_doing_ajax())
			&&
			(
				blocksy_get_post_editor() === 'brizy'
				||
				blocksy_get_post_editor() === 'elementor'
			)
		) {
			return;
		}

		echo blocksy_render_view(dirname(__FILE__) . '/woo-gallery-template.php');

		ob_start();
	},
	4,
	4
);

add_action(
	'woocommerce_after_template_part',
	function ($template_name, $template_path, $located, $args) {
		if ($template_name !== 'single-product/product-image.php') {
			return;
		}

		if (
			(is_product() || wp_doing_ajax())
			&&
			(
				blocksy_get_post_editor() === 'brizy'
				||
				blocksy_get_post_editor() === 'elementor'
			)
		) {
			return;
		}

		ob_get_clean();
	},
	4,
	4
);

add_action(
	'wp_ajax_blocksy_get_product_view_for_variation',
	'blocksy_get_product_view_for_variation'
);

add_action(
	'wp_ajax_nopriv_blocksy_get_product_view_for_variation',
	'blocksy_get_product_view_for_variation'
);

function blocksy_get_product_view_for_variation() {
	$variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
	$variation = $variation_id ? wc_get_product($variation_id) : false;

	$product = wc_get_product($variation->get_parent_id());

	if (! $variation || ! $product) {
		wp_send_json_error();
	}

	$gallery_images = array_filter(explode(',', get_post_meta(
		$variation_id,
		'_wc_additional_variation_images',
		true
	)), 'wp_get_attachment_url');

	$variation_main_image = $variation->get_image_id();

	if (! empty($variation_main_image)) {
		array_unshift($gallery_images, $variation_main_image);
	}

	wp_send_json_success([
		'html' => blocksy_render_view(
			dirname(__FILE__) . '/woo-gallery-template.php',
			[
				'product' => $product,
				'gallery_images' => $gallery_images,
				'forced_single' => true,
				'current_variation' => $variation_id
			]
		)
	]);
}
