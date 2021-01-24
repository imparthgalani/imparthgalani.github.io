<?php
/**
 * Mailchimp widget
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
		'value' => __( 'Newsletter', 'blc' ),
		'disableRevertButton' => true,
	],

	'mailchimp_text' => [
		'label' => __( 'Message', 'blc' ),
		'type' => 'textarea',
		'value' => __( 'Enter your email address below to subscribe to our newsletter', 'blc' ),
		'design' => 'inline',
		'disableRevertButton' => true,
	],

	'mailchimp_list_id_source' => [
		'type' => 'ct-radio',
		'label' => __( 'List Source', 'blc' ),
		'value' => 'default',
		'view' => 'radio',
		'inline' => true,
		'design' => 'inline',
		'disableRevertButton' => true,
		'choices' => [
			'default' => __('Default', 'blc'),
			'custom' => __('Custom', 'blc'),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'mailchimp_list_id_source' => 'custom' ],
		'options' => [

			'mailchimp_list_id' => [
				'label' => __( 'List ID', 'blc' ),
				'type' => 'blocksy-mailchimp',
				'value' => '',
				'design' => 'inline',
				'disableRevertButton' => true,
			],

		],
	],

	'has_mailchimp_name' => [
		'type'  => 'ct-switch',
		'label' => __( 'Name Field', 'blc' ),
		'value' => 'no',
		'disableRevertButton' => true,
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'has_mailchimp_name' => 'yes' ],
		'options' => [

			'mailchimp_name_label' => [
				'type' => 'text',
				'label' => __( 'Name Label', 'blc' ),
				'design' => 'inline',
				'value' => __( 'Your name', 'blc' ),
				'disableRevertButton' => true,
			],

		],
	],

	'mailchimp_mail_label' => [
		'type' => 'text',
		'label' => __( 'Mail Label', 'blc' ),
		'design' => 'inline',
		'value' => __( 'Your email', 'blc' ),
		'disableRevertButton' => true,
	],

	'mailchimp_button_text' => [
		'type' => 'text',
		'label' => __( 'Button Label', 'blc' ),
		'design' => 'inline',
		'value' => __( 'Subscribe', 'blc' ),
		'disableRevertButton' => true,
	],

	'mailchimp_alignment' => [
		'type' => 'ct-radio',
		'label' => __( 'Content Alignment', 'blc' ),
		'value' => 'center',
		'view' => 'text',
		'design' => 'inline',
		'attr' => [ 'data-type' => 'alignment' ],
		'disableRevertButton' => true,
		'choices' => [
			'left' => '',
			'center' => '',
			'right' => '',
		],
	],

];
