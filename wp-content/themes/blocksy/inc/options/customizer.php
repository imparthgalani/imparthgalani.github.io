<?php
/**
 * Customizer options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */
$custom_post_types = blocksy_get_options('general/custom-post-types');

$extensions_options = apply_filters(
	'blocksy_extensions_customizer_options',
	[]
);

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$options = [
	[
		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'title' => __( 'General Options', 'blocksy' ),
			'priority' => 1,
		],

		'general' => [
			'title' => __( 'General', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/general' ),
		],

		'header' => [
			'title' => __( 'Header', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/header' ),
		],

		'footer' => [
			'title' => __( 'Footer', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/footer' ),
		],

		'sidebar' => [
			'title' => __( 'Sidebar', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/sidebar' ),
		],

		'color' => [
			'title' => __( 'Colors', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/colors' ),
		],

		'typography' => [
			'title' => __( 'Typography', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/typography' ),
		],

		'performance' => [
			'title' => __( 'Performance', 'blocksy' ),
			'container' => [ 'priority' => 1 ],
			'options' => blocksy_get_options( 'general/performance' ),
		],

		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'title' => __( 'Post types', 'blocksy' ),
			'priority' => 2,
		],

		'blog_posts' => [
			'title' => __( 'Blog Posts', 'blocksy' ),
			'container' => [ 'priority' => 2 ],
			'options' => blocksy_get_options( 'posts/blog' ),
		],

		'single_blog_posts' => [
			'title' => __( 'Single Posts', 'blocksy' ),
			'container' => [
				'priority' => 2,
				'type' => 'child',
			],
			'options' => blocksy_get_options( 'posts/post' ),
		],

		'archive_blog_posts_categories' => [
			'title' => __('Categories', 'blocksy'),
			'container' => [
				'priority' => 2,
				'type' => 'child',
			],
			'options' => blocksy_get_options( 'posts/categories' ),
		],

		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'kind' => 'divider',
			'priority' => 2,
		],

		'single_pages' => [
			'title' => __( 'Pages', 'blocksy' ),
			'container' => [ 'priority' => 2 ],
			'options' => blocksy_get_options( 'pages/page' ),
		],

		'author_page' => [
			'title' => __( 'Author Page', 'blocksy' ),
			'container' => [ 'priority' => 2 ],
			'options' => blocksy_get_options( 'pages/author-page' ),
		],

		'search_page' => [
			'title' => __( 'Search Page', 'blocksy' ),
			'container' => [ 'priority' => 2 ],
			'options' => blocksy_get_options( 'pages/search-page' ),
		],
	],


	function_exists('is_shop') ? [
		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'kind' => 'divider',
			'priority' => 2,
		],

		'woocomerrce_posts_archives' => [
			'title' => __( 'WooCommerce', 'blocksy' ),
			'container' => [
				'priority' => 2.2
			],
			// 'only_if_exists' => true,
			'options' => [
				'woocommerce_general' => [
					'title' => __( 'General', 'blocksy' ),
					'container' => [
						'priority' => 2
					],
					'options' => blocksy_get_options( 'posts/woo-general' ),
				],

				'woocomerrce_posts_archives' => [
					'title' => __( 'Product Archives', 'blocksy' ),
					'container' => [
						'priority' => 2
					],
					'options' => blocksy_get_options( 'posts/woo-categories' ),
				],

				'woocomerrce_single' => [
					'title' => __( 'Single Product', 'blocksy' ),
					'container' => [
						'priority' => 2,
						// 'type' => 'child'
					],
					// 'only_if_exists' => true,
					'options' => blocksy_get_options( 'posts/woo-single' ),
				],

				'woocommerce_checkout' => [
					'title' => __('Checkout Page', 'blocksy'),
					'container' => [
						'priority' => 2,
						// 'type' => 'child'
					],
					'only_if_exists' => true,
					'options' => []
				],
			]
		],
	] : [],

	$custom_post_types,

	[
		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'title' => __( 'Visitor Engagement', 'blocksy' ),
			'priority' => 6,
		],

		'general_visitor_engagement' => [
			'title' => __('General', 'blocksy'),
			'container' => [ 'priority' => 6 ],
			'options' => blocksy_get_options( 'engagement/general' ),
		],

		'social_accounts' => [
			'title' => __( 'Social Networks', 'blocksy' ),
			'container' => [ 'priority' => 6 ],
			'options' => blocksy_get_options( 'engagement/social-accounts' ),
		],
	],

	apply_filters(
		'blocksy_misc_end_section_customizer_options',
		[]
	),

	empty($extensions_options) ? [] : [

		blocksy_rand_md5() => [
			'type' => 'ct-group-title',
			'title' => __( 'Extensions', 'blocksy' ),
			'priority' => 7,
		],

	],

	$extensions_options
];
