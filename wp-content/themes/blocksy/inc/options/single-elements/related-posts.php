<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($enabled)) {
	$enabled = 'yes';
}

if (! isset($post_type)) {
	$post_type = 'post';
}

$options = [
	$prefix . 'has_related_posts' => [
		'label' => __('Related Posts', 'blocksy'),
		'type' => 'ct-panel',
		'switch' => true,
		'value' => $enabled,
		'sync' => blocksy_sync_whole_page([
			'prefix' => $prefix,
		]),
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					[
						blocksy_rand_md5() => [
							'type' => 'ct-group',
							'label' => __( 'Posts Number', 'blocksy' ),
							'attr' => [ 'data-columns' => '2:medium' ],
							'options' => [

								$prefix . 'related_posts_count' => [
									'label' => false,
									'type' => 'ct-number',
									'value' => 3,
									'min' => 2,
									'max' => 20,
									'design' => 'block',
									'disableRevertButton' => true,
									'attr' => [ 'data-width' => 'full' ],
									'desc' => __( 'Number of Posts', 'blocksy' ),
									'sync' => [
										[
											'prefix' => $prefix,
											'selector' => '.ct-related-posts',
											'render' => function () {
												blocksy_related_posts();
											}
										],

										[
											'id' => $prefix . 'related_posts_count_skip',
											'loader_selector' => 'skip',
											'prefix' => $prefix,
											'selector' => '.ct-related-posts',
											'render' => function () {
												blocksy_related_posts();
											}
										]
									]

								],

								$prefix . 'related_posts_columns' => [
									'label' => false,
									'type' => 'ct-number',
									'value' => 3,
									'min' => 2,
									'max' => 4,
									'design' => 'block',
									'disableRevertButton' => true,
									'attr' => [ 'data-width' => 'full' ],
									'desc' => __('Posts Per Row', 'blocksy' ),
									'sync' => 'live'
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						$prefix . 'related_criteria' => [
							'label' => __( 'Related Criteria', 'blocksy' ),
							'type' => $prefix === 'single_blog_post_' ? 'ct-select' : 'hidden',
							'type' => 'ct-select',
							'value' => array_keys(blocksy_get_taxonomies_for_cpt(
								$post_type
							))[0],
							'view' => 'text',
							'design' => 'inline',
							'choices' => blocksy_ordered_keys(
								blocksy_get_taxonomies_for_cpt($post_type)
							),
							'sync' => [
								'prefix' => $prefix,
								'selector' => '.ct-related-posts',
								'render' => function () {
									blocksy_related_posts();
								}
							]
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						$prefix . 'has_related_featured_image' => [
							'label' => __( 'Featured Image', 'blocksy' ),
							'type' => 'ct-switch',
							'value' => 'yes',
							'sync' => [
								'prefix' => $prefix,
								'selector' => '.ct-related-posts',
								'render' => function () {
									blocksy_related_posts();
								}
							]
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ $prefix . 'has_related_featured_image' => 'yes' ],
							'options' => [

								$prefix . 'related_featured_image_ratio' => [
									'label' => __( 'Image Ratio', 'blocksy' ),
									'type' => 'ct-ratio',
									'value' => '16/9',
									'design' => 'inline',
									'sync' => 'live'
								],

								$prefix . 'related_featured_image_size' => [
									'label' => __('Image Size', 'blocksy'),
									'type' => 'ct-select',
									'value' => 'medium',
									'view' => 'text',
									'design' => 'inline',
									'sync' => [
										'id' => $prefix . 'archive_order_image',
									],
									'choices' => blocksy_ordered_keys(
										blocksy_get_all_image_sizes()
									),
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],
					],

					blocksy_get_options('general/meta', [
						'prefix' => $prefix . 'related_single',
						'has_label' => true,
						'meta_elements' => blocksy_post_meta_defaults([
							[
								'id' => 'post_date',
								'enabled' => true,
							],

							[
								'id' => 'comments',
								'enabled' => true,
							],
						]),
						'item_style_type' => 'hidden',
						'item_divider_type' => 'hidden',

						'skip_sync_id' => [
							'id' => $prefix . 'related_posts_count_skip',
						],

						'sync_id' => [
							'prefix' => $prefix,
							'loader_selector' => '.entry-meta',
							'selector' => '.ct-related-posts',
							'render' => function () {
								blocksy_related_posts();
							}
						]
					]),

					[
						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						$prefix . 'related_label' => [
							'label' => __( 'Module Title', 'blocksy' ),
							'type' => 'text',
							'design' => 'inline',
							'value' => __( 'Related Posts', 'blocksy' ),
							'sync' => 'live'
						],

						$prefix . 'related_label_wrapper' => [
							'label' => __( 'Module Title Tag', 'blocksy' ),
							'type' => 'ct-select',
							'value' => 'h3',
							'view' => 'text',
							'design' => 'inline',
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
							'sync' => [
								'prefix' => $prefix,
								'selector' => '.ct-related-posts',
								'loader_selector' => '.ct-block-title',
								'render' => function () {
									blocksy_related_posts();
								}
							]
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					$prefix . 'related_posts_containment' => [
						'label' => __('Module Placement', 'blocksy'),
						'type' => 'ct-radio',
						'value' => 'separated',
						'view' => 'text',
						'design' => 'block',
						'desc' => __('Separate or unify the related posts module from or with the entry content area.', 'blocksy'),
						'choices' => [
							'separated' => __('Separated', 'blocksy'),
							'contained' => __('Contained', 'blocksy'),
						],
						'sync' => blocksy_sync_whole_page([
							'prefix' => $prefix,
						]),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							'any' => [
								'all' => [
									$prefix . 'related_posts_containment' => 'separated',
									$prefix . 'comments_containment' => 'separated',
									$prefix . 'has_comments' => 'yes'
								],

								'all_' => [
									$prefix . 'related_posts_containment' => 'contained',
									$prefix . 'comments_containment' => 'contained',
									$prefix . 'has_comments' => 'yes'
								],
							]
						],
						'options' => [

							$prefix . 'related_location' => [
								'label' => __( 'Location', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'before',
								'view' => 'text',
								'design' => 'block',
								'divider' => 'top',
								'choices' => [
									'before' => __( 'Before Comments', 'blocksy' ),
									'after' => __( 'After Comments', 'blocksy' ),
								],
								'sync' => blocksy_sync_whole_page([
									'prefix' => $prefix,
								]),
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'related_posts_containment' => 'separated'
						],
						'options' => [

							$prefix . 'related_structure' => [
								'label' => __( 'Container Structure', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'normal',
								'view' => 'text',
								'design' => 'block',
								'divider' => 'top',
								'choices' => [
									'normal' => __( 'Normal', 'blocksy' ),
									'narrow' => __( 'Narrow', 'blocksy' ),
								],
								'sync' => 'live'
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'related_structure' => 'narrow',
							$prefix . 'related_posts_containment' => 'separated'
						],
						'options' => [
							$prefix . 'related_narrow_width' => [
								'label' => __( 'Container Max Width', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => 750,
								'min' => 500,
								'max' => 800,
								'sync' => 'live'
							],
						],
					],

					$prefix . 'related_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'divider' => 'top',
						'sync' => 'live',

						'value' => [
							'desktop' => true,
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
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'related_posts_label_color' => [
						'label' => __( 'Module Title Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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

					$prefix . 'related_posts_link_color' => [
						'label' => __( 'Posts Title Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'sync' => 'live',

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

					$prefix . 'related_posts_meta_color' => [
						'label' => __( 'Meta Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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

					$prefix . 'related_thumb_radius' => [
						'label' => __( 'Image Border Radius', 'blocksy' ),
						'type' => 'ct-spacing',
						'divider' => 'top',
						'value' => blocksy_spacing_value([
							'linked' => true,
						]),
						'inputAttr' => [
							'placeholder' => '5'
						],
						'responsive' => true,
						'sync' => 'live',
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'related_posts_containment' => 'separated'
						],
						'options' => [

							$prefix . 'related_posts_background' => [
								'label' => __( 'Container Background', 'blocksy' ),
								'type' => 'ct-background',
								'design' => 'inline',
								'divider' => 'top',
								'value' => blocksy_background_default_value([
									'backgroundColor' => [
										'default' => [
											'color' => '#eff1f5',
										],
									],
								]),
								'sync' => 'live',
							],

							$prefix . 'related_posts_container_spacing' => [
								'label' => __( 'Container Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => [
									'mobile' => '30px',
									'tablet' => '50px',
									'desktop' => '70px',
								],
								'units' => blocksy_units_config([
									[
										'unit' => 'px',
										'min' => 0,
										'max' => 150,
									],
								]),
								'responsive' => true,
								'divider' => 'top',
								'sync' => 'live',
							],

						],
					],
				],
			],
		],
	],
];

