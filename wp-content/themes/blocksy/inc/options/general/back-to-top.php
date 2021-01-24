<?php
/**
 * Back to top options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'has_back_top' => [
		'label' => __( 'Scroll to Top', 'blocksy' ),
		'type' => 'ct-panel',
		'switch' => true,
		'value' => 'no',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'top_button_type' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'type-1',
						'attr' => [
							'data-type' => 'background',
							'data-columns' => '3',
						],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'type-1' => [
								'src'   => blocksy_image_picker_file( 'top-1' ),
								'title' => __( 'Type 1', 'blocksy' ),
							],

							'type-2' => [
								'src'   => blocksy_image_picker_file( 'top-2' ),
								'title' => __( 'Type 2', 'blocksy' ),
							],

							'type-3' => [
								'src'   => blocksy_image_picker_file( 'top-3' ),
								'title' => __( 'Type 3', 'blocksy' ),
							],
						],
					],

					'top_button_shape' => [
						'label' => __( 'Button Shape', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'square',
						'view' => 'text',
						'design' => 'block',
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'square' => __( 'Square', 'blocksy' ),
							'circle' => __( 'Circle', 'blocksy' ),
						],
					],

					'topButtonSize' => [
						'label' => __( 'Icon Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 10,
						'max' => 50,
						'value' => 12,
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'topButtonOffset' => [
						'label' => __( 'Bottom Offset', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 5,
						'max' => 300,
						'value' => 25,
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sideButtonOffset' => [
						'label' => __( 'Side Offset', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 5,
						'max' => 300,
						'value' => 25,
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'top_button_alignment' => [
						'label' => __( 'Alignment', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'right',
						'setting' => [ 'transport' => 'postMessage' ],
						'view' => 'text',
						'divider' => 'top',
						'attr' => [ 'data-type' => 'alignment' ],
						'choices' => [
							'left' => '',
							'right' => '',
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'back_top_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'desktop' => true,
							'tablet' => true,
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

					'topButtonIconColor' => [
						'label' => __( 'Icon Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => '#ffffff',
							],

							'hover' => [
								'color' => '#ffffff',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'topButtonShapeBackground' => [
						'label' => __( 'Shape Background Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'var(--paletteColor3)',
							],

							'hover' => [
								'color' => 'var(--paletteColor4)',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'topButtonShadow' => [
						'label' => __( 'Shadow', 'blocksy' ),
						'type' => 'ct-box-shadow',
						'divider' => 'top',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => blocksy_box_shadow_value([
							'enable' => false,
							'h_offset' => 0,
							'v_offset' => 5,
							'blur' => 20,
							'spread' => 0,
							'inset' => false,
							'color' => [
								'color' => 'rgba(210, 213, 218, 0.2)',
							],
						])
					],

				],
			],

		],
	],
];