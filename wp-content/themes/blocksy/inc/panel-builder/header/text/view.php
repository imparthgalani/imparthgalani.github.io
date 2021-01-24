<?php

$class = 'ct-header-text';

if ($panel_type === 'header') {
	$search_visibility = blocksy_default_akg('visibility', $atts, [
		'tablet' => true,
		'mobile' => true,
	]);
} else {
	$search_visibility = blocksy_default_akg('footer_visibility', $atts, [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	]);
}

$class .= ' ' . blocksy_visibility_classes($search_visibility);

$text = do_shortcode(
	blocksy_translate_dynamic(
		blocksy_default_akg(
			'header_text',
			$atts,
			__('Sample text', 'blocksy')
		)
	),
	'header:' . $section_id . ':text:header_text'
);

?>

<div
	class="<?php echo esc_attr($class) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>
	<div class="entry-content">
		<?php echo $text ?>
	</div>
</div>
