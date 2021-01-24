<div class="ct-container" <?php echo blocksy_get_v_spacing() ?>>
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title">
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'blocksy' ); ?>
			</h1>

			<p>
				<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try to search for something else?', 'blocksy' ); ?>
			</p>
		</header>

		<div class="page-content">
			<?php get_search_form(); ?>
		</div>
	</section>
</div>

