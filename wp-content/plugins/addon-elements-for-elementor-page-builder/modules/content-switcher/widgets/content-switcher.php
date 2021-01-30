<?php
namespace WTS_EAE\Modules\ContentSwitcher\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use WTS_EAE\Modules\ContentSwitcher\Skins;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
class Content_Switcher extends EAE_Widget_Base
{

    public function get_name()
    {
        return 'eae-content-switcher';
    }

    public function get_title()
    {
        return __('EAE - Content Switcher', 'wts-eae');
    }

    public function get_icon()
    {
        return 'eicon-flip-box';
    }

    public function get_categories()
    {
        return ['wts-eae'];
    }

    protected $_has_template_content = false;

    protected function _register_skins() {
        $this->add_skin(new Skins\Skin_1( $this ));
        //$this->add_skin(new Skins\Skin_2( $this ));
        $this->add_skin(new Skins\Skin_3( $this ));
        $this->add_skin(new Skins\Skin_4( $this ));
    }


    public function _register_controls(){
        $this->start_controls_section(
            'cs_skins',
            [
                'label' => __( 'Skins', 'wts-eae' ),
            ]
        );




        $this->end_controls_section();

        $this->start_controls_section(
            'content',
            [
                'label' => __( 'Content', 'wts-eae' ),
            ]
        );
        $this->add_control(
            'skin_msg',
            [
                'label' => __( '', 'plugin-name' ),
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __( 'NOTE : This Skin requires only two items.', 'wts-eae' ),
                'condition'  =>  [
                    '_skin'  =>  ['skin3','skin4'],
                ],
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'title', [
                'label' => __( 'Title', 'wts-eae' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Content1' , 'wts-eae' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'content_type', [
                'label' => __( 'Type', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options'   =>  [
                    'plain_content'   =>  __('WYSIWYG', 'wts-eae'),
                    'saved_section'     =>  __('Saved Section', 'wts-eae'),
                    'saved_page'        =>  __('Saved Page', 'wts-eae'),
                    'ae_template'       =>  __('AE-Template', 'wts-eae'),
                ],
                'default'   =>  'plain_content',
            ]
        );
        $repeater->add_control(
            'plain_content',
            [
                'label' => __( 'Type', 'wts-eae' ),
                'type' => Controls_Manager::WYSIWYG,
                'condition'  =>  [
                    'content_type'  =>  'plain_content',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'default'     => __( 'Add some nice text here.', 'wts-eae' ),
            ]
        );
        $saved_sections[''] = __( 'Select Section', 'wts-eae' );
        $saved_sections     = $saved_sections + $this->select_elementor_page( 'section' );
        $repeater->add_control(
            'saved_section',
            [
                'label' => __( 'Sections', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options'   =>  $saved_sections,
                'condition'  =>  [
                    'content_type'  =>  'saved_section',
                ],
            ]
        );
        $saved_page[''] = __( 'Select Section', 'wts-eae' );
        $saved_page     = $saved_sections + $this->select_elementor_page( 'page' );
        $repeater->add_control(
            'saved_pages',
            [
                'label' => __( 'Pages', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options'   =>  $saved_page,
                'condition'  =>  [
                    'content_type'  =>  'saved_page',
                ],
            ]
        );

        $saved_ae_template[''] = __( 'Select AE Template', 'wts-eae' );
        $saved_ae_template     = $saved_ae_template + $this->select_ae_templates();
        $repeater->add_control(
            'ae_templates',
            [
                'label' => __( 'AE-Templates', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options'   =>  $saved_ae_template,
                'condition'  =>  [
                    'content_type'  =>  'ae_template',
                ],
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'wts-eae'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $start = is_rtl() ? __( 'left', 'wts-eae' ) : __( 'Left', 'wts-eae' );
        $end = ! is_rtl() ? __( 'Right', 'wts' ) : __( 'Left', 'wts-eae' );

        $repeater->add_control(
            'icon_align',
            [
                'label'     => __('Icon Position', 'wts-eae'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left' => __('Left', 'wts-eae'),
                    'right'  => __('Right', 'wts-eae'),
                ],
            ]
        );

        $repeater->add_control(
            'active',
            [
                'label' => __( 'Active', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
                'description'   =>  __('Active on Load' , 'wts-eae'),
                'label_on' => __( 'Yes', 'wts-eae' ),
                'label_off' => __( 'No', 'wts-eae' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'content_list',
            [
                'label' => __( 'List', 'wts-eae' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'prevent_empty' =>  true,
//                'item_actions' => [
//                    'add' => false,
//                    'remove' => false,
//                    'duplicate' => false
//                ],
                'default' => [
                    [
                        'title' => __( 'Primary', 'wts-eae' ),
                        'content_type' => 'plain_content',
                        'plain_content' => __('Nam sit amet magna a ex tincidunt faucibus nec nec velit. Pellentesque posuere ac metus vitae luctus. Vivamus congue leo ut posuere consectetur. Proin mattis turpis non dignissim faucibus. Aenean iaculis urna non purus consectetur, auctor suscipit elit cursus. Ut quis vehicula ex. Ut pulvinar velit sed nulla gravida, id euismod ipsum finibus', 'wts-eae'),
                        'active'    =>  'yes',
                    ],
                    [
                        'title' => __( 'Secondary', 'wts-eae' ),
                        'content_type' => 'plain_content',
                        'plain_content' => __('Nam sit amet magna a ex tincidunt faucibus nec nec velit. Pellentesque posuere ac metus vitae luctus. Vivamus congue leo ut posuere consectetur. Proin mattis turpis non dignissim faucibus. Aenean iaculis urna non purus consectetur, auctor suscipit elit cursus. Ut quis vehicula ex. Ut pulvinar velit sed nulla gravida, id euismod ipsum finibus', 'wts-eae')
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'display',
            [
                'label' => __( 'Display Setting', 'wts-eae' ),
            ]
        );


        $this->add_responsive_control(
            'switch_align',
            [
                'label' => __( 'Switch Alignment', 'wts-eae' ),
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
                    '{{WRAPPER}} .eae-cs-switch-container' => 'text-align : {{VALUE}}'
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => __( 'Space', 'wts-eae' ),
                'description'   => __('Set Space between switcher and content section'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-switch-container' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'anim_duration',
            [
                'label' => __( 'Animation Speed', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'description'    =>  __('Set Animation Duration in Millisecond','wts-eae'),
                'min' => 100,
                'max' => 3000,
                'step' => 100,
                'default' => 400,
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-toggle-switcher:before' => 'transition-duration: {{VALUE}}ms',
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-switch-button:before' => 'transition-duration: {{VALUE}}ms',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'label_style',
            [
                'label' => __( 'Switch', 'wts-ese' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'global'    =>  [
                    'default'   => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button .eae-content-switch-label , {{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-switch-label .eae-cs-label',

            ]
        );

        $this->start_controls_tabs(
            'label_tabs'
        );

        $this->start_controls_tab(
            'label_style_normal',
            [
                'label' => __( 'Normal', 'wts-eae' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' =>  __('Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
//                'global'    =>  [
//                    'default'   =>  Global_Colors::COLOR_SECONDARY,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button .eae-content-switch-label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-switch-label' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' =>  __('Icon Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button .eae-content-switch-label i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-switch-label i' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_control(
            'title_bg_color',
            [
                'label' =>  __('Background Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
//                'global'    =>  [
//                    'default'   =>  Global_Colors::COLOR_PRIMARY,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border_normal',
                'label' => __( 'Border', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button',
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => __('Border Radius', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_box_shadow',
                'label' => __( 'Box Shadow', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button',
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'label_style_active',
            [
                'label' => __( 'Active', 'wts-eae' ),
            ]
        );

        $this->add_control(
            'title_color_active',
            [
                'label' =>  __('Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
//                'global'    =>  [
//                    'default'   =>  Global_Colors::COLOR_PRIMARY,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button.active .eae-content-switch-label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-switch-label.active' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' =>  __('Icon Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button.active .eae-content-switch-label i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-switch-label.active i' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_control(
            'title_bg_color_active',
            [
                'label' =>  __('Background Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
//                'global'    =>  [
//                    'default'   =>  Global_Colors::COLOR_ACCENT,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-layout-skin2 .eae-cs-label-wrapper .eae-content-switch-button.active' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-switch-container  .eae-cs-label-wrapper .active.eae-content-switch-button:before' => 'background-color: {{VALUE}};',
//                    '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-label-wrapper .eae-content-switch-button.active:before' => '',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );

        $this->add_control(
            'title_border_color_active',
            [
                'label' =>  __('Border Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button.active' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );

        $this->add_control(
            'button_border_radius_active',
            [
                'label'      => __('Border Radius', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_box_shadow_active',
                'label' => __( 'Box Shadow', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button.active',
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );




        $this->end_controls_tab();

        $this->end_controls_tabs();




        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __( 'Icon Spacing', 'wts-eae' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.eae-cs-icon-align-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.eae-cs-icon-align-right i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.eae-cs-icon-align-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.eae-cs-icon-align-left i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label' => __( 'Spacing', 'wts-eae' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.primary-label' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.primary-label' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.secondary-label' => 'margin-left: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .eae-cs-switch-container .eae-content-switch-label.secondary-label' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
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
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
                'separator' =>  'before',
            ]
        );

        $this->add_responsive_control(
            'button_spacing',
            [
                'label'      => __('Spacing', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-cs-label-wrapper .eae-content-switch-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' , 'skin2']
                ],
            ]
        );




        $this->add_control(
            'box_style',
            [
                'label' => __( 'Box Style', 'wts-eae' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    '_skin' =>  ['skin1']
                ],
            ]
        );

        $this->add_control(
            'title_box_bg_color',
            [
                'label' =>  __('Box Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
//                'global'    =>  [
//                    'default'   =>  Global_Colors::COLOR_PRIMARY,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-switch-wrapper' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin1']
                ],
            ]
        );
        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => __('Box Padding', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-switch-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __( 'Border', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-switch-wrapper',
                'condition' => [
                    '_skin' =>  ['skin1']
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __('Border Radius', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-cs-layout-skin1 .eae-cs-switch-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    '_skin' =>  ['skin1' ]
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'switch_bar',
            [
                'label' =>  __('Switch Bar' , 'wts-eae'),
                'tab'   =>  Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'title_section_padding',
            [
                'label'      => __('Section Padding', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_section_bg_color',
                'label' => __( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-container',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_section_border',
                'label' => __( 'Border', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-container',
            ]
        );

        $this->add_control(
            'title_section_border_radius',
            [
                'label'      => __('Border Radius', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_section_shadow',
                'label' => __( 'Box Shadow', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-container',
            ]
        );

        $this->end_controls_section();
//        Switcher Section Start
        $this->start_controls_section(
            'switch_style',
            [
                'label' => __( 'Switcher Control', 'wts-ese' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4' ]
                ],
            ]
        );
        $this->add_responsive_control(
            'handle_border_size',
            [
                'label' => __( 'Handle Border Size', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher:before' => 'border-width : {{VALUE}}px;',
                ],
//                'condition' => [
//                    '_skin' =>  ['skin3' , 'skin4']
//                ],
            ]
        );

        $this->add_responsive_control(
            'slider_border_size',
            [
                'label' => __( 'Slider Border Size', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher' => 'border-width : {{VALUE}}px;',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );
        $this->start_controls_tabs(
            'switch_style_tabs'
        );

        $this->start_controls_tab(
            'switch_style_normal_tab',
            [
                'label' => __( 'Normal', 'wts-eae' ),
            ]
        );

        $this->add_control(
            'handle_color',
            [
                'label' =>  __('Handle Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher:before' => 'background-color : {{VALUE}}',
                ],
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_ACCENT,
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );


        $this->add_control(
            'handle_border_color',
            [
                'label' =>  __('Handle Border Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher:before' => 'border-color : {{VALUE}}',
                ],
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_ACCENT,
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );
        $this->add_control(
            'slider_color',
            [
                'label' =>  __('Slider Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher' => 'background-color : {{VALUE}}',
                ],
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_SECONDARY,
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );

        $this->add_control(
            'slider_border_color',
            [
                'label' =>  __('Slider Border Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switcher' => 'border-color : {{VALUE}}',
                ],
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_SECONDARY,
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'switch_style_active_tab',
            [
                'label' => __( 'Active', 'wts-eae' ),
            ]
        );

        $this->add_control(
            'handle_color_active',
            [
                'label' =>  __('Handle Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switch:checked + .eae-content-toggle-switcher:before' => 'background-color : {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );
        $this->add_control(
            'handle_border_color_active',
            [
                'label' =>  __('Handle Border Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switch:checked + .eae-content-toggle-switcher:before' => 'border-color : {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );
        $this->add_control(
            'slider_color_active',
            [
                'label' =>  __('Slider Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switch:checked + .eae-content-toggle-switcher' => 'background-color : {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );


        $this->add_control(
            'slider_border_color_active',
            [
                'label' =>  __('Slider Border Color', 'wts-eae'),
                'type'  =>  Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-switch-wrapper .eae-content-toggle-switch:checked + .eae-content-toggle-switcher' => 'border-color : {{VALUE}}',
                ],
                'condition' => [
                    '_skin' =>  ['skin3' , 'skin4']
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->end_controls_section();

//        Switcher Section End

        $this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Content', 'wts-ese' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' =>  'before',
            ]
        );

//        $this->add_control(
//            'content_box_bg_color',
//            [
//                'label' =>  __('Box Color', 'wts-eae'),
//                'type'  =>  Controls_Manager::COLOR,
//                'selectors' => [
//                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper' => 'background-color: {{VALUE}}',
//                ],
//                'condition' => [
//                    '_skin' =>  ['skin1']
//                ],
//            ]
//        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_box_bg_color',
                'label' => __( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_box',
                'label' => __( 'Border', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper',

            ]
        );
        $this->add_control(
            'content_border_radius',
            [
                'label'      => __('Border Radius', 'wts-eae'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_box_shadow',
                'label' => __( 'Box Shadow', 'wts-eae' ),
                'selector' => '{{WRAPPER}} .eae-content-switcher-wrapper .eae-cs-content-container .eae-cs-content-wrapper',

            ]
        );


    }

    public function select_elementor_page( $type ) {
        $args  = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'elementor_library_type',
                    'field'    => 'slug',
                    'terms'    => $type,
                ),
            ),
            'post_type' => 'elementor_library',
            'posts_per_page'    => -1,
        );
        $query = new \WP_Query( $args );

        $posts = $query->posts;
        //$items['0'] = ['Select '.ucfirst($type)];


        foreach ( $posts as $post ) {
            $items[ $post->ID ] = $post->post_title;
        }

        if ( empty( $items ) ) {
            $items = [];
        }

        return $items;
    }

    private function select_ae_templates() {
        $ae_id = [];
        if(isset($_GET['post'])) {
            $ae_id = array($_GET['post']);
        }
        $args  = array(
            'post_type' => 'ae_global_templates',
            'meta_key'  => 'ae_render_mode',
            'meta_value' => 'block_layout',
            'posts_per_page'    => -1,
            'post__not_in' => $ae_id,
        );
        $query = new \WP_Query( $args );

        $posts = $query->posts;
        //$items['0'] = ['Select '.ucfirst($type)];


        foreach ( $posts as $post ) {
            $items[ $post->ID ] = $post->post_title;
        }

        if ( empty( $items ) ) {
            $items = [];
        }

        return $items;
    }

}