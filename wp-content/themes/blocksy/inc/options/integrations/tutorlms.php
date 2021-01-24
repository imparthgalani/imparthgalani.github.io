<?php

$options = [
	'tutorlms_course_options' => [
		'type' => 'ct-options',
		'inner-options' => [
			/*
			blocksy_get_options('general/page-title', [
				'prefix' => 'courses_single',
				'is_single' => true,
				'is_cpt' => true,
				'enabled_label' => sprintf(
					__('%s Title', 'blocksy'),
					'Course'
				),
			]),
			 */

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Course Structure', 'blocksy' ),
			],

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'tutorlms_single_structure' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'type-1',
						'choices' => [
							'type-2' => [
								'src' => blocksy_image_picker_url('left-single-sidebar.svg'),
								'title' => __('Left Sidebar', 'blocksy'),
							],

							'type-1' => [
								'src' => blocksy_image_picker_url('right-single-sidebar.svg'),
								'title' => __('Right Sidebar', 'blocksy'),
							],
						],
					],

					'courses_single_content_style' => [
						'label' => __('Content Area Style', 'blocksy'),
						'type' => 'ct-radio',
						'value' => 'boxed',
						'view' => 'text',
						'design' => 'block',
						'divider' => 'top',
						'choices' => [
							'wide' => __( 'Wide', 'blocksy' ),
							'boxed' => __( 'Boxed', 'blocksy' ),
						],
					],
				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					blocksy_get_options('single-elements/structure-design', [
						'prefix' => 'courses_single',
					])

				],
			],

		]
	]
];

