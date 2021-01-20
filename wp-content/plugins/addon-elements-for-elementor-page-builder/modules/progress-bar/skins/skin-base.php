<?php

namespace WTS_EAE\Modules\ProgressBar\Skins;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use WTS_EAE\Classes\Post_Helper;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

abstract class Skin_Base extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/eae-progress-bar/pb_skins/before_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/eae-progress-bar/pb_skins/after_section_end', [
			$this,
			'register_style_controls'
		] );
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;
	}

	public function register_style_controls() {
		$this->start_controls_section(
			'general_style',
			[
				'label' => __( 'General', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'progress_color',
			[
				'label'     => __( 'Progress Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-pb-bar-inner' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'progress_bg_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-pb-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pb_title_style',
			[
				'label' => __( 'Title', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'global'    =>  [
				        'default'   =>  Global_Colors::COLOR_SECONDARY,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-pb-bar-skill' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .eae-pb-bar-skill',
				'global'    =>  [
					'default'   => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pb_value_style',
			[
				'label' => __( 'Percentage', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'value_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-pb-bar-value' => 'color: {{VALUE}};',
				],
				'global'    =>  [
					'default'   => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'value_typography',
				'selector' => '{{WRAPPER}} .eae-pb-bar-value',
				'global'    =>  [
					'default'   => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}

	function common_render() {
		$settings = $this->parent->get_settings_for_display();

		//echo '<pre>';print_r( $settings );echo '</pre>';
		$this->parent->add_render_attribute( 'wrapper_class', 'class', 'eae-progress-bar-wrapper' );
		if(is_rtl()){
            $this->parent->add_render_attribute( 'wrapper_class', 'class', 'eae-progress-bar-rtl' );
        }

		$this->parent->add_render_attribute( 'wrapper_class', 'class', 'eae-progress-bar');
		$this->parent->add_render_attribute( 'wrapper_class', 'class', 'eae-progress-bar-' . $settings['_skin'] );
		$this->parent->add_render_attribute( 'wrapper_class', 'data-skin', $settings['_skin'] );
		$this->parent->add_render_attribute( 'wrapper_class', 'data-skill', $settings['progress_title'] );
		$this->parent->add_render_attribute( 'wrapper_class', 'data-value', $settings['progress_value']['size'] );

		$this->parent->add_render_attribute( 'pb_val_class', 'class', 'eae-pb-bar-value' );
		$this->parent->add_render_attribute( 'pb_val_class', 'class', 'eae-pb-bar-value-' . $settings['_skin'] );
		$this->parent->add_render_attribute( 'pb_val_class', 'class', 'eae-pb-bar-value--aligned-value' );
		//$this->parent->add_render_attribute( 'pb_val_class', 'class', 'js-animated' );

		$this->parent->add_render_attribute( 'pb_bar_class', 'class', 'eae-pb-bar' );
		$this->parent->add_render_attribute( 'pb_bar_class', 'class', 'eae-pb-bar-'. $settings['_skin']  );

		$this->parent->add_render_attribute( 'pb_bar_inner_class', 'class', 'eae-pb-bar-inner' );
		$this->parent->add_render_attribute( 'pb_bar_inner_class', 'class', 'eae-pb-bar-inner-'. $settings['_skin']  );
		//$this->parent->add_render_attribute( 'pb_bar_inner_class', 'class', 'js-animated' );

		$this->parent->add_render_attribute( 'pb_title_class', 'class', 'eae-pb-bar-skill' );
		$this->parent->add_render_attribute( 'pb_title_class', 'class', 'eae-pb-bar-skill-'. $settings['_skin']  );
		//$this->parent->add_render_attribute( 'pb_title_class', 'class', 'js-animated' );
		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'wrapper_class' ); ?>>
			<?php if($settings['progress_value_show']) { ?>
			<span <?php echo $this->parent->get_render_attribute_string( 'pb_val_class' ); ?>>
				<?php echo $settings['progress_value']['size'] . '%' ?>
			</span>
			<?php } ?>
			<div <?php echo $this->parent->get_render_attribute_string( 'pb_bar_class' ); ?>>
				<div <?php echo $this->parent->get_render_attribute_string( 'pb_bar_inner_class' ); ?>></div>
			</div>
			<?php if($settings['progress_title_show']) { ?>
			<span <?php echo $this->parent->get_render_attribute_string( 'pb_title_class' ); ?>>
				<?php echo $settings['progress_title'] ?>
			</span>
			<?php } ?>
		</div>
		<?php
	}
}