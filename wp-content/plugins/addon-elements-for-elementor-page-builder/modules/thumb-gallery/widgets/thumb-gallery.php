<?php

namespace WTS_EAE\Modules\ThumbGallery\Widgets;

use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ThumbGallery extends EAE_Widget_Base {

	public function get_name() {
		return 'eae-thumbgallery';
	}

	public function get_title() {
		return __('EAE - Thumbnail Slider', 'wts-eae');
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
    }

    public function get_keywords()
    {
		return [
			'gallery',
			'ea thumb gallery',
            'slider',
            'thumbnail slider',
            'media carousel',
            'carousel',
        ];
    }

    protected function _register_controls()
	{
        $this->start_controls_section(
			'section_gallery',
			[
				'label' => __('Slides', 'wts-eae')
			]
        );
        
        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'gallery_repeater' );

        $repeater->start_controls_tab( 
            'slide_background',
            [ 
                'label' => __( 'Image', 'wts-eae' ) 
            ]
        );

        $repeater->add_control(
			'slide_image',
			[
				'label' => _x( 'Image', 'wts-eae' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'show_label' => false,
                'selectors' => [
                    '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}}' => 'background-image: url({{URL}})',
				],
				'render_type' => 'template'
			]
        );

        $repeater->add_control(
			'slide_thumb_image',
			[
				'label' => __( 'Custom Thumbnail Image', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'wts-eae' ),
				'label_off' => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
        );

        $repeater->add_control(
			'thumb_image',
			[
				'label' => _x( 'Image', 'wts-eae' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'show_label' => false,
				'selectors' => [
					'{{WRAPPER}} .eae-thumb-slide{{CURRENT_ITEM}}' => 'background-image: url({{URL}})',
                ],
                'conditions' => [
					'terms' => [
						[
							'name' => 'slide_thumb_image',
							'value' => 'yes',
						],
					],
				],
				'render_type' => 'template'
			]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 
            'content',
            [ 
                'label' => __( 'Content', 'wts-eae' ) 
            ]
        );

        $repeater->add_control(
			'slide_heading',
			[
				'label' => __( 'Heading & Description', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => __( 'Slide Heading', 'wts-eae' ),
				'label_block' => true,
			]
        );
        
        $repeater->add_control(
			'slide_description',
			[
				'label' => __( 'Description', 'wts-eae' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit Ut elit tellus.', 'wts-eae' ),
				'show_label' => false,
			]
        );
        
        $repeater->add_control(
			'slide_button_text',
			[
				'label' => __( 'Button Text', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => __( 'Click Here', 'wts-eae' ),
			]
        );
        
        $repeater->add_control(
			'slide_link',
			[
				'label' => __( 'Link', 'wts-eae' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __( 'https://your-link.com', 'wts-eae' ),
			]
        );
        
        $repeater->add_control(
			'slide_link_click',
			[
				'label' => __( 'Apply Link On', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slide' => __( 'Whole Slide', 'wts-eae' ),
					'button' => __( 'Button Only', 'wts-eae' ),
				],
				'default' => 'slide',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_link[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 
            'style',
            [ 
                'label' => __( 'Style', 'wts-eae' ) 
            ]
        );

        $repeater->add_control(
			'slide_custom_style',
			[
				'label' => __( 'Custom', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific slide.', 'wts-eae' ),
			]
        );

        $repeater->add_control(
			'slide_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-content' => '{{value}}',
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
        );

        $repeater->add_control(
			'slide_vertical_position',
			[
				'label' => __( 'Vertical Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'wts-eae' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'wts-eae' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'wts-eae' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
        );

        $repeater->add_control(
			'slide_text_align',
			[
				'label' => __( 'Text Align', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
        );

        // $repeater->add_control(
		// 	'slide_content_color',
		// 	[
		// 		'label' => __( 'Content Color', 'wts-eae' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-heading' => 'color: {{VALUE}}',
		// 			'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-text' => 'color: {{VALUE}}',
        //             '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-button .eae-slide-btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
		// 		],
		// 		'conditions' => [
		// 			'terms' => [
		// 				[
		// 					'name' => 'slide_custom_style',
		// 					'value' => 'yes',
		// 				],
		// 			],
		// 		],
		// 	]
		// );

		$repeater->add_control(
			'slide_content_bgcolor',
			[
				'label' => __( 'Content Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-content' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator' => 'after',
			]
		);
		
		$repeater->add_control(
			'repeater_heading_color',
			[
				'label' => __( 'Heading Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-heading' => 'color: {{VALUE}}',

				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
        );
		
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Heading Typography', 'wts-eae' ),
				'name' => 'repeater_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-heading',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'repeater_description_color',
			[
				'label' => __( 'Description Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-text' => 'color: {{VALUE}}',

				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator' => 'before',
			]
        );
		
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Description Typography', 'wts-eae' ),
				'name' => 'repeater_description_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-text',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator' => 'after',
			]
		);
		
		$repeater->add_control(
			'repeater_button_color',
			[
				'label'     => __('Button Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-button .eae-slide-btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator' => 'before',
			]
        );

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Button Typography', 'wts-eae' ),
				'name'     => 'repeater_button_typography',
				'global'    =>  [
					'default'   => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-inner .eae-slide-button .eae-slide-btn',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
        );

        $repeater->add_control(
			'slide_overlay',
			[
				'label' => __( 'Overlay', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator' => 'before',
			]
        );

        $repeater->add_control(
			'slide_overlay_color',
			[
				'label' => __( 'Overlay Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
                            'name' => 'slide_custom_style',
                            'value' => 'yes',
                        ], 
						[
							'name' => 'slide_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-background-overlay' => 'background-color: {{VALUE}}',
				],
			]
        );

        $repeater->add_control(
			'slide_overlay_blend_mode',
			[
				'label' => __( 'Blend Mode', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'wts-eae' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
                            'name' => 'slide_custom_style',
                            'value' => 'yes',
                        ], 
						[
							'name' => 'slide_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-background-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

        $repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'repeater_text_shadow',
				'selector' => '{{WRAPPER}} .eae-swiper-slide{{CURRENT_ITEM}} .eae-slide-content',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);


        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
			'slides',
            [
                'label' => __( 'Slides', 'wts-eae' ),
                'type' => Controls_Manager::REPEATER,
                'show_label' => true,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        // 'slide_image' => '',
                        'slide_heading' => __( 'Slide 1 Heading', 'wts-eae' ),
                        'slide_description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor.', 'wts-eae' ),
						'slide_button_text' => __( 'Click Here', 'wts-eae' ),
                    ],
                    [
                        // 'slide_image' => '',
                        'slide_heading' => __( 'Slide 2 Heading', 'wts-eae' ),
                        'slide_description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'wts-eae' ),
						'slide_button_text' => __( 'Click Here', 'wts-eae' ),
                    ],
                    [
                        // 'slide_image' => '',
                        'slide_heading' => __( 'Slide 3 Heading', 'wts-eae' ),
                        'slide_description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'wts-eae' ),
						'slide_button_text' => __( 'Click Here', 'wts-eae' ),
                    ],
                ],
                'title_field' => '{{{ slide_heading }}}',
            ]
        );

        $this->add_responsive_control(
			'slide_height',
			[
				'label' => __( 'Height', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 400,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors' => [
                    '{{WRAPPER}} .eae-swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
        );
        
        $this->add_control(
			'slide_background_size',
			[
				'label' => _x( 'Image Fit', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => _x( 'Cover', 'Background Control', 'wts-eae' ),
					'contain' => _x( 'Contain', 'Background Control', 'wts-eae' ),
					'auto' => _x( 'Auto', 'Background Control', 'wts-eae' ),
				],
				'selectors' => [
					'{{WRAPPER}}  .eae-swiper-outer-wrapper .eae-swiper-slide' => 'background-size: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'slide_background_position',
			[
				'label' => _x( 'Image Position', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'' => __( 'Default', 'wts-eae' ),
					'center center' => __( 'Center Center', 'wts-eae' ),
					'center left' => __( 'Center Left', 'wts-eae' ),
					'center right' => __( 'Center Right', 'wts-eae' ),
					'top center' => __( 'Top Center', 'wts-eae' ),
					'top left' => __( 'Top Left', 'wts-eae' ),
					'top right' => __( 'Top Right', 'wts-eae' ),
					'bottom center' => __( 'Bottom Center', 'wts-eae' ),
					'bottom left' => __( 'Bottom Left', 'wts-eae' ),
					'bottom right' => __( 'Bottom Right', 'wts-eae' ),
				],
				'selectors' => [
					'{{WRAPPER}}  .eae-swiper-outer-wrapper .eae-swiper-slide' => 'background-position: {{VALUE}}',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'eae_slide_image',
                'default' => 'full',
                'exclude' => ['custom'],
				'separator' => 'none',
			]
        );
        

        $this->add_control(
			'slides_background_overlay',
			[
				'label' => __( 'Slide Overlay', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
        );
        
        $this->add_control(
			'slides_background_overlay_color',
			[
				'label' => __( 'Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'conditions' => [
					'terms' => [
						[
							'name' => 'slides_background_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-background-overlay' => 'background-color: {{VALUE}}',
				],
			]
        );
        
        $this->add_control(
			'background_overlay_blend_mode',
			[
				'label' => __( 'Blend Mode', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'wts-eae' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slides_background_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-background-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_thumb_setting',
            [
                'label' => __( 'Thumbnails', 'wts-eae' ),
                'type' => Controls_Manager::SECTION,
            ]
		);
		
		$this->add_responsive_control(
			'thumb_slides_per_view',
			[
				'label' => __( 'Thumbs Per View', 'wts-eae' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'tablet_default'    =>  3,
				'mobile_default'    =>  2,
			]
        );

        $this->add_responsive_control(
			'thumb_space_between',
			[
				'label' => __( 'Space Between Thumbs', 'wts-eae' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 10,
				'tablet_default'    =>  10,
                'mobile_default'    =>  5,
                // 'selectors' => [
                //     '{{WRAPPER}} .eae-swiper-container' => 'margin-bottom: {{VALUE}}px;',
                // ],
                // 'render_type' => 'template'
			]
        );

        $this->add_control(
			'thumb_navigation',
			[
                'label' => __('Arrows', 'wts-eae'),
				'type'  => Controls_Manager::SWITCHER,
				'default'  => '',
			]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
                'label' => __( 'Size', 'wts-eae' ),
                'name' => 'eae_thumb_image', 
                'default' => 'full',
                'exclude' => ['custom'],
                'separator' => 'before',
			]
        );

        $this->add_responsive_control(
            'thumb_ratio',
            [
                'label' => __('Ratio', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.42,
                ],
                'tablet_default' => [
                    'size' => '',
                ],
                'mobile_default' => [
                    'size' => 0.5,
                ],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 2,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-thumb-slide .eae-fit-aspect-ratio' => 'padding-bottom: calc( {{SIZE}} * 100% );',
                ],
            ]
        );
        
        // $this->add_control(
        //     'thumb_image_ratio',
        //     [
        //         'label' => __('Ratio', 'wts-eae'),
        //         'type' => Controls_Manager::SELECT,
        //         'default' => '219',
        //         'options' => [
		// 			'169' => '16:9',
		// 			'219' => '21:9',
		// 			'43' => '4:3',
		// 			'11' => '1:1',
        //         ],
        //         'prefix_class' => 'eae-aspect-ratio-',
        //         'separator' => 'after',
        //     ]
        // );

        $this->add_control(
			'thumb_horizontal_align',
			[
				'label' => __( 'Position', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'top' => __( 'Top', 'wts-eae' ),
					'bottom' => __( 'Bottom', 'wts-eae' ), 
				],
                'default' => 'bottom',
			]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_setting',
            [
                'label' => __( 'Slider Options', 'wts-eae' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
			'slider_effect',
			[
				'label' => __( 'Effect', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'wts-eae' ),
					'fade' => __( 'Fade', 'wts-eae' ),
                ],
                'separator' => 'after'
			]
        );

        $this->add_control(
            'slider_speed',
            [
                'label' => __('Speed', 'wts-eae'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'description' => __('Duration of transition between slides (in ms)', 'wts-eae'),
                'range' => [
                    'px' => [
                        'min' => 1000,
                        'max' => 10000,
                        'step' => 500
                    ]
                ],
            ]
        );

        $this->add_control(
			'slider_autoplay',
			[
				'label' => __( 'Autoplay', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on'=>__('Yes', 'wts-eae'),
                'label_off' =>__('No' , 'wts-eae'),
			]
        );

        $this->add_control(
            'slider_autoplay_duration',
            [
                'label' => __('Duration', 'wts-eae'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'description' => __('Delay between transitions (in ms)', 'wts-eae'),
                'range' => [
                    'px' =>[
                        'min' => 300,
                        'max' => 3000,
                        'step' => 300,
                    ]
                ],
                'condition' => [
                    'slider_autoplay' => 'yes',
                ]
            ]
        ); 

        $this->add_control(
            'slider_pause_on_interaction',
            [
                'label' =>  __('Pause on Interaction', 'wts-eae'),
                'type'  =>  Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'=>__('Yes', 'wts-eae'),
                'label_off' =>__('No' , 'wts-eae'),
                'condition' => [
                    'slider_autoplay' => 'yes',
                ],

            ]
		);
		
		$this->add_control(
			'slider_direction',
			[
				'label' => __( 'Direction', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ltr',
				'options' => [
					'ltr' => __( 'Left', 'wts-eae' ),
					'rtl' => __( 'Right', 'wts-eae' ),
				],
			]
		);
        
        
        $this->add_responsive_control(
			'slider_space_between',
			[
				'label' => __('Space Between Slides', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' =>[
					'size' => 10,
				],
				'tablet_default' =>[
					'size' => 15,
				],
				'mobile_default' =>[
					'size' => 10,
				],
				'range' => [
					'px'=>[
						'min'=> 0,
						'max'=> 50,
						'step'=> 5,
					]
                ],        
			]
        );
        
        $this->add_control(
            'slider_loop',
            [
                'label' => __('Loop', 'wts-eae'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on'=>__('Yes', 'wts-eae'),
                'label_off' =>__('No' , 'wts-eae'),
                'separator' => 'after'
            ]
        );

        $this->add_control(
			'slider_navigation',
			[
                'label' => __('Arrows', 'wts-eae'),
				'type'  => Controls_Manager::SWITCHER,
				'default'  => 'yes',
				'label_on' => __('Yes' , 'wts-eae'),
                'label_off' => __('No' , 'wts-eae'),
                'return_value' => 'yes',
			]
		);
		
		$this->add_control(
            'navigation_icon_left',
            [
                'label' => __( 'Icon Prev', 'wts-eae' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fa fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'condition'=> [
                    'slider_navigation' => 'yes'
                ],
            ]
		);
		
		$this->add_control(
            'navigation_icon_right',
            [
                'label' => __( 'Icon Next', 'wts-eae' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fa fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'condition'=> [
                    'slider_navigation' => 'yes'
                ],
            ]
        );
        
        $this -> add_control(
			'slider_pagination',
			[
				'label' => __('Pagination' , 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' =>
					[
						''        => __('None', 'wts-eae'),
						'bullets' => __( 'Bullets' , 'wts-eae'),
						'fraction' =>__( 'Fraction' , 'wts-eae'),
						'progressbar' =>__('Progress' , 'wts-eae'),
					],
				'default'=>'',
			]
        );

        $this->add_control(
            'slider_clickable',
            [
                'label' =>__('Clickable' , 'wts-eae'),
                'type' =>Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on'=>__('Yes', 'wts-eae'),
                'label_off' =>__('No' , 'wts-eae'),
                'condition'=> [
                    'slider_pagination' => 'bullets'
                ],
            ]
        );

        $this->add_control(
            'slider_keyboard',
            [
                'label' => __('Keyboard Control' , 'wts-eae'),
                'type' =>Controls_Manager::SWITCHER,
                'default'=> 'yes',
                'label_on'=>__('Yes', 'wts-eae'),
                'label_off' =>__('No' , 'wts-eae'),
                'return_value'=>'yes',
            ]
        );
            
        $this->end_controls_section();

        $this->start_controls_section(
			'slides_style_section',
			[
				'label' => __('Slides', 'wts-eae'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between_thumbs',
			[
				'label' => __('Space Between', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'default' =>[
					'size' => 10,
				],
				'tablet_default' =>[
					'size' => 10,
				],
				'mobile_default' =>[
					'size' => 5,
				],
				'range' => [
					'px'=>[
						'min'=> 0,
						'max'=> 50,
						'step'=> 5,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eae-thumb-horizontal-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eae-thumb-horizontal-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
			]
		);

        $this->add_control(
			'slider_bgcolor',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-swiper-slide' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'slide_border',
				'fields_options' => [
					'border' => [
						'default' => '',
					],
					'width'  => [
						'default' => [
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
							'unit'   => 'px'
						],
					],
					'color'  => [
						'default' => '#0c0c0c',
					]
				],
				'selector'  => '{{WRAPPER}} .eae-swiper-container',
			]
        );

        $this->add_control(
			'slider_border_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-swiper-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'slides_padding',
			[
				'label' => __( 'Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-slide-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                //'separator' => 'before',
			]
		);
		
		$this->add_control(
			'slides_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'eae--hr-position-',
			]
		);
		
		$this->add_control(
			'slides_vertical_position',
			[
				'label' => __( 'Vertical Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'wts-eae' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'wts-eae' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'wts-eae' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'eae--vr-position-',
			]
		);
		
		$this->add_control(
			'slides_text_align',
			[
				'label' => __( 'Text Align', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .eae-slide-inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .eae-slide-content',
			]
        ); 

        $this-> add_responsive_control(
            'slide_content_width',
            [
                'label' => __('Content Width', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                ],
                'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '66',
					'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'selectors' => [
					'{{WRAPPER}} .eae-slide-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
		);
		
		$this->add_control(
			'content_bgcolor',
			[
				'label' => __( 'Content Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-content' => 'background-color: {{VALUE}}',
				],
			]
        );

        $this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'slides_style_title',
			[
				'label' => __( 'Heading', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-heading' => 'color: {{VALUE}}',

				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-slide-heading',
			]
        );
        
        $this->add_control(
            'title_spacing',
            [
                'label' => __('Spacing', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-slide-inner .eae-slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'slides_style_description',
			[
				'label' => __( 'Description', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-text' => 'color: {{VALUE}}',

				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-slide-text',
			]
        );

        $this->add_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'wts-eae' ),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-slide-inner .eae-slide-text:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'slides_style_button',
			[
				'label' => __( 'Button', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'global'    =>  [
					'default'   => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-slide-button .eae-slide-btn',
			]
        );
        
        $this->start_controls_tabs('slides_button_style_tabs');

        $this->start_controls_tab(
			'tab_button_normal_style',
			[
				'label' => __('Normal', 'wts-eae'),
			]
        );
        
        $this->add_control(
			'button_color',
			[
				'label'     => __('Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn' => 'color: {{VALUE}};',
				],
			]
        );

        $this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
			'tab_button_hover_style',
			[
				'label' => __('Hover', 'wts-eae'),
			]
        );
        
        $this->add_control(
			'button_hover_color',
			[
				'label'     => __('Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn:hover' => 'color: {{VALUE}};',
				],
			]
        );

        $this->add_control(
			'button_border_hover_color',
			[
				'label'     => __('Border Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
        );
        
        $this->add_control(
			'button_bg_hover_color',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn:hover' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'button_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'    => 2,
							'right'  => 2,
							'bottom' => 2,
							'left'   => 2,
							'unit'   => 'px'
						],
					],
				],
				'selector'  => '{{WRAPPER}} .eae-slide-button .eae-slide-btn',
				'separator' => 'before',
			]
        );
        
        $this->add_control(
			'button_border_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_responsive_control(
			'button_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-slide-button .eae-slide-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'navigation_style_section',
			[
				'label' => __( 'Slider Navigation', 'wts-eae' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
					'terms' => [
                        [
                            'name' => 'slider_pagination',
                            'operator' => '!=',
                            'value' => '',
                        ],
						[
                            'name' => 'slider_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
			]
        );

        $this->add_control(
			'arrows_heading',
			[
				'label' => __( 'Arrows', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
			]
        );
        
        $this->add_control(
			'arrows_color',
			[
				'label' => __( 'Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-slider-nav-button' => 'color: {{VALUE}}',
                ],
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
			]
        );
        
        $this->add_control(
			'arrows_size',
			[
				'label' => __( 'Size', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-slider-nav-button' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
                'separator' => 'after',
			]
        );
        
        $this->add_control(
			'pagination_bullets_heading',
			[
				'label' => __( 'Bullets', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_pagination',
                            'operator' => '==',
							'value' => 'bullets',
						],
					],
                ],
                //'separator' => 'before',
			]
        );

        $this->add_control(
			'pagination_fraction_heading',
			[
				'label' => __( 'Fraction', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_pagination',
                            'operator' => '==',
							'value' => 'fraction',
						],
					],
                ],
                //'separator' => 'before',
			]
        );

        $this->add_control(
			'pagination_progressbar_heading',
			[
				'label' => __( 'ProgressBar', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
					'terms' => [
						[
                            'name' => 'slider_pagination',
                            'operator' => '==',
							'value' => 'progressbar',
						],
					],
                ],
                //'separator' => 'before',
			]
        );

        $this->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
					'slider_pagination!' => '',
                ],
			]
        );
        
        $this->add_control(
			'pagination_active_color',
			[
				'label' => __( 'Active Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-current' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
					'slider_pagination!' => '',
                ],
			]
        );
        
        $this->add_control(
			'pagination_size',
			[
				'label' => __( 'Size', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 25,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}', //.swiper-container-horizontal 		
				],
				'condition' => [
					'slider_pagination!' => '',
                ],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'thumbnails_style_section',
			[
				'label' => __( 'Thumbnails', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'thumbnail_border',
				'fields_options' => [
					'border' => [
						'default' => '',
					],
					'width'  => [
						'default' => [
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
							'unit'   => 'px'
						],
					],
					'color'  => [
						'default' => '#0c0c0c',
					]
				],
				'selector'  => '{{WRAPPER}} .eae-thumb-slide',
			]
        );

        $this->add_control(
			'thumbnail_border_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-thumb-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-thumb-slide:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
			'thumb_arrows_heading',
			[
				'label' => __( 'Arrows', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
					'terms' => [
						[
                            'name' => 'thumb_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
                ],
                'separator' => 'before',
			]
        );

        $this->add_control(
			'thumb_arrows_color',
			[
				'label' => __( 'Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-thumb-button' => 'color: {{VALUE}}',
                ],
                'conditions' => [
					'terms' => [
						[
                            'name' => 'thumb_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
			]
        );
        
        $this->add_control(
			'thumb_arrows_size',
			[
				'label' => __( 'Size', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-thumb-button' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'conditions' => [
					'terms' => [
						[
                            'name' => 'thumb_navigation', 
                            'operator' => '!=',
							'value' => '',
                        ],
					],
				],
			]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        $slides = $settings['slides'];

        $slides_per_view['desktop'] = $settings['thumb_slides_per_view'] != "" ? $settings['thumb_slides_per_view'] : 1;
        $slides_per_view['tablet']  = $settings['thumb_slides_per_view_tablet'] != "" ? $settings['thumb_slides_per_view_tablet'] : 1;
        $slides_per_view['mobile']  = $settings['thumb_slides_per_view_mobile'] != "" ? $settings['thumb_slides_per_view_mobile'] : 1;

        $space_between['desktop'] = $settings['thumb_space_between'] != "" ? $settings['thumb_space_between'] : 5;
        $space_between['tablet']  = $settings['thumb_space_between_tablet'] != "" ? $settings['thumb_space_between_tablet'] : 15;
        $space_between['mobile']  = $settings['thumb_space_between_mobile'] != "" ? $settings['thumb_space_between_mobile'] : 10;

        //$thumb_navigation = $settings['thumb_navigation'];

        $slider_data = $this->get_swiper_settings($settings);
        
        //echo '<pre>'; print_r($settings); echo '</pre>';
        
        $this->add_render_attribute('outer-wrapper', 'class', ['eae-swiper-outer-wrapper', 'eae-swiper']);

        $this->add_render_attribute('outer-wrapper', 'data-swiper-settings', json_encode($slider_data));

        if (!empty($slides_per_view)) {
            $this->add_render_attribute('outer-wrapper', 'data-slides-per-view', json_encode($slides_per_view, JSON_NUMERIC_CHECK));
        }

        if (!empty($space_between)) {
            $this->add_render_attribute('outer-wrapper', 'data-space', json_encode($space_between, JSON_NUMERIC_CHECK));
        }

        // if ($thumb_navigation == 'yes') {
        //     $this->add_render_attribute('outer-wrapper', 'data-navigation', $thumb_navigation);
        // }
        
        ?>

        <div <?php echo $this->get_render_attribute_string('outer-wrapper');?>>
            <?php

                if($settings['thumb_horizontal_align'] == 'top'){
                    $this->render_thumbslider($slides, $settings);
                }

                $this->render_slider($slides, $settings);

                if($settings['thumb_horizontal_align'] == 'bottom'){
                    $this->render_thumbslider($slides, $settings);
                }
                
            ?>
        </div> 
        
        <?php
          
    }

    function render_slider($slides, $settings){

        $this->add_render_attribute('slider-container', 'class', ['eae-swiper-container', 'swiper-container']);

        $this->add_render_attribute('slider-wrapper', 'class', ['eae-swiper-wrapper', 'swiper-wrapper', 'slider_vertical_wrapper']);

        $slider_data = $this->get_swiper_settings($settings);

        ?>
           
            <div <?php echo $this->get_render_attribute_string('slider-container');?>>
                <div <?php echo $this->get_render_attribute_string('slider-wrapper');?>>
                    
                    <?php   
                    foreach($slides as $slide){
                
                        $id	            = $slide['_id'];
                        $heading        = $slide['slide_heading'];
                        $description    = $slide['slide_description'];
                        $button_text    = $slide['slide_button_text'];
                        $link           = $slide['slide_link']['url'];

                        $slide_element = 'div';

                        $this->set_render_attribute('swiper-repeater-item', 'class', ['elementor-repeater-item-'.$id, 'eae-swiper-slide', 'swiper-slide']);
                        $image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['slide_image']['id'], 'eae_slide_image', $settings );
                       
                        if(!empty($slide['slide_image']['id'])){
                            $this->set_render_attribute('swiper-repeater-item', 'style', 'background-image : url('. $image_url . ');' );
                        }else{
                            $this->remove_render_attribute('swiper-repeater-item', 'style');
                        }
                        
                        $this->set_render_attribute('slide-inner', 'class', 'eae-slide-inner');
                        if($link != '' && $slide['slide_link_click'] === 'slide'){
                            $slide_element = 'a';
                            $this->set_render_attribute('slide-inner', 'href', $link);
                        }
                    ?>


                    <div <?php echo $this->get_render_attribute_string('swiper-repeater-item'); ?>>
                   
                        <?php if( $settings['slides_background_overlay'] == 'yes' || $slide['slide_overlay'] == 'yes'){ ?> 
                            <div class="eae-background-overlay"></div>
                        <?php } ?>
                        
                        <<?php echo $slide_element; ?>  <?php echo $this->get_render_attribute_string('slide-inner'); ?>>
							<?php if(!empty($heading || $description || $button_text)){ ?>
								<div class="eae-slide-content">
									<?php if(!empty($heading)){?>
										<div class="eae-slide-heading"><?php echo $heading; ?></div>
									<?php } ?>

									<?php if(!empty($description)){?>	
									<div class="eae-slide-text"><?php echo $description; ?></div>
									<?php } ?>

									<?php if(!empty($button_text)){?>
									<div class="eae-slide-button">
										<?php if($link != '' && $slide['slide_link_click'] == 'button'){ ?>
											<a class="eae-slide-btn" href="<?php echo $link ?>"><?php echo $button_text; ?></a> 
										<?php } else{ ?>
											<span class="eae-slide-btn"><?php echo $button_text; ?></span> 
										<?php } ?>
									</div>
									<?php } ?>
								</div>
							<?php } ?>
                        </<?php echo $slide_element; ?>> 
                                  
                    </div>
                   
                    <?php } ?> 
                </div>
               
                <?php if(!empty($slider_data['pagination'])){ ?>
					<div class = "eae-swiper-pagination swiper-pagination"></div>
				<?php } ?>
                
				<?php if(!empty($slider_data['navigation'])){ ?>
	
                        <div class = " eae-swiper-button eae-slider-nav-button  eae-swiper-button-prev">
							<?php Icons_Manager::render_icon($settings['navigation_icon_left']) ?>
						</div>	
                           
                        <div class = "eae-swiper-button eae-slider-nav-button eae-swiper-button-next">
							<?php Icons_Manager::render_icon($settings['navigation_icon_right']) ?>
						</div>	
                                   
				<?php } ?>
                
            </div>
            
        <?php
        
    }

    function render_thumbslider($slides, $settings){

        $this->add_render_attribute('thumb-container', 'class', ['eae-thumb-container', 'swiper-container', 'eae-gallery-thumbs']);
        $this->add_render_attribute('thumb-wrapper', 'class', ['eae-thumb-wrapper', 'swiper-wrapper']);

        $thumb_navigation = $settings['thumb_navigation'];

        if($settings['thumb_horizontal_align'] == 'top'){
            $this->add_render_attribute('thumb-container', 'class', ['eae-thumb-horizontal-top']);
        }
        if($settings['thumb_horizontal_align'] == 'bottom'){
            $this->add_render_attribute('thumb-container', 'class', ['eae-thumb-horizontal-bottom']);
        }
        
        ?>

            <div <?php echo $this->get_render_attribute_string('thumb-container');?>>
                <div <?php echo $this->get_render_attribute_string('thumb-wrapper');?>>
                    <?php 
                    foreach($slides as $slide){ 
						   
						$thumb_image_id   = $slide['thumb_image']['id'];
							
                        if($slide['slide_thumb_image'] === ''){
                            $thumb_image_id = $slide['slide_image']['id'];
                        }

                        $id = $slide['_id'];
                        $this->set_render_attribute('thumb-repeater-item', 'class', ['elementor-repeater-item-'.$id, 'eae-thumb-slide', 'swiper-slide']);
                        
                        if(!empty($thumb_image_id)){
                            $thumb_image_url = Group_Control_Image_Size::get_attachment_image_src( $thumb_image_id, 'eae_thumb_image', $settings );
                        }else{
                            $thumb_image_url = Utils::get_placeholder_image_src();
                        }      

                        $this->set_render_attribute('thumb-repeater-item', 'style', 'background-image : url('. $thumb_image_url . ');' );
           
                    ?>
                       
                        <div <?php echo $this->get_render_attribute_string('thumb-repeater-item'); ?>>
                                <div class='eae-fit-aspect-ratio'></div>
                        </div>
                    <?php } ?> 
                </div>

                <?php if($thumb_navigation == 'yes'){ ?>
                        <div class = " eae-thumb-button eae-swiper-button  eae-swiper-button-prev">
                            <i class="eicon-chevron-left"></i>
                        </div>

                        <div class = "eae-thumb-button eae-swiper-button eae-swiper-button-next">
                            <i class="eicon-chevron-right"></i>
                        </div>
                <?php } ?>
                
            </div>

        <?php
    }

    function get_swiper_settings($settings){

        $slider_data['effect'] = $settings['slider_effect'];

        $slider_data['speed'] 	 = 	$settings['slider_speed'];

        if($settings['slider_autoplay'] === 'yes'){
			$slider_data['autoplay']['duration']  =  $settings['slider_autoplay_duration'];

			if($settings['slider_direction'] === 'rtl'){
				$slider_data['autoplay']['reverseDirection'] = true;
			}
			if($settings['slider_direction'] === 'ltr'){
				$slider_data['autoplay']['reverseDirection'] = false;
			}
			
			$slider_data['autoplay']['slider_direction'] = $settings['slider_direction'];
            
            $settings['slider_pause_on_interaction'] == 'yes' ? $slider_data['autoplay']['disableOnInteraction'] = true : $slider_data['autoplay']['disableOnInteraction'] = false;
        }else{
            $swiper_data['autoplay'] = false;
        }

        $slider_data['spaceBetween']['desktop'] = $settings['slider_space_between']['size'];
        $slider_data['spaceBetween']['tablet']  = $settings['slider_space_between_tablet']['size'];
        $slider_data['spaceBetween']['mobile']  = $settings['slider_space_between_mobile']['size'];

        if(!empty($settings['slider_loop'])){
            $slider_data['loop']     =  $settings['slider_loop'];
        } 

        if(!empty($settings['slider_navigation'])){
            $slider_data['navigation']  =  $settings['slider_navigation'];
        }  

        if(!empty($settings['slider_pagination'])){
            $slider_data['pagination']  =  $settings['slider_pagination'];
        }
      
        $settings['slider_clickable'] == 'yes' ? $slider_data['clickable'] = true : $slider_data['clickable'] = false;

        $settings['slider_keyboard'] == 'yes' ? $slider_data['keyboard'] = true : $slider_data['keyboard'] = false;     
    
        return $slider_data;
    }
}