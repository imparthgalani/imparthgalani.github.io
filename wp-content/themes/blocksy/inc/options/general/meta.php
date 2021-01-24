<?php

if (! isset($skip_sync_id)) {
	$skip_sync_id = null;
}

if (! isset($sync_id)) {
	$sync_id = null;
}

if (! isset($is_cpt)) {
	$is_cpt = false;
}

if (! isset($has_label)) {
	$has_label = false;
}

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($is_page)) {
	$is_page = false;
}

if (! isset($item_style_type)) {
	$item_style_type = 'ct-radio';
}

if (! isset($item_divider_type)) {
	$item_divider_type = 'ct-radio';
}

if (! isset($meta_elements)) {
	$meta_elements = blocksy_post_meta_defaults([
		[
			'id' => 'author',
			'enabled' => true,
		],

		[
			'id' => 'post_date',
			'enabled' => true,
		],

		[
			'id' => 'updated_date',
			'enabled' => false,
		],

		[
			'id' => 'categories',
			'enabled' => true,
		],

		[
			'id' => 'comments',
			'enabled' => true,
		],

		[
			'id' => 'tags',
			'enabled' => false,
		]
	]);
}

$date_format_options = [
	blocksy_rand_md5() => [
		'type' => 'ct-group',
		'attr' => [ 'data-columns' => '1' ],
		'options' => [
			'date_format_source' => [
				'label' => __( 'Date Format', 'blocksy' ),
				'type' => 'ct-radio',
				'value' => 'default',
				'view' => 'text',
				'choices' => [
					'default' => __( 'Default', 'blocksy' ),
					'custom' => __( 'Custom', 'blocksy' ),
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'date_format_source' => 'custom'
				],
				'options' => [
					'date_format' => [
						'label' => false,
						'type' => 'text',
						'design' => 'block',
						'value' => 'M j, Y',
						// translators: The interpolations addes a html link around the word.
						'desc' => sprintf(
							__('Date format %sinstructions%s.', 'blocksy'),
							'<a href="https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples" target="_blank">',
							'</a>'
						),
						'disableRevertButton' => true,
					],
				],
			],
		],
	],
];

$options = [
	$prefix . 'meta_elements' => [
		'label' => $has_label ? __( 'Meta Elements', 'blocksy' ) : false,
		'type' => 'ct-layers',
		'wrapperAttr' => [ 'data-layer' => 'inner' ],
		'itemClass' => 'ct-inner-layer',
		'manageable' => true,
		'value' => $meta_elements,
		'sync' => $sync_id ? $sync_id : 'refresh',

		'settings' => array_merge([
			'author' => [
				'label' => __('Author', 'blocksy'),
				'options' => [
					'has_author_avatar' => [
						'label' => __( 'Author Avatar', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => ['has_author_avatar' => 'yes'],
						'options' => [
							'avatar_size' => array_merge([
								'label' => __('Avatar Size', 'blocksy'),
								'type' => 'ct-number',
								'design' => 'inline',
								'value' => 25,
								'min' => 15,
								'max' => 50,
							], $skip_sync_id ? [
								'sync' => $skip_sync_id
							] : []),
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'meta_type' => 'label' ],
						'values_source' => 'parent',
						'options' => [
							'label' => [
								'type' => 'text',
								'design' => 'inline',
								'value' => __('By', 'blocksy')
							],
						],
					],
				],
			],

			'comments' => [
				'label' => __('Comments', 'blocksy'),
			],

			'post_date' => [
				'label' => __('Published Date', 'blocksy'),
				'options' => [
					$date_format_options,

					[
						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'meta_type' => 'label' ],
							'values_source' => 'parent',
							'options' => [
								'label' => [
									'type' => 'text',
									'design' => 'inline',
									'value' => __('On', 'blocksy')
							],
							],
						],
					],
				],
			],

			'updated_date' => [
				'label' => __('Updated Date', 'blocksy'),
				'options' => [
					$date_format_options,

					[
						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'meta_type' => 'label' ],
							'values_source' => 'parent',
							'options' => [
								'label' => [
									'type' => 'text',
									'design' => 'inline',
									'value' => __('On', 'blocksy')
							],
							],
						],
					],
				],
			],

		], !$is_page ? [
			'categories' => [
				'label' => $is_cpt ? __('Taxonomies', 'blocksy') : __('Categories', 'blocksy'),
				'options' => [
					'style' => array_merge([
						'label' => __( 'Categories Style', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'simple',
						'setting' => [ 'transport' => 'postMessage' ],
						'view' => 'text',
						'choices' => [
							'simple' => __( 'Simple', 'blocksy' ),
							'pill' => __( 'Button', 'blocksy' ),
							'underline' => __( 'Underline', 'blocksy' ),
						]
					], $skip_sync_id ? [
						'sync' => $skip_sync_id
					] : []),

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'meta_type' => 'label' ],
						'values_source' => 'parent',
						'options' => [
							'label' => [
								'type' => 'text',
								'design' => 'inline',
								'value' => __('In', 'blocksy')
							],
						],
					],
				],
			],

			'tags' => [
				'label' => __('Tags', 'blocksy'),
				'options' => [
					'style' => array_merge([
						'label' => __( 'Tags Style', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'simple',
						'setting' => [ 'transport' => 'postMessage' ],
						'view' => 'text',
						'choices' => [
							'simple' => __( 'Simple', 'blocksy' ),
							'pill' => __( 'Button', 'blocksy' ),
							'underline' => __( 'Underline', 'blocksy' ),
						],
					], $skip_sync_id ? [
						'sync' => $skip_sync_id
					] : []),

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'meta_type' => 'label' ],
						'values_source' => 'parent',
						'options' => [
							'label' => [
								'type' => 'text',
								'design' => 'inline',
								'value' => __('In', 'blocksy')
							],
						],
					],
				],
			]
		] : []),
	],

	$prefix . 'meta_type' => array_merge([
		'label' => __('Items Style', 'blocksy'),
		'type' => $item_style_type,
		'value' => 'simple',
		'view' => 'text',
		'choices' => [
			'simple' => __('Simple', 'blocksy'),
			'label' => __('Labels', 'blocksy'),
			'icons' => __('Icons', 'blocksy'),
		],
	], $sync_id ? [
		'sync' => $sync_id
	] : []),

	$prefix . 'meta_divider' => array_merge([
		'label' => __('Items Divider', 'blocksy'),
		'type' => $item_divider_type,
		'value' => 'slash',
		'view' => 'text',
		'attr' => [ 'data-type' => 'meta-divider' ],
		'choices' => [
			'none' => __('none', 'blocksy'),
			'slash' => '',
			'line' => '',
			'circle' => '',
		],
	], $skip_sync_id ? [
		'sync' => $skip_sync_id
	] : [
		'sync' => 'live'
	]),
];

