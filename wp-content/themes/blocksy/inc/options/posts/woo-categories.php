<?php

$options = [
	'woo_categories_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_get_options('general/page-title', [
				'prefix' => 'woo_categories',
				'is_woo' => true,
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Shop Settings', 'blocksy' ),
				],

				'shop_cards_type' => [
					'label' => false,
					'type' => 'ct-image-picker',
					'value' => 'type-1',
					'divider' => 'bottom',
					'setting' => [ 'transport' => 'postMessage' ],
					'choices' => [

						'type-1' => [
							'src'   => blocksy_image_picker_url( 'woo-type-1.svg' ),
							'title' => __( 'Type 1', 'blocksy' ),
						],

						'type-2' => [
							'src'   => blocksy_image_picker_url( 'woo-type-2.svg' ),
							'title' => __( 'Type 2', 'blocksy' ),
						],


					],

					'sync' => blocksy_sync_whole_page([
						'prefix' => 'woo_categories',
						'loader_selector' => '.products > li'
					]),
				],

				'blocksy_woo_columns' => [
					'label' => __('Columns & Rows', 'blocksy'),
					'type' => 'ct-woocommerce-columns-and-rows',
					'value' => [
						'desktop' => 4,
						'tablet' => 3,
						'mobile' => 1
					],
					'min' => 1,
					'max' => 5,
					'responsive' => true,
					'setting' => [
						'transport' => 'postMessage'
					],
				],

				'woocommerce_catalog_columns' => [
					'type' => 'hidden',
					'value' => 4,
					'setting' => [
						'type' => 'option',
						'transport' => 'postMessage'
					],
				],

				'woocommerce_catalog_rows' => [
					'type' => 'hidden',
					'value' => 4,
					'setting' => [
						'type' => 'option',
					],

					'sync' => blocksy_sync_whole_page([
						'prefix' => 'woo_categories',
						'loader_selector' => '.products > li'
					]),
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ]
				],

				'product_card_options_panel' => [
					'label' => __( 'Cards Options', 'blocksy' ),
					'type' => 'ct-panel',
					'wrapperAttr' => [ 'data-panel' => 'only-arrow' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [
								[
									'woocommerce_thumbnail_cropping' => [
										'label' => __('Image', 'blocksy'),
										'type' => 'ct-woocommerce-ratio',
										/**
										 * Can be
										 * 1:1
										 * custom
										 * predefined
										 */
										'value' => '1:1',
										'design' => 'inline',
										'setting' => [
											'type' => 'option',
											'transport' => 'postMessage'
										],
										'preview_width_key' => 'woocommerce_thumbnail_image_width',
										'inner-options' => [
											'woocommerce_thumbnail_image_width' => [
												'type' => 'text',
												'label' => __('Image Width', 'blocksy'),
												'desc' => __('Image height will be automatically calculated based on the image ratio.', 'blocksy'),
												'value' => 500,
												'design' => 'inline',
												'setting' => [
													'type' => 'option',
													'capability' => 'manage_woocommerce',
												]
											],
										],
									],

									'woocommerce_thumbnail_cropping_custom_width' => [
										'label' => false,
										'type' => 'hidden',
										'value' => 4,
										'setting' => [
											'type' => 'option',
											'capability' => 'manage_woocommerce',
											'transport' => 'postMessage'
										],
										'disableRevertButton' => true,
										'desc' => __('Width', 'blocksy'),
									],

									'woocommerce_thumbnail_cropping_custom_height' => [
										'label' => false,
										'type' => 'hidden',
										'value' => 3,
										'setting' => [
											'type' => 'option',
											'capability' => 'manage_woocommerce',
											'transport' => 'postMessage'
										],
										'disableRevertButton' => true,
										'desc' => __('Height', 'blocksy'),
									],

									'product_image_hover' => [
										'label' => __( 'Image Hover Effect', 'blocksy' ),
										'type' => 'ct-select',
										'value' => 'none',
										'view' => 'text',
										'design' => 'inline',
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => blocksy_ordered_keys(
											[
												'none' => __( 'None', 'blocksy' ),
												'swap' => __( 'Swap Images', 'blocksy' ),
												'zoom' => __( 'Zoom', 'blocksy' ),
											]
										),

										'sync' => blocksy_sync_whole_page([
											'prefix' => 'woo_categories',
											'loader_selector' => '.products > li'
										]),
									],

									blocksy_rand_md5() => [
										'type' => 'ct-divider',
									],

									'has_star_rating' => [
										'label' => __( 'Star Rating', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'yes',
										'sync' => blocksy_sync_whole_page([
											'prefix' => 'woo_categories',
											'loader_selector' => '.products > li'
										]),
									],

									'has_sale_badge' => [
										'label' => __( 'Sale Badge', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'yes',
										'sync' => blocksy_sync_whole_page([
											'prefix' => 'woo_categories',
											'loader_selector' => '.products > li'
										]),
									],

									'has_product_categories' => [
										'label' => __( 'Product Categories', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'no',
										'sync' => blocksy_sync_whole_page([
											'prefix' => 'woo_categories',
											'loader_selector' => '.products > li'
										]),
									],

									blocksy_rand_md5() => [
										'type' => 'ct-divider',
									],
								],

								apply_filters(
									'blocksy_woo_card_options_elements',
									[]
								),

								[
									'shopCardsGap' => [
										'label' => __( 'Cards Gap', 'blocksy' ),
										'type' => 'ct-slider',
										'min' => 0,
										'max' => 100,
										'responsive' => true,
										'value' => [
											'mobile' => 30,
											'tablet' => 30,
											'desktop' => 30,
										],
										'setting' => [ 'transport' => 'postMessage' ],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [ 'shop_cards_type' => 'type-1' ],
										'options' => [

											blocksy_rand_md5() => [
												'type' => 'ct-divider',
											],

											'shop_cards_alignment_1' => [
												'type' => 'ct-radio',
												'label' => __( 'Content Alignment', 'blocksy' ),
												'value' => 'left',
												'view' => 'text',
												'attr' => [ 'data-type' => 'alignment' ],
												'disableRevertButton' => true,
												'design' => 'block',
												'setting' => [ 'transport' => 'postMessage' ],
												'choices' => [
													'left' => '',
													'center' => '',
													'right' => '',
												],
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

								'cardProductTitleFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Title Font', 'blocksy' ),
									'value' => blocksy_typography_default_values([
										'size' => '17px',
										'variation' => 'n6',
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'cardProductTitleColor' => [
									'label' => __( 'Title Color', 'blocksy' ),
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
											'inherit' => 'var(--headingColor)'
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
											'inherit' => 'var(--linkHoverColor)'
										],
									],
								],

								'cardProductPriceColor' => [
									'label' => __( 'Price Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'divider' => 'top',
									'setting' => [ 'transport' => 'postMessage' ],

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

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'has_product_categories' => 'yes' ],
									'options' => [

										'cardProductCategoriesColor' => [
											'label' => __( 'Categories Color', 'blocksy' ),
											'type'  => 'ct-color-picker',
											'design' => 'inline',
											'divider' => 'top',
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

									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'shop_cards_type' => 'type-1' ],
									'options' => [

										'cardProductButton1Text' => [
											'label' => __( 'Button Text Color', 'blocksy' ),
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
													'title' => __( 'Initial', 'blocksy' ),
													'id' => 'default',
													'inherit' => 'var(--buttonTextInitialColor)'
												],

												[
													'title' => __( 'Hover', 'blocksy' ),
													'id' => 'hover',
													'inherit' => 'var(--buttonTextHoverColor)'
												],
											],
										],

										'cardProductButtonBackground' => [
											'label' => __( 'Button Background Color', 'blocksy' ),
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
													'inherit' => 'var(--buttonInitialColor)'
												],

												[
													'title' => __( 'Hover', 'blocksy' ),
													'id' => 'hover',
													'inherit' => 'var(--buttonHoverColor)'
												],
											],
										],

									],
								],


								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'shop_cards_type' => 'type-2' ],
									'options' => [

										'cardProductButton2Text' => [
											'label' => __( 'Button Text Color', 'blocksy' ),
											'type'  => 'ct-color-picker',
											'design' => 'inline',
											'divider' => 'top',
											'setting' => [ 'transport' => 'postMessage' ],

											'value' => [
												'default' => [
													'color' => 'var(--color)',
												],

												'hover' => [
													'color' => 'var(--linkHoverColor)',
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

										'cardProductBackground' => [
											'label' => __( 'Card Background Color', 'blocksy' ),
											'type'  => 'ct-color-picker',
											'design' => 'inline',
											'divider' => 'top',
											'setting' => [ 'transport' => 'postMessage' ],
											'value' => [
												'default' => [
													'color' => '#ffffff',
												],
											],

											'pickers' => [
												[
													'title' => __( 'Initial', 'blocksy' ),
													'id' => 'default',
												],
											],
										],

										'cardProductShadow' => [
											'label' => __( 'Card Shadow', 'blocksy' ),
											'type' => 'ct-box-shadow',
											'responsive' => true,
											'divider' => 'top',
											'setting' => [ 'transport' => 'postMessage' ],
											'value' => blocksy_box_shadow_value([
												'enable' => true,
												'h_offset' => 0,
												'v_offset' => 12,
												'blur' => 18,
												'spread' => -6,
												'inset' => false,
												'color' => [
													'color' => 'rgba(34, 56, 101, 0.03)',
												],
											])
										],

									],
								],

								'cardProductRadius' => [
									'label' => __( 'Border Radius', 'blocksy' ),
									'type' => 'ct-spacing',
									'divider' => 'top',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => blocksy_spacing_value([
										'linked' => true,
										'top' => '3px',
										'left' => '3px',
										'right' => '3px',
										'bottom' => '3px',
									]),
									'responsive' => true
								],

							],
						],

					],
				],

				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],

				'has_shop_sort' => [
					'label' => __( 'Shop Sort', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'has_shop_results_count' => [
					'label' => __( 'Shop Results Count', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'sync' => 'live'
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'woo_categories',
			]),

			blocksy_get_options('general/pagination', [
				'prefix' => 'woo_categories',
			]),

			apply_filters(
				'blocksy:options:woocommerce:archive:page-elements-end',
				[]
			),

			[
				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Functionality Options', 'blocksy' ),
				],

				'product_catalog_panel' => [
					'label' => __( 'Product Catalog', 'blocksy' ),
					'type' => 'ct-panel',
					'wrapperAttr' => [ 'data-panel' => 'only-arrow' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						'woocommerce_shop_page_display' => [
							'label' => __( 'Shop page display', 'blocksy' ),
							'type' => 'ct-select',
							'value' => '',
							'view' => 'text',
							'placeholder' => __('Show products', 'blocksy'),
							'design' => 'block',
							'setting' => [
								'type' => 'option'
							],
							'desc' => __( 'Choose what to display on the main shop page.', 'blocksy' ),
							'choices' => blocksy_ordered_keys(
								[
									'' => __('Show products', 'blocksy'),
									'subcategories' => __('Show categories', 'blocksy'),
									'both' => __('Show categories & products', 'blocksy'),
								]
							),
						],

						'woocommerce_category_archive_display' => [
							'label' => __( 'Category display', 'blocksy' ),
							'type' => 'ct-select',
							'value' => '',
							'view' => 'text',
							'placeholder' => __('Show products', 'blocksy'),
							'design' => 'block',
							'setting' => [
								'type' => 'option'
							],
							'desc' => __( 'Choose what to display on product category pages.', 'blocksy' ),
							'choices' => blocksy_ordered_keys(
								[
									'' => __('Show products', 'blocksy'),
									'subcategories' => __('Show subcategories', 'blocksy'),
									'both' => __('Show subcategories & products', 'blocksy'),
								]
							),
						],

						'woocommerce_default_catalog_orderby' => [
							'label' => __( 'Default product sorting', 'blocksy' ),
							'type' => 'ct-select',
							'value' => 'menu_order',
							'view' => 'text',
							'design' => 'block',
							'desc' => __( 'How should products be sorted in the catalog by default?', 'blocksy' ),
							'setting' => [
								'type' => 'option'
							],
							'choices' => blocksy_ordered_keys(
								[
									'menu_order' => __('Default sorting (custom ordering + name)', 'blocksy'),
									'popularity' => __('Popularity (sales)', 'blocksy'),
									'rating' => __('Average rating', 'blocksy'),
									'date' => __('Sort by most recent', 'blocksy'),
									'price' => __('Sort by price (asc)', 'blocksy'),
									'price-desc' => __('Sort by price (desc)', 'blocksy'),
								]
							),
						],

					],
				],

			],

		],
	],
];
