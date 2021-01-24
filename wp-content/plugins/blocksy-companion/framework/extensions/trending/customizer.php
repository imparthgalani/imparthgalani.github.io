<?php

$all_post_types = [
	'post' => __('Posts', 'blc')
];

if (class_exists('WooCommerce')) {
	$all_post_types['product'] = __('Products', 'blc');
}

if (function_exists('blocksy_manager')) {
	$post_types = blocksy_manager()->post_types->get_supported_post_types();

	foreach ($post_types as $single_post_type) {
		$post_type_object = get_post_type_object($single_post_type);

		if (! $post_type_object) {
			continue;
		}

		$all_post_types[$single_post_type] = $post_type_object->labels->singular_name;
	}
}

$options = [
	'title' => __('Trending Posts', 'blc'),
	'container' => [ 'priority' => 8 ],
	'options' => [
		'trending_posts_section_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => [
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Trending Posts', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blc' ),
					'type' => 'tab',
					'options' => [
						'trending_block_post_type' => count($all_post_types) > 1 ? [
							'label' => __( 'Post Type', 'blc' ),
							'type' => 'ct-select',
							'value' => 'post',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'choices' => blocksy_ordered_keys($all_post_types),

							'sync' => [
								'selector' => '.ct-trending-block',
								'render' => function () {
									echo blc_get_trending_block();
								}
							],
						] : [
							'label' => __('Post Type', 'blc'),
							'type' => 'hidden',
							'value' => 'post',
							'design' => 'none',
							'setting' => ['transport' => 'postMessage'],
						],

						'trending_block_filter' => [
							'label' => __( 'Trending From', 'blc' ),
							'type' => 'ct-select',
							'value' => 'all_time',
							'view' => 'text',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'choices' => blocksy_ordered_keys(
								[
									'all_time' => __( 'All Time', 'blc' ),
									'last_24_hours' => __( 'Last 24 Hours', 'blc' ),
									'last_7_days' => __( 'Last 7 Days', 'blc' ),
									'last_month' => __( 'Last Month', 'blc' ),
								]
							),

							'sync' => [
								'selector' => '.ct-trending-block',
								'render' => function () {
									echo blocksy_get_trending_block();
								}
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						'trendingBlockContainerSpacing' => [
							'label' => __( 'Container Inner Spacing', 'blc' ),
							'type' => 'ct-slider',
							'value' => [
								'mobile' => '30px',
								'tablet' => '30px',
								'desktop' => '30px',
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

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						'trending_block_visibility' => [
							'label' => __( 'Container Visibility', 'blc' ),
							'type' => 'ct-visibility',
							'design' => 'block',
							'sync' => 'live',

							'value' => [
								'desktop' => true,
								'tablet' => true,
								'mobile' => false,
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blc' ),
								'tablet' => __( 'Tablet', 'blc' ),
								'mobile' => __( 'Mobile', 'blc' ),
							]),
						],

					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blc' ),
					'type' => 'tab',
					'options' => [

						'trendingBlockFontColor' => [
							'label' => __( 'Font Color', 'blc' ),
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
									'title' => __( 'Initial', 'blc' ),
									'id' => 'default',
									'inherit' => 'var(--color)'
								],

								[
									'title' => __( 'Hover', 'blc' ),
									'id' => 'hover',
									'inherit' => 'var(--linkHoverColor)'
								],
							],
						],

						'trending_block_background' => [
							'label' => __( 'Container Background', 'blc' ),
							'type' => 'ct-background',
							'design' => 'inline',
							'divider' => 'top',
							'sync' => 'live',
							'value' => blocksy_background_default_value([
								'backgroundColor' => [
									'default' => [
										'color' => '#e0e3e8',
									],
								],
							])
						],

					],
				],
			]
		]
	]
];
