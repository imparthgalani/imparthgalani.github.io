<?php

namespace WTS_EAE\Modules\ProgressBar\Widgets;

use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Controls_Manager;
use WTS_EAE\Modules\ProgressBar\Skins;

class Progress_Bar extends EAE_Widget_Base {

	public function get_name() {
		return 'eae-progress-bar';
	}

	public function get_title() {
		return __( 'EAE - Progress Bar', 'wts-eae' );
	}

	public function get_icon() {
		return 'eae-icons eae-progress-bar';
	}

	public function get_keywords() {
		return [ 'progress', 'bar' ];
	}

	protected $_has_template_content = false;

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_1( $this ) );
		$this->add_skin( new Skins\Skin_2( $this ) );
		$this->add_skin( new Skins\Skin_3( $this ) );
		$this->add_skin( new Skins\Skin_4( $this ) );
		$this->add_skin( new Skins\Skin_5( $this ) );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'pb_skins',
			[
				'label' => __( 'General', 'wts-eae' ),
			]
		);

		$this->add_control(
			'progress_title',
			[
				'label'       => __( 'Skill', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
				'default'     => 'Web Designer',
				'label_block' => false,
			]
		);

		$this->add_control(
			'progress_value',
			[
				'label'   => __( 'Percentage', 'wts-eae' ),
				'type'    => Controls_Manager::SLIDER,
                'dynamic' => [
                    'active' => true,
                ],
				'range'   => [
					'min' => 1,
					'max' => 100,
				],
				'default' => [
					'size' => 50,
				],
			]
		);

		$this->add_control(
			'progress_title_show',
			[
				'label'        => __( 'Show Title', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'progress_value_show',
			[
				'label'        => __( 'Show Percentage', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	public function _content_template() {
		?>
		<#
		var wrapperKey = 'wrapperclass';
		view.addRenderAttribute( wrapperKey, 'class', 'eae-progress-bar-wrapper' );
		view.addRenderAttribute( wrapperKey, 'class', 'eae-progress-bar' );
		view.addRenderAttribute( wrapperKey, 'class', 'eae-progress-bar-' + settings._skin );
		view.addRenderAttribute( wrapperKey, 'data-skin', settings._skin );
		view.addRenderAttribute( wrapperKey, 'data-skill', settings.progress_title );
		view.addRenderAttribute( wrapperKey, 'data-value', settings.progress_value.size );

		view.addRenderAttribute( 'pb_val_class', 'class', 'eae-pb-bar-value' );
		view.addRenderAttribute( 'pb_val_class', 'class', 'eae-pb-bar-value-' + settings._skin );
		view.addRenderAttribute( 'pb_val_class', 'class', 'eae-pb-bar-value--aligned-value' );

		view.addRenderAttribute( 'pb_bar_class', 'class', 'eae-pb-bar' );
		view.addRenderAttribute( 'pb_bar_class', 'class', 'eae-pb-bar-' + settings._skin );

		view.addRenderAttribute( 'pb_bar_inner_class', 'class', 'eae-pb-bar-inner' );
		view.addRenderAttribute( 'pb_bar_inner_class', 'class', 'eae-pb-bar-inner-' + settings._skin  );

		view.addRenderAttribute( 'pb_title_class', 'class', 'eae-pb-bar-skill' );
		view.addRenderAttribute( 'pb_title_class', 'class', 'eae-pb-bar-skill-' + settings._skin  );
		#>
		<div {{{ view.getRenderAttributeString( wrapperKey ) }}}>
			<# if(settings.progress_value_show) { #>
			<span {{{ view.getRenderAttributeString('pb_val_class') }}}>
			{{{ settings.progress_value.size + '%' }}}
			</span>
			<# } #>

			<div {{{ view.getRenderAttributeString('pb_bar_class') }}}>
			<div {{{ view.getRenderAttributeString('pb_bar_inner_class') }}}>
		</div>
		</div>

		<# if(settings.progress_title_show) { #>
		<span {{{ view.getRenderAttributeString('pb_title_class') }}}>
		{{{ settings.progress_title }}}
		</span>
		<# } #>
		</div>
	<?php }
}