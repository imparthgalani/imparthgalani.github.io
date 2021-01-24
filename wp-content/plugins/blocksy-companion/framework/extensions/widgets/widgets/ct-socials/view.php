<?php
/**
 * Socials Widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

// Widget title.
$title = blocksy_default_akg( 'title', $atts, __('Social Icons', 'blc') );

echo wp_kses_post($before_widget . $before_title . $title . $after_title);

$size = blocksy_default_akg('social_icons_size', $atts, 'medium');
$type = blocksy_default_akg('social_type', $atts, 'simple');
$fill = blocksy_default_akg('social_icons_fill', $atts, 'outline');

/**
 * blocksy_social_icons() function is already properly escaped.
 * Escaping it again here would cause SVG icons to not be outputed
 */
echo blc_call_fn(
	['fn' => 'blocksy_social_icons'],
	blocksy_default_akg(
		'socials',
		$atts,
		[
			[
				'id' => 'facebook',
				'enabled' => true,
			],

			[
				'id' => 'twitter',
				'enabled' => true,
			],

			[
				'id' => 'instagram',
				'enabled' => true,
			],
		]
	),
	[
		'size' => $size,
		'fill' => $fill,
		'type' => $type
	]
);

echo wp_kses_post($after_widget);

