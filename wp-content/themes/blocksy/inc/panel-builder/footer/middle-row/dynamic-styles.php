<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Row top & bottom spacing
if (empty($default_top_bottom_spacing)) {
	$default_top_bottom_spacing = [
		'desktop' => '70px',
		'tablet' => '50px',
		'mobile' => '40px',
	];
}

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '> div'
		])
	),
	'variableName' => 'container-spacing',
	'unit' => '',
	'value' => blocksy_akg(
		'rowTopBottomSpacing',
		$atts,
		$default_top_bottom_spacing
	)
]);


// Items gap
if (empty($default_items_spacing)) {
	$default_items_spacing = [
		'desktop' => 60,
		'tablet' => 40,
		'mobile' => 40,
	];
}

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '> div'
		])
	),
	'variableName' => 'items-gap',
	'value' => blocksy_akg(
		'footerItemsGap',
		$atts,
		$default_items_spacing
	)
]);

// vertical alignment
$vertical_alignment = blocksy_akg( 'footer_row_vertical_alignment', $atts, 'flex-start' );

if ($vertical_alignment !== 'flex-start') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '> div'
			])
		),
		'variableName' => 'vertical-alignment',
		'value' => $vertical_alignment,
		'unit' => '',
	]);
}

// Widgets title font & color
blocksy_output_font_css([
	'font_value' => blocksy_akg( 'footerWidgetsTitleFont', $atts,
		blocksy_typography_default_values([
			'size' => '16px',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.widget-title'
		])
	),
]);

blocksy_output_colors([
	'value' => blocksy_akg('footerWidgetsTitleColor', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.widget-title'
				])
			),
			'variable' => 'headingColor'
		],
	],
]);


// Widgets font & color
blocksy_output_font_css([
	'font_value' => blocksy_akg( 'footerWidgetsFont', $atts,
		blocksy_typography_default_values([
			// 'size' => '16px',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.ct-widget > *:not(.widget-title)'
		])
	),
]);

// Widgets font color
blocksy_output_colors([
	'value' => blocksy_akg('rowFontColor', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'link_initial' => [ 'color' => 'var(--color)' ],
		'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-widget > *:not(.widget-title)'
				])
			),
			'variable' => 'color'
		],

		'link_initial' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-widget'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'link_hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-widget'
				])
			),
			'variable' => 'linkHoverColor'
		],
	],
]);

// Widgets headings color
blocksy_output_colors([
	'value' => blocksy_akg('rowHeadingFontColor', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-widget > *:not(.widget-title)'
				])
			),
			'variable' => 'headingColor'
		],
	],
]);


// Columns divider
blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '[data-divider="columns"]'
		])
	),
	'variableName' => 'border',
	'value' => blocksy_akg('footerColumnsDivider', $atts, [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => '#dddddd',
		],
	]),
]);


// Top border
$footerRowTopBorderFullWidth = blocksy_akg('footerRowTopBorderFullWidth', $atts, 'no');

$top_has_border_selector = blocksy_mutate_selector([
	'selector' => $root_selector,
	'operation' => 'suffix',
	'to_add' => '> div'
]);

$top_has_no_border_selector = $root_selector;

if ($footerRowTopBorderFullWidth === 'yes') {
	$top_has_border_selector = $root_selector;

	$top_has_no_border_selector = blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	]);
}

$footerRowTopDivider = blocksy_akg('footerRowTopDivider', $atts, [
	'width' => 1,
	'style' => 'none',
	'color' => [
		'color' => '#dddddd',
	],
]);

if (isset($footerRowTopDivider['desktop']) || is_customize_preview()) {
	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($top_has_border_selector),
		'variableName' => 'border-top',
		'value' => $footerRowTopDivider,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($top_has_no_border_selector),
		'variableName' => 'border-top',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);
}



// Bottom border
$footerRowBottomBorderFullWidth = blocksy_akg('footerRowBottomBorderFullWidth', $atts, 'no');

$bottom_has_border_selector = blocksy_mutate_selector([
	'selector' => $root_selector,
	'operation' => 'suffix',
	'to_add' => '> div'
]);
$bottom_has_no_border_selector = $root_selector;

if ($footerRowBottomBorderFullWidth === 'yes') {
	$bottom_has_border_selector = $root_selector;

	$bottom_has_no_border_selector = blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	]);
}

$footerRowBottomDivider = blocksy_akg('footerRowBottomDivider', $atts, [
	'width' => 1,
	'style' => 'none',
	'color' => [
		'color' => '#dddddd',
	],
]);

if (isset($footerRowBottomDivider['desktop']) || is_customize_preview()) {
	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($bottom_has_border_selector),
		'variableName' => 'border-bottom',
		'value' => $footerRowBottomDivider,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($bottom_has_no_border_selector),
		'variableName' => 'border-bottom',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);
}


// Row background
if (empty($default_background)) {
	$default_background = blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => 'transparent'
			],
		],
	]);
}

blocksy_output_background_css([
	'selector' => blocksy_assemble_selector($root_selector),
	'css' => $css,
	'value' => blocksy_akg('footerRowBackground', $atts,
		$default_background
	)
]);


$count = count($primary_item['columns']);

$gridTemplate = [
	'desktop' => 'initial',
	'tablet' => 'initial',
	'mobile' => 'initial'
];

if ($count === 2) {
	$gridTemplate = blocksy_default_akg('2_columns_layout', $atts, [
		'desktop' => 'repeat(2, 1fr)',
		'tablet' => 'initial',
		'mobile' => 'initial'
	]);
}

if ($count === 3) {
	$gridTemplate = blocksy_default_akg('3_columns_layout', $atts, [
		'desktop' => 'repeat(3, 1fr)',
		'tablet' => 'initial',
		'mobile' => 'initial',
	]);
}

if ($count === 4) {
	$gridTemplate = blocksy_default_akg('4_columns_layout', $atts, [
		'desktop' => 'repeat(4, 1fr)',
		'tablet' => 'initial',
		'mobile' => 'initial'
	]);
}

if ($count === 5) {
	$gridTemplate = blocksy_default_akg('5_columns_layout', $atts, [
		'desktop' => 'repeat(5, 1fr)',
		'tablet' => 'initial',
		'mobile' => 'initial'
	]);
}

if ($count === 6) {
	$gridTemplate = blocksy_default_akg('6_columns_layout', $atts, [
		'desktop' => 'repeat(6, 1fr)',
		'tablet' => 'initial',
		'mobile' => 'initial'
	]);
}

$css->put(
	blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	])),
	'--grid-template-colummns: ' . $gridTemplate['desktop']
);

$tablet_css->put(
	blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	])),
	'--grid-template-colummns: ' . $gridTemplate['tablet']
);

$mobile_css->put(
	blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	])),
	'--grid-template-colummns: ' . $gridTemplate['mobile']
);

