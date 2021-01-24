<?php

// Color palette
blocksy_output_colors([
	'value' => get_theme_mod('colorPalette'),
	'default' => [
		'color1' => [ 'color' => '#3eaf7c' ],
		'color2' => [ 'color' => '#33a370' ],
		'color3' => [ 'color' => 'rgba(44, 62, 80, 0.9)' ],
		'color4' => [ 'color' => 'rgba(44, 62, 80, 1)' ],
		'color5' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'color1' => ['variable' => 'paletteColor1'],
		'color2' => ['variable' => 'paletteColor2'],
		'color3' => ['variable' => 'paletteColor3'],
		'color4' => ['variable' => 'paletteColor4'],
		'color5' => ['variable' => 'paletteColor5'],
	],
]);

// Colors
blocksy_output_colors([
	'value' => get_theme_mod('fontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'color'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('linkColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'linkInitialColor'],
		'hover' => ['variable' => 'linkHoverColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('selectionColor'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'selectionTextColor'],
		'hover' => ['variable' => 'selectionBackgroundColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('border_color'),
	'default' => [
		'default' => [ 'color' => 'rgba(224, 229, 235, 0.9)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'border-color'],
	],
]);


// Heading
blocksy_output_colors([
	'value' => get_theme_mod('headingColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'headingColor'
		],
	],
]);

// Content spacing
$contentSpacingMap = [
	'none' => '0',
	'compact' => '0.8em',
	'comfortable' => '1.5em',
	'spacious' => '2em',
];

$contentSpacing = get_theme_mod('contentSpacing', 'comfortable');

$contentSpacing = isset(
	$contentSpacingMap[$contentSpacing]
) ? $contentSpacingMap[$contentSpacing] : $contentSpacingMap['comfortable'];

$css->put(':root', '--contentSpacing: ' . $contentSpacing);

// Buttons
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'buttonMinHeight',
	'value' => get_theme_mod('buttonMinHeight', [
		'mobile' => 45,
		'tablet' => 45,
		'desktop' => 45,
	])
]);

if (get_theme_mod('buttonHoverEffect', 'yes') !== 'yes') {
	$css->put(':root', '--buttonShadow: none');
	$css->put(':root', '--buttonTransform: none');
}

blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'property' => 'buttonBorderRadius',
	'value' => get_theme_mod( 'buttonRadius',
		blocksy_spacing_value([
			'linked' => true,
			'top' => '3px',
			'left' => '3px',
			'right' => '3px',
			'bottom' => '3px',
		])
	)
]);

blocksy_output_colors([
	'value' => get_theme_mod('buttonTextColor'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'buttonTextInitialColor'],
		'hover' => ['variable' => 'buttonTextHoverColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('buttonColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'buttonInitialColor'],
		'hover' => ['variable' => 'buttonHoverColor'],
	],
]);

// Layout
$max_site_width = get_theme_mod( 'maxSiteWidth', 1290 );
$css->put(
	':root',
	'--container-max-width: ' . $max_site_width . 'px'
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'content-vertical-spacing',
	'unit' => '',
	'value' => get_theme_mod('contentAreaSpacing', [
		'desktop' => '60px',
		'tablet' => '60px',
		'mobile' => '50px',
		
	])
]);

$narrowContainerWidth = get_theme_mod( 'narrowContainerWidth', 750 );
$css->put(
	':root',
	'--narrow-container-max-width: ' . $narrowContainerWidth . 'px'
);

$wideOffset = get_theme_mod( 'wideOffset', 130 );
$css->put(
	':root',
	'--wide-offset: ' . $wideOffset . 'px'
);

// Sidebar
$sidebar_width = get_theme_mod( 'sidebarWidth', '27' );
$css->put( '[data-sidebar]', '--sidebarWidth: ' . $sidebar_width . '%' );
$css->put( '[data-sidebar]', '--sidebarWidthNoUnit: ' . intval($sidebar_width) );

$sidebarGap = blocksy_get_with_percentage( 'sidebarGap', '4%' );
$css->put( '[data-sidebar]', '--sidebarGap: ' . $sidebarGap );

