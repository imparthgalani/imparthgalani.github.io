<?php


add_filter(
	'do_shortcode_tag',
	function ($output, $tag, $attr, $m) {
		if ($tag === 'woocommerce_my_account') {
			return str_replace(
				'class="woocommerce"',
				'class="woocommerce ' . (is_user_logged_in() ? 'ct-woo-account' : 'ct-woo-unauthorized') . '"',
				$output
			);
		}

		return $output;
	},
	9999,
	4
);
