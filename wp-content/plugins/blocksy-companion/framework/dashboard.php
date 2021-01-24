<?php

namespace Blocksy;

class Dashboard {
	public function __construct() {
		add_action(
			'admin_enqueue_scripts',
			[ $this, 'enqueue_static' ],
			100
		);

		add_action('admin_body_class', function ($class) {
			if (blc_fs()->is_activation_mode()) {
				$class .= ' blocksy-fs-optin-dashboard';
			}

			return $class;
		});

		blc_fs()->add_filter(
			'connect-message_on-premium',
			function ($text) {
				if (strpos($text, '<br>') !== false) {
					$exploded_message = explode('<br>', $text);

					$text = '<span>' . $exploded_message[0] . '</span>' . $exploded_message[1];
				}

				return $text;
			}
		);

		blc_fs()->add_filter(
			'connect_message_on_update',
			function (
				$message,
				$user_first_name,
				$product_title,
				$user_login,
				$site_link,
				$freemius_link
			) {
				$is_network_upgrade_mode = ( fs_is_network_admin() && blc_fs()->is_network_upgrade_mode() );
				$slug = blc_fs()->get_slug();
				$is_gdpr_required = \FS_GDPR_Manager::instance()->is_required();
				$hey_x_text = esc_html( sprintf( fs_text_x_inline( 'Hey %s,', 'greeting', 'hey-x', $slug ), $user_first_name ) );

				$default_optin_message = $is_gdpr_required ?
					fs_text_inline( 'Never miss an important update - opt in to our security & feature updates notifications, educational content, offers, and non-sensitive diagnostic tracking with %4$s. If you skip this, that\'s okay! %1$s will still work just fine.', 'connect-message_on-update', $slug ) :
					fs_text_inline( 'Never miss an important update - opt in to our security & feature updates notifications, and non-sensitive diagnostic tracking with %4$s. If you skip this, that\'s okay! %1$s will still work just fine.', 'connect-message_on-update', $slug );

				return (($is_network_upgrade_mode ?
					'' :
					/* translators: %s: name (e.g. Hey John,) */
					'<span>' . $hey_x_text . '</span>'
				) .
				sprintf(
					esc_html( $default_optin_message ),
					'<b>' . esc_html( blc_fs()->get_plugin_name() ) . '</b>',
					'<b>' . $user_login . '</b>',
					$site_link,
					$freemius_link
				));

			}, 10, 6
		);

		blc_fs()->add_action('connect/before', function () {
			$path = dirname(__FILE__) . '/views/optin.php';

			echo blc_call_fn(
				['fn' => 'blocksy_render_view'],
				$path,
				[]
			);
		});

		blc_fs()->add_action('connect/after', function () {
			echo '</div>';
		});

		add_action(
			'wp_ajax_blocksy_fs_connect_again',
			function () {
				if (! current_user_can('edit_theme_options')) {
					wp_send_json_error();
				}

				blc_fs()->connect_again();
				wp_send_json_success();
			}
		);

		add_filter(
			'blocksy_dashboard_localizations',
			function ($d) {
				$is_anonymous = blc_fs()->is_anonymous();
				$connect_template = '';

				if ($is_anonymous) {
					ob_start();
					blc_fs()->_connect_page_render();
					$connect_template = ob_get_clean();
				}

				return array_merge([
					'is_pro' => blc_fs()->is__premium_only(),
					'is_anonymous' => $is_anonymous,
					'connect_template' => $connect_template,
					'has_beta_consent' => Plugin::instance()->user_wants_beta_updates()
				], $d);
			}
		);
	}

	public function enqueue_static() {
		if (! function_exists('blocksy_is_dashboard_page')) return;
		if (! blocksy_is_dashboard_page()) return;

		$data = get_plugin_data(BLOCKSY__FILE__);

		$deps = apply_filters('blocksy-dashboard-scripts-dependencies', [
			'wp-i18n',
			'ct-events',
			'ct-options-scripts'
		]);

		wp_enqueue_script(
			'blocksy-dashboard-scripts',
			BLOCKSY_URL . 'static/bundle/dashboard.js',
			$deps,
			$data['Version'],
			false
		);

		wp_enqueue_style(
			'blocksy-dashboard-styles',
			BLOCKSY_URL . 'static/bundle/dashboard.css',
			[],
			$data['Version']
		);
	}
}
