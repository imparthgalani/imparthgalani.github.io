<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Offcanvas background
$offcanvas_behavior = blocksy_akg('offcanvas_behavior', $atts, 'panel');

$offcanvasBackground = blocksy_akg(
	'offcanvasBackground',
	$atts,
	blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => 'rgba(18, 21, 25, 0.98)'
			],
		],
	])
);

$offcanvasBackdrop = blocksy_akg(
	'offcanvasBackdrop',
	$atts,
	blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => 'rgba(255,255,255,0)'
			],
		],
	])
);

if ($offcanvas_behavior === 'panel') {
	blocksy_output_background_css([
		'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '> section'
		])),
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'responsive' => true,
		'value' => $offcanvasBackground
	]);
}

// Offcanvas backdrop
blocksy_output_background_css([
	'selector' => blocksy_assemble_selector($root_selector),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'responsive' => true,
	'value' => $offcanvas_behavior === 'panel' ? $offcanvasBackdrop : $offcanvasBackground,
]);

blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector[0] . ' [data-behaviour*="side"]'),
	'value' => blocksy_akg('headerPanelShadow', $atts, blocksy_box_shadow_value([
		'enable' => true,
		'h_offset' => 0,
		'v_offset' => 0,
		'blur' => 70,
		'spread' => 0,
		'inset' => false,
		'color' => [
			'color' => 'rgba(0, 0, 0, 0.35)',
		],
	])),
	'responsive' => true
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'variableName' => 'side-panel-width',
	'unit' => '',
	'value' => blocksy_akg('side_panel_width', $atts, [
		'desktop' => '500px',
		'tablet' => '65vw',
		'mobile' => '90vw',
	])
]);

$vertical_alignment = blocksy_akg( 'offcanvas_content_vertical_alignment', $atts, 'flex-start' );

if ($vertical_alignment !== 'flex-start') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'vertical-alignment',
		'unit' => '',
		'value' => $vertical_alignment,
	]);
}

$horizontal_alignment = blocksy_akg( 'offcanvasContentAlignment', $atts, 'flex-start' );

if ($horizontal_alignment !== 'flex-start') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'horizontal-alignment',
		'unit' => '',
		'value' => $horizontal_alignment,
	]);
}


blocksy_output_colors([
	'value' => blocksy_akg('menu_close_button_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.close-button'
			])),
			'variable' => 'closeButtonColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.close-button'
			])),
			'variable' => 'closeButtonHoverColor'
		]
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg('menu_close_button_shape_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.close-button'
			])),
			'variable' => 'closeButtonBackground'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.close-button'
			])),
			'variable' => 'closeButtonHoverBackground'
		]
	],
]);
