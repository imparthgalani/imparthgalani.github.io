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

$query = new WP_Query([
	'order' => 'DESC',
	'ignore_sticky_posts' => true,
	'post_type' => $args['post_type'],
	'orderby' => $args['orderby'],
	'posts_per_page' => $args['limit'],
	'paged' => $paged
]);

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
