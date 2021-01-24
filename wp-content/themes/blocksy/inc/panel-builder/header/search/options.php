<?php

$cpt_choices = [
	'post' => __('Posts', 'blocksy'),
	'page' => __('Pages', 'blocksy'),
	'product' => __('Products', 'blocksy')
];

$cpt_options = [
	'post' => true,
	'page' => true,
	'product' => true
];

foreach (blocksy_manager()->post_types->get_supported_post_types() as $single_cpt) {
	if (get_post_type_object($single_cpt)) {
		$cpt_choices[$single_cpt] = get_post_type_labels(
			get_post_type_object($single_cpt)
		)->singular_name;
	} else {
		$cpt_choices[$single_cpt] = ucfirst($single_cpt);
	}

	$cpt_options[$single_cpt] = true;
}

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'searchHeaderIconSize' => [
				'label' => __( 'Icon Size', 'blocksy' ),
				'type' => 'ct-slider',
				'min' => 5,
				'max' => 50,
				'value' => 15,
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __('Search Through Criteria', 'blocksy'),
				'desc' => __(
					'Chose in which post types do you want to perform searches.',
					'blocksy'
				)
			],

			'search_through' => [
				'label' => false,
				'type' => 'ct-checkboxes',
				'attr' => ['data-columns' => '2'],
				'disableRevertButton' => true,
				'choices' => blocksy_ordered_keys($cpt_choices),
				'value' => $cpt_options
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Icon Color', 'blocksy' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'searchHeaderIconColor',
						'label' => __('Default State', 'blocksy')
					],

					[
						'id' => 'transparentSearchHeaderIconColor',
						'label' => __('Transparent State', 'blocksy'),
						'condition' => [
							'builderSettings/has_transparent_header' => 'yes',
						],
					],


					[
						'id' => 'stickySearchHeaderIconColor',
						'label' => __('Sticky State', 'blocksy'),
						'condition' => [
							'builderSettings/has_sticky_header' => 'yes',
						],
					],	
				],
				'options' => [

					'searchHeaderIconColor' => [
						'label' => __( 'Icon Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'var(--color)',
							],

							'hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],

					'transparentSearchHeaderIconColor' => [
						'label' => __( 'Icon Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'stickySearchHeaderIconColor' => [
						'label' => __( 'Icon Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],
				],
			],

			'headerSearchMargin' => [
				'label' => __( 'Icon Margin', 'blocksy' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'searchHeaderLinkColor' => [
				'label' => __( 'Modal Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => '#ffffff',
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
						'inherit' => 'var(--linkHoverColor)'
					],
				],
			],

			'search_close_button_color' => [
				'label' => __( 'Close Icon Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

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
						'inherit' => 'rgba(255, 255, 255, 0.7)'
					],

					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
						'inherit' => '#ffffff'
					],
				],
			],

			'search_close_button_shape_color' => [
				'label' => __( 'Close Icon Background', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

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
						'inherit' => 'rgba(0, 0, 0, 0.5)'
					],

					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
						'inherit' => 'rgba(0, 0, 0, 0.5)'
					],
				],
			],

			'searchHeaderBackground' => [
				'label' => __( 'Modal Background', 'blocksy' ),
				'type'  => 'ct-background',
				'design' => 'inline',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => 'rgba(18, 21, 25, 0.98)'
						],
					],
				])
			],

		],
	],


	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'wp_customizer_current_view' => 'mobile' ],
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'header_search_visibility' => [
				'label' => __( 'Item Visibility', 'blocksy' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'allow_empty' => true,
				'value' => [
					'tablet' => true,
					'mobile' => true,
				],

				'choices' => blocksy_ordered_keys([
					'tablet' => __( 'Tablet', 'blocksy' ),
					'mobile' => __( 'Mobile', 'blocksy' ),
				]),
			],

		],
	],
];
