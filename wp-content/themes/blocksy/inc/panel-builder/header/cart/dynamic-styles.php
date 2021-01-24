<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Icon size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.ct-cart-icon'
		])
	),
	'variableName' => 'icon-size',
	'value' => blocksy_akg('cartIconSize', $atts, [
		'mobile' => 15,
		'tablet' => 15,
		'desktop' => 15,
	])
]);


// Icon color
blocksy_output_colors([
	'value' => blocksy_akg('cartHeaderIconColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> a'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> a'
				])
			),
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);


// Badge color
blocksy_output_colors([
	'value' => blocksy_akg('cartBadgeColor', $atts),
	'default' => [
		'background' => [ 'color' => 'var(--paletteColor1)' ],
		'text' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'background' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'cartBadgeBackground'
		],

		'text' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'cartBadgeText'
		],
	],
	'responsive' => true
]);


// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparentCartHeaderIconColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> a'
						]),

						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> a'
						]),

						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);


	// Badge color
	blocksy_output_colors([
		'value' => blocksy_akg('transparentCartBadgeColor', $atts),
		'default' => [
			'background' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'text' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'background' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'cartBadgeBackground'
			],

			'text' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'cartBadgeText'
			],
		],
		'responsive' => true
	]);
}


// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('stickyCartHeaderIconColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> a'
						]),

						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> a'
						]),

						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);


	// Badge color
	blocksy_output_colors([
		'value' => blocksy_akg('stickyCartBadgeColor', $atts),
		'default' => [
			'background' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'text' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'background' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'cartBadgeBackground'
			],

			'text' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'cartBadgeText'
			],
		],
		'responsive' => true
	]);
}


// Dropdown top offset
$cartDropdownTopOffset = blocksy_akg( 'cartDropdownTopOffset', $atts, 15 );
$css->put(
	blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.ct-cart-content'
		])
	),
	'--dropdownTopOffset: ' . $cartDropdownTopOffset . 'px'
);


// Cart font color
blocksy_output_colors([
	'value' => blocksy_akg('cartFontColor', $atts),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-cart-content'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-cart-content'
				])
			),
			'variable' => 'linkHoverColor'
		],
	],
]);

// Cart dropdown
blocksy_output_colors([
	'value' => blocksy_akg('cartDropDownBackground', $atts),
	'default' => ['default' => ['color' => '#29333C']],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.ct-cart-content'
				])
			),
			'variable' => 'backgroundColor'
		]
	],
]);


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'headerCartMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

// panel type
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '#woo-cart-panel',
	'variableName' => 'side-panel-width',
	'responsive' => true,
	'unit' => '',
	'value' => blocksy_akg('cart_panel_width', $atts, [
		'desktop' => '500px',
		'tablet' => '65vw',
		'mobile' => '90vw',
	])
]);

blocksy_output_colors([
	'value' => blocksy_akg('cart_panel_font_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'link_initial' => [ 'color' => 'var(--headingColor)' ],
		'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '#woo-cart-panel',
			'variable' => 'color'
		],

		'link_initial' => [
			'selector' => '#woo-cart-panel',
			'variable' => 'linkInitialColor'
		],

		'link_hover' => [
			'selector' => '#woo-cart-panel',
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);

blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '#woo-cart-panel',
	'value' => blocksy_akg('cart_panel_shadow', $atts, blocksy_box_shadow_value([
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

blocksy_output_background_css([
	'selector' => '#woo-cart-panel > section',
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'responsive' => true,
	'value' => blocksy_akg('cart_panel_background', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => '#ffffff'
				],
			],
		])
	)
]);

blocksy_output_background_css([
	'selector' => '#woo-cart-panel',
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'responsive' => true,
	'value' => blocksy_akg('cart_panel_backgrop', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => 'rgba(18, 21, 25, 0.6)'
				],
			],
		])
	)
]);

blocksy_output_colors([
	'value' => blocksy_akg('cart_panel_close_button_color', $atts),
	'default' => [
		'default' => [ 'color' => 'rgba(0, 0, 0, 0.5)' ],
		'hover' => [ 'color' => 'rgba(0, 0, 0, 0.5)' ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '#woo-cart-panel .close-button',
			'variable' => 'closeButtonColor'
		],

		'hover' => [
			'selector' => '#woo-cart-panel .close-button',
			'variable' => 'closeButtonHoverColor'
		]
	],
]);


blocksy_output_colors([
	'value' => blocksy_akg('cart_panel_close_button_shape_color', $atts),
	'default' => [
		'default' => [ 'color' => 'rgba(0, 0, 0, 0)' ],
		'hover' => [ 'color' => 'rgba(0, 0, 0, 0)' ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '#woo-cart-panel .close-button',
			'variable' => 'closeButtonBackground'
		],

		'hover' => [
			'selector' => '#woo-cart-panel .close-button',
			'variable' => 'closeButtonHoverBackground'
		]
	],
]);
