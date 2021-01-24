<?php
/**
 * Blog options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'blog_section_options' => [
		'type' => 'ct-options',
		'inner-options' => [
			blocksy_get_options('general/page-title', [
				'prefix' => 'blog',
				'is_home' => true,
				'enabled_label' => __('Blog Title', 'blocksy'),
				'enabled_default' => 'no'
			]),

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'blog',
				'title' => __('Blog', 'blocksy')
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'blog',
			]),

			blocksy_get_options('general/pagination', [
				'prefix' => 'blog',
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Functionality Options', 'blocksy' ),
				],
			],

			blocksy_get_options('general/cards-reveal-effect', [
				'prefix' => 'blog',
			]),
		],
	],
];
