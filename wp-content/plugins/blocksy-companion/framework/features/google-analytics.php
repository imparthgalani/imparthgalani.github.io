<?php

namespace Blocksy;

class GoogleAnalytics {
	public function __construct() {
		add_filter(
			'blocksy_engagement_general_start_customizer_options',
			[$this, 'generate_google_analytics_opts']
		);

		if (is_admin()) return;

		add_action('print_footer_scripts', function () {
			if (is_admin()) return;

			if (class_exists('BlocksyExtensionCookiesConsent')) {
				if (\BlocksyExtensionCookiesConsent::should_display_notification()) {
					return;
				}
			}

			$analytics_id = get_theme_mod('analytics_id', '');

			if (! empty($analytics_id)) {
			?>

			<!-- Google Analytics -->
			<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $analytics_id ?>', 'auto');
			ga('send', 'pageview');
			<?php if (get_theme_mod('ip_anonymization', 'no') === 'yes') { ?>
			ga('set', 'anonymizeIp', true);
			<?php } ?>
			</script>
			<!-- End Google Analytics -->

			<?php
			};

			$analytics_v4_id = get_theme_mod('analytics_v4_id', '');

			if (! empty($analytics_v4_id)) {
			?>

			<!-- Global site tag (gtag.js) - Google Analytics v4 -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analytics_v4_id ?>"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php echo $analytics_v4_id?>');
			</script>
			<!-- End Google Analytics v4 -->

			<?php
			};


		});
	}

	public function generate_google_analytics_opts($options) {
		$options[] = [
			'analytics_id' => [
				'label' => __( 'Google Analytics', 'blc' ),
				'type' => 'text',
				'design' => 'block',
				'divider' => 'bottom',
				'value' => '',
				'desc' => __( 'Insert your Google Analytics tracking ID.', 'blc' ),
				'disableRevertButton' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'analytics_v4_id' => [
				'label' => __( 'Google Analytics v4', 'blc' ),
				'type' => 'text',
				'design' => 'block',
				'divider' => 'bottom',
				'value' => '',
				'desc' => sprintf(
					__(
						'Insert your Google Analytics v4 tracking ID. Instructions on how to activate this for your site can be found %shere%s.',
						'blc'
					),
					'<a href="https://support.google.com/analytics/answer/9744165?hl=en">',
					'</a>'
				),
				'disableRevertButton' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'ip_anonymization' => [
				'label' => __( 'IP Anonymization', 'blc' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'desc' => __( 'Enable Google Analytics IP anonymization feature <a href="https://developers.google.com/analytics/devguides/collection/gtagjs/ip-anonymization">(more info)</a>.', 'blc' ),
				'setting' => [ 'transport' => 'postMessage' ],
			],
		];

		return $options;
	}
}
