<?php

add_action('wp', function () {
	if (! get_theme_mod('blocksy_has_checkout_coupon', false)) {
		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
	}
});

