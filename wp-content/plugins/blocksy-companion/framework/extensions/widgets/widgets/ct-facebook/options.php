<?php
/**
 * Facebook widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'title' => [
		'type' => 'text',
		'label' => __( 'Title', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'value' => __( 'Facebook', 'blc' ),
		'disableRevertButton' => true,
	],

	'facebook_page_url' => [
		'type' => 'text',
		'label' => __( 'Page URL', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'disableRevertButton' => true,
	],

	'facebook_faces' => [
		'type'  => 'ct-switch',
		'label' => __( 'Profile Photos', 'blc' ),
		'value' => 'yes',
	],

	'facebook_timeline' => [
		'type'  => 'ct-switch',
		'label' => __( 'Timeline', 'blc' ),
		'value' => 'no',
	],

	'facebook_cover' => [
		'type'  => 'ct-switch',
		'label' => __( 'Cover Photo', 'blc' ),
		'value' => 'no',
	],

	'facebook_small_header' => [
		'type'  => 'ct-switch',
		'label' => __( 'Small Header', 'blc' ),
		'value' => 'no',
	],

];
