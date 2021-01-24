<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Icon size
$search_header_icon_size = blocksy_akg('searchHeaderIconSize', $atts, 15);

if ($search_header_icon_size !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'icon-size',
		'value' => $search_header_icon_size
	]);
}

// Icon color
blocksy_output_colors([
	'value' => blocksy_akg('searchHeaderIconColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
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
	'responsive' => true
]);

// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparentSearchHeaderIconColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);
}


// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('stickySearchHeaderIconColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);
}

// Links color
blocksy_output_colors([
	'value' => blocksy_akg('searchHeaderLinkColor', $atts),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal'
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal'
			),
			'variable' => 'linkHoverColor'
		],
	],
]);


// Close button
blocksy_output_colors([
	'value' => blocksy_akg('search_close_button_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal .close-button'
			),
			'variable' => 'closeButtonColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal .close-button'
			),
			'variable' => 'closeButtonHoverColor'
		]
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg('search_close_button_shape_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal .close-button'
			),
			'variable' => 'closeButtonBackground'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				$root_selector[0] . ' #search-modal .close-button'
			),
			'variable' => 'closeButtonHoverBackground'
		]
	],
]);


// Modal background
blocksy_output_background_css([
	'selector' => blocksy_assemble_selector(
		$root_selector[0] . ' #search-modal'
	),
	'css' => $css,
	'value' => blocksy_akg('searchHeaderBackground', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => 'rgba(18, 21, 25, 0.98)'
				],
			],
		])
	)
]);


// Icon margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'headerSearchMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);
