<?php

/**
 * Theme Update
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

class Blocksy_Db_Versioning {
	public function __construct() {
		if (is_admin()) {
			add_action('admin_init', [$this, 'init'], 3);
		} else {
			add_action('wp', [$this, 'init'], 3);
		}
	}

	public function init() {
		$saved_version = get_option('blocksy_db_version', '1.0.0');

		$theme = blocksy_get_wp_parent_theme();
		$current_version = $theme->get('Version');

		foreach ($this->get_patches() as $single_patch) {
			if (
				version_compare(
					$saved_version,
					$single_patch['version'],
					'<'
				)
			) {
				call_user_func($single_patch['cb']);
			}
		}

		if (version_compare($saved_version, $current_version, '<')) {
			do_action('blocksy:cache-manager:purge-all');
			do_action('blocksy:dynamic-css:regenere_css_files');
			update_option('blocksy_db_version', $current_version);
		}
	}

	public function get_patches() {
		return [
			[
				'version' => '1.6.5',
				'cb' => [$this, 'v_1_6_5']
            ],

			[
				'version' => '1.7.17',
				'cb' => [$this, 'v_1_7_17']
			],

			[
				'version' => '1.7.18',
				'cb' => [$this, 'v_1_7_18']
			],

			[
				'version' => '1.7.25',
				'cb' => [$this, 'v_1_7_25']
			],

			[
				'version' => '1.7.30',
				'cb' => [$this, 'v_1_7_30']
			],

			[
				'version' => '1.7.36',
				'cb' => [$this, 'v_1_7_36']
			],

			[
				'version' => '1.7.41',
				'cb' => [$this, 'v_1_7_41']
			],

			[
				'version' => '1.7.55',
				'cb' => [$this, 'v_1_7_55']
			],

			[
				'version' => '1.7.56',
				'cb' => [$this, 'v_1_7_56']
			]
		];
	}

	public function v_1_6_5() {
		if (get_theme_mod('narrowContainerWidth', null)) {
			$narrowContainerWidth = get_theme_mod('narrowContainerWidth', null);

			if (
				intval($narrowContainerWidth) <= 100
				&&
				intval($narrowContainerWidth) >= 50
			) {
				remove_theme_mod('narrowContainerWidth');
			}
		}
	}

	public function v_1_7_17() {
		if (
			get_theme_mod('has_trending_block', '__empty__') === 'yes'
			&&
			class_exists('\Blocksy\Plugin')
		) {
			$manager = \Blocksy\Plugin::instance()->extensions;
			$manager->activate_extension('trending');
		}

		// TODO: options to migrate
		//
		// Page title:
		// single_blog_post_title_enabled -> single_blog_post_hero_enabled
		// woo_categories_has_page_title -> woo_categories_hero_enabled
		// blog_page_title_enabled -> blog_hero_enabled
		// cpt_single_title_enabled -> cpt_single_hero_enabled
		// cpt_archive_title_enabled -> cpt_archive_hero_enabled
		// categories_has_page_title -> categories_hero_enabled
		// search_page_title_enabled -> search_hero_enabled
		// author_page_title -> author_hero_enabled
		// single_page_title_enabled -> single_page_hero_enabled
		//
		//
		// Structure:
		//
		// single_content_style -> single_blog_post_content_style
		// post_background -> single_blog_post_background
		// post_content_background -> single_blog_post_content_background
		// postContentBoxedSpacing -> single_blog_post_content_boxed_spacing
		// postContentBoxedRadius -> single_blog_post_content_boxed_radius
		// postContentBoxedShadow -> single_blog_post_content_boxed_shadow
		//
		// page_content_style -> single_page_content_style
		// page_background -> single_page_background
		// page_content_background -> single_page_content_background
		// pageContentBoxedSpacing -> single_page_content_boxed_spacing
		// pageContentBoxedRadius -> single_page_content_boxed_radius
		// pageContentBoxedShadow -> single_page_content_boxed_shadow

		$this->migrate_options([
			[
				'old' => 'single_blog_post_title_enabled',
				'new' => 'single_blog_post_hero_enabled'
			],

			[
				'old' => 'woo_categories_has_page_title',
				'new' => 'woo_categories_hero_enabled'
			],

			[
				'old' => 'blog_page_title_enabled',
				'new' => 'blog_hero_enabled'
			],

			[
				'old' => 'categories_has_page_title',
				'new' => 'categories_hero_enabled'
			],

			[
				'old' => 'search_page_title_enabled',
				'new' => 'search_hero_enabled'
			],

			[
				'old' => 'author_page_title',
				'new' => 'author_hero_enabled'
			],

			[
				'old' => 'single_page_title_enabled',
				'new' => 'single_page_hero_enabled'
			],

			// Structure
			[
				'old' => 'single_content_style',
				'new' => 'single_blog_post_content_style'
			],

			[
				'old' => 'post_background',
				'new' => 'single_blog_post_background'
			],

			[
				'old' => 'post_content_background',
				'new' => 'single_blog_post_content_background',
			],

			[
				'old' => 'postContentBoxedSpacing',
				'new' => 'single_blog_post_content_boxed_spacing'
			],

			[
				'old' => 'postContentBoxedRadius',
				'new' => 'single_blog_post_content_boxed_radius'
			],

			[
				'old' => 'postContentBoxedShadow',
				'new' => 'single_blog_post_content_boxed_shadow'
			],

			[
				'old' => 'page_content_style',
				'new' => 'single_page_content_style'
			],

			[
				'old' => 'page_background',
				'new' => 'single_page_background'
			],

			[
				'old' => 'page_content_background',
				'new' => 'single_page_content_background'
			],

			[
				'old' => 'pageContentBoxedSpacing',
				'new' => 'single_page_content_boxed_spacing'
			],

			[
				'old' => 'pageContentBoxedRadius',
				'new' => 'single_page_content_boxed_radius'
			],

			[
				'old' => 'pageContentBoxedShadow',
				'new' => 'single_page_content_boxed_shadow'
			],

			[
				'old' => 'has_share_box',
				'new' => 'single_blog_post_has_share_box'
			],

			[
				'old' => 'share_box_type',
				'new' => 'single_blog_post_share_box_type'
			],

			[
				'old' => 'share_box1_location',
				'new' => 'single_blog_post_share_box1_location'
			],

			[
				'old' => 'share_box2_location',
				'new' => 'single_blog_post_share_box2_location'
			],

			[
				'old' => 'share_facebook',
				'new' => 'single_blog_post_share_facebook'
			],

			[
				'old' => 'share_twitter',
				'new' => 'single_blog_post_share_twitter'
			],

			[
				'old' => 'share_pinterest',
				'new' => 'single_blog_post_share_pinterest'
			],

			[
				'old' => 'share_linkedin',
				'new' => 'single_blog_post_share_linkedin'
			],

			[
				'old' => 'share_reddit',
				'new' => 'single_blog_post_share_reddit'
			],

			[
				'old' => 'share_hacker_news',
				'new' => 'single_blog_post_share_hacker_news'
			],

			[
				'old' => 'share_vk',
				'new' => 'single_blog_post_share_vk'
			],

			[
				'old' => 'share_ok',
				'new' => 'single_blog_post_share_ok'
			],

			[
				'old' => 'share_telegram',
				'new' => 'single_blog_post_share_telegram'
			],

			[
				'old' => 'share_viber',
				'new' => 'single_blog_post_share_viber'
			],

			[
				'old' => 'share_whatsapp',
				'new' => 'single_blog_post_share_whatsapp'
			],

			[
				'old' => 'share_box_visibility',
				'new' => 'single_blog_post_share_box_visibility'
			],

			[
				'old' => 'shareItemsIconColor',
				'new' => 'single_blog_post_share_items_icon_color'
			],

			[
				'old' => 'shareItemsIconColor',
				'new' => 'single_blog_post_share_items_border'
			],

			[
				'old' => 'topShareBoxSpacing',
				'new' => 'single_blog_post_top_share_box_spacing'
			],

			[
				'old' => 'bottomShareBoxSpacing',
				'new' => 'single_blog_post_bottom_share_box_spacing'
			],

			[
				'old' => 'shareItemsIcon',
				'new' => 'single_blog_post_share_items_icon'
			],

			[
				'old' => 'shareItemsBackground',
				'new' => 'single_blog_post_share_items_background'
			],

			[
				'old' => 'has_author_box',
				'new' => 'single_blog_post_has_author_box'
			],

			[
				'old' => 'single_author_box_type',
				'new' => 'single_blog_post_single_author_box_type',
			],

			[
				'old' => 'single_author_box_social',
				'new' => 'single_blog_post_single_author_box_social'
			],

			[
				'old' => 'singleAuthorBoxSpacing',
				'new' => 'single_blog_post_single_author_box_spacing'
			],

			[
				'old' => 'author_box_visibility',
				'new' => 'single_blog_post_author_box_visibility'
			],

			[
				'old' => 'singleAuthorBoxBorder',
				'new' => 'single_blog_post_single_author_box_border'
			],

			[
				'old' => 'singleAuthorBoxBackground',
				'new' => 'single_blog_post_single_author_box_background'
			],

			[
				'old' => 'singleAuthorBoxShadow',
				'new' => 'single_blog_post_single_author_box_shadow'
			],


			[
				'old' => 'has_post_nav',
				'new' => 'single_blog_post_has_post_nav'
			],

			[
				'old' => 'has_post_nav_title',
				'new' => 'single_blog_post_single_blog_post'
			],

			[
				'old' => 'has_post_nav_thumb',
				'new' => 'single_blog_post_has_post_nav_thumb'
			],

			[
				'old' => 'postNavSpacing',
				'new' => 'single_blog_post_post_nav_spacing'
			],

			[
				'old' => 'post_nav_visibility',
				'new' => 'single_blog_post_post_nav_visibility'
			],

			[
				'old' => 'postsNavFontColor',
				'new' => 'single_blog_post_posts_nav_font_color'
			],

			[
				'old' => 'has_related_posts',
				'new' => 'single_blog_post_has_related_posts'
			],

			[
				'old' => 'related_posts_count',
				'new' => 'single_blog_post_related_posts_count'
			],

			[
				'old' => 'related_posts_columns',
				'new' => 'single_blog_post_related_posts_columns'
			],

			[
				'old' => 'related_criteria',
				'new' => 'single_blog_post_related_criteria'
			],

			[
				'old' => 'related_featured_image_ratio',
				'new' => 'single_blog_post_related_featured_image_ratio'
			],

			[
				'old' => 'related_label',
				'new' => 'single_blog_post_related_label'
			],

			[
				'old' => 'related_label_wrapper',
				'new' => 'single_blog_post_related_label_wrapper'
			],

			[
				'old' => 'related_posts_containment',
				'new' => 'single_blog_post_related_posts_containment'
			],

			[
				'old' => 'related_location',
				'new' => 'single_blog_post_related_location'
			],

			[
				'old' => 'related_structure',
				'new' => 'single_blog_post_related_structure'
			],

			[
				'old' => 'related_structure',
				'new' => 'single_blog_post_related_structure'
			],

			[
				'old' => 'relatedNarrowWidth',
				'new' => 'single_blog_post_related_narrow_width'
			],

			[
				'old' => 'related_visibility',
				'new' => 'single_blog_post_related_visibility'
			],

			[
				'old' => 'relatedPostsLabelColor',
				'new' => 'single_blog_post_related_posts_label_color'
			],

			[
				'old' => 'relatedPostsLinkColor',
				'new' => 'single_blog_post_related_posts_link_color'
			],

			[
				'old' => 'relatedPostsMetaColor',
				'new' => 'single_blog_post_related_posts_meta_color'
			],

			[
				'old' => 'relatedThumbRadius',
				'new' => 'single_blog_post_related_thumb_radius'
			],

			[
				'old' => 'related_posts_background',
				'new' => 'single_blog_post_related_posts_background'
			],

			[
				'old' => 'related_posts_container_spacing',
				'new' => 'single_blog_post_related_posts_container_spacing'
			],

			// Comments
			[
				'old' => 'post_has_comments',
				'new' => 'single_blog_post_has_comments'
			],

			[
				'old' => 'post_comments_containment',
				'new' => 'single_blog_post_comments_containment'
			],

			[
				'old' => 'post_comments_structure',
				'new' => 'single_blog_post_comments_structure'
			],

			[
				'old' => 'post_commentsNarrowWidth',
				'new' => 'single_blog_post_comments_narrow_width'
			],

			[
				'old' => 'post_commentsFontColor',
				'new' => 'single_blog_post_comments_font_color'
			],

			[
				'old' => 'post_comments_background',
				'new' => 'single_blog_post_comments_background'
			],

			[
				'old' => 'page_has_comments',
				'new' => 'single_page_has_comments'
			],

			[
				'old' => 'page_comments_containment',
				'new' => 'single_page_comments_containment'
			],

			[
				'old' => 'page_comments_structure',
				'new' => 'single_page_comments_structure'
			],

			[
				'old' => 'page_commentsNarrowWidth',
				'new' => 'single_page_comments_narrow_width'
			],

			[
				'old' => 'page_commentsFontColor',
				'new' => 'single_page_comments_font_color'
			],

			[
				'old' => 'page_comments_background',
				'new' => 'single_page_comments_background'
			],

			[
				'old' => 'woo_has_sidebar',
				'new' => 'woo_categories_has_sidebar'
			],

			[
				'old' => 'woo_sidebar_position',
				'new' => 'woo_categories_sidebar_position'
			],

			[
				'old' => 'woo_pagination_global_type',
				'new' => 'woo_categories_pagination_global_type'
			],

			[
				'old' => 'woo_load_more_label',
				'new' => 'woo_categories_load_more_label'
			],

			[
				'old' => 'woo_paginationSpacing',
				'new' => 'woo_categories_paginationSpacing'
			],

			[
				'old' => 'woo_simplePaginationFontColor',
				'new' => 'woo_categories_simplePaginationFontColor'
			],

			[
				'old' => 'woo_paginationButtonText',
				'new' => 'woo_categories_paginationButtonText'
			],

			[
				'old' => 'woo_paginationButton',
				'new' => 'woo_categories_paginationButton'
			],

			[
				'old' => 'woo_paginationDivider',
				'new' => 'woo_categories_paginationDivider'
			]
		]);
	}

	public function v_1_7_18() {
		$section_value = blocksy_manager()->header_builder->get_section_value();

		$old_section_id = $section_value['current_section'];

		if ($old_section_id !== 'type-1') {
			$section_value['current_section'] = 'type-1';
			$old_section = null;

			foreach ($section_value['sections'] as $current_section) {
				if ($current_section['id'] === $old_section_id) {
					$old_section = $current_section;
				}
			}

			if ($old_section && $section_value['sections'][0]['id'] === 'type-1') {
				if (isset($old_section['items'])) {
					$section_value['sections'][0]['items'] = $old_section['items'];
				}

				if (isset($old_section['desktop'])) {
					$section_value['sections'][0]['desktop'] = $old_section['desktop'];
				}

				if (isset($old_section['mobile'])) {
					$section_value['sections'][0]['mobile'] = $old_section['mobile'];
				}

				if (isset($old_section['settings'])) {
					$section_value['sections'][0]['settings'] = $old_section['settings'];
				}
			}

			set_theme_mod('header_placements', $section_value);
		}

		$render = new Blocksy_Footer_Builder_Render();
		$section_value = $render->get_section_value();

		$old_section_id = $section_value['current_section'];

		if ($old_section_id !== 'type-1') {
			$section_value['current_section'] = 'type-1';
			$old_section = null;

			foreach ($section_value['sections'] as $current_section) {
				if ($current_section['id'] === $old_section_id) {
					$old_section = $current_section;
				}
			}

			if ($old_section && $section_value['sections'][0]['id'] === 'type-1') {
				if (isset($old_section['rows'])) {
					$section_value['sections'][0]['rows'] = $old_section['rows'];
				}

				if (isset($old_section['settings'])) {
					$section_value['sections'][0]['settings'] = $old_section['settings'];
				}
			}

			set_theme_mod('footer_placements', $section_value);
		}
	}

	public function v_1_7_25() {
		$current_transparent_header = null;
		$transparent_index = null;
		$section_value = blocksy_manager()->header_builder->get_section_value();

		foreach ($section_value['sections'] as $index => $current_section) {
			if ($current_section['id'] === 'ct-custom-transparent') {
				$current_transparent_header = $current_section;
				$transparent_index = $index;
			}
		}

		if (! $current_transparent_header) {
			return;
		}

		if (! class_exists('\Blocksy\Plugin')) {
			return;
		}

		$conditions = \Blocksy\Plugin::instance()->header->get_conditions();

		$transparent_header_conditions = null;

		foreach ($conditions as $index => $single_condition) {
			if ($single_condition['id'] === 'ct-custom-transparent') {
				$transparent_header_conditions = $single_condition['conditions'];

				$conditions[$index]['conditions'] = [];
			}
		}

		\Blocksy\Plugin::instance()->header->set_conditions($conditions);

		if (
			! $transparent_header_conditions
			||
			empty($transparent_header_conditions)
		) {
			return;
		}

		if (! isset($section_value['sections'][0]['settings'])) {
			$section_value['sections'][0]['settings'] = [];
		}

		$section_value['sections'][0]['settings']['has_transparent_header'] = 'yes';
		$section_value['sections'][0]['settings']['transparent_conditions'] = $transparent_header_conditions;

		set_theme_mod('header_placements', $section_value);
	}

	public function v_1_7_30() {
		$transform = function ($old, $new) {
			if (! isset($old['desktop'])) {
				return $old;
			}

			return [
				'desktop' => blocksy_spacing_value([
					'linked' => true,
					'top' => $old['desktop'],
					'left' => $old['desktop'],
					'right' => $old['desktop'],
					'bottom' => $old['desktop'],
				]),

				'tablet' => blocksy_spacing_value([
					'linked' => true,
					'top' => $old['tablet'],
					'left' => $old['tablet'],
					'right' => $old['tablet'],
					'bottom' => $old['tablet'],
				]),

				'mobile' => blocksy_spacing_value([
					'linked' => true,
					'top' => $old['mobile'],
					'left' => $old['mobile'],
					'right' => $old['mobile'],
					'bottom' => $old['mobile'],
				]),
			];
		};

		$this->migrate_options([
			[
				'old' => 'single_blog_post_content_boxed_spacing',
				'new' => 'single_blog_post_boxed_content_spacing',
				'transform' => $transform,
			],

			[
				'old' => 'single_page_content_boxed_spacing',
				'new' => 'single_page_boxed_content_spacing',
				'transform' => $transform,
			],
		]);
	}

	public function v_1_7_36() {
		if (get_theme_mod('custom_logo')) {
			return;
		}

		$items = blocksy_manager()->header_builder->get_section_value()['sections'][0]['items'];

		foreach ($items as $single_item) {
			if ($single_item['id'] !== 'logo') {
				continue;
			}

			$custom_logo = blocksy_akg(
				'custom_logo',
				$single_item['values'],
				'__default__'
			);

			if (
				$custom_logo !== '__default__'
				&&
				is_array($custom_logo)
				&&
				isset($custom_logo['desktop'])
			) {
				set_theme_mod('custom_logo', $custom_logo['desktop']);
			}
		}
	}

	public function v_1_7_41() {
		$this->migrate_options([
			[
				'old' => 'has_post_tags',
				'new' => 'single_blog_post_has_post_tags'
			]
		]);
	}

	public function v_1_7_55() {
		$previous_value = get_theme_mod(
			'product_thumbs_spacing',
			'__default__'
		);

		if ($previous_value === '__default__') {
			return;
		}

		if (
			is_numeric($previous_value)
			&&
			intval($previous_value) >= 0
			&&
			intval($previous_value) <= 70
		) {
			set_theme_mod(
				'product_thumbs_spacing',
				$previous_value . '%'
			);
		}
	}

	public function v_1_7_56() {
		$this->migrate_options_values([
			[
				'id' => 'single_blog_post_related_criteria',
				'migrate' => [
					[
						'old' => 'tags',
						'new' => 'post_tag'
					],

					[
						'old' => 'categories',
						'new' => 'category'
					]
				]
			]
		]);
	}

	private function migrate_options_values($options) {
		foreach ($options as $single_option) {
			$old_value = get_theme_mod($single_option['id'], '__empty__');

			if ($old_value === '__empty__') {
				continue;
			}

			foreach ($single_option['migrate'] as $to_migrate) {
				if ($old_value !== $to_migrate['old']) {
					continue;
				}

				set_theme_mod($single_option['id'], $to_migrate['new']);
			}
		}
	}

	private function migrate_options($options) {
		foreach ($options as $single_option) {
			$old_id = $single_option['old'];
			$new_id = $single_option['new'];

			$maybe_old = get_theme_mod($old_id, '__empty__');
			$maybe_new = get_theme_mod($new_id, '__empty__');

			if ($maybe_old !== '__empty__' && $maybe_new === '__empty__') {
				if (isset($single_option['transform'])) {
					$maybe_old = call_user_func(
						$single_option['transform'],
						$maybe_old,
						$maybe_new
					);
				}

				set_theme_mod($new_id, $maybe_old);
			}
		}
	}
}

new Blocksy_Db_Versioning();

