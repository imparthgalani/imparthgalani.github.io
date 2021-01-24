<?php
/**
 * Breadcrumbs options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [

	'breadcrumbs_panel' => [
		'label' => __( 'Breadcrumbs', 'blocksy' ),
		'type' => 'ct-panel',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'breadcrumb_separator' => [
				'label' => __('Separator', 'blocksy'),
				'type' => 'ct-image-picker',
				'value' => 'type-1',
				'attr' => [ 'data-columns' => '3' ],
				'divider' => 'bottom',
				'choices' => [

					'type-1' => [
						'src'   => blocksy_image_picker_file( 'breadcrumb-sep-1' ),
						'title' => __( 'Type 1', 'blocksy' ),
					],

					'type-2' => [
						'src'   => blocksy_image_picker_file( 'breadcrumb-sep-2' ),
						'title' => __( 'Type 2', 'blocksy' ),
					],

					'type-3' => [
						'src'   => blocksy_image_picker_file( 'breadcrumb-sep-3' ),
						'title' => __( 'Type 3', 'blocksy' ),
					],
				],

				'sync' => blocksy_sync_whole_page([
					'loader_selector' => '.ct-breadcrumbs'
				]),
			],

			'breadcrumb_home_item' => [
				'label' => __('Home Item', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'text',
				'view' => 'text',
				'choices' => [
					'text' => __('Text', 'blocksy'),
					'icon' => __('Icon', 'blocksy'),
				],
				'sync' => blocksy_sync_whole_page([
					'loader_selector' => '.ct-breadcrumbs'
				]),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'breadcrumb_home_item' => 'text' ],
				'options' => [

					'breadcrumb_home_text' => [
						'label' => __( 'Home Page Text', 'blocksy' ),
						'type' => 'text',
						'design' => 'block',
						'value' => __( 'Home', 'blocksy' ),
						'sync' => blocksy_sync_whole_page([
							'loader_selector' => '.ct-breadcrumbs'
						]),
					],

				],
			],

			'breadcrumb_page_title' => [
				'label' => __( 'Current Page/Post Title', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'divider' => 'top',
				'sync' => blocksy_sync_whole_page([
					'loader_selector' => '.ct-breadcrumbs'
				]),
			],

			'breadcrumb_taxonomy_title' => [
				'label' => __( 'Current Taxonomy Title', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'divider' => 'top',
				'sync' => blocksy_sync_whole_page([
					'loader_selector' => '.ct-breadcrumbs'
				]),
			],

		],
	],

];
