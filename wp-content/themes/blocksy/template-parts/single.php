<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blocksy
 */

if (
	blocksy_default_akg(
		'page_structure_type',
		blocksy_get_post_options(),
		'default'
	) !== 'default'
	&&
	is_customize_preview()
) {
	blocksy_add_customizer_preview_cache(
		function () {
			return blocksy_html_tag(
				'div',
				[
					'data-structure-custom' => blocksy_default_akg(
						'page_structure_type',
						blocksy_get_post_options(),
						'default'
					)
				],
				''
			);
		}
	);
}

if (have_posts()) {
	the_post();
}

/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
if (apply_filters('blocksy:single:has-default-hero', true)) {
	echo blocksy_output_hero_section([
		'type' => 'type-2'
	]);
}

$container_class = 'ct-container';

if (blocksy_get_page_structure() === 'narrow') {
	$container_class = 'ct-container-narrow';
}

$content_style = blocksy_get_content_style();

ob_start();
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
$post_content = ob_get_clean();

?>

	<div
		class="<?php echo trim($container_class) ?>"
		<?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?>
		<?php echo blocksy_get_v_spacing() ?>
		<?php echo blocksy_get_entry_content_editor() ?>>

		<?php do_action('blocksy:single:container:top'); ?>

		<section>
			<?php
				/**
					* Note to code reviewers: This line doesn't need to be escaped.
					* Function blocksy_single_content() used here escapes the value properly.
					*/
				echo blocksy_single_content($post_content);
			?>
		</section>

		<?php get_sidebar(); ?>

		<?php do_action('blocksy:single:container:bottom'); ?>
	</div>

<?php

blocksy_display_page_elements('separated');

have_posts();
wp_reset_query();

