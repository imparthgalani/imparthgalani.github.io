<?php

// share box
if (
	get_theme_mod($prefix . '_has_share_box', 'yes') === 'yes'
	&&
	$prefix !== 'single_page'
) {

	$share_box_type = get_theme_mod($prefix. '_share_box_type', 'type-1');

	if ($share_box_type === 'type-1') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.ct-share-box[data-location="top"]', $prefix),
			'variableName' => 'margin',
			'value' => get_theme_mod(
				$prefix . '_top_share_box_spacing',
				[
					'mobile' => '30px',
					'tablet' => '50px',
					'desktop' => '70px',
				]
			),
			'unit' => ''
		]);

		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.ct-share-box[data-location="bottom"]', $prefix),
			'variableName' => 'margin',
			'value' => get_theme_mod(
				'bottom_share_box_spacing',
				[
					'mobile' => '30px',
					'tablet' => '50px',
					'desktop' => '70px',
				]
			),
			'unit' => ''
		]);

		blocksy_output_colors([
			'value' => get_theme_mod($prefix . '_share_items_icon_color', []),
			'default' => [
				'default' => [ 'color' => 'var(--color)' ],
				'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			],
			'css' => $css,
			'variables' => [
				'default' => [
					'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-1"]', $prefix),
					'variable' => 'linkInitialColor'
				],

				'hover' => [
					'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-1"]', $prefix),
					'variable' => 'linkHoverColor'
				],
			],
		]);

		blocksy_output_border([
			'css' => $css,
			'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-1"]', $prefix),
			'variableName' => 'border',
			'value' => get_theme_mod($prefix . '_share_items_border', [
				'width' => 1,
				'style' => 'solid',
				'color' => [
					'color' => '#e0e5eb',
				],
			])
		]);
	}

	if ($share_box_type === 'type-2') {
		blocksy_output_colors([
			'value' => get_theme_mod(
				$prefix . '_share_items_icon',
				[]
			),
			'default' => [
				'default' => [ 'color' => '#ffffff' ],
			],
			'css' => $css,
			'variables' => [
				'default' => [
					'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-2"]', $prefix),
					'variable' => 'color'
				],
			],
		]);

		blocksy_output_colors([
			'value' => get_theme_mod($prefix . '_share_items_background', []),
			'default' => [
				'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
				'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			],
			'css' => $css,
			'variables' => [
				'default' => [
					'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-2"]', $prefix),
					'variable' => 'background-color'
				],

				'hover' => [
					'selector' => blocksy_prefix_selector('.ct-share-box[data-type="type-2"]', $prefix),
					'variable' => 'background-color-hover'
				]
			],
		]);
	}
}


// Author Box
if (
	get_theme_mod($prefix . '_has_author_box', 'no') === 'yes'
	&&
	$prefix !== 'single_page'
) {

	$author_box_spacing = get_theme_mod($prefix. '_single_author_box_spacing', '40px');

	if ($author_box_spacing !== '40px') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.author-box', $prefix),
			'variableName' => 'spacing',
			'value' => $author_box_spacing,
			'unit' => ''
		]);
	}


	$author_box_type = get_theme_mod($prefix. '_single_author_box_type', 'type-2');

	if ($author_box_type === 'type-1') {
		blocksy_output_colors([
			'value' => get_theme_mod($prefix . '_single_author_box_background', []),
			'default' => [
				'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			],
			'css' => $css,
			'variables' => [
				'default' => [
					'selector' => blocksy_prefix_selector('.author-box[data-type="type-1"]', $prefix),
					'variable' => 'background-color'
				],
			],
		]);

		blocksy_output_box_shadow([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.author-box[data-type="type-1"]', $prefix),
			'value' => get_theme_mod(
				$prefix . '_single_author_box_shadow',
				blocksy_box_shadow_value([
					'enable' => true,
					'h_offset' => 0,
					'v_offset' => 50,
					'blur' => 90,
					'spread' => 0,
					'inset' => false,
					'color' => [
						'color' => 'rgba(210, 213, 218, 0.4)',
					],
				])
			),
			'responsive' => true
		]);
	}

	if ($author_box_type === 'type-2') {
		blocksy_output_colors([
			'value' => get_theme_mod($prefix . '_single_author_box_border', []),
			'default' => [
				'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			],
			'css' => $css,
			'variables' => [
				'default' => [
					'selector' => blocksy_prefix_selector('.author-box[data-type="type-2"]', $prefix),
					'variable' => 'border-color'
				],
			],
		]);
	}
}

// Posts Navigation
if (
	get_theme_mod($prefix . '_has_post_nav', 'yes') === 'yes'
	&&
	$prefix !== 'single_page'
) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_prefix_selector('.post-navigation', $prefix),
		'variableName' => 'margin',
		'value' => get_theme_mod($prefix . '_post_nav_spacing', [
			'mobile' => '40px',
			'tablet' => '60px',
			'desktop' => '80px',
		]),
		'unit' => ''
	]);

	blocksy_output_colors([
		'value' => get_theme_mod($prefix . '_posts_nav_font_color', []),
		'default' => [
			'default' => [ 'color' => 'var(--color)' ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => blocksy_prefix_selector('.post-navigation', $prefix),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_prefix_selector('.post-navigation', $prefix),
				'variable' => 'linkHoverColor'
			],
		],
	]);
}


