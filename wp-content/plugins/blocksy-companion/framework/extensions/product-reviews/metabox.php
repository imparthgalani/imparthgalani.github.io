<?php

$options = [

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'gallery' => [
				'type' => 'ct-multi-image-uploader',
				'label' => __('Gallery', 'blc'),
				'design' => 'inline',
				'value' => []
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_button_label' => [
				'type' => 'text',
				'label' => __('Affiliate Button Label', 'blc'),
				'design' => 'inline',
				'value' => __('Buy Now', 'blc')
			],

			'product_link' => [
				'type' => 'text',
				'label' => __('Affiliate Link', 'blc'),
				'design' => 'inline',
				'value' => '#'
			],

			/*
			'product_button_icon' => [
				'type' => 'icon-picker',
				'label' => __('Button Icon', 'blc'),
				'design' => 'inline',
				'value' => [
					'icon' => 'fas fa-shopping-cart'
				]
			],
			 */

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_read_content_button_label' => [
				'type' => 'text',
				'label' => __('Read More Button Label', 'blc'),
				'design' => 'inline',
				'value' => __('Read More', 'blc')
			],

			/*
			'product_read_content_button_icon' => [
				'type' => 'icon-picker',
				'label' => __('Button Icon', 'blc'),
				'design' => 'inline',
				'value' => [
					'icon' => 'fas fa-arrow-down'
				]
			],
			 */

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_description' => [
				'type' => 'wp-editor',
				'label' => __('Small Description', 'blc'),
				'value' => '',
				'design' => 'inline',
			]

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Rating', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'scores' => [
				'type' => 'ct-addable-box',
				'label' => __('Scores', 'blc'),
				'design' => 'inline',
				'preview-template' => '<%= label %> (<%= score === 1 ? "1 star" : score + " stars" %>)',

				'inner-options' => [
					'label' => [
						'type' => 'text',
						'value' => 'Default'
					],

					'score' => [
						'type' => 'ct-number',
						'value' => 5,
						'min' => 1,
						'max' => 5
					]
				],

				'value' => [
					/*
					[
						'label' => 'Features',
						'score' => 5
					],

					[
						'label' => 'Quality',
						'score' => 5
					]
					 */
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_specs' => [
				'type' => 'ct-addable-box',
				'label' => __('Product specs', 'blc'),
				'design' => 'inline',
				'preview-template' => '<%= label %>',

				'inner-options' => [
					'label' => [
						'type' => 'text',
						'value' => 'Default'
					],

					'value' => [
						'type' => 'text',
						'value' => ''
					]
				],

				'value' => []
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_pros' => [
				'type' => 'ct-addable-box',
				'label' => __('Pros', 'blc'),
				'design' => 'inline',
				'preview-template' => '<%= label %>',

				'inner-options' => [
					'label' => [
						'type' => 'text',
						'value' => 'Default'
					],
				],

				'value' => []
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'product_cons' => [
				'type' => 'ct-addable-box',
				'label' => __('Cons', 'blc'),
				'design' => 'inline',
				'preview-template' => '<%= label %>',

				'inner-options' => [
					'label' => [
						'type' => 'text',
						'value' => 'Default'
					],
				],

				'value' => []
			],

		],
	],

	// blocksy_rand_md5() => [
	// 	'title' => __( 'Design', 'blocksy' ),
	// 	'type' => 'tab',
	// 	'options' => [

	// 	],
	// ],
];

