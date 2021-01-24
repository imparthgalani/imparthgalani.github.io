<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Blocksy
 */

/**
 * Single entry title.
 *
 * @param string $tag HTML tag.
 */
if (! function_exists('blocksy_entry_title')) {
function blocksy_entry_title( $tag = 'h2' ) {
	if (empty(get_the_title())) {
		return '';
	}

	ob_start();

	?>

	<<?php echo esc_attr( $tag ); ?> class="entry-title">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php the_title(); ?>
		</a>
	</<?php echo esc_attr( $tag ); ?>>

	<?php

	return ob_get_clean();
}
}

/**
 * Output entry excerpt.
 *
 * @param number $length Number of words allowed in excerpt.
 */
if (! function_exists('blocksy_entry_excerpt')) {
function blocksy_entry_excerpt($length = 40, $class = 'entry-excerpt', $post_id = null) {

	if (empty(trim(get_the_excerpt($post_id)))) {
		return '';
	}

	$post = get_post($post_id);

	$has_native_excerpt = $post->post_excerpt;

	$excerpt = null;

	if ($has_native_excerpt) {
		$excerpt = get_the_excerpt($post_id);
	}

	if (! $excerpt) {
		ob_start();
		blocksy_trim_excerpt(get_the_excerpt($post_id), $length);
		$excerpt = ob_get_clean();
	}

	ob_start();

	?>

	<div class="<?php echo esc_attr($class) ?>">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post(do_shortcode($excerpt));
		?>
	</div>

	<?php

	return ob_get_clean();
}
}

/**
 * Output post navigation.
 */
if (! function_exists('blocksy_post_navigation')) {
function blocksy_post_navigation() {
	$next_post = apply_filters(
		'blocksy:post-navigation:next-post',
		get_adjacent_post(false, '', true)
	);

	$previous_post = apply_filters(
		'blocksy:post-navigation:previous-post',
		get_adjacent_post(false, '', false)
	);

	if (! $next_post && ! $previous_post) {
		return '';
	}

    $prefix = blocksy_manager()->screen->get_prefix();

	$container_class = 'post-navigation';

	$container_class .= ' ' . blocksy_visibility_classes(get_theme_mod(
		$prefix . '_post_nav_visibility',
		[
			'desktop' => true,
			'tablet' => true,
			'mobile' => true,
		]
	));

	$home_page_url = get_home_url();

	$post_slug = get_post_type() === 'post' ? __( 'Post', 'blocksy' ) : get_post_type_object( get_post_type() )->labels->singular_name;
	$post_slug = '<span>' . $post_slug . '</span>';

	$has_thumb = get_theme_mod($prefix . '_has_post_nav_thumb', 'yes') === 'yes';

	$has_title = get_theme_mod($prefix . '_has_post_nav_title', 'yes') === 'yes';

	$next_post_image_output = '';
	$previous_post_image_output = '';

	if ($next_post) {
		$next_title = '';

		if ($has_title) {
			$next_title = $next_post->post_title;
		}

		if ($has_thumb && get_post_thumbnail_id($next_post)) {
			$next_post_image_output = blocksy_image(
				[
					'attachment_id' => get_post_thumbnail_id( $next_post ),
					'ratio' => '1/1',
					'inner_content' => '<svg width="20px" height="15px" viewBox="0 0 20 15"><polygon points="0,7.5 5.5,13 6.4,12.1 2.4,8.1 20,8.1 20,6.9 2.4,6.9 6.4,2.9 5.5,2 "/></svg>',
					'tag_name' => 'figure'
				]
			);
		}
	}

	if ($previous_post) {
		$previous_title = '';
		if ( $has_title ) {
			$previous_title = $previous_post->post_title;
		}

		if ($has_thumb && get_post_thumbnail_id($previous_post)) {
			$previous_post_image_output = blocksy_image(
				[
					'attachment_id' => get_post_thumbnail_id( $previous_post ),
					'ratio' => '1/1',
					'inner_content' => '<svg width="20px" height="15px" viewBox="0 0 20 15"><polygon points="14.5,2 13.6,2.9 17.6,6.9 0,6.9 0,8.1 17.6,8.1 13.6,12.1 14.5,13 20,7.5 "/></svg>',
					'tag_name' => 'figure'
				]
			);
		}
	}

	ob_start();

	?>

		<nav class="<?php echo esc_attr( $container_class ); ?>">
			<?php if ($next_post) { ?>
				<a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-item-prev">
					<?php if ($has_thumb) { ?>
						<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo $next_post_image_output;
						?>
					<?php } ?>

					<div class="item-content">
						<span class="item-label">
							<?php
								echo wp_kses_post(sprintf(
									// translators: post title
									__( 'Previous %s', 'blocksy' ),
									$post_slug
								));
							?>
						</span>

						<?php if ( ! empty( $next_title ) ) { ?>
							<span class="item-title">
								<?php echo wp_kses_post($next_title); ?>
							</span>
						<?php } ?>
					</div>

				</a>
			<?php } else { ?>
				<div class="nav-item-prev"></div>
			<?php } ?>

			<?php if ( $previous_post ) { ?>
				<a href="<?php echo esc_url( get_permalink( $previous_post ) ); ?>" class="nav-item-next">
					<div class="item-content">
						<span class="item-label">
							<?php
								echo wp_kses_post(sprintf(
									// translators: post title
									__( 'Next %s', 'blocksy' ),
									$post_slug
								));
							?>
						</span>

						<?php if ( ! empty( $previous_title ) ) { ?>
							<span class="item-title">
								<?php echo wp_kses_post($previous_title); ?>
							</span>
						<?php } ?>
					</div>

					<?php if ($has_thumb) { ?>
						<?php
							echo $previous_post_image_output;
						?>
					<?php } ?>
				</a>
			<?php } else { ?>
				<div class="nav-item-next"></div>
			<?php } ?>

		</nav>

	<?php

	return ob_get_clean();
}
}

