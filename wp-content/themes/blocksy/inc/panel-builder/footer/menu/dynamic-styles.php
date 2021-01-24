<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Items spacing
$footerMenuItemsSpacing = blocksy_akg( 'footerMenuItemsSpacing', $atts, 25 );

if ($footerMenuItemsSpacing !== 25) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'menu-items-spacing',
		'value' => $footerMenuItemsSpacing
	]);
}

// Horizontal alignment
$horizontal_alignment = blocksy_akg( 'footerMenuAlignment', $atts, 'flex-start' );

if ($horizontal_alignment !== 'flex-start') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'replace-last',
			'to_add' => '[data-column="menu"]'
		])),
		'variableName' => 'horizontal-alignment',
		'value' => $horizontal_alignment,
		'unit' => '',
	]);
}

// Vertical alignment
$vertical_alignment = blocksy_akg( 'footerMenuVerticalAlignment', $atts, 'CT_CSS_SKIP_RULE' );

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'replace-last',
		'to_add' => '[data-column="menu"]'
	])),
	'variableName' => 'vertical-alignment',
	'value' => $vertical_alignment,
	'unit' => '',
]);


// Top level font
blocksy_output_font_css([
	'font_value' => blocksy_akg( 'footerMenuFont', $atts,
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n7',
			'line-height' => '1.3',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => 'ul'
	])),
]);


// Font color
blocksy_output_colors([
	'value' => blocksy_akg('footerMenuFontColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '> ul > li > a'
			])),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '> ul > li > a'
			])),
			'variable' => 'linkHoverColor'
		],
	],
]);

// Top level margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'footerMenuMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);
