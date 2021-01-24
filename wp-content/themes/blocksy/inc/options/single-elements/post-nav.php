<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($enabled)) {
	$enabled = 'yes';
}


$options = [
	$prefix . 'has_post_nav' => [
		'label' => __( 'Posts Navigation', 'blocksy' ),
		'type' => 'ct-panel',
		'switch' => true,
		'value' => $enabled,
		'sync' => blocksy_sync_single_post_container([
			'prefix' => $prefix
		]),
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'has_post_nav_title' => [
						'label' => __( 'Post Title', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => [
							'prefix' => $prefix,
							'selector' => '.post-navigation',
							'render' => function () {
								if (have_posts()) {
									the_post();
								}

								echo blocksy_post_navigation();
							}
						],
					],

					$prefix . 'has_post_nav_thumb' => [
						'label' => __( 'Post Thumbnail', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'sync' => [
							'prefix' => $prefix,
							'selector' => '.post-navigation',
							'render' => function () {
								if (have_posts()) {
									the_post();
								}

								echo blocksy_post_navigation();
							}
						],
					],

					$prefix . 'post_nav_spacing' => [
						'label' => __( 'Container Inner Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => [
							'mobile' => '40px',
							'tablet' => '60px',
							'desktop' => '80px',
						],
						'units' => blocksy_units_config([
							[
								'unit' => 'px',
								'min' => 0,
								'max' => 200,
							],
						]),
						'responsive' => true,
						'sync' => 'live'
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					$prefix . 'post_nav_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',

						'sync' => 'live',
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

					$prefix . 'posts_nav_font_color' => [
						'label' => __( 'Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'value' => [
							'default' => [
								'color' => 'var(--color)',
							],

							'hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'sync' => 'live',

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

		],
	],

];

