<?php

namespace WTS_EAE\Modules\InfoCircle\Skins;

use Elementor\Core\Kits\Documents\Tabs\Colors_And_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use WTS_EAE\Plugin;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Elementor\Repeater;
use WTS_EAE\Controls\Group\Group_Control_Icon;
use WTS_EAE\Classes\Helper;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

abstract class Skin_Base extends Elementor_Skin_Base
{

	protected function _register_controls_actions()
	{
		add_action('elementor/element/eae-info-circle/ic_skins/before_section_end', [$this, 'register_controls']);
		add_action('elementor/element/eae-info-circle/ic_skins/after_section_end', [$this, 'register_common_controls']);
		add_action('elementor/element/eae-info-circle/ic_skins/after_section_end', [$this, 'register_style_controls']);
	}

	public function register_controls(Widget_Base $widget)
	{
		$this->parent = $widget;

		$this->add_control(
			'global_icon_heading',
			[
				'label' => __('Global Icon', 'wts-eae'),
				'type'  => Controls_Manager::HEADING,
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
					'text'  => [
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
		//				'default'   => 'fa fa-star',
		//				'condition' => [
		//					$this->get_control_id('global_icon_type')  => 'icon'
		//				]
		//			]
		//		);

		$this->add_control(
			'global_icon_new',
			[
				'label' => __('Icon', 'wts-eae'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => $this->get_control_id('global_icon'),
				'default' => [
					'value' => 'fas fa-star',
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
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'condition' => [
					$this->get_control_id('global_icon_type') => 'image'
				],
			]
		);

		$this->add_control(
			'global_icon_text',
			[
				'label'       => __('Text', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => false,
				'condition'   => [
					$this->get_control_id('global_icon_type')  => 'text'
				]
			]
		);

		$this->add_control(
			'global_icon_view',
			[
				'label'     => __('View', 'wts-eae'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default' => __('Default', 'wts-eae'),
					'stacked' => __('Stacked', 'wts-eae'),
					'framed'  => __('Framed', 'wts-eae'),
				],
				'default'   => 'framed',
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
					$this->get_control_id('global_icon_view!')      => 'default',
				]
			]
		);
	}

	public function register_common_controls(Widget_Base $widget)
	{
	}
	public function register_style_controls()
	{
	}
	function common_render()
	{
		$settings = $this->parent->get_settings_for_display();
		//echo '<pre>'; print_r($settings); echo '</pre>';
		//die('dfadf');
		$helper = new Helper();

?>
		<div class="eae-info-circle-wrapper">
			<div class="eae-info-circle" data-active-item="1" data-autoplay="<?php echo $this->get_instance_value('ic_content_auto_change') ?>" data-delay="<?php echo $this->get_instance_value('ic_change_duration') ?>" style="opacity: 1;">
				<?php foreach ($settings['info_circle_items'] as $index => $item) : ?>
					<?php //echo '<pre>'; print_r($item); echo '</pre>'; 
					?>
					<div class="eae-info-circle-item elementor-repeater-item-<?php echo $item['_id'] ?>" style="opacity: 1;">
						<div id="<?php echo $item['_id'] ?>" data-id="<?php echo $item['_id'] ?>" class="eae-ic-icon-wrap" style="opacity: 1;">
							<?php $this->render_icon($item, $settings); ?>
						</div>
						<div class="eae-info-circle-item__content-wrap">
							<div class="eae-info-circle-item__content">
								<h3 class="eae-ic-heading"><?php echo $item['ic_item_title']; ?></h3>
								<div class="eae-ic-description">
									<p><?php echo $item['ic_item_content']; ?></p>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
<?php
	}

	function render_icon($item, $settings)
	{

		$helper = new Helper();
		$default_icon['icon_new']  = $this->get_instance_value('global_icon_new');
		$default_icon['icon']      = $this->get_instance_value('global_icon');
		$default_icon['icon_type'] = $this->get_instance_value('global_icon_type');
		$skin =     $settings['_skin'];
		$default_icon['image']     = $settings[$skin . '_global_icon_image'];
		$default_icon['text']      = $this->get_instance_value('global_icon_text');
		$default_icon['view']      = $this->get_instance_value('global_icon_view');
		$default_icon['shape']     = $this->get_instance_value('global_icon_shape');
		//		echo '<pre>'; print_r($default_icon); echo '</pre>';
		//		die('dfaf');
		$helper->get_icon_html($item, 'item_icon', $default_icon, $settings);
	}

	function eae_infocircle_content_section()
	{

		$repeater = new Repeater();

		$repeater->start_controls_tabs('infolist_items_tab');

		$repeater->start_controls_tab(
			'content',
			[
				'label' => __('Content', 'wts-eae'),
			]
		);

		$repeater->add_control(
			'ic_item_title',
			[
				'label'       => __('Title', 'wts-eae'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('This is the heading', 'wts-eae'),
				'placeholder' => __('Enter your title', 'wts-eae'),
			]
		);

		$repeater->add_group_control(
			Group_Control_Icon::get_type(),
			[
				'name'  => 'item_icon',
				'label' => 'Icon',
			]
		);

		$repeater->add_control(
			'ic_item_content',
			[
				'label'       => __('Content', 'wts-eae'),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __('Content', 'wts-eae'),
				'default'     => __('Add some nice text here.', 'wts-eae'),
			]
		);

		$repeater->add_control(
			'ic_item_title_size',
			[
				'label'   => __('Title HTML Tag', 'wts-eae'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h3',
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'style',
			[
				'label' => __('Style', 'wts-eae'),
			]
		);
		$repeater->add_control(
			'ic_custom_style',
			[
				'label'     => __('Custom Content Style', 'wts-eae'),
				'type'      => Controls_Manager::SWITCHER,
				'default'      => 'no',
			]
		);
		$repeater->add_control(
			'ic_custom_content_align',
			[
				'label'     => __('Content Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-info-circle {{CURRENT_ITEM}} .eae-info-circle-item__content' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography_ind',
				'label'    => __('Title Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}  .eae-ic-heading',
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography_ind',
				'label'    => __('Content Typography', 'wts-eae'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}  .eae-ic-description',
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);


		$repeater->add_control(
			'title_color_ind',
			[
				'label'     => __('Title Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}  .eae-ic-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'content_color_ind',
			[
				'label'     => __('Content Color', 'wts-eae'),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}  .eae-ic-description' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_color_indv',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .eae-info-circle-item__content-wrap',
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'hover_color_heading',
			[
				'label' => __('Hover', 'wts-eae'),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);


		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_color_indv_hover',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .eae-info-circle-item__content-wrap:hover',
				'condition' => [
					'ic_custom_style' => 'yes'
				]
			]
		);

		$this->get_repeater_icon_styles($repeater);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->start_controls_section(
			'info_circle',
			[
				'label'     => __('Info Circle Items', 'wts-eae'),
			]
		);


		$this->add_control(
			'info_circle_items',
			[
				'label'      => __('List Items', 'wts-eae'),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'     => [
					[
						'ic_item_title' => __('MASTER CLEANSE BESPOKE', 'wts-eae'),
						'ic_item_content' => __('IPhone tilde pour-over, sustainable cred roof party occupy master cleanse. Godard vegan heirloom sartorial flannel raw denim +1. Sriracha umami meditation, listicle chambray fanny pack blog organic Blue Bottle.', 'wts-eae'),
					],
					[
						'ic_item_title' => __('ORGANIC BLUE BOTTLE', 'wts-eae'),
						'ic_item_content' => __('Godard vegan heirloom sartorial flannel raw denim +1 umami gluten-free hella vinyl. Viral seitan chillwave, before they sold out wayfarers selvage skateboard Pinterest messenger bag.', 'wts-eae'),
					],
					[
						'ic_item_title' => __('TWEE DIY KALE', 'wts-eae'),
						'ic_item_content' => __('Twee DIY kale chips, dreamcatcher scenester mustache leggings trust fund Pinterest pickled. Williamsburg street art Odd Future jean shorts cold-pressed banh mi DIY distillery Williamsburg.', 'wts-eae'),
					],
				],
			]
		);
		$this->end_controls_section();
	}


	function eae_infocircle_style_section()
	{

		$this->start_controls_section(
			'content_styling',
			[
				'label' => __('Content', 'wts-eae'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ic_content_mouseenter',
			[
				'label'     => __('Content Change on MouseEnter', 'wts-eae'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'wts-eae'),
				'label_off' => __('No', 'wts-eae'),
				'return_value' => 'yes',
				'default' => '',
				'prefix_class'  =>  'eae-mouseenter-'
			]
		);

		$this->add_control(
			'ic_content_auto_change',
			[
				'label'     => __('Content Auto Change', 'wts-eae'),
				'type'      => Controls_Manager::SWITCHER,
				'default'      => 'no',
			]
		);
		$this->add_control(
			'ic_change_duration',
			[
				'label'     => __('Change Duration', 'wts-eae'),
				'type'      => Controls_Manager::TEXT,
				'default'   => '3000',
				'condition' => [
					$this->get_control_id('ic_content_auto_change') => 'yes',
				]
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'     => __('Content Alignment', 'wts-eae'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
					'start'   => [
						'title' => __('Left', 'wts-eae'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'wts-eae'),
						'icon'  => 'fa fa-align-center',
					],
					'end'  => [
						'title' => __('Right', 'wts-eae'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-info-circle .eae-info-circle-item__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __('Content Padding', 'wts-eae'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eae-info-circle .eae-info-circle-item__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .eae-ic-heading' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .eae-ic-description' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .eae-ic-heading',
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
				'selector' => '{{WRAPPER}} .eae-ic-description',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'label'    => 'Title Shadow',
				'selector' => '{{WRAPPER}} .eae-ic-heading',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'item_text_shadow',
				'label'    => 'Content Shadow',
				'selector' => '{{WRAPPER}} .eae-ic-description',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_color',
				'types'     => ['classic', 'gradient'],
				'fields_options' => [
					'background' => [
						'default' => 'classic'
					],
					'color' => [
						'default' => '#f4f4f4'
					],
				],
				'selector'  => '{{WRAPPER}} .eae-info-circle-item__content-wrap',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .eae-info-circle-item__content-wrap',
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

	function get_icon_style_section()
	{
		$helper = new Helper();
		$helper->group_icon_styles($this, [
			'name'                  => 'item_icon',
			'label'                 => __('Icon', 'wts-eae'),
			'primary_color'         => true,
			'secondary_color'       => true,
			'hover_primary_color'   => false,
			'hover_secondary_color' => false,
			'hover_animation'       => false,
			'focus_primary_color'   => true,
			'focus_secondary_color' => true,
			'icon_size'             => true,
			'icon_padding'          => true,
			'rotate'                => true,
			'border_width'          => true,
			'border_radius'         => true,
			'custom_style_switch'   => false,
			'focus_item_class'      => 'eae-active',
		]);
	}
}
