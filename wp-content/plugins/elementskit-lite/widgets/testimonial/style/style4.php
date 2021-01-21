<div class="elementskit-testimonial-slider ekit-testimonia-style-4" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<?php foreach ($testimonials as $testimonial): ?>
		<div class="elementskit-single-testimonial-slider elementskit-testimonial-slider-block-style elementor-repeater-item-<?php echo esc_attr( $testimonial[ '_id' ] ); ?>">
			<div class="elementskit-commentor-bio <?php echo esc_attr($ekit_testimonial_client_area_alignment); ?>">
				<?php if (isset($testimonial['client_photo']) && !empty($testimonial['client_photo']['url']) && sizeof($testimonial['client_photo']) > 0) {
					$clientLogo = isset($testimonial['client_photo']['url']) ? $testimonial['client_photo']['url'] : ''; ?>
					
					<?php if ( !empty( $testimonial['client_photo']['url'] ) ): ?>
					<div class="elementskit-commentor-image">
						<img src="<?php echo esc_url($clientLogo); ?>" height="<?php echo esc_attr($ekit_testimonial_client_image_size['size']); ?>" width="<?php echo esc_attr($ekit_testimonial_client_image_size['size']); ?>" alt="<?php esc_attr_e("Client Photo", "agmycoo");?>">
					</div>
					<?php endif; ?>
				<?php } ?>
				<span class="elementskit-profile-info">
					<strong class="elementskit-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
					<span class="elementskit-author-des"><?php echo isset($testimonial['designation']) ? \ElementsKit_Lite\Utils::kspan($testimonial['designation']) : ''; ?></span>
				</span>
			</div>
			<div class="elementskit-commentor-content">
				<?php if(isset($ekit_testimonial_wartermark_enable) && $ekit_testimonial_wartermark_enable == 'yes'):?>
					
					<span class="elementskit-watermark-icon ekit_watermark_icon_custom_position">
						<?php
							// new icon
							$migrated = isset( $settings['__fa4_migrated']['ekit_testimonial_wartermarks'] );
							// Check if its a new widget without previously selected icon using the old Icon control
							$is_new = empty( $settings['ekit_testimonial_wartermark'] );
							if ( $is_new || $migrated ) {
								// new icon
								\Elementor\Icons_Manager::render_icon( $settings['ekit_testimonial_wartermarks'], [ 'aria-hidden' => 'true' ] );
							} else {
								?>
								<i class="<?php echo esc_attr($settings['ekit_testimonial_wartermark']); ?>" aria-hidden="true"></i>
								<?php
							}
						?>
					</span>

					

				<?php endif;?>
				<?php if ( isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
					<p><?php echo isset($testimonial['review']) ? \ElementsKit_Lite\Utils::kses($testimonial['review']) : ''; ?></p>
				<?php endif; ?>
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
			</div><!-- .commentor-content END -->
		</div>
	<?php endforeach; ?>
</div>
