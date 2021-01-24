<?php
/**
 * Advertisement widget
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
		'value' => __( 'Advertisement', 'blc' ),
		'disableRevertButton' => true,
	],

	'ad_source' => [
		'label' => __( 'Source', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'code',
		'view' => 'radio',
		'design' => 'inline',
		'inline' => true,
		'disableRevertButton' => true,
		'choices' => [
			'code' => __( 'Code', 'blc' ),
			'upload' => __( 'Image', 'blc' ),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'ad_source' => 'code' ],
		'options' => [

			'ad_code' => [
				'label' => __( 'Ad Code', 'blc' ),
				'type' => 'textarea',
				'value' => '',
				'design' => 'inline',
				'disableRevertButton' => true,
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'ad_source' => 'upload' ],
		'options' => [

			'ad_image' => [
				'label' => __('Upload Image', 'blc'),
				'type' => 'ct-image-uploader',
				'design' => 'inline',
				'value' => [ 'attachment_id' => null ],
				'emptyLabel' => __('Select Image', 'blc'),
				'filledLabel' => __('Change Image', 'blc'),
			],

			'ad_link' => [
				'type' => 'text',
				'label' => __( 'Ad URL', 'blc' ),
				'design' => 'inline',
				'value' => 'https://creativethemes.com',
				'disableRevertButton' => true,
			],

			'ad_link_target' => [
				'type'  => 'ct-switch',
				'label' => __( 'Open link in new tab', 'blc' ),
				'value' => 'yes',
				'disableRevertButton' => true,
			],

		],
	],

];
