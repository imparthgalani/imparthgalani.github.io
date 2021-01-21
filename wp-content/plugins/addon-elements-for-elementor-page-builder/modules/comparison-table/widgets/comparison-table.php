<?php

namespace WTS_EAE\Modules\ComparisonTable\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ComparisonTable extends EAE_Widget_Base
{
	public function get_name()
	{
		return 'eae-comparisontable';
	}

	public function get_title()
	{
		return __('EAE - Comparison Table', 'wts-eae');
	}

	public function get_icon()
	{
		return 'eae-icons eae-compare-table';
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
			'table_count',
			[
				'label'       => __('Plan', 'wts-eae'),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 2,
				'min'         => 2,
				'max'         => 10,
				'placeholder' => __('Tables', 'wts-eae'),
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_legend',
			[
				'label' => __('Feature Box', 'wts-eae')
			]
		);

		$this->add_control(
			'feature_box_heading',
			[
				'label'       => __('Heading', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __('Add Heading Here', 'wts-eae'),
			]
		);


		$this->add_control(
			'show_tooltip',
			[
				'label'        => __('Enable Tooltip', 'wts-eae'),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'tooltip_type',
			[
				'label'        => __('Type', 'wts-eae'),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'link' => __('Link', 'wts-eae'),
					'icon' => __('Icon', 'wts-eae'),
				],
				'default'      => 'icon',
				'prefix_class' => 'eae-ct-tt-type-',
				'render_type'  => 'template',
				'condition'    => [
					'show_tooltip' => 'yes'
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'legend_feature_text',
			[
				'label'       => __('Feature', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => 'feature',
				'placeholder' => __('Enter your feature', 'wts-eae'),
			]
		);
		$repeater->add_control(
			'legend_feature_tooltip_text',
			[
				'label'       => __('Tooltip', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Tooltip Text', 'wts-eae'),
			]
		);

		$this->add_control(
			'features_text',
			[
				'label'      => __('Features', 'wts-eae'),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'default'    => [
					[
						'legend_feature_text' => __('Bandwidth', 'wts-eae'),
					],
					[
						'legend_feature_text' => __('Space', 'wts-eae'),
					],
					[
						'legend_feature_text' => __('Domain', 'wts-eae'),
					],
				],
				'fields'     =>  $repeater->get_controls(),
			]
		);
		$this->end_controls_section();

		$this->add_tables();
	}

	function add_tables()
	{

		$repeater = new Repeater();

		$repeater->add_control(
			'table_content_type',
			[
				'label'       => __('Content', 'wts-eae'),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'fa fa-check' => [
						'title' => __('Yes', 'wts-eae'),
						'icon'  => 'fa fa-check',
					],
					'fa fa-close' => [
						'title' => __('No', 'wts-eae'),
						'icon'  => '
						fa fa-close',
					],
					'text'        => [
						'title' => __('Text', 'wts-eae'),
						'icon'  => 'fa fa-font',
					]
				],
				'default'     => 'text',
			]
		);
		$repeater->add_control(
			'feature_text',
			[
				'label'       => __('Feature', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => __('Feature', 'wts-eae'),
				'placeholder' => __('Enter your feature', 'wts-eae'),
				'condition'   => [
					'table_content_type' => 'text'
				]
			]
		);
		for ($i = 1; $i < 11; $i++) {
			$this->start_controls_section(
				'section_table_' . $i,
				[
					'label'     => __('Plan ' . $i, 'wts-eae'),
					'operator'  => '>',
					'condition' => [
						'table_count' => $this->add_condition_value($i),
					]
				]
			);
			$this->add_control(
				'table_title_' . $i,
				[
					'label'       => __('Title', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('Our Plan', 'wts-eae'),
					'placeholder' => __('Enter table title', 'wts-eae'),
				]
			);
			$this->add_control(
				'table_currency_symbol_' . $i,
				[
					'label'       => __('Currency Symbol', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('$', 'wts-eae'),
					'placeholder' => __('$', 'wts-eae'),
				]
			);
			$this->add_control(
				'table_price_' . $i,
				[
					'label'       => __('Price', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('39.99', 'wts-eae'),
					'placeholder' => __('Enter table title', 'wts-eae'),
				]
			);
			$this->add_control(
				'table_offer_discount_' . $i,
				[
					'label'        => __('Offering Discount', 'wts-eae'),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'table_original_price_' . $i,
				[
					'label'       => __('Original Price', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('49.99', 'wts-eae'),
					'placeholder' => __('Enter table title', 'wts-eae'),
					'condition'   => [
						'table_offer_discount_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'table_duration_' . $i,
				[
					'label'       => __('Duration', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('/year', 'wts-eae'),
					'placeholder' => __('Enter table title', 'wts-eae'),
				]
			);

			$this->add_control(
				'table_ribbon_' . $i,
				[
					'label'        => __('Ribbon', 'wts-eae'),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			$this->add_control(
				'table_ribbon_text_' . $i,
				[
					'label'       => __('Ribbon Text', 'wts-eae'),
					'type'        => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default'     => __('Popular', 'wts-eae'),
					'placeholder' => __('Popular', 'wts-eae'),
					'condition'   => [
						'table_ribbon_' . $i => 'yes',
					]
				]
			);

			$this->add_control(
				'ribbons_position_' . $i,
				[
					'label'       => __('Position', 'wts-eae'),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
						'left'  => [
							'title' => __('Left', 'wts-eae'),
							'icon'  => 'eicon-h-align-left',
						],
						'top'   => [
							'title' => __('Top', 'wts-eae'),
							'icon'  => 'eicon-v-align-top',
						],
						'right' => [
							'title' => __('Right', 'wts-eae'),
							'icon'  => 'eicon-h-align-right',
						]
					],
					'default'     => 'left',
					'condition'   => [
						'table_ribbon_' . $i => 'yes'
					]
				]
			);

			$this->add_control(
				'button_text_' . $i,
				[
					'label'   => __('Button Text', 'wts-eae'),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => 'Buy Now'
				]
			);
			$this->add_control(
				'item_link_' . $i,
				[
					'label'   => __('Link', 'wts-eae'),
					'type'    => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url'         => '#',
						'is_external' => '',
					],

				]
			);

			$this->add_control(
				'feature_items_' . $i,
				[
					'label'      => __('Features', 'wts-eae'),
					'type'       => Controls_Manager::REPEATER,
					'show_label' => true,
					'default'    => [
						[
							'feature_text' => __('25GB', 'wts-eae'),
						],
						[
							'feature_text' => __('5GB', 'wts-eae'),
						],
						[
							'feature_text' => __('1', 'wts-eae'),
						],
					],
					'fields'     =>  $repeater->get_controls(),
				]
			);


			$this->add_control(
				'override_style_' . $i,
				[
					'label'        => __('Override Style', 'wts-eae'),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'before'
				]
			);

			$this->add_control(
				'custom__heading_' . $i,
				[
					'label'     => __('Heading', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'heading_text_color_custom_' . $i,
				[
					'label'     => __('Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default'   =>  Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . '.eae-ct-heading' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'heading_text_bg_color_custom_' . $i,
				[
					'label'     => __('Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . '.eae-ct-heading' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);

			$this->add_control(
				'active_tab_color_custom_' . $i,
				[
					'label'     => __('Active Tab Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default'   =>  Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . '.eae-ct-heading.active' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);

			$this->add_control(
				'active_tab_bg_color_custom_' . $i,
				[
					'label'     => __('Active Tab BG Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . '.eae-ct-heading.active' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_o_price_heading_' . $i,
				[
					'label'     => __('Original Price', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'override_style_' . $i       => 'yes',
						'table_offer_discount_' . $i => 'yes'
					]
				]
			);
			$this->add_control(
				'custom_o_price_color_' . $i,
				[
					'label'     => __('Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default'   =>  Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-price-wrapper .eae-ct-original-price' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i       => 'yes',
						'table_offer_discount_' . $i => 'yes'
					]
				]
			);
			$this->add_control(
				'custom_o_price_line_color_' . $i,
				[
					'label'     => __('Line Through Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default'   =>  Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-price-wrapper .eae-ct-original-price' => 'text-decoration-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i       => 'yes',
						'table_offer_discount_' . $i => 'yes'
					]
				]
			);
			$this->add_control(
				'custom_price_heading_' . $i,
				[
					'label'     => __('Price', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_currency_color_' . $i,
				[
					'label'     => __('Currency Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-price-wrapper .eae-ct-currency' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_price_color_' . $i,
				[
					'label'     => __('Price Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-price-wrapper .eae-ct-price' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_fractional_color_' . $i,
				[
					'label'     => __('Fractional Part Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-price-wrapper .eae-ct-fractional-price' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_duration_color_' . $i,
				[
					'label'     => __('Duration Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i . ' .eae-ct-duration' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_price_bg_color_' . $i,
				[
					'label'     => __('Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-plan.eae-table-' . $i => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_table_Items_' . $i,
				[
					'label'     => __('Features', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_table_item_color_' . $i,
				[
					'label'     => __('Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} td.eae-table-' . $i . '.eae-ct-txt' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'features_tbl_check_color_' . $i,
				[
					'label'     => __('Check Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-wrapper td.eae-table-' . $i . ' i.fa.fa-check' => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-ct-wrapper td.eae-table-' . $i . ' i.fas.fa-check' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'features_tbl_close_color_' . $i,
				[
					'label'     => __('Close Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-ct-wrapper td.eae-table-' . $i . ' i.fa.fa-close' => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-ct-wrapper td.eae-table-' . $i . ' i.fas.fa-times' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_table_item_bg_color_' . $i,
				[
					'label'     => __('Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} td.eae-table-' . $i . '.eae-ct-txt' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_ribbon_heading_' . $i,
				[
					'label'     => __('Ribbon', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'override_style_' . $i => 'yes',
						'table_ribbon_' . $i   => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_ribbon_text_color_' . $i,
				[
					'label'     => __('Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} th.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'color: {{VALUE}};',
						'{{WRAPPER}} th.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
						'table_ribbon_' . $i   => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_ribbon_bg_color_' . $i,
				[
					'label'     => __('Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} th.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} li.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} th.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'background-color: {{VALUE}};',
						'{{WRAPPER}} li.eae-table-' . $i . '.eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
						'table_ribbon_' . $i   => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_button_heading_' . $i,
				[
					'label'     => __('Button', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_button_text_color_' . $i,
				[
					'label'     => __('Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . ' .eae-ct-btn' => 'color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);
			$this->add_control(
				'custom_button_bg_color_' . $i,
				[
					'label'     => __('Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-table-' . $i . ' .eae-ct-btn' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);

			$this->add_control(
				'custom_btn_clm_background_color_' . $i,
				[
					'label'     => __('Column Background Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} tr:last-child td.eae-table-' . $i => 'background-color: {{VALUE}}; border-color:{{VALUE}}',
					],
					'condition' => [
						'override_style_' . $i => 'yes',
					]
				]
			);

			$this->end_controls_section();
		}

		$this->start_controls_section(
			'feature_button',
			[
				'label' => __('Button', 'wts-eae')
			]
		);

		$this->add_control(
			'button_heading_text',
			[
				'label' =>  __('Heading', 'wts-eae'),
				'type'  =>  Controls_Manager::TEXT
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __('General', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'odd_color',
			[
				'label'     => __('Odd Row Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(even)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'even_color',
			[
				'label'     => __('Even Row Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(odd)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'table_border',
				'label'       => __('Border', 'wts-eae'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
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
						'default' => '#DDD',
					]
				],
				'selector'    => '{{WRAPPER}} .eae-ct-wrapper table tr:first-child td, {{WRAPPER}} .eae-ct-wrapper table tr:last-child td, {{WRAPPER}} .eae-ct-wrapper td,{{WRAPPER}} .eae-ct-wrapper td,{{WRAPPER}} .eae-ct-wrapper th',
				'label_block' => true,
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'section_feature_style',
			[
				'label' => __('Feature Box', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_text_bg_color',
			[
				'label'     => __('Primary Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} tbody tr:nth-child(odd) .eae-ct-feature' => 'background-color: {{VALUE}};',
				],
			]
		);

		//		$this->add_control(
		//			'feature_odd_color',
		//			[
		//				'label'     => __( 'Odd Row Color', 'wts-eae' ),
		//				'type'      => Controls_Manager::COLOR,
		//				'selectors' => [
		//					'{{WRAPPER}} tbody tr:nth-child(odd) .eae-ct-feature' => 'background-color: {{VALUE}};',
		//				],
		//			]
		//		);

		$this->add_control(
			'feature_even_color',
			[
				'label'     => __('Secondary Row Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody tr:nth-child(even) .eae-ct-feature' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_text_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-ct-feature',
			]
		);

		$this->add_responsive_control(
			'feature_text_align',
			[
				'label'     => __('Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					]
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature' => 'text-align: {{VALUE}};',
				]
			]
		);
		$this->add_responsive_control(
			'feature_text_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_box_heading_style',
			[
				'label'     => __('Heading', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'feature_box_heading!' => ''
				]
			]
		);

		$this->add_control(
			'feature_heading_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'default'   =>  '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-header .eae-fbox-heading' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody tr .eae-ct-hide.eae-fbox-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
					'feature_box_heading!' => ''
				]
			]
		);
		$this->add_control(
			'feature_heading_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-header .eae-fbox-heading' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} tbody tr .eae-ct-hide.eae-fbox-heading' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'feature_box_heading!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_heading_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .eae-ct-header .eae-fbox-heading , {{WRAPPER}} tbody tr .eae-ct-hide.eae-fbox-heading',
			]
		);


		$this->add_control(
			'tooltip_icon_heading',
			[
				'label'     => __('Tooltip Icon', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);
		$this->add_control(
			'tooltip_icon_size',
			[
				'label'     => __('Size', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature .eae-icon-view-stacked i' => 'font-size: {{SIZE}}px',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'feature_tooltip_icon_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature .eae-icon-view-stacked i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);
		$this->add_control(
			'feature_tooltip_icon_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature .eae-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);
		$this->add_control(
			'feature_tooltip_icon_hover_color',
			[
				'label'     => __('Hover Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature .tooltip:hover .eae-icon-view-stacked i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);
		$this->add_control(
			'feature_tooltip_icon_bg_hover_color',
			[
				'label'     => __('Hover Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-feature .tooltip:hover .eae-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'tooltip_icon_padding',
			[
				'label'     => __('Padding', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper .eae-icon' => 'padding: {{SIZE}}px',
				],
				'condition' => [
					'tooltip_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'tooltip_Text_heading',
			[
				'label'     => __('Tooltip Text', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'feature_tooltip_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper .tooltip .tooltiptext' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'feature_tooltip_text_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper .tooltip .tooltiptext'         => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-wrapper .tooltip .tooltiptext::before' => 'border-top-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'Tooltip_text_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .eae-ct-wrapper .tooltip .tooltiptext',
			]
		);

		$this->add_responsive_control(
			'feature_tooltip_text_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-wrapper .tooltip .tooltiptext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon_style',
			[
				'label' => __('Ribbon', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'eae_ribbon_distance',
			[
				'label'     => __('Distance', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'ribbon_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'eae_ribbons_typography',
				'selector' => '{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner,{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ribbon_border',
				'label'    => __('Box Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner, {{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top',
			]
		);
		$this->add_responsive_control(
			'ribbon_text_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper span.eae-ct-ribbons-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'                       => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => __('Heading', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_format',
			[
				'label'        => __('Tab Format', 'wts-eae'),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'all'     => __('All', 'wts-eae'),
					'tab-mob' => __('Tablet & Mobile', 'wts-eae'),
					'mobile'  => __('Mobile', 'wts-eae'),
				],
				'default'      => 'mobile',
				'prefix_class' => 'eae-tab-format-',
			]
		);
		$this->add_responsive_control(
			'eae_th_height',
			[
				'label'     => __('Height', 'wts-eae'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-heading' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'active_tab_color',
			[
				'label'     => __('Active Tab Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-heading.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-heading' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'heading_text_color_active',
			[
				'label'     => __('Active Tab Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .active.eae-ct-heading' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'heading_text_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-heading' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_text_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-ct-heading',
			]
		);
		$this->add_responsive_control(
			'heading_text_align',
			[
				'label'     => __('Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					]
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-heading' => 'text-align: {{VALUE}};',
				]
			]
		);
		$this->add_responsive_control(
			'heading_text_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			[
				'label' => __('Price', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'original_heading',
			[
				'label' => __('Original Price', 'wts-eae'),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'original_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-original-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'line_through_text_color',
			[
				'label'     => __('Text Decoration Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-original-price' => 'text-decoration-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'original_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-original-price',
			]
		);
		$this->add_control(
			'original_align',
			[
				'label'       => __('Vertical Alignment', 'wts-eae'),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'flex-end',
				'label_block' => false,
				'options'     => [
					'flex-start' => [
						'title' => __('Top', 'wts-eae'),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => __('Bottom', 'wts-eae'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],

				'selectors' => [
					'{{WRAPPER}} .eae-ct-original-price' => 'align-self: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'currency_heading',
			[
				'label'     => __('Currency', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'currency_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-currency' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'currency_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-currency',
			]
		);
		$this->add_control(
			'currency_align',
			[
				'label'       => __('Vertical Alignment', 'wts-eae'),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'flex-start',
				'label_block' => false,
				'options'     => [
					'flex-start' => [
						'title' => __('Top', 'wts-eae'),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => __('Bottom', 'wts-eae'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],

				'selectors' => [
					'{{WRAPPER}} .eae-ct-currency' => 'align-self: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'price_heading',
			[
				'label'     => __('Price', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'price_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-price',
			]
		);
		$this->add_control(
			'fractional_heading',
			[
				'label'     => __('Fractional', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'fractional _text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-fractional-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'fractional_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-fractional-price',
			]
		);
		$this->add_control(
			'fractional_align',
			[
				'label'       => __('Vertical Alignment', 'wts-eae'),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'flex-start',
				'label_block' => false,
				'options'     => [
					'flex-start' => [
						'title' => __('Top', 'wts-eae'),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => __('Bottom', 'wts-eae'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],

				'selectors' => [
					'{{WRAPPER}} .eae-ct-fractional-price' => 'align-self: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'duration_heading',
			[
				'label'     => __('Duration', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'duration_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-duration' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'duration_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-duration',
			]
		);

		$this->add_control(
			'price_text_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-plan' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_text_align',
			[
				'label'     => __('Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center'     => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'flex-end'   => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					]
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-price-wrapper  ' => 'justify-content: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'add_responsive_control',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-plan' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_text_style',
			[
				'label' => __('Features', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_tbl_text_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-txt' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'features_tbl_check_color',
			[
				'label'     => __('Check Icon Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper i.fa.fa-check' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-wrapper i.fas.fa-check' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'features_tbl_close_color',
			[
				'label'     => __('Close Icon Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper i.fa.fa-close' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-wrapper i.fas.fa-times' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_tbl_text_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-txt' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'Feature_tbl_text_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .eae-ct-txt',
			]
		);

		$this->add_responsive_control(
			'feature_tbl_text_align',
			[
				'label'     => __('Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					]
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-txt' => 'text-align: {{VALUE}};',
				]
			]
		);
		$this->add_responsive_control(
			'feature_tbl_text_padding',
			[
				'label'      => __('Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => __('Button', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_heading_style',
			[
				'label'     => __('Heading', 'wts-eae'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_heading_text!' => ''
				]
			]
		);

		$this->add_control(
			'button_heading_color',
			[
				'label'     => __('Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'default'   =>  '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper .eae-ct-button-heading' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-wrapper .eae-button-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_heading_text!' => ''
				]
			]
		);
		$this->add_control(
			'button_heading_bg_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default'   =>  Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-ct-wrapper .eae-ct-button-heading' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .eae-ct-wrapper .eae-button-heading' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_heading_text!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_heading_typography',
				'global'    => [
					'default'   =>  Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'{{WRAPPER}} .eae-ct-wrapper .eae-ct-button-heading' => 'color: {{VALUE}};',
				'condition' => [
					'button_heading_text!' => ''
				]
			]
		);

		$this->start_controls_tabs(
			'button_style_tabs'
		);

		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => __('Normal', 'wts-eae'),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __('Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_background_color',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#61ce70',
				'selectors' => [
					'{{WRAPPER}} .eae-ct-btn' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => __('Hover', 'wts-eae'),
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label'     => __('Text Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_background_color_hover',
			[
				'label'     => __('Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-ct-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'btn_clm_background_color',
			[
				'label'     => __('Column Background Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:last-child td' => 'background-color: {{VALUE}}; border-color:{{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_text_typography',
				'label'    => __('Typography', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-btn',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'btn_text_shadow',
				'label'    => 'Text Shadow',
				'selector' => '{{WRAPPER}} .eae-ct-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'btn_box_shadow',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .eae-ct-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'btn_border',
				'label'    => __('Border', 'wts-eae'),
				'selector' => '{{WRAPPER}} .eae-ct-btn',
			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label'      => __('Border Radius', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-ct-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .eae-ct-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	function add_condition_value($j)
	{
		$value = [];
		for ($i = $j; $i < 11; $i++) {
			$value[] = $i;
		}

		return $value;
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('eae-ct-wrapper', 'class', 'eae-ct-wrapper');
		if ($settings['feature_box_heading'] == '') {
			$this->add_render_attribute('eae-ct-wrapper', 'class', 'feature-heading-blank');
		}
		if ($settings['button_heading_text'] == '') {
			$this->add_render_attribute('eae-ct-wrapper', 'class', 'button-heading-blank');
		}
?>
		<article <?php echo $this->get_render_attribute_string('eae-ct-wrapper'); ?>>

			<ul>
				<?php
				for ($i = 1; $i <= $settings['table_count']; $i++) {
					if ($settings['table_ribbon_' . $i] == 'yes') {
						echo '<li class="eae-ct-heading eae-table-' . $i . ' eae-ct-ribbons-yes eae-ct-ribbons-h-' . $settings['ribbons_position_' . $i] . '">';
						if ($settings['ribbons_position_' . $i] == 'top') {
				?>
							<div class="eae-ct-ribbons-wrapper-top">
								<span class="eae-ct-ribbons-inner-top">
									<?php echo $settings['table_ribbon_text_' . $i] ?>
								</span>
							</div>
						<?php
						} else {
						?>
							<div class="eae-ct-ribbons-wrapper">
								<span class="eae-ct-ribbons-inner">
									<?php echo $settings['table_ribbon_text_' . $i] ?>
								</span>
							</div>

				<?php
						}
					} else {
						echo '<li class="eae-ct-heading eae-table-' . $i . '">';
					}
					echo '<div class="eae-ct-heading-inner">';
					echo $settings['table_title_' . $i];
					echo '</div>';
					echo '</li>';
				}
				?>
			</ul>

			<table>
				<tbody>
					<tr class="eae-ct-header">
						<?php
						$class = 'hide';
						$cont = "";
						$rowspan = "";
						if (!empty($settings['feature_box_heading'])) {
							$rowspan = 2;
							$class   = "eae-fbox-heading";
							$cont    = $settings['feature_box_heading'];
						} ?>

						<td class="<?php echo $class; ?>" rowspan="<?php echo $rowspan; ?>"> <?php echo $cont; ?></td>
						<?php

						for ($i = 1; $i <= $settings['table_count']; $i++) {
							if ($settings['table_ribbon_' . $i] == 'yes') {
								echo '<td class="eae-ct-heading eae-ct-ribbons-yes eae-ct-ribbons-h-' . $settings['ribbons_position_' . $i] . ' eae-table-' . $i . '">';
								if ($settings['ribbons_position_' . $i] == 'top') {
						?>
									<div class="eae-ct-ribbons-wrapper-top">
										<span class="eae-ct-ribbons-inner-top">
											<?php echo $settings['table_ribbon_text_' . $i] ?>
										</span>
									</div>
								<?php
								} else {
								?>
									<div class="eae-ct-ribbons-wrapper">
										<span class="eae-ct-ribbons-inner">
											<?php echo $settings['table_ribbon_text_' . $i] ?>
										</span>
									</div>

						<?php
								}
							} else {
								echo '<td class="eae-ct-heading eae-table-' . $i . '">';
							}
							echo $settings['table_title_' . $i];
							echo '</td>';
						}
						?>
					</tr>
					<?php
					echo '<tr>';
					$cls = "hide";
					if (!empty($settings['feature_box_heading'])) {
						$cls = "hide eae-ct-hide eae-fbox-heading";
					} ?>
					<td class="<?php echo $cls; ?>"><?php echo $settings['feature_box_heading']; ?></td>
					<?php
					for ($j = 1; $j <= $settings['table_count']; $j++) {
						echo '<td class="eae-ct-plan eae-table-' . $j . '"><div class="eae-ct-price-wrapper">';

						if ($settings['table_offer_discount_' . $j] == 'yes') {
							echo '<span class="eae-ct-original-price">';
							echo $settings['table_currency_symbol_' . $j] . $settings['table_original_price_' . $j];
							echo '</span>';
						}

						$price            = explode('.', $settings['table_price_' . $j]);
						$fractional_price = '';
						if (count($price) > 1) {
							$fractional_price = '<span class="eae-ct-fractional-price">' . $price[1] . '</span>';
						}
						echo '<span class="eae-ct-currency">' . $settings['table_currency_symbol_' . $j] . '</span>';
						echo '<span class="eae-ct-price">' . $price[0] . '</span>';
						echo $fractional_price;
						echo '</div>';
						echo '<span class="eae-ct-duration">' . $settings['table_duration_' . $j] . '</span>';
						echo '</td>';
					}
					echo '</tr>';

					for ($x = 1; $x <= count($settings['features_text']); $x++) {
						echo '<tr>';
						echo '<td  class="eae-ct-feature">';

						if ($settings['features_text'][$x - 1]['legend_feature_tooltip_text'] !== '' && $settings['show_tooltip'] == 'yes') {

							if ($settings['tooltip_type'] !== 'icon') {
								echo '<div class="tooltip">';
								echo '<span class="eae-ct-heading-tooltip">';
							} else {
								echo '<span>';
							}
							echo $settings['features_text'][$x - 1]['legend_feature_text'];
							echo '</span>';
							if ($settings['tooltip_type'] == 'icon') {
					?>
								<div class="tooltip">
									<div class="eae-icon eae-icon-view-stacked eae-icon-shape-circle eae-icon-type-icon">
										<div class="eae-icon-wrap">
											<i class="fa fa-info"></i>
										</div>
									</div>
								<?php
							}
								?>
								<span class="tooltiptext">
									<?php
									echo $settings['features_text'][$x - 1]['legend_feature_tooltip_text'];
									?>
								</span>
								</div>
						<?php
						} else {
							echo $settings['features_text'][$x - 1]['legend_feature_text'];
						}
						echo '</td>';

						for ($j = 1; $j <= $settings['table_count']; $j++) {
							echo '<td class="eae-ct-txt eae-table-' . $j . '">';
							if (count($settings['feature_items_' . $j]) >= $x) {
								if ($settings['feature_items_' . $j][$x - 1]['table_content_type'] !== 'text') {
									if ($settings['feature_items_' . $j][$x - 1]['table_content_type'] == 'fa fa-close') {
										$icon  = array(
											'value' =>  'fas fa-times',
											'library'   =>  'solid'
										);
									} else {
										$icon  = array(
											'value' =>  'fas fa-check',
											'library'   =>  'solid'
										);
									}
									Icons_Manager::render_icon($icon);

									//echo '<i class="' . $icon . '"></i>';
								} else {
									echo $settings['feature_items_' . $j][$x - 1]['feature_text'];
								}
							} else {
								echo '';
							}
							echo '</td>';
						}
						echo '</tr>';
					}
					if (!empty($settings['button_heading_text'])) {
						$this->add_render_attribute('button_heading', 'class', 'eae-button-heading');
					}
					echo '<td ' .  $this->get_render_attribute_string("button_heading")  . '>' . $settings['button_heading_text'] . '</td>';
					for ($j = 1; $j <= $settings['table_count']; $j++) {

						if (!empty($settings['item_link_' . $j]['url'])) {
							$this->add_link_attributes('button_' . $j . '-link-attributes', $settings['item_link_' . $j]);
						}
						$this->add_render_attribute('button_' . $j . '-link-attributes', 'class', 'eae-ct-btn');
						// $this->add_render_attribute('button_' . $j . '-link-attributes', 'href', $settings['item_link_' . $j]['url']);
						// $this->add_render_attribute('button_' . $j . '-link-attributes', 'class', 'eae-ct-btn');

						// if ($settings['item_link_' . $j]['is_external'] == 'on') {
						// 	$this->add_render_attribute('button_' . $j . '-link-attributes', 'target', '_blank');
						// }
						// if ($settings['item_link_' . $j]['nofollow']) {
						// 	$this->add_render_attribute('button_' . $j . '-link-attributes', 'rel', 'nofollow');
						// }

						echo '<td class="eae-table-' . $j . '">';
						if ($settings['button_text_' . $j] !== '') {
							echo '<a ' . $this->get_render_attribute_string('button_' . $j . '-link-attributes') . '>' . $settings['button_text_' . $j] . '</a>';
						}
						echo '</td>';
					}
						?>
				</tbody>
			</table>
		</article>
	<?php
	}

	protected function _content_template()
	{
	?>
		<# view.addRenderAttribute( 'eae-ct-wrapper' , 'class' , 'eae-ct-wrapper' ); if(settings['feature_box_heading']=='' ){ view.addRenderAttribute( 'eae-ct-wrapper' , 'class' , 'feature-heading-blank' ); } if(settings['button_heading_text']=='' ){ view.addRenderAttribute( 'eae-ct-wrapper' , 'class' , 'button-heading-blank' ); } #>
			<article {{{ view.getRenderAttributeString('eae-ct-wrapper') }}}>
				<ul>
					<# for ( var i=1; i <=settings.table_count; i++ ) { if ( settings['table_ribbon_' + i ]=='yes' ) { view.addRenderAttribute( 'heading_' + i, 'class' , 'eae-ct-heading' ); view.addRenderAttribute( 'heading_' + i, 'class' , 'eae-table-' + i ); view.addRenderAttribute( 'heading_' + i, 'class' , 'eae-ct-ribbons-yes' ); view.addRenderAttribute( 'heading_' + i, 'class' , 'eae-ct-ribbons-h-' + settings['ribbons_position_' + i ] ); } if ( settings['table_ribbon_' + i ]=='yes' ) { #>
						<li {{{ view.getRenderAttributeString(
                'heading_' + i ) }}}>
							<# if ( settings['ribbons_position_' + i ]=='top' ) { #>
								<div class="eae-ct-ribbons-wrapper-top">
									<span class="eae-ct-ribbons-inner-top">
										{{{ settings['table_ribbon_text_'  + i ] }}}
									</span>
								</div>
								<# } else { #>
									<div class="eae-ct-ribbons-wrapper">
										<span class="eae-ct-ribbons-inner">
											{{{ settings['table_ribbon_text_'  + i ] }}}
										</span>
									</div>

									<# } } else{ #>
						<li class="eae-ct-heading eae-table-" {{{i}}}>
							<# } #>
								<div class="eae-ct-heading-inner">
									{{{ settings['table_title_' + i ] }}}
								</div>
						</li>
						<# } #>
				</ul>
				<table>
					<tbody>
						<tr class="eae-ct-header">
							<# var cont='' ; view.addRenderAttribute( 'feature_heading' , 'class' , 'hide' ); view.addRenderAttribute( 'feature_heading' , 'rowspan' , null ); if (settings['feature_box_heading'] !='' ) { var cls='eae-fbox-heading' ; var cont=settings['feature_box_heading'] ; var rowspan=2; view.addRenderAttribute( 'feature_heading' , 'class' , 'eae-fbox-heading' ); view.addRenderAttribute( 'feature_heading' , 'rowspan' , '2' ); } #>
								<td {{{ view.getRenderAttributeString('feature_heading') }}}> {{{cont}}}</td>
								<# for ( var i=1; i <=settings.table_count; i++ ) { if ( settings[ 'table_ribbon_' + i ]=='yes' ) { view.addRenderAttribute( 'heading_inn_' + i, 'class' , 'eae-ct-heading' ); view.addRenderAttribute( 'heading_inn_' + i, 'class' , 'eae-ct-ribbons-yes' ); view.addRenderAttribute( 'heading_inn_' + i, 'class' , 'eae-ct-ribbons-h-' + settings['ribbons_position_' + i ] ); view.addRenderAttribute( 'heading_inn_' + i, 'class' , 'eae-table-' + i ); #>
									<td {{{ view.getRenderAttributeString('heading_inn_' + i ) }}}>
										<# if ( settings[ 'ribbons_position_' + i ]=='top' ) { #>
											<div class="eae-ct-ribbons-wrapper-top">
												<span class="eae-ct-ribbons-inner-top">
													{{{ settings[ 'table_ribbon_text_' + i ] }}}
												</span>
											</div>
											<# } else { #>
												<div class="eae-ct-ribbons-wrapper">
													<span class="eae-ct-ribbons-inner">
														{{{ settings[ 'table_ribbon_text_' + i ] }}}
													</span>
												</div>

												<# } #>
													<# } else { #>
									<td class="eae-ct-heading eae-table-{{{ i }}}">
										<# } #>
											{{{ settings[ 'table_title_' + i ] }}}
									</td>
									<# } #>
						</tr>
						<tr>
							<# var cls='hide' ; view.addRenderAttribute( 'fet_heading' , 'class' , 'hide' ); if (settings['feature_box_heading'] !='' ) { view.addRenderAttribute( 'fet_heading' , 'class' , ['hide eae-ct-hide eae-fbox-heading'] ); var cls='hide eae-ct-hide eae-fbox-heading' ; } #>

								<td {{{view.getRenderAttributeString('fet_heading') }}}> {{{settings['feature_box_heading']}}}</td>
								<# for ( var j=1; j <=settings.table_count; j++ ) { #>
									<td class="eae-ct-plan eae-table-{{{ j }}}">
										<div class="eae-ct-price-wrapper">

											<# if ( settings[ 'table_offer_discount_' + j ]=='yes' ) { #>
												<span class="eae-ct-original-price">
													{{{ settings[ 'table_currency_symbol_' + j ] + settings[ 'table_original_price_' + j ] }}}
												</span>
												<# } var price=settings[ 'table_price_' + j].split("."); var fractional_price='' ; if ( price.length> 1 ) {

													fractional_price = '<span class="eae-ct-fractional-price">' + price[1] + '</span>';
													}
													#>
													<span class="eae-ct-currency"> {{{ settings[ 'table_currency_symbol_' + j ] }}} </span>
													<span class="eae-ct-price"> {{{ price[0] }}} </span>
													{{{ fractional_price }}}
										</div>
										<span class="eae-ct-duration"> {{{ settings[ 'table_duration_' + j ] }}} </span>
									</td>
									<# } #>
						</tr>

						<# for ( var x=1; x <=settings['features_text'].length; x++ ) { #>
							<tr>
								<td class="eae-ct-feature">
									<# if ( settings['features_text'][ x - 1 ]['legend_feature_tooltip_text'] !=='' && settings['show_tooltip']=='yes' ) { if ( settings['tooltip_type'] !=='icon' ) { #>
										<div class="tooltip">
											<span class="eae-ct-heading-tooltip">
												<# } else { #>
													<span>
														<# }#>
															{{{ settings['features_text'][ x - 1 ]['legend_feature_text'] }}}
													</span>
													<# if ( settings['tooltip_type']=='icon' ) { #>
														<div class="tooltip">
															<div class="eae-icon eae-icon-view-stacked eae-icon-shape-circle eae-icon-type-icon">
																<div class="eae-icon-wrap">
																	<i class="fa fa-info"></i>
																</div>
															</div>
															<# } #>
																<span class="tooltiptext">
																	{{{ settings['features_text'][ x - 1 ]['legend_feature_tooltip_text'] }}}
																</span>
														</div>
														<# } else { #>
															{{{ settings['features_text'][ x - 1 ]['legend_feature_text'] }}}
															<# } #>
											</span>
											<# for ( var j=1; j <=settings['table_count']; j++ ) { #>
								<td class="eae-ct-txt eae-table-{{{ j }}}">
									<# if ( settings[ 'feature_items_' + j ].length>= x ) {
										if ( settings[ 'feature_items_' + j ][ x - 1 ]['table_content_type'] !== 'text' ) {
										if ( settings[ 'feature_items_' + j ][ x - 1 ]['table_content_type'] == 'fa fa-close' ){
										var icon = 'fas fa-times';
										}else{
										var icon = 'fas fa-check';
										}
										#>
										<i class=" {{{ icon }}}"></i>
										<# } else { #>
											{{{ settings[ 'feature_items_' + j ][ x - 1 ]['feature_text'] }}}
											<# } } else { #>
												<# } #>
								</td>
								<# } #>
							</tr>
							<# } #>
								<# var button_heading='' ; if(settings['button_heading_text'] !='' ){ view.addRenderAttribute( 'button_heading' , 'class' , 'eae-ct-button-heading' ); button_heading=settings['button_heading_text'] } #>
									<td {{{ view.getRenderAttributeString( 'button_heading' ) }}}> {{{ button_heading }}} </td>
									<# for ( j=1; j <=settings['table_count']; j++ ) { view.addRenderAttribute( 'button_' + j + '-link-attributes' , 'href' , settings[ 'item_link_' + j ]['url'] ); view.addRenderAttribute( 'button_' + j + '-link-attributes' , 'class' , 'eae-ct-btn' ); if ( settings[ 'item_link_' + j ]['is_external']=='on' ) { view.addRenderAttribute( 'button_' + j + '-link-attributes' , 'target' , '_blank' ); } if ( settings[ 'item_link_' + j ]['nofollow'] ) { view.addRenderAttribute( 'button_' + j + '-link-attributes' , 'rel' , 'nofollow' ); } #>
										<td class="eae-table-{{{ j }}}">
											<# if ( settings[ 'button_text_' . j ] !=='' ) { #>
												<a {{{ view.getRenderAttributeString( 'button_' + j + '-link-attributes' ) }}}> {{{ settings[ 'button_text_' + j ] }}} </a>
												<# } #>
										</td>
										<# } #>
					</tbody>
				</table>
			</article>
	<?php
	}
}