$sidebarOffset = get_theme_mod( 'sidebarOffset', '50' );
$css->put( '[data-sidebar]', '--sidebarOffset: ' . $sidebarOffset . 'px' );

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsTitleColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-sidebar .widget-title',
			'variable' => 'headingColor'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsFontColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'link_initial' => [ 'color' => 'var(--color)' ],
		'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-sidebar > *',
			'variable' => 'color'
		],

		'link_initial' => [
			'selector' => '.ct-sidebar',
			'variable' => 'linkInitialColor'
		],

		'link_hover' => [
			'selector' => '.ct-sidebar',
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsHeadingFontColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-widget > *:not(.widget-title)',
			'variable' => 'headingColor'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarBackgroundColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor5)' ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '[data-sidebar] > aside',
			'variable' => 'sidebarBackgroundColor'
		],
	],
	'responsive' => true
]);

// Sidebar border
blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => 'aside[data-type="type-2"]',
	'variableName' => 'border',
	'value' => get_theme_mod('sidebarBorder', [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.8)',
		],
	]),
	'responsive' => true
]);

blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => 'aside[data-type="type-3"]',
	'variableName' => 'border',
	'value' => get_theme_mod('sidebarDivider', [
		'width' => 1,
		'style' => 'solid',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.8)',
		],
	]),
	'responsive' => true
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-sidebar',
	'variableName' => 'sidebar-widgets-spacing',
	'value' => get_theme_mod('sidebarWidgetsSpacing', [
		'desktop' => 60,
		'tablet' => 40,
		'mobile' => 40,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => "[data-sidebar] > aside",
	'variableName' => 'sidebarInnerSpacing',
	'value' => get_theme_mod('sidebarInnerSpacing', [
		'mobile' => 35,
		'tablet' => 35,
		'desktop' => 35,
	])
]);

blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => 'aside[data-type="type-2"]',
	'property' => 'borderRadius',
	'value' => get_theme_mod( 'sidebarRadius',
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

// Sidebar shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => 'aside[data-type="type-2"]',
	'value' => get_theme_mod('sidebarShadow', blocksy_box_shadow_value([
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

// To top button
$topButtonSize = get_theme_mod('topButtonSize', 12);

if ($topButtonSize !== 12) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.ct-back-to-top',
		'variableName' => 'icon-size',
		'value' => $topButtonSize
	]);
}

$topButtonOffset = get_theme_mod('topButtonOffset', 25);

if ($topButtonOffset !== 25) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.ct-back-to-top',
		'variableName' => 'back-top-bottom-offset',
		'value' => $topButtonOffset
	]);
}

$sideButtonOffset = get_theme_mod('sideButtonOffset', 25);

if ($sideButtonOffset !== 25) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.ct-back-to-top',
		'variableName' => 'back-top-side-offset',
		'value' => $sideButtonOffset
	]);
}

blocksy_output_colors([
	'value' => get_theme_mod('topButtonIconColor'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'colorHover'
		]
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('topButtonShapeBackground'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'backgroundColor'
		],

		'hover' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'backgroundColorHover'
		]
	],
]);

blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-back-to-top',
	'value' => get_theme_mod('topButtonShadow', blocksy_box_shadow_value([
		'enable' => false,
		'h_offset' => 0,
		'v_offset' => 5,
		'blur' => 20,
		'spread' => 0,
		'inset' => false,
		'color' => [
			'color' => 'rgba(210, 213, 218, 0.2)',
		],
	])),
	'responsive' => true
]);

// Passepartout
$has_passepartout = get_theme_mod('has_passepartout', 'no');

if ($has_passepartout !== 'no' || is_customize_preview()) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '[data-frame]',
		'variableName' => 'frame-size',
		'value' => get_theme_mod('passepartoutSize', 10)
	]);

	blocksy_output_colors([
		'value' => get_theme_mod('passepartoutColor'),
		'default' => [
			'default' => [ 'color' => 'var(--paletteColor1)' ],
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => '[data-frame]',
				'variable' => 'frame-color'
			],
		],
	]);
}
