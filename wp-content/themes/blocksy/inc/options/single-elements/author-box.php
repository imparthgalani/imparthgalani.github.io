<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

$options = [
	$prefix . 'has_author_box' => [
		'label' => __( 'Author Box', 'blocksy' ),
		'type' => 'ct-panel',
		'switch' => true,
		'value' => 'no',
		'sync' => blocksy_sync_single_post_container([
			'prefix' => $prefix
		]),
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'single_author_box_type' => [
						'label' => __('Box Type', 'blocksy'),
						'type' => 'ct-image-picker',
						'value' => 'type-2',
						'attr' => ['data-type' => 'background'],
						'sync' => [
							'prefix' => $prefix,
							'selector' => '.author-box',
							'render' => function () {
								if (have_posts()) {
									the_post();
								}

								blocksy_author_box();
							}
						],
						'choices' => [
							'type-1' => [
								'src' => blocksy_image_picker_url('author-box-type-1.svg'),
								'title' => __('Type 1', 'blocksy'),
							],

							'type-2' => [
								'src' => blocksy_image_picker_url('author-box-type-2.svg'),
								'title' => __('Type 2', 'blocksy'),
							],
						],
					],

					$prefix . 'single_author_box_posts_count' => [
						'label' => __( 'Posts count', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'divider' => 'top',
						'sync' => [
							'prefix' => $prefix,
							'selector' => '.author-box',
							'render' => function () {
								if (have_posts()) {
									the_post();
								}

								blocksy_author_box();
							}
						],
					],

					$prefix . 'single_author_box_social' => [
						'label' => __( 'Social Icons', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'desc' => sprintf(
							// translators: placeholder here is the link URL.
							__(
								'You can set the author sochial channels %shere%s.',
								'blocksy'
							),
							sprintf(
								'<a href="%s" target="_blank">',
								admin_url('/profile.php')
							),
							'</a>'
						),
						'divider' => 'top',
						'sync' => [
							'prefix' => $prefix,
							'selector' => '.author-box',
							'render' => function () {
								if (have_posts()) {
									the_post();
								}

								blocksy_author_box();
							}
						],
					],

					$prefix . 'single_author_box_spacing' => [
						'label' => __( 'Container Inner Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => '40px',
						'units' => blocksy_units_config([
							[
								'unit' => 'px',
								'min' => 0,
								'max' => 100,
							],
						]),
						'responsive' => true,
						'divider' => 'top',
						'sync' => 'live'
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					$prefix . 'author_box_visibility' => [
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
							$prefix . 'single_author_box_type' => 'type-2'
						],
						'options' => [

							$prefix . 'single_author_box_border' => [
								'label' => __( 'Border Color', 'blocksy' ),
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
										'inherit' => '#e8ebf0'
									],
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [
							$prefix . 'single_author_box_type' => 'type-1'
						],
						'options' => [
							$prefix . 'single_author_box_background' => [
								'label' => __( 'Background Color', 'blocksy' ),
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
										'inherit' => '#ffffff'
									],
								],
							],

							$prefix . 'single_author_box_shadow' => [
								'label' => __( 'Shadow', 'blocksy' ),
								'type' => 'ct-box-shadow',
								'responsive' => true,
								'divider' => 'top',
								'sync' => 'live',
								'value' => blocksy_box_shadow_value([
									'enable' => true,
									'h_offset' => 0,
									'v_offset' => 50,
									'blur' => 90,
									'spread' => 0,
									'inset' => false,
									'color' => [
										'color' => 'rgba(210, 213, 218, 0.4)',
									],
								])
							],
						],
					],
				],
			],
		],
	],
];

