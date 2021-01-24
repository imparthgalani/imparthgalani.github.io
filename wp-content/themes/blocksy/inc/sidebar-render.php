<?php

if (! function_exists('blocksy_render_sidebar')) {
function blocksy_render_sidebar() {
	if (blocksy_sidebar_position() === 'none') {
		return '';
	}

	$sticky_output = '';

	$type = get_theme_mod('sidebar_type', 'type-1');

	if (get_theme_mod('has_sticky_sidebar', 'no') === 'yes') {
		$sticky_output = 'data-sticky';
	}

	$widgets_separated_output = '';

	if (
		$type === 'type-2'
		&&
		get_theme_mod('separated_widgets', 'no') === 'yes'
	) {
		$widgets_separated_output = 'data-widgets="separated"';
	}

	$class_output = '';

	$sidebar_classes = blocksy_visibility_classes(get_theme_mod('sidebar_visibility', [
		'desktop' => true,
		'tablet' => false,
		'mobile' => false,
	]));

	if (! empty(trim($sidebar_classes))) {
		$class_output = 'class="' . $sidebar_classes . '"';
	}

	$sidebar_to_render = blocksy_get_sidebar_to_render();

	if (! is_active_sidebar($sidebar_to_render)) {
		return '<aside></aside>';
	}

	$prefix = blocksy_manager()->screen->get_prefix();

	ob_start();

	?>

	<aside
		<?php echo wp_kses_post($class_output); ?>
		data-type="<?php echo esc_attr($type) ?>"
		id="sidebar"
		<?php echo blocksy_generic_get_deep_link([
			'suffix' => $prefix . '_has_sidebar'
		]); ?>
		<?php echo blocksy_schema_org_definitions('sidebar') ?>>

		<div
			class="ct-sidebar" <?php echo wp_kses_post($sticky_output); ?>
			<?php echo wp_kses_post($widgets_separated_output) ?>>
			<?php dynamic_sidebar($sidebar_to_render); ?>
		</div>
	</aside>

	<?php

	return ob_get_clean();
}
}

