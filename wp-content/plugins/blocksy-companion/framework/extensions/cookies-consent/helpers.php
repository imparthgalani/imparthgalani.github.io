<?php

function blc_ext_cookies_consent_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			[ 'data-id' => 'blocksy-cookies-consent-section' ],
			blocksy_ext_cookies_consent_output(true)
		)
	);
}

function blocksy_ext_cookies_consent_output($forced = false) {
	if (! $forced) {
		blc_ext_cookies_consent_cache();
	}

	/*
	if (! BlocksyExtensionCookiesConsent::should_display_notification()) {
		if (! $forced) {
			return;
		}
	}
	 */

	$content = get_theme_mod(
		'cookie_consent_content',
		__('We use cookies to ensure that we give you the best experience on our website.', 'blc')
	);

	$button_text = get_theme_mod('cookie_consent_button_text', __('Accept', 'blc'));
	$period = get_theme_mod('cookie_consent_period', 'forever');
	$type = get_theme_mod('cookie_consent_type', 'type-1');

	$class = 'container';

	if ( $type === 'type-2' ) {
		$class = 'ct-container';
	}

	ob_start();

	?>


	<div class="cookie-notification ct-fade-in-start" data-period="<?php echo esc_attr($period) ?>" data-type="<?php echo esc_attr($type) ?>">

		<div class="<?php echo esc_attr($class) ?>">
			<?php if (!empty($content)) { ?>
				<div class="ct-cookies-content"><?php echo wp_kses_post($content) ?></div>
			<?php } ?>

			<button type="submit" class="ct-button ct-accept"><?php echo esc_html($button_text) ?></button>

			<?php if ($type === 'type-1' || is_customize_preview()) { ?>
				<button class="ct-close">×</button>
			<?php } ?>

		</div>
	</div>
	<?php

	return ob_get_clean();
}

function blocksy_ext_cookies_checkbox($prefix = '') {
	ob_start();

	if (! empty($prefix)) {
		$prefix = '_' . $prefix;
	}

	$message = get_theme_mod(
		'forms_cookie_consent_content',
		sprintf(
			__('I accept the %sPrivacy Policy%s', 'blc'),
			'<a href="/privacy-policy">',
			'</a>'
		)
	);

	?>

	<p class="gdpr-confirm-policy">
		<input id="gdprconfirm<?php echo $prefix ?>" name="gdprconfirm" type="checkbox" required /><label for="gdprconfirm<?php echo $prefix ?>"><?php echo $message ?></label>
	</p>

	<?php

	return ob_get_clean();
}
