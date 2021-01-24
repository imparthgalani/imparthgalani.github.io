<?php
/**
 * Author page
 *
 * @copyright 2020-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'author_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			blocksy_get_options('general/page-title', [
				'prefix' => 'author',
				'is_author' => true
			]),

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'author',
				'title' => __('Author Page', 'blocksy')
			]),

			[
				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'author',
			]),
		],
	],
];
