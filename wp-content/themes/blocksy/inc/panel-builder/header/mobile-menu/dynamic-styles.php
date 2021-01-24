<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// link font
blocksy_output_font_css([
	'font_value' => blocksy_akg('mobileMenuFont', $atts,
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '30px',
				'tablet'  => '30px',
				'mobile'  => '20px'
			],
			'variation' => 'n7',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector)
]);


// link color
blocksy_output_colors([
	'value' => blocksy_akg('mobileMenuColor', $atts),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'linkHoverColor'
		],
	],
]);

$mobile_menu_child_size = blocksy_akg( 'mobile_menu_child_size', $atts, '20px' );

if ($mobile_menu_child_size !== '20px') {
	$css->put(
		blocksy_assemble_selector($root_selector),
		'--mobile_menu_child_size: ' . $mobile_menu_child_size
	);
}

$mobile_menu_type = blocksy_akg( 'mobile_menu_type', $atts, 'type-1' );

if ($mobile_menu_type !== 'type-1' || is_customize_preview()) {
	blocksy_output_border([
		'css' => $css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'mobile-menu-divider',
		'value' => blocksy_akg('mobile_menu_divider', $atts, [
			'width' => 1,
			'style' => 'solid',
			'color' => [
				'color' => 'rgba(255, 255, 255, 0.2)',
			],
		])
	]);
}


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'value' => blocksy_default_akg(
		'mobileMenuMargin', $atts,
		blocksy_spacing_value([
			'left' => 'auto',
			'right' => 'auto',
			'linked' => true,
		])
	)
]);

