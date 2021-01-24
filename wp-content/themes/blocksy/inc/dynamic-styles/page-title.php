<?php

$page_title_source = blocksy_get_page_title_source();

if (! $page_title_source) {
	return;
}

$default_type = 'type-1';

$default_hero_elements = [];

$default_hero_elements[] = [
	'id' => 'custom_title',
	'enabled' => true,
];

$default_hero_elements[] = [
	'id' => 'custom_description',
	'enabled' => true,
];

if (is_singular() || is_author()) {
	$default_hero_elements[] = [
		'id' => 'custom_meta',
		'enabled' => true,
	];
}

if (is_author()) {
	$default_hero_elements[] = [
		'id' => 'author_social_channels',
		'enabled' => true,
	];
}

$default_hero_elements[] = [
	'id' => 'breadcrumbs',
	'enabled' => false,
];

$hero_elements = blocksy_akg_or_customizer(
	'hero_elements',
	blocksy_get_page_title_source(),
	$default_hero_elements
);

if (
	blocksy_get_page_title_source()['strategy'] === 'customizer'
	&& (
		blocksy_get_page_title_source()['prefix'] === 'woo_categories'
		||
		blocksy_get_page_title_source()['prefix'] === 'author'
	)
) {
	$default_type = 'type-2';
}

if (
	((
		function_exists('is_woocommerce')
		&&
		(
			is_product_category()
			||
			is_product_tag()
			||
			is_shop()
		)
	) || is_author())
	&&
	isset($page_title_source['strategy'])
	&&
	$page_title_source['strategy'] === 'customizer'
) {
	$default_type = 'type-2';
}

$type = blocksy_akg_or_customizer(
	'hero_section',
	$page_title_source,
	$default_type
);

$hero_elements = blocksy_akg_or_customizer(
	'hero_elements',
	blocksy_get_page_title_source(),
	$default_hero_elements
);

// title
blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'pageTitleFont',
		$page_title_source,
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '32px',
				'tablet'  => '30px',
				'mobile'  => '25px'
			],
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-header .page-title'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer( 'pageTitleFontColor', $page_title_source ),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-header .page-title',
			'variable' => 'headingColor'
		],
	],
]);


// meta
blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'pageMetaFont',
		$page_title_source,
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n6',
			'line-height' => '1.5',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-header .entry-meta'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer( 'pageMetaFontColor', $page_title_source ),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-header .entry-meta',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.entry-header .entry-meta',
			'variable' => 'linkHoverColor'
		],
	],
]);

// excerpt
blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'pageExcerptFont',
		$page_title_source,
		blocksy_typography_default_values([
			// 'variation' => 'n5',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-header .page-description'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer( 'pageExcerptColor', $page_title_source ),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-header .page-description',
			'variable' => 'color'
		],
	],
]);

// breadcrumbs
blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'breadcrumbsFont',
		$page_title_source,
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n6',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-header .ct-breadcrumbs'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer( 'breadcrumbsFontColor', $page_title_source ),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'initial' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-header .ct-breadcrumbs',
			'variable' => 'color'
		],

		'initial' => [
			'selector' => '.entry-header .ct-breadcrumbs',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.entry-header .ct-breadcrumbs',
			'variable' => 'linkHoverColor'
		],
	],
]);

if ($type === 'type-1') {
	$hero_alignment1 = blocksy_akg_or_customizer(
		'hero_alignment1',
		$page_title_source,
		apply_filters(
			'blocksy:hero:type-1:default-alignment',
			'left',
			blocksy_manager()->screen->get_prefix()
		)
	);

	if ($hero_alignment1 !== 'left') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => '.hero-section[data-type="type-1"]',
			'variableName' => 'alignment',
			'unit' => '',
			'value' => $hero_alignment1,
		]);
	}

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.hero-section[data-type="type-1"]',
		'variableName' => 'margin-bottom',
		'value' => blocksy_akg_or_customizer('hero_margin', $page_title_source, [
			'desktop' => 50,
			'tablet' => 30,
			'mobile' => 30,

		])
	]);
}


