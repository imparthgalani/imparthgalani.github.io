<?php

namespace WTS_EAE\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Hover_Transition extends Base_Data_Control {

	private static $_hover_transition;

	public function get_type() {
		return 'EAE_HOVER_TRANSITION';
	}

	public static function get_transitions() {
		if ( is_null( self::$_hover_transition ) ) {
			self::$_hover_transition = [
				'2D Transitions'  => [
					'hvr-grow'                   => __( 'Grow', 'wts-eae' ),
					'hvr-shrink'                 => __( 'Shrink', 'wts-eae' ),
					'hvr-pulse'                  => __( 'Pulse', 'wts-eae' ),
					'hvr-pulse-grow'             => __( 'Pulse Grow', 'wts-eae' ),
					'hvr-pulse-shrink'           => __( 'Pulse Shrink', 'wts-eae' ),
					'hvr-push'                   => __( 'Push', 'wts-eae' ),
					'hvr-pop'                    => __( 'Pop', 'wts-eae' ),
					'hvr-bounce-in'              => __( 'Bounce In', 'wts-eae' ),
					'hvr-bounce-out'             => __( 'Bounce Out', 'wts-eae' ),
					'hvr-rotate'                 => __( 'Rotate', 'wts-eae' ),
					'hvr-grow-rotate'            => __( 'Icon Shrink', 'wts-eae' ),
					'hvr-float'                  => __( 'Float', 'wts-eae' ),
					'hvr-sink'                   => __( 'Sink', 'wts-eae' ),
					'hvr-bob'                    => __( 'Bob', 'wts-eae' ),
					'hvr-hang'                   => __( 'Hang', 'wts-eae' ),
					'hvr-skew'                   => __( 'Skew', 'wts-eae' ),
					'hvr-skew-forward'           => __( 'Skew Forward', 'wts-eae' ),
					'hvr-skew-backward'          => __( 'Skew Backward', 'wts-eae' ),
					'hvr-wobble-horizontal'      => __( 'Wobble Horizontal', 'wts-eae' ),
					'hvr-wobble-vertical'        => __( 'Wobble Vertical', 'wts-eae' ),
					'hvr-wobble-to-bottom-right' => __( 'Wobble To Bottom Right', 'wts-eae' ),
					'hvr-wobble-to-top-right'    => __( 'Wobble To Top Right', 'wts-eae' ),
					'hvr-wobble-top'             => __( 'Wobble Top', 'wts-eae' ),
					'hvr-wobble-bottom'          => __( 'Wobble Bottom', 'wts-eae' ),
					'hvr-wobble-skew'            => __( 'Wobble Skew', 'wts-eae' ),
					'hvr-buzz'                   => __( 'Buzz', 'wts-eae' ),
					'hvr-buzz-out'               => __( 'Buzz Out', 'wts-eae' ),
					'hvr-forward'                => __( 'Forward', 'wts-eae' ),
					'hvr-backward'               => __( 'Backward', 'wts-eae' ),
				],
				'Background'      => [
					'hvr-fade'                   => __( 'Fade', 'wts-eae' ),
					'hvr-back-pulse'             => __( 'Back Pulse', 'wts-eae' ),
					'hvr-sweep-to-right'         => __( 'Sweep To Right', 'wts-eae' ),
					'hvr-sweep-to-left'          => __( 'Sweep To Left', 'wts-eae' ),
					'hvr-sweep-to-bottom'        => __( 'Sweep To Bottom', 'wts-eae' ),
					'hvr-sweep-to-top'           => __( 'Sweep To Top', 'wts-eae' ),
					'hvr-bounce-to-right'        => __( 'Bounce To Right', 'wts-eae' ),
					'hvr-bounce-to-left'         => __( 'Bounce To Left', 'wts-eae' ),
					'hvr-bounce-to-bottom'       => __( 'Bounce To Bottom', 'wts-eae' ),
					'hvr-bounce-to-top'          => __( 'Bounce To Top', 'wts-eae' ),
					'hvr-radial-out'             => __( 'Radial Out', 'wts-eae' ),
					'hvr-radial-in'              => __( 'Radial In', 'wts-eae' ),
					'hvr-rectangle-in'           => __( 'Rectangle In', 'wts-eae' ),
					'hvr-rectangle-out'          => __( 'Rectangle Out', 'wts-eae' ),
					'hvr-shutter-in-horizontal'  => __( 'Shutter In Horizontal', 'wts-eae' ),
					'hvr-shutter-out-horizontal' => __( 'Shutter Out Horizontal', 'wts-eae' ),
					'hvr-shutter-in-vertical'    => __( 'Shutter In Vertical', 'wts-eae' ),
					'hvr-shutter-out-vertical'   => __( 'Shutter Out Vertical', 'wts-eae' ),
				],
				'Icon'            => [
					'hvr-icon-back'              => __( 'Icon Back', 'wts-eae' ),
					'hvr-icon-forward'           => __( 'Icon Forward', 'wts-eae' ),
					'hvr-icon-down'              => __( 'Icon Down', 'wts-eae' ),
					'hvr-icon-up'                => __( 'Icon Up', 'wts-eae' ),
					'hvr-icon-spin'              => __( 'Icon Spin', 'wts-eae' ),
					'hvr-icon-drop'              => __( 'Icon Drop', 'wts-eae' ),
					'hvr-icon-fade'              => __( 'Icon Fade', 'wts-eae' ),
					'hvr-icon-float-away'        => __( 'Icon Float Away', 'wts-eae' ),
					'hvr-icon-sink-away'         => __( 'Icon Sink Away', 'wts-eae' ),
					'hvr-icon-grow'              => __( 'Icon Grow', 'wts-eae' ),
					'hvr-icon-shrink'            => __( 'Icon Shrink', 'wts-eae' ),
					'hvr-icon-pulse'             => __( 'Icon Pulse', 'wts-eae' ),
					'hvr-icon-pulse-grow'        => __( 'Icon Pulse Grow', 'wts-eae' ),
					'hvr-icon-pulse-shrink'      => __( 'Icon Pulse Shrink', 'wts-eae' ),
					'hvr-icon-push'              => __( 'Icon Push', 'wts-eae' ),
					'hvr-icon-pop'               => __( 'Icon Pop', 'wts-eae' ),
					'hvr-icon-bounce'            => __( 'Icon Bounce', 'wts-eae' ),
					'hvr-icon-rotate'            => __( 'Icon Rotate', 'wts-eae' ),
					'hvr-icon-grow-rotate'       => __( 'Icon Grow Rotate', 'wts-eae' ),
					'hvr-icon-float'             => __( 'Icon Float', 'wts-eae' ),
					'hvr-icon-sink'              => __( 'Icon Sink', 'wts-eae' ),
					'hvr-icon-bob'               => __( 'Icon Bob', 'wts-eae' ),
					'hvr-icon-hang'              => __( 'Icon Hang', 'wts-eae' ),
					'hvr-icon-wobble-horizontal' => __( 'Icon Wobble Horizontal', 'wts-eae' ),
					'hvr-icon-wobble-vertical'   => __( 'Icon Wobble Vertical', 'wts-eae' ),
					'hvr-icon-buzz'              => __( 'Icon Buzz', 'wts-eae' ),
					'hvr-icon-buzz-out'          => __( 'Icon Buzz Out', 'wts-eae' ),
				],
				'Border'          => [
					'hvr-border-fade'           => __( 'Border Fade', 'wts-eae' ),
					'hvr-hollow'                => __( 'Hollow', 'wts-eae' ),
					'hvr-trim'                  => __( 'Trim', 'wts-eae' ),
					'hvr-ripple-out'            => __( 'Ripple Out', 'wts-eae' ),
					'hvr-ripple-in'             => __( 'Ripple In', 'wts-eae' ),
					'hvr-outline-out'           => __( 'Outline Out', 'wts-eae' ),
					'hvr-outline-in'            => __( 'Outline In', 'wts-eae' ),
					'hvr-round-corners'         => __( 'Round Corners', 'wts-eae' ),
					'hvr-underline-from-left'   => __( 'Underline From Left', 'wts-eae' ),
					'hvr-underline-from-center' => __( 'Underline From Center', 'wts-eae' ),
					'hvr-underline-from-right'  => __( 'Underline From Right', 'wts-eae' ),
					'hvr-reveal'                => __( 'Reveal', 'wts-eae' ),
					'hvr-underline-reveal'      => __( 'Underline Reveal', 'wts-eae' ),
					'hvr-overline-reveal'       => __( 'Overline Reveal', 'wts-eae' ),
					'hvr-overline-from-left'    => __( 'Overline From Left', 'wts-eae' ),
					'hvr-overline-from-center'  => __( 'Overline From Center', 'wts-eae' ),
					'hvr-overline-from-right'   => __( 'Overline From Right', 'wts-eae' ),
				],
				'Shadow And Glow' => [
					'hvr-shadow'            => __( 'Shadow', 'wts-eae' ),
					'hvr-grow-shadow'       => __( 'Grow Shadow', 'wts-eae' ),
					'hvr-float-shadow'      => __( 'Trim', 'wts-eae' ),
					'hvr-ripple-out'        => __( 'Float Shadow', 'wts-eae' ),
					'hvr-glow'              => __( 'Glow', 'wts-eae' ),
					'hvr-shadow-radial'     => __( 'Shadow Radial', 'wts-eae' ),
					'hvr-box-shadow-outset' => __( 'Box Shadow Outset', 'wts-eae' ),
					'hvr-box-shadow-inset'  => __( 'Box Shadow Inset', 'wts-eae' ),
				]

			];
		}

		return self::$_hover_transition;
	}

	public function enqueue() {

		wp_register_script( 'eae-control', EAE_URL . 'assets/js/editor.js', [ 'jquery' ], '1.0.0' );
		wp_enqueue_script( 'eae-control' );
	}


	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
        <div class="elementor-control-field">
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" data-setting="{{ data.name }}">
                    <option value=""><?php echo __( 'None', 'wts-eae' ); ?></option>
					<?php foreach ( self::get_transitions() as $transitions_group_name => $transitions_group ) : ?>
                        <optgroup label="<?php echo $transitions_group_name; ?>">
							<?php foreach ( $transitions_group as $transition_name => $transition_title ) : ?>
                                <option value="<?php echo $transition_name; ?>"><?php echo $transition_title; ?></option>
							<?php endforeach; ?>
                        </optgroup>
					<?php endforeach; ?>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
		<?php
	}
}
