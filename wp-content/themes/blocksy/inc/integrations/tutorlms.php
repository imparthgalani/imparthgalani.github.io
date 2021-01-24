<?php

if (! function_exists('blocksy_tutor_lms_content_open')) {
	function blocksy_tutor_lms_content_open() {
		echo '<div class="ct-container-full" data-v-spacing="top:bottom">';
	}
}

if (! function_exists('blocksy_tutor_lms_content_close')) {
	function blocksy_tutor_lms_content_close() {
		echo '</div>';
	}
}

if (! function_exists('blocksy_tutor_lms_course_content_open')) {
	function blocksy_tutor_lms_course_content_open() {
		$sidebar = 'right';

		$page_structure_type = get_theme_mod('tutorlms_single_structure', 'type-1');

		if ('type-1' === $page_structure_type) {
			$sidebar = 'right';
		}

		if ('type-2' === $page_structure_type) {
			$sidebar = 'left';
		}

		$attr = [
			'class' => 'ct-container-full',
			'data-v-spacing' => 'top:bottom',
			'data-tutor-sidebar' => $sidebar,
			'data-structure' => get_theme_mod(
				'courses_single_content_style',
				'boxed'
			)
		];

		echo '<div ' . blocksy_attr_to_html($attr) . '>';
	}
}

if (! function_exists('blocksy_tutor_lms_content_close')) {
	function blocksy_tutor_lms_content_close() {
		echo '</div>';
	}
}

add_action('tutor_dashboard/before/wrap', 'blocksy_tutor_lms_content_open');
add_action('tutor_dashboard/after/wrap', 'blocksy_tutor_lms_content_close');
add_action('tutor_course/archive/before/wrap', 'blocksy_tutor_lms_content_open');
add_action('tutor_course/archive/after/wrap', 'blocksy_tutor_lms_content_close');
add_action('tutor_student/before/wrap', 'blocksy_tutor_lms_content_open');
add_action('tutor_student/after/wrap', 'blocksy_tutor_lms_content_close');

add_action('tutor_course/single/before/wrap', 'blocksy_tutor_lms_course_content_open');
add_action('tutor_course/single/after/wrap', 'blocksy_tutor_lms_content_close');
add_action('tutor_course/single/enrolled/before/wrap', 'blocksy_tutor_lms_course_content_open');
add_action('tutor_course/single/enrolled/after/wrap', 'blocksy_tutor_lms_content_close');

add_action('tutor_course/single/before/wrap', function () {
});

add_action('wp_enqueue_scripts', function () {
	if (! function_exists('tutor_utils')) {
		return;
	}

	$is_script_debug = tutor_utils()->is_script_debug();
	$suffix = $is_script_debug ? '' : '.min';

	if (tutor_utils()->get_option('load_tutor_css')){
		wp_enqueue_style(
			'tutor-frontend',
			tutor()->url."assets/css/tutor-front{$suffix}.css",
			array(),
			tutor()->version
		);
	}
}, 5);

