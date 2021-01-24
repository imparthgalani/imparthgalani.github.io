<?php
/**
 * Posts widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$all_post_types = [
	'post' => __('Posts', 'blc'),
	'page' => __('Pages', 'blc'),
];

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

$cpt_options = [];

foreach ($all_post_types as $custom_post_type => $label) {
	if ($custom_post_type === 'page') {
		continue;
	}

	$opt_id = 'category';
	$label = __('Category', 'blc');
	$label_multiple = __('All categories', 'blc');
	$taxonomy = 'category';

	if ($custom_post_type !== 'post') {
		$opt_id = $custom_post_type . '_taxonomy';
		$label = __('Taxonomy', 'blc');
		$label_multiple = __('All taxonomies', 'blc');

		$taxonomies = get_object_taxonomies($custom_post_type);

		if (count($taxonomies) > 0) {
			$taxonomy = $taxonomies[0];
		} else {
			$taxonomy = 'nonexistent';
		}
	}

	$categories = get_terms([
		'taxonomy' => $taxonomy,
		// 'post_type' => $custom_post_type,
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => false
	]);

	$category_choices = [
		'all_categories' => $label_multiple
	];

	if (! is_wp_error($categories)) {
		foreach ($categories as $category) {
			$category_choices[$category->term_id] = $category->name;
		}
	}

	$cpt_options[blocksy_rand_md5()] = [
		'type' => 'ct-condition',
		'condition' => [
			'post_type_source' => $custom_post_type,
			'post_source' => '!custom'
		],
		'options' => [
			$opt_id => [
				'type' => 'ct-select',
				'label' => $label,
				'value' => 'all_categories',
				'choices' => blocksy_ordered_keys($category_choices),
				'design' => 'inline',
			],
		]
	];
}

$options = [
	[
		'title' => [
			'type' => 'text',
			'label' => __('Title', 'blc'),
			'field_attr' => ['id' => 'widget-title'],
			'design' => 'inline',
			'value' => __('Posts', 'blc'),
		],

		'posts_type' => [
			'type' => 'ct-select',
			'label' => __('Widget Design', 'blc'),
			'value' => 'small-thumbs',
			'design' => 'inline',
			'choices' => blocksy_ordered_keys(
				[
					'no-thumbs' => __( 'Without Thumbnails', 'blc' ),
					'small-thumbs' => __( 'Small Thumbnails', 'blc' ),
					'large-thumbs' => __( 'Large Thumbnails', 'blc' ),
					'large-small' => __( 'First Thumbnail Large', 'blc' ),
					'rounded' => __( 'Rounded Thumbnails', 'blc' ),
					'numbered' => __( 'Numbered', 'blc' ),
				]
			),
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [
				'posts_type' => 'small-thumbs|large-thumbs|large-small',
			],
			'options' => [

				'post_widget_image_ratio' => [
					'label' => __( 'Image Ratio', 'blocksy' ),
					'type' => 'ct-ratio',
					'value' => 'original',
					'design' => 'inline',
				],

			],
		],

		'post_type_source' => [
			'type' => 'ct-select',
			'label' => __( 'Post Type', 'blc' ),
			'value' => 'post',
			'design' => 'inline',
			'choices' => blocksy_ordered_keys($all_post_types)
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => ['post_type_source' => '!page'],
			'options' => [
				'post_source' => [
					'type' => 'ct-select',
					'label' => __( 'Source', 'blc' ),
					'value' => 'categories',
					'design' => 'inline',
					'choices' => blocksy_ordered_keys(
						[
							'categories' => __('Taxonomies', 'blc'),
							'custom' => __( 'Custom Query', 'blc' ),
						]
					),
				],
			],
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => ['post_type_source' => 'page'],
			'options' => [
				'page_source' => [
					'type' => 'ct-select',
					'label' => __('Source', 'blc'),
					'value' => 'default',
					'design' => 'inline',
					'choices' => blocksy_ordered_keys(
						[
							'default' => __('Default', 'blc'),
							'custom' => __('Custom Query', 'blc'),
						]
					),
				],
			],
		],
	],

	$cpt_options,

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'post_type_source' => '!page',
			'post_source' => '!custom'
		],
		'options' => [
			'type' => [
				'type' => 'ct-select',
				'label' => __( 'Sort by', 'blc' ),
				'value' => 'commented',
				'design' => 'inline',
				'choices' => blocksy_ordered_keys(
					[
						'recent' => __( 'Recent', 'blc' ),
						'commented' => __( 'Most Commented', 'blc' ),
					]
				),
			],

			'days' => [
				'type' => 'ct-select',
				'label' => __( 'Order by', 'blc' ),
				'value' => 'all_time',
				'design' => 'inline',
				'choices' => blocksy_ordered_keys(
					[
						'all_time' => __( 'All Time', 'blc' ),
						'7' => __( '1 Week', 'blc' ),
						'30' => __( '1 Month', 'blc' ),
						'90' => __( '3 Months', 'blc' ),
						'180' => __( '6 Months', 'blc' ),
						'360' => __( '1 Year', 'blc' ),
					]
				),
			],

			'posts_number' => [
				'type' => 'ct-number',
				'label' => __( 'Posts Count', 'blc' ),
				'min' => 1,
				'max' => 30,
				'value' => 5,
				'design' => 'inline',
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'post_type_source' => '!page',
			'post_source' => 'custom'
		],
		'options' => [

			'post_id' => [
				'label' => __( 'Posts ID', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'desc' => sprintf(
					__('Separate posts ID by comma. How to find the %spost ID%s.', 'blocksy'),
					'<a href="https://www.wpbeginner.com/beginners-guide/how-to-find-post-category-tag-comments-or-user-id-in-wordpress/" target="_blank">',
					'</a>'
				),
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'post_type_source' => 'page',
			'page_source' => 'custom'
		],
		'options' => [

			'page_id' => [
				'label' => __( 'Pages ID', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'desc' => sprintf(
					__('Separate pages ID by comma. How to find the %spage ID%s.', 'blocksy'),
					'<a href="https://www.wpbeginner.com/beginners-guide/how-to-find-post-category-tag-comments-or-user-id-in-wordpress/" target="_blank">',
					'</a>'
				),
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [
			'post_type_source' => 'page',
			'page_source' => '!custom'
		],
		'options' => [
			'page_number' => [
				'type' => 'ct-number',
				'label' => __( 'Pages Count', 'blc' ),
				'min' => 1,
				'max' => 30,
				'value' => 5,
				'design' => 'inline',
			],
		],
	],

	'display_date' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Date', 'blc' ),
		'value' => 'no',
	],

	'display_comments' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Comments', 'blc' ),
		'value' => 'no',
	],

	'display_excerpt' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Excerpt', 'blc' ),
		'value' => 'no',
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'display_excerpt' => 'yes' ],
		'options' => [

			'excerpt_lenght' => [
				'type' => 'ct-number',
				'label' => __( 'Excerpt Lenght', 'blc' ),
				'min' => 5,
				'max' => 30,
				'value' => 10,
				'design' => 'inline',
			],

		],
	],
];