// Related Posts
if (
	get_theme_mod($prefix . '_has_related_posts', 'yes') === 'yes'
	&&
	$prefix !== 'single_page'
) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_prefix_selector('.ct-related-posts-container', $prefix),
		'variableName' => 'padding',
		'value' => get_theme_mod(
			$prefix . '_related_posts_container_spacing',
			[
				'mobile' => '30px',
				'tablet' => '50px',
				'desktop' => '70px',
			]
		),
		'unit' => ''
	]);

	blocksy_output_background_css([
		'selector' => blocksy_prefix_selector('.ct-related-posts-container', $prefix),
		'css' => $css,
		'value' => get_theme_mod(
			$prefix . '_related_posts_background',
			blocksy_background_default_value([
				'backgroundColor' => [
					'default' => [
						'color' => '#eff1f5'
					],
				],
			])
		)
	]);

	blocksy_output_colors([
		'value' => get_theme_mod($prefix . '_related_posts_label_color'),
		'default' => [
			'default' => ['color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => blocksy_prefix_selector('.ct-related-posts-container .ct-block-title', $prefix),
				'variable' => 'headingColor'
			],
		],
	]);

	if (function_exists('blocksy_output_responsive_switch')) {
		blocksy_output_responsive_switch([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.ct-related-posts-container', $prefix),
			'value' => get_theme_mod(
				$prefix . '_related_visibility',
				[
					'desktop' => true,
					'tablet' => false,
					'mobile' => false,
				]
			),
			'on' => 'block'
		]);
	}

	if (function_exists('blocksy_output_responsive_switch')) {
		blocksy_output_responsive_switch([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => blocksy_prefix_selector('.ct-related-posts', $prefix),
			'value' => get_theme_mod(
				$prefix . '_related_visibility',
				[
					'desktop' => true,
					'tablet' => false,
					'mobile' => false,
				]
			),
			'on' => 'grid'
		]);
	}

	blocksy_output_colors([
		'value' => get_theme_mod($prefix . '_related_posts_link_color'),
		'default' => [
			'default' => [ 'color' => 'var(--color)' ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => blocksy_prefix_selector('.related-entry-title', $prefix),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_prefix_selector('.related-entry-title', $prefix),
				'variable' => 'linkHoverColor'
			],
		],
	]);

	blocksy_output_colors([
		'value' => get_theme_mod($prefix . '_related_posts_meta_color'),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => blocksy_prefix_selector('.ct-related-posts .entry-meta', $prefix),
				'variable' => 'color'
			],

			'hover' => [
				'selector' => blocksy_prefix_selector('.ct-related-posts .entry-meta', $prefix),
				'variable' => 'linkHoverColor'
			],
		],
	]);

	blocksy_output_spacing([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_prefix_selector('.ct-related-posts .ct-image-container', $prefix),
		'property' => 'borderRadius',
		'value' => get_theme_mod($prefix . '_related_thumb_radius',
			blocksy_spacing_value([
				'linked' => true,
			])
		)
	]);


	$relatedNarrowWidth = get_theme_mod($prefix . '_related_narrow_width', 750 );

	if ($relatedNarrowWidth !== 750) {
		$css->put(
			blocksy_prefix_selector('.ct-related-posts-container', $prefix),
			'--narrow-container-max-width: ' . $relatedNarrowWidth . 'px'
		);
	}
}
