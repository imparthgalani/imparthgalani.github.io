<?php

$selector_prefix = $prefix;

if ($selector_prefix === 'blog') {
	$selector_prefix = '';
}

// Pagination
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('.ct-pagination', $selector_prefix),
	'variableName' => 'spacing',
	'value' => get_theme_mod($prefix . '_paginationSpacing', [
		'mobile' => 50,
		'tablet' => 60,
		'desktop' => 80,
	])
]);

blocksy_output_border([
	'css' => $css,
	'selector' => blocksy_prefix_selector('.ct-pagination[data-divider]', $selector_prefix),
	'variableName' => 'border',
	'value' => get_theme_mod($prefix . '_paginationDivider', [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.5)',
		],
	])
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_simplePaginationFontColor', []),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'active' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="simple"], [data-pagination="next_prev"]',
				$selector_prefix
			),
			'variable' => 'color'
		],

		'active' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="simple"]',
				$selector_prefix
			),
			'variable' => 'colorActive'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="simple"], [data-pagination="next_prev"]',
				$selector_prefix
			),
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_paginationButtonText', []),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="load_more"]',
				$selector_prefix
			),
			'variable' => 'buttonTextInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="load_more"]',
				$selector_prefix
			),
			'variable' => 'buttonTextHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_paginationButton', []),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="load_more"]',
				$selector_prefix
			),
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector(
				'[data-pagination="load_more"]',
				$selector_prefix
			),
			'variable' => 'buttonHoverColor'
		],
	],
]);

