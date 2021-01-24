<?php

class BlocksyMailchimpManager {
	public function __construct() {
	}

	public function get_settings() {
		$option = get_option('blocksy_ext_mailchimp_credentials', []);

		if (empty($option)) {
			$option = [];
		}

		return array_merge([
			'api_key' => null,
			'list_id' => null
		], $option);
	}

	public function set_settings($vals) {
		update_option('blocksy_ext_mailchimp_credentials', array_merge([
			'api_key' => null,
			'list_id' => null
		], $vals));
	}

	public function can($capability = 'manage_options') {
		if (is_multisite()) {
			// Only network admin can change files that affects the entire network.
			$can = current_user_can_for_blog( get_current_blog_id(), $capability );
		} else {
			$can = current_user_can( $capability );
		}

		if ($can) {
			// Also you can use this method to get the capability.
			$can = $capability;
		}

		return $can;
	}

	public function fetch_lists($api_key) {
		if (! $api_key) {
			return 'api_key_invalid';
		}

		if (strpos($api_key, '-') === false) {
			return 'api_key_invalid';
		}

		$region = explode('-', $api_key);

		$response = wp_remote_get('https://' . $region[1] . '.api.mailchimp.com/3.0/lists', [
			'headers' => [
				'Authorization' => 'Basic ' . base64_encode('asd:' . $api_key)
			]
		]);

		if ( ! is_wp_error( $response ) ) {
			if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
				return 'api_key_invalid';
			}

			$body = json_decode(wp_remote_retrieve_body( $response ), true);

			if (! $body) {
				return 'api_key_invalid';
			}

			if (! isset($body['lists'])) {
				return 'api_key_invalid';
			}

			return array_map(function($list) {
				return [
					'name' => $list['name'],
					'id' => $list['id'],
					'subscribe_url_long' => $list['subscribe_url_long'],
					'subscribe_url_long_json' => $this->transform_subscribe_url(
						$list['subscribe_url_long']
					),

					'has_gdpr_fields' => $list['marketing_permissions']
				];
			}, $body['lists']);
		} else {
			return 'api_key_invalid';
		}
	}

	public function transform_subscribe_url($url) {
		return str_replace(
			'subscribe',
			'subscribe/post-json',
			$url . '&c=callback'
		);
	}

	public function get_form_url_and_gdpr_for($maybe_custom_list = null) {
		$settings = $this->get_settings();

		if (! isset($settings['api_key'])) {
			return false;
		}

		if (! $settings['api_key']) {
			return false;
		}

		$lists = $this->fetch_lists($settings['api_key']);

		if (! is_array($lists)) {
			return false;
		}

		if (empty($lists)) {
			return false;
		}

		if ($maybe_custom_list) {
			$settings['list_id'] = $maybe_custom_list;
		}

		if (! $settings['list_id']) {
			return [
				'form_url' => $lists[0]['subscribe_url_long'],
				'has_gdpr_fields' => $lists[0]['has_gdpr_fields']
			];
		}

		foreach ($lists as $single_list) {
			if ($single_list['id'] === $settings['list_id']) {
				return [
					'form_url' => $single_list['subscribe_url_long'],
					'has_gdpr_fields' => $single_list['has_gdpr_fields']
				];
			}
		}

		return [
			'form_url' => $lists[0]['subscribe_url_long'],
			'has_gdpr_fields' => $lists[0]['has_gdpr_fields']
		];
	}
}

