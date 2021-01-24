<?php

$atts = blocksy_get_post_options(null, [
	'meta_id' => 'blocksy_product_review_options'
]);

$gallery_images = array_map(function ($item) {
	return $item['attachment_id'];
}, blocksy_akg('gallery', $atts, []));

$thumb_id = get_post_thumbnail_id();

if ($thumb_id) {
	array_unshift($gallery_images, intval($thumb_id));
} else {
	$gallery_images = [];
}

echo '<section class="ct-product-hero">';
echo '<div class="ct-container">';
if (count($gallery_images) === 1) {
	$attachment_id = $gallery_images[0];

	$image_href = wp_get_attachment_image_src(
		$attachment_id,
		'full'
	);

	$width = null;
	$height = null;

	if ($image_href) {
		$width = $image_href[1];
		$height = $image_href[2];

		$image_href = $image_href[0];
	}

	echo blocksy_image([
		'attachment_id' => $gallery_images[0],
		'size' => 'full',
		'ratio' => '2/1',
		'tag_name' => 'a',
		'html_atts' => array_merge([
			'href' => $image_href
		], $width ? [
			'data-width' => $width,
			'data-height' => $height
		] : []),
	]);
}

if (count($gallery_images) > 1) {
	$args = [
		'images' => $gallery_images,
		'size' => 'full',
		'images_ratio' => '2/1'
	];

	if (count($gallery_images) <= 5) {
		$args['pills_images'] = $gallery_images;
	} else {
		$args['has_pills'] = false;
	}

	echo blocksy_flexy($args);

	if (count($gallery_images) > 5) {
		echo blocksy_flexy([
			'images' => $gallery_images,
			'size' => 'thumb',
			'has_pills' => false,
			'images_ratio' => '1/1',
			'class' => 'flexy-draggable-pills',
			'first_item_class' => 'active'
		]);
	}
}

echo blocksy_output_hero_section([
	'type' => 'type-1'
]);

$scores = blocksy_akg('scores', $atts, []);

if (! empty($scores)) {
	echo '<div class="ct-product-scores">';

	echo '<ul>';

	foreach ($scores as $single_score) {
		echo '<li>';
		echo '<span>' . $single_score['label'] . '</span>';

		echo '<div class="star-rating" role="img">';
		$width = ( ( intval($single_score['score']) / 5 ) * 100 );

		echo '<span style="width: ' . $width . '%;">Rated <strong class="rating">3</strong> out of 5</span>';
		echo '</div>';
		echo '</li>';
	}

	echo '</ul>';

	echo '<div class="ct-overall-score">';

	$avg_score = round(array_reduce($scores, function ($carry, $score) {
		return $carry + intval($score['score']);
	}, 0) / count($scores) * 2) / 2;

	echo '<span class="ct-average-score">' . $avg_score . '/5</span>';

	echo '<div class="star-rating" role="img">';
	$width = ( ( $avg_score / 5 ) * 100 );
	echo '<span style="width: ' . $width . '%;"></span>';
	echo '</div>';

	echo '<span class="ct-score-label">';
	echo __('Overall Score', 'blc');
	echo '</span>';
	echo '</div>';

	echo '</div>';
}

echo '<div class="ct-product-actions">';

$product_link = blocksy_akg('product_link', $atts, '#');
$product_button_label = blocksy_akg(
	'product_button_label',
	$atts,
	__('Buy Now', 'blc')
);

$product_read_content_button_label = blocksy_akg(
	'product_read_content_button_label',
	$atts,
	__('Read More', 'blc')
);

if (! empty($product_button_label)) {
	echo '<a href="#post-' . get_the_ID() . '" class="ct-button">';
	echo $product_read_content_button_label;

	/*
	echo blc_get_icon([
		'icon_descriptor' => blocksy_akg('product_read_content_button_icon', $atts, [
			'icon' => 'fas fa-arrow-down'
		]),
	]);
	 */

	echo '</a>';
}

if (! empty($product_button_label) && ! empty($product_link)) {
	echo '<a href="' . esc_url($product_link) . '" class="ct-button">';
	echo $product_button_label;

	/*
	echo blc_get_icon([
		'icon_descriptor' => blocksy_akg('product_button_icon', $atts, [
			'icon' => 'fas fa-cart-arrow-down'
		]),
	]);
	 */

	echo '</a>';
}

echo '</div>';

$product_specs = blocksy_akg('product_specs', $atts, []);
$product_pros = blocksy_akg('product_pros', $atts, []);
$product_cons = blocksy_akg('product_cons', $atts, []);
$product_description = blocksy_akg('product_description', $atts, '');

if (! empty($product_description)) {
	echo '<div class="ct-product-description">';

	echo '<div class="entry-content">';
	echo do_shortcode($product_description);
	echo '</div>';

	echo '</div>';
}

if (
	! empty($product_specs)
	||
	! empty($product_pros)
	||
	! empty($product_cons)
) {
	echo '<div class="ct-product-info">';

	if (! empty($product_specs)) {
		echo '<div class="ct-specs">';
		echo '<h5>' . __('Specs', 'blc') . '</h5>';

		echo '<ul>';

		foreach ($product_specs as $single_spec) {
			echo '<li>';
			echo '<b>' . blocksy_akg('label', $single_spec, '') . ': </b>';
			echo blocksy_akg('value', $single_spec, '');
			echo '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}

	if (! empty($product_pros)) {
		echo '<div>';
		echo '<h5>' . __('Pros', 'blc') . '</h5>';

		echo '<ul>';

		foreach ($product_pros as $single_pro) {
			echo '<li>';
			echo blocksy_akg('label', $single_pro, '');
			echo '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}

	if (! empty($product_cons)) {
		echo '<div>';
		echo '<h5>' . __('Cons', 'blc') . '</h5>';

		echo '<ul>';

		foreach ($product_cons as $single_cons) {
			echo '<li>';
			echo blocksy_akg('label', $single_cons, '');
			echo '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}

	echo '</div>';
}

echo '</div>';
echo '</section>';
