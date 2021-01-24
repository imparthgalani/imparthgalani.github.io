<?php

if (! function_exists('blocksy_single_content')) {
function blocksy_single_content($content = null) {
	$post_options = blocksy_get_post_options();

	$prefix = blocksy_manager()->screen->get_prefix();

	$has_share_box = get_theme_mod(
		$prefix . '_has_share_box',
		$prefix === 'single_blog_post' ? 'yes' : 'no'
	) === 'yes';

	if (blocksy_is_page()) {
		$has_share_box = false;
	}

	$has_author_box = get_theme_mod(
		$prefix . '_has_author_box',
		'no'
	) === 'yes';

	$has_post_tags = get_theme_mod(
		$prefix . '_has_post_tags',
		'yes'
	) === 'yes';

	$has_post_nav = get_theme_mod(
		$prefix . '_has_post_nav',
		$prefix === 'single_blog_post' ? 'yes' : 'no'
	) === 'yes';

	if (blocksy_is_page()) {
		$has_author_box = false;
		$has_post_nav = false;
	}

	if (
		blocksy_default_akg(
			'disable_posts_navigation', $post_options, 'no'
		) === 'yes'
	) {
		$has_post_nav = false;
	}

	if (
		blocksy_default_akg(
			'disable_author_box', $post_options, 'no'
		) === 'yes'
	) {
		$has_author_box = false;
	}

	if (
		blocksy_default_akg(
			'disable_post_tags', $post_options, 'no'
		) === 'yes'
	) {
		$has_post_tags = false;
	}

	if (blocksy_is_page() && ! in_array('post_tag', get_object_taxonomies('page'))) {
		$has_post_tags = false;
	}

	if (
		blocksy_default_akg(
			'disable_share_box', $post_options, 'no'
		) === 'yes'
	) {
		$has_share_box = false;
	}

	$featured_image_location = 'none';

	$page_title_source = blocksy_get_page_title_source();
	$featured_image_source = blocksy_get_featured_image_source();

	if ($page_title_source) {
		$actual_type = blocksy_akg_or_customizer(
			'hero_section',
			blocksy_get_page_title_source(),
			'type-1'
		);

		if ($actual_type !== 'type-2') {
			$featured_image_location = get_theme_mod(
				$prefix . '_featured_image_location',
				'above'
			);
		} else {
			$featured_image_location = 'below';
		}
	} else {
		$featured_image_location = 'above';
	}

	$share_box_type = get_theme_mod($prefix . '_share_box_type', 'type-1');

	$share_box1_location = get_theme_mod($prefix . '_share_box1_location', [
		'top' => false,
		'bottom' => true,
	]);

	$share_box2_location = get_theme_mod($prefix . '_share_box2_location', 'right');

	$content_editor = blocksy_get_entry_content_editor();

	$content_class = 'entry-content';

	if (
		strpos($content_editor, 'elementor') !== false
		||
		strpos($content_editor, 'bakery') !== false
	) {
		$content_class = 'ct-builder-content';
	}

	ob_start();

	?>

	<article
		id="post-<?php the_ID(); ?>"
		<?php post_class(); ?>>

		<?php
			if ($featured_image_location === 'above') {
				echo blocksy_get_featured_image_output();
			}

			if (
				! is_singular([ 'product' ])
				&&
				apply_filters('blocksy:single:has-default-hero', true)
			) {
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_hero_section() used here escapes the value properly.
				 */
				echo blocksy_output_hero_section([
					'type' => 'type-1'
				]);
			}

			if ($featured_image_location === 'below') {
				echo blocksy_get_featured_image_output();
			}
		?>

		<?php if (
			(
				(
					$share_box_type === 'type-1'
					&&
					$share_box1_location['top']
				) || $share_box_type === 'type-2'
			)
			&&
			$has_share_box
		) { ?>
			<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_get_social_share_box() used here escapes the value properly.
				 */
				echo blocksy_get_social_share_box([
					'html_atts' => $share_box_type === 'type-1' ? [
						'data-location' => 'top'
					] : [
						'data-location' => $share_box2_location,
					],
					'type' => $share_box_type
				]);
			?>
		<?php } ?>

		<div class="<?php echo $content_class ?>">
			<?php

			if (! is_attachment()) {
				if ($content) {
					echo $content;
				} else {
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'blocksy' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						)
					);
				}
			} else {
				?>
					<figure class="entry-attachment wp-block-image">
						<?php
							echo blocksy_image([
								'attachment_id' => get_the_ID(),
								'size' => 'full',
								'tag_name' => 'a',
								'ratio' => 'original',
								'html_atts' => [
									'href' => wp_get_attachment_url(get_the_ID())
								]
							]);
						?>

						<figcaption class="wp-caption-text"><?php the_excerpt(); ?></figcaption>
					</figure>
				<?php
			}

			?>
		</div>

		<?php
			if (get_post_type() === 'post') {
				edit_post_link(
					sprintf(
						/* translators: %s: Post title. */
						__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'blocksy' ),
						get_the_title()
					)
				);
			}

			wp_link_pages(
				[
					'before' => '<div class="page-links"><span class="post-pages-label">' . esc_html__( 'Pages', 'blocksy' ) . '</span>',
					'after'  => '</div>',
				]
			);

			do_action('blocksy:single:content:bottom');
		?>

		<?php if ($has_post_tags) { ?>
			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_post_meta() used here escapes the value properly.
				 */
				if (blocksy_get_categories_list('', false)) {
					echo blocksy_html_tag(
						'div',
						['class' => 'entry-tags'],
						blocksy_get_categories_list('', false)
					);
				}
			?>
		<?php } ?>

		<?php if (
			$share_box_type === 'type-1'
			&&
			$share_box1_location['bottom']
			&&
			$has_share_box
		) { ?>
			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_get_social_share_box() used here escapes the value properly.
				 */
				echo blocksy_get_social_share_box([
					'html_atts' => ['data-location' => 'bottom'],
					'type' => 'type-1'
				]);
			?>
		<?php } ?>

		<?php

		if ($has_author_box) {
			blocksy_author_box();
		}

		if ($has_post_nav) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_post_navigation() used here escapes the value properly.
			 */
			echo blocksy_post_navigation();
		}

		if (function_exists('blc_ext_mailchimp_subscribe_form')) {
			if (get_post_type() === 'post') {
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blc_ext_mailchimp_subscribe_form() used here escapes the value properly.
				 */
				echo blc_ext_mailchimp_subscribe_form();
			}
		}

		blocksy_display_page_elements('contained');

		?>

	</article>

	<?php

	return ob_get_clean();
}
}

