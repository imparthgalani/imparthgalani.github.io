<?php

$options = [

	'has_sticky_header' => [
		'label' => __( 'Sticky Functionality', 'blc' ),
		'type' => 'ct-switch',
		'value' => 'no',

		'sync' => [
			'id' => 'header_placements_1'
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'has_sticky_header' => 'yes' ],
		'options' => [

			'sticky_rows' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'middle',
				'design' => 'block',
				'sync' => [
					'id' => 'header_placements_1'
				],

				'choices' => [
					'middle' => [
						'src' => blocksy_image_picker_url('sticky-main.svg'),
						'title' => __('Only Main Row', 'blocksy'),
					],

					'top_middle' => [
						'src' => blocksy_image_picker_url('sticky-top-main.svg'),
						'title' => __('Top & Main Row', 'blocksy'),
					],

					'entire_header' => [
						'src' => blocksy_image_picker_url('sticky-all.svg'),
						'title' => __('All Rows', 'blocksy'),
					],

					'middle_bottom' => [
						'src' => blocksy_image_picker_url('sticky-main-bottom.svg'),
						'title' => __('Main & Bottom Row', 'blocksy'),
					],

					'top' => [
						'src' => blocksy_image_picker_url('sticky-top.svg'),
						'title' => __('Only Top Row', 'blocksy'),
					],

					'bottom' => [
						'src' => blocksy_image_picker_url('sticky-bottom.svg'),
						'title' => __('Only Bottom Row', 'blocksy'),
					],
				],
			],

			'sticky_effect' => [
				'label' => __('Sticky Effect', 'blc' ),
				'type' => 'ct-select',
				'value' => 'shrink',
				'design' => 'block',
				'sync' => [
					'id' => 'header_placements_1'
				],
				'choices' => blocksy_ordered_keys([
					'shrink' => __('Default', 'blc'),
					'slide' => __('Slide Down', 'blc'),
					'fade' => __('Fade', 'blc'),
					'auto-hide' => __('Auto Hide/Show', 'blc'),
				]),
			],

			'sticky_behaviour' => [
				'label' => __( 'Enable on', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',
				'value' => [
					'desktop' => true,
					// 'tablet' => true,
					'mobile' => true,
				],

				'choices' => blocksy_ordered_keys([
					'desktop' => __('Desktop', 'blc'),
					// 'tablet' => __('Tablet', 'blc'),
					'mobile' => __('Mobile', 'blc'),
				]),
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	'has_transparent_header' => [
		'label' => __( 'Transparent Functionality', 'blc' ),
		'type' => 'ct-switch',
		'value' => 'no',
		'sync' => [
			'id' => 'header_placements_1'
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'has_transparent_header' => 'yes',
			'id' => 'type-1'
		],
		'options' => [
			'transparent_conditions' => [
				'type' => 'blocksy-display-condition',
				'value' => [
					[
						'type' => 'include',
						'rule' => 'everywhere'
					],

					[
						'type' => 'exclude',
						'rule' => '404'
					],

					[
						'type' => 'exclude',
						'rule' => 'search'
					],

					[
						'type' => 'exclude',
						'rule' => 'archives'
					]
				],
				'label' => __( 'Display Conditions', 'blc' ),
				'display' => 'modal',
				'design' => 'block',
				// 'divider' => 'top',
				'sync' => [
					'id' => 'header_placements_1'
				]
			],
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'has_transparent_header' => 'yes' ],
		'options' => [
			'transparent_behaviour' => [
				'label' => __( 'Enable on', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',
				'value' => [
					'desktop' => true,
					// 'tablet' => true,
					'mobile' => true,
				],

				'choices' => blocksy_ordered_keys([
					'desktop' => __('Desktop', 'blc'),
					// 'tablet' => __('Tablet', 'blc'),
					'mobile' => __('Mobile', 'blc'),
				]),
			],

		],
	],

];

