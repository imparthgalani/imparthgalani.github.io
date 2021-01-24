<?php
/**
 * Buttons options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [

	'buttons_panel' => [
		'label' => __( 'Buttons', 'blocksy' ),
		'type' => 'ct-panel',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'buttonMinHeight' => [
				'label' => __( 'Min Height', 'blocksy' ),
				'type' => 'ct-slider',
				'min' => 30,
				'max' => 100,
				'value' => 45,
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'buttonHoverEffect' => [
				'label' => __( 'Hover Effect', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'buttonRadius' => [
				'label' => __( 'Border Radius', 'blocksy' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
					'top' => '3px',
					'left' => '3px',
					'right' => '3px',
					'bottom' => '3px',
				]),
				'responsive' => true
			],

			'buttonTextColor' => [
				'label' => __( 'Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'top',
				'skipEditPalette' => true,
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

			'buttonColor' => [
				'label' => __( 'Background Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'skipEditPalette' => true,
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

		],
	],

];