<?php

class Blocksy_Header_Builder_Patcher {
	private $patch_result = null;

	public function mount_theme_mod_value_patcher() {
		add_filter('theme_mod_header_placements', function ($value) {
			return $this->get_patch_result($value);
		});

		add_filter('option_theme_mods_' . get_option('stylesheet'), function ($value) {
			$original_value = $value;

			if (! is_array($value)) {
				return $value;
			}

			if (! isset($value['header_placements'])) {
				return $value;
			}

			if (! is_array($value['header_placements'])) {
				return $value;
			}

			$value['header_placements'] = $this->get_patch_result(
				$value['header_placements']
			);

			if (! is_array($value['header_placements'])) {
				return $original_value;
			}

			return $value;
		});
	}

	private function get_patch_result($value) {
		if (! $this->patch_result || wp_doing_ajax()) {
			$this->patch_result = $this->patch_header_placements($value);
		}

		return $this->patch_result;
	}

	private function patch_header_placements($value) {
		if (! is_array($value)) {
			return $value;
		}

		if (! isset($value['sections'])) {
			return $value;
		}

		$default = blocksy_manager()->header_builder->get_default_value();

		$present_ids = [];

		foreach ($value['sections'] as $actual_section) {
			$present_ids[] = $actual_section['id'];
		}

		$is_a_custom_in_default = false;

		foreach ($default['sections'] as $actual_section) {
			if (strpos($actual_section['id'], 'ct-custom') !== false) {
				$is_a_custom_in_default = true;
			}
		}

		/**
		 * Very important code path.
		 * This checks if there are no custom headers added.
		 */
		if (
			! $is_a_custom_in_default
			&&
			strpos($value['current_section'], 'ct-custom') !== false
		) {
			$value['current_section'] = $present_ids[0];
		}

		foreach ($default['sections'] as $single_section) {
			if (! in_array($single_section['id'], $present_ids)) {
				$value['sections'][] = $single_section;
			}
		}

		if (isset($value['__forced_static_header__'])) {
			$should_have_preview = is_customize_preview() || isset(
				$_REQUEST['wp_customize_render_partials']
			);

			if (! $should_have_preview) {
				unset($value['__forced_static_header__']);
			}
		}

		foreach ($value['sections'] as $section_index => $single_section) {
			$has_offcanvas = in_array('offcanvas', array_map(function ($row) {
				return $row['id'];
			}, $single_section['desktop']));

			if (! $has_offcanvas) {
				$value['sections'][$section_index]['desktop'][] = [
					'id' => 'offcanvas',
					'placements' => [
						[
							'id' => 'start',
							'items' => []
						]
					]
				];
			}
		}

		return $value;
	}
}
