<?php

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'offcanvas_behavior' => [
				'label' => __('Reaveal as', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'panel',
				'view' => 'text',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'modal' => __( 'Modal', 'blocksy' ),
					'panel' => __( 'Side Panel', 'blocksy' ),
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'offcanvas_behavior' => 'panel' ],
				'options' => [

					'side_panel_position' => [
						'label' => __('Reveal From', 'blocksy'),
						'type' => 'ct-radio',
						'value' => 'right',
						'view' => 'text',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'left' => __( 'Left Side', 'blocksy' ),
							'right' => __( 'Right Side', 'blocksy' ),
						],
					],

					'side_panel_width' => [
						'label' => __( 'Panel Width', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => [
							'desktop' => '500px',
							'tablet' => '65vw',
							'mobile' => '90vw',
						],
						'units' => blocksy_units_config([
							[ 'unit' => 'px', 'min' => 0, 'max' => 1000 ],
						]),
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'offcanvas_content_vertical_alignment' => [
				'type' => 'ct-radio',
				'label' => __( 'Vertical Alignment', 'blocksy' ),
				'view' => 'text',
				'design' => 'block',
				'responsive' => true,
				'attr' => [ 'data-type' => 'vertical-alignment' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => 'flex-start',
				'choices' => [
					'flex-start' => '',
					'center' => '',
					'flex-end' => '',
				],
			],

			'offcanvasContentAlignment' => [
				'type' => 'ct-radio',
				'label' => __( 'Horizontal Alignment', 'blocksy' ),
				'view' => 'text',
				'design' => 'block',
				'divider' => 'top',
				'responsive' => true,
				'attr' => [ 'data-type' => 'horizontal-alignment' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => 'flex-start',
				'choices' => [
					'flex-start' => '',
					'center' => '',
					'flex-end' => '',
				],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'offcanvasBackground' => [
				'label' => __( 'Panel Background', 'blocksy' ),
				'type'  => 'ct-background',
				'design' => 'block:right',
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => 'rgba(18, 21, 25, 0.98)'
						],
					],
				])
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'offcanvas_behavior' => 'panel' ],
				'options' => [

					'offcanvasBackdrop' => [
						'label' => __( 'Panel Backgrop', 'blocksy' ),
						'type'  => 'ct-background',
						'design' => 'block:right',
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => blocksy_background_default_value([
							'backgroundColor' => [
								'default' => [
									'color' => 'rgba(255,255,255,0)'
								],
							],
						])
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'offcanvas_behavior' => 'panel' ],
				'options' => [

					'headerPanelShadow' => [
						'label' => __( 'Shadow', 'blocksy' ),
						'type' => 'ct-box-shadow',
						'design' => 'block',
						'responsive' => true,
						'divider' => 'top',
						'value' => blocksy_box_shadow_value([
							'enable' => true,
							'h_offset' => 0,
							'v_offset' => 0,
							'blur' => 70,
							'spread' => 0,
							'inset' => false,
							'color' => [
								'color' => 'rgba(0, 0, 0, 0.35)',
							],
						])
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'menu_close_button_color' => [
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

			'menu_close_button_shape_color' => [
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

		],
	],

];
