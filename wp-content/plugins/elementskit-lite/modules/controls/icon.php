<?php
namespace ElementsKit_Lite\Modules\Controls;

defined( 'ABSPATH' ) || exit;

class Icon extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'icon';
	}

	public function enqueue() {
		// styles
		wp_register_style( 'elementskit-css-icon-control',  Init::get_url() . 'assets/css/ekiticons.css', [], '1.0.1' );
		wp_enqueue_style( 'elementskit-css-icon-control' );
    }
    
	public static function get_icons() {
    return include Init::get_dir() . 'icon-list.php';
	}

	protected function get_default_settings() {
		return [
			'options' => self::get_icons(),
		];
	}

	public function content_template() {
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<select class="elementor-control-icon" data-setting="{{ data.name }}" data-placeholder="<?php esc_attr_e( 'Select Icon', 'elementskit-hederfooter' ); ?>">
					<option value=""><?php esc_html_e( 'Select Icon', 'elementskit-hederfooter' ); ?></option>
					<# _.each( data.options, function( option_title, option_value ) { #>
					<option value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{ data.description }}</div>
		<# } #>
		<?php
	}
}
