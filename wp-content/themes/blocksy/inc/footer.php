<?php

add_action('wp_footer', function () {
	$default_footer_elements = [];

	if (function_exists('blocksy_woo_floating_cart')) {
		$default_footer_elements[] = blocksy_woo_floating_cart();
	}

	if (get_theme_mod('has_back_top', 'no') === 'yes') {
		ob_start();
		blocksy_output_back_to_top_link();
		$default_footer_elements[] = ob_get_clean();
	}

	$elements = new Blocksy_Header_Builder_Elements();

	ob_start();
	$elements->render_search_modal();
	$default_footer_elements[] = ob_get_clean();

	$default_footer_elements[] = $elements->render_cart_offcanvas();
	$default_footer_elements[] = $elements->render_offcanvas();

	$footer_elements = apply_filters(
		'blocksy:footer:offcanvas-drawer',
		$default_footer_elements
	);

	if (! empty($footer_elements)) {
		echo '<div class="ct-drawer-canvas">';

		foreach ($footer_elements as $footer_el) {
			echo $footer_el;
		}

		echo '</div>';
	}

	if (is_customize_preview()) {
		blocksy_add_customizer_preview_cache(
			function () {
				return blocksy_html_tag(
					'div',
					['data-id' => 'socials-general-cache'],
					'<section>' . blocksy_social_icons(null, [
						'type' => 'simple-small'
					]) . '</section>'
				);
			}
		);
	}

	if (is_customize_preview()) {
		blocksy_add_customizer_preview_cache(function () {
			return blocksy_html_tag(
				'div',
				['data-id' => 'back-to-top-link'],
				blocksy_collect_and_return(function () {
					blocksy_output_back_to_top_link(true);
				})
			);
		});
	}

});

