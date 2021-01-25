<?php

if (! function_exists('blocksy_render_archive_cards')) {
	return;
}

if (get_query_var('paged')) {
	$paged = get_query_var('paged');
} elseif (get_query_var('page')) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}

$query_args = [
	'order' => 'DESC',
	'ignore_sticky_posts' => true,
	'post_type' => $args['post_type'],
	'orderby' => $args['orderby'],
	'posts_per_page' => $args['limit'],
	'paged' => $paged,
	'ignore_sticky_posts' => $args['ignore_sticky_posts'] === 'yes'
];

if (isset($args['post_ids']) && $args['post_ids']) {
	$query_args['post__in'] = explode(',', $args['post_ids']);
}

if (isset($args['term_ids']) && $args['term_ids']) {
	$tax_query = [
		'relation' => 'OR'
	];

	foreach (explode(',', $args['term_ids']) as $internal_term_id) {
		$term_id = trim($internal_term_id);
		$term = get_term($term_id);

		if (! $term) {
			continue;
		}

		$tax_query[] = [
			'field' => $term_id,
			'taxonomy' => $term->taxonomy,
			'terms' => $term_id
		];
	}


	$query_args['tax_query'] = $tax_query;
}

$query = new WP_Query($query_args);

$prefix = 'blog';

$custom_post_types = blocksy_manager()->post_types->get_supported_post_types();

foreach ($custom_post_types as $cpt) {
	if ($cpt === $args['post_type']) {
		$prefix = $args['post_type'] . '_archive';
	}
}

echo '<div class="ct-posts-shortcode" data-prefix="' . $prefix . '">';

echo blocksy_render_archive_cards([
	'prefix' => $prefix,
	'query' => $query,
	'has_pagination' => $args['has_pagination'] === 'yes'
]);

wp_reset_postdata();

echo '</div>';
