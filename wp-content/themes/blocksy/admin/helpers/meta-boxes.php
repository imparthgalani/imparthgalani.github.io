<?php

class Blocksy_Meta_Boxes {
	public function __construct() {
		add_action('init', [$this, 'init_taxonomies'], 999);

		add_action('load-post.php', [$this, 'init_metabox']);
		add_action('load-post-new.php', [$this, 'init_metabox']);
	}

	public function init_metabox() {
		add_action('add_meta_boxes', [$this, 'setup_meta_box']);
		add_action('save_post', [$this, 'save_meta_box']);
	}

	public function init_taxonomies() {
		$post_types = apply_filters(
			'blocksy:editor:post_types_for_rest_field',
			['post', 'page']
		);

		$custom_post_types = blocksy_manager()->post_types->get_supported_post_types();

		foreach ($custom_post_types as $single_custom_post_type) {
			$post_types[] = $single_custom_post_type;
		}

		register_rest_field(
			$post_types,
			'blocksy_meta',
			array(
				'get_callback' => function ($object) {
					$post_id = $object['id'];
					return get_post_meta($post_id, 'blocksy_post_meta_options', true);
				},
				'update_callback' => function ($value, $object) {
					$post_id = $object->ID;
					update_post_meta($post_id, 'blocksy_post_meta_options', $value);
				}
			)
		);

		$current_edit_taxonomy = $this->get_current_edit_taxonomy();

		if (! empty($_POST)) {
			add_action( 'edited_term', function ($term_id, $tt_id, $taxonomy) {
				return;
				if (
					!(
						isset( $_POST['action'] )
						&&
						'editedtag' === $_POST['action']
						&&
						isset( $_POST['taxonomy'] )
						&&
						($taxonomy = get_taxonomy( sanitize_text_field(wp_unslash($_POST['taxonomy'])) ))
						&&
						current_user_can($taxonomy->cap->edit_terms)
					)
				) {
					return;
				}

				if (isset( $_POST['tag_ID'] ) && intval(sanitize_text_field(wp_unslash($_POST['tag_ID']))) !== $term_id) {
					// the $_POST values belongs to another term, do not save them into this one
					return;
				}

				$options = $this->get_options_for_taxonomy($taxonomy->name);

				if ( empty( $options ) ) {
					return;
				}

				$values = [];

				if (isset($_POST['blocksy_taxonomy_meta_options'][blocksy_post_name()])) {
					$values = json_decode(
						sanitize_text_field(wp_unslash( $_POST['blocksy_taxonomy_meta_options'][blocksy_post_name()] )),
						true
					);
				}

				update_term_meta(
					$term_id,
					'blocksy_taxonomy_meta_options',
					$values
				);
			}, 10, 3 );
		}

		if (
			$current_edit_taxonomy['taxonomy'] === 'category'
			||
			$current_edit_taxonomy['taxonomy'] === 'post_tag'
		) {
			add_action(
				$current_edit_taxonomy['taxonomy'] . '_edit_form',

				function ($term) {
					return;
					$values = get_term_meta(
						$term->term_id,
						'blocksy_taxonomy_meta_options'
					);

					if ( empty( $values ) ) {
						$values = [ [] ];
					}

					$options = $this->get_options_for_taxonomy($term->taxonomy);

					if (empty($options)) {
						return;
					}

					$theme = blocksy_get_wp_theme();

					echo '<div class="ct-taxonomy-meta-box">';

					echo blocksy_html_tag(
						'h2',
						[],
						sprintf(
							// Translators: %s is the theme name.
							__('%s Settings', 'blocksy'),
							$theme->get('Name')
						)
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
							'name_prefix' => 'blocksy_taxonomy_meta_options',
							'attr' => [
								'class' => 'ct-meta-box'
							]
						]
					);

					echo '</div>';
				}
			);
		}
	}

	public function setup_meta_box() {
		// Get all public posts.
		$post_types = get_post_types(['public' => true]);

		foreach ($post_types as $type) {
			$options = apply_filters('blocksy_post_meta_options', null, $type);

			if (! $options) {
				continue;
			}

			add_meta_box(
				'blocksy_settings_meta_box',
				sprintf(
					// Translators: %s is the theme name.
					__( '%s Settings', 'blocksy' ),
					__( 'Blocksy', 'blocksy' )
				),
				function ($post) {
					$values = get_post_meta($post->ID, 'blocksy_post_meta_options');

					if (empty($values)) {
						$values = [[]];
					}

					$options = apply_filters(
						'blocksy_post_meta_options',
						null,
						get_post_type($post)
					);

					if (! $options) {
						return;
					}

					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Function blocksy_output_options_panel() used here escapes the value properly.
					 */
					echo blocksy_output_options_panel(
						[
							'options' => $options,
							'values' => $values[0],
							'id_prefix' => 'ct-post-meta-options',
							'name_prefix' => 'blocksy_post_meta_options',
							'attr' => [
								'class' => 'ct-meta-box',
								'data-disable-reverse-button' => 'yes'
							]
						]
					);

					wp_nonce_field(basename(__FILE__), 'blocksy_settings_meta_box');
				},
				$type, 'normal', 'default'
			);
		}
	}

	public function save_meta_box($post_id) {
		// Checks save status.
		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		$is_valid_nonce = !! (
			isset($_POST['blocksy_settings_meta_box']) && wp_verify_nonce(
				sanitize_text_field(wp_unslash($_POST['blocksy_settings_meta_box'])), basename(__FILE__)
			)
		);

		if ($is_autosave || $is_revision || !$is_valid_nonce) {
			return;
		}

		$values = [];

		if (isset($_POST['blocksy_post_meta_options'][blocksy_post_name()])) {
			$values = json_decode(
				wp_unslash($_POST['blocksy_post_meta_options'][blocksy_post_name()]),
				true
			);
		}

		update_post_meta($post_id, 'blocksy_post_meta_options', $values);
	}

	private function get_current_edit_taxonomy() {
		static $cache_current_taxonomy_data = null;

		if ($cache_current_taxonomy_data !== null) {
			return $cache_current_taxonomy_data;
		}

		$result = array(
			'taxonomy' => null,
			'term_id'  => 0,
		);

		do {
			if (! is_admin()) {
				break;
			}

			// code from /wp-admin/admin.php line 110
			{
				if (
					isset($_REQUEST['taxonomy'])
					&&
					taxonomy_exists(
						sanitize_text_field(wp_unslash($_REQUEST['taxonomy']))
					)
				) {
					$taxnow = sanitize_text_field(wp_unslash($_REQUEST['taxonomy']));
				} else {
					$taxnow = '';
				}
			}

			if (empty($taxnow)) {
				break;
			}

			$result['taxonomy'] = $taxnow;

			if (empty($_REQUEST['tag_ID'])) {
				return $result;
			}

			// code from /wp-admin/edit-tags.php
			{
				$tag_ID = (int) $_REQUEST['tag_ID'];
			}

			$result['term_id'] = $tag_ID;
		} while ( false );

		$cache_current_taxonomy_data = $result;
		return $cache_current_taxonomy_data;
	}

	private function get_options_for_taxonomy($taxonomy) {
		$options = [];

		$taxonomy_slug = str_replace('_', '-', $taxonomy);

		global $wp_taxonomies;

		$post_type = $wp_taxonomies[$taxonomy]->object_type;

		if (is_array($post_type) && strpos(implode('', $post_type), 'post') !== false) {
			$taxonomy_slug = 'category';
		}

		$path = get_template_directory() . '/inc/options/taxonomies/' . $taxonomy_slug . '.php';

		if (file_exists($path)) {
			$options = blocksy_akg(
				'options',
				blocksy_get_variables_from_file($path, [ 'options' => [] ])
			);
		}

		return $options;
	}
}

new Blocksy_Meta_Boxes();
