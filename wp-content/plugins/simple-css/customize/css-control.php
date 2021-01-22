<?php
class Simple_CSS_Editor extends WP_Customize_Control {

	public $type = 'textarea';

	public function render_content() { ?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="customize-control-content">
				<textarea style="height:calc( 100vh - 200px );" spellcheck="false" class="widefat" cols="45" rows="15" <?php $this->link(); ?>><?php echo wp_kses_post( $this->value() ); ?></textarea>
			</div>
		</label>
	<?php }

}
