<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

if (empty($default_height)) {
	$default_height = [
		'mobile' => 70,
		'tablet' => 70,
		'desktop' => 120,
	];
}

if (empty($default_background)) {
	$default_background = blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => '#ffffff',
			],
		],
	]);
}

// Row height
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'variableName' => 'height',
	'value' => blocksy_akg('headerRowHeight', $atts, $default_height)
]);

// Row background
blocksy_output_background_css([
	'selector' => blocksy_assemble_selector($root_selector),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'value' => blocksy_akg('headerRowBackground', $atts, $default_background),
	'responsive' => true,
]);


// Top Border
$headerRowTopBorderFullWidth = blocksy_akg('headerRowTopBorderFullWidth', $atts, 'no');

$top_has_border_selector = blocksy_mutate_selector([
	'selector' => $root_selector,
	'operation' => 'suffix',
	'to_add' => '> div'
]);

$top_has_no_border_selector = $root_selector;

if ($headerRowTopBorderFullWidth === 'yes') {
	$top_has_border_selector = $root_selector;

	$top_has_no_border_selector = blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	]);
}

$headerRowTopBorder = blocksy_akg('headerRowTopBorder', $atts, [
	'width' => 1,
	'style' => 'none',
	'color' => [
		'color' => 'rgba(44,62,80,0.2)',
	],
]);

blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($top_has_border_selector),
	'variableName' => 'borderTop',
	'value' => $headerRowTopBorder,
	'responsive' => true
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($top_has_no_border_selector),
	'variableName' => 'borderTop',
	'value' => [
		'desktop' => 'none',
		'tablet' => 'none',
		'mobile' => 'none'
	],
	'unit' => ''
]);


// Bottom Border
$headerRowBottomBorderFullWidth = blocksy_akg('headerRowBottomBorderFullWidth', $atts, 'no');

$bottom_has_border_selector = blocksy_mutate_selector([
	'selector' => $root_selector,
	'operation' => 'suffix',
	'to_add' => '> div'
]);
$bottom_has_no_border_selector = $root_selector;

if ($headerRowBottomBorderFullWidth === 'yes') {
	$bottom_has_border_selector = $root_selector;

	$bottom_has_no_border_selector = blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'suffix',
		'to_add' => '> div'
	]);
}

$headerRowBottomBorder = blocksy_akg('headerRowBottomBorder', $atts, [
	'width' => 1,
	'style' => 'none',
	'color' => [
		'color' => 'rgba(44,62,80,0.2)',
	],
]);

blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($bottom_has_border_selector),
	'variableName' => 'borderBottom',
	'value' => $headerRowBottomBorder,
	'responsive' => true
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($bottom_has_no_border_selector),
	'variableName' => 'borderBottom',
	'value' => [
		'desktop' => 'none',
		'tablet' => 'none',
		'mobile' => 'none'
	],
	'unit' => ''
]);

// Box shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'value' => blocksy_akg('headerRowShadow', $atts, blocksy_box_shadow_value([
		'enable' => false,
		'h_offset' => 0,
		'v_offset' => 10,
		'blur' => 20,
		'spread' => 0,
		'inset' => false,
		'color' => [
			'color' => 'rgba(44,62,80,0.05)',
		],
	])),
	'responsive' => true,
	'should_skip_output' => false
]);

// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	// background
	blocksy_output_background_css([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),

		'value' => blocksy_akg(
			'transparentHeaderRowBackground',
			$atts,
			blocksy_background_default_value([
				'backgroundColor' => [
					'default' => [
						'color' => 'rgba(255,255,255,0)',
					],
				],
			])
		),
		'responsive' => true
	]);

	// Border top
	$transparentHeaderRowTopBorder = blocksy_akg(
		'transparentHeaderRowTopBorder',
		$atts,
		[
			'width' => 1,
			'style' => 'none',
			'color' => [
				'color' => 'rgba(44,62,80,0.2)',
			],
		]
	);

	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $top_has_border_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),
		'variableName' => 'borderTop',
		'value' => $transparentHeaderRowTopBorder,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $top_has_no_border_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),

		'variableName' => 'borderTop',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);

	// Border bottom
	$transparentHeaderRowBottomBorder = blocksy_akg(
		'transparentHeaderRowBottomBorder',
		$atts,
		[
			'width' => 1,
			'style' => 'none',
			'color' => [
				'color' => 'rgba(44,62,80,0.2)',
			],
		]
	);

	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $bottom_has_border_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),

		'variableName' => 'borderBottom',
		'value' => $transparentHeaderRowBottomBorder,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $bottom_has_no_border_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),

		'variableName' => 'borderBottom',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);

	// box shadow
	blocksy_output_box_shadow([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'el-prefix',
			'to_add' => '[data-transparent-row="yes"]'
		])),

		'value' => blocksy_akg('transparentHeaderRowShadow', $atts, blocksy_box_shadow_value([
			'enable' => false,
			'h_offset' => 0,
			'v_offset' => 10,
			'blur' => 20,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(44,62,80,0.05)',
			],
		])),
		'responsive' => true,
		'should_skip_output' => false
	]);
}

// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	// background
	blocksy_output_background_css([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),

		'value' => blocksy_akg('stickyHeaderRowBackground', $atts, $default_background),
		'responsive' => true
	]);

	if (blocksy_akg('has_sticky_shrink', $atts, 'no') === 'yes') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'to_add' => '[data-sticky]'
			])),
			'variableName' => 'stickyShrink',
			'value' => blocksy_akg('stickyHeaderRowShrink', $atts, 70),
			'unit' => ''
		]);
	}

	// Border top
	$stickyHeaderRowTopBorder = blocksy_akg(
		'stickyHeaderRowTopBorder',
		$atts,
		[
			'width' => 1,
			'style' => 'none',
			'color' => [
				'color' => 'rgba(44,62,80,0.2)',
			],
		]
	);

	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $top_has_border_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),
		'variableName' => 'borderTop',
		'value' => $stickyHeaderRowTopBorder,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $top_has_no_border_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),

		'variableName' => 'borderTop',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);

	// Border bottom
	$stickyHeaderRowBottomBorder = blocksy_akg(
		'stickyHeaderRowBottomBorder',
		$atts,
		[
			'width' => 1,
			'style' => 'none',
			'color' => [
				'color' => 'rgba(44,62,80,0.2)',
			],
		]
	);

	blocksy_output_border([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $bottom_has_border_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),

		'variableName' => 'borderBottom',
		'value' => $stickyHeaderRowBottomBorder,
		'responsive' => true
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $bottom_has_no_border_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),

		'variableName' => 'borderBottom',
		'value' => [
			'desktop' => 'none',
			'tablet' => 'none',
			'mobile' => 'none'
		],
		'unit' => ''
	]);

	// box shadow
	blocksy_output_box_shadow([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'to_add' => '[data-sticky*="yes"]'
		])),
		'value' => blocksy_akg('stickyHeaderRowShadow', $atts, blocksy_box_shadow_value([
			'enable' => false,
			'h_offset' => 0,
			'v_offset' => 10,
			'blur' => 20,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(44,62,80,0.05)',
			],
		])),
		'responsive' => true,
		'should_skip_output' => false
	]);
}
