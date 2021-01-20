<?php

namespace WTS_EAE\Controls\Group;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Group_Control_Icon extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'eae-icon';
	}

	protected function init_fields() {
		$controls = [];


		$controls['icon_type'] = [
			'type'        => Controls_Manager::CHOOSE,
			'label'       => __( 'Type', 'wts-eae' ),
			'default'     => 'icon',
			'options'     => [
				'icon'  => [
					'title' => __( 'Fontawesome Icon', 'wts-eae' ),
					'icon'  => 'fa fa-font-awesome',
				],
				'image' => [
					'title' => __( 'Custom Icons', 'wts-eae' ),
					'icon'  => 'fa fa-image',
				],
				'text'  => [
					'title' => __( 'Text', 'wts-eae' ),
					'icon'  => 'fa fa-font',
				],
			],
			'label_block' => false,
			'toggle'      => false,
			'condition'   => [
				'eae_icon!' => ''
			]
		];


//		$controls['icon'] = [
//			'label'     => __( 'Icon', 'wts-eae' ),
//			'type'      => Controls_Manager::ICON,
//			'default'   => 'fa fa-star',
//			'condition' => [
//				'eae_icon!' => '',
//				'icon_type'  => 'icon'
//			],
//		];

        $controls['icon_new'] = [
            'label' => __( 'Icon', 'wts-eae' ),
            'type' => Controls_Manager::ICONS,
            'fa4compatibility' => 'item_icon_icon',
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'fa-solid',
            ],
            'condition' => [
				'eae_icon!' => '',
				'icon_type'  => 'icon'
			],
        ];

		$controls['image'] = [
			'label'       => __( 'Custom Icon', 'wts-eae' ),
			'type'        => Controls_Manager::MEDIA,
			'dynamic' => [
                'active' => true,
            ],
			'label_block' => true,
			'condition'   => [
				'eae_icon!' => '',
				'icon_type'  => 'image'
			],
		];

		$controls['text'] = [
			'label'       => __( 'Text', 'wts-eae' ),
			'type'        => Controls_Manager::TEXT,
            'dynamic' => [
                'active' => true,
            ],
			'label_block' => false,
			'condition'   => [
				'eae_icon!' => '',
				'icon_type'  => 'text'
			],
		];

		$controls['view'] = [
			'label'     => __( 'View', 'wts-eae' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'global'  => __( 'Global', 'wts-eae'),
				'default' => __( 'Default', 'wts-eae' ),
				'stacked' => __( 'Stacked', 'wts-eae' ),
				'framed'  => __( 'Framed', 'wts-eae' ),
			],
			'default'   => 'global',
			'condition' => [
				'eae_icon!' => '',
				'icon_new!'      => ''
			],
		];

		$controls['shape'] = [
			'label'     => __( 'Shape', 'wts-eae' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'global'  => __( 'Global', 'wts-eae'),
				'circle' => __( 'Circle', 'wts-eae' ),
				'square' => __( 'Square', 'wts-eae' ),
			],
			'default'   => 'global',
			'condition' => [
				'view!'      => 'default',
				'eae_icon!' => '',
				'icon_new!'      => ''
			],
		];

		return $controls;
	}

	protected function get_default_options() {
		return [
			'popover' => [
				'starter_title' => _x( 'Icon', 'wts-eae' ),
				'starter_name'  => 'eae_icon',
			]
		];
	}
}
