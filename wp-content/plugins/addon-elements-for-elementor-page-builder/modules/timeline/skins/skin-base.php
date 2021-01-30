<?php

namespace WTS_EAE\Modules\Timeline\Skins;

use Elementor\Core\Kits\Documents\Tabs\Colors_And_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use WTS_EAE\Classes\Post_Helper;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use WTS_EAE\Classes\Helper;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

abstract class Skin_Base extends Elementor_Skin_Base
{

	protected function _register_controls_actions()
	{
		add_action('elementor/element/eae-timeline/tl_skins/before_section_end', [$this, 'register_controls']);
		add_action('elementor/element/eae-timeline/tl_skins/after_section_end', [$this, 'register_items_control']);
		add_action('elementor/element/eae-timeline/section_post_element/after_section_end', [
			$this,
			'register_global_icon'
		]);
		add_action('elementor/element/eae-timeline/tl_skins/after_section_end', [
			$this,
			'register_style_controls'
		]);
	}

	public function register_controls(Widget_Base $widget)
	{
		$this->parent = $widget;
	}

	public function register_global_icon(Widget_Base $widget)
	{
		$this->parent = $widget;
		$this->start_controls_section(
			'section_global_icon',
			[
				'label' => __('Global Icon', 'wts-eae')
			]
		);

		$this->add_control(
			'global_icon_heading',
			[
				'label'     => __('Global Icon', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'global_icon_type',
			[
				'type'        => Controls_Manager::CHOOSE,
				'label'       => __('Type', 'wts-eae'),
				'default'     => 'icon',
				'options'     => [
					'icon'  => [
						'title' => __('Fontawesome Icon', 'wts-eae'),
						'icon'  => 'fa fa-font-awesome',
					],
					'image' => [
						'title' => __('Custom Icons', 'wts-eae'),
						'icon'  => 'fa fa-image',
					],
					'text'  =>   [
						'title' => __('Text', 'wts-eae'),
						'icon'  => 'fa fa-font',
					],
				],
				'label_block' => false,
			]
		);

		//		$this->add_control(
		//			'global_icon',
		//			[
		//				'label'     => __( 'Icon', 'wts-eae' ),
		//				'type'      => Controls_Manager::ICON,
		//				'default'   => 'fa fa-calendar',
		//				'condition' => [
		//					$this->get_control_id( 'global_icon_type' ) => 'icon'
		//				]
		//			]
		//		);

		$this->add_control(
			'global_icon_new',
			[
				'label' => __('Icon', 'wts-eae'),
				'type' => Controls_Manager::ICONS,
				//'fa4compatibility' => 'global_icon',
				'fa4compatibility' => $this->get_control_id('global_icon'),
				'default' => [
					'value' => 'fa fa-calendar',
					'library' => 'fa-solid',
				],
				'condition' => [
					$this->get_control_id('global_icon_type') => 'icon'
				]
			]
		);

		$this->add_control(
			'global_icon_image',
			[
				'label'       => __('Custom Icon', 'wts-eae'),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'condition'   => [
					$this->get_control_id('global_icon_type') => 'image'
				]
			]
		);

		$this->add_control(
			'global_icon_text',
			[
				'label'       => __('Text', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'condition'   => [
					$this->get_control_id('global_icon_type') => 'text'
				]
			]
		);

		$this->add_control(
			'global_icon_view',
			[
				'label'   => __('View', 'wts-eae'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => __('Default', 'wts-eae'),
					'stacked' => __('Stacked', 'wts-eae'),
					'framed'  => __('Framed', 'wts-eae'),
				],
				'default' => 'stacked',
			]
		);

		$this->add_control(
			'global_icon_shape',
			[
				'label'     => __('Shape', 'wts-eae'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'circle' => __('Circle', 'wts-eae'),
					'square' => __('Square', 'wts-eae'),
				],
				'default'   => 'circle',
				'condition' => [
					$this->get_control_id('global_icon_view!') => 'default',
				]
			]
		);

		$this->end_controls_section();
	}

	public function register_style_controls()
	{
	}

	public function register_items_control(Widget_Base $widget)
	{
	}

	function eae_timeline_style_section()
	{
		$this->start_controls_section(
			'section_styling',
			[
				'label' => __('Layout', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'timeline_align',
			[
				'label'   => __('Alignment', 'wts-eae'),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'eicon-h-align-right',
					],
					'toggle' => false,
				],
			]
		);
		$this->add_control(
			'tl_responsive_style',
			[
				'label'     => __('Responsive Style', 'wts-eae'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'mobile'        => __('For Mobile', 'wts-eae'),
					'mobile-tablet' => __('For Mobile & Tablet', 'wts-eae'),
				],
				'default'   => 'mobile',
				'condition' => [
					$this->get_control_id('timeline_align') => 'center'
				]
			]
		);

		$this->add_control(
			'tl_responsive_layout',
			[
				'label'        => __('Responsive Orientation', 'wts-eae'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Right', 'wts-eae'),
				'label_off'    => __('Left', 'wts-eae'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					$this->get_control_id('timeline_align') => 'center'
				]
			]
		);

		$this->add_control(
			'horizontal_spacing',
			[
				'label'     => __('Horizontal Spacing', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-layout-center .eae-tl-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}} !important; margin-left: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .eae-layout-left .eae-tl-icon-wrapper'   => 'margin-right: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .eae-layout-right .eae-tl-icon-wrapper'  => 'margin-left: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'vertical_spacing',
			[
				'label'     => __('Vertical Spacing', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-timeline-item' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'card_styling',
			[
				'label' => __('Card', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'     => __('Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
					'left'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Top', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_align_heading',
			[
				'label'     => __('Image', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'image_align_post',
			[
				'label'        => __('Alignment', 'wts-eae'),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'row'         => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'column'      => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'row-reverse' => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'column',
				'selectors'    => [
					'{{WRAPPER}} .eae-tl-item-content' => 'flex-direction: {{VALUE}}',
				],
				'prefix_class' => 'image-position-',
			]
		);

		$this->add_control(
			'tl_alternate_style',
			[
				'label'        => __('Alternate Style', 'wts-eae'),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					$this->get_control_id('image_align_post!') => 'column',
				]
			]
		);

		$this->add_control(
			'image_width_post',
			[
				'label'     => __('Size', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-image'                         => 'width: {{SIZE}}%',
					'{{WRAPPER}}.image-position-column .eae-tl-content'      => 'width: 100%',
					'{{WRAPPER}}.image-position-row .eae-tl-content'         => 'width: calc(100% - {{SIZE}}%)',
					'{{WRAPPER}}.image-position-row-reverse .eae-tl-content' => 'width: calc(100% - {{SIZE}}%)',
				],
			]
		);

		$this->add_control(
			'image_spacing_post',
			[
				'label'     => __('Spacing', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.image-position-column .eae-tl-item-image'                                                                                                                         => 'margin: 0 auto {{SIZE}}{{UNIT}} auto;',
					'{{WRAPPER}}.image-position-row .eae-layout-center:not(.eae-timeline-layout-rtl) .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'                                         => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-center.eae-timeline-layout-rtl .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'                 => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-center:not(.eae-timeline-alternate-yes) .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'         => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-center.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'               => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-center .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'                                 => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-center:not(.eae-timeline-alternate-yes) .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-center.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'       => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-left:not(.eae-timeline-alternate-yes) .eae-timeline-item:not(.custom-image-style-yes) .eae-tl-item-image'                          => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-left.eae-timeline-alternate-yes .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'                => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-left.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'                 => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-left:not(.eae-timeline-alternate-yes) .eae-timeline-item:not(.custom-image-style-yes) .eae-tl-item-image'                  => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-left.eae-timeline-alternate-yes .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'        => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-left.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'         => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-right:not(.eae-timeline-alternate-yes) .eae-timeline-item:not(.custom-image-style-yes) .eae-tl-item-image'                         => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-right.eae-timeline-alternate-yes .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'               => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row .eae-layout-right.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'                => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-right:not(.eae-timeline-alternate-yes) .eae-timeline-item:not(.custom-image-style-yes) .eae-tl-item-image'                 => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-right.eae-timeline-alternate-yes .eae-timeline-item:nth-child(even):not(.custom-image-style-yes) .eae-tl-item-image'       => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.image-position-row-reverse .eae-layout-right.eae-timeline-alternate-yes .eae-timeline-item:nth-child(odd):not(.custom-image-style-yes) .eae-tl-item-image'        => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'image_radius_post',
			[
				'label'      => __('Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after'
			]
		);
		$this->add_control(
			'arrow_align',
			[
				'label'   => __('Arrow Alignment', 'wts-eae'),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => [
					'top'    => [
						'title' => __('Top', 'wts-eae'),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __('Bottom', 'wts-eae'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __('Border', 'wts-eae'),
				'selector'    => '{{WRAPPER}} .eae-tl-item-content',
				'label_block' => true,
			]
		);

		$this->start_controls_tabs('timeline_content_style_tab');

		$this->start_controls_tab(
			'default',
			[
				'label' => __('Default', 'wts-eae'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __('Title Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __('Content Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-content' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => __('Title Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-tl-item-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => __('Content Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-tl-item-content',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'label'    => 'Title Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'item_text_shadow',
				'label'    => 'Content Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-content-innner',
			]
		);
		$this->add_control(
			'background_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-content'                                                                                            => 'background: {{VALUE}};',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-timeline-item:nth-child(even) .eae-tl-item-content::before'                 => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-timeline-item:nth-child(odd) .eae-tl-item-content::before'                  => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .eae-layout-right.eae-timeline .eae-tl-item-content::before'                                                     => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .eae-layout-left.eae-timeline .eae-tl-item-content::before'                                                      => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(mobile){{WRAPPER}} .eae-layout-center.eae-timeline.eae-tl-res-layout-left .eae-timeline-item .eae-tl-item-content::before'  => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(tablet){{WRAPPER}} .eae-layout-center.eae-timeline.eae-tl-res-layout-left .eae-timeline-item .eae-tl-item-content::before'  => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(mobile){{WRAPPER}} .eae-layout-center.eae-timeline.eae-tl-res-layout-right .eae-timeline-item .eae-tl-item-content::before' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(tablet){{WRAPPER}} .eae-layout-center.eae-timeline.eae-tl-res-layout-right .eae-timeline-item .eae-tl-item-content::before' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(mobile){{WRAPPER}} .eae-timeline.eae-layout-center.eae-tl-res-style-mobile .eae-timeline-item:nth-child(odd) .eae-tl-item-content::before'  => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(tablet){{WRAPPER}} .eae-timeline.eae-layout-center.eae-tl-res-style-mobile .eae-timeline-item:nth-child(odd) .eae-tl-item-content::before'  => 'border-color: transparent transparent transparent {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'box_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-content',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __('Hover', 'wts-eae'),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => __('Title Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label'     => __('Content Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-content' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography_hover',
				'label'    => __('Title Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-title',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography_hover',
				'label'    => __('Content Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-content',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow_hover',
				'label'    => 'Title Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'item_text_shadow_hover',
				'label'    => 'Content Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-content-innner',
			]
		);
		$this->add_control(
			'background_color_hover',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-content'                                                                                                    => 'background: {{VALUE}};',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-timeline-item:nth-child(even) .eae-tl-content-wrapper:hover .eae-tl-item-content::before'                         => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-timeline-item:nth-child(odd) .eae-tl-content-wrapper:hover .eae-tl-item-content::before'                          => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(tablet)(mobile){{WRAPPER}} .eae-tl-res-layout-right.eae-layout-center.eae-timeline .eae-timeline-item .eae-tl-content-wrapper:hover .eae-tl-item-content::before' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(tablet)(mobile){{WRAPPER}} .eae-tl-res-layout-left.eae-layout-center.eae-timeline .eae-timeline-item .eae-tl-content-wrapper:hover .eae-tl-item-content::before'  => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'{{WRAPPER}} .eae-layout-right.eae-timeline .eae-tl-content-wrapper:hover .eae-tl-item-content::before'                                                             => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .eae-layout-left.eae-timeline .eae-tl-content-wrapper:hover .eae-tl-item-content::before'                                                              => 'border-color: transparent {{VALUE}} transparent transparent !important;',
				],
			]
		);
		$this->add_control(
			'box_radius_hover',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow_hover',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-content-wrapper:hover .eae-tl-item-content',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'focused',
			[
				'label' => __('Focused', 'wts-eae'),
			]
		);

		$this->add_control(
			'title_color_focused',
			[
				'label'     => __('Title Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_focused',
			[
				'label'     => __('Content Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-content' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography_focused',
				'label'    => __('Title Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-title',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography_focused',
				'label'    => __('Content Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-content',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'item_title_shadow_focused',
				'label'    => 'Title Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'item_text_shadow_focused',
				'label'    => 'Content Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-content-innner',
			]
		);
		$this->add_control(
			'background_color_focused',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-content'                                                                                                                                  => 'background: {{VALUE}};',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item:nth-child(even) .eae-tl-item-content::before'                                                        => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(mobile){{WRAPPER}} .eae-tl-res-layout-left.eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item .eae-tl-item-content::before'                                         => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'(mobile)(tablet){{WRAPPER}} .eae-tl-res-style-mobile-tablet.eae-tl-res-layout-left.eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item .eae-tl-item-content::before'  => 'border-color: transparent {{VALUE}} transparent transparent !important;',
					'{{WRAPPER}} .eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item:nth-child(odd) .eae-tl-item-content::before'                                                         => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(mobile){{WRAPPER}} .eae-tl-res-layout-right.eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item .eae-tl-item-content::before'                                        => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'(mobile)(tablet){{WRAPPER}} .eae-tl-res-style-mobile-tablet.eae-tl-res-layout-right.eae-layout-center.eae-timeline .eae-tl-item-focused.eae-timeline-item .eae-tl-item-content::before' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .eae-layout-right.eae-timeline .eae-tl-item-focused .eae-tl-item-content::before'                                                                                           => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .eae-layout-left.eae-timeline .eae-tl-item-focused .eae-tl-item-content::before'                                                                                            => 'border-color: transparent {{VALUE}} transparent transparent !important;',
				],
			]
		);
		$this->add_control(
			'box_radius_focused',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow_focused',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-content',

			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->register_style_cta_controls();

		$this->start_controls_section(
			'date_styling',
			[
				'label' => __('Date', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'date_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-meta'       => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-tl-item-meta-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'date_margin',
			[
				'label'      => __('Margin', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-meta'       => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-tl-item-meta-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs('date_tabs_style');

		$this->start_controls_tab(
			'date_normal',
			[
				'label' => __('Normal', 'wts-eae'),
			]
		);
		$this->add_control(
			'date_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-meta'       => 'color: {{value}}',
					'{{WRAPPER}} .eae-tl-item-meta-inner' => 'color: {{value}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'date_shadow',
				'label'     => 'Text Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-meta,{{WRAPPER}} .eae-tl-item-meta-inner',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'date_typography',
				'label'     => __('Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-tl-item-meta,{{WRAPPER}} .eae-tl-item-meta-inner',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'date_hover',
			[
				'label' => __('Hover', 'wts-eae'),
			]
		);
		$this->add_control(
			'date_color_hover',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta'       => 'color: {{value}}',
					'{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta-inner' => 'color: {{value}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'date_shadow_hover',
				'label'     => 'Text Shadow',
				'selector' => '{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta,{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta-inner',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'date_typography_hover',
				'label'     => __('Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta,{{WRAPPER}} .eae-timeline-item:hover .eae-tl-item-meta-inner',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'date_focused',
			[
				'label' => __('Focused', 'wts-eae'),
			]
		);
		$this->add_control(
			'date_color_focused',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta'       => 'color: {{value}}',
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta-inner' => 'color: {{value}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'date_shadow_focused',
				'label'     => 'Text Shadow',
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta,{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta-inner',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'date_typography_focused',
				'label'     => __('Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta,{{WRAPPER}} .eae-tl-item-focused .eae-tl-item-meta-inner',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'line_styling',
			[
				'label' => __('Connector', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'line_bg_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-timline-progress-bar' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'progress_color',
			[
				'label'     => __('Progress Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-timline-progress-bar .eae-pb-inner-line' => 'background: {{VALUE}}',

				],
			]
		);


		$this->add_control(
			'progress_offset',
			[
				'label'    =>   __('Progress Offset', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				]
			]
		);

		$this->add_control(
			'line_thickness',
			[
				'label'     => __('Thickness', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'   => [
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-layout-center .eae-timline-progress-bar' => 'width: {{SIZE}}{{UNIT}}; left: calc(50% - {{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .eae-layout-left .eae-timline-progress-bar'   => 'width: {{SIZE}}{{UNIT}};',
					// left: calc(10px + {{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .eae-layout-right .eae-timline-progress-bar'  => 'width: {{SIZE}}{{UNIT}};'
					//left: calc(100% - 13px - {{SIZE}}{{UNIT}}/2);',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'icon_global_style',
			[
				'label' => __('Icon', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->get_icon_style_section();
		$this->end_controls_section();
	}

	public function register_style_cta_controls()
	{
		$this->start_controls_section(
			'section_cta_style',
			[
				'label'     => __('Call To Action', 'wts-eae'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_cta'  => 'yes',
					'data_source' => 'post'
				],
			]
		);

		$this->start_controls_tabs('cta_tabs_style');

		$this->start_controls_tab(
			'cta_normal',
			[
				'label' => __('Normal', 'wts-eae'),
			]
		);

		$this->add_control(
			'cta_color',
			[
				'label'     => __('Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-tl-read-more a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'cta_background_color',
				'label'    => __('Background Color Image', 'wts-eae'),
				'types'    => ['none', 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eae-tl-read-more',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'cta_border',
				'label'    => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-tl-read-more',
			]
		);

		$this->add_control(
			'cta_border_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => [
					'{{WRAPPER}}  .eae-tl-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_hover',
			[
				'label' => __('Hover', 'wts-eae'),
			]
		);

		$this->add_control(
			'cta_hover_color',
			[
				'label'     => __('Text Hover Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .eae-tl-read-more:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'cta_background_hover_color',
				'label'    => __('Background Color Image', 'wts-eae'),
				'types'    => ['none', 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eae-tl-read-more:hover',
			]
		);

		$this->add_control(
			'cta_hover_border_color',
			[
				'label'     => __('Border Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-read-more:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cta_border_radius_hover',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => [
					'{{WRAPPER}}  .eae-tl-read-more:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_focused',
			[
				'label' => __('focused', 'wts-eae'),
			]
		);

		$this->add_control(
			'cta_focused_color',
			[
				'label'     => __('Text focused Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-read-more a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'cta_background_focused_color',
				'label'    => __('Background Color Image', 'wts-eae'),
				'types'    => ['none', 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eae-tl-item-focused .eae-tl-read-more',
			]
		);

		$this->add_control(
			'cta_focused_border_color',
			[
				'label'     => __('Border Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-read-more' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cta_border_radius_focused',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-item-focused .eae-tl-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cta_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-tl-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_typography',
				'selector' => '{{WRAPPER}} .eae-tl-read-more a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
			]
		);

		$this->end_controls_section();
	}

	function get_icon_style_section()
	{
		$helper = new Helper();

		//$helper->group_icon_timeline_styles( $this, [
		$helper->group_icon_styles($this, [
			'name'                  => 'item_icon',
			'primary_color'         => true,
			'secondary_color'       => true,
			'hover_primary_color'   => true,
			'hover_secondary_color' => true,
			'focus_primary_color'   => true,
			'focus_secondary_color' => true,
			'hover_animation'       => false,
			'icon_size'             => true,
			'icon_padding'          => true,
			'rotate'                => true,
			'border_width'          => true,
			'border_radius'         => true,
			'tabs'                  => false,
			'custom_style_switch'   => false,
			'focus_item_class'      => 'eae-tl-item-focused',
		]);
	}

	function common_render()
	{
		$settings = $this->parent->get_settings_for_display();

		$helper = new Helper();
		$top_offset = $this->get_instance_value('progress_offset')['size'];

		$this->parent->add_render_attribute('wrapper_class', 'data-layout', $this->get_instance_value('timeline_align'));
		$this->parent->add_render_attribute('wrapper_class', 'data-top-offset', $top_offset);
		$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-layout-' . $this->get_instance_value('timeline_align'));
		$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-timeline');
		if (is_rtl()) {
			$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-timeline-layout-rtl');
		}

		$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-timeline-alternate-' . $this->get_instance_value('tl_alternate_style'));
		$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-tl-' . $this->get_instance_value('arrow_align'));

		if ($this->get_instance_value('timeline_align') == 'center') {
			$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-tl-res-style-' . $this->get_instance_value('tl_responsive_style'));
			if ('yes' == $this->get_instance_value('tl_responsive_layout')) {
				$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-tl-res-layout-right');
			} else {
				$this->parent->add_render_attribute('wrapper_class', 'class', 'eae-tl-res-layout-left');
			}
		}

		$this->parent->add_render_attribute('bar_class', 'class', 'eae-timline-progress-bar');

		$this->parent->add_render_attribute('meta_wrapper', 'class', 'eae-tl-item-meta-wrapper');
		$this->parent->add_render_attribute('meta', 'class', 'eae-tl-item-meta');
?>
		<section <?php echo $this->parent->get_render_attribute_string('wrapper_class'); ?>>
			<div <?php echo $this->parent->get_render_attribute_string('bar_class'); ?>>
				<div class='eae-pb-inner-line'></div>
			</div>

			<?php
			if ($settings['data_source'] == 'custom') {
				$this->render_custom_content($settings, $helper);
			} else {
				$this->render_post_content($settings, $helper);
			}
			?>
		</section>

	<?php
	}

	function render_custom_content($settings, $helper)
	{
    //echo '<pre>'; print_r($settings); echo '</pre>';
	?>

		<?php foreach ($settings['timeline_items'] as $index => $item) : ?>
			<?php

			$this->parent->add_render_attribute($item['_id'] . '-icon_wrapper', 'class', [
				'eae-tl-icon-wrapper'
			]); ?>
			<?php
			$this->parent->add_render_attribute($item['_id'] . '-icon_wrapper', 'id', $item['_id']);
			$this->parent->add_render_attribute($item['_id'] . '-link-attributes', 'href', $item['item_link']['url']);
			if ($item['item_link']['is_external'] == 'on') {
				$this->parent->add_render_attribute($item['_id'] . '-link-attributes', 'target', '_blank');
			}
			if ($item['item_link']['nofollow']) {
				$this->parent->add_render_attribute($item['_id'] . '-link-attributes', 'rel', 'nofollow');
			}

			?>

			<?php
			if ($settings['_skin'] == 'skin2') {
				if ($item['image_align'] !== '') {
					$image_align = $item['image_align'];
				} else {
					$image_align = "row";
				}
			} else {
				$image_align = $item['image_align'];
			}
			?>
			<div id="<?php echo $item['_id'] ?>" class="eae-timeline-item elementor-repeater-item-<?php echo $item['_id'] ?> custom-image-style-<?php echo $item['tl_custom_image_style'] ?> image-position-<?php echo $image_align; ?>">

				<div <?php echo $this->parent->get_render_attribute_string('meta_wrapper'); ?>>
					<?php
					if ($item['item_date'] !== '') {
					?>
						<div <?php echo $this->parent->get_render_attribute_string('meta'); ?>>
							<?php
							echo $item['item_date'];
							?>
						</div>
					<?php
					}
					?>

				</div>

				<div <?php echo $this->parent->get_render_attribute_string($item['_id'] . '-icon_wrapper'); ?>>
					<?php

					$default_icon['icon_type'] = $this->get_instance_value('global_icon_type');
					$icon_migrated = isset($settings['__fa4_migrated']['slider_icon_new']);
					$icon_is_new = empty($settings['slider_icon']);

					$default_icon['icon_new']      = $this->get_instance_value('global_icon_new');
					$default_icon['icon']      = $this->get_instance_value('global_icon');
					$default_icon['image']     = $this->get_instance_value('global_icon_image');
					$default_icon['text']      = $this->get_instance_value('global_icon_text');
					$default_icon['view']      = $this->get_instance_value('global_icon_view');
					$default_icon['shape']     = $this->get_instance_value('global_icon_shape');
					echo $helper->get_icon_html($item, 'item_icon', $default_icon, $settings);

					?>
				</div>
				<div class="eae-tl-content-wrapper">
					<?php if (!empty($item['item_link']['url'])) { ?>
						<a <?php echo $this->parent->get_render_attribute_string($item['_id'] . '-link-attributes'); ?>>
						<?php } ?>
						<div class="eae-tl-item-content">
							<?php

							if ($item['item_content_image']['id'] != "" || $item['item_content_image']['id'] === 0) {
//								echo "<div class='eae-tl-item-image'>" . wp_get_attachment_image($item['item_content_image']['id'], $item['item_content_image_size_size']) . "</div>";
								echo "<div class='eae-tl-item-image'>" . Group_Control_Image_Size::get_attachment_image_html( $item, 'item_content_image_size' , 'item_content_image' ) . "</div>";
							} else {
								if ($settings['_skin'] == 'skin2') {
									echo "<div class='eae-tl-item-image'><img width='300px' src='" . $item['item_content_image']['url'] . "'></div>";
								}
							}
							?>
							<div class="eae-tl-content">
								<div class="eae-content-inner">
									<div class="eae-tl-item-meta-wrapper-inner">
										<?php
										if ($item['item_date'] !== '') {
										?>
											<div class="eae-tl-item-meta-inner">
												<?php
												echo $item['item_date'];
												?>
											</div>
										<?php
										}
										?>
									</div>
									<?php
									echo '<' . $item['item_title_size'] . ' class="eae-tl-item-title">' . $item['item_title_text'] . '</' . $item['item_title_size'] . '>';
									echo '<div class="eae-tl-content-innner">' . $item['item_content'] . '</div>';
									?>
								</div>
							</div>
						</div>
						<?php if (!empty($item['item_link']['url'])) {
							echo '</a>';
						} ?>
				</div>

			</div>
		<?php endforeach; ?>
		<?php
	}

	function render_post_content($settings, $helper)
	{
		$post_helper = new Post_Helper();
		$posts       = $post_helper->get_queried_posts($settings);
		if ($posts) {
		?>

			<?php
			while ($posts->have_posts()) {
				$posts->the_post();
			?>
				<div class="eae-timeline-item">
					<div <?php echo $this->parent->get_render_attribute_string('meta_wrapper'); ?>>
						<div <?php echo $this->parent->get_render_attribute_string('meta'); ?>>
							<?php echo $this->render_post_date($settings); ?>
						</div>
					</div>

					<div class="eae-tl-icon-wrapper">
						<?php
						$default_icon['icon_type'] = $this->get_instance_value('global_icon_type');
						$default_icon['icon_new']      = $this->get_instance_value('global_icon_new');
						$default_icon['icon']      = $this->get_instance_value('global_icon');
						$default_icon['image']     = $this->get_instance_value('global_icon_image');
						$default_icon['text']      = $this->get_instance_value('global_icon_text');
						$default_icon['view']      = $this->get_instance_value('global_icon_view');
						$default_icon['shape']     = $this->get_instance_value('global_icon_shape');
						$item = $settings['timeline_items'];
						echo $helper->get_icon_html($item, 'item_icon', $default_icon, $settings); ?>
					</div>
					<div class="eae-tl-content-wrapper">

						<div class="eae-tl-item-content">
							<?php
							//if ( $item['item_content_image']['id'] != "" ) {
							//$pix = wp_get_attachment_image_src( $item['item_content_image']['id'], $item['item_content_image_size_size'] );
							//echo "<div class='eae-tl-item-image'><img src='" . $pix[0] . "'></div>";
							$this->render_image($settings);
							//} else {
							//   if ( $settings['_skin'] == 'skin2' ) {
							//     echo "<div class='eae-tl-item-image'><img width='300px' src='" . $item['item_content_image']['url'] . "'></div>";
							//}
							//}
							?>
							<div class="eae-tl-content">
								<div class="eae-content-inner">
									<div class="eae-tl-item-meta-wrapper-inner">
										<div class="eae-tl-item-meta-inner">
											<?php echo $this->render_post_date($settings); ?>
										</div>
									</div>
									<?php
									$this->render_title($settings, $this);
									$this->render_content($settings, $this);
									$this->render_read_more($settings, $this);
									?>
								</div>
							</div>
						</div>
					</div>

				</div>

			<?php
			}
		}
	}

	public function render_image($settings)
	{
		global $post;
		if ($settings['show_image'] == 'yes') {
			?>
			<div class="eae-tl-item-image">
				<?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
			</div>
		<?php
		}
	}

	public function render_title($settings, $widget_base)
	{
		global $post;
		$title_html = '';
		$post_title = $post->post_title;
		if ($settings['show_title'] == 'yes') {

			if ($settings['enable_title_link'] == 'yes') {
				if ($settings['title_new_tab'] == 'yes') {
					$widget_base->parent->add_render_attribute('link-attr', 'target', '_blank');
				}
				$title_html = '<a class="eae-tl-item-title"' . $widget_base->parent->get_render_attribute_string('link-attr') . ' href="' . get_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '"
			>';
			}

			$title_html .= $post_title;

			if ($settings['enable_title_link'] == 'yes') {
				$title_html .= '</a>';
			}
			echo sprintf('<%1$s itemprop="name" class="eae-tl-item-title" %2$s>%3$s</%1$s>', $settings['html_tag'], '', $title_html);
		}
	}

	public function render_content($settings, $widget_base)
	{
		global $post;
		$post_excerpt = $post->post_excerpt;
		$post_content = $post->post_content;
		//echo '<pre>'; print_r( $settings ); die();
		if ($settings['enable_excerpt'] == 'yes') {
			if ($post_excerpt == '') {
				echo '<p>' . wp_trim_words($post_content, $settings['excerpt_size'], '...') . '</p>';
			} else {
				echo '<p>' . wp_trim_words($post_excerpt, $settings['excerpt_size'], '...') . '</p>';
			}
		}
	}

	public function render_read_more($settings, $widget_base)
	{
		global $post;
		if ($settings['enable_cta'] == 'yes') {
		?>
			<div class="eae-tl-read-more">
				<a href="<?php echo get_permalink($post->ID); ?>"><?php echo $settings['cta_text']; ?></a>
			</div>
<?php
		}
	}

	public function render_post_date($settings)
	{
		global $post;
		if ($settings['show_date'] == 'yes') {
			$format = $settings['post_date_format'];
			if ($format == 'custom') {
				$format = $settings['post_date_format_custom'];
			}
			if ($format == 'default') {
				$format = get_option('date_format');
			}
			echo get_the_date($format, $post);
		}
	}
}
