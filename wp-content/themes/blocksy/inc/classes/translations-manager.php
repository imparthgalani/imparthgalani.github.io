<?php

class Blocksy_Translations_Manager {
	public function get_all_translation_keys() {
		$builder_keys = Blocksy_Manager::instance()->builder->translation_keys();

		foreach (['blog', 'categories', 'search', 'author'] as $prefix) {
			$archive_order = get_theme_mod($prefix . '_archive_order', null);

			if (! $archive_order) {
				continue;
			}

			foreach ($archive_order as $single_archive_component) {
				if ($single_archive_component['id'] !== 'read_more') {
					continue;
				}

				if (blocksy_akg('read_more_text', $single_archive_component)) {
					$builder_keys[] = [
						'key' => $prefix . '_archive_read_more_text',
						'value' => blocksy_akg(
							'read_more_text',
							$single_archive_component
						)
					];
				}
			}
		}

		foreach (['blog'] as $prefix) {
			$hero_elements = get_theme_mod($prefix . '_hero_elements', null);

			if (! $hero_elements) {
				continue;
			}

			foreach ($hero_elements as $single_hero_component) {
				if (
					$single_hero_component['id'] === 'custom_title'
					&&
					blocksy_akg('title', $single_hero_component)
				) {
					$builder_keys[] = [
						'key' => $prefix . '_hero_custom_title',
						'value' => blocksy_akg('title', $single_hero_component)
					];
				}

				if (
					$single_hero_component['id'] === 'custom_description'
					&&
					blocksy_akg('description', $single_hero_component)
				) {
					$builder_keys[] = [
						'key' => $prefix . '_hero_custom_description',
						'value' => blocksy_akg('description', $single_hero_component)
					];
				}
			}
		}

		return $builder_keys;
	}

	public function register_translation_keys() {
		if (!function_exists('pll_register_string')) {
			return;
		}

		$builder_keys = $this->get_all_translation_keys();

		foreach ($builder_keys as $single_key) {
			pll_register_string(
				$single_key['key'],
				$single_key['value'],
				'Blocksy',
				isset($single_key['multiline']) ? $single_key['multiline'] : false
			);
		}
	}

	public function register_wpml_translation_keys() {
		if (! function_exists('icl_object_id')) {
			return;
		}

		$builder_keys = $this->get_all_translation_keys();

		foreach ($builder_keys as $single_key) {
			do_action(
				'wpml_register_single_string',
				'Blocksy',
				$single_key['key'],
				$single_key['value']
			);
		}
	}
}

if (! function_exists('blocksy_has_i18n_plugin')) {
	function blocksy_has_i18n_plugin() {
		if (function_exists('pll_the_languages')) {
			return true;
		}

		if (function_exists('icl_object_id')) {
			return true;
		}

		if (function_exists('weglot_get_current_language')) {
			return true;
		}

		return false;
	}
}

if (! function_exists('blocksy_translate_dynamic')) {
	function blocksy_translate_dynamic($text, $key = null) {
		if (function_exists('pll__')) {
			return pll__($text); // PHPCS:ignore WordPress.WP.I18n
		}

		if ($key) {
			return apply_filters(
				'wpml_translate_single_string',
				$text,
				'Blocksy',
				$key
			);
		}

		return $text;
	}
}
