<?php

if (! function_exists('blocksy_flexy')) {
function blocksy_flexy($args = []) {
	$args = wp_parse_args($args, [
		'prefix' => '',

		'items' => '',
		'images' => null,
		'images_ratio' => '3/4',

		'pills_images' => null,

		'pills_count' => 0,

		'first_item_class' => '',
		'items_container_class' => '',
		'class' => '',

		'size' => 'medium',
		'href' => null,

		'has_pills' => true,

		'enable' => true
	]);

	$prefix = $args['prefix'];

	if (! empty($args['prefix'])) {
		$prefix .= '_';
	}

	$has_scale_rotate = false;

	if ($args['images']) {
		$args['pills_count'] = count($args['images']);
		$args['items'] = '';

		foreach ($args['images'] as $index => $single_image) {
			$attachment_id = is_array($single_image) ? $single_image['attachment_id'] : $single_image;

			if ($has_scale_rotate) {
				$args['items'] .= '<div>';
			}

			$single_item_href = $args['href'];
			$width = null;
			$height = null;

			if (! $single_item_href) {
				$single_item_href = wp_get_attachment_image_src(
					$attachment_id,
					'full'
				);

				if ($single_item_href) {
					$width = $single_item_href[1];
					$height = $single_item_href[2];

					$single_item_href = $single_item_href[0];
				}
			}

			$class = '';

			if ($index === 0 && $args['first_item_class']) {
				$class = $args['first_item_class'];
			}

			if (! empty($class)) {
				$class = 'class="' . $class . '"';
			}

			$args['items'] .= '<div ' . $class . '>' . blocksy_image([
				'no_image_type' => 'woo',
				'attachment_id' => $attachment_id,
				'ratio' => $args['images_ratio'],
				'tag_name' => 'a',
				'size' => $args['size'],
				'html_atts' => array_merge([
					'href' => $single_item_href
				], $width ? [
					'data-width' => $width,
					'data-height' => $height
				] : []),
			]) .'</div>';

			if ($has_scale_rotate) {
				$args['items'] .= '</div>';
			}
		}
	}

	if ($args['enable']) {
		$initial_value = 'no';

		if ($has_scale_rotate) {
			$initial_value = 'no:scalerotate';
		}

		$args['container_attr']['data-flexy'] = $initial_value;
	}

	// Slider view
	// boxed | full
	$slider_view = 'boxed';

	$container_attr = '';

	foreach ($args['container_attr'] as $key => $value) {
		$container_attr .= ' ' . $key . '="' . $value . '"';
	}

	$container_attr = trim($container_attr);

	$dynamic_height_output = '';

	if ($args['images_ratio'] === 'original' || is_customize_preview()) {
		$dynamic_height_output = 'data-height="dynamic"';
	}

	$class = trim('flexy-container ' . $args['class']);

	?>

	<div
		class="<?php echo $class ?>"
		<?php echo $container_attr ?>>

		<div class="flexy">
			<div class="flexy-view" data-flexy-view="<?php echo $slider_view ?>">
				<div
					class="flexy-items <?php echo $args['items_container_class'] ?>"
					<?php echo $dynamic_height_output ?>>
					<?php echo $args['items']; ?>
				</div>
			</div>
		</div>

		<?php
			if ($args['has_pills']) {
				blocksy_flexy_pills($args['pills_count'], $args['pills_images']);
			}
		?>
	</div>
	<?php
}
}

if (! function_exists('blocksy_flexy_pills')) {
function blocksy_flexy_pills($number_of_sliders, $pills_images = null) {
	if ($number_of_sliders === 0) return;

	$type = $pills_images ? 'thumbs' : 'circle';

	?>

	<nav class="flexy-pills" data-type="<?php echo $type ?>">
		<?php foreach (range(1, ceil($number_of_sliders)) as $index) { ?>
		<?php
			if ($pills_images) {
				$image_output = blocksy_image([
					'attachment_id' => $pills_images[$index - 1],
					'ratio' => '1/1',
					'tag_name' => 'a',
					'size' => "woocommerce_thumbnail",
					'class' => intval($index) === 1 ? 'active' : '',
					'html_atts' => [
						'href' => '#',
					],
				]);

				echo $image_output;
			} else {
				?>

				<a href="#" <?php if (intval($index) === 1) echo ' class="active"' ?>>
					<span hidden>
						<?php
							// translators: %s is the number of the slide
							echo sprintf(__('Slide %s', 'blocksy'), $index);
						?>
					</span>
				</a>

				<?php
			}
		} ?>
	</nav>

    <?php
}
}
