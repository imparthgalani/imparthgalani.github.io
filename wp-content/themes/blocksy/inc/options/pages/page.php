<?php

/**
 * Page options.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'page_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			[
				blocksy_get_options('general/page-title', [
					'prefix' => 'single_page',
					'is_single' => true,
					'is_page' => true
				]),

				blocksy_rand_md5() => [
					'label' => __( 'Page Structure', 'blocksy' ),
					'type' => 'ct-title',
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [
						blocksy_get_options('single-elements/structure', [
							'default_structure' => 'type-4',
							'prefix' => 'single_page',
						]),
					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [
						blocksy_get_options('single-elements/structure-design', [
							'prefix' => 'single_page',
						])
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('single-elements/featured-image', [
				'prefix' => 'single_page',
			]),

			in_array('post_tag', get_object_taxonomies('page')) ? [
				'single_page_has_post_tags' => [
					'label' => __( 'Page Tags', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'sync' => blocksy_sync_single_post_container([
						'prefix' => 'single_page'
					]),
				],
			] : [],

			blocksy_get_options('general/comments-single', [
				'prefix' => 'single_page',
			]),

		],
	],
];
