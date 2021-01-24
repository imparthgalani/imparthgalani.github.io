<?php

if (! function_exists('blocksy_output_back_to_top_link')) {
function blocksy_output_back_to_top_link($for_preview = false) {
	$type = get_theme_mod('top_button_type', 'type-1');
	$shape = get_theme_mod('top_button_shape', 'square');
	$alignment = get_theme_mod('top_button_alignment', 'right');

	$svgs = [
		'type-1' => '<svg width="12" height="12" viewBox="0 0 20 20"><path d="M10,0L9.4,0.6L0.8,9.1l1.2,1.2l7.1-7.1V20h1.7V3.3l7.1,7.1l1.2-1.2l-8.5-8.5L10,0z"/></svg>',

		'type-2' => '<svg width="12" height="12" viewBox="0 0 20 20"><path d="M18.1,9.4c-0.2,0.4-0.5,0.6-0.9,0.6h-3.7c0,0-0.6,8.7-0.9,9.1C12.2,19.6,11.1,20,10,20c-1,0-2.3-0.3-2.7-0.9C7,18.7,6.5,10,6.5,10H2.8c-0.4,0-0.7-0.2-1-0.6C1.7,9,1.7,8.6,1.9,8.3c2.8-4.1,7.2-8,7.4-8.1C9.5,0.1,9.8,0,10,0s0.5,0.1,0.6,0.2c0.2,0.1,4.6,3.9,7.4,8.1C18.2,8.7,18.3,9.1,18.1,9.4z"/></svg>',

		'type-3' => '<svg width="15" height="15" viewBox="0 0 20 20"><path d="M10,0c0,0-4.4,3-4.4,9.6c0,0.1,0,0.2,0,0.4c-0.8,0.6-2.2,1.9-2.2,3c0,1.3,1.3,4,1.3,4L7.1,14l0.7,1.6h4.4l0.7-1.6l2.4,3.1c0,0,1.3-2.7,1.3-4c0-1.1-1.5-2.4-2.2-3c0-0.1,0-0.2,0-0.4C14.4,3,10,0,10,0zM10,5.2c0.8,0,1.5,0.7,1.5,1.5S10.8,8.1,10,8.1S8.5,7.5,8.5,6.7S9.2,5.2,10,5.2z M8.1,16.3c-0.2,0.2-0.3,0.5-0.3,0.8C7.8,18.5,10,20,10,20s2.2-1.4,2.2-2.9c0-0.3-0.1-0.6-0.3-0.8h-0.6c0,0.1,0,0.1,0,0.2c0,1-1.3,1.5-1.3,1.5s-1.3-0.5-1.3-1.5c0-0.1,0-0.1,0-0.2H8.1z"/></svg>',
	];

	$class = 'ct-back-to-top';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('back_top_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]));

	?>

	<a href="#" class="<?php echo esc_attr($class) ?>"
		data-shape="<?php echo esc_attr($shape) ?>"
		data-alignment="<?php echo esc_attr($alignment) ?>"
		title="<?php echo esc_attr__('Go to top', 'blocksy') ?>" aria-label="<?php echo esc_attr__('Go to top', 'blocksy') ?>">

		<?php
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * It can't be escaped with wp_kses_post() because it contains an SVG and is perfectly safe.
			 */
			echo $svgs[$type]
		?>

		<?php

			if ($for_preview) {
				foreach ($svgs as $key => $value) {
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Function blocksy_html_tag() used here escapes the value properly.
					 * It's mainly not escaped with wp_kses_post() because it contains an SVG.
					 */
					echo blocksy_html_tag(
						'div',
						['data-top' => $key],
						$value
					);
				}
			}

		?>

	</a>

	<?php
}
}
