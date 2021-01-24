<?php

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'mobile_menu_trigger_type' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'type-1',
				'attr' => [
					'data-columns' => '3',
					'data-ratio' => '2:1',
				],
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [

					'type-1' => [
						'src'   => blocksy_image_picker_file( 'trigger-1' ),
						'title' => __( 'Type 1', 'blocksy' ),
					],

					'type-2' => [
						'src'   => blocksy_image_picker_file( 'trigger-2' ),
						'title' => __( 'Type 2', 'blocksy' ),
					],

					'type-3' => [
						'src'   => blocksy_image_picker_file( 'trigger-3' ),
						'title' => __( 'Type 3', 'blocksy' ),
					],
				],
			],

			'trigger_design' => [
				'type' => 'ct-radio',
				'label' => __( 'Trigger Design', 'blocksy' ),
				'value' => 'simple',
				'view' => 'text',
				'design' => 'block',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],

				'choices' => [
					'simple' => __( 'Simple', 'blocksy' ),
					'outline' => __( 'Outline', 'blocksy' ),
					'solid' => __( 'Solid', 'blocksy' ),
				],
			],

			'has_trigger_label' => [
				'label' => __( 'Trigger Label', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_trigger_label' => 'yes' ],
				'options' => [

					'trigger_label' => [
						'label' => __( 'Label Text', 'blocksy' ),
						'type' => 'text',
						'design' => 'inline',
						'value' => __( 'Menu', 'blocksy' ),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'trigger_label_alignment' => [
						'type' => 'ct-radio',
						'label' => __( 'Label Alignment', 'blocksy' ),
						'value' => 'right',
						'view' => 'text',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],

						'choices' => [
							'left' => __( 'Left', 'blocksy' ),
							'right' => __( 'Right', 'blocksy' ),
						],
					],

				],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Trigger Color', 'blocksy' ),
				'choices' => [
					[
						'id' => 'triggerIconColor',
						'label' => __('Default State', 'blocksy')
					],

					[
						'id' => 'transparentTriggerIconColor',
						'label' => __('Transparent State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'stickyTriggerIconColor',
						'label' => __('Sticky State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'triggerIconColor' => [
						'label' => __( 'Trigger Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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

					'transparentTriggerIconColor' => [
						'label' => __( 'Trigger Color', 'blocksy' ),
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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'stickyTriggerIconColor' => [
						'label' => __( 'Trigger Color', 'blocksy' ),
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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => [
					__('Border Color', 'blocksy') => [
						'trigger_design' => 'outline'
					],

					__('Background Color', 'blocksy') => [
						'trigger_design' => 'solid'
					]
				],
				'divider' => 'top',
				'choices' => [
					[
						'id' => 'triggerSecondColor',
						'label' => __('Default State', 'blocksy'),
						'condition' => [ 'trigger_design' => '!simple' ],
					],

					[
						'id' => 'transparentTriggerSecondColor',
						'label' => __('Transparent State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'trigger_design' => '!simple',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'stickyTriggerSecondColor',
						'label' => __('Sticky State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'trigger_design' => '!simple',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'triggerSecondColor' => [
						'label' => __( 'Trigger Border Color', 'blocksy' ),
						'label' => [
							__('Border Color', 'blocksy') => [
								'trigger_design' => 'outline'
							],

							__('Background Color', 'blocksy') => [
								'trigger_design' => 'solid'
							]
						],
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => '#eeeeee',
							],

							'hover' => [
								'color' => '#eeeeee',
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

					'transparentTriggerSecondColor' => [
						'label' => __( 'Trigger Border Color', 'blocksy' ),
						'label' => [
							__('Border Color', 'blocksy') => [
								'trigger_design' => 'outline'
							],

							__('Background Color', 'blocksy') => [
								'trigger_design' => 'solid'
							]
						],
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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'stickyTriggerSecondColor' => [
						'label' => __( 'Trigger Border Color', 'blocksy' ),
						'label' => [
							__('Border Color', 'blocksy') => [
								'trigger_design' => 'outline'
							],

							__('Background Color', 'blocksy') => [
								'trigger_design' => 'solid'
							]
						],
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
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'triggerMargin' => [
				'label' => __( 'Margin', 'blocksy' ),
				'type' => 'ct-spacing',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true,
			],

		],
	],
];
