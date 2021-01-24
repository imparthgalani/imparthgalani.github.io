<?php

$class = 'ct-header-cta';

$class = trim($class . ' ' . blocksy_visibility_classes(
	blocksy_akg('visibility', $atts, [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	])
));

$type = blocksy_default_akg('header_button_type', $atts, 'type-1');
$size = blocksy_default_akg('header_button_size', $atts, 'small');
$link = blocksy_translate_dynamic(
	blocksy_default_akg('header_button_link', $atts, ''),
	'header:' . $section_id . ':button:header_button_link'
);

$visibility = blocksy_default_akg('visibility', $atts, [
	'tablet' => true,
	'mobile' => true,
]);

$target_output = '';

if (blocksy_default_akg('header_button_target', $atts, 'no') === 'yes') {
	$target_output = 'target="_blank" rel="noopener noreferrer"';
}

$class .= ' ' . blocksy_visibility_classes($visibility);
$button_class = 'ct-button';

if ($type === 'type-2') {
	$button_class = 'ct-button-ghost';
}

$text = blocksy_translate_dynamic(
	blocksy_default_akg('header_button_text', $atts, __('Download', 'blocksy')),
	'header:' . $section_id . ':button:header_button_text'
);

?>

<div
	class="<?php echo esc_attr(trim($class)) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>

	<a
		href="<?php echo esc_url($link) ?>"
		class="<?php echo $button_class ?>"
		data-size="<?php echo esc_attr($size) ?>"
		<?php echo wp_kses_post($target_output) ?>>
		<?php echo $text ?>
	</a>
</div>

