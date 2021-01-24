<?php

// Color palette
$colorPalette = blocksy_get_colors(
	get_theme_mod('colorPalette'),
	[
		'color1' => ['color' => '#3eaf7c'],
		'color2' => ['color' => '#33a370'],
		'color3' => ['color' => 'rgba(44, 62, 80, 0.9)'],
		'color4' => ['color' => 'rgba(44, 62, 80, 1)'],
		'color5' => ['color' => '#ffffff'],
	]
);

$css->put(
	':root',
	"--paletteColor1: {$colorPalette['color1']}"
);

$css->put(
	':root',
	"--paletteColor2: {$colorPalette['color2']}"
);

$css->put(
	':root',
	"--paletteColor3: {$colorPalette['color3']}"
);

$css->put(
	':root',
	"--paletteColor4: {$colorPalette['color4']}"
);

$css->put(
	':root',
	"--paletteColor5: {$colorPalette['color5']}"
);


// body font color
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


// link color
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

// border color
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

// heading color
blocksy_output_colors([
	'value' => get_theme_mod('headingColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'headingColor'],
	],
]);


// buttons
$buttonTextColor = blocksy_get_colors( get_theme_mod('buttonTextColor'),
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	]
);

$css->put(
	':root',
	"--buttonTextInitialColor: {$buttonTextColor['default']}"
);

$css->put(
	':root',
	"--buttonTextHoverColor: {$buttonTextColor['hover']}"
);

$button_color = blocksy_get_colors( get_theme_mod('buttonColor'),
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
);

$css->put(
	':root',
	"--buttonInitialColor: {$button_color['default']}"
);

$css->put(
	':root',
	"--buttonHoverColor: {$button_color['hover']}"
);

blocksy_output_colors([
	'value' => get_theme_mod('global_quantity_color'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'quantity-initial-color'
		],

		'hover' => [
			'selector' => ':root',
			'variable' => 'quantity-hover-color'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('global_quantity_arrows'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'quantity-arrows-initial-color'
		],

		'hover' => [
			'selector' => ':root',
			'variable' => 'quantity-arrows-hover-color'
		],
	],
]);

if (
	function_exists('get_current_screen')
	&&
	get_current_screen()
	&&
	get_current_screen()->is_block_editor()
) {
	if (get_current_screen()->base === 'post') {
		$post_type = get_current_screen()->post_type;

		$post_id = null;

		if (isset($_GET['post']) && $_GET['post']) {
			$post_id = $_GET['post'];
		}

		$prefix = blocksy_manager()->screen->get_admin_prefix($post_type);

		$background_source = blocksy_default_akg(
			'background',
			blocksy_get_post_options($post_id),
			blocksy_background_default_value([
				'backgroundColor' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword()
					],
				],
			])
		);

		if (
			isset($background_source['background_type'])
			&&
			$background_source['background_type'] === 'color'
			&&
			isset($background_source['backgroundColor']['default']['color'])
			&&
			$background_source['backgroundColor']['default']['color'] === Blocksy_Css_Injector::get_skip_rule_keyword()
		) {
			$background_source = get_theme_mod(
				$prefix . '_background',
				blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => Blocksy_Css_Injector::get_skip_rule_keyword()
						],
					],
				])
			);

			if (
				isset($background_source['background_type'])
				&&
				$background_source['background_type'] === 'color'
				&&
				isset($background_source['backgroundColor']['default']['color'])
				&&
				$background_source['backgroundColor']['default']['color'] === Blocksy_Css_Injector::get_skip_rule_keyword()
			) {
				$background_source = get_theme_mod(
					'site_background',
					blocksy_background_default_value([
						'backgroundColor' => [
							'default' => [
								'color' => '#f8f9fb'
							],
						],
					])
				);
			}
		}

		$default_content_style = blocksy_default_akg(
			'content_style',
			blocksy_get_post_options($post_id),
			'inherit'
		);

		$source = [
			'prefix' => $prefix,
			'strategy' => 'customizer'
		];

		$source = null;

		if ($default_content_style === 'boxed') {
			$source = [
				'strategy' => blocksy_get_post_options($post_id)
			];
		} else {
			if (blocksy_get_content_style($post_id, $prefix) === 'boxed') {
				$source = [
					'prefix' => $prefix,
					'strategy' => 'customizer'
				];
			}
		}

		if (blocksy_get_content_style($post_id, $prefix) === 'boxed') {
			$background_source = blocksy_akg_or_customizer(
				'content_background',
				$source,
				blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => '#ffffff'
						],
					],
				])
			);
		}

		blocksy_output_background_css([
			'selector' => '.block-editor-writing-flow',
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'value' => $background_source,
			'responsive' => true,
		]);
	}

	blocksy_theme_get_dynamic_styles([
		'name' => 'typography',
		'css' => $css,
		'mobile_css' => $mobile_css,
		'tablet_css' => $tablet_css,
		'context' => 'inline',
		'chunk' => 'admin'
	]);

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
}
