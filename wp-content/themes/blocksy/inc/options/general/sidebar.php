<?php
/**
 * Colors options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'sidebar_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'sidebar_type' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'type-1',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'type-1' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-1.svg' ),
								'title' => __( 'Type 1', 'blocksy' ),
							],

							'type-2' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-2.svg' ),
								'title' => __( 'Type 2', 'blocksy' ),
							],

							'type-3' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-3.svg' ),
								'title' => __( 'Type 3', 'blocksy' ),
							],


							'type-4' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-4.svg' ),
								'title' => __( 'Type 4', 'blocksy' ),
							],

						],
					],

					'sidebarWidth' => [
						'label' => __( 'Sidebar Width', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => 27,
						'min' => 10,
						'max' => 70,
						'defaultUnit' => '%',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarGap' => [
						'label' => __( 'Sidebar Gap', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => '4%',
						'units' => blocksy_units_config([
							[ 'unit' => '%', 'min' => 0, 'max' => 50 ],
							[ 'unit' => 'px', 'min' => 0, 'max' => 600 ],
							[ 'unit' => 'pt', 'min' => 0, 'max' => 500 ],
							[ 'unit' => 'em', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'rem', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'vw', 'min' => 0, 'max' => 50 ],
							[ 'unit' => 'vh', 'min' => 0, 'max' => 50 ],
						]),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2 | type-3 | type-4' ],
						'options' => [

							'sidebarInnerSpacing' => [
								'label' => __( 'Container Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'min' => 5,
								'max' => 80,
								'responsive' => true,
								'value' => [
									'mobile' => 35,
									'tablet' => 35,
									'desktop' => 35,
								],
								'setting' => [ 'transport' => 'postMessage' ],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

						],
					],

					'sidebarWidgetsSpacing' => [
						'label' => __( 'Widgets Vertical Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'desktop' => 60,
							'tablet' => 40,
							'mobile' => 40,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'widgets_title_wrapper' => [
						'label' => __( 'Widget Title Tag', 'blocksy' ),
						'type' => 'ct-select',
						'value' => 'h2',
						'view' => 'text',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => blocksy_ordered_keys(
							[
								'h1' => 'H1',
								'h2' => 'H2',
								'h3' => 'H3',
								'h4' => 'H4',
								'h5' => 'H5',
								'h6' => 'H6',
								'span' => 'span',
							]
						),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2' ],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							'separated_widgets' => [
								'label' => __( 'Separate Widgets', 'blocksy' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'has_sticky_sidebar' => [
						'label' => __( 'Sticky Sidebar', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_sticky_sidebar' => 'yes' ],
						'options' => [

							'sidebarOffset' => [
								'label' => __( 'Top Offset', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => 50,
								'min' => 0,
								'max' => 200,
								'defaultUnit' => 'px',
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'sidebar_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'desktop' => true,
							'tablet' => false,
							'mobile' => false,
						],

						'choices' => blocksy_ordered_keys([
							'desktop' => __( 'Desktop', 'blocksy' ),
							'tablet' => __( 'Tablet', 'blocksy' ),
							'mobile' => __( 'Mobile', 'blocksy' ),
						]),
					],

				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'sidebarWidgetsTitleFont' => [
						'type' => 'ct-typography',
						'label' => __( 'Widgets Title Font', 'blocksy' ),
						'value' => blocksy_typography_default_values([
							'size' => '18px',
						]),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarWidgetsTitleColor' => [
						'label' => __( 'Widgets Title Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'var(--headingColor)'
							],
						],
					],

					'sidebarWidgetsFont' => [
						'type' => 'ct-typography',
						'label' => __( 'Widgets Font', 'blocksy' ),
						'value' => blocksy_typography_default_values([
							// 'size' => '16px',
						]),
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarWidgetsFontColor' => [
						'label' => __( 'Widgets Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_initial' => [
								'color' => 'var(--color)',
							],

							'link_hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Text Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'var(--color)'
							],

							[
								'title' => __( 'Link Initial', 'blocksy' ),
								'id' => 'link_initial',
							],

							[
								'title' => __( 'Link Hover', 'blocksy' ),
								'id' => 'link_hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],

					'sidebarWidgetsHeadingFontColor' => [
						'label' => __( 'Widgets Headings Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'var(--headingColor)'
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2 | type-4' ],
						'options' => [

							'sidebarBackgroundColor' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'block:right',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'default' => [
										'color' => 'var(--paletteColor5)',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2' ],
						'options' => [

							'sidebarBorder' => [
								'label' => __( 'Border', 'blocksy' ),
								'type' => 'ct-border',
								'design' => 'block',
								'divider' => 'top',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'width' => 1,
									'style' => 'none',
									'color' => [
										'color' => 'rgba(224, 229, 235, 0.8)',
									],
								]
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-3' ],
						'options' => [

							'sidebarDivider' => [
								'label' => __( 'Divider', 'blocksy' ),
								'type' => 'ct-border',
								'design' => 'block',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'width' => 1,
									'style' => 'solid',
									'color' => [
										'color' => 'rgba(224, 229, 235, 0.8)',
									],
								]
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2' ],
						'options' => [

							'sidebarShadow' => [
								'label' => __( 'Shadow', 'blocksy' ),
								'type' => 'ct-box-shadow',
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => blocksy_box_shadow_value([
									'enable' => true,
									'h_offset' => 0,
									'v_offset' => 12,
									'blur' => 18,
									'spread' => -6,
									'inset' => false,
									'color' => [
										'color' => 'rgba(34, 56, 101, 0.04)',
									],
								])
							],

							'sidebarRadius' => [
								'label' => __( 'Border Radius', 'blocksy' ),
								'type' => 'ct-spacing',
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => blocksy_spacing_value([
									'linked' => true,
								]),
								'responsive' => true
							],

						],
					],

				],
			],
		],
	],
];
