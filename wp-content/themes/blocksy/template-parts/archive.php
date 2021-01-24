<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blocksy
 */

$prefix = blocksy_manager()->screen->get_prefix();

$blog_post_structure = get_theme_mod($prefix . '_structure', 'grid');

$container_class = 'ct-container';

if ($blog_post_structure === 'gutenberg') {
	$container_class = 'ct-container-narrow';
}

/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
echo blocksy_output_hero_section([
	'type' => 'type-2'
]);

?>

<div class="<?php echo $container_class ?>" <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?> <?php echo blocksy_get_v_spacing() ?>>

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

			echo blocksy_render_archive_cards();
		?>
	</section>

	<?php get_sidebar(); ?>
</div>

