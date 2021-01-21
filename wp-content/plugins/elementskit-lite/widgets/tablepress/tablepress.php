<?php
namespace Elementor;

use \Elementor\ElementsKit_Widget_TablePress_Handler as Handler;
use \ElementsKit_Lite\Modules\Controls\Controls_Manager as ElementsKit_Controls_Manager;

if (! defined( 'ABSPATH' ) ) exit;

class ElementsKit_Widget_TablePress extends Widget_Base {
	use \ElementsKit_Lite\Widgets\Widget_Notice;

    public $base;

    public function get_name() {
        return Handler::get_name();
    }

    public function get_title() {
        return Handler::get_title();
    }

    public function get_icon() {
        return Handler::get_icon();
    }

    public function get_categories() {
        return Handler::get_categories();
    }

    public function get_help_url() {
        return '';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'ekit_tablepress_section_content_table',
            [
                'label' => esc_html__( 'Table', 'elemenetskit' ),
            ]
        );

        $this->add_control(
			'ekit_tablepress_table_id',
			[
				'label'   => esc_html__( 'Select Table', 'elemenetskit' ),
				'type'    => Controls_Manager::SELECT,
                'label_block' => 'true',
				'default' => '0',
				'options' => \ElementsKit_Lite\Utils::tablepress_table_list(),
			]
		);

        
		if (class_exists('TablePress_Responsive_Tables')) {
			$this->add_control(
				'ekit_tablepress_table_responsive',
				[
                    'label'   => __( 'Responsive', 'elemenetskit' ),
					'type'    => Controls_Manager::SELECT,
                    'default' => 'none',
                    'label_block' => 'true',
					'options' => [
                        'none'        => __( 'None', 'elemenetskit' ),
						'flip'     => __( 'Flip', 'elemenetskit' ),
						'scroll'   => __( 'Scroll', 'elemenetskit' ),
						'collapse' => __( 'Collapse', 'elemenetskit' ),
                        'stack'    => __( 'Stack', 'elemenetskit' ),
					],
				]
			);
            $this->add_control(
                'ekit_tablepress_table_responsive_breakpoint',
                [
                    'label'   => __( 'Responsive Breakpoint', 'elemenetskit' ),
                    'type'    => Controls_Manager::SELECT,
                    'label_block' => 'true',
                    'default' => 'none',
                    'options' => [
                        'none'        => __( 'None', 'elemenetskit' ),
                        'phone'     => __( 'Phone', 'elemenetskit' ),
                        'tablet'     => __( 'Tablet', 'elemenetskit' ),
                        'desktop'   => __( 'Desktop', 'elemenetskit' ),
                        'all' => __( 'All', 'elemenetskit' ),
                    ],
                    'condition' => [
                        'ekit_tablepress_table_responsive!' => 'none'
                    ]
                ]
            );
        }
            
		$this->add_responsive_control(
            'ekit_tablepress_navigation_hide',
			[
                'label'     => esc_html__( 'Nav Hide', 'elemenetskit' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_length' => 'display: none;',
				],
                ]
		);
        
		$this->add_responsive_control(
			'ekit_tablepress_search_hide',
			[
                'label'     => esc_html__( 'Search Hide', 'elemenetskit' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
                    '{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter' => 'display: none;',
				],
                ]
            );

        $this->add_responsive_control(
			'ekit_tablepress_footer_info_hide',
			[
                'label'     => esc_html__( 'Footer Info Hide', 'elemenetskit' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_info' => 'display: none;',
				],
			]
		);

