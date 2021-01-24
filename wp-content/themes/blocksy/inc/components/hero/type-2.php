<?php

$attachment_id = false;

$page_title_bg_type = blocksy_akg_or_customizer(
	'page_title_bg_type',
	blocksy_get_page_title_source(),
	(
		(is_singular() || blocksy_is_page()) ? 'featured_image' : 'color'
	)
);

if ($page_title_bg_type !== 'color') {
	if (
		is_singular()
		||
		blocksy_is_page()
	) {
		if (blocksy_is_page()) {
			$attachment_id = get_post_thumbnail_id(blocksy_is_page());
		} else {
			$attachment_id = get_post_thumbnail_id();
		}
	} else {
		$term_id = get_queried_object_id();

		if ($term_id && !is_singular()) {
			$id = get_term_meta($term_id, 'thumbnail_id');

			if ($id && !empty($id)) {
				$attachment_id = $id[0];
			}

			if (! $id) {
				$attachment_id = null;
			}
		}
	}
}

if ($page_title_bg_type === 'custom_image') {
	$attachment_id = null;

	$custom_background_image = blocksy_akg_or_customizer(
		'custom_hero_background',
		blocksy_get_page_title_source(),
		[
			'attachment_id' => null
		]
	);

	if ($custom_background_image['attachment_id']) {
		$attachment_id = $custom_background_image['attachment_id'];
	}
}

if (
	$page_title_bg_type === 'custom_image'
	||
	$page_title_bg_type === 'featured_image'
) {
	$parallax_result = [];

	$parallax_value = blocksy_akg_or_customizer(
		'parallax',
		blocksy_get_page_title_source(),
		[
			'desktop' => false,
			'tablet' => false,
			'mobile' => false,
		]
	);

	if ($parallax_value['desktop']) {
		$parallax_result[] = 'desktop';
	}

	if ($parallax_value['tablet']) {
		$parallax_result[] = 'tablet';
	}

	if ($parallax_value['mobile']) {
		$parallax_result[] = 'mobile';
	}

	if (count($parallax_result) > 0) {
		$attr['data-parallax'] = implode(':', $parallax_result);
	}
}

$hero_structure = blocksy_akg_or_customizer(
	'hero_structure',
	blocksy_get_page_title_source(),
	'narrow'
);

$container_class = 'ct-container';

if ($hero_structure === 'narrow') {
	$container_class = 'ct-container-narrow';
}

?>

<section <?php echo blocksy_attr_to_html($attr) ?>>
	<?php if ($attachment_id) { ?>
		<figure>
			<?php
				echo blocksy_image([
					'attachment_id' => $attachment_id,
					'size' => 'full',
					'ratio_blocks' => false
				]);
			?>
		</figure>
	<?php } ?>

	<header class="entry-header <?php echo $container_class ?>">
		<?php echo $elements ?>
	</header>
</section>


