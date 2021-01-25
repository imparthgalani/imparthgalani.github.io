<?php

/**
 * Class Preloader_Plus_Group_Title
 *
 * Add a title to groups of controls.
 *
 * @since 1.0
 */
if ( ! class_exists( 'Preloader_Customize_Misc_Control' ) ) {
	class Preloader_Customize_Misc_Control extends WP_Customize_Control {
		public $description = '';
		public $url = '';
		public $text_url = '';

		public function render_content() {
			switch ( $this->type ) {
				default:
				case 'description' :
				echo '<p class="description">' . esc_html( $this->description ) . '</p>';
				break;

				case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				break;

				case 'big_heading':
				echo '<span class="customize-control-title" style="padding:10px 20px;color:#fff;background:#008aff">' . esc_html( $this->label ) . '</span>';
				break;

				case 'line' :
				echo '<hr />';
				break;

				case 'group' :
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				echo '<span class="description">' . esc_html( $this->description ) . '</span>';
				break;

				case 'pro-info':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				echo '<span class="description">' . esc_html( $this->description ) . '</span>';
				echo '<a href="' . esc_url( $this->url ) . '" class="preloader-plus-pro-button" target="_blank">' . esc_html( $this->text_url ) . '</span>';
				break;
			}
		}
	}
}

if ( ! class_exists( 'Preloader_Customize_Radio_Control' ) ) {
	class Preloader_Customize_Radio_Control extends WP_Customize_Control {
		public $type = 'radio_image';

		public function render_content() {
			$input_id = '_customize-input-' . $this->id;
    	$description_id = '_customize-description-' . $this->id;
    	$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			if ( empty( $this->choices ) ) {
	  		return;
	  	}

	  	$name = '_customize-radio-' . $this->id;
	  	if ( ! empty( $this->label ) ) : ?>
	  		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	  	<?php endif;
	  	if ( ! empty( $this->description ) ) : ?>
	  		<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description ; ?></span>
	  	<?php endif;

	  	foreach ( $this->choices as $value => $label ) : ?>
	  		<span class="preloader-icon-wrapper">
	    		<input id="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"
	      		type="radio"
	      		<?php echo $describedby_attr; ?>
	      		value="<?php echo esc_attr( $value ); ?>"
	      		name="<?php echo esc_attr( $name ); ?>"
	      		<?php $this->link(); ?>
	      		<?php checked( $this->value(), $value ); ?>
	      	/>
	      	<label for="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"><img src="<?php echo esc_url( $label ); ?>" /></label>
	    	</span>
	  	<?php endforeach;
		}
	}
}

/**
 * Sortable control
 */
class Preloader_Plus_Customizer_Sortable_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'preloader-plus-sortable';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'preloader-plus-sortable', PRELOADER_PLUS_URL . 'assets/admin/js/customizer-sortable.js', array( 'jquery', 'customize-base', 'jquery-ui-core', 'jquery-ui-sortable' ), false, true );
		wp_enqueue_style( 'preloader-plus-sortable', PRELOADER_PLUS_URL . 'assets/admin/css/customizer-sortable.css', array() , PRELOADER_PLUS_VERSION );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value']       = maybe_unserialize( $this->value() );
		$this->json['choices']     = $this->choices;
		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		$this->json['inputAttrs'] = maybe_serialize( $this->input_attrs() );

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label class='preloader-plus-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<ul class="sortable">
				<# _.each( data.value, function( choiceID ) { #>
					<li {{{ data.inputAttrs }}} class='preloader-plus-sortable-item' data-value='{{ choiceID }}'>
						<i class='dashicons dashicons-menu'></i>
						<i class="dashicons dashicons-visibility visibility"></i>
						{{{ data.choices[ choiceID ] }}}
					</li>
				<# }); #>
				<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
					<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
						<li {{{ data.inputAttrs }}} class='preloader-plus-sortable-item invisible' data-value='{{ choiceID }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ choiceID ] }}}
						</li>
					<# } #>
				<# }); #>
			</ul>
		</label>
		<?php
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}
}
