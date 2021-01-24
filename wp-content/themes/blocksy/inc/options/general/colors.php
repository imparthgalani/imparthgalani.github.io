<?php
/**
 * Colors options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'colors_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'colorPalette' => [
				'label' => __( 'Color Palettes', 'blocksy' ),
				'type'  => 'ct-color-palettes-picker',
				'design' => 'block',
				// translators: The interpolations addes a html link around the word.
				'desc' => sprintf(
					__('Learn more about palettes and colors %shere%s.', 'blocksy'),
					'<a href="https://creativethemes.com/blocksy/docs/general-options/colors/" target="_blank">',
					'</a>'
				),
				'setting' => [ 'transport' => 'postMessage' ],
				'predefined' => true,
				'wrapperAttr' => [
					'data-type' => 'color-palette',
					'data-label' => 'heading-label'
				],

				'value' => [
					'color1' => [
						'color' => '#3eaf7c',
					],

					'color2' => [
						'color' => '#33a370',
					],

					'color3' => [
						'color' => 'rgba(44, 62, 80, 0.9)',
					],

					'color4' => [
						'color' => 'rgba(44, 62, 80, 1)',
					],

					'color5' => [
						'color' => '#ffffff',
					],

					'current_palette' => 'palette-1',

					'palettes' => [
						[
							'id' => 'palette-1',

							'color1' => [
								'color' => '#3eaf7c',
							],

							'color2' => [
								'color' => '#33a370',
							],

							'color3' => [
								'color' => 'rgba(44, 62, 80, 0.9)',
							],

							'color4' => [
								'color' => 'rgba(44, 62, 80, 1)',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						],

						[
							'id' => 'palette-2',

							'color1' => [
								'color' => '#2872fa',
							],

							'color2' => [
								'color' => '#1559ed',
							],

							'color3' => [
								'color' => 'rgba(36,59,86,0.9)',
							],

							'color4' => [
								'color' => 'rgba(36,59,86,1)',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						],

						[
							'id' => 'palette-3',

							'color1' => [
								'color' => '#FB7258',
							],

							'color2' => [
								'color' => '#F74D67',
							],

							'color3' => [
								'color' => '#6e6d76',
							],

							'color4' => [
								'color' => '#0e0c1b',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						]
					]
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Global Colors', 'blocksy' ),
			],

			'fontColor' => [
				'label' => __( 'Base Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'skipEditPalette' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor3)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'linkColor' => [
				'label' => __( 'Link Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'skipEditPalette' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor1)',
					],

					'hover' => [
						'color' => 'var(--paletteColor2)',
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

			'headingColor' => [
				'label' => __( 'Heading Color (H1 - H6)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'skipEditPalette' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'selectionColor' => [
				'label' => __( 'Text Selection Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'skipEditPalette' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => '#ffffff',
					],

					'hover' => [
						'color' => 'var(--paletteColor1)',
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

			'border_color' => [
				'label' => __( 'Border Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'rgba(224, 229, 235, 0.9)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'site_background' => [
				'label' => __( 'Site Background', 'blocksy' ),
				'type' => 'ct-background',
				'design' => 'block:right',
				'responsive' => true,
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => '#f8f9fb'
						],
					],
				])
			],

		],
	],
];
