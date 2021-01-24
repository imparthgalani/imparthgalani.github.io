<?php
/**
 * Search page
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'search_section_options' => [
		'type' => 'ct-options',
		'inner-options' => [
			blocksy_get_options('general/page-title', [
				'prefix' => 'search',
				'is_search' => true
			]),

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'search',
				'title' => __('Search Results', 'blocksy')
			]),

			[
				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'search'
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Functionality Options', 'blocksy' ),
				],

				'search_enable_live_results' => [
					'label' => __( 'Live results', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
				],
			],
		]
	]
];
