<?php
/**
 * Options for socials widget.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$options = [

	'title' => [
		'type' => 'text',
		'label' => __( 'Title', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'value' => __( 'Social Icons', 'blc' ),
		'disableRevertButton' => true,
	],

	'socials' => [
		'type' => 'ct-layers',
		'label' => false,
		'manageable' => true,
		'desc' => sprintf(
			__( 'You can configure social URLs in %s.', 'blc' ),
			sprintf(
				'<a href="%s" target="_blank">%s</a>',
				admin_url('/customize.php?autofocus[section]=social_accounts'),
				__('Customizer', 'blc')
			)
		),
		'value' => [
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
		],

		'settings' => blc_call_fn([
			'fn' => 'blocksy_get_social_networks_list',
			'default' => []
		])
	],

	'social_icons_size' => [
		'label' => __( 'Icons Size', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'medium',
		'view' => 'text',
		'design' => 'block',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [
			'small' => __( 'Small', 'blc' ),
			'medium' => __( 'Medium', 'blc' ),
			'large' => __( 'Large', 'blc' ),
		],
	],

	'social_type' => [
		'label' => __( 'Icons Shape Type', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'simple',
		'view' => 'text',
		'design' => 'block',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [
			'simple' => __( 'None', 'blc' ),
			'rounded' => __( 'Rounded', 'blc' ),
			'square' => __( 'Square', 'blc' ),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'social_type' => '!simple' ],
		'options' => [

			'social_icons_fill' => [
				'label' => __( 'Shape Fill Type', 'blc' ),
				'type' => 'ct-radio',
				'value' => 'outline',
				'view' => 'text',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'solid' => __( 'Solid', 'blc' ),
					'outline' => __( 'Outline', 'blc' ),
				],
			],

		],
	],

];
