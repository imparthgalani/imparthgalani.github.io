<?php

$class = 'ct-header-socials';

$visibility = blocksy_default_akg('visibility', $atts, [
	'tablet' => true,
	'mobile' => true,
]);

$class .= ' ' . blocksy_visibility_classes($visibility);

$socialsColor = blocksy_default_akg('headerSocialsColor', $atts, 'custom');
$socialsType = blocksy_default_akg('socialsType', $atts, 'simple');

$socials = blocksy_default_akg(
	'header_socials',
	$atts,
	[
		[
			'id' => 'facebook',
			'enabled' => true,
		],

		[
			'id' => 'twitter',
			'enabled' => true,
		],

		[
			'id' => 'instagram',
			'enabled' => true,
		],
	]
);

?>

<div
	class="<?php echo esc_attr($class) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>

	<?php echo blocksy_social_icons($socials, [
		'type' => $socialsType,
		'icons-color' => $socialsColor,
		'fill' => blocksy_default_akg(
			'socialsFillType',
			$atts,
			'solid'
		),
		'hide_labels' => !blocksy_some_device(blocksy_default_akg(
			'socialsLabelVisibility',
			$atts,
			[
				'desktop' => false,
				'tablet' => false,
				'mobile' => false,
			]
		))
	]) ?>

</div>
