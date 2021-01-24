<?php

blc_call_fn(['fn' => 'blocksy_output_background_css'], [
	'selector' => '.ct-trending-block',
	'css' => $css,
	'value' => get_theme_mod(
		'trending_block_background',
		blc_call_fn([
			'fn' => 'blocksy_background_default_value',
			'default' => null
		], [
			'backgroundColor' => [
				'default' => [
					'color' => '#e0e3e8'
				],
			],
		])
	)
]);

blc_call_fn(['fn' => 'blocksy_output_responsive'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ".ct-trending-block",
	'variableName' => 'padding',
	'value' => get_theme_mod('trendingBlockContainerSpacing', [
		'mobile' => '30px',
		'tablet' => '30px',
		'desktop' => '30px',
	]),
	'unit' => ''
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('trendingBlockFontColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-trending-block',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.ct-trending-block',
			'variable' => 'linkHoverColor'
		],
	],
]);
