<?php
namespace WTS_EAE\Modules\TextSeparator\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Colors_And_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TextSeparator extends EAE_Widget_Base {

	public function get_name() {
		return 'wts-textseparator';
	}

	public function get_title() {
		return __( 'EAE - Text Separator', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-divider wts-eae-pe';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'wts-eae' )
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'wts-eae' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => __( 'Enter text', 'wts-eae' ),
				'default' => __( 'This is text separator', 'wts-eae' )
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'wts-eae' ),
					'h2' => __( 'H2', 'wts-eae' ),
					'h3' => __( 'H3', 'wts-eae' ),
					'h4' => __( 'H4', 'wts-eae' ),
					'h5' => __( 'H5', 'wts-eae' ),
					'h6' => __( 'H6', 'wts-eae' ),
					'div' => __( 'div', 'wts-eae' ),
					'span' => __( 'span', 'wts-eae' ),
					'p' => __( 'p', 'wts-eae' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
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
				'default' => 'center'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'wts-eae' ),
				'type' => Controls_Manager::SECTION,
			]
		);


		$this->add_control(
			'icon_new',
			[
				'label' => __( 'Icon', 'wts-eae' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'wts-eae' ),
					'stacked' => __( 'Stacked', 'wts-eae' ),
					'framed' => __( 'Framed', 'wts-eae' ),
				],
				'default' => 'default',
				'prefix_class' => 'eae-icon-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'wts-eae' ),
					'square' => __( 'Square', 'wts-eae' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'eae-icon-shape-',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => __('Icon Position','wts-eae'),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'before' => __( 'Before Text', 'wts-eae' ),
					'after' => __( 'After Text', 'wts-eae' )
				],
				'default' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_divider',
			[
				'label' => __( 'Divider', 'wts-eae' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'wts-eae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => __( 'Solid', 'wts-eae' ),
					'double' => __( 'Double', 'wts-eae' ),
					'dotted' => __( 'Dotted', 'wts-eae' ),
					'dashed' => __( 'Dashed', 'wts-eae' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .wts-eae-textseparator .eae-sep-holder .eae-sep-lines' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'weight',
			[
				'label' => __( 'Weight', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wts-eae-textseparator .eae-sep-holder .eae-sep-lines' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);




		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-separator-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-separator-title',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => __( 'Divider', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => __( 'Divider Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],

				'selectors' => [
					'{{WRAPPER}} .eae-sep-lines' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label' => __( 'Width', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wts-eae-textseparator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_align',
			[
				'label' => __( 'Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'' => [
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
					'{{WRAPPER}} .wts-eae-textseparator' => 'float: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __( 'Icon', 'wts-eae' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => __( 'Primary Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-default  i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-default svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked .eae-separator-icon-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-separator-icon-inner, {{WRAPPER}}.eae-icon-view-framed .eae-separator-icon-inner i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-framed .eae-separator-icon-inner svg ' => 'fill: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => __( 'Secondary Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.eae-icon-view-framed .eae-separator-icon-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked .eae-separator-icon-inner i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.eae-icon-view-stacked .eae-separator-icon-inner svg' => 'fill: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'size',
			[
				'label' => __( 'Icon Size', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-separator-icon-inner i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eae-separator-icon-inner svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Icon Padding', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,

				'selectors' => [
					'{{WRAPPER}} .eae-separator-icon-inner' => 'padding: {{SIZE}}{{UNIT}};',
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
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __( 'Icon Rotate', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],

				'selectors' => [
					'{{WRAPPER}} .eae-separator-icon-inner i' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .eae-separator-icon-inner svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .eae-separator-icon-inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-separator-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);
	}

	protected function render( ) {
		$settings = $this->get_settings_for_display();
		//echo '<pre>'; print_r($settings); echo '</pre>';
		$this->add_render_attribute('separator_wrapper','class','wts-eae-textseparator');
		$this->add_render_attribute('separator_wrapper','class','sep-align-'.$settings['align']);
		if(!empty($settings['icon_new']) ){
			$this->add_render_attribute('separator_wrapper','class','icon-yes');
			$this->add_render_attribute('separator_wrapper','class','icon-'.$settings['icon_position']);
		}


		$icon_migrated = isset($settings['__fa4_migrated']['icon_new']);
		$icon_is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

		if(!empty($settings['title'])){
			$this->add_render_attribute('separator_wrapper','class','title-yes');
		}

		$this->add_render_attribute( 'title', 'class', 'eae-separator-title' );

		$this->add_inline_editing_attributes( 'title' );
		if(isset($settings['icon']) && empty($settings['icon'])){
			$settings['icon_new'] = [];
		}
		?>
        <div <?php echo $this->get_render_attribute_string('separator_wrapper');?> >
            <div class="eae-sep-holder sep-left">
                <div class="eae-sep-lines"></div>
            </div>

			<?php if(!empty($settings['icon_new']) && $settings['icon_position'] == 'before') { ?>
                <div class="eae-separator-icon-wrapper">
                    <div class="eae-separator-icon-inner">
						<?php //if(!empty($settings['icon'])){
						if ( ($icon_migrated || $icon_is_new ) && !empty($settings['icon_new']) ) :
							Icons_Manager::render_icon($settings['icon_new'], ['aria-hidden' => 'true']);
						else:?>
                            <i class="<?php echo $settings['icon']; ?>"></i>
						<?php endif; ?>
						<?php //} ?>
                    </div>
                </div>
			<?php } ?>

			<?php if($settings['title'] != ''){
				echo sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['html_tag'], $this->get_render_attribute_string( 'title' ), $settings['title'] );
			}?>

			<?php if(!empty($settings['icon_new']) && $settings['icon_position'] == 'after') { ?>
                <div class="eae-separator-icon-wrapper">
                    <div class="eae-separator-icon-inner">
						<?php  if ( ($icon_migrated || $icon_is_new ) && !empty($settings['icon_new']) ) :
							Icons_Manager::render_icon($settings['icon_new'], ['aria-hidden' => 'true']);
						else:?>
                            <i class="<?php echo $settings['icon']; ?>"></i>
						<?php endif; ?>
                    </div>
                </div>
			<?php } ?>

            <div class="eae-sep-holder sep-right">
                <div class="eae-sep-lines"></div>
            </div>
        </div>
		<?php
	}

	protected function _content_template() {
		?>
        <#
        view.addRenderAttribute( 'separator_wrapper','class','wts-eae-textseparator' );
        view.addRenderAttribute('separator_wrapper','class','sep-align-'+settings.align);
        if(settings.icon_new){
        view.addRenderAttribute('separator_wrapper','class','icon-yes');
        view.addRenderAttribute('separator_wrapper','class','icon-'+settings.icon_position);
        }

        iconHTML = elementor.helpers.renderIcon( view, settings.icon_new, { 'aria-hidden': true }, 'i' , 'object' ),
        migrated = elementor.helpers.isIconMigrated( settings, 'icon_new' );

        if((settings.title)){
        view.addRenderAttribute('separator_wrapper','class','title-yes');
        }

        view.addRenderAttribute( 'title', 'class', 'eae-separator-title' );

        view.addInlineEditingAttributes( 'title' );
        #>
        <div  {{{ view.getRenderAttributeString( 'separator_wrapper' ) }}}>
        <div class="eae-sep-holder sep-left">
            <div class="eae-sep-lines"></div>
        </div>

        <# if((settings.icon_new) && settings.icon_position == 'before') { #>
        <div class="eae-separator-icon-wrapper">
            <div class="eae-separator-icon-inner">
                <# if ( iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
                {{{ iconHTML.value }}}
                <# } else { #>
                <i class="{{ settings.icon }}" aria-hidden="true"></i>
                <# } #>
            </div>
        </div>
        <# } #>

        <{{{settings.html_tag}}} {{{ view.getRenderAttributeString( 'title' ) }}} >{{{ settings.title }}}</{{{settings.html_tag}}}>

        <# if((settings.icon_new) && settings.icon_position == 'after') { #>
        <div class="eae-separator-icon-wrapper">
            <div class="eae-separator-icon-inner">
                <# if ( iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
                {{{ iconHTML.value }}}
                <# } else { #>
                <i class="{{ settings.icon }}" aria-hidden="true"></i>
                <# } #>
            </div>
        </div>
        <# } #>

        <div class="eae-sep-holder sep-right">
            <div class="eae-sep-lines"></div>
        </div>
        </div>
		<?php
	}
	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'icon_new', true );
	}
}