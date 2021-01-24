<?php

$options = [
	blocksy_rand_md5() => [
		'type' => 'ct-title',
		'label' => __( 'Customizing: Logged in State', 'blc' ),
	],

	'account_state' => [
		'label' => false,
		'type' => 'ct-image-picker',
		'value' => 'in',
		'attr' => [ 'data-type' => 'background' ],
		'switchDeviceOnChange' => 'desktop',
		'choices' => [
			'in' => [
				'src'   => blocksy_image_picker_url( 'log-in-state.svg' ),
				'title' => __( 'Logged In Options', 'blc' ),
			],

			'out' => [
				'src' => blocksy_image_picker_url('log-out-state.svg'),
				'title' => __('Logged Out Options', 'blc'),
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'account_state' => 'in' ],
				'options' => [

					'account_link' => [
						'label' => __( 'Account Action', 'blc' ),
						'type' => 'ct-select',
						'value' => 'profile',
						'view' => 'text',
						'design' => 'inline',
						'choices' => blocksy_ordered_keys(
							[
								'profile' => __( 'Profile Page', 'blc' ),
								'dashboard' => __( 'Dashboard Page', 'blc' ),
								// 'menu' => __( 'Menu', 'blc' ),
								'custom' => __( 'Custom Link', 'blc' ),
								'logout' => __( 'Logout', 'blc' ),
							]
						),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'account_link' => 'menu' ],
						'options' => [
							'loggedin_account_menu' => [
								'label' => __('Select Menu', 'blc'),
								'type' => 'ct-select',
								'value' => 'blocksy_location',
								'view' => 'text',
								'design' => 'inline',
								'setting' => ['transport' => 'postMessage'],
								'placeholder' => __('Select menu...', 'blc'),
								'choices' => blocksy_ordered_keys(blocksy_get_menus_items()),
								'desc' => sprintf(
									// translators: placeholder here means the actual URL.
									__( 'Manage your menu items in the %sMenus screen%s.', 'blc' ),
									sprintf(
										'<a href="%s" target="_blank">',
										admin_url('/nav-menus.php')
									),
									'</a>'
								),
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'account_link' => 'custom' ],
						'options' => [

							'account_custom_page' => [
								'label' => __( 'Custom Page Link', 'blc' ),
								'type' => 'text',
								'design' => 'inline',
								'disableRevertButton' => true,
								'value' => ''
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'loggedin_media' => [
						'label' => __( 'Media Type', 'blc' ),
						'type' => 'ct-radio',
						'design' => 'block',
						'view' => 'text',
						'value' => 'avatar',
						'choices' => [
							'avatar' => __( 'Avatar', 'blc' ),
							'icon' => __( 'Icon', 'blc' ),
							'none' => __( 'None', 'blc' ),
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'loggedin_media' => 'avatar' ],
						'options' => [

							'accountHeaderAvatarSize' => [
								'label' => __( 'Avatar Size', 'blc' ),
								'type' => 'ct-slider',
								'min' => 10,
								'max' => 40,
								'value' => 18,
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'loggedin_media' => 'icon' ],
						'options' => [

							'account_loggedin_icon' => [
								'label' => false,
								'type' => 'ct-image-picker',
								'value' => 'type-1',
								'attr' => [
									'data-type' => 'background',
									'data-columns' => '3',
								],
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [

									'type-1' => [
										'src'   => blocksy_image_picker_file( 'account-1' ),
										'title' => __( 'Type 1', 'blocksy' ),
									],

									'type-2' => [
										'src'   => blocksy_image_picker_file( 'account-2' ),
										'title' => __( 'Type 2', 'blocksy' ),
									],

									'type-3' => [
										'src'   => blocksy_image_picker_file( 'account-3' ),
										'title' => __( 'Type 3', 'blocksy' ),
									],

									'type-4' => [
										'src'   => blocksy_image_picker_file( 'account-4' ),
										'title' => __( 'Type 4', 'blocksy' ),
									],

									'type-5' => [
										'src'   => blocksy_image_picker_file( 'account-5' ),
										'title' => __( 'Type 5', 'blocksy' ),
									],

									'type-6' => [
										'src'   => blocksy_image_picker_file( 'account-6' ),
										'title' => __( 'Type 6', 'blocksy' ),
									],
								],
							],

							'account_loggedin_icon_size' => [
								'label' => __( 'Icon Size', 'blc' ),
								'type' => 'ct-slider',
								'min' => 5,
								'max' => 50,
								'value' => 15,
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
							],

							'account_loggedin_icon_position' => [
								'type' => 'ct-radio',
								'label' => __( 'Icon Alignment', 'blc' ),
								'value' => 'left',
								'view' => 'text',
								'design' => 'block',
								'choices' => [
									'left' => __( 'Left', 'blc' ),
									'right' => __( 'Right', 'blc' ),
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'loggedin_text' => [
						'label' => __( 'Text Type', 'blc' ),
						'type' => 'ct-radio',
						'design' => 'block',
						'view' => 'text',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => 'label',
						'choices' => [
							'label' => __( 'Label', 'blc' ),
							'username' => __( 'Name', 'blc' ),
							'none' => __( 'None', 'blc' ),
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'loggedin_text' => 'label' ],
						'options' => [

							'loggedin_label' => [
								'label' => __( 'Custom Label', 'blc' ),
								'type' => 'text',
								'design' => 'inline',
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => __('My Account', 'blc')
							],

						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'account_state' => 'out' ],
				'options' => [

					'login_account_action' => [
						'label' => __( 'Account Action', 'blc' ),
						'type' => 'ct-select',
						'value' => 'modal',
						'view' => 'text',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => blocksy_ordered_keys(
							[
								'modal' => __( 'Modal', 'blc' ),
								'custom' => __( 'Custom Link', 'blc' ),
							]
						),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'login_account_action' => 'custom' ],
						'options' => [

							'loggedout_account_custom_page' => [
								'label' => __( 'Custom Page Link', 'blc' ),
								'type' => 'text',
								'design' => 'inline',
								'disableRevertButton' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => ''
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'login_style' => [
						'label' => __( 'View Type', 'blc' ),
						'type' => 'ct-checkboxes',
						'design' => 'block',
						'view' => 'text',
						'disableRevertButton' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'icon' => true,
							'label' => true,
						],

						'choices' => blocksy_ordered_keys([
							'icon' => __( 'Icon', 'blc' ),
							'label' => __( 'Label', 'blc' ),
						]),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'login_style/icon' => true ],
						'options' => [

							'accountHeaderIcon' => [
								'label' => false,
								'type' => 'ct-image-picker',
								'value' => 'type-1',
								'attr' => [
									'data-type' => 'background',
									'data-columns' => '3',
								],
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [

									'type-1' => [
										'src'   => blocksy_image_picker_file( 'account-1' ),
										'title' => __( 'Type 1', 'blocksy' ),
									],

									'type-2' => [
										'src'   => blocksy_image_picker_file( 'account-2' ),
										'title' => __( 'Type 2', 'blocksy' ),
									],

									'type-3' => [
										'src'   => blocksy_image_picker_file( 'account-3' ),
										'title' => __( 'Type 3', 'blocksy' ),
									],

									'type-4' => [
										'src'   => blocksy_image_picker_file( 'account-4' ),
										'title' => __( 'Type 4', 'blocksy' ),
									],

									'type-5' => [
										'src'   => blocksy_image_picker_file( 'account-5' ),
										'title' => __( 'Type 5', 'blocksy' ),
									],

									'type-6' => [
										'src'   => blocksy_image_picker_file( 'account-6' ),
										'title' => __( 'Type 6', 'blocksy' ),
									],
								],
							],

							'accountHeaderIconSize' => [
								'label' => __( 'Icon Size', 'blc' ),
								'type' => 'ct-slider',
								'min' => 5,
								'max' => 50,
								'value' => 15,
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
							],

							'accountHeaderIconPosition' => [
								'type' => 'ct-radio',
								'label' => __( 'Icon Alignment', 'blc' ),
								'value' => 'left',
								'view' => 'text',
								'design' => 'block',
								'choices' => [
									'left' => __( 'Left', 'blc' ),
									'right' => __( 'Right', 'blc' ),
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'login_style/label' => true ],
						'options' => [

							'login_label' => [
								'label' => __('Label', 'blc'),
								'type' => 'text',
								'design' => 'inline',
								'divider' => 'top',
								'disableRevertButton' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => __('Login', 'blc')
							],
						],
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'all' => [
							'account_state' => 'out',
							'login_style/label' => true,
						],

						'all~' => [
							'account_state' => 'in',
							'loggedin_text' => '!none'
						]
					]
				],
				'options' => [
					'account_label_visibility' => [
						'label' => __( 'Label/Name Visibility', 'blc' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'divider' => 'top',
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
		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'account_label_font' => [
				'type' => 'ct-typography',
				'label' => __( 'Label/Name Font', 'blc' ),
				'value' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n6',
					'text-transform' => 'uppercase',
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Label/Name Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'accountHeaderColor',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparentAccountHeaderColor',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'stickyAccountHeaderColor',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'accountHeaderColor' => [
						'label' => __( 'Label/Name Color', 'blc' ),
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
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],

					'transparentAccountHeaderColor' => [
						'label' => __( 'Label/Name Color', 'blc' ),
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
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

					'stickyAccountHeaderColor' => [
						'label' => __( 'Label/Name Color', 'blc' ),
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
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'accountHeaderMargin' => [
				'label' => __( 'Item Margin', 'blc' ),
				'type' => 'ct-spacing',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'account_state' => 'in' ],
				'options' => [

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'account_state' => 'out' ],
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'account_form_shadow' => [
						'label' => __( 'Form Shadow', 'blc' ),
						'type' => 'ct-box-shadow',
						'design' => 'block',
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

					'accountHeaderFormBackground' => [
						'label' => __( 'Form Background', 'blc' ),
						'type'  => 'ct-background',
						'design' => 'inline',
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

					'accountHeaderBackground' => [
						'label' => __( 'Form Backdrop', 'blc' ),
						'type'  => 'ct-background',
						'design' => 'inline',
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

					'account_close_button_color' => [
						'label' => __( 'Close Icon Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'top',
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
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
								'inherit' => 'rgba(255, 255, 255, 0.7)'
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
								'inherit' => '#ffffff'
							],
						],
					],

					'account_close_button_shape_color' => [
						'label' => __( 'Close Icon Background', 'blc' ),
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
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
								'inherit' => 'rgba(0, 0, 0, 0.5)'
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
								'inherit' => 'rgba(0, 0, 0, 0.5)'
							],
						],
					],

				],
			],

		],
	],
];
