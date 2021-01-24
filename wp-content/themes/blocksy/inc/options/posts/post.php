<?php

$options = [
	'single_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			[
				blocksy_get_options('general/page-title', [
					'prefix' => 'single_blog_post',
					'is_single' => true,
					'enabled_label' => __('Post Title', 'blocksy')
				]),

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Post Structure', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [
						blocksy_get_options('single-elements/structure', [
							'prefix' => 'single_blog_post',
						]),
					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [
						blocksy_get_options('single-elements/structure-design', [
							'prefix' => 'single_blog_post',
						])
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Post Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('single-elements/featured-image', [
				'prefix' => 'single_blog_post',
			]),

			[
				'single_blog_post_has_post_tags' => [
					'label' => __( 'Post Tags', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'sync' => blocksy_sync_single_post_container([
						'prefix' => 'single_blog_post'
					]),
				],
			],

			blocksy_get_options('single-elements/post-share-box', [
				'prefix' => 'single_blog_post'
			]),

			blocksy_get_options('single-elements/author-box', [
				'prefix' => 'single_blog_post'
			]),

			blocksy_get_options('single-elements/post-nav', [
				'prefix' => 'single_blog_post'
			]),

			apply_filters(
				'blocksy_single_posts_end_customizer_options',
				[]
			),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('single-elements/related-posts', [
				'prefix' => 'single_blog_post'
			]),

			blocksy_get_options('general/comments-single', [
				'prefix' => 'single_blog_post',
			]),

		],
	],
];
