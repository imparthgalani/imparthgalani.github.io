<?php

$default_content_style = blocksy_default_akg(
	'content_style',
	blocksy_get_post_options(),
	'inherit'
);

$source = [
	'prefix' => $prefix,
	'strategy' => 'customizer'
];

$source = null;

if ($default_content_style === 'boxed') {
	$source = [
		'strategy' => blocksy_get_post_options()
	];
} else {
	if (blocksy_get_content_style() === 'boxed') {
		$source = [
			'prefix' => $prefix,
			'strategy' => 'customizer'
		];
	}
}

$default_background = blocksy_default_akg(
	'background',
	blocksy_get_post_options(),
	blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => Blocksy_Css_Injector::get_skip_rule_keyword()
			],
		],
	])
);

$background_source = blocksy_default_akg(
	'background',
	blocksy_get_post_options(),
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
}

blocksy_output_background_css([
	'selector' => blocksy_prefix_selector('', $prefix),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'value' => $background_source,
	'responsive' => true,
]);

if ($source || is_customize_preview()) {
	if (blocksy_get_content_style() === 'boxed') {
		blocksy_output_background_css([
			'selector' => blocksy_prefix_selector('[data-structure*="boxed"]', $prefix),
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'value' => blocksy_akg_or_customizer('content_background', $source,
				blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => '#ffffff'
						],
					],
				])
			),
			'responsive' => true,
		]);

		blocksy_output_spacing([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('[data-structure*="boxed"]', $prefix),
			'property' => 'boxed-content-spacing',
			'value' => blocksy_akg_or_customizer(
				'boxed_content_spacing',
				$source,
				[
					'desktop' => blocksy_spacing_value([
						'linked' => true,
						'top' => '40px',
						'left' => '40px',
						'right' => '40px',
						'bottom' => '40px',
					]),
					'tablet' => blocksy_spacing_value([
						'linked' => true,
						'top' => '35px',
						'left' => '35px',
						'right' => '35px',
						'bottom' => '35px',
					]),
					'mobile'=> blocksy_spacing_value([
						'linked' => true,
						'top' => '20px',
						'left' => '20px',
						'right' => '20px',
						'bottom' => '20px',
					]),
				]
			)
		]);

		blocksy_output_spacing([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('[data-structure*="boxed"]', $prefix),
			'property' => 'border-radius',
			'value' => blocksy_akg_or_customizer(
				'content_boxed_radius',
				$source,
				blocksy_spacing_value([
					'linked' => true,
					'top' => '3px',
					'left' => '3px',
					'right' => '3px',
					'bottom' => '3px',
				])
			)
		]);

		blocksy_output_box_shadow([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('[data-structure*="boxed"]', $prefix),
			'value' => blocksy_akg_or_customizer(
				'content_boxed_shadow',
				$source,
				blocksy_box_shadow_value([
					'enable' => true,
					'h_offset' => 0,
					'v_offset' => 12,
					'blur' => 18,
					'spread' => -6,
					'inset' => false,
					'color' => [
						'color' => 'rgba(34, 56, 101, 0.04)',
					],
				])
			),
			'responsive' => true
		]);
	}
}
