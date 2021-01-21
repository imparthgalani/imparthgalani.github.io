<?php

namespace WTS_EAE\Modules\TestimonialSlider\Widgets;

use Elementor\Controls_Manager;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} //Exit if accessed directly

class TestimonialSlider extends EAE_Widget_Base{

	public function get_name()
	{
		return 'wts-testimonial-slider';
	}

	public function get_title()
	{
		return __('EAE - Testimonial Slider', 'wts-eae');
	}

	public function get_icon()
	{
		return 'fa fa-star';
	}

	public function get_categories()
	{
		return ['wts-eae'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_general',
			[
				'label' => __('General', 'wts-eae')
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => __( 'Grid', 'wts-eae' ),
					'carousel' => __( 'Carousel', 'wts-eae' ),
				],
				'default' => 'grid',
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' =>  __('Row Gap' , 'wts-eae'),
				'type'  =>  Controls_Manager::SLIDER,
				'range' =>  [
					'px'  =>  [
						'min' =>  0,
						'max' =>  200,
					]
				],
				'condition'   => [
					'layout' => 'carousel'
				],
				'selectors'  =>  [
					'{{WRAPPER}} .eae-swiper-wrapper' => 'margin-bottom:{{SIZE}}{{UNIT}};'
				],

			]
		);

