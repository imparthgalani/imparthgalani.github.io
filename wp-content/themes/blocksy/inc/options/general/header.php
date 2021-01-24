<?php

$options = [
	'header_general_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'customizer_section' => 'layout',
		'inner-options' => [
			'header_placements' => [
				'type' => 'ct-header-builder',
				'setting' => ['transport' => 'postMessage'],
				'value' => blocksy_manager()->header_builder->get_default_value(),
				'selective_refresh' => apply_filters('blocksy:header:selective_refresh', [
					[
						'id' => 'header_placements_1',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#main-container > header',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							echo blocksy_manager()->header_builder->render();
						}
					],

					[
						'id' => 'header_placements_offcanvas',
						'fallback_refresh' => false,
						'container_inclusive' => false,
						'selector' => '#offcanvas',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$elements = new Blocksy_Header_Builder_Elements();

							echo $elements->render_offcanvas([
								'has_container' => false
							]);
						}
					],

					[
						'id' => 'header_placements_item:menu',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#main-container > header',
						'loader_selector' => '[data-id="menu"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							echo blocksy_manager()->header_builder->render();
						}
					],

					[
						'id' => 'header_placements_item:cart',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => 'header [data-id="cart"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$header = new Blocksy_Header_Builder_Render();
							echo $header->render_single_item('cart');
						}
					],

					[
						'id' => 'header_placements_item:menu-secondary',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#main-container > header',
						'loader_selector' => '[data-id="menu-secondary"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							echo blocksy_manager()->header_builder->render();
						}
					],

					[
						'id' => 'header_placements_item:mobile-menu',
						'fallback_refresh' => false,
						'container_inclusive' => false,
						'selector' => '#offcanvas',
						'loader_selector' => '[data-id="mobile-menu"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$elements = new Blocksy_Header_Builder_Elements();

							echo $elements->render_offcanvas([
								'has_container' => false
							]);
						}
					],

					[
						'id' => 'header_placements_item:logo:desktop',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '[data-device="desktop"] [data-id="logo"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Header_Builder_Render();
							echo $b->render_single_item('logo');
						}
					],

					[
						'id' => 'header_placements_item_mobile:logo:mobile',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '[data-device="mobile"] [data-id="logo"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Header_Builder_Render();

							echo $b->render_single_item('logo', [
								'device' => 'mobile'
							]);
						}
					]
				]),
			],
		]
	],
];

