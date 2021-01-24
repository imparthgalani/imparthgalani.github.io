<?php

require_once dirname(__FILE__) . '/helpers.php';

class BlocksyExtensionProductReviews {
	public function __construct() {
		add_filter(
			'blocksy:options:cpt:page-title-args',
			function ($args, $cpt) {
				if ($cpt === 'blc-product-review') {
					$args['has_hero_type'] = false;
				}

				return $args;
			},
			10, 2
		);

		add_action('init', [$this, 'declare_cpt']);

		add_action('load-post.php', [$this, 'init_metabox']);
		add_action('load-post-new.php', [$this, 'init_metabox']);

		add_filter('blocksy:single:has-default-hero', function ($def) {
			if (! is_singular('blc-product-review')) {
				return $def;
			}

			return false;
		});

		add_filter(
			'blocksy:hero:type-1:default-alignment',
			function ($default, $prefix) {
				if ($prefix === 'blc-product-review_single') {
					return 'center';
				}

				return $default;
			},
			10, 2
		);

		add_filter('blocksy:archive:render-card-layers', function ($layers, $prefix) {
			if ($prefix !== 'blc-product-review_archive') {
				return $layers;
			}

			$layers['overall_score'] = blocksy_get_product_review_overall_score();

			return $layers;
		}, 10, 2);

		add_filter('blocksy:posts-listing:archive-order:default', function ($default, $prefix) {
			if ($prefix !== 'blc-product-review_archive') {
				return $default;
			}

			$default[] = [
				'id' => 'overall_score',
				'enabled' => true
			];

			return $default;
		}, 10, 2);

		add_filter('blocksy:options:posts-listing-archive-order', function ($option, $prefix) {
			if ($prefix !== 'blc-product-review_archive') {
				return $option;
			}

			$option['value'][] = [
				'id' => 'overall_score',
				'enabled' => true
			];

			$option['settings']['overall_score'] = [
				'label' => __('Overall Score', 'blocksy'),
					/*
				'options' => [
					'excerpt_length' => [
						'label' => __('Length', 'blocksy'),
						'type' => 'ct-number',
						'design' => 'inline',
						'value' => 40,
						'min' => 10,
						'max' => 100,
					],
				],
				*/
			];

			return $option;
		}, 10, 2);

		add_action(
			'blocksy:content:top',
			function () {
				if (! is_singular('blc-product-review')) {
					return;
				}

				echo blc_call_fn(
					['fn' => 'blocksy_render_view'],
					dirname(__FILE__) . '/views/single-top.php',
					[]
				);
			}
		);

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			wp_enqueue_style(
				'blocksy-ext-product-reviews-styles',
				BLOCKSY_URL . 'framework/extensions/product-reviews/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);
		});
	}

	public function init_metabox() {
		add_action('add_meta_boxes', [$this, 'setup_meta_box']);
		add_action('save_post', [$this, 'save_meta_box']);
	}

	public function declare_cpt() {
		$settings = $this->get_settings();

		register_post_type('blc-product-review', [
			'label' => __('Product Reviews', 'blc'),
			'description' => __( 'Product Reviews', 'blc'),
			'menu_icon' => 'dashicons-star-filled',
			'labels' => [
				'name' => __('Product Reviews', 'blc'),
				'singular_name' => __('Product Review', 'blc'),
				'menu_name' => __('Product Reviews', 'blc'),
				'parent_item_colon' => __('Parent Product Review', 'blc'),
				'all_items' => __('All Reviews', 'blc'),
				'view_item' => __('View Product Review', 'blc'),
				'add_new_item' => __('Add New Product Review', 'blc'),
				'add_new' => __('Add New Review', 'blc'),
				'edit_item' => __('Edit Product Review', 'blc'),
				'update_item' => __('Update Product Review', 'blc'),
				'search_items' => __('Search Product Review', 'blc'),
				'not_found' => __('Not Found', 'blc'),
				'not_found_in_trash' => __('Not found in Trash', 'blc')
			],
			'supports' => [
				'comments',
				'title', 'editor', 'excerpt',
				'author', 'thumbnail', 'revisions',
				'custom-fields'
			],
			'show_in_rest' => true,
			'public' => true,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => true,
			'has_archive' => true,
			'can_export' => true,
			'exclude_from_search' => false,
			// 'taxonomies' => array('post_tag'),
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'rewrite' => [
				'slug' => $settings['single_slug']
			],
		]);

		register_taxonomy(
			'blc-product-review-categories',
			[
				'blc-product-review'
			],
			[
				'hierarchical' => true,
				'labels' => [
					'name' => __('Categories', 'blc'),
					'singular_name' => __('Category', 'blc'),
					'search_items' =>  __('Search Category', 'blc'),
					'all_items' => __('All Categories', 'blc'),
					'parent_item' => __('Parent Category', 'blc'),
					'parent_item_colon' => __('Parent Category:', 'blc'),
					'edit_item' => __('Edit Category', 'blc'),
					'update_item' => __('Update Category', 'blc'),
					'add_new_item' => __('Add New Category', 'blc'),
					'new_item_name' => __('New Category Name', 'blc'),
					'menu_name' => __('Categories', 'blc'),
				],
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
                'show_in_rest' => true,
				'rewrite' => [
					'slug' => $settings['category_slug']
				],
			]
		);
	}

	public function setup_meta_box() {
		add_meta_box(
			'blocksy_settings_meta_box',
			sprintf(
				// Translators: %s is the theme name.
				__( '%s Settings', 'blocksy' ),
				__( 'Blocksy', 'blocksy' )
			),
			function ($post) {
				$values = get_post_meta($post->ID, 'blocksy_product_review_options');

				if (empty($values)) {
					$values = [[]];
				}

				$options = blc_call_fn(
					['fn' => 'blocksy_get_options'],
					dirname(__FILE__) . '/metabox.php',
					[],
					false
				);

				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_options_panel() used here escapes the value properly.
				 */
				echo blocksy_output_options_panel(
					[
						'options' => $options,
						'values' => $values[0],
						'id_prefix' => 'ct-post-meta-options',
						'name_prefix' => 'blocksy_product_review_options',
						'attr' => [
							'class' => 'ct-meta-box',
							'data-disable-reverse-button' => 'yes'
						]
					]
				);

				wp_nonce_field(basename(__FILE__), 'blocksy_settings_meta_box');
			},
			'blc-product-review', 'normal', 'default'
		);
	}

	public function save_meta_box($post_id) {
		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		$is_valid_nonce = !! (
			isset($_POST['blocksy_settings_meta_box']) && wp_verify_nonce(
				sanitize_text_field(wp_unslash($_POST['blocksy_settings_meta_box'])),
				basename(__FILE__)
			)
		);

		if ($is_autosave || $is_revision || !$is_valid_nonce) {
			return;
		}

		$values = [];

		if (isset($_POST['blocksy_product_review_options'][blocksy_post_name()])) {
			$values = json_decode(
				wp_unslash($_POST['blocksy_product_review_options'][blocksy_post_name()]),
				true
			);
		}

		update_post_meta(
			$post_id,
			'blocksy_product_review_options',
			$values
		);
	}

	public function get_settings() {
		if (wp_doing_ajax()) {
			$maybe_input = json_decode(file_get_contents('php://input'), true);

			if (
				$maybe_input
				&&
				isset($maybe_input['extension'])
				&&
				$maybe_input['extension'] === 'product-reviews'
				&&
				isset($maybe_input['extAction'])
				&&
				$maybe_input['extAction']['type'] === 'persist'
			) {
				return $maybe_input['extAction']['settings'];
			}
		}

		return get_option('blocksy_ext_product_reviews_settings', [
			'single_slug' => 'product-review',
			'category_slug' => 'product-review-category',
		]);
	}

	public function set_settings($value) {
		update_option('blocksy_ext_product_reviews_settings', $value);
	}
}