/**
 * Output related posts for a single post.
 *
 * @param number $per_page Number of posts to output.
 */
if (! function_exists('blocksy_related_posts')) {
function blocksy_related_posts($location = null) {
	global $post;

	$prefix = blocksy_manager()->screen->get_prefix();
	$per_page = intval(get_theme_mod($prefix . '_related_posts_count', 3));

	$post_type = get_post_type($post);

	$taxonomy = get_theme_mod(
		$prefix . '_related_criteria',
		array_keys(blocksy_get_taxonomies_for_cpt($post_type))[0]
	);

	$all_taxonomy_ids = [];

	if ($taxonomy) {
		$all_taxonomies = get_the_terms($post->ID, $taxonomy);

		if ($all_taxonomies) {
			foreach ($all_taxonomies as $current_taxonomy) {
				$all_taxonomy_ids[] = $current_taxonomy->term_id;
			}
		}
	}

	$query = new WP_Query(
		apply_filters(
			'blocksy:related-posts:query-args',
			array_merge(
				[
					'ignore_sticky_posts' => 0,
					'posts_per_page' => $per_page,
					'post__not_in' => [$post->ID],
					'post_type' => $post_type,
				],
				! empty($all_taxonomy_ids) ? [
					'tax_query' => [
						[
							'field' => 'id',
							'taxonomy' => $taxonomy,
							'terms' => $all_taxonomy_ids,
						]
					]
				] : []
			)
		)
	);

	$label = get_theme_mod(
		$prefix . '_related_label',
		__( 'Related Posts', 'blocksy')
	);

	$meta_elements = get_theme_mod(
		$prefix . '_related_single_meta_elements',
		blocksy_post_meta_defaults([
			[
				'id' => 'post_date',
				'enabled' => true,
			],

			[
				'id' => 'comments',
				'enabled' => true,
			],
		])
	);

	$columns = get_theme_mod($prefix . '_related_posts_columns', 3);

	$class = 'ct-related-posts-container';

	if (! $query->have_posts()) {
		wp_reset_postdata();
		return;
	}

	$label_tag = get_theme_mod($prefix . '_related_label_wrapper', 'h3');

	$container_class = 'ct-container';

	if (get_theme_mod($prefix . '_related_structure', 'normal') === 'narrow') {
		$container_class = 'ct-container-narrow';
	}

	?>

	<?php if ($location === 'separated') { ?>
	<div class="<?php echo esc_attr($class) ?>">
		<div class="<?php echo $container_class ?>">
	<?php } ?>

		<div class="ct-related-posts" data-column-set="<?php echo esc_attr($columns); ?>">
			<<?php echo $label_tag ?> class="ct-block-title">
				<?php echo wp_kses_post($label); ?>
			</<?php echo $label_tag ?>>

			<?php while ($query->have_posts()) { ?>
				<?php $query->the_post(); ?>

				<article <?php echo blocksy_schema_org_definitions('creative_work') ?>>
					<?php
						if (
							get_post_thumbnail_id()
							&&
							get_theme_mod(
								$prefix . '_has_related_featured_image',
								'yes'
							) === 'yes'
						) {
							echo wp_kses_post(blocksy_image(
								[
									'attachment_id' => get_post_thumbnail_id(),
									'ratio' => get_theme_mod(
										$prefix . '_related_featured_image_ratio',
										'16/9'
									),
									'tag_name' => 'a',
									'size' => get_theme_mod(
										$prefix . '_related_featured_image_size',
										'medium'
									),
									'html_atts' => [
										'href' => esc_url( get_permalink() ),
										'aria-label' => get_the_title()
									],
								]
							));
						}
					?>

					<?php if (! empty(get_the_title())) { ?>
						<h3 class="related-entry-title" <?php echo blocksy_schema_org_definitions('name') ?>>
							<a href="<?php echo esc_url( get_permalink() ); ?>" <?php echo blocksy_schema_org_definitions('url') ?>><?php the_title(); ?></a>
						</h3>
					<?php } ?>

					<?php echo blocksy_post_meta($meta_elements, [
						'meta_divider' => 'slash'
					]); ?>
				</article>
			<?php } ?>
		</div>

	<?php if ($location === 'separated') { ?>
		</div>
	</div>
	<?php } ?>

	<?php

	wp_reset_postdata();
}
}

function blocksy_before_current_template() {
	do_action('blocksy:template:before');
}

function blocksy_after_current_template() {
	do_action('blocksy:template:after');
}
