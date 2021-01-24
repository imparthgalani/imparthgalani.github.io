<?php

$options = [

	blocksy_rand_md5() => [
		'type' => 'ct-title',
		'label' => __( 'Top Level Options', 'blocksy' ),
	],

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'mini_cart_type' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'type-1',
				'attr' => [
					'data-type' => 'background',
					'data-columns' => '3',
				],
				'divider' => 'bottom',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [

					'type-1' => [
						'src'   => blocksy_image_picker_file( 'cart-1' ),
						'title' => __( 'Type 1', 'blocksy' ),
					],

					'type-2' => [
						'src'   => blocksy_image_picker_file( 'cart-2' ),
						'title' => __( 'Type 2', 'blocksy' ),
					],

					'type-3' => [
						'src'   => blocksy_image_picker_file( 'cart-3' ),
						'title' => __( 'Type 3', 'blocksy' ),
					],
				],
			],

			'cartIconSize' => [
				'label' => __( 'Icon Size', 'blocksy' ),
				'type' => 'ct-slider',
				'min' => 5,
				'max' => 50,
				'value' => 15,
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'has_cart_badge' => [
				'label' => __( 'Icon Badge', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'cart_subtotal_visibility' => [
				'label' => __( 'Cart Total Visibility', 'blocksy' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'allow_empty' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'desktop' => true,
					'tablet' => true,
					'mobile' => true,
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
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [
			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Icon Color', 'blocksy' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'cartHeaderIconColor',
						'label' => __('Default State', 'blocksy')
					],

					[
						'id' => 'transparentCartHeaderIconColor',
						'label' => __('Transparent State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'stickyCartHeaderIconColor',
						'label' => __('Sticky State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [
					'cartHeaderIconColor' => [
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

					'transparentCartHeaderIconColor' => [
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

					'stickyCartHeaderIconColor' => [
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


			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Badge Color', 'blocksy' ),
				'responsive' => true,
				'divider' => 'top',
				'choices' => [
					[
						'id' => 'cartBadgeColor',
						'label' => __('Default State', 'blocksy'),
						'condition' => [
							'has_cart_badge' => 'yes',
						],
					],

					[
						'id' => 'transparentCartBadgeColor',
						'label' => __('Transparent State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'has_cart_badge' => 'yes',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'stickyCartBadgeColor',
						'label' => __('Sticky State', 'blocksy'),
						'condition' => [
							'row' => '!offcanvas',
							'has_cart_badge' => 'yes',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'cartBadgeColor' => [
						'label' => __( 'Badge Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'background' => [
								'color' => 'var(--paletteColor1)',
							],

							'text' => [
								'color' => '#ffffff',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Background', 'blocksy' ),
								'id' => 'background',
							],

							[
								'title' => __( 'Text', 'blocksy' ),
								'id' => 'text',
							],
						],
					],

					'transparentCartBadgeColor' => [
						'label' => __( 'Badge Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'top',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'background' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'text' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Background', 'blocksy' ),
								'id' => 'background',
							],

							[
								'title' => __( 'Text', 'blocksy' ),
								'id' => 'text',
							],
						],
					],

					'stickyCartBadgeColor' => [
						'label' => __( 'Badge Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'top',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'background' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'text' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Background', 'blocksy' ),
								'id' => 'background',
							],

							[
								'title' => __( 'Text', 'blocksy' ),
								'id' => 'text',
							],
						],
					],

				],
			],

			'headerCartMargin' => [
				'label' => __( 'Margin', 'blocksy' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	'has_cart_dropdown' => [
		'label' => __( 'Cart Drawer', 'blocksy' ),
		'type' => 'ct-switch',
		'value' => 'yes',
		'wrapperAttr' => [ 'data-label' => 'heading-label' ],
		'setting' => [ 'transport' => 'postMessage' ],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'has_cart_dropdown' => 'yes' ],
		'options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'cart_drawer_type' => [
						'label' => __('Cart Drawer Type', 'blocksy'),
						'type' => apply_filters(
							'blocksy:header:cart:cart_drawer_type:option',
							'hidden'
						),
						'value' => 'dropdown',
						'divider' => 'bottom',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'dropdown' => [
								'src' => blocksy_image_picker_url('cart-1.svg'),
								'title' => __( 'Dropdown', 'blocksy' ),
							],

							'offcanvas' => [
								'src' => blocksy_image_picker_url('cart-2.svg'),
								'title' => __( 'Off Canvas', 'blocksy' ),
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'cart_drawer_type' => 'dropdown' ],
						'options' => [
							'cartDropdownTopOffset' => [
								'label' => __( 'Dropdown Top Offset', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => 15,
								'min' => 0,
								'max' => 50,
								'setting' => [ 'transport' => 'postMessage' ],
							],
						]
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'cart_drawer_type' => 'offcanvas' ],
						'options' => [

							'cart_panel_position' => [
								'label' => __('Panel Reveal', 'blocksy'),
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

							'cart_panel_width' => [
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

							'auto_open_cart' => [
								'label' => __( 'Open Cart Automatically On', 'blocksy' ),
								'type' => 'ct-checkboxes',
								'view' => 'text',
								'design' => 'block',
								'divider' => 'top',
								'allow_empty' => true,
								'setting' => ['transport' => 'postMessage'],
								'desc' => __( 'Automatically open the cart drawer after a product is added to cart.', 'blocksy' ),
								'value' => [
									'archive' => false,
									'product' => false,
								],
								'choices' => blocksy_ordered_keys([
									'archive' => __('Archive Page', 'blocksy'),
									'product' => __('Product Page', 'blocksy'),
								]),
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
						'type' => 'ct-condition',
						'condition' => [ 'cart_drawer_type' => 'dropdown' ],
						'options' => [

							'cartFontColor' => [
								'label' => __( 'Font Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
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

							'cartDropDownBackground' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#29333C',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'cart_drawer_type' => 'offcanvas' ],
						'options' => [

							'cart_panel_font_color' => [
								'label' => __( 'Font Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'block:right',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'default' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],

									'link_initial' => [
										'color' => 'var(--headingColor)',
									],

									'link_hover' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],
								],

								'pickers' => [
									[
										'title' => __( 'Text Initial', 'blocksy' ),
										'id' => 'default',
										'inherit' => 'var(--color)'
									],

									[
										'title' => __( 'Link Initial', 'blocksy' ),
										'id' => 'link_initial',
										'inherit' => 'var(--linkInitialColor)'
									],

									[
										'title' => __( 'Link Hover', 'blocksy' ),
										'id' => 'link_hover',
										'inherit' => 'var(--linkHoverColor)'
									],
								],
							],

							'cart_panel_shadow' => [
								'label' => __( 'Panel Shadow', 'blocksy' ),
								'type' => 'ct-box-shadow',
								'design' => 'block',
								'divider' => 'top',
								'responsive' => true,
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

							'cart_panel_background' => [
								'label' => __( 'Panel Background', 'blocksy' ),
								'type'  => 'ct-background',
								'design' => 'block:right',
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => blocksy_background_default_value([
									'backgroundColor' => [
										'default' => [
											'color' => '#ffffff'
										],
									],
								])
							],

							'cart_panel_backgrop' => [
								'label' => __( 'Panel Backgrop', 'blocksy' ),
								'type'  => 'ct-background',
								'design' => 'block:right',
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => blocksy_background_default_value([
									'backgroundColor' => [
										'default' => [
											'color' => 'rgba(18, 21, 25, 0.6)'
										],
									],
								])
							],

							'cart_panel_close_button_color' => [
								'label' => __( 'Close Icon Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => 'rgba(0, 0, 0, 0.5)',
									],

									'hover' => [
										'color' => 'rgba(0, 0, 0, 0.8)',
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

							'cart_panel_close_button_shape_color' => [
								'label' => __( 'Close Icon Background', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => 'rgba(0, 0, 0, 0)',
									],

									'hover' => [
										'color' => 'rgba(0, 0, 0, 0)',
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

				],
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

			'header_cart_visibility' => [
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
