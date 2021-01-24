<?php
/**
 * Contact Info widget
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
		'value' => __( 'Contact Info', 'blc' ),
		'disableRevertButton' => true,
	],

	'contact_text' => [
		'label' => __( 'Text', 'blc' ),
		'type' => 'textarea',
		'design' => 'inline',
		'disableRevertButton' => true,
	],

	'contact_information' => [
		'label' => false,
		'type' => 'ct-layers',
		'manageable' => true,
		'value' => [
			[
				'id' => 'address',
				'enabled' => true,
				'title' => __('Address:', 'blc'),
				'content' => 'Street Name, NY 38954',
			],

			[
				'id' => 'phone',
				'enabled' => true,
				'title' => __('Phone:', 'blc'),
				'content' => '578-393-4937',
				'link' => 'tel:578-393-4937',
			],

			[
				'id' => 'mobile',
				'enabled' => true,
				'title' => __('Mobile:', 'blc'),
				'content' => '578-393-4937',
				'link' => 'tel:578-393-4937',
			],

		],

		'settings' => [
			'address' => [
				'label' => __( 'Address', 'blc' ),
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Address:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => 'Street Name, NY 38954',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'design' => 'inline',
					]
				],

				'clone' => true
			],

			'phone' => [
				'label' => __( 'Phone', 'blc' ),
				'clone' => true,
				'options' => [

					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Phone:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => '578-393-4937',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => 'tel:578-393-4937',
						'design' => 'inline',
					]

				]
			],

			'mobile' => [
				'label' => __( 'Mobile', 'blc' ),
				'clone' => true,
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Mobile:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => '578-393-4937',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => 'tel:578-393-4937',
						'design' => 'inline',
					],

				]
			],

			'hours' => [
				'label' => __( 'Work Hours', 'blc' ),
				'clone' => true,
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Opening hours', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => '9AM - 5PM',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => '',
						'design' => 'inline',
					],

				]
			],

			'fax' => [
				'label' => __( 'Fax', 'blc' ),
				'clone' => true,
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Fax:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => '578-393-4937',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => 'tel:578-393-4937',
						'design' => 'inline',
					],

				]
			],

			'email' => [
				'label' => __( 'Email', 'blc' ),
				'clone' => true,
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Email:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => 'contact@yourwebsite.com',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => 'mailto:contact@yourwebsite.com',
						'design' => 'inline',
					],

				]
			],

			'website' => [
				'label' => __( 'Website', 'blc' ),
				'clone' => true,
				'options' => [
					'title' => [
						'type' => 'text',
						'label' => __('Title', 'blc'),
						'value' => __('Website:', 'blc'),
						'design' => 'inline',
					],

					'content' => [
						'type' => 'text',
						'label' => __('Content', 'blc'),
						'value' => 'creativethemes.com',
						'design' => 'inline',
					],

					'link' => [
						'type' => 'text',
						'label' => __('Link (optional)', 'blc'),
						'value' => 'https://creativethemes.com',
						'design' => 'inline',
					],
				]
			],
		],
	],

	'contacts_icons_size' => [
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

	'contacts_icon_shape' => [
		'label' => __( 'Icons Shape Type', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'rounded',
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
		'condition' => [ 'contacts_icon_shape' => '!simple' ],
		'options' => [

			'contacts_icon_fill_type' => [
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

	'contact_link_target' => [
		'type'  => 'ct-switch',
		'label' => __( 'Open link in new tab', 'blc' ),
		'value' => 'no',
		'disableRevertButton' => true,
	],
];
