<?php

namespace WTS_EAE\Modules\FilterableGallery\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Utils;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class FilterableGallery extends EAE_Widget_Base
{

	public function get_name()
	{
		return 'eae-filterableGallery';
	}

	public function get_title()
	{
		return __('EAE - Filterable Gallery', 'wts-eae');
	}

	public function get_icon()
	{
		return 'eicon-flip-box wts-eae-pe';
	}

	public function get_categories()
	{
		return ['wts-eae'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'general',
			[
				'label' => __('General', 'wts-eae'),
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'eae_filter_label',
			[
				'label' => __('Filter Label', 'wts-eae'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'   =>  'Filter'
			]
		);

		$repeater->add_control(
			'eae_img_gallery',
			[
				'label' => __('Add Images', 'wts-eae'),
				'type' => Controls_Manager::GALLERY,
				'dynamic' => [
					'active' => true,
				],
				'show_label' => false,
                'render'    =>  'template',
			]
		);

		$this->add_control(
			'eae_filterable_gallery_content',
			[
				'label' => __('Items', 'wts-eae'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{eae_filter_label}}}',
				'show_label' => true,
				'default' => [
					[
						'eae_filter_label' => 'Filter1',
					],
					[
						'eae_filter_label' => 'Filter2'
					],
					[
						'eae_filter_label' => 'Filter3'
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting',
			[
				'label' => __('Setting', 'wts-eae'),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => ['custom'],
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __('Columns', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'desktop_default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'min' => 1,
				'max' => 6,
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item' => 'width: calc(100%/{{VALUE}})',
				]
			]
		);

		$this->add_control(
			'enable_image_ratio',
			[
				'label' => __('Enable Image Ratio', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label' => __('Image Ratio', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.66,
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
					'{{WRAPPER}} .eae-fg-wrapper.eae-image-ratio-yes .eae-gallery-item-inner .eae-fg-img-wrapper' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				],
				'condition' => [
					'enable_image_ratio' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'gutter',
			[
				'label' => __('Gutter', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
						'step' => 2,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item' => 'padding-left:calc({{SIZE}}{{UNIT}}/2);  padding-right:calc({{SIZE}}{{UNIT}}/2);  margin-bottom:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .eae-gallery-filter' => 'margin-left:calc({{SIZE}}{{UNIT}}/2);  margin-right:calc({{SIZE}}{{UNIT}}/2);  margin-bottom:{{SIZE}}{{UNIT}}',
				]
			]
		);


		$this->add_control(
			'show_all',
			[
				'label' => __('Show "All" Filter Tab', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'wts-eae'),
				'label_off' => __('Hide', 'wts-eae'),
				'return_value' => 'yes',
				'default' => 'yes',
				'render_type' => 'template',
				'prefix_class' => 'eae-show-all-',
			]
		);

		$this->add_control(
			'show_all_tab_text',
			[
				'label' => __('All Tab Text', 'wts-eae'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'   =>  __('All', 'wts-eae'),
				'condition' => [
					'show_all' => 'yes',
				]
			]
		);

		$this->add_control(
			'masonry',
			[
				'label' => __('Masonry', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => '',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'hover_tilt',
			[
				'label' => __('Hover Tilt', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'open_lightbox',
			[
				'label' => __('Lightbox', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'options' =>
					[
						'default' => __('Default', 'wts-eae'),
						'yes' => __('Yes', 'wts-eae'),
						'no' => __('No', 'wts-eae'),
					],
				'default' => 'no',
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'hover_scale',
			[
				'label' => __('Hover Scale', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'options' =>
					[
						'default' => __('Default', 'wts-eae'),
						'yes' => __('Yes', 'wts-eae'),
						'no' => __('No', 'wts-eae'),
					],
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'scale_value',
			[
				'label' => __('Scale Value', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => .1,
				'default' => 1.1,
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item-inner:hover img' => 'transform: scale({{VALUE}})',
				],
				'condition' => [
					'hover_scale' => 'yes',
				]

			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'tilt_setting',
			[
				'label' => __('Tilt Setting', 'wts-eae'),
				'condition' => [
					'hover_tilt' => 'yes',
				]
			]
		);
		$this->add_control(
			'max_tilt',
			[
				'label' => __('Max Tilt', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 5,
				'default' => 20,

			]
		);
		$this->add_control(
			'perspective',
			[
				'label' => __('Perspective', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'description' => __('Transform perspective, the lower the more extreme the tilt gets.', 'wts-eae'),
				'min' => 100,
				'max' => 1000,
				'step' => 50,
				'default' => 800,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __('Speed', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 50,
				'default' => 300,
			]
		);

		$this->add_control(
			'tilt_axis',
			[
				'label' => __('Tilt Axis', 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __('Both', 'wts-eae'),
					'x' => __('X', 'wts-eae'),
					'y' => __('Y', 'wts-eae'),
				],
			]
		);


		$this->add_control(
			'glare',
			[
				'label' => __('Glare', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'max_glare',
			[
				'label' => __('Glare', 'wts-eae'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => .1,
				'default' => 0.5,
				'condition' => [
					'glare' => 'yes',
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'overlay_setting',
			[
				'label' => __('Overlay Setting', 'wts-eae'),
			]
		);

		$this->add_control(
			'show_overlay',
			[
				'label' => __('Show Overlay', 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'hover' => __('On Hover', 'wts-eae'),
					'always' => __('Always', 'wts-eae'),
					'never' => __('Never', 'wts-eae'),
					'hide-on-hover' => __('Hide on Hover', 'wts-eae')
				],
				'default' => 'hover',
				'render_type' => 'template',
				'prefix_class' => 'eae-overlay-',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => __('Caption', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'condition' =>
					[
						'show_overlay!' => 'never',
					]
			]


		);


		$this->add_control(
			'icon_style',
			[
				'label' => __('Icon', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' =>
					[
						'show_overlay!' => 'never',
					]

			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __('Icon', 'wts-eae'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],

				'condition' =>
					[
						'show_overlay!' => 'never',
					]
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __('View', 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __('Default', 'wts-eae'),
					'stacked' => __('Stacked', 'wts-eae'),
					'framed' => __('Framed', 'wts-eae'),

				],
				'default' => 'framed',
				'prefix_class' => 'eae-icon-view-',
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'hover_direction_aware',
			[
				'label' => __('Hover Direction Aware', 'wts-eae'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => 'label_off',
				'condition' => [
					'show_overlay' => 'hover',
				]
			]
		);

		$this->add_control(
			'overlay_speed',
			[
				'label' => __('Overlay Speed', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '500',
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 100,
					],
				],
				'condition' => [
					'show_overlay' => 'hover',
					'hover_direction_aware' => 'yes',
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __('General', 'wts-eae'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->start_controls_tabs('style_tabs');

		$this->start_controls_tab(
			'normal',
			[
				'label' => __('Normal', 'wts-eae')
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_border',
				'label' => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-gallery-item .eae-gallery-item-inner',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label' => __('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'label' => __('Item Shadow', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner',
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'hover',
			[
				'label' => __('Hover', 'wts-eae')
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_border_hover',
				'label' => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner:hover',
			]
		);

		$this->add_control(
			'item_border_radius_hover',
			[
				'label' => __('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item-inner:hover *' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-gallery-item-inner:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow_hover',
				'label' => __('Item Shadow', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner:hover ',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		//---


		$this->start_controls_section(
			'imgae_style_section',
			[
				'label' => __('Image', 'wts-eae'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->start_controls_tabs('image_style_tabs');

		$this->start_controls_tab(
			'image_normal',
			[
				'label' => __('Normal', 'wts-eae')
			]
		);

		$this->add_control(
			'fg_image_opacity',
			[
				'label' => __('Opacity', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item-inner img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'img_css_filters',
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner img',
			]
		);


		$this->end_controls_tab();


		$this->start_controls_tab(
			'image_hover',
			[
				'label' => __('Hover', 'wts-eae')
			]
		);

		$this->add_control(
			'image_hover_opacity',
			[
				'label' => __('Opacity', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-gallery-item-inner:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'img_hover_css_filters',
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner:hover img',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//-------

		$this->start_controls_section(
			'style_section',
			[
				'label' => __('Overlay', 'wts-eae'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'overlay',
			[
				'label' => __('Overlay', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_overlay!' => 'never',
				]
			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_color',
				'label' => __('Color', 'wts-eae'),
				'types' => ['none', 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eae-gallery-item-inner .eae-grid-overlay',
				'condition' => [
					'show_overlay!' => 'never',
				],
			]
		);


		$this->add_control(
			'eae_animation',
			[
				'label' => __('Animation', 'wts-eae'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __('None', 'wts-eae'),
					'pulse' => __('Pulse', 'wts-eae'),
					'headShake' => __('Head Shake', 'wts-eae'),
					'tada' => __('Tada', 'wts-eae'),
					'fadeIn' => __('Fade In', 'wts-eae'),
					'fadeInDown' => __('Fade In Down', 'wts-eae'),
					'fadeInLeft' => __('Fade In Left', 'wts-eae'),
					'fadeInRight' => __('Fade In Right', 'wts-eae'),
					'fadeInUp' => __('Fade In Up', 'wts-eae'),
					'rotateInDownLeft' => __('Rotate In Down Left', 'wts-eae'),
					'rotateInDownRight' => __('Rotate In Down Right', 'wts-eae'),
					'rotateInUpLeft' => __('Rotate In Up Left', 'wts-eae'),
					'rotateInUpRight' => __('Rotate In Up Right', 'wts-eae'),
					'zoomIn' => __('Zoom In', 'wts-eae'),
					'zoomInDown' => __('Zoom In Down', 'wts-eae'),
					'zoomInLeft' => __('Zoom In Left', 'wts-eae'),
					'zoomInRight' => __('Zoom In Right', 'wts-eae'),
					'zoomInUp' => __('Zoom In Up', 'wts-eae'),
					'slideInLeft' => __('Slide In Left', 'wts-eae'),
					'slideInRight' => __('Slide In Right', 'wts-eae'),
					'slideInUp' => __('Slide In Up', 'wts-eae'),
					'slideInDown' => __('Slide In Down', 'wts-eae'),
				],
				'default' => 'fadeIn',
				'condition' => [
					'show_overlay' => ['hover', 'hide-on-hover'],
					'hover_direction_aware!' => 'yes',
				]
			]
		);

		$this->add_control(
			'animation_time',
			[
				'label' => __('Animation Time', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1.00
				],
				'range' => [
					'min' => 1.00,
					'max' => 10.00,
					'step' => 0.01
				],
				'condition' => [
					'animation!' => ''
				],
				'selectors' => [
					'{{WRAPPER}}.eae-grid-overlay' => 'animation-duration:{{SIZE}}s;'
				]
			]
		);

		$this->add_control(
			'caption_style',
			[
				'label' => __('Caption', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'caption' => 'yes',
				]
			]

		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __('Typography', 'wts-eae'),
				'global'    =>  [
				        'default'   =>  Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
				'selector' => '{{WRAPPER}} .eae-overlay-caption',
				'condition' => [
					'caption' => 'yes',
				]
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => __('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-caption' => 'color:{{VALUE}};'
				],
				'global'    =>  [
				        'default'   =>  Global_Colors::COLOR_PRIMARY,
                ],
				'condition' => [
					'caption' => 'yes',
				]
			]
		);

		$this->add_control(
			'caption_color_hover',
			[
				'label' => __('Hover Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-caption:hover' => 'color:{{VALUE}};'
				],
				'condition' => [
					'caption' => 'yes',
				]
			]
		);


		$this->add_control(
			'icon_overlay_style',
			[
				'label' => __('Icon', 'wts-eae'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',
				],

			]

		);

		$this->add_control(
			'primary_color',
			[
				'label' => __('Primary Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-stacked .eae-overlay-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-overlay-icon, {{WRAPPER}}.eae-icon-view-default .eae-overlay-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-overlay-icon svg, {{WRAPPER}}.eae-icon-view-default .eae-overlay-icon svg' => 'fill : {{VALUE}};',
				],
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_PRIMARY,
                ],
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',

				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __('Secondary Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-framed .eae-overlay-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked .eae-overlay-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked .eae-overlay-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'icon!' => '',
					'view!' => 'default',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'primary_color_hover',
			[
				'label' => __('Primary Color Hover', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-stacked .eae-overlay-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-overlay-icon:hover, {{WRAPPER}}.eae-icon-view-default .eae-overlay-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-overlay-icon:hover svg, {{WRAPPER}}.eae-icon-view-default  .eae-overlay-icon:hover svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',
				],

			]
		);

		$this->add_control(
			'secondary_color_hover',
			[
				'label' => __('Secondary Color Hover', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
					'show_overlay!' => 'never',
				],
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-framed:hover .eae-overlay-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked:hover .eae-overlay-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked:hover .eae-overlay-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __('Size', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'default' => [
					'size' => '20',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eae-overlay-icon svg' => 'width : {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __('Icon Padding', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
					'show_overlay!' => 'never',
				],

			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __('Rotate', 'wts-eae'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-icon i , {{WRAPPER}} .eae-overlay-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'icon!' => '',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __('Border Width', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eae-overlay-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
					'show_overlay!' => 'never',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_style_section',
			[
				'label' => __('Filter', 'wts-eae'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_typography',
				'label' => __('Typography', 'wts-eae'),

                'global'    =>  [
                    'default'   =>  Global_Typography::TYPOGRAPHY_ACCENT
                ],
				'selector' => '{{WRAPPER}} .eae-filter-label',
			]
		);
		$this->start_controls_tabs('filter_style_tabs');

		$this->start_controls_tab(
			'filter_normal',
			[
				'label' => __('Normal', 'wts-eae')
			]
		);

		$this->add_control(
			'filter_color',
			[
				'label' => __('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'current_filter_color',
			[
				'label' => __('Current Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'filter_bg_color',
			[
				'label' => __('Background Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_ACCENT,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'current_filter_bg_color',
			[
				'label'     => __('Current Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    =>  [
				        'default'   =>  Global_Colors::COLOR_PRIMARY,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label.current' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'filter-border',
				'label' => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-filter-label',
			]
		);

		$this->add_control(
			'filter_border_current_color',
			[
				'label' => __('Current Border Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label.current' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'filter_border_box_shadow',
				'label' => __( 'Box Shadow', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .eae-filter-label',
			]
		);


		$this->add_control(
			'filter_border_radius',
			[
				'label' => __('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'filter_hover',
			[
				'label' => __('Hover', 'wts-eae')
			]
		);

		$this->add_control(
			'filter_hover_color',
			[
				'label' => __('Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'current_filter_hover_color',
			[
				'label' => __('Current Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'filter_bg_hover_color',
			[
				'label' => __('Background Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'current_filter_bg_hover_color',
			[
				'label' => __('Current Background Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover.current' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'filter_border_hover_color',
			[
				'label' => __('Border Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'filter_border_current_hover_color',
			[
				'label' => __('Current Border Color', 'wts-eae'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover.current' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'filter_border_box_shadow_hover',
				'label' => __( 'Box Shadow', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .eae-filter-label:hover',
			]
		);

		$this->add_control(
			'filter_border_hover_radius',
			[
				'label' => __('Border Radius', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'filter_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' =>  [
					'{{WRAPPER}} .eae-gallery-filter' => 'justify-content : {{VALUE}}'
				],
				'default' => 'center',
				'toggle' => true,
			]
		);

		$this->add_responsive_control(
			'filter_padding',
			[
				'label' => __('Padding', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'filter_margin',
			[
				'label' => __('Spacing', 'wts-eae'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eae-filter-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '10',
					'left' => '',
					'unit' => 'px',
					'isLinked' => '',
				],
			]
		);


		$this->end_controls_section();


	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		//echo '<pre>'; print_r($settings); echo '</pre>';
		$max_tilt    = $settings['max_tilt'];
		$perspective = $settings['perspective'];
		$speed       = $settings['speed'];
		$tilt_axis   = $settings['tilt_axis'];
		$glare       = $settings['glare'];
		$max_glare   = $settings['max_glare'];
		$animation   = $settings['eae_animation'];
		if($settings['show_overlay'] != 'never') {
            $icon = $settings['icon']['value'];
        }
        if($settings['hover_direction_aware'] == 'yes'){
            $overlay_speed = $settings['overlay_speed']['size'];
        }

		$filter_groups = $settings['eae_filterable_gallery_content'];
		//echo '<pre>'; print_r($filter_groups); echo '</pre>';

		$this->add_render_attribute('gallery-wrapper', 'class', 'eae-fg-wrapper');
		if ($settings['hover_tilt'] == 'yes') {
			$this->add_render_attribute('gallery-wrapper', 'class', 'eae-tilt-yes');
			$this->add_render_attribute('gallery-wrapper', 'data-maxtilt', $max_tilt);
			$this->add_render_attribute('gallery-wrapper', 'data-perspective', $perspective);
			$this->add_render_attribute('gallery-wrapper', 'data-speed', $speed);
			$this->add_render_attribute('gallery-wrapper', 'data-tilt-axis', $tilt_axis);
			$this->add_render_attribute('gallery-wrapper', 'data-glare', $glare);
			if ($glare == 'yes') {
				$this->add_render_attribute('gallery-wrapper', 'data-max-glare', $max_glare);
			}
		}
		if ($settings['masonry'] == 'yes') {
			$this->add_render_attribute('gallery-wrapper', 'class', 'masonry-yes');
		}
		if ($settings['hover_direction_aware'] == 'yes' && $settings['show_overlay'] == 'hover') {
			$this->add_render_attribute('gallery-wrapper', 'class', 'eae-hover-direction-effect');
			$this->add_render_attribute('gallery-wrapper', 'data-overlay-speed', $overlay_speed);
		}
		if ($settings['enable_image_ratio'] == 'yes') {
			$this->add_render_attribute('gallery-wrapper', 'class', 'eae-image-ratio-' . $settings['enable_image_ratio']);
		}

		if($settings['open_lightbox'] === 'yes'){
			$this->add_render_attribute('link', [
				'data-elementor-open-lightbox' => $settings['open_lightbox'],
				'data-elementor-lightbox-slideshow' => 'eae-fg-gallery-' . rand(0, 99999),
			]);
		}else{
			$this->add_render_attribute('link', [
				'data-elementor-open-lightbox' => 'no',
			]);
		}

		if (Plugin::$instance->editor->is_edit_mode()) {
			$this->add_render_attribute('link', [
				'class' => 'elementor-clickable',
			]);
		}

		?>
        <div <?php echo $this->get_render_attribute_string('gallery-wrapper'); ?>>
            <div class="eae-gallery-filter">
				<?PHP if ($settings['show_all'] == 'yes' && count($settings['eae_filterable_gallery_content']) > 1) { ?>
                    <a href="#" data-filter="*" data-filter-name="all" class="eae-filter-label current"><?php echo $settings['show_all_tab_text']; ?></a>
				<?php } ?>
				<?php
				if (count($settings['eae_filterable_gallery_content']) > 1) {
					//echo '<pre>'; print_r($filter_groups); echo '</pre>';
					$demo_images = [];
					if( empty($filter_group[0]['eae_img_gallery']) && empty($filter_group[1]['eae_img_gallery']) && empty($filter_group[0]['eae_img_gallery']) ){
						$demo_images[] = $this->get_placeholder_images();
//						echo '<pre>'; print_r($demo_images); echo '</pre>';
					}
					foreach ($filter_groups as $filter_group) {
						$images = $filter_group['eae_img_gallery'];
						if(empty($images)){
							//echo '<pre>'; print_r($demo_images); echo '</pre>';
							$images = $demo_images;
						}
						if (!empty($images)) {
							$filter_label = $filter_group['eae_filter_label'];
							$filter_name  = strtolower($filter_group['eae_filter_label']);
							$filter_name  = str_replace(" ", "-", $filter_name);
							//$filter_group['eae_filter_class'];
							?>
                            <a href="#" data-filter=".<?php echo $filter_name; ?>"
                               class="eae-filter-label" data-filter-name="<?php echo $filter_name; ?>"> <?php echo $filter_label; ?></a>
							<?php
						}
					}
				}
				?>
            </div>
            <div class="eae-fg-image">
				<?php
				foreach ($filter_groups as $filter_group) {
					$images = $filter_group['eae_img_gallery'];
					if(empty($images)){
						//echo '<pre>'; print_r($demo_images); echo '</pre>';
						$images = $demo_images;
					}
					$filter_name = strtolower($filter_group['eae_filter_label']);
					$filter_name = str_replace(" ", "-", $filter_name);
					$this->add_render_attribute('gallery-item-' . $filter_group['_id'], 'class', 'eae-gallery-item');
					$this->add_render_attribute('gallery-item-' . $filter_group['_id'], 'class', $filter_name);
					if ($settings['hover_tilt'] == 'yes') {
						$this->add_render_attribute('gallery-item-' . $filter_group['_id'], 'class', 'el-tilt');
					}
					if (!empty($images)) {
						foreach ($images as $image) {
							$image_url=wp_get_attachment_image_url($image['id'],$settings['thumbnail_size']);
							?>
                            <div <?php echo $this->get_render_attribute_string('gallery-item-' . $filter_group['_id']); ?>>
                                <div class="eae-gallery-item-inner">
                                    <a href="<?php echo $image_url; ?>" <?php echo $this->get_render_attribute_string('link'); ?>>
										<?php if ($settings['enable_image_ratio'] == 'yes'){ ?>
                                        <div class="eae-fg-img-wrapper">
											<?php } ?>
											<?php if(!empty($image['id'])){
												$img = wp_get_attachment_image($image['id'], $settings['thumbnail_size']);
												echo $img;
											}else{?>
                                                <img src="<?php echo $image['url']; ?>">
											<?php }

											?>
											<?php if ($settings['enable_image_ratio'] == 'yes'){ ?>
                                        </div>
									<?php } ?>
                                        <?php if($settings['show_overlay'] != 'never'){?>
                                            <div class="eae-grid-overlay <?php echo $animation ?>">
                                                <div class="eae-grid-overlay-inner">
                                                    <div class="eae-icon-wrapper">
                                                        <?php if (!empty($icon)) { ?>
                                                            <div class="eae-overlay-icon">
                                                                <?php
                                                                Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                    $caption = wp_get_attachment_caption($image['id']);
                                                    if (!empty($caption) && $settings['caption'] == 'yes') { ?>
                                                        <div class="eae-overlay-caption"><?php echo $caption; ?></div>
                                                    <?php } ?>
                                                </div>
                                        </div>
                                        <?php } ?>
                                    </a>
                                </div>
                            </div>
						<?php }
					}
				}
				?>
            </div>
        </div>
		<?php

	}

	public function get_placeholder_images(){
		$demo_images =
			[
				'id'    =>  0,
				'url'   =>  Utils::get_placeholder_image_src(),
			];
		return $demo_images;
	}
}