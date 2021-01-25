<?php
namespace WTS_EAE\Modules\PriceTable\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
//use Elementor\Core\Kits\Controls\Repeater;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PriceTable extends EAE_Widget_Base {

	public function get_name() {
		return 'wts-pricetable';
	}

	public function get_title() {
		return __( 'EAE - Price Table', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-price-table wts-eae-pe';

	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Plan Heading', 'wts-eae' )
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter plan name', 'wts-eae' ),
				'default' => __( 'Plan 1', 'wts-eae' ),
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label' => __( 'Heading HTML Tag', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'wts-eae' ),
					'h2' => __( 'H2', 'wts-eae' ),
					'h3' => __( 'H3', 'wts-eae' ),
					'h4' => __( 'H4', 'wts-eae' ),
					'h5' => __( 'H5', 'wts-eae' ),
					'h6' => __( 'H6', 'wts-eae' )
				],
				'default' => 'h2',
			]
		);


		$this->add_control(
			'sub-heading',
			[
				'label' => __( 'Sub Heading', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter plan name', 'wts-eae' ),
				'default' => __( 'Plan 1', 'wts-eae' ),
			]
		);

		$this->add_control(
			'sub_heading_tag',
			[
				'label' => __( 'Sub Heading HTML Tag', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'wts-eae' ),
					'h2' => __( 'H2', 'wts-eae' ),
					'h3' => __( 'H3', 'wts-eae' ),
					'h4' => __( 'H4', 'wts-eae' ),
					'h5' => __( 'H5', 'wts-eae' ),
					'h6' => __( 'H6', 'wts-eae' ),
					'p' => __( 'P', 'wts-eae' )
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_box',
			[
				'label' => __( 'Price Box', 'wts-eae' )
			]
		);


		$this->add_control(
			'price-box-text',
			[
				'label' => __( 'Price Box Text', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( '$100', 'wts-eae' ),
				'default' => __( '$100', 'wts-eae' ),
			]
		);


		$this->add_control(
			'price-box-subtext',
			[
				'label' => __( 'Price Box Sub Text', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'per month', 'wts-eae' ),
				'default' => __( 'per month', 'wts-eae' ),
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'None', 'wts-eae' ),
					'circle' => __( 'Circle', 'wts-eae' ),
					'square' => __( 'Square', 'wts-eae' ),
				],
				'default' => 'circle',
				'prefix_class' => 'eae-pt-price-box-shape-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features',
			[
				'label' => __( 'Features', 'wts-eae' )
			]

		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Text', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => __( 'Plan Features', 'wts-eae' ),
				'default' => __( 'Feature 1', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'available',
			[
				'label' => __( 'Included', 'wts-eae' ),
				'type' => Controls_Manager::SWITCHER,
				'label_block' => true,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'feature-list',
			[
				'label' => __( 'Plan Features', 'wts-eae' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'List Item #1', 'wts-eae' ),
						'available' => 'yes'
					],
					[
						'text' => __( 'List Item #2', 'wts-eae' ),
						'available' => 'yes'
					],
					[
						'text' => __( 'List Item #3', 'wts-eae' ),
						'available' => 'yes'
					],
				],

				'title_field' => '{{{ text }}}'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_action_button',
			[
				'label' => __( 'Action Button', 'wts-eae' )
			]
		);

		$this->add_control(
			'action_text',
			[
				'label' => __( 'Button Text', 'wts-eae' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Buy', 'wts-eae' ),
				'default' => __( 'Buy Now', 'wts-eae' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'wts-eae' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'http://your-link.com', 'wts-eae' ),
				'separator' => 'before',
			]
		);

//        $this->add_control(
//			'icon',
//			[
//				'label' => __( 'Icon', 'wts-eae' ),
//				'type' => Controls_Manager::ICON,
//				'label_block' => true,
//				'default' => 'fa fa-shopping-cart',
//			]
//		);

		$this->add_control(
			'icon_new',
			[
				'label' => __( 'Icon', 'wts-eae' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-shopping-cart',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'wts-eae' ),
					'right' => __( 'After', 'wts-eae' ),
				],

			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'default'   =>  [
					'unit'  =>  'px',
					'size'  =>  5,
				],

				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button .eae-pt-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eae-pt-action-button .eae-pt-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);





		$this->end_controls_section();


		$this->start_controls_section(
			'section-box-style',
			[
				'label' => __( 'Box Style', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box-color',
			[
				'label' => __( 'Box Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#93C64F',
                'selectors' => [
					'{{WRAPPER}} .wts-price-box-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => __( 'Box Border', 'wts-eae' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .wts-price-box-wrapper',
			]
		);


		$this->add_control(
			'box-border-radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wts-price-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wts-price-box-wrapper > div:first-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .wts-price-box-wrapper > div:last-child' => 'border-radius: 0 0  {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_box_shadow',
				'selector' => '{{WRAPPER}} .wts-price-box-wrapper',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'section-plan-heading-style',
			[
				'label' => __( 'Plan Heading', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'plan_heading_color',
			[
				'label' => __( 'Heading Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
                'selectors' => [
					'{{WRAPPER}} .eae-pt-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'plan_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-pt-heading',
			]
		);

		$this->add_control(
			'plan_sub_heading_color',
			[
				'label' => __( 'Sub Heading Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
				'selectors' => [
					'{{WRAPPER}} .eae-pt-sub-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'plan_sub_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-pt-sub-heading',
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'heading_section_bg',
				'label' => __( 'Section Background', 'wts-eae' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .heading-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section-price-box',
			[
				'label' => __( 'Price Box', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pb_content_settings',
			[
				'label' => __( 'Content Settings', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_text_color',
			[
				'label' => __( 'Price Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
				'selectors' => [
					'{{WRAPPER}} .plan-price-shape-inner .price-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_text_typography',
				'selector' => '{{WRAPPER}} .plan-price-shape-inner .price-text',
			]
		);


		$this->add_control(
			'price_sub_text_color',
			[
				'label' => __( 'Sub Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
				'selectors' => [
					'{{WRAPPER}} .plan-price-shape-inner .price-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_sub_text_typography',

				'selector' => '{{WRAPPER}} .plan-price-shape-inner .price-subtext',
			]
		);

		$this->add_control(
			'pb_box_settings',
			[
				'label' => __( 'Box Settings', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'price_box_border',
				'label' => __( 'Price Box Border', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .plan-price-shape',
			]
		);

		$this->add_control(
			'price_box_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .plan-price-shape' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'price_box_padding',
			[
				'label' => __( 'Price Box Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .plan-price-shape-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'price_box_section_bg',
				'label' => __( 'Section Background', 'wts-eae' ),
				'types' => [ 'classic' ,'gradient'],
				'selector' => '{{WRAPPER}} .plan-price-block',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section-features-style',
			[
				'label' => __( 'Feature List', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_text_color',
			[
				'label' => __( 'Features Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
				'selectors' => [
					'{{WRAPPER}} .eae-pt-feature-list li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'features_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-pt-feature-list li',
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'feature_section_bg',
				'label' => __( 'Section Background', 'wts-eae' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .plan-features-wrapper',
			]
		);

		$this->add_responsive_control(
			'feature_align',
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
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .plan-features-wrapper .eae-pt-feature-list' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'feature_padding',
			[
				'label' => __( 'Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .plan-features-wrapper .eae-pt-feature-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section-action-button',
			[
				'label' => __( 'Action Button', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button-section-bg',
			[
				'label' => __( 'Section Background', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .eae-pt-button-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-pt-action-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'wts-eae' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .eae-pt-action-button',
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#93C64F',
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'action_section_bg',
				'label' => __( 'Section Background', 'wts-eae' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .eae-pt-button-wrapper',
				'default' => [
					'background' => 'classic',
					'color'      => '#555'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'wts-eae' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .eae-pt-action-button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_hover',
			[
				'label' => __( 'Button Hover', 'wts-eae' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-pt-action-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-pt-action-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render( ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('heading','class','eae-pt-heading');
		$this->add_render_attribute('sub_heading','class','eae-pt-sub-heading');
		$this->add_render_attribute('button','class','eae-pt-action-button');
		$this->add_render_attribute( 'icon-align', 'class', 'eae-pt-align-icon-' . $settings['icon_align'] );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );

			if ( ! empty( $settings['link']['is_external'] ) ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		$icon_migrated = isset( $settings['__fa4_migrated']['icon_new'] );
		$icon_is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();


		?>
        <div class="wts-price-box-wrapper">
		<?php
		if(!empty($settings['heading']) || !empty($settings['heading'])) {
			?>
            <div class="heading-wrapper">
			<?php if(!empty($settings['heading'])){
				?>
                <<?php echo $settings['heading_tag']; ?> <?php echo $this->get_render_attribute_string('heading'); ?>>
				<?php echo $settings['heading']; ?>
                </<?php echo $settings['heading_tag'] ?>>
				<?php
			} ?>

			<?php if(!empty($settings['sub-heading'])){
				?>
                <<?php echo $settings['sub_heading_tag']; ?> <?php echo $this->get_render_attribute_string('sub_heading'); ?>>
				<?php echo $settings['sub-heading']; ?>
                </<?php echo $settings['sub_heading_tag'] ?>>
				<?php
			} ?>
            </div>
			<?php
		}

		if(!empty($settings['price-box-text']) || !empty($settings['price-box-subtext'])){
			?>
            <div class="plan-price-block">
                <div class="plan-price-shape">
                    <div class="plan-price-shape-inner">
						<?php if(!empty($settings['price-box-text'])){ ?>
                            <span class="price-text"><?php echo $settings['price-box-text']; ?></span>
						<?php } ?>

						<?php if(!empty($settings['price-box-subtext'])){ ?>
                            <span class="price-subtext"><?php echo $settings['price-box-subtext']; ?></span>
						<?php } ?>
                    </div>
                </div>
            </div>

			<?php
		}

		if(count($settings['feature-list'])){
			?>
            <div class="plan-features-wrapper">
                <ul class="eae-pt-feature-list">
					<?php
					foreach($settings['feature-list'] as $feature){
						?>
                        <li class="<?php echo ($feature['available'] == 'yes')? '':'strike-feature'; ?>"><?php echo $feature['text']; ?></li>
						<?php
					}
					?>
                </ul>
            </div>
			<?php
		}

		if(!empty($settings['action_text'])){
			?>
            <div class="eae-pt-button-wrapper">
                <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                    <span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
                        <?php if ( !empty( $settings['icon_new'] ) ) : ?>
                            <span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
                               <?php if ( $icon_migrated || $icon_is_new ) :
	                               Icons_Manager::render_icon($settings['icon_new'], ['aria-hidden' => 'true']);
                               else : ?>
                                   <i class="<?php echo $settings['icon']; ?>"></i>
                               <?php endif; ?>
                            </span>
                        <?php endif; ?>
                        <span class="elementor-button-text"><?php echo $settings['action_text']; ?></span>
                    </span>
                </a>
            </div>
			<?php
		}
		?>
        </div> <!-- close .wts-price-box-wrapper -->
		<?php
	}

	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'icon_new' );
	}

}
//Plugin::instance()->widgets_manager->register_widget_type( new Widget_PriceTable() );