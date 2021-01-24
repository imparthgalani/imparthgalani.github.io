<?php

$options = [
	'single_categories_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			blocksy_get_options('general/page-title', [
				'prefix' => 'categories',
				'is_archive' => true
			]),

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'categories',
				'title' => __('Categories', 'blocksy')
			]),

			[
				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Categories Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'categories',
			]),
		],
	],
];
