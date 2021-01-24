<?php

add_action('init', function () {
	if (
		get_option(
			'elementor_disable_color_schemes',
			'__DEFAULT__'
		) === '__DEFAULT__'
	) {
		update_option('elementor_disable_color_schemes', 'yes');
	}

	if (
		get_option(
			'elementor_disable_typography_schemes',
			'__DEFAULT__'
		) === '__DEFAULT__'
	) {
		update_option('elementor_disable_typography_schemes', 'yes');
	}

	if (! get_option('elementor_viewport_lg')) {
		update_option('elementor_viewport_lg', 1000);
	}

	if (! get_option('elementor_viewport_md')) {
		update_option('elementor_viewport_md', 690);
	}

	add_action(
		'elementor/element/section/section_layout/after_section_start',
		function ($element, $args) {
			$element->add_control('blocksy_stretch_section', [
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Full Width Section', 'blocksy' ),
				// 'description' => esc_html__( 'It will remove the "weird" columns gap added by Elementor on the left and right side of each section (when `Columns Gap` is active). This helps you to have consistent content width without having to manually readjust it everytime you create sections with `Columns Gap`', 'blocksy' ),
				'return_value' => 'stretched',
				'hide_in_inner' => true,
				'default' => '',
				'separator' => 'after',
				'prefix_class' => 'ct-section-',
			]);
		},
		10, 2
	);

	add_action(
		'elementor/element/section/section_layout/before_section_end',
		function ($element, $args) {
			$element->remove_control('stretch_section');
			$element->add_control('fix_columns_alignment', [
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Columns Alignment Fix', 'blocksy' ),
				// 'description' => esc_html__( 'It will remove the "weird" columns gap added by Elementor on the left and right side of each section (when `Columns Gap` is active). This helps you to have consistent content width without having to manually readjust it everytime you create sections with `Columns Gap`', 'blocksy' ),
				'return_value' => 'fix',
				'default' => apply_filters(
					'blocksy:integrations:elementor:fix_columns_alignment:default',
					''
				),
				'separator' => 'before',
				'prefix_class' => 'ct-columns-alignment-',
			]);
		},
		10, 2
	);

	add_action('elementor/editor/after_enqueue_styles', function () {
		$theme = blocksy_get_wp_parent_theme();

		wp_enqueue_style(
			'blocksy-elementor-styles',
			get_template_directory_uri() . '/static/bundle/elementor.css',
			[],
			$theme->get('Version')
		);
	});
});

add_filter('fl_builder_settings_form_defaults', function ($defaults, $form_type) {
	if ('global' === $form_type) {
		$defaults->row_padding = '0';
		$defaults->row_width = '1290';
		$defaults->medium_breakpoint = '1000';
		$defaults->responsive_breakpoint = '690';
	}

	return $defaults;
}, 10, 2);

add_action(
	'elementor/theme/register_locations',
	function ($elementor_theme_manager) {
		$elementor_theme_manager->register_all_core_location();
	}
);

