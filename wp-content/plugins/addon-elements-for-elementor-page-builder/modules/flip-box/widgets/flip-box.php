<?php

namespace WTS_EAE\Modules\FlipBox\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Colors_And_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class FlipBox extends EAE_Widget_Base
{

    public function get_name()
    {
        return 'wts-flipbox';
    }

    public function get_title()
    {
        return __('EAE - Flip Box', 'wts-eae');
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
            'section_front_box',
            [
                'label' => __('Front Box', 'wts-eae')
            ]
        );



        $this->add_control(
            'front_icon_new',
            [
                'label' => __('Icon', 'wts-eae'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'front_icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'front_icon_view',
            [
                'label' => __('View', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default', 'wts-eae'),
                    'stacked' => __('Stacked', 'wts-eae'),
                    'framed' => __('Framed', 'wts-eae'),
                ],
                'default' => 'default',

            ]
        );

        $this->add_control(
            'front_icon_shape',
            [
                'label' => __('Shape', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => __('Circle', 'wts-eae'),
                    'square' => __('Square', 'wts-eae'),
                ],
                'default' => 'circle',
                'condition' => [
                    'front_icon_view!' => 'default',
                ],

            ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => __('Title', 'wts-eae'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter text', 'wts-eae'),
                'default' => __('Text Title', 'wts-eae'),
            ]
        );

        $this->add_control(
            'front_title_html_tag',
            [
                'label' => __('HTML Tag', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __('H1', 'wts-eae'),
                    'h2' => __('H2', 'wts-eae'),
                    'h3' => __('H3', 'wts-eae'),
                    'h4' => __('H4', 'wts-eae'),
                    'h5' => __('H5', 'wts-eae'),
                    'h6' => __('H6', 'wts-eae')
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'front-text',
            [
                'label' => __('Text', 'wts-eae'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter text', 'wts-eae'),
                'default' => __('Add some nice text here.', 'wts-eae'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_back_box',
            [
                'label' => __('Back Box', 'wts-eae')
            ]
        );

        $this->add_control(
            'back_icon_new',
            [
                'label' => __('Icon', 'wts-eae'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'front_icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'back_icon_view',
            [
                'label' => __('View', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default', 'wts-eae'),
                    'stacked' => __('Stacked', 'wts-eae'),
                    'framed' => __('Framed', 'wts-eae'),
                ],
                'default' => 'default',

            ]
        );

        $this->add_control(
            'back_icon_shape',
            [
                'label' => __('Shape', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => __('Circle', 'wts-eae'),
                    'square' => __('Square', 'wts-eae'),
                ],
                'default' => 'circle',
                'condition' => [
                    'back_icon_view!' => 'default',
                ],

            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => __('Title', 'wts-eae'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter text', 'wts-eae'),
                'default' => __('Text Title', 'wts-eae'),
            ]
        );

        $this->add_control(
            'back_title_html_tag',
            [
                'label' => __('HTML Tag', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __('H1', 'wts-eae'),
                    'h2' => __('H2', 'wts-eae'),
                    'h3' => __('H3', 'wts-eae'),
                    'h4' => __('H4', 'wts-eae'),
                    'h5' => __('H5', 'wts-eae'),
                    'h6' => __('H6', 'wts-eae')
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'back_text',
            [
                'label' => __('Text', 'wts-eae'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter text', 'wts-eae'),
                'default' => __('Add some nice text here.', 'wts-eae'),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section-action-button',
            [
                'label' => __('Action Button', 'wts-eae'),
            ]
        );

        $this->add_control(
            'action_text',
            [
                'label' => __('Button Text', 'wts-eae'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Buy', 'wts-eae'),
                'default' => __('Buy Now', 'wts-eae'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link to', 'wts-eae'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('http://your-link.com', 'wts-eae'),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section-general-style',
            [
                'label' => __('General', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'animation_style',
            [
                'label' => __('Animation Style', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal'                            => __('Flip Horizontal', 'wts-eae'),
                    'vertical'                              => __('Flip Vertical', 'wts-eae'),
                    'fade'                                  => __('Fade', 'wts-eae'),
                    'flipcard flipcard-rotate-top-down'     => __('Cube - Top Down', 'wts-eae'),
                    'flipcard flipcard-rotate-down-top'     => __('Cube - Down Top', 'wts-eae'),
                    //'flipcard flipcard-rotate-left-right'   => __( 'Cube - Left Right', 'wts-eae' ),
                    //'flipcard flipcard-rotate-right-left'   => __( 'Cube - Right Left', 'wts-eae' ),
                    'flip box'                              => __('Flip Box', 'wts-eae'),
                    'flip box fade'                         => __('Flip Box Fade', 'wts-eae'),
                    'flip box fade up'                      => __('Fade Up', 'wts-eae'),
                    'flip box fade hideback'                => __('Fade Hideback', 'wts-eae'),
                    'flip box fade up hideback'             => __('Fade Up Hideback', 'wts-eae'),
                    'nananana'                              => __('Nananana', 'wts-eae'),
                    ''                                      => __('Rollover', 'wts-eae'),
                ],
                'default' => 'vertical',
                'prefix_class' => 'eae-fb-animate-'
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'flip_box_border',
                'label' => __('Box Border', 'wts-eae'),
                'selector' => '{{WRAPPER}} .eae-flip-box-inner > div',
            ]
        );



        $this->add_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eae-flip-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_height',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Box Height', 'wts-eae'),
                'placeholder' => __('250', 'wts-eae'),
                'default' => __('250', 'wts-eae'),
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-inner' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}}.eae-fb-animate-flipcard .eae-flip-box-front' => 'transform-origin: center center calc(-{{VALUE}}px/2);-webkit-transform-origin:center center calc(-{{VALUE}}px/2);',
                    '{{WRAPPER}}.eae-fb-animate-flipcard .eae-flip-box-back' => 'transform-origin: center center calc(-{{VALUE }}px/2);-webkit-transform-origin:center center calc(-{{VALUE}}px/2);'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section-front-box-style',
            [
                'label' => __('Front Box', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'front_box_background',
                'label' => __('Front Box Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eae-flip-box-front',
            ]
        );


        $this->add_control(
            'front_box_title_color',
            [
                'label' => __('Title', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .front-icon-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'front_title!' => ''
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'front_box_title_typography',
                'label' => __('Title Typography', 'wts-eae'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .front-icon-title',
            ]
        );

        $this->add_control(
            'front_box_text_color',
            [
                'label' => __('Description Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-front p' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'front_box_text_typography',
                'label' => __('Description Typography', 'wts-eae'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .eae-flip-box-front p',
            ]
        );


        /**
         *  Front Box icons styles
         **/
        $this->add_control(
            'front_box_icon_color',
            [
                'label' => __('Icon Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-front .icon-wrapper i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eae-flip-box-front .icon-wrapper svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'front_box_icon_fill_color',
            [
                'label' => __('Icon Fill Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#92BE43',
                'selectors' => [
                    '{{WRAPPER}} .eae-fb-icon-view-stacked' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'front_icon_view!' => 'default',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'front_box_icon_border',
                'label' => __('Box Border', 'wts-eae'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .eae-flip-box-front .eae-fb-icon-view-framed, {{WRAPPER}} .eae-flip-box-front .eae-fb-icon-view-stacked',
                'label_block' => true,
                'condition' => [
                    'front_icon_view!' => 'default',
                ],
            ]
        );

        $this->add_control(
            'front_icon_size',
            [
                'label' => __('Icon Size', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-front .icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eae-flip-box-front .icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'front_icon_padding',
            [
                'label' => __('Icon Padding', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-front .icon-wrapper' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 1.5,
                    'unit' => 'em',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                    ],
                ],
                'condition' => [
                    'front_icon_view!' => 'default',
                ],
            ]
        );





        $this->end_controls_section();



        $this->start_controls_section(
            'section-back-box-style',
            [
                'label' => __('Back Box', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'back_box_background',
                'label' => __('Back Box Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eae-flip-box-back',
            ]
        );

        $this->add_control(
            'back_box_title_color',
            [
                'label' => __('Title', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .back-icon-title' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'back_box_title_typography',
                'label' => __('Title Typography', 'wts-eae'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .back-icon-title',
            ]
        );

        $this->add_control(
            'back_box_text_color',
            [
                'label' => __('Description Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back p' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'back_box_text_typography',
                'label' => __('Description Typography', 'wts-eae'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .eae-flip-box-back p',
            ]
        );


        /**
         *  Back Box icons styles
         **/
        $this->add_control(
            'back_box_icon_color',
            [
                'label' => __('Icon Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper svg' => 'fill: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'back_box_icon_fill_color',
            [
                'label' => __('Icon Fill Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#92BE43',
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back .eae-fb-icon-view-stacked' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'back_icon_view' => 'stacked'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'back_box_icon_border',
                'label' => __('Box Border', 'wts-eae'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .eae-flip-box-back .eae-fb-icon-view-framed, {{WRAPPER}} .eae-flip-box-back .eae-fb-icon-view-stacked',
                'label_block' => true,
                'condition' => [
                    'back_icon_view!' => 'default'
                ],
            ]
        );

        $this->add_control(
            'back_icon_size',
            [
                'label' => __('Icon Size', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'back_icon_space',
            [
                'label' => __('Icon Space', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'back_icon_padding',
            [
                'label' => __('Icon Padding', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .eae-flip-box-back .icon-wrapper' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 1.5,
                    'unit' => 'em',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                    ],
                ],
                'condition' => [
                    'back_icon_view!' => 'default',
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'section-action-button-style',
            [
                'label' => __('Action Button', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eae-fb-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __('Typography', 'wts-eae'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .eae-fb-button',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'default' => '#93C64F',
                'selectors' => [
                    '{{WRAPPER}} .eae-fb-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __('Border', 'wts-eae'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .eae-fb-button',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eae-fb-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label' => __('Text Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eae-fb-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        //echo '<pre>'; print_r($settings); echo '</pre>';
        $front_icon_migrated = isset($settings['__fa4_migrated']['front_icon_new']);
        $front_icon_is_new = empty($settings['front_icon']) && Icons_Manager::is_migration_allowed();

        $back_icon_migrated = isset($settings['__fa4_migrated']['back_icon_new']);
        $back_icon_is_new = empty($settings['back_icon']) && Icons_Manager::is_migration_allowed();;

        $this->add_render_attribute('front-icon-wrapper', 'class', 'icon-wrapper');
        $this->add_render_attribute('front-icon-wrapper', 'class', 'eae-fb-icon-view-' . $settings['front_icon_view']);
        $this->add_render_attribute('front-icon-wrapper', 'class', 'eae-fb-icon-shape-' . $settings['front_icon_shape']);
        $this->add_render_attribute('front-icon-title', 'class', 'front-icon-title');


        $this->add_render_attribute('back-icon-wrapper', 'class', 'icon-wrapper');
        $this->add_render_attribute('back-icon-wrapper', 'class', 'eae-fb-icon-view-' . $settings['back_icon_view']);
        $this->add_render_attribute('back-icon-wrapper', 'class', 'eae-fb-icon-shape-' . $settings['back_icon_shape']);
        $this->add_render_attribute('back-icon-title', 'class', 'back-icon-title');

        $this->add_render_attribute('button', 'class', 'eae-fb-button');
        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('button', $settings['link']);
        }

?>
        <div class="eae-flip-box-wrapper">
            <div class="eae-flip-box-inner" onclick="">

                <div class="eae-flip-box-front">
                    <div class="flipbox-content">
                        <?php if (!empty($settings['front_icon_new'])) { ?>
                            <div <?php echo $this->get_render_attribute_string('front-icon-wrapper'); ?>>
                                <?php if ($front_icon_migrated || $front_icon_is_new) :
                                    Icons_Manager::render_icon($settings['front_icon_new'], ['aria-hidden' => 'true']);
                                else : ?>
                                    <i class="<?php echo $settings['front_icon']; ?>"></i>
                                <?php endif; ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($settings['front_title'])) { ?>
                            <<?php echo $settings['front_title_html_tag']; ?> <?php echo $this->get_render_attribute_string('front-icon-title'); ?>>
                                <?php echo $settings['front_title']; ?>
                            </<?php echo $settings['front_title_html_tag']; ?>>
                        <?php } ?>

                        <?php if (!empty($settings['front-text'])) { ?>
                            <p>
                                <?php echo $settings['front-text']; ?>
                            </p>
                        <?php } ?>
                    </div>
                </div>

                <div class="eae-flip-box-back">
                    <div class="flipbox-content">
                        <?php if (!empty($settings['back_icon_new'])) { ?>
                            <div <?php echo $this->get_render_attribute_string('back-icon-wrapper'); ?>>
                                <?php if ($back_icon_migrated || $back_icon_is_new) :
                                    Icons_Manager::render_icon($settings['back_icon_new'], ['aria-hidden' => 'true']);
                                else : ?>
                                    <i class="<?php echo $settings['back_icon']; ?>"></i>
                                <?php endif; ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($settings['back_title'])) { ?>
                            <<?php echo $settings['back_title_html_tag']; ?> <?php echo $this->get_render_attribute_string('back-icon-title'); ?>>
                                <?php echo $settings['back_title']; ?>
                            </<?php echo $settings['back_title_html_tag']; ?>>
                        <?php } ?>

                        <?php if (!empty($settings['back_text'])) { ?>
                            <p>
                                <?php echo $settings['back_text']; ?>
                            </p>
                        <?php } ?>

                        <?php if (!empty($settings['action_text'])) { ?>
                            <div class="eae-fb-button-wrapper">
                                <a <?php echo $this->get_render_attribute_string('button'); ?>>
                                    <span class="elementor-button-text"><?php echo $settings['action_text']; ?></span>
                                </a>
                            </div>
                        <?php  }  ?>
                    </div>
                </div>

            </div>
        </div>
<?php
    }
}
//Plugin::instance()->widgets_manager->register_widget_type( new Widget_FlipBox() );