		$this->add_responsive_control(
            'ekit_tablepress_pagination_hide',
            [
                'label'     => esc_html__( 'Pagination Hide', 'elemenetskit' ),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .elemenetskit-tablepress .dataTables_paginate' => 'display: none;',
                ],
            ]
        );

        $this->add_responsive_control(
            'ekit_tablepress_header_align',
            [
                'label'   => __( 'Header Alignment', 'elemenetskit' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'ekit_tablepress_body_align',
            [
                'label'   => __( 'Body Alignment', 'elemenetskit' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elemenetskit' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elemenetskit-tablepress table.tablepress tr td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'ekit_tablepress_section_style_table',
			[
				'label' => __( 'Table', 'elemenetskit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_table_text_color',
			[
				'label'     => esc_html__( 'Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_length, {{WRAPPER}} .elemenetskit-tablepress .dataTables_filter, {{WRAPPER}} .elemenetskit-tablepress .dataTables_info, {{WRAPPER}} .elemenetskit-tablepress .paginate_button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_table_border_style',
			[
				'label'   => __( 'Border Style', 'elemenetskit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'elemenetskit' ),
					'solid'  => __( 'Solid', 'elemenetskit' ),
					'double' => __( 'Double', 'elemenetskit' ),
					'dotted' => __( 'Dotted', 'elemenetskit' ),
					'dashed' => __( 'Dashed', 'elemenetskit' ),
					'groove' => __( 'Groove', 'elemenetskit' ),
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress table.tablepress' => 'border-style: {{VALUE}};',
                ],
                'condition' => [
                    'ekit_tablepress_table_border_style!' => 'none'
                ]
			]
		);

		$this->add_control(
			'ekit_tablepress_table_border_width',
			[
				'label'   => __( 'Border Width', 'elemenetskit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress table.tablepress' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ekit_tablepress_table_border_style!' => 'none'
                ]
			]
		);

		$this->add_control(
			'ekit_tablepress_table_border_color',
			[
				'label'     => __( 'Border Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress table.tablepress' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'ekit_tablepress_table_border_style!' => 'none'
                ]
			]
		);
        
        $this->add_responsive_control(
			'ekit_tablepress_table_header_tools_gap',
			[
				'label' => __( 'Pagination And Serach Gap', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_length, {{WRAPPER}} .elemenetskit-tablepress .dataTables_filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'ekit_tablepress_table_footer_tools_gap',
			[
				'label' => __( 'Footer Text And Navigation gap', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_info, {{WRAPPER}} .elemenetskit-tablepress .dataTables_paginate' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ekit_tablepress_section_style_header',
			[
				'label' => __( 'Header', 'elemenetskit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_header_background',
			[
				'label'     => __( 'Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#dfe3e6',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_header_active_background',
			[
				'label'     => __( 'Hover And Active Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccd3d8',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .sorting:hover, {{WRAPPER}} .elemenetskit-tablepress .tablepress .sorting_asc, {{WRAPPER}} .elemenetskit-tablepress .tablepress .sorting_desc' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_header_color',
			[
				'label'     => __( 'Text Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_header_border_style',
			[
				'label'   => __( 'Border Style', 'elemenetskit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'elemenetskit' ),
					'solid'  => __( 'Solid', 'elemenetskit' ),
					'double' => __( 'Double', 'elemenetskit' ),
					'dotted' => __( 'Dotted', 'elemenetskit' ),
					'dashed' => __( 'Dashed', 'elemenetskit' ),
					'groove' => __( 'Groove', 'elemenetskit' ),
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_header_border_width',
			[
				'label'   => __( 'Border Width', 'elemenetskit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ekit_tablepress_header_border_style!' => 'none'
                ]
			]
		);

		$this->add_control(
			'ekit_tablepress_header_border_color',
			[
				'label'     => __( 'Border Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'ekit_tablepress_header_border_style!' => 'none'
                ]
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_header_padding',
			[
				'label'      => __( 'Padding', 'elemenetskit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'ekit_tablepress_section_style_body',
			[
				'label' => __( 'Body', 'elemenetskit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ekit_tablepress_cell_border_style',
			[
				'label'   => __( 'Border Style', 'elemenetskit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'elemenetskit' ),
					'solid'  => __( 'Solid', 'elemenetskit' ),
					'double' => __( 'Double', 'elemenetskit' ),
					'dotted' => __( 'Dotted', 'elemenetskit' ),
					'dashed' => __( 'Dashed', 'elemenetskit' ),
					'groove' => __( 'Groove', 'elemenetskit' ),
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress td' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_cell_border_width',
			[
				'label'   => __( 'Border Width', 'elemenetskit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress td' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ekit_tablepress_cell_border_style!' => 'none'
                ]
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_cell_padding',
			[
				'label'      => __( 'Cell Padding', 'elemenetskit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0.5,
					'bottom' => 0.5,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs('ekit_tablepress_tabs_body_style');

		$this->start_controls_tab(
			'ekit_tablepress_tab_normal',
			[
				'label' => __( 'Normal', 'elemenetskit' ),
			]
		);

		$this->add_control(
			'ekit_tablepress_normal_background',
			[
				'label'     => __( 'Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .odd td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_normal_color',
			[
				'label'     => __( 'Text Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .odd td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_normal_border_color',
			[
				'label'     => __( 'Border Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .odd td' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'ekit_tablepress_cell_border_style!' => 'none'
                ]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ekit_tablepress_tab_stripe',
			[
				'label' => __( 'Stripe', 'elemenetskit' ),
			]
		);

		$this->add_control(
			'ekit_tablepress_stripe_background',
			[
				'label'     => __( 'Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f7f7f7',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .even td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_stripe_color',
			[
				'label'     => __( 'Text Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .even td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_stripe_border_color',
			[
				'label'     => __( 'Border Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .even td' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'ekit_tablepress_cell_border_style!' => 'none'
                ]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'ekit_tablepress_body_hover_background',
			[
				'label'     => __( 'Hover Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .tablepress .row-hover tr:hover td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ekit_tablepress_section_search_layout_style',
			[
				'label'      => esc_html__( 'Filter And Search', 'elemenetskit' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
				        [
							'name'  => 'ekit_tablepress_navigation_hide',
							'value' => '',
				        ],
				        [	
							'name'  => 'ekit_tablepress_search_hide',
							'value' => '',
				        ],
				    ],
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_search_icon_color',
			[
				'label'     => esc_html__( 'Color', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ekit_tablepress_search_background',
			[
				'label'     => esc_html__( 'Background', 'elemenetskit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_search_padding',
			[
				'label'      => esc_html__( 'Padding', 'elemenetskit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ekit_tablepress_search_border',
				'label'       => esc_html__( 'Border', 'elemenetskit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select',
			]
		);

		$this->add_responsive_control(
			'ekit_tablepress_search_radius',
			[
				'label'      => esc_html__( 'Radius', 'elemenetskit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ekit_tablepress_search_box_shadow',
				'selector' => '{{WRAPPER}} .elemenetskit-tablepress .dataTables_filter input, {{WRAPPER}} .elemenetskit-tablepress .dataTables_length select',
			]
		);

		$this->end_controls_section();

		$this->insert_pro_message();
    }

    private function get_shortcode() {
		$settings = $this->get_settings();

		if (!$settings['ekit_tablepress_table_id']) {
			return '<div class="elemenetskit-alert-info">'.__('Please Select A Table From Setting!', 'elemenetskit').'</div>';
		}
		
		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
			\TablePress::load_controller( 'frontend' );
			$controller = new \TablePress_Frontend_Controller();
			$controller->init_shortcodes();
		}

		$attributes = [
			'id'         => $settings['ekit_tablepress_table_id'],
            'responsive' => (class_exists('TablePress_Responsive_Tables')) ? $settings['ekit_tablepress_table_responsive'] : '',
            'responsive_breakpoint' => (class_exists('TablePress_Responsive_Tables')) ? $settings['ekit_tablepress_table_responsive_breakpoint'] : '',
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = ['<div class="elemenetskit-tablepress ekit-wid-con" id="ekit_tablepress_'.$this->get_id().'">'];
		$shortcode[] = sprintf( '[table %s]', $this->get_render_attribute_string( 'shortcode' ) );
		$shortcode[] = '</div>';

		$output = implode("", $shortcode);

		return $output;
	}

	public function render() {
		$settings = $this->get_settings();
        echo do_shortcode( $this->get_shortcode() );
        
		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) { ?>
			<script src="<?php echo plugins_url(); ?>/tablepress/js/jquery.datatables.min.js"></script>
			<script>
				jQuery(document).ready(function($){
					jQuery('#ekit_tablepress_<?php echo esc_attr($this->get_id()); ?>').find('.tablepress').dataTable();
                });
			</script>
        <?php }
	}

	public function render_plain_content() {
        echo $this->get_shortcode();
    }
    
    protected function _content_template() { }
}