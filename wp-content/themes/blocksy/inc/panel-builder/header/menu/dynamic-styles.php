<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Items spacing
$headerMenuItemsSpacing = blocksy_akg( 'headerMenuItemsSpacing', $atts, 25 );

if ($headerMenuItemsSpacing !== 25) {
	$css->put(
		blocksy_assemble_selector($root_selector),
		'--menu-items-spacing: ' . $headerMenuItemsSpacing . 'px'
	);
}


// Items height
$headerMenuItemsHeight = blocksy_akg( 'headerMenuItemsHeight', $atts, 100 );

if ($headerMenuItemsHeight !== 100) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '> ul > li > a'
			])
		),
		'--menu-item-height: ' . $headerMenuItemsHeight . '%'
	);
}


// Top level font
blocksy_output_font_css([
	'font_value' => blocksy_akg( 'headerMenuFont', $atts,
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
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '> ul > li > a'
		])
	)
]);


// Font color
blocksy_output_colors([
	'value' => blocksy_akg('menuFontColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover-type-3' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> ul > li > a'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> ul > li > a'
				])
			),
			'variable' => 'linkHoverColor'
		],

		'hover-type-3' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> ul > li > a'
				])
			),
			'variable' => 'colorHoverType3'
		],
	],
]);

// Active indicator color
blocksy_output_colors([
	'value' => blocksy_akg('menuIndicatorColor', $atts),
	'default' => [
		'active' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'active' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'menu-indicator-active-color'
		],
	],
]);

// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparentMenuFontColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover-type-3' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> ul > li > a'
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
							'to_add' => '> ul > li > a'
						]),
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],

			'hover-type-3' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> ul > li > a'
						]),
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'colorHoverType3'
			],
		],
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparentMenuIndicatorColor', $atts),
		'default' => [
			'active' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,

		'variables' => [
			'active' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'menu-indicator-active-color'
			],
		],
	]);
}

// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('stickyMenuFontColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover-type-3' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> ul > li > a'
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
							'to_add' => '> ul > li > a'
						]),
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],

			'hover-type-3' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '> ul > li > a'
						]),
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'colorHoverType3'
			],
		],
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('stickyMenuIndicatorColor', $atts),
		'default' => [
			'active' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,

		'variables' => [
			'active' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'menu-indicator-active-color'
			],
		],
	]);
}

// Top level margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'headerMenuMargin', $atts,
		blocksy_spacing_value([
			'top' => 'auto',
			'bottom' => 'auto',
			'linked' => true,
		])
	)
]);

// Dropdown top offset
$dropdownTopOffset = blocksy_akg( 'dropdownTopOffset', $atts, 0 );

if ($dropdownTopOffset !== 0) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.sub-menu'
			])
		),
		'--dropdown-top-offset: ' . $dropdownTopOffset . 'px'
	);
}


// Dropdown box width
$dropdownMenuWidth = blocksy_akg( 'dropdownMenuWidth', $atts, 200 );

if ($dropdownMenuWidth !== 200) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.sub-menu'
			])
		),
		'--dropdown-width: ' . $dropdownMenuWidth . 'px'
	);
}


// Dropdown items spacing
$dropdownItemsSpacing = blocksy_akg( 'dropdownItemsSpacing', $atts, 13 );

if ($dropdownItemsSpacing !== 13) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.sub-menu'
			])
		),
		'--dropdown-items-spacing: ' . $dropdownItemsSpacing . 'px'
	);
}


// Dropdown font
blocksy_output_font_css([
	'font_value' => blocksy_akg( 'headerDropdownFont', $atts,
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n5',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.sub-menu'
		])
	),
]);


// Dropdown font color
blocksy_output_colors([
	'value' => blocksy_akg('headerDropdownFontColor', $atts),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.sub-menu'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.sub-menu'
				])
			),
			'variable' => 'linkHoverColor'
		],
	],
]);

// Dropdown divider
$headerDropdownDivider = blocksy_akg('headerDropdownDivider', $atts, [
	'width' => 1,
	'style' => 'dashed',
	'color' => [
		'color' => 'rgba(255, 255, 255, 0.1)',
	],
]);

blocksy_output_border([
	'css' => $css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.sub-menu'
		])
	),
	'variableName' => 'dropdown-divider',
	'value' => $headerDropdownDivider
]);

if (blocksy_default_akg('dropdown_items_type', $atts, 'simple') === 'padded') {
	if ($headerDropdownDivider['style'] !== 'none') {
		$css->put(
			blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.sub-menu'
				])
			),
			'--dropdown-items-padding: 0px'
		);
	} else {
		$css->put(
			blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.menu'
				])
			),
			'--dropdown-divider-margin: 0px'
		);
	}
}

// Dropdown background
blocksy_output_colors([
	'value' => blocksy_akg('headerDropdownBackground', $atts),
	'default' => [
		'default' => [ 'color' => '#29333C' ],
		'hover' => [ 'color' => '#34414c' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.sub-menu'
				])
			),
			'variable' => 'background-color'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.sub-menu'
				])
			),
			'variable' => 'background-hover-color'
		],
	],
]);

// Box shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.sub-menu'
		])
	),
	'value' => blocksy_akg('headerDropdownShadow', $atts, blocksy_box_shadow_value([
		'enable' => true,
		'h_offset' => 0,
		'v_offset' => 10,
		'blur' => 20,
		'spread' => 0,
		'inset' => false,
		'color' => [
			'color' => 'rgba(41, 51, 61, 0.1)',
		],
	])),
	'responsive' => true
]);

// Border radius
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.sub-menu'
		])
	),
	'property' => 'border-radius',
	'value' => blocksy_default_akg(
		'headerDropdownRadius', $atts,
		blocksy_spacing_value([
			'linked' => false,
			'top' => '0px',
			'left' => '2px',
			'right' => '0px',
			'bottom' => '2px',
		])
	)
]);
