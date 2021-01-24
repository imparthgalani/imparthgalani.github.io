<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blocksy
 */

get_header();

$prefix = blocksy_manager()->screen->get_prefix();

$blog_post_structure = get_theme_mod($prefix . '_structure', 'grid');
$blog_post_columns = get_theme_mod($prefix . '_columns', '3');

$columns_output = '';

if ( $blog_post_structure === 'grid' ) {
	$columns_output = 'data-column-set="' . $blog_post_columns . '"';
}

$joined_date = date( "F j, Y", strtotime(get_userdata(
	get_the_author_meta('ID')
)->user_registered) );

$comments_count = get_comments([
	'type' => '',
	'user_id' => get_the_author_meta('ID'),
	'count' => true,
]);

/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
echo blocksy_output_hero_section([
	'type' => 'type-2'
]);

?>

<div class="ct-container" <?php echo wp_kses(blocksy_sidebar_position_attr(), []); ?>  <?php echo blocksy_get_v_spacing() ?>>
	<section>
		<?php
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_output_hero_section() used here
			 * escapes the value properly.
			 */
			echo blocksy_output_hero_section([
				'type' => 'type-1'
			]);
		?>

		<?php if (have_posts()) {

			if (have_posts()) { ?>
				<div class="entries"
					data-layout="<?php echo esc_attr($blog_post_structure); ?>"
					<?php echo blocksy_get_listing_card_type() ?>
					<?php echo blocksy_listing_page_structure() ?>
					<?php echo wp_kses_post($columns_output); ?>
					<?php echo blocksy_schema_org_definitions('blog') ?>>
			<?php }

			while (have_posts()) {
				the_post();
				get_template_part(
					'template-parts/content-loop', get_post_type()
				);
			}

			if (have_posts()) { ?>
				</div>
			<?php }

			/**
				* Note to code reviewers: This line doesn't need to be escaped.
				* Function blocksy_display_posts_pagination() used here escapes the value properly.
				*/
			echo blocksy_display_posts_pagination();
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</section>

	<?php get_sidebar(); ?>
</div>

<?php

get_footer();
