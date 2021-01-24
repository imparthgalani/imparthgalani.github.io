<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Icon size
$socialsIconSize = blocksy_akg( 'socialsIconSize', $atts, 15 );

if ($socialsIconSize !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'icon-size',
		'value' => $socialsIconSize,
		'responsive' => true
	]);
}

// Icon spacing
$socialsIconSpacing = blocksy_akg( 'socialsIconSpacing', $atts, 15 );

if ($socialsIconSpacing !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'spacing',
		'value' => $socialsIconSpacing,
		'responsive' => true
	]);
}


// Horizontal alignment
$horizontal_alignment = blocksy_akg( 'footerSocialsAlignment', $atts, 'flex-start' );

if ($horizontal_alignment !== 'flex-start') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'replace-last',
			'to_add' => $column_selector
		])),
		'variableName' => 'horizontal-alignment',
		'value' => $horizontal_alignment,
		'unit' => '',
	]);
}


// Vertical alignment
$vertical_alignment = blocksy_akg( 'footerSocialsVerticalAlignment', $atts, 'CT_CSS_SKIP_RULE' );

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'replace-last',
		'to_add' => $column_selector
	])),
	'variableName' => 'vertical-alignment',
	'value' => $vertical_alignment,
	'unit' => '',
]);


// Icons custom color
blocksy_output_colors([
	'value' => blocksy_akg('footerSocialsIconColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '[data-color="custom"]'
			])),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '[data-color="custom"]'
			])),
			'variable' => 'linkHoverColor'
		]
	],

	'responsive' => true
]);

// Icons custom background
blocksy_output_colors([
	'value' => blocksy_akg('footerSocialsIconBackground', $atts),
	'default' => [
		'default' => [ 'color' => 'rgba(218, 222, 228, 0.3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '[data-color="custom"]'
			])),
			'variable' => 'background-color'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '[data-color="custom"]'
			])),
			'variable' => 'background-hover-color'
		]
	],

	'responsive' => true
]);

// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'footerSocialsMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

if (function_exists('blocksy_output_responsive_switch')) {
	blocksy_output_responsive_switch([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.ct-label'
		])),
		'value' => blocksy_default_akg(
			'socialsLabelVisibility',
			$atts,
			[
				'desktop' => false,
				'tablet' => false,
				'mobile' => false,
			]
		),
		'on' => 'block'
	]);
}

