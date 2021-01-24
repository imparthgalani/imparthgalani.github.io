<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($has_share_box_type)) {
	$has_share_box_type = true;
}

if (! isset($has_share_box_location1)) {
	$has_share_box_location1 = true;
}

if (! isset($has_share_box)) {
	$has_share_box = 'yes';
}

if (! isset($general_tab_end)) {
	$general_tab_end = [];
}

if (! isset($has_bottom_share_box_spacing)) {
	$has_bottom_share_box_spacing = true;
}

if (! isset($has_share_items_border)) {
	$has_share_items_border = true;
}

$options = [
	$prefix . 'has_share_box' => [
		'label' => __( 'Share Box', 'blocksy' ),
		'type' => 'ct-panel',
		'switch' => true,
		'value' => $has_share_box,
		'sync' => blocksy_sync_single_post_container([
			'prefix' => $prefix
		]),
		'inner-options' => [
			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'share_box_type' => [
						'label' => false,
						'type' => $has_share_box_type ? 'ct-image-picker' : 'hidden',
						'value' => 'type-1',
						'attr' => [ 'data-type' => 'background' ],
						'switchDeviceOnChange' => 'desktop',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix
						]),
						'choices' => [
							'type-1' => [
								'src'   => blocksy_image_picker_url( 'share-box-type-1.svg' ),
								'title' => __( 'Type 1', 'blocksy' ),
							],

							'type-2' => [
								'src'   => blocksy_image_picker_url( 'share-box-type-2.svg' ),
								'title' => __( 'Type 2', 'blocksy' ),
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'share_box_type' => 'type-1'
						],
						'options' => array_merge([

							$prefix . 'share_box1_location' => [
								'label' => __( 'Box Location', 'blocksy' ),
								'type' => $has_share_box_location1 ? 'ct-checkboxes' : 'hidden',
								'design' => $has_share_box_location1 ? 'block' : 'none',
								'view' => 'text',
								'value' => [
									'top' => false,
									'bottom' => true,
								],
								'sync' => blocksy_sync_single_post_container([
									'prefix' => $prefix
								]),

								'divider' => 'bottom',

								'choices' => blocksy_ordered_keys([
									'top' => __( 'Top', 'blocksy' ),
									'bottom' => __( 'Bottom', 'blocksy' ),
								]),
							],

							$prefix . 'has_share_box_title' => [
								'label' => __( 'Module Title', 'blocksy' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'sync' => blocksy_sync_single_post_container([
									'prefix' => $prefix,
									'loader_selector' => '.ct-share-box'
								]),
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ $prefix . 'has_share_box_title' => 'yes' ],
								'options' => [

									$prefix . 'share_box_title' => [
										'label' => false,
										'type' => 'text',
										'design' => 'block',
										'value' => __( 'Share your love', 'blocksy' ),
										'disableRevertButton' => true,
										'sync' => 'live'
									],

								],
							],

						], $general_tab_end)
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'share_box_type' => 'type-2'
						],
						'options' => [
							$prefix . 'share_box2_location' => [
								'label' => __( 'Box Location', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'right',
								'view' => 'text',
								'design' => 'block',
								'choices' => [
									'left' => __( 'Left', 'blocksy' ),
									'right' => __( 'Right', 'blocksy' ),
								],
								'sync' => blocksy_sync_single_post_container([
									'prefix' => $prefix
								]),
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-title',
						'label' => __( 'Share Networks', 'blocksy' ),
					],

					$prefix . 'share_facebook' => [
						'label' => __( 'Facebook', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_twitter' => [
						'label' => __( 'Twitter', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_pinterest' => [
						'label' => __( 'Pinterest', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_linkedin' => [
						'label' => __( 'LinkedIn', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_reddit' => [
						'label' => __( 'Reddit', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						])
					],

					$prefix . 'share_hacker_news' => [
						'label' => __( 'Hacker News', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_vk' => [
						'label' => __( 'VKontakte', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_ok' => [
						'label' => __( 'Odnoklassniki', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_telegram' => [
						'label' => __( 'Telegram', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_viber' => [
						'label' => __( 'Viber', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_whatsapp' => [
						'label' => __( 'WhatsApp', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					$prefix . 'share_flipboard' => [
						'label' => __( 'Flipboard', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'sync' => blocksy_sync_single_post_container([
							'prefix' => $prefix,
							'loader_selector' => '.ct-share-box'
						]),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					$prefix . 'share_box_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'sync' => 'live',

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
							$prefix . 'share_box_type' => 'type-1'
						],
						'options' => [

							[
								$prefix . 'share_items_icon_color' => [
									'label' => __( 'Icons Color', 'blocksy' ),
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
							],

							$has_share_items_border ? [
								$prefix . 'share_items_border' => [
									'label' => __( 'Border', 'blocksy' ),
									'type' => 'ct-border',
									'design' => 'inline',
									'divider' => 'top',
									'sync' => 'live',
									'value' => [
										'width' => 1,
										'style' => 'solid',
										'color' => [
											'color' => '#e0e5eb',
										],
									]
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],
							] : []
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'share_box_type' => 'type-1',
							$prefix . 'share_box1_location/top' => true
						],
						'options' => [

							$prefix . 'top_share_box_spacing' => [
								'label' => __( 'Top Box Spacing', 'blocksy' ),
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
										'max' => 100,
									],
								]),
								'responsive' => true,
								'sync' => 'live',
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'share_box_type' => 'type-1',
							$prefix . 'share_box1_location/bottom' => true
						],
						'options' => [
							$has_bottom_share_box_spacing ? [
								$prefix . 'bottom_share_box_spacing' => [
									'label' => __( 'Bottom Box Spacing', 'blocksy' ),
									'type' => 'ct-slider',
									'sync' => 'live',
									'value' => [
										'mobile' => '30px',
										'tablet' => '50px',
										'desktop' => '70px',
									],
									'units' => blocksy_units_config([
										[
											'unit' => 'px',
											'min' => 0,
											'max' => 100,
										],
									]),
									'responsive' => true,
								],
							] : []
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ $prefix . 'share_box_type' => 'type-2' ],
						'options' => [

							$prefix . 'share_items_icon' => [
								'label' => __( 'Icons Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'sync' => 'live',

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

							$prefix . 'share_items_background' => [
								'label' => __( 'Background Color', 'blocksy' ),
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
										'inherit' => 'var(--paletteColor1)',
									],

									[
										'title' => __( 'Hover', 'blocksy' ),
										'id' => 'hover',
										'inherit' => 'var(--paletteColor2)',
									],
								],
							],
						],
					],

				],
			],
		],
	],
];

