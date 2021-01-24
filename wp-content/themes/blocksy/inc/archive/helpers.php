<?php

if (! function_exists('blocksy_render_archive_cards')) {
	function blocksy_render_archive_cards($args = []) {
		global $wp_query;

		$args = wp_parse_args(
			$args,
			[
				'query' => $wp_query,
				'prefix' => blocksy_manager()->screen->get_prefix(),
				'has_pagination' => true
			]
		);

		$blog_post_structure = get_theme_mod($args['prefix'] . '_structure', 'grid');

		$blog_post_columns = get_theme_mod($args['prefix'] . '_columns', '3');

		$columns_output = '';

		if ($blog_post_structure === 'grid') {
			$columns_output = 'data-column-set="' . $blog_post_columns . '"';
		}

		if ($args['query']->have_posts()) {
			$entries_open = '<div class="entries" ';
			$entries_open .= 'data-layout="' . esc_attr($blog_post_structure) . '"';
			$entries_open .= ' ' . blocksy_get_listing_card_type([
				'prefix' => $args['prefix']
			]);
			$entries_open .= ' ' . blocksy_listing_page_structure([
				'prefix' => $args['prefix']
			]);
			$entries_open .= ' ' . $columns_output;
			$entries_open .= ' ' . blocksy_schema_org_definitions('blog');
			$entries_open .= ' ' . blocksy_generic_get_deep_link([
				'prefix' => $args['prefix']
			]) . '>';

			echo $entries_open;

			while ($args['query']->have_posts()) {
				$args['query']->the_post();

				blocksy_render_archive_card([
					'prefix' => $args['prefix']
				]);
			}

			echo '</div>';

			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_display_posts_pagination() used here escapes the value properly.
			 */
			if ($args['has_pagination']) {
				echo blocksy_display_posts_pagination([
					'query' => $args['query'],
					'prefix' => $args['prefix']
				]);
			}
		} else {
			get_template_part('template-parts/content', 'none');
		}
	}
}

