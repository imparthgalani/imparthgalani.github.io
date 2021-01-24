<?php

if (! function_exists('woocommerce_mini_cart')) {
    return '';
}

$has_only_item = false;
$has_only_cart = false;

if (isset($render_args['only_item'])) {
	$has_only_item = $render_args['only_item'];
}

if (isset($render_args['only_cart'])) {
	$has_only_cart = $render_args['only_cart'];
}

$svgs = apply_filters('blocksy:header:cart:icons', [
	'type-1' => '<svg viewBox="0 0 10 10"><path d="M10,8.9L9.6,1c0-0.6-0.4-1-1.1-1H1.4c-0.6,0-1,0.4-1,1L0,8.9l0,0C0,9.6,0.4,10,1,10h7.9C9.6,10,10,9.6,10,8.9L10,8.9zM8.9,9.1H1C0.9,9.1,0.9,9.1,0.9,9L1.2,1l0,0c0-0.1,0-0.1,0.1-0.1h7.2c0.1,0,0.1,0.1,0.1,0.1l0,0l0.4,7.9C9.1,9.1,9.1,9.1,8.9,9.1zM6.5,1.8C6.2,1.8,6.1,2,6.1,2.2v1.3c0,0.6-0.4,1.1-1.1,1.1c-0.6,0-1-0.5-1-1.1V2.2c0-0.2-0.2-0.5-0.5-0.5S3,1.9,3,2.2v1.3c0,1.1,0.9,1.9,1.9,1.9s1.9-0.8,1.9-1.9V2.2C6.9,2,6.8,1.8,6.5,1.8z"/></svg>',

	'type-2' => '<svg viewBox="0 0 10 10"><path d="M0.4,0.4C0.2,0.4,0,0.5,0,0.7s0.1,0.4,0.4,0.4l0,0h0.7c0.1,0,0.1,0.1,0.1,0.1l1.6,5.4C3,7.1,3.4,7.4,3.9,7.4H8c0.5,0,0.9-0.4,1.1-0.8L10,3.1c0.1-0.2-0.1-0.4-0.3-0.4H9.6H2.4L1.9,1.1l0,0C1.9,0.6,1.5,0.4,1.1,0.4H0.4zM4.1,8.1c-0.4,0-0.7,0.4-0.7,0.7s0.4,0.7,0.7,0.7s0.7-0.4,0.7-0.7S4.5,8.1,4.1,8.1zM7.8,8.1c-0.4,0-0.7,0.4-0.7,0.7s0.4,0.7,0.7,0.7c0.4,0,0.7-0.4,0.7-0.7S8.2,8.1,7.8,8.1z"/></svg>',

	'type-3' => '<svg viewBox="0 0 10 10"><path d="M3,0.7c-0.4,0-0.7,0.2-0.9,0.6L1.1,3.9H0.4c-0.1,0-0.3,0.1-0.4,0.2C0,4.1,0,4.3,0,4.4l1.1,4.2c0.1,0.4,0.5,0.6,0.9,0.6h5.9c0.4,0,0.8-0.3,0.9-0.6L10,4.4c0-0.1,0-0.3-0.1-0.4C9.9,3.9,9.7,3.9,9.6,3.9H8.9L7.8,1.2l0,0C7.6,0.9,7.4,0.7,7,0.7H3zM3,1.6h3.9l1,2.3H2.1L3,1.6z M3.2,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4C3,7.9,2.8,7.6,2.8,7.4V5.7C2.7,5.4,2.9,5.2,3.2,5.2zM5,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4c-0.3,0-0.4-0.2-0.4-0.4V5.7C4.6,5.4,4.7,5.2,5,5.2z M6.8,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4c-0.3,0-0.4-0.2-0.4-0.4V5.7C6.4,5.4,6.6,5.2,6.8,5.2z"/></svg>'
]);

$current_count = WC()->cart->get_cart_contents_count();

$class = 'ct-header-cart';

$class .= ' ' . blocksy_visibility_classes(
	blocksy_default_akg('header_cart_visibility', $atts, [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	])
);

$badge_output = '';

if (blocksy_default_akg('has_cart_badge', $atts, 'yes') !== 'yes') {
	$badge_output = 'data-skip-badge';
}

$has_cart_dropdown = blocksy_default_akg(
	'has_cart_dropdown',
	$atts,
	'yes'
) === 'yes';

$cart_drawer_type = blocksy_default_akg('cart_drawer_type', $atts, 'dropdown');

$subtotal_output = '';

if (is_customize_preview()) {
	$subtotal_output = 'data-subtotal="' . esc_attr(WC()->cart->get_cart_subtotal()) . '"';
}

$cart_total_class = 'ct-cart-total';

$cart_total_class .= ' ' . blocksy_visibility_classes(
	blocksy_default_akg('cart_subtotal_visibility', $atts, [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	])
);

$type = blocksy_default_akg('mini_cart_type', $atts, 'type-1');

if (empty($type)) {
	$type = 'type-1';
}

$item_class = 'ct-cart-item';

$url = wc_get_cart_url();

$auto_open_output = '';

if ($has_cart_dropdown && $cart_drawer_type === 'offcanvas') {
	$item_class .= ' ct-offcanvas-trigger';
	$url = '#woo-cart-panel';

	$auto_open_cart = blocksy_default_akg('auto_open_cart', $atts, [
		'archive' => false,
		'product' => false,
	]);

	$components = [];


	if ($auto_open_cart['archive']) {
		$components[] = 'archive';
	}

	if ($auto_open_cart['product']) {
		$components[] = 'product';
	}

	if (! empty($components)) {
		$auto_open_output = 'data-auto-open="' . implode(':', $components) . '"';
	}
}

ob_start();

?>

<a class="<?php echo $item_class ?>"
	href="<?php echo esc_attr($url) ?>"
	<?php echo wp_kses_post($badge_output) ?>
	data-count="<?php echo esc_attr($current_count) ?>"
	aria-label="<?php echo __('Cart', 'blocksy') ?>"
	<?php echo $auto_open_output ?>>

	<span class="ct-cart-label"><?php echo __('Cart', 'blocksy') ?></span>
	<span class="<?php echo $cart_total_class ?>">
		<?php echo WC()->cart->get_cart_subtotal(); ?>
	</span>

	<span class="ct-cart-icon">
		<?php
			/**
				* Note to code reviewers: This line doesn't need to be escaped.
				* The value used here escapes the value properly.
				* It contains an inline SVG, which is safe.
				*/
			echo $svgs[$type]
		?>
	</span>
</a>

<?php

$item = ob_get_clean();

if ($has_only_item) {
	echo $item;
	return;
}

if ($has_only_cart) {
	if ($has_cart_dropdown && $cart_drawer_type === 'dropdown') {
		ob_start();
		woocommerce_mini_cart();
		$content = ob_get_clean();

		echo blocksy_html_tag(
			'div',
			['class' => 'ct-cart-content'],
			$content
		);
	}
	return;
}

?>

<div
	class="<?php echo esc_attr($class) ?>"
	<?php echo wp_kses_post($subtotal_output) ?>
	<?php echo blocksy_attr_to_html($attr) ?>>

	<?php
		echo $item;

		if ($has_cart_dropdown && $cart_drawer_type === 'dropdown') {
			ob_start();
			woocommerce_mini_cart();
			$content = ob_get_clean();

			echo blocksy_html_tag(
				'div',
				['class' => 'ct-cart-content'],
				$content
			);
		}
	?>
</div>