if ($type === 'type-2') {

	$template_args = apply_filters('blocksy:header:item-template-args', []);

	if (
		isset($template_args['has_transparent_header'])
		&&
		$template_args['has_transparent_header']
	) {
		$render = new Blocksy_Header_Builder_Render();
		$header_height = $render->get_header_height();

		if (! in_array('desktop', $template_args['has_transparent_header'])) {
			$header_height['desktop'] = 0;
		}

		if (! in_array('mobile', $template_args['has_transparent_header'])) {
			$header_height['tablet'] = 0;
			$header_height['mobile'] = 0;
		}

		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => ':root',
			'variableName' => 'headerHeight',
			'value' => $header_height
		]);
	}

	$hero_alignment2 = blocksy_akg_or_customizer('hero_alignment2', $page_title_source, 'center');

	if ($hero_alignment2 !== 'center') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => '.hero-section[data-type="type-2"]',
			'variableName' => 'alignment',
			'unit' => '',
			'value' => $hero_alignment2,
		]);
	}

	$hero_vertical_alignment = blocksy_akg_or_customizer('hero_vertical_alignment', $page_title_source, 'center');

	if ($hero_vertical_alignment !== 'center') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => '.hero-section[data-type="type-2"]',
			'variableName' => 'vertical-alignment',
			'unit' => '',
			'value' => $hero_vertical_alignment,
		]);
	}

	// height
	$hero_height = blocksy_akg_or_customizer('hero_height', $page_title_source, '250px');

	if ($hero_height !== '250px') {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => '.hero-section[data-type="type-2"]',
			'variableName' => 'min-height',
			'unit' => '',
			'value' => $hero_height,
		]);
	}

	// overlay color
	blocksy_output_colors([
		'value' => blocksy_akg_or_customizer(
			'pageTitleOverlay',
			$page_title_source
		),
		'default' => [
			'default' => ['color' => Blocksy_Css_Injector::get_skip_rule_keyword()]
		],
		'css' => $css,
		'variables' => [
			'default' => [
				'selector' => '.hero-section[data-type="type-2"]',
				'variable' => 'page-title-overlay'
			],
		],
	]);

	// background
	blocksy_output_background_css([
		'selector' => '.hero-section[data-type="type-2"]',
		'css' => $css,
		'value' => blocksy_akg_or_customizer('pageTitleBackground', $page_title_source,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => '#EDEFF2'
				],
			],
		])
		)
	]);
}

$selectors_map = [
	// custom_meta is a bit specially handled
	'author_social_channels' => '.hero-section .author-box-social',
	'custom_description' => '.hero-section .page-description',
	'custom_title' => '.hero-section .page-title, .hero-section .ct-author-name',
	'breadcrumbs' => '.hero-section .ct-breadcrumbs',
	'custom_meta' => '.hero-section .entry-meta'
];

$meta_indexes = [
	'first' => null,
	'second' => null
];

foreach ($hero_elements as $index => $single_hero_element) {
	if (! isset($single_hero_element['enabled'])) {
		continue;
	}

	if ($single_hero_element['id'] === 'custom_meta') {
		if ($meta_indexes['first'] === null) {
			$meta_indexes['first'] = $index;
		} else {
			$meta_indexes['second'] = $index;
		}
	}
}

foreach ($hero_elements as $index => $single_hero_element) {
	if (! $single_hero_element['enabled']) {
		continue;
	}

	if (
		$single_hero_element['id'] === 'custom_meta'
		&&
		$index === $meta_indexes['second']
	) {
		$selectors_map['custom_meta'] = '.entry-meta[data-id="second"]';
	}

	$hero_item_spacing = blocksy_akg('hero_item_spacing', $single_hero_element, 20);

	if (intval($hero_item_spacing) !== 20) {
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => $selectors_map[$single_hero_element['id']],
			'variableName' => 'itemSpacing',
			'value' => $hero_item_spacing
		]);
	}
}

