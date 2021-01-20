<div class="elementskit-testimonial-slider <?php echo esc_attr($wrapper_class); ?>" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
<?php
	// start foreach loop
	foreach ($testimonials as $testimonial):
?>
	<div class="elemntskit-testimonial-item">
		<div class="elementskit-single-testimonial-slider">
			<div class="row">
				<div class="col-lg-6 elementkit-testimonial-col">
					<div class="elementskit-commentor-content">
						<?php if (isset($testimonial['client_logo']) && !empty($testimonial['client_logo']['url']) && sizeof($testimonial['client_logo']) > 0) {
							$clientLogo = isset($testimonial['client_logo']['url']) ? $testimonial['client_logo']['url'] : '';
						?>
							<div class="elementskit-client_logo">
								<img src="<?php echo esc_url($clientLogo); ?>" alt="<?php esc_attr_e("Client Logo","agmycoo");?>">
							</div>
						<?php
							} ?>
						<?php if ( isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
							<p><?php echo isset($testimonial['review']) ? \ElementsKit_Lite\Utils::kses($testimonial['review']) : ''; ?></p>
						<?php endif;  ?>
						<?php if ( 'yes' == $ekit_testimonial_title_separetor ): ?>
							<span class="elementskit-border-hr"></span>
						<?php endif; ?>
						<span class="elementskit-profile-info">
							<strong class="elementskit-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
							<span class="elementskit-author-des"><?php echo isset($testimonial['designation']) ? \ElementsKit_Lite\Utils::kspan($testimonial['designation']) : ''; ?></span>
						</span>
					</div>
				</div>
				<div class="col-lg-6 elementkit-testimonial-col">
					<div class="elementskit-profile-image-card">
						<?php if (isset($testimonial['client_photo']) && !empty($testimonial['client_photo']['url']) &&  sizeof($testimonial['client_photo']) > 0) {
								$clientPhoto = isset($testimonial['client_photo']['url']) ? $testimonial['client_photo']['url'] : ''; ?>
								<img src="<?php echo esc_url($clientPhoto); ?>" alt="<?php esc_attr_e("Client Image","agmycoo");?>">
						<?php } ?>
						<?php if( isset($ekit_testimonial_enable_social) && $ekit_testimonial_enable_social == 'yes'):?>
							<div class="elementskit-hover-area">
								<ul class="social-list medium circle text-colored">
									<?php if(isset($testimonial['facebook_url']) && strlen($testimonial['facebook_url']) > 5){?>
									<li><a href="<?php esc_attr_e($testimonial['facebook_url']);?>" class="facebook"><i class="fa fa-facebook"></i></a></li>
									<?php }?>
									<?php if(isset($testimonial['twitter_url']) && strlen($testimonial['twitter_url']) > 5){?>
									<li><a href="<?php esc_attr_e($testimonial['twitter_url']);?>" class="twitter"><i class="fa fa-twitter"></i></a></li>
									<?php }?>
									<?php if(isset($testimonial['linkedin_url']) && strlen($testimonial['linkedin_url']) > 5){?>
									<li><a href="<?php esc_attr_e($testimonial['linkedin_url']);?>" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
									<?php }?>
									<?php if(isset($testimonial['youtube_url']) && strlen($testimonial['youtube_url']) > 5){?>
									<li><a href="<?php esc_attr_e($testimonial['youtube_url']);?>" class="youtube"><i class="fa fa-youtube"></i></a></li>
									<?php }?>

								</ul>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; // end foreach loop ?>
</div>
