<?php

class Blocksy_Header_Builder_Elements {
	public function render_offcanvas($args = []) {
		$args = wp_parse_args($args, [
			'has_container' => true,
			'device' => 'mobile'
		]);

		$render = new Blocksy_Header_Builder_Render();

		if (! $render->contains_item('trigger')) {
			return '';
		}

		$mobile_content = '';
		$desktop_content = '';

		$current_layout = $render->get_current_section()['mobile'];

		foreach ($current_layout as $row) {
			if ($row['id'] !== 'offcanvas') {
				continue;
			}

			if ($render->is_row_empty($row)) {
				// return '';
			}

			$mobile_content .= $render->render_items_collection(
				$row['placements'][0]['items']
			);
		}

		$current_layout = $render->get_current_section()['desktop'];

		foreach ($current_layout as $row) {
			if ($row['id'] !== 'offcanvas') {
				continue;
			}

			$desktop_content .= $render->render_items_collection(
				$row['placements'][0]['items']
			);
		}

		$atts = $render->get_item_data_for('offcanvas');
		$row_config = $render->get_item_config_for('offcanvas');

		$class = 'ct-panel ct-header';
		$behavior = 'modal';

		$position_output = [];

		if (blocksy_default_akg('offcanvas_behavior', $atts, 'panel') !== 'modal') {
			$behavior = blocksy_default_akg(
				'side_panel_position', $atts, 'right'
			) . '-side';
		}

		ob_start();
		do_action('blocksy:header:offcanvas:desktop:top');
		$desktop_content = ob_get_clean() . $desktop_content;

		ob_start();
		do_action('blocksy:header:offcanvas:desktop:bottom');
		$desktop_content = $desktop_content . ob_get_clean();

		ob_start();
		do_action('blocksy:header:offcanvas:mobile:top');
		$mobile_content = ob_get_clean() . $mobile_content;

		ob_start();
		do_action('blocksy:header:offcanvas:mobile:bottom');
		$mobile_content = $mobile_content . ob_get_clean();

		$without_container = blocksy_html_tag(
			'div',
			array_merge(
				[
					'class' => 'ct-panel-content',
					'data-device' => 'desktop'
				],
				is_customize_preview() ? [
					'data-item-label' => $row_config['config']['name'],
					'data-location' => $render->get_customizer_location_for('offcanvas')
				] : []
			),
			$desktop_content
		) . blocksy_html_tag(
			'div',
			array_merge(
				[
					'class' => 'ct-panel-content',
					'data-device' => 'mobile'
				],
				is_customize_preview() ? [
					'data-item-label' => $row_config['config']['name'],
					'data-location' => $render->get_customizer_location_for('offcanvas')
				] : []
			),
			$mobile_content
		);

		$without_container = '
		<div class="ct-panel-actions">
			<div class="close-button">
				<span class="ct-trigger closed">
					<span></span>
				</span>
			</div>
		</div>
		' .  $without_container;

		if (blocksy_default_akg(
			'offcanvas_behavior',
			$atts,
			'panel'
		) === 'panel') {
			$without_container = '<section>' . $without_container . '</section>';
		}

		if (! $args['has_container']) {
			return $without_container;
		}

		return blocksy_html_tag(
			'div',
			array_merge(
				[
					'id' => 'offcanvas',
					'class' => $class,
					'data-behaviour' => $behavior,
					'data-device' => $args['device']
				],
				$position_output
			),
			$without_container
		);
	}

	public function render_search_modal() {
		$render = new Blocksy_Header_Builder_Render();

		if (! $render->contains_item('search')) {
			return;
		}

		$atts = $render->get_item_data_for('search');

		$search_through = blocksy_akg('search_through', $atts, [
			'post' => true,
			'page' => true,
			'product' => true
		]);

		foreach (blocksy_manager()->post_types->get_supported_post_types() as $single_cpt) {
			if (! isset($search_through[$single_cpt])) {
				$search_through[$single_cpt] = true;
			}
		}

		$post_type = [];

		foreach ($search_through as $single_post_type => $enabled) {
			if (! $enabled) {
				continue;
			}

			$post_type[] = $single_post_type;
		}

		?>

		<div id="search-modal" class="ct-panel" data-behaviour="modal">
			<div class="ct-panel-actions">
				<div class="close-button">
					<span class="ct-trigger closed">
						<span></span>
					</span>
				</div>
			</div>

			<div class="ct-panel-content">
				<?php get_search_form([
					'enable_search_field_class' => true,
					'ct_post_type' => $post_type
				]); ?>
			</div>
		</div>

		<?php
	}

	public function render_cart_offcanvas($args = []) {
		$args = wp_parse_args($args, [
			'has_container' => true,
			'device' => 'mobile'
		]);

		$render = new Blocksy_Header_Builder_Render();

		if (! $render->contains_item('cart')) {
			return '';
		}

		if (! function_exists('woocommerce_mini_cart')) {
			return '';
		}

		$atts = $render->get_item_data_for('cart');

		$has_cart_dropdown = blocksy_default_akg(
			'has_cart_dropdown',
			$atts,
			'yes'
		) === 'yes';

		$cart_drawer_type = blocksy_default_akg('cart_drawer_type', $atts, 'dropdown');

		if (! $has_cart_dropdown) {
			return;
		}

		if ($cart_drawer_type !== 'offcanvas') {
			return;
		}

		ob_start();
		woocommerce_mini_cart();
		$content = ob_get_clean();

		$class = 'ct-panel';
		$behavior = 'modal';

		$position_output = [];

		if (blocksy_default_akg('offcanvas_behavior', $atts, 'panel') !== 'modal') {
			$behavior = blocksy_default_akg(
				'side_panel_position', $atts, 'right'
			) . '-side';
		}

		$without_container = blocksy_html_tag(
			'div',
			array_merge([
				'class' => 'ct-panel-content',
			]),
			$content
		);

		if (! $args['has_container']) {
			return $without_container;
		}

		return blocksy_html_tag(
			'div',
			array_merge(
				[
					'id' => 'woo-cart-panel',
					'class' => $class,
					'data-behaviour' => $behavior
				],
				$position_output
			),

			'<section>
				<div class="ct-panel-actions">
					<h6>' . __('Shopping Cart', 'blocksy') . '</h6>

					<div class="close-button">
						<span class="ct-trigger closed">
							<span></span>
						</span>
					</div>
				</div>
			'
			. $without_container .

			'</section>'
		);
	}
}
