<?php
namespace WTS_EAE\Modules\AnimatedText\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AnimatedText extends EAE_Widget_Base {
	
	public function get_name() {
		return 'wts-AnimatedText';
	}
	
	public function get_title() {
		return __( 'EAE - Animated Text', 'wts-eae' );
	}
	
	public function get_icon() {
		return 'eicon-animation-text wts-eae-pe';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}
		
	protected function _register_controls() {
			$this->start_controls_section(
				'section_general',
				[
					'label' => __( 'General', 'wts-eae' )
				]
			);


			$this->add_responsive_control(
					'text-align',
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
							'default' => '',
							'selectors' => [
									'{{WRAPPER}} .eae-at-animation' => 'text-align: {{VALUE}};',
							]
					]
			);

			$this->add_control(
				'pre-text',
				[
					'label' => __( 'Pre Text', 'wts-eae' ),
					'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
					'placeholder' => __( 'Enter text', 'wts-eae' ),
					'default' => __( 'I Love', 'wts-eae' ),
				]
			);
			
			
			$this->add_control(
				'animation-text-list',
				[
					'label' => __( 'Animated Text List', 'wts-eae' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'text' => __( 'Football', 'wts-eae' ),
						],
						[
							'text' => __( 'Cricket', 'wts-eae' ),
						],
						[
							'text' => __( 'Basketball', 'wts-eae' ),
						],
					],
					'fields' => [
						[
							'name' => 'text',
							'label' => __( 'Text', 'wts-eae' ),
							'type' => Controls_Manager::TEXT,
                            'dynamic' => [
                                'active' => true,
                            ],
							'label_block' => true,
							'placeholder' => __( 'Text to animate', 'wts-eae' ),
							'default' => __( '', 'wts-eae' ),
						],
					],
					'title_field' => '{{{ text }}}'
				]
			);

			$this->add_control(
				'post-text',
				[
					'label' => __( 'Post Text', 'wts-eae' ),
					'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
					'placeholder' => __( 'Enter text', 'wts-eae' ),
					'default' => __( 'Very Much', 'wts-eae' ),
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_pre_text_style',
				[
					'label' => __( 'Pre Text', 'wts-eae' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			
			
			$this->add_control(
				'pre_text_color',
				[
					'label' => __( 'Pre Text Color', 'wts-eae' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-at-pre-text' => 'color: {{VALUE}};',
					],
				]
			);
	
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'pre_text_typography',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY
					],
					'selector' => '{{WRAPPER}} .eae-at-pre-text',
				]
			);

			
			$this->end_controls_section();

			
			 $this->start_controls_section(
				'section_animation_text_style',
				[
					'label' => __( 'Animated Text', 'wts-eae' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);


			$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
							'name' => 'animation_color_typography',
							'global' => [
								'default' => Global_Typography::TYPOGRAPHY_PRIMARY
							],
							'selector' => '{{WRAPPER}} .eae-at-animation-text, {{WRAPPER}} .eae-at-animation-text i',
					]
			);
			
			
			$this->add_control(
				'animation_color',
				[
					'label' => __( 'Animation Text Color', 'wts-eae' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_ACCENT,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation-text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'animated_text_border',
					'label' => __( 'Box Border', 'wts-eae' ),
					'selector' => '{{WRAPPER}} .eae-at-animation-text-wrapper .eae-at-animation-text.is-visible',
				]
			);



			$this->add_control(
				'box_border_radius',
				[
					'label' => __( 'Border Radius', 'wts-eae' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation-text-wrapper .eae-at-animation-text.is-visible' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
				]
			);

			$this->add_control(
				'box_padding',
				[
					'label' => __( 'Padding', 'wts-eae' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation-text-wrapper .eae-at-animation-text.is-visible' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'box_margin',
				[
					'label' => __( 'Margin', 'wts-eae' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation-text-wrapper .eae-at-animation-text.is-visible' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	

			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'animation_section_bg',
					'label' => __( 'Section Background', 'wts-eae' ),
					'types' => [ 'classic','gradient'  ],
					'selector' => '{{WRAPPER}} .eae-at-animation-text-wrapper .eae-at-animation-text.is-visible',
				]
			);


			
			$this->end_controls_section();

			$this->start_controls_section(
				'section_cursor_style',
				[
					'label' => __( 'Cursor Control', 'wts-eae' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);


			$this->add_control(
				'cursor_color',
				[
					'label' => __( 'Color', 'wts-eae' ),
					'type' => Controls_Manager::COLOR,

					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'default' => '#54595f',
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation-text-wrapper::after' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'cursor_width',
				[
					'label' => __( 'Width', 'wts-eae' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default' => [
						'size' => 1,
						'unit' => 'px',
					],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 5,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .eae-at-animation.type .eae-at-animation-text-wrapper::after' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_post_text_style',
				[
					'label' => __( 'Post Text', 'wts-eae' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);


			$this->add_control(
				'post_text_color',
				[
					'label' => __( 'Post Text Color', 'wts-eae' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-at-post-text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'post_text_typography',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .eae-at-post-text',
				]
			);

			$this->end_controls_section();
	}
	
	protected function render(){
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('eae-at-animated-text-wrapper','class','eae-at-animation-text-wrapper');

		$this->add_render_attribute('eae-at-animated-text-wrapper','class','waiting');

		$this->add_render_attribute('eae-at-animated-text','class','eae-at-animation-text');

		$this->add_render_attribute('eae-at-pre-txt','class','eae-at-pre-text');

        $this->add_render_attribute('eae-at-animated','class','eae-at-animation');

		$this->add_render_attribute('eae-at-animated','class','type');

		$this->add_render_attribute('eae-at-animated','class','letters');

		$this->add_render_attribute('eae-at-post-txt','class','eae-at-post-text');

		?>
			<div id="eae-at-<?php echo $this->get_id(); ?>" class="eae-animtext-wrapper">
				<div <?php echo $this->get_render_attribute_string( 'eae-at-animated' ); ?>>
					<span <?php echo $this->get_render_attribute_string( 'eae-at-pre-txt' ); ?>><?php echo $settings['pre-text']; ?></span>
						<?php if(count($settings['animation-text-list'])){
						?>
							<span <?php echo $this->get_render_attribute_string( 'eae-at-animated-text-wrapper' ); ?>>
								<?php
									foreach($settings['animation-text-list'] as $animation_text){
								?>

									<span <?php echo $this->get_render_attribute_string( 'eae-at-animated-text' ); ?>><?php echo $animation_text['text']; ?></span>

								<?php
									 }
								?>
							</span>
						<?php
						}?>
					<span <?php echo $this->get_render_attribute_string( 'eae-at-post-txt' ); ?>><?php echo $settings['post-text']; ?></span>
				</div>
			</div>
			<script>
				jQuery(document).trigger('elementor/render/animation-text','#eae-at-<?php echo $this->get_id(); ?>');

				jQuery(document).ready(function(){
					jQuery(document).trigger('elementor/render/animation-text','#eae-at-<?php echo $this->get_id(); ?>');
				});
			</script>
        <?php
	}

}

//Plugin::instance()->widgets_manager->register_widget_type( new Widget_AnimatedText() );
?>