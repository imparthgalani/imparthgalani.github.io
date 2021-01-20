<div class="elementskit-testimonial-slider" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
<?php
	foreach ($testimonials as $testimonial):
		$clientPhoto = '';
		if (isset($testimonial['client_photo']) && !empty($testimonial['client_photo']['url']) &&  sizeof($testimonial['client_photo']) > 0) {
			$clientPhoto = isset($testimonial['client_photo']['url']) ? $testimonial['client_photo']['url'] : '';  } ?>

			<div class="elementskit-testimonial_card" style="background-image: url(<?php esc_attr_e($clientPhoto );?>);">
				<?php if ($ekit_testimonial_rating_enable == 'yes') : ?>
				<ul class="elementskit-stars">
					<?php
					$reviewData = isset($testimonial['rating']) ? $testimonial['rating'] : 0;
					for($m = 1; $m <= 5; $m++){
						$iconStart = 'far fa-star';
						if($reviewData >= $m){
							$iconStart = 'fas fa-star active';
						}
					?>
					<li><a href="#"><i class="<?php esc_attr_e( $iconStart );?>"></i></a></li>

					<?php }?>
				</ul>
				<?php endif; ?>

				<?php if ( isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
					<p class="elementskit-commentor-coment"><?php echo isset($testimonial['review']) ? \ElementsKit_Lite\Utils::kses($testimonial['review']) : ''; ?></p>
				<?php endif;  ?>

				<?php if ( isset($testimonial['review_youtube_link']) && !empty($testimonial['review_youtube_link'])) : ?>
					<div class="elementskit-video-popup-content">
						<a href="<?php esc_attr_e($review_youtube_link);?>" class="video-popup"><i class="icon icon-play"></i></a>
					</div><!-- .elementskit-video-popup-content END -->
				<?php endif;  ?>

				<span class="elementskit-profile-info">
					<strong class="elementskit-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
					<span class="elementskit-author-des"><?php echo isset($testimonial['designation']) ? \ElementsKit_Lite\Utils::kspan($testimonial['designation']) : ''; ?></span>
				</span>
				<div class="xs-overlay elementor-repeater-item-<?php echo esc_attr( $testimonial[ '_id' ] ); ?>"></div>
			</div><!-- .testimonial_card END -->
	<?php endforeach; ?>
</div>
