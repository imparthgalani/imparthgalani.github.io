<?php

if (! function_exists('blocksy_display_page_elements')) {
function blocksy_display_page_elements($location = null) {
	$prefix = blocksy_manager()->screen->get_prefix();

	$has_related_posts = get_theme_mod(
		$prefix . '_has_related_posts',
		$prefix === 'single_blog_post' ? 'yes' : 'no'
	) === 'yes' && (
		blocksy_default_akg(
			'disable_related_posts',
			blocksy_get_post_options(),
			'no'
		) !== 'yes'
	);

	$has_comments = get_theme_mod($prefix . '_has_comments', 'yes');

	$related_posts_location = get_theme_mod(
		$prefix . '_related_posts_containment',
		'separated'
	);
	$comments_location = null;

	if ($has_comments === 'yes') {
		$comments_location = get_theme_mod(
			$prefix . '_comments_containment',
			'separated'
		);
	}

	ob_start();

	if ($has_related_posts) {
		blocksy_related_posts($location);
	}

	$related_posts_output = ob_get_clean();

	if (
		(
			get_theme_mod($prefix . '_related_location', 'before') === 'before'
			||
			$comments_location !== $related_posts_location
		) && $has_related_posts && $related_posts_location === $location
	) {
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The var $related_posts_output used here escapes the value properly.
		 */
		echo $related_posts_output;
	}

	$container_class = 'ct-container';

	if (
		get_theme_mod(
			$prefix . '_comments_structure',
			'narrow'
		) === 'narrow'
	) {
		$container_class = 'ct-container-narrow';
	}

	ob_start();

	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || get_comments_number()) { ?>

		<?php if ($location === 'separated') { ?>
		<div class="ct-comments-container">
			<div class="<?php echo $container_class ?>">
		<?php } ?>

				<?php comments_template(); ?>

		<?php if ($location === 'separated') { ?>
			</div>
		</div>
		<?php } ?>

	<?php }

	$comments = ob_get_clean();

	if ($has_comments === 'yes' && $comments_location === $location) {
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The val $comments used here escapes the value properly.
		 */
		echo $comments;
	}

	if (
		get_theme_mod($prefix . '_related_location', 'before') === 'after'
		&&
		$comments_location === $related_posts_location
		&&
		$has_related_posts
		&&
		$related_posts_location === $location
	) {
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The var $related_posts_output used here escapes the value properly.
		 */
		echo $related_posts_output;
	}
}
}
