<?php
/**
 * Page title options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

if (! isset($has_hero_type)) {
	$has_hero_type = true;
}

if (! isset($enabled_label)) {
	$enabled_label = __('Page Title', 'blocksy');
}

if (! isset($enabled_default)) {
	$enabled_default = 'yes';
}

if (! isset($is_cpt)) {
	$is_cpt = false;
}

if (! isset($is_bbpress)) {
	$is_bbpress = false;
}

if (! isset($is_woo)) {
	$is_woo = false;
}

if (! isset($is_page)) {
	$is_page = false;
}

if (! isset($is_author)) {
	$is_author = false;
}

if (! isset($has_default)) {
	$has_default = false;
}

if (! isset($is_home)) {
	$is_home = false;
}

if (! isset($is_single)) {
	$is_single = false;
}

if (! isset($is_search)) {
	$is_search = false;
}

if (! isset($is_archive)) {
	$is_archive = false;
}

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

$custom_description_layer_name = __('Description', 'blocksy');

if ($is_author) {
	$custom_description_layer_name = __('Bio', 'blocksy');
}

if (
	(
		$is_single || $is_home
	) && !$is_bbpress
) {
	$custom_description_layer_name = __('Excerpt', 'blocksy');
}

if ($is_search) {
	$custom_description_layer_name = __('Subtitle', 'blocksy');
}

$default_hero_elements = [];

$default_hero_elements[] = array_merge([
	'id' => 'custom_title',
	'enabled' => $prefix !== 'product_',
	'heading_tag' => 'h1',
	'title' => __('Home', 'blocksy')
], (
	$is_author ? [
		'has_author_avatar' => 'yes',
		'author_avatar_size' => 60
	] : []
));

$default_hero_elements[] = [
	'id' => 'custom_description',
	'enabled' => $prefix !== 'product_',
	'description_visibility' => [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]
];

if (
	(
		$is_single || $is_author
	) && !$is_bbpress
) {
	$default_hero_elements[] = [
		'id' => 'custom_meta',
		'enabled' => ! $is_page && $prefix !== 'product_',
		'meta_elements' => blocksy_post_meta_defaults([
			[
				'id' => 'author',
				'has_author_avatar' => 'yes',
				'enabled' => true,
			],

			[
				'id' => 'post_date',
				'enabled' => true,
			],

			[
				'id' => 'comments',
				'enabled' => true,
			],

			[
				'id' => 'categories',
				'enabled' => ! $is_page,
			],
		]),
		'page_meta_elements' => [
			'joined' => true,
			'articles_count' => true,
			'comments' => true
		]
	];
}

if ($is_author) {
	$default_hero_elements[] = [
		'id' => 'author_social_channels',
		'enabled' => true
	];
}

$default_hero_elements[] = [
	'id' => 'breadcrumbs',
	'enabled' => $prefix === 'product_',
];

$when_enabled_general_settings = [
	$has_hero_type ? [
		$prefix . 'hero_section' => [
			'label' => $has_default ? __('Type', 'blocksy') : false,
			'type' => 'ct-image-picker',
			'value' => ($is_woo || $is_author) ? 'type-2' : 'type-1',
			'design' => 'block',
			'sync' => blocksy_sync_whole_page([
				'prefix' => $prefix,
			]),
			'choices' => [
				'type-1' => [
					'src' => blocksy_image_picker_url('hero-type-1.svg'),
					'title' => __('Type 1', 'blocksy'),
				],

				'type-2' => [
					'src' => blocksy_image_picker_url('hero-type-2.svg'),
					'title' => __('Type 2', 'blocksy'),
				],
			],
		],
	] : [
		$prefix . 'hero_section' => [
			'type' => 'hidden',
			'value' => ($is_woo || $is_author) ? 'type-2' : 'type-1',
		]
	],

	[

		$prefix . 'hero_elements' => [
			'label' => __('Elements', 'blocksy'),
			'type' => 'ct-layers',
			'attr' => [ 'data-layers' => 'title-elements' ],
			'design' => 'block',
			'value' => $default_hero_elements,

			'sync' => [
				[
					'selector' => '.hero-section',
					'container_inclusive' => true,
					'prefix' => $prefix,
					'render' => function ($args) {
						echo blocksy_output_hero_section([
							'type' => get_theme_mod(
								$args['prefix'] . '_hero_section',
								'type-1'
							)
						]);
					}
				],

				[
					'prefix' => $prefix,
					'id' => $prefix . 'hero_elements_heading_tag',
					'loader_selector' => '.page-title',
				],

				[
					'prefix' => $prefix,
					'id' => $prefix . 'hero_elements_meta_first',
					'loader_selector' => '.entry-meta:1'
				],

				[
					'prefix' => $prefix,
					'id' => $prefix . 'hero_elements_meta_second',
					'loader_selector' => '.entry-meta:2'
				],

				[
					'prefix' => $prefix,
					'id' => $prefix . 'hero_elements_spacing',
					'loader_selector' => 'skip',
				],

				[
					'prefix' => $prefix,
					'id' => $prefix . 'hero_elements_author_avatar',
					'loader_selector' => '.ct-author-name',
				]
			],

			'settings' => [
				'breadcrumbs' => [
					'label' => __('Breadcrumbs', 'blocksy'),
					'options' => [
						'hero_item_spacing' => [
							'label' => __( 'Top Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => 20,
							'min' => 0,
							'max' => 100,
							'responsive' => true,
							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],
					],
				],

				'custom_title' => [
					'label' => $is_author ? __( 'Name & Avatar', 'blocksy' ) : __('Title', 'blocksy'),
					'options' => [
						[
							'heading_tag' => [
								'label' => __('Heading tag', 'blocksy'),
								'type' => 'ct-select',
								'value' => 'h1',
								'view' => 'text',
								'design' => 'inline',
								'sync' => [
									'id' => $prefix . 'hero_elements_heading_tag',
								],
								'choices' => blocksy_ordered_keys(
									[
										'h1' => 'H1',
										'h2' => 'H2',
										'h3' => 'H3',
										'h4' => 'H4',
										'h5' => 'H5',
										'h6' => 'H6',
									]
								),
							],
						],

						[
							$is_home ? [
								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => ['show_on_front' => 'posts'],
									'values_source' => 'global',
									'options' => [
										'title' => [
											'label' => __('Title', 'blocksy'),
											'type' => 'text',
											'value' => __('Home', 'blocksy'),
											'disableRevertButton' => true,
											'design' => 'inline',
										],
									]
								],
							] : []
						],

						[
							($is_archive || $is_bbpress) ? [
								'has_category_label' => [
									'label' => __('Category Label', 'blocksy'),
									'type' => 'ct-switch',
									'value' => 'yes',
								]
							] : []
						],

						[
							$is_author ? [
								blocksy_rand_md5() => [
									'type' => 'ct-group',
									'attr' => [ 'data-columns' => '1' ],
									'options' => [
										'has_author_avatar' => [
											'label' => __('Author avatar', 'blocksy'),
											'type' => 'ct-switch',
											'value' => 'yes',
											'sync' => [
												'id' => $prefix . 'hero_elements_author_avatar',
											],
										],

										blocksy_rand_md5() => [
											'type' => 'ct-condition',
											'condition' => [ 'has_author_avatar' => 'yes' ],
											'options' => [
												'author_avatar_size' => [
													'label' => __( 'Avatar Size', 'blocksy' ),
													'type' => 'ct-number',
													'design' => 'inline',
													'value' => 60,
													'min' => 15,
													'max' => 100,
													'sync' => [
														'id' => $prefix . 'hero_elements_spacing',
													],
												],
											],
										],

									],
								],
							] : []
						],

						'hero_item_spacing' => [
							'label' => __( 'Top Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => 20,
							'min' => 0,
							'max' => 100,
							'responsive' => true,
							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],
					],
				],

				'custom_description' => [
					'label' => $custom_description_layer_name,
					'options' => [
						[
							$is_home ? [
								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'show_on_front' => 'posts' ],
									'values_source' => 'global',
									'options' => [
										'description' => [
											'label' => false,
											'type' => 'textarea',
											'value' => '',
											'disableRevertButton' => true,
											'design' => 'block',
										],
									]
								],
							] : []
						],

						'description_visibility' => [
							'label' => __( 'Visibility', 'blocksy' ),
							'type' => 'ct-visibility',
							'design' => 'block',

							'value' => [
								'desktop' => true,
								'tablet' => true,
								'mobile' => false,
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blocksy' ),
								'tablet' => __( 'Tablet', 'blocksy' ),
								'mobile' => __( 'Mobile', 'blocksy' ),
							]),

							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],

						'hero_item_spacing' => [
							'label' => __( 'Top Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => 20,
							'min' => 0,
							'max' => 100,
							'responsive' => true,
							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],
					],
				],

				'custom_meta' => [
					// 'label' => __('Post Meta', 'blocksy'),
					'label' => $is_author ? __( 'Author Meta', 'blocksy' ) : __('Post Meta', 'blocksy'),
					'clone' => true,
					'sync' => [
						'id' => $prefix . 'hero_elements_meta'
					],
					'options' => [
						$is_author ? [
							'page_meta_elements' => [
								'label' => __( 'Meta Elements', 'blocksy' ),
								'type' => 'ct-checkboxes',
								'design' => 'block',
								'attr' => [ 'data-columns' => '2' ],
								'allow_empty' => true,
								'choices' => blocksy_ordered_keys(
									[
										'joined' => __( 'Joined Date', 'blocksy' ),
										'articles_count' => __( 'Articles', 'blocksy' ),
										'comments' => __( 'Comments', 'blocksy' ),
									]
								),

								'value' => [
									'joined' => true,
									'articles_count' => true,
									'comments' => true
								],
							],
						] : [],

						[
							$is_single ? [
								blocksy_get_options('general/meta', [
									'skip_sync_id' => [
										'id' => $prefix . 'hero_elements_spacing',
									],
									'is_page' => $is_page,
									'is_cpt' => $is_cpt
								])
							] : []
						],

						'hero_item_spacing' => [
							'label' => __( 'Top Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => 20,
							'min' => 0,
							'max' => 100,
							'responsive' => true,
							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],
					],
				],

				'author_social_channels' => [
					'label' => __('Social Channels', 'blocksy'),
					'options' => [
						'hero_item_spacing' => [
							'label' => __( 'Top Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => 20,
							'min' => 0,
							'max' => 100,
							'responsive' => true,
							'sync' => [
								'id' => $prefix . 'hero_elements_spacing',
							],
						],
					],
				],
			]
		],

		blocksy_rand_md5() => [
			'type' => 'ct-divider',
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [ $prefix . 'hero_section' => 'type-1' ],
			'options' => [

				$prefix . 'hero_alignment1' => [
					'type' => 'ct-radio',
					'label' => __( 'Horizontal Alignment', 'blocksy' ),
					'value' => apply_filters(
						'blocksy:hero:type-1:default-alignment',
						'left',
						trim($prefix, '_')
					),
					'view' => 'text',
					'attr' => [ 'data-type' => 'alignment' ],
					'responsive' => true,
					'design' => 'block',
					'sync' => 'live',
					'choices' => [
						'left' => '',
						'center' => '',
						'right' => '',
					],
				],

				$prefix . 'hero_margin' => [
					'label' => __( 'Container Bottom Spacing', 'blocksy' ),
					'type' => 'ct-slider',
					'value' => [
						'desktop' => 50,
						'tablet' => 30,
						'mobile' => 30,
					],
					'min' => 0,
					'max' => 300,
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
				],
			],
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [ $prefix . 'hero_section' => 'type-2' ],
			'options' => array_merge([

				$prefix . 'hero_alignment2' => [
					'type' => 'ct-radio',
					'label' => __( 'Horizontal Alignment', 'blocksy' ),
					'value' => 'center',
					'view' => 'text',
					'attr' => [ 'data-type' => 'alignment' ],
					'responsive' => true,
					'design' => 'block',
					'sync' => 'live',
					'choices' => [
						'left' => '',
						'center' => '',
						'right' => '',
					],
				],

				$prefix . 'hero_vertical_alignment' => [
					'type' => 'ct-radio',
					'label' => __( 'Vertical Alignment', 'blocksy' ),
					'value' => 'center',
					'view' => 'text',
					'design' => 'block',
					'responsive' => true,
					'attr' => [ 'data-type' => 'vertical-alignment' ],
					'sync' => 'live',

					'choices' => [
						'flex-start' => '',
						'center' => '',
						'flex-end' => '',
					],
				],
			]),
		],

	],

	[

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [ $prefix . 'hero_section' => 'type-2' ],
			'options' => [

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				$prefix . 'hero_structure' => [
					'label' => __( 'Container Width', 'blocksy' ),
					'type' => 'ct-radio',
					'value' => 'narrow',
					'view' => 'text',
					'design' => 'block',
					'sync' => 'live',
					'choices' => [
						'normal' => __( 'Default', 'blocksy' ),
						'narrow' => __( 'Narrow', 'blocksy' ),
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				$prefix . 'page_title_bg_type' => [
					'label' => __( 'Container Background Image', 'blocksy' ),
					'type' => 'ct-radio',
					'value' => ($is_archive || $is_author || $is_search) ? 'color' : 'featured_image',
					'view' => 'text',
					'design' => 'block',
					'attr' => [ 'data-radio-text' => 'small' ],
					'choices' => array_merge(($is_archive || $is_author || $is_search) ? [] : [
						'featured_image' => __( 'Featured', 'blocksy' ),
					], [
						'custom_image' => __( 'Custom', 'blocksy' ),
						'color' => __( 'None', 'blocksy' ),
					]),
					'sync' => [
						'id' => $prefix . 'hero_elements',
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [
						$prefix . 'page_title_bg_type' => 'custom_image'
					],
					'options' => [
						$prefix . 'custom_hero_background' => [
							'label' => __('Custom Image', 'blocksy'),
							'type' => 'ct-image-uploader',
							'design' => false,
							'value' => [ 'attachment_id' => null ],
							'emptyLabel' => __('Select Image', 'blocksy'),
							'filledLabel' => __('Change Image', 'blocksy'),
							'sync' => [
								'id' => $prefix . 'hero_elements',
							],
						],
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [
						$prefix . 'page_title_bg_type' => 'custom_image | featured_image',
					],
					'options' => [
						$prefix . 'parallax' => [
							'label' => __( 'Parallax Effect', 'blocksy' ),
							'desc' => __( 'Choose for which devices you want to enable the parallax effect.', 'blocksy' ),
							'type' => 'ct-visibility',
							'design' => 'block',
							'allow_empty' => true,
							'sync' => 'live',
							'value' => [
								'desktop' => false,
								'tablet' => false,
								'mobile' => false,
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blocksy' ),
								'tablet' => __( 'Tablet', 'blocksy' ),
								'mobile' => __( 'Mobile', 'blocksy' ),
							]),
						],
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				$prefix . 'hero_height' => [
					'label' => __( 'Container Height', 'blocksy' ),
					'type' => 'ct-slider',
					'value' => '250px',
					'design' => 'block',
					'units' => blocksy_units_config([
						[
							'unit' => 'px',
							'min' => 50,
							'max' => 1000,
						],
					]),
					'responsive' => true,
					'sync' => 'live'
				],
			],
		],
	],
];

$when_enabled_design_settings = [
	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			$prefix . 'hero_elements:array-ids:custom_title:enabled' => 'true',
		],
		'options' => [
			$prefix . 'pageTitleFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Title Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => [
						'desktop' => '32px',
						'tablet'  => '30px',
						'mobile'  => '25px'
					],
				]),
				'design' => 'block',
				'sync' => 'live'
			],

			$prefix . 'pageTitleFontColor' => [
				'label' => __( 'Title Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'sync' => 'live',

				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
						'inherit' => 'var(--headingColor)'
					],
				],
			],
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'all' => [
				$prefix . 'hero_elements:array-ids:custom_meta:enabled' => 'true',
				'any' => [
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/author' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/comments' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/date' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/updated' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/categories' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:single_meta_elements/tags' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:page_meta_elements/joined' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:page_meta_elements/articles_count' => 'true',
					$prefix . 'hero_elements:array-ids:custom_meta:page_meta_elements/comments' => 'true',
				]
			],
		],

		'options' => [
			$prefix . 'pageMetaFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Meta Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n6',
					'line-height' => '1.3',
					'text-transform' => 'uppercase',
				]),
				'design' => 'block',
				'sync' => 'live'
			],

			$prefix . 'pageMetaFontColor' => [
				'label' => __( 'Meta Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'sync' => 'live',

				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
						'inherit' => 'var(--color)'
					],

					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
						'inherit' => 'var(--linkHoverColor)'
					],
				],
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'all' => [
				$prefix . 'hero_elements:array-ids:custom_description:enabled' => 'true',
				'any' => [
					$prefix . 'hero_elements:array-ids:custom_description:description_visibility/desktop' => 'true',
					$prefix . 'hero_elements:array-ids:custom_description:description_visibility/tablet' => 'true',
					$prefix . 'hero_elements:array-ids:custom_description:description_visibility/mobile' => 'true',
				]
			]
		],
		'options' => [
			$prefix . 'pageExcerptFont' => [
				'type' => 'ct-typography',
				'label' => $is_single ? __( 'Excerpt Font', 'blocksy' ) : __(
					'Description Font', 'blocksy'
				),
				'value' => blocksy_typography_default_values([
					// 'variation' => 'n5',
				]),
				'design' => 'block',
				'sync' => 'live'
			],

			$prefix . 'pageExcerptColor' => [
				'label' => $is_single ? __( 'Excerpt Font Color', 'blocksy' ) : __(
					'Description Font Color', 'blocksy'
				),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'sync' => 'live',

				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
						'inherit' => 'var(--color)'
					],
				],
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			$prefix . 'hero_elements:array-ids:breadcrumbs:enabled' => 'true',
		],
		'options' => [
			$prefix . 'breadcrumbsFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Breadcrumbs Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n6',
					'text-transform' => 'uppercase',
				]),
				'design' => 'block',
				'sync' => 'live'
			],

			$prefix . 'breadcrumbsFontColor' => [
				'label' => __( 'Breadcrumbs Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'sync' => 'live',

				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],

					'initial' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Text', 'blocksy' ),
						'id' => 'default',
						'inherit' => 'var(--color)'
					],

					[
						'title' => __( 'Link Initial', 'blocksy' ),
						'id' => 'initial',
						'inherit' => 'var(--linkInitialColor)'
					],

					[
						'title' => __( 'Link Hover', 'blocksy' ),
						'id' => 'hover',
						'inherit' => 'var(--linkHoverColor)'
					],
				],
			],
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			$prefix . 'hero_section' => 'type-2'
		],
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ $prefix . 'page_title_bg_type' => '!color' ],
				'options' => [

					$prefix . 'pageTitleOverlay' => [
						'label' => __( 'Image Overlay Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',
						'sync' => 'live',

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial color', 'blocksy' ),
								'id' => 'default',
							],
						],
					],

				],
			],

			$prefix . 'pageTitleBackground' => [
				'label' => __( 'Container Background', 'blocksy' ),
				'type' => 'ct-background',
				'design' => 'inline',
				'sync' => 'live',
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => '#EDEFF2'
						],
					],
				])
			],

		],
	],
];

$when_enabled_settings = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => $when_enabled_general_settings
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => $when_enabled_design_settings
	],
];

$options_when_not_default = [
	$prefix . 'hero_enabled' => [
		'label' => $enabled_label,
		'type' => 'ct-panel',
		'switch' => true,
		'value' => $enabled_default,
		'wrapperAttr' => ['data-label' => 'heading-label'],
		'sync' => blocksy_sync_whole_page([
			'prefix' => $prefix,
		]),
		'inner-options' => $when_enabled_settings
	]
];

// options output for posts/pages
$options_when_default = [
	$prefix . 'has_hero_section' => [
		// 'label' => $is_page ? __('Page Title', 'blocksy') : __(
		// 	'Post Title', 'blocksy'
		// ),
		'label' => false,
		'type' => 'ct-radio',
		'value' => 'default',
		'view' => 'text',
		'disableRevertButton' => true,
		'design' => $is_single ? 'block' : 'inline',
		'wrapperAttr' => [ 'data-spacing' => 'custom' ],
		'choices' => [
			'default' => __( 'Inherit', 'blocksy' ),
			'enabled' => __( 'Custom', 'blocksy' ),
			'disabled' => __( 'Disabled', 'blocksy' ),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ $prefix . 'has_hero_section' => 'default' ],
		'options' => [
			blocksy_rand_md5() => [
				'type' => 'ct-notification',
				'attr' => [ 'data-spacing' => 'custom' ],
				'text' => __( 'By default these options are inherited from Customizer options.', 'blocksy' ),
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [$prefix . 'has_hero_section' => 'enabled'],
		'options' => $when_enabled_settings
	],
];

// options output for taxonomies
if (! $is_single) {
	$options_when_default = [
		blocksy_rand_md5() => [
			'title' => __( 'General', 'blocksy' ),
			'type' => 'tab',
			'options' => [
				$prefix . 'has_hero_section' => [
					'label' => __('Page Title', 'blocksy'),
					'type' => 'ct-radio',
					'value' => 'default',
					'view' => 'text',
					'disableRevertButton' => true,
					'design' => $is_single ? 'block' : 'inline',
					'wrapperAttr' => [ 'data-spacing' => 'custom' ],
					'choices' => [
						'default' => __( 'Inherit', 'blocksy' ),
						'enabled' => __( 'Custom', 'blocksy' ),
						'disabled' => __( 'Disabled', 'blocksy' ),
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [$prefix . 'has_hero_section' => 'enabled'],
					'options' => $when_enabled_general_settings
				],
			]
		],

		blocksy_rand_md5() => [
			'title' => __( 'Design', 'blocksy' ),
			'type' => 'tab',
			'options' => [

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [$prefix . 'has_hero_section' => 'enabled'],
					'options' => $when_enabled_design_settings
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [$prefix . 'has_hero_section' => '!enabled'],
					'options' => [
						blocksy_rand_md5() => [
							'type' => 'ct-notification',
							'attr' => ['data-label' => 'no-label'],
							'text' => __('Options will appear here only if you will set Custom in Page Title option.', 'blocksy')
						]
					]
				],
			]
		],
	];
}

$options = $has_default ? $options_when_default : $options_when_not_default;