		$this->add_control(
			'skin',
			[
				'label' => __( 'Skin', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'skin-1' => __( 'Skin 1', 'wts-eae' ),
					'skin-2' => __( 'Skin 2', 'wts-eae' ),
					'skin-3' => __( 'Skin 3', 'wts-eae' ),
					'skin-4' => __( 'Skin 4', 'wts-eae' ),
				],
				'default' => 'skin-1',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_testimonials',
			[
				'label' => __('Testimonials', 'wts-eae')
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'person_image',
			[
				'label' => __('Image', 'wts-eae'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => [ 'custom' ],
			]
		);

		$repeater->add_control(
			'person_name',
			[
				'label' => __('Name', 'wts-eae'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$repeater->add_control(
			'company_name',
			[
				'label' => __('Company Name', 'wts-eae'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);


		$repeater->add_control(
			'message',
			[
				'label' => __('Message', 'wts-eae'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);
		$repeater->add_control(
			'rating',
			[
				'label' => __('Rating', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 0,
				'max' => 5,
				'step' => 1,
			]
		);
		$this->add_control(
			'testimonials',
			[
				'label' => __( 'Testimonials', 'wts-eae' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'person_image' =>'',
						'person_name' => __( 'John Doe', 'wts-eae' ),
						'company_name'  =>  __('XYZ' , 'wts-eae'),
						'message'   =>  __('Add message content. Click edit button to change the message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus' , 'wts-eae'),
						'rating' =>  '4.5'
					],
					[
						'person_image' =>'',
						'person_name' => __( 'Jane Doe', 'wts-eae' ),
						'company_name'  =>  __('ABC' , 'wts-eae'),
						'message'   =>  __('Add message content. Click edit button to change the message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus' , 'wts-eae'),
						'rating' =>  '2'
					],
					[
						'person_image' =>'',
						'person_name' => __( 'M Max', 'wts-eae' ),
						'company_name'  =>  __('QWE' , 'wts-eae'),
						'message'   =>  __(' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus' , 'wts-eae'),
						'rating' =>  '2.5'
					],
				],
				'title_field' => '{{{ person_name }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_gridlayout',
			[
				'label' => __('Grid Settings', 'wts-eae'),
				'condition' => [
					'layout' => 'grid'
				]
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __('Columns', 'wts-eae'),
				'type'  => Controls_Manager::NUMBER,
				'desktop_default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'min' => 1,
				'max' => 6,
				'condition'   => [
					'layout' => 'grid'
				],
				'selectors' => [
					'{{WRAPPER}} .eae-grid-container' => 'width: calc(100%/{{VALUE}})',
				]
			]
		);

		$this->add_control(
			'masonry',
			[
				'label' =>__('Masonry Layout' , 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('On', 'wts-eae'),
				'label_off' => __('Off', 'wts-eae'),
				'return_value' => 'yes',
				'condition'   => [
					'layout' => 'grid'
				],
			]

		);
		$this->add_responsive_control(
			'gutter',
			[
				'label' => __('Gutter','wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range'=>[
					'px'=>[
						'min' => 0,
						'max' =>40,
						'step' => 2,
					]
				],
				'default'=>[
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-grid-container' => 'padding-left:calc({{SIZE}}{{UNIT}}/2);' ,
					'{{WRAPPER}} .eae-grid-wrapper .eae-grid-container' => 'padding-right:calc({{SIZE}}{{UNIT}}/2);' ,
					'{{WRAPPER}} .eae-grid .eae-grid-container' => 'margin-bottom:{{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'layout' => 'grid'
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_layout',
			[
				'label' => __('Carousel Settings', 'wts-eae'),
				'condition' => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => __('Effects', 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'fade' => __('Fade', 'wts-eae'),
					'slide' => __('Slide', 'wts-eae'),
					'cube' => __('Cube', 'wts-eae'),
					'coverflow' => __('Coverflow', 'wts-eae'),
					'flip' => __('Flip', 'wts-eae'),
				],
				'default'=>'slide',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_responsive_control(
			'slide_per_view',
			[
				'label' => __( 'Slides Per View', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'default' => 3,
				'tablet_default'    =>  2,
				'mobile_default'    =>  1,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'effect',
							'operator' => '==',
							'value' => 'slide',
						],
						[
							'name' => 'effect',
							'operator' => '==',
							'value' => 'coverflow',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_per_group',
			[
				'label' => __( 'Slides Per Group', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'default' => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'effect',
							'operator' => '==',
							'value' => 'slide',
						],
						[
							'name' => 'effect',
							'operator' => '==',
							'value' => 'coverflow',
						],
					],
				],
			]
		);

		$this->add_control(
			'controls',
			[
				'label' => __('Setting', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __('Speed', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 300,
				],
				'description' => __('Duration of transition between slides (in ms)', 'wts-eae'),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 900,
						'step' => 1
					]
				],
				'condition'   => [
					'layout' => 'carousel'
				]

			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __('Autoplay', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('On', 'wts-eae'),
				'label_off' => __('Off', 'wts-eae'),
				'return_value' => 'yes',
				'condition'   => [
					'layout' => 'carousel'
				]
			]

		);

		$this->add_control(
			'duration',
			[
				'label' => __('Duration', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 3000,
				],
				'range' => [
					'px' =>[
						'min' => 1000,
						'max' => 10000,
						'step' => 1000,
					]
				],
				'condition' => [
					'autoplay' => 'yes',
					'layout!' => 'grid'
				],

			]
		);


		$this->add_responsive_control(
			'space',
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
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __('Loop', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);


		$this->add_control(
			'pagination_heading',
			[
				'label' => __('Pagination', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this -> add_control(
			'ptype',
			[
				'label' => __(' Pagination Type' , 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' =>
					[
						''        => __('None', 'wts-eae'),
						'bullets' => __( 'Bullets' , 'wts-eae'),
						'fraction' =>__( 'Fraction' , 'wts-eae'),
						'progressbar' =>__('Progress' , 'wts-eae'),
					],
				'default'=>'bullets',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'clickable',
			[
				'label' =>__('Clickable' , 'wts-eae'),
				'type' =>Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on'=>__('Yes', 'wts-eae'),
				'label_off' =>__('No' , 'wts-eae'),
				'condition'=> [
					'ptype' => 'bullets'
				],

			]
		);

		$this->add_control(
			'navigation_button',
			[
				'label' => __('Previous/Next Button' , 'wts-eae'),
				'type' =>Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Yes' , 'wts-eae'),
				'label_off' => __('No' , 'wts-eae'),
				'return_value' => 'yes',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'keyboard',
			[
				'label' => __('Keyboard Control' , 'wts-eae'),
				'type' =>Controls_Manager::SWITCHER,
				'default'=> 'yes',
				'label_on'=>__('Yes', 'wts-eae'),
				'label_off' =>__('No' , 'wts-eae'),
				'return_value'=>'yes',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);

		$this->add_control(
			'scrollbar',
			[
				'label' =>__('Scroll bar', 'wts-eae'),
				'type' =>Controls_Manager::SWITCHER,
				'default'=>'yes',
				'label_on' =>__('Yes' , 'wts-eae'),
				'label_off'=>__('No' , 'wts-eae'),
				'return_value' => 'yes',
				'condition'   => [
					'layout' => 'carousel'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Slider', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'wts-eae' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .testimonial-wrapper',
			]
		);
		$this-> add_control(
			'bar_background_color',
			[
				'label' =>__('Bar Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper.skin-1 .detail-wrapper' => 'background-color: {{VALUE}};',
				],
				'condition' =>  [
					'skin' => 'skin-1',
				]
			]
		);
		$this-> add_responsive_control(
			'padding',
			[
				'label' =>__('Padding', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this-> add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .testimonial-wrapper',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_content',
			[
				'label' => __('Content', 'wts-eae'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,

			]
		);
		$this->add_control(
			'message_heading',
			[
				'label' => __('Message', 'wts-eae'),
				'type' => Controls_Manager::HEADING,

			]

		);
		$this-> add_control(
			'message_background_color',
			[
				'label' =>__('Background', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .content-wrapper .wrapper' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this-> add_control(
			'message_color',
			[
				'label' =>__('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .content-wrapper .content' => 'color: {{VALUE}};',
				]
			]
		);
		$this-> add_group_control(
			Group_Control_Typography::get_type(),
			[   'name' => 'message_typography',
			    'label' =>__('Typography', 'wts-eae'),
			    'selector' => '{{WRAPPER}} .testimonial-wrapper .content-wrapper blockquote.wrapper p.content',
			]
		);
		$this->add_responsive_control(
			'message_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'wts-eae' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .testimonial-wrapper .content-wrapper .wrapper p.content' => 'text-align : {{VALUE}};'
				],
				'default' => 'center',
			]
		);
		$this-> add_responsive_control(
			'message_padding',
			[
				'label' =>__('Padding', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .content-wrapper blockquote.wrapper p.content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this-> add_responsive_control(
			'message_margin',
			[
				'label' =>__('Margin', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this->add_control(
			'title_heading',
			[
				'label' => __('Name', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',

			]

		);
		$this-> add_control(
			'title_color',
			[
				'label' =>__('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .title' => 'color: {{VALUE}};',
				]
			]
		);
		$this-> add_group_control(
			Group_Control_Typography::get_type(),
			[   'name' => 'title_typography',
			    'label' =>__('Typography', 'wts-eae'),
			    'selector' => '{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .title',
			]
		);
		$this->add_responsive_control(
			'title_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .testimonial-wrapper .detail-wrapper .title-wrapper .title' => 'text-align : {{VALUE}};'
				],
				'default' => 'center',
			]
		);
		$this-> add_responsive_control(
			'title_margin',
			[
				'label' =>__('Margin', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this->add_control(
			'company_heading',
			[
				'label' => __(' Company Name', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',

			]

		);
		$this-> add_control(
			'company_name_color',
			[
				'label' =>__('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .company' => 'color: {{VALUE}};',
				]
			]
		);
		$this-> add_group_control(
			Group_Control_Typography::get_type(),
			[   'name' => 'company_name_typography',
			    'label' =>__('Typography', 'wts-eae'),
			    'selector' => '{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .company',
			]
		);
		$this->add_responsive_control(
			'company_name_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .testimonial-wrapper .detail-wrapper .title-wrapper .company' => 'text-align : {{VALUE}};'
				],
				'default' => 'center',
			]
		);

		$this-> add_responsive_control(
			'company_margin',
			[
				'label' =>__('Margin', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .detail-wrapper .title-wrapper .company' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_rating',
			[
				'label' => __('Rating', 'wts-eae'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,


			]
		);
		$this-> add_control(
			'icon_color',
			[
				'label' =>__('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .detail-wrapper .rating-wrapper i' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' =>__('Icon Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 17,
				],
				'range' => [
					'px' => [
						'min' => 17,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .detail-wrapper .rating-wrapper ' => 'font-size : {{SIZE}}{{UNIT}};',
				],

			]
		);
		$this->add_responsive_control(
			'rating_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .detail-wrapper .rating-wrapper ' => 'text-align : {{VALUE}};'
				],
				'default' => 'center',
			]
		);
		$this-> add_responsive_control(
			'rating_margin',
			[
				'label' =>__('Margin', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .detail-wrapper .rating-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_images',
			[
				'label' => __('Image', 'wts-eae'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,

			]
		);
		$this->add_responsive_control(
			'image_size',
			[
				'label' =>__('Image Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'default' =>
					[
						'size' => 100
					],
			]
		);
		$this->add_responsive_control(
			'image_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .testimonial-wrapper .image-wrapper' => 'text-align : {{VALUE}};'
				],
				'default' => 'center',
			]
		);
		$this-> add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .testimonial-wrapper .image-wrapper img',
			]
		);
		$this-> add_responsive_control(
			'border_radius',
			[
				'label' =>__('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);
		$this-> add_responsive_control(
			'image_margin',
			[
				'label' =>__('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-wrapper .image-wrapper .image-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]

		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_pagination',
			[
				'label' => __('Carousel', 'wts-eae'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'carousel',
				]

			]
		);
		$this->add_control(
			'style_arrow',
			[
				'label' => __('Arrow', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->start_controls_tabs( 'arrow_styles' );

		$this->start_controls_tab(
			'normal_tab_arrow',
			[
				'label' => __( 'Normal', 'wts-eae' ),
			]
		);
		$this->add_control(
			'arrows_color',
			[
				'label' => __('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev i' => 'color:{{VAlUE}};',
					'{{WRAPPER}} .swiper-button-next i' => 'color:{{VAlUE}};'
				],
				'default' => '#444',
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_control(
			'arrow_background_color',
			[
				'label' => __(' Background Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev ' => 'background-color:{{VAlUE}};',
					'{{WRAPPER}} .swiper-button-next ' => 'background-color:{{VAlUE}};'
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'arrows_border',
				'label' => __( 'Border', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .swiper-container .swiper-button-prev , {{WRAPPER}} .swiper-container .swiper-button-next',
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_control(
			'arrows_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-button-prev ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
					'{{WRAPPER}} .swiper-container .swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_tab_arrow',
			[
				'label' => __( 'Hover', 'wts-eae' ),
			]
		);
		$this->add_control(
			'arrow_hover_color',
			[
				'label' => __('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover i' => 'color:{{VAlUE}};',
					'{{WRAPPER}} .swiper-button-next:hover i' => 'color:{{VAlUE}};'
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_control(
			'arrow_hover_background_color',
			[
				'label' => __(' Background Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover' => 'background-color:{{VAlUE}};',
					'{{WRAPPER}} .swiper-button-next:hover' => 'background-color:{{VAlUE}};'
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_control(
			'arrow_hover_border_color',
			[
				'label' => __(' Border Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover' => 'border-color:{{VAlUE}};',
					'{{WRAPPER}} .swiper-button-next:hover' => 'border-color:{{VAlUE}};'
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_control(
			'arrow_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-button-prev:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
					'{{WRAPPER}} .swiper-container .swiper-button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'arrows_size',
			[
				'label' => __('Arrow Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50
				],
				'range' => [
					'min' => 20,
					'max' => 100,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev i' => 'font-size:{{SIZE}}px;',
					'{{WRAPPER}} .swiper-button-next i' => 'font-size:{{SIZE}}px;',
				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'horizontal_position_arrow',
			[
				'label' => __( 'Horizontal Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default' => 'center',
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'vertical_position_arrow',
			[
				'label' => __( 'Vertical Position', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default' => 'center',
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'horizontal_offset_arrow',
			[
				'label' => __('Horizontal Offset', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'min' => 1,
					'max' => 1000,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .eae-hpos-left .eae-swiper-button-wrapper' => 'left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-hpos-right .eae-swiper-button-wrapper' => 'right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-hpos-center .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-hpos-center .swiper-button-next' => 'right: {{SIZE}}{{UNIT}}',

				],
				'condition' => [
					'navigation_button' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'vertical_offset_arrow',
			[
				'label' => __('Vertical Offset', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'min' => 1,
					'max' => 1000,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .eae-vpos-top .eae-swiper-button-wrapper' => 'top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-vpos-bottom .eae-swiper-button-wrapper' => 'bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-vpos-middle .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-vpos-middle .swiper-button-next' => 'top: {{SIZE}}{{UNIT}}',

				],
				'condition' => [
					'navigation_button' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'padding_arrow',
			[
				'label' => __( 'Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .swiper-button-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'dot_heading_style',
			[
				'label' => __('Dots', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ptype' => 'bullets'
				]
			]
		);

		$this->add_control(
			'dot_size',
			[
				'label' => __('Dots Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' =>
					[
						'size' => 5
					],
				'range' => [
					'min' => 1,
					'max' => 10,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width:{{SIZE}}px; height:{{SIZE}}px;',
				],
				'condition' => [
					'ptype' => 'bullets'
				]
			]
		);
		$this->add_control(
			'dot_color',
			[
				'label' => __('Active Dot Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .swiper-pagination-bullet-active' => 'background-color:{{VAlUE}} !important;',
				],
				'condition' => [
					'ptype' => 'bullets'
				]
			]
		);

		$this->add_control(
			'inactive_dot_color',
			[
				'label' => __('Inactive Dot Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color:{{VAlUE}};',
				],
				'condition' => [
					'ptype' => 'bullets'
				]
			]
		);
		$this->add_responsive_control(
			'bullet_margin_pagination',
			[
				'label' => __( 'Margin', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ptype' => 'bullets'
				]
			]
		);

		$this->add_control(
			'style_scroll_heading',
			[
				'label' => __('Scrollbar', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'scrollbar' => 'yes'
				]
			]
		);
		$this->add_control(
			'scrollbar_size',
			[
				'label' => __('Scrollbar Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5
				],
				'range' => [
					'min' => 1,
					'max' => 10,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container-vertical .swiper-scrollbar' => 'width:{{SIZE}}px;',
					'{{WRAPPER}} .swiper-container-horizontal .swiper-scrollbar' => 'height:{{SIZE}}px;',
				],
				'condition' => [
					'scrollbar' => 'yes'
				]
			]
		);
		$this->add_control(
			'scrollbar_drag_color',
			[
				'label' => __('Scrollbar Drag Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-scrollbar' => 'background-color:{{VAlUE}};',
				],
				'condition' => [
					'scrollbar' => 'yes'
				]
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label' => __('Scrollbar Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-scrollbar-drag' => 'background-color:{{VAlUE}};',
				],
				'condition' => [
					'scrollbar' => 'yes'
				]
			]
		);
		$this->add_control(
			'heading_progressbar',
			[
				'label' => __('Progress Bar', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ptype' => 'progressbar'
				]
			]
		);
		$this->add_control(
			'progressbar_color_pagination',
			[
				'label' => __('Progress Bar Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color:{{VAlUE}};',
				],
				'condition' => [
					'ptype' => 'progressbar'
				]
			]
		);
		$this->add_control(
			'progressbar_color_pg',
			[
				'label' => __('Progress Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color:{{VAlUE}};',
				],
				'condition' =>
					[
						'ptype' => 'progressbar'
					]
			]
		);
		$this->add_control(
			'progress_size',
			[
				'label' => __('Progress Bar Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' =>
					[
						'size' => 5
					],
				'range' => [
					'min' => 1,
					'max' => 10,
					'step' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height:{{SIZE}}px;',
					'{{WRAPPER}} .swiper-container-vertical .swiper-pagination-progress' => 'width:{{SIZE}}px;',
				],
				'condition' => [
					'ptype' => 'progressbar'
				]
			]
		);
		$this->add_responsive_control(
			'progressbar_margin',
			[
				'label' => __( 'Margin', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ptype' => 'progressbar'
				]
			]
		);
		$this->end_controls_section();








	}
	protected function render() {
		$settings = $this->get_settings();
		$skin = $settings['skin'];
		$testimonials = $settings['testimonials'];
		//echo '<pre>'; print_r($settings); echo '</pre>';
		if($settings['layout'] == 'carousel') {

			/*-- Carousel */
			$slide_per_view['desktop'] = $settings['slide_per_view'] != "" ? $settings['slide_per_view'] : 1;
			$slide_per_view['tablet'] = $settings['slide_per_view_tablet'] != "" ? $settings['slide_per_view_tablet'] : 1;
			$slide_per_view['mobile'] = $settings['slide_per_view_mobile'] != "" ? $settings['slide_per_view_mobile'] : 1;

			$slides_per_group['desktop'] = $settings['slides_per_group'] != "" ? $settings['slides_per_group'] : 1;
			$slides_per_group['tablet'] = $settings['slides_per_group_tablet'] != "" ? $settings['slides_per_group_tablet'] : 1 ;
			$slides_per_group['mobile'] = $settings['slides_per_group_mobile'] != "" ? $settings['slides_per_group_mobile'] : 1;
			//echo '<pre>';print_r($slide_per_view);'</pre>';

			$direction = 'horizontal';
			$speed = $settings['speed'];
			$autoplay = $settings['autoplay'];
			$duration = $settings['duration'];
			$effect = $settings['effect'];
			$space['desktop'] = $settings['space']['size'];
			$space['tablet'] = $settings['space_tablet']['size'];
			$space['mobile'] = $settings['space_mobile']['size'];
			//print_r(json_encode($space));
			$loop = $settings['loop'];
			$pagination_type = $settings['ptype'];
			$navigation_button = $settings['navigation_button'];
			$clickable = $settings['clickable'];
			$keyboard = $settings['keyboard'];
			$scrollbar = $settings['scrollbar'];
			//$ptype = $settings['ptype'];

			$this->add_render_attribute('outer-wrapper', 'class', 'eae-swiper-outer-wrapper');
			$this->add_render_attribute('outer-wrapper' , 'class' , 'eae-layout-'.$settings['layout']);
			$this->add_render_attribute( 'outer-wrapper', 'class', 'eae-hpos-' .$settings['horizontal_position_arrow'] );
			$this->add_render_attribute( 'outer-wrapper', 'class', 'eae-vpos-' .$settings['vertical_position_arrow']);

			$this->add_render_attribute('outer-wrapper', 'data-speed', $speed['size']);
			$this->add_render_attribute('outer-wrapper', 'data-direction', $direction);
			if ($autoplay == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-autoplay', $autoplay);
			}
			if ($autoplay == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-duration', $duration['size']);
			}
			$this->add_render_attribute('outer-wrapper', 'data-effect', $effect);
			$this->add_render_attribute('outer-wrapper', 'data-space', json_encode($space, JSON_NUMERIC_CHECK));
			if ($loop == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-loop', $loop);
			} else {
				autoplayStopOnLast:
				true;
			}

			if (!empty($slide_per_view)) {
				$this->add_render_attribute('outer-wrapper', 'data-slides-per-view', json_encode($slide_per_view, JSON_NUMERIC_CHECK));
			}

			if (!empty($slides_per_group)) {
				$this->add_render_attribute('outer-wrapper', 'data-slides-per-group', json_encode($slides_per_group, JSON_NUMERIC_CHECK));
			}


			if ($pagination_type != '') {
				$this->add_render_attribute('outer-wrapper', 'data-ptype', $pagination_type);
			}
			if ($pagination_type == 'bullets' && $clickable == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-clickable', $clickable);
			}
			if ($navigation_button == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-navigation', $navigation_button);
			}
			if ($keyboard == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-keyboard', $keyboard);
			}
			if ($scrollbar == 'yes') {
				$this->add_render_attribute('outer-wrapper', 'data-scrollbar', $scrollbar);
			}

			$this->add_render_attribute('wrapper' , 'class' , 'eae-swiper-wrapper');
			$this->add_render_attribute('wrapper' , 'class' , 'swiper-wrapper');
			?>
			<div <?php echo $this->get_render_attribute_string('outer-wrapper');?>>
				<div class="swiper-container">
					<div <?php echo $this->get_render_attribute_string('wrapper');?>>
						<?php
						foreach($testimonials as $testimonial){
							$name = $testimonial['person_name'];
							$image_size = $testimonial['thumbnail_size'];
							$image = $testimonial['person_image']['id'];
							if(!empty($testimonial['person_image']['id'])){
								$avatar = wp_get_attachment_image_src($image , $image_size);
							}
							else{
								$avatar[0] = Utils::get_placeholder_image_src();
							}
							//print_r($avatar);
							$company = $testimonial['company_name'];
							$message = $testimonial['message'];
							$rating = $testimonial['rating'];
							?>
							<div class="swiper-slide">
								<div class="swiper-slide-wrapper">
									<div class="testimonial-wrapper <?php echo $skin; ?> ">
										<div class="image-wrapper">
											<img src="<?php echo $avatar[0]; ?>">
										</div>
										<div class="content-wrapper">
											<?php if($skin == 'skin-3'){?>
											<div class="content-section">
												<?php } ?>
												<blockquote class="wrapper">
													<p class="content"><?php echo $message; ?></p>
												</blockquote>
											</div>
											<div class="detail-wrapper">
												<div class="rating-wrapper">
													<?php for($i=1; $i<=5; $i++){?>
														<?php if($i <= $rating){?>
															<i class="fa fa-star"></i>
														<?php } elseif ($i > $rating && $i-1 < $rating) {?>
															<i class="fa fa-star-half-empty"></i>
														<?php } else {?>
															<i class="fa fa-star-o"></i>
														<?php } ?>
													<?php  } ?>

												</div>
												<div class="title-wrapper">
													<div class="title"><?php echo $name; ?><?php if($skin == 'skin-1'){ echo ' -';} ?></div>
													<div class="company"><?php echo $company; ?></div>
												</div>
											</div>
											<?php if($skin == 'skin-3'){?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php if($pagination_type != ''){ ?>
						<div class = "swiper-pagination"></div>
					<?php } ?>

					<?php if($navigation_button == 'yes'){ ?>
				<?php if($settings['horizontal_position_arrow'] != 'center'){;?>
					<div class="eae-swiper-button-wrapper">
						<?php } ?>
						<div class = "swiper-button-prev">
							<i class="fa fa-angle-left"></i>
						</div>
						<div class = "swiper-button-next">
							<i class="fa fa-angle-right"></i>
						</div>
						<?php } ?>
						<?php if($settings['horizontal_position_arrow'] != 'center'){;?>
					</div>
				<?php } ?>

					<?php if($scrollbar == 'yes'){ ?>
						<div class = "swiper-scrollbar"></div>
					<?php } ?>
				</div>
			</div>

			<?php
		}

		/*-- Carousel End */

		/*--Grid Start */
		if($settings['layout'] == 'grid'){
			$masonry    =   $settings['masonry'];
			$this->add_render_attribute('grid-wrapper' , 'class' , 'eae-layout-'.$settings['layout']);
			$this->add_render_attribute('grid-wrapper','class','eae-masonry-'.$masonry);
			$this->add_render_attribute('grid-wrapper','class','eae-grid-wrapper');
			?>
			<div <?php echo $this->get_render_attribute_string('grid-wrapper'); ?>>
				<div class="eae-grid">
					<?php
					foreach($testimonials as $testimonial){
						$name = $testimonial['person_name'];
						$image_size = $testimonial['thumbnail_size'];
						$image = $testimonial['person_image']['id'];
						if(!empty($testimonial['person_image']['id'])){
							$avatar = wp_get_attachment_image_src($image , $image_size);
						}
						else{
							$avatar[0] = Utils::get_placeholder_image_src();
						}
						//print_r($avatar);
						$company = $testimonial['company_name'];
						$message = $testimonial['message'];
						$rating = $testimonial['rating'];
						?>
						<div class="eae-grid-container">
							<div class="eae-grid-item">
								<div class="testimonial-wrapper <?php echo $skin; ?> ">
									<div class="image-wrapper">
										<img src="<?php echo $avatar[0]; ?>">
									</div>
									<div class="content-wrapper">
										<?php if($skin == 'skin-3'){?>
										<div class="content-section">
											<?php } ?>
											<blockquote class="wrapper">
												<p class="content"><?php echo $message; ?></p>
											</blockquote>
										</div>
										<div class="detail-wrapper">
											<div class="rating-wrapper">
												<?php for($i=1; $i<=5; $i++){?>
													<?php if($i <= $rating){?>
														<i class="fa fa-star"></i>
													<?php } elseif ($i > $rating && $i-1 < $rating) {?>
														<i class="fa fa-star-half-empty"></i>
													<?php } else {?>
														<i class="fa fa-star-o"></i>
													<?php } ?>
												<?php  } ?>

											</div>
											<div class="title-wrapper">
												<div class="title"><?php echo $name; ?><?php if($skin == 'skin-1'){ echo ' -';} ?></div>
												<div class="company"><?php echo $company; ?></div>
											</div>
										</div>
										<?php if($skin == 'skin-3'){?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php }
		//echo '<pre>'; print_r($testimonials); echo '</pre>';
	}
}
//Plugin::instance()->widgets_manager->register_widget_type( new EAE_Testimonial_Slider() );