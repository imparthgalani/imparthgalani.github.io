<?php

blocksy_output_font_css([
	'font_value' => get_theme_mod(
		$prefix . '_cardTitleFont',
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '20px',
				'tablet'  => '20px',
				'mobile'  => '18px'
			],
			'line-height' => '1.3'
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('.entry-card .entry-title', $prefix)
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardTitleColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-card .entry-title', $prefix),
			'variable' => 'headingColor'
		],
		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-card .entry-title', $prefix),
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_font_css([
	'font_value' => get_theme_mod(
		$prefix . '_cardExcerptFont',
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '16px',
				'tablet'  => '16px',
				'mobile'  => '16px'
			],
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('.entry-excerpt', $prefix)
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardExcerptColor'),
	'default' => [
		'default' => ['color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT')]
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-excerpt', $prefix),
			'variable' => 'color'
		]
	],
]);

blocksy_output_font_css([
	'font_value' => get_theme_mod(
		$prefix . '_cardMetaFont',
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '12px',
				'tablet'  => '12px',
				'mobile'  => '12px'
			],
			'variation' => 'n6',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('.entry-card .entry-meta', $prefix)
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardMetaColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-card .entry-meta', $prefix),
			'variable' => 'color'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-card .entry-meta', $prefix),
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardButtonSimpleTextColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="simple"]', $prefix),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="simple"]', $prefix),
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardButtonBackgroundTextColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="background"]', $prefix),
			'variable' => 'buttonTextInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="background"]', $prefix),
			'variable' => 'buttonTextHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardButtonOutlineTextColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="outline"]', $prefix),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-button[data-type="outline"]', $prefix),
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardButtonColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('.entry-button', $prefix),
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => blocksy_prefix_selector('.entry-button', $prefix),
			'variable' => 'buttonHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod($prefix . '_cardBackground'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => blocksy_prefix_selector('[data-cards="boxed"] .entry-card', $prefix),
			'variable' => 'cardBackground'
		],
	],
]);

blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('[data-cards="boxed"] .entry-card', $prefix),
	'variableName' => 'border',
	'value' => get_theme_mod($prefix . '_cardBorder', [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	]),
	'responsive' => true
]);

blocksy_output_border([
	'css' => $css,
	'selector' => blocksy_prefix_selector('.entry-card', $prefix),
	'variableName' => 'entry-divider',
	'value' => get_theme_mod($prefix . '_entryDivider', [
		'width' => 1,
		'style' => 'solid',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.8)',
		],
	])
]);

blocksy_output_border([
	'css' => $css,
	'selector' => blocksy_prefix_selector('[data-cards="simple"] .entry-card', $prefix),
	'variableName' => 'border',
	'value' => get_theme_mod($prefix . '_cardDivider', [
		'width' => 1,
		'style' => 'dashed',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.8)',
		],
	])
]);

$cards_gap = get_theme_mod($prefix. '_cardsGap', 30);

if ($cards_gap !== 30) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_prefix_selector('.entries', $prefix),
		'variableName' => 'cardsGap',
		'value' => $cards_gap
	]);
}

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('[data-cards="boxed"] .entry-card', $prefix),
	'variableName' => 'cardSpacing',
	'value' => get_theme_mod($prefix . '_card_spacing', [
		'mobile' => 25,
		'tablet' => 35,
		'desktop' => 35,
	])
]);

// Border radius
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('[data-cards="boxed"] .entry-card', $prefix),
	'property' => 'borderRadius',
	'value' => get_theme_mod(
		$prefix . '_cardRadius',
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

// Box shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('[data-cards="boxed"] .entry-card', $prefix),
	'value' => get_theme_mod($prefix . '_cardShadow', blocksy_box_shadow_value([
		'enable' => true,
		'h_offset' => 0,
		'v_offset' => 12,
		'blur' => 18,
		'spread' => -6,
		'inset' => false,
		'color' => [
			'color' => 'rgba(34, 56, 101, 0.04)',
		],
	])),
	'responsive' => true
]);

// Featured Image Radius
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_prefix_selector('.entry-card .ct-image-container', $prefix),
	'property' => 'borderRadius',
	'value' => get_theme_mod(
		$prefix . '_cardThumbRadius',
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

