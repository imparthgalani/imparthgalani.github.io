<?php

if (! isset($is_cpt)) {
	$is_cpt = false;
}

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($title)) {
	$title = __('blog', 'blocksy');
}

$options = [
	blocksy_rand_md5() => [
		'type'  => 'ct-title',
		'label' => sprintf(
			// translators: placeholder here means the actual structure title.
			__('%s Structure', 'blocksy'),
			$title
		),
		'desc' => sprintf(
			// translators: placeholder here means the actual structure title.
			__('Set the %s entries default structure.', 'blocksy'),
			$title
		),
	],

	$prefix . 'structure' => [
		'label' => false,
		'type' => 'ct-image-picker',
		'value' => 'grid',
		'sync' => blocksy_sync_whole_page([
			'prefix' => $prefix,
			'loader_selector' => '.entries > article'
		]),
		'choices' => [
			'simple' => [
				'src' => blocksy_image_picker_url('simple.svg'),
				'title' => __('Simple', 'blocksy'),
			],

			'classic' => [
				'src' => blocksy_image_picker_url('classic.svg'),
				'title' => __('Classic', 'blocksy'),
			],

			'grid' => [
				'src' => blocksy_image_picker_url('grid.svg'),
				'title' => __('Grid', 'blocksy'),
			],

			'enhanced-grid' => [
				'src' => blocksy_image_picker_url('enhanced-grid.svg'),
				'title' => __('Enhanced Grid', 'blocksy'),
			],

			'gutenberg' => [
				'src' => blocksy_image_picker_url('gutenberg.svg'),
				'title' => __('Gutenberg', 'blocksy'),
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
		'attr' => ['data-type' => 'small']
	],

	$prefix . 'archive_listing_panel' => [
		'label' => __('Cards Options', 'blocksy'),
		'type' => 'ct-panel',
		'value' => 'yes',
		'wrapperAttr' => ['data-panel' => 'only-arrow'],
		'inner-options' => [
			blocksy_rand_md5() => [
				'title' => __('General', 'blocksy'),
				'type' => 'tab',
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ $prefix . 'structure' => '!grid' ],
						'options' => [

							$prefix . 'archive_per_page' => [
								'label' => __( 'Posts per page', 'blocksy' ),
								'type' => 'ct-number',
								'value' => 10,
								'min' => 1,
								'max' => 30,
								'design' => 'inline',
								'sync' => blocksy_sync_whole_page([
									'prefix' => $prefix,
									'loader_selector' => '.entries > article'
								]),
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ $prefix . 'structure' => 'grid' ],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-group',
								'label' => __( 'Posts Number', 'blocksy' ),
								'attr' => [ 'data-columns' => '2:medium' ],
								'options' => [

									$prefix . 'columns' => [
										'label' => false,
										'desc' => __( 'Posts per row', 'blocksy' ),
										'type' => 'ct-number',
										'value' => 3,
										'min' => 2,
										'max' => 5,
										'design' => 'block',
										'disableRevertButton' => true,
										'attr' => [ 'data-width' => 'full' ],
										'sync' => blocksy_sync_whole_page([
											'prefix' => $prefix,
											'loader_selector' => '.entries > article'
										]),
									],

									$prefix . 'archive_per_page' => [
										'label' => false,
										'desc' => __( 'Posts per page', 'blocksy' ),
										'type' => 'ct-number',
										'value' => 10,
										'min' => 1,
										'max' => 30,
										'design' => 'block',
										'disableRevertButton' => true,
										'attr' => [ 'data-width' => 'full' ],
										'sync' => blocksy_sync_whole_page([
											'prefix' => $prefix,
											'loader_selector' => '.entries > article'
										]),
									],

								],
							],

						],
					],


					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					$prefix . 'archive_order' => apply_filters('blocksy:options:posts-listing-archive-order', [
						'label' => __('Card Elements', 'blocksy'),
						'type' => 'ct-layers',

						'sync' => [
							blocksy_sync_whole_page([
								'prefix' => $prefix,
								'loader_selector' => '.entries > article[id]'
							]),

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_heading_tag',
								'loader_selector' => '.entry-title',
								'container_inclusive' => false
							],

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_image',
								'loader_selector' => '.ct-image-container',
								'container_inclusive' => false
							],

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_button',
								'loader_selector' => '.entry-button',
								'container_inclusive' => false
							],

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_skip',
								'loader_selector' => 'skip',
								'container_inclusive' => false
							],

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_meta_first',
								'loader_selector' => '.entry-meta:1',
								'container_inclusive' => false
							],

							[
								'prefix' => $prefix,
								'id' => $prefix . 'archive_order_meta_second',
								'loader_selector' => '.entry-meta:2',
								'container_inclusive' => false
							],
						],

						'value' => [
							[
								'id' => 'post_meta',
								'enabled' => true,
								'meta_elements' => blocksy_post_meta_defaults([
									[
										'id' => 'categories',
										'enabled' => true,
									],
								]),
								'meta_type' => 'simple',
								'meta_divider' => 'slash',
							],

							[
								'id' => 'title',
								'heading_tag' => 'h2',
								'enabled' => true,
							],

							[
								'id' => 'featured_image',
								'thumb_ratio' => '4/3',
								'is_boundless' => 'yes',
								'image_size' => 'medium_large',
								'enabled' => true,
							],

							[
								'id' => 'excerpt',
								'excerpt_length' => '40',
								'enabled' => true,
							],

							[
								'id' => 'read_more',
								'button_type' => 'background',
								'enabled' => false,
							],

							[
								'id' => 'post_meta',
								'enabled' => true,
								'meta_elements' => blocksy_post_meta_defaults([
									[
										'id' => 'author',
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
								]),
								'meta_type' => 'simple',
								'meta_divider' => 'slash',
							],

							[
								'id' => 'divider',
								'enabled' => false
							]
						],

						'settings' => [
							'title' => [
								'label' => __('Title', 'blocksy'),
								'options' => [

									'heading_tag' => [
										'label' => __('Heading tag', 'blocksy'),
										'type' => 'ct-select',
										'value' => 'h2',
										'view' => 'text',
										'design' => 'inline',
										'sync' => [
											'id' => $prefix . 'archive_order_heading_tag',
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
							],

							'featured_image' => [
								'label' => __('Featured Image', 'blocksy'),
								'options' => [
									'thumb_ratio' => [
										'label' => __('Image Ratio', 'blocksy'),
										'type' => 'ct-ratio',
										'view' => 'inline',
										'value' => '4/3',
										'sync' => [
											'id' => $prefix . 'archive_order_skip',
										],
									],

									'image_size' => [
										'label' => __('Image Size', 'blocksy'),
										'type' => 'ct-select',
										'value' => 'medium_large',
										'view' => 'text',
										'design' => 'inline',
										'sync' => [
											'id' => $prefix . 'archive_order_image',
										],
										'choices' => blocksy_ordered_keys(
											blocksy_get_all_image_sizes()
										),
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [
											$prefix . 'card_type' => 'boxed',
											$prefix . 'structure' => '!gutenberg'
										],
                                        'values_source' => 'global',
										'options' => [
											'is_boundless' => [
												'label' => __('Boundless Image', 'blocksy'),
												'type' => 'ct-switch',
												'sync' => [
													'id' => $prefix . 'archive_order_skip',
												],
												'value' => 'yes',
											],
										],
									],

								],
							],

							'excerpt' => [
								'label' => __('Excerpt', 'blocksy'),
								'options' => [
									'excerpt_length' => [
										'label' => __('Length', 'blocksy'),
										'type' => 'ct-number',
										'design' => 'inline',
										'value' => 40,
										'min' => 10,
										'max' => 100,
									],
								],
							],

							'read_more' => [
								'label' => __('Read More Button', 'blocksy'),
								'options' => [
									'button_type' => [
										'label' => false,
										'type' => 'ct-radio',
										'value' => 'background',
										'view' => 'text',
										'choices' => [
											'simple' => __('Simple', 'blocksy'),
											'background' => __('Background', 'blocksy'),
											'outline' => __('Outline', 'blocksy'),
										],

										'sync' => [
											'id' => $prefix . 'archive_order_skip',
										]
									],

									'read_more_text' => [
										'label' => __('Text', 'blocksy'),
										'type' => 'text',
										'design' => 'inline',
										'value' => __('Read More', 'blocksy'),
										'sync' => [
											'id' => $prefix . 'archive_order_skip',
										]
									],

									'read_more_arrow' => [
										'label' => __('Show Arrow', 'blocksy'),
										'type' => 'ct-switch',
										'value' => 'no',
										'sync' => [
											'id' => $prefix . 'archive_order_button',
										]
									],

									'read_more_alignment' => [
										'type' => 'ct-radio',
										'label' => __('Alignment', 'blocksy'),
										'value' => 'left',
										'view' => 'text',
										'attr' => ['data-type' => 'alignment'],
										'design' => 'block',
										'sync' => [
											'prefix' => $prefix,
											'id' => $prefix . 'archive_order_skip',
										],
										'choices' => [
											'left' => '',
											'center' => '',
											'right' => '',
										],
									],
								],
							],

							'post_meta' => [
								'label' => __('Post Meta', 'blocksy'),
								'clone' => true,
								'sync' => [
									'id' => $prefix . 'archive_order_meta'
								],
								'options' => blocksy_get_options('general/meta', [
									'is_cpt' => $is_cpt,
									'skip_sync_id' => [
										'id' => $prefix . 'archive_order_skip'
									],
									'meta_elements' => blocksy_post_meta_defaults([
										[
											'id' => 'author',
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
									]),
								])
							],

							'divider' => [
								'label' => __('Divider', 'blocksy'),
								'clone' => true,
								'sync' => [
									'id' => $prefix . 'archive_order_meta'
								],
							]
						],
					], trim($prefix, '_')),

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'structure' => '!gutenberg'
						],
						'options' => [
							$prefix . 'card_type' => [
								'label' => __('Card Type', 'blocksy'),
								'type' => 'ct-radio',
								'value' => 'boxed',
								'view' => 'text',
								'divider' => 'bottom',
								'sync' => 'live',
								'choices' => [
									'simple' => __('Simple', 'blocksy'),
									'boxed' => __('Boxed', 'blocksy'),
								],
							],
						],
					],

					$prefix . 'cardsGap' => [
						'label' => __( 'Cards Gap', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'sync' => 'live',
						'value' => 30,
					],

					$prefix . 'card_spacing' => [
						'label' => __( 'Card Inner Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'mobile' => 25,
							'tablet' => 35,
							'desktop' => 35,
						],
						'divider' => 'top',
						'sync' => 'live',
					],

				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'archive_order:array-ids:title:enabled' => '!no'
						],
						'options' => [

							$prefix . 'cardTitleFont' => [
								'type' => 'ct-typography',
								'label' => __( 'Title Font', 'blocksy' ),
								'sync' => 'live',
								'value' => blocksy_typography_default_values([
									'size' => [
										'desktop' => '20px',
										'tablet'  => '20px',
										'mobile'  => '18px'
									],
									'line-height' => '1.3'
								]),
							],

							$prefix . 'cardTitleColor' => [
								'label' => __( 'Title Font Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'sync' => 'live',
								'design' => 'inline',

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

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'archive_order:array-ids:excerpt:enabled' => '!no'
						],
						'options' => [

							$prefix . 'cardExcerptFont' => [
								'type' => 'ct-typography',
								'label' => __( 'Excerpt Font', 'blocksy' ),
								'sync' => 'live',
								'value' => blocksy_typography_default_values([
									'size' => [
										'desktop' => '16px',
										'tablet'  => '16px',
										'mobile'  => '16px'
									],
								]),
							],

							$prefix . 'cardExcerptColor' => [
								'label' => __( 'Excerpt Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'noColor' => [ 'background' => 'var(--color)'],
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

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

						],
					],

					$prefix . 'cardMetaFont' => [
						'type' => 'ct-typography',
						'label' => __( 'Meta Font', 'blocksy' ),
						'sync' => 'live',
						'value' => blocksy_typography_default_values([
							'size' => [
								'desktop' => '12px',
								'tablet'  => '12px',
								'mobile'  => '12px'
							],
							'variation' => 'n6',
							'text-transform' => 'uppercase',
						]),
					],

					$prefix . 'cardMetaColor' => [
						'label' => __( 'Meta Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'noColor' => [ 'background' => 'var(--color)'],
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


					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'archive_order:array-ids:read_more:button_type' => 'simple',
							$prefix . 'archive_order:array-ids:read_more:enabled' => '!no'
						],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							$prefix . 'cardButtonSimpleTextColor' => [
								'label' => __( 'Button Font Color', 'blocksy' ),
								'sync' => 'live',
								'type'  => 'ct-color-picker',
								'design' => 'inline',

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
										'inherit' => 'var(--linkInitialColor)'
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
							$prefix . 'archive_order:array-ids:read_more:button_type' => 'background',
							$prefix . 'archive_order:array-ids:read_more:enabled' => '!no'
						],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							$prefix . 'cardButtonBackgroundTextColor' => [
								'label' => __( 'Button Font Color', 'blocksy' ),
								'sync' => 'live',
								'type'  => 'ct-color-picker',
								'design' => 'inline',

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

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'archive_order:array-ids:read_more:button_type' => 'outline',
							$prefix . 'archive_order:array-ids:read_more:enabled' => '!no'
						],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							$prefix . 'cardButtonOutlineTextColor' => [
								'label' => __( 'Button Font Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'sync' => 'live',
								'design' => 'inline',

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
										'inherit' => 'var(--linkInitialColor)'
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
							$prefix . 'archive_order:array-ids:read_more:button_type' => '!simple',
							$prefix . 'archive_order:array-ids:read_more:enabled' => '!no'
						],
						'options' => [

							$prefix . 'cardButtonColor' => [
								'label' => __( 'Button Color', 'blocksy' ),
								'sync' => 'live',
								'type'  => 'ct-color-picker',
								'design' => 'inline',

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
						'condition' => [
							$prefix . 'card_type' => 'simple',
							$prefix . 'archive_order:array-ids:featured_image:enabled' => '!no'

						],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							$prefix . 'cardThumbRadius' => [
								'label' => __( 'Featured Image Radius', 'blocksy' ),
								'type' => 'ct-spacing',
								'sync' => 'live',
								'value' => blocksy_spacing_value([
									'linked' => true,
								]),
								'responsive' => true
							],

							$prefix . 'cardDivider' => [
								'label' => __( 'Card bottom divider', 'blocksy' ),
								'type' => 'ct-border',
								'sync' => 'live',
								'design' => 'inline',
								'divider' => 'top',
								'value' => [
									'width' => 1,
									'style' => 'dashed',
									'color' => [
										'color' => 'rgba(224, 229, 235, 0.8)',
									],
								]
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					$prefix . 'entryDivider' => [
						'label' => __( 'Card Divider', 'blocksy' ),
						'type' => 'ct-border',
						'sync' => 'live',
						'design' => 'inline',
						'value' => [
							'width' => 1,
							'style' => 'solid',
							'color' => [
								'color' => 'rgba(224, 229, 235, 0.8)',
							],
						]
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'card_type' => 'boxed',
							$prefix . 'structure' => '!gutenberg'
						],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							$prefix . 'cardBackground' => [
								'label' => __( 'Card Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'sync' => 'live',
								'design' => 'inline',
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

							$prefix . 'cardBorder' => [
								'label' => __( 'Card Border', 'blocksy' ),
								'type' => 'ct-border',
								'design' => 'block',
								'sync' => 'live',
								'divider' => 'top',
								'responsive' => true,
								'value' => [
									'width' => 1,
									'style' => 'none',
									'color' => [
										'color' => 'rgba(44,62,80,0.2)',
									],
								]
							],

							$prefix . 'cardShadow' => [
								'label' => __( 'Card Shadow', 'blocksy' ),
								'type' => 'ct-box-shadow',
								'sync' => 'live',
								'responsive' => true,
								'divider' => 'top',
								'value' => blocksy_box_shadow_value([
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
							],

							$prefix . 'cardRadius' => [
								'label' => __( 'Border Radius', 'blocksy' ),
								'sync' => 'live',
								'type' => 'ct-spacing',
								'divider' => 'top',
								'value' => blocksy_spacing_value([
									'linked' => true,
								]),
								'responsive' => true
							],

						],
					],
				],
			],
		]
	],
];
