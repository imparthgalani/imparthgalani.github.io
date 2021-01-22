<?php
/*
Plugin Name: Simple CSS
Plugin URI: https://generatepress.com
Description: Simply add CSS to your WordPress site using an awesome CSS editor or the live Customizer.
Version: 1.1.1
Author: Tom Usborne
Author URI: https://tomusborne.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'simple_css_admin_menu' );
/**
 * Add the admin menu page.
 *
 * @since 0.1
 */
function simple_css_admin_menu() {
	$setting = add_theme_page(
		__( 'Simple CSS', 'simple-css' ),
		__( 'Simple CSS', 'simple-css' ),
		'edit_theme_options',
		'simple-css',
		'simple_css_editor'
	);

	if ( ! $setting ) {
		return;
	}

    add_action( 'load-' . $setting, 'simple_css_scripts' );
}

/**
 * Enqueue all necessary scripts and styles.
 *
 * @since 0.1
 */
function simple_css_scripts() {
	wp_enqueue_script( 'simple-css-codemirror-js', plugin_dir_url( __FILE__ ) . 'js/codemirror.js', array( 'jquery' ), null );
	wp_enqueue_script( 'simple-css-js', plugin_dir_url( __FILE__ ) . 'js/css.js', array( 'jquery' ), null );
	wp_enqueue_style( 'simple-css-codemirror-css', plugin_dir_url( __FILE__ ) . 'css/codemirror.css', null, null );
	wp_enqueue_style( 'simple-css-ambiance-css', plugin_dir_url( __FILE__ ) . 'css/ambiance.css', null, null );
	wp_enqueue_style( 'simple-css', plugin_dir_url( __FILE__ ) . 'css/style.css', null, null );
}

add_action( 'admin_init', 'simple_css_register_setting' );
/**
 * Register the settings for the admin page.
 *
 * @since 0.1
 */
function simple_css_register_setting() {
	register_setting(
		'simple_css',
		'simple_css',
		'simple_css_validate'
	);
}

/**
 * Build the admin page.
 *
 * @since 0.1
 */
function simple_css_editor() {
	$options    = get_option( 'simple_css' );
	$css = isset( $options['css'] ) ? strip_tags( $options['css'] ) : '';
	$theme = isset( $options['theme'] ) ? $options['theme'] : '';

	if ( '' == $theme ) {
		$theme = 1;
	}

	if ( 1 == $theme ) {
		$theme_name = 'ambiance';
	} else {
		$theme_name = 'default';
	}
	?>

	<div class="wrap" id="poststuff">
		<?php settings_errors(); ?>
		<div id="post-body" class="simple-css metabox-holder columns-2">
			<form action="options.php" method="post">
				<div id="post-body-content">
					<?php settings_fields( 'simple_css' ); ?>
					<div class="simple-css-container" data-theme="<?php echo $theme_name; ?>">
						<textarea name="simple_css[css]" id="simple-css-textarea"><?php echo $css; ?></textarea>
					</div>
				</div>

				<div id="postbox-container-1" class="postbox-container simple-css-sidebar">
					<div>
						<?php submit_button( __( 'Save CSS', 'simple-css' ), 'primary large simple-css-save' ); ?>

						<div class="color-theme">
							<select class="change-theme" name="simple_css[theme]" id="simple_css[theme]">
								<option value="1" <?php selected( $theme, 1 ); ?>><?php _e( 'Dark','simple-css' );?></option>
								<option value="2" <?php selected( $theme, 2 ); ?>><?php _e( 'Light','simple-css' );?></option>
							</select>
						</div>

						<?php if ( ! defined( 'GENERATE_VERSION' ) ) : ?>
							<div class="postbox">
								<h3 class="hndle"><span><?php _e( 'GeneratePress', 'simple-css' ); ?></span></h3>
								<div class="inside">
									<p><?php printf( __( 'Check out our free WordPress theme, %s.', 'simple-css' ), '<a href="https://generatepress.com" target="_blank">GeneratePress</a>' ); ?></p>
								</div>
							</div>
						<?php endif; ?>

						<div class="postbox">
							<h3 class="hndle"><span><?php _e( 'Customizer', 'simple-css' ); ?></span></h3>
							<div class="inside">
								<p><?php printf( __( 'Want to live preview your CSS changes? Check out the Simple CSS textarea in the %1$sCustomize%2$s area.', 'simple-css' ), '<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">', '</a>' ); ?></p>
							</div>
						</div>

						<div class="postbox">
							<h3 class="hndle"><span><?php _e( 'Tips', 'simple-css' ); ?></span></h3>
							<div class="inside">
								<p><?php _e( 'Simple CSS should not be used for huge documents. If your CSS is larger than 1000 lines, you should consider using a child theme.', 'simple-css' ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Sanitize our saved values.
 *
 * @since 0.1
 */
function simple_css_validate( $input ) {
	$input['css'] = strip_tags( $input['css'] );
	$input['theme'] = sanitize_text_field( $input['theme'] );
	return $input;
}

add_action( 'customize_register', 'simple_css_customize' );
/**
 * Create the Customizer option.
 *
 * @since 0.1
 */
function simple_css_customize( $wp_customize ) {
	require_once( plugin_dir_path( __FILE__ ) . 'customize/css-control.php' );

	$wp_customize->add_section( 'simple_css_section',
		array(
			'title'       => __( 'Simple CSS', 'simple-css' ),
			'priority'    => 200,
		)
	);

	$wp_customize->add_setting( 'simple_css[css]' ,
		array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_css_sanitize_css',
			'transport'			=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Simple_CSS_Editor(
			$wp_customize, 'simple_css',
			array(
				'section'  => 'simple_css_section',
				'settings' => 'simple_css[css]'
			)
		)
	);
}

add_action( 'customize_preview_init', 'simple_css_live_preview' );
/**
 * Add our live preview.
 *
 * @since 1.0
 */
function simple_css_live_preview() {
	wp_enqueue_script( 'simple-css-live-preview', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/live-preview.js', array( 'customize-preview' ), null, true );
}

/**
 * Strip HTML from our CSS.
 *
 * @since 1.0
 *
 * @param $input Our initial CSS.
 */
function simple_css_sanitize_css( $input ) {
	return strip_tags( $input );
}

add_action( 'wp_head', 'simple_css_generate' );
/**
 * Generate the CSS in the wp_head hook.
 *
 * @since 0.1
 */
function simple_css_generate() {
	$options = get_option( 'simple_css', array() );
	$output = '';

	if ( isset( $options['css'] ) ) {
		$output = $options['css'];
	}

	if ( is_singular() ) {
		$output .= get_post_meta( get_the_ID(), '_simple_css', true );
	}

	if ( '' == $output ) {
		return;
	}

	$output = str_replace( array( "\r", "\n" ), '', $output );
	$output = preg_replace( '/\s+/', ' ', $output );

	// Finally, print it
	echo '<style type="text/css" id="simple-css-output">';
		echo strip_tags( $output );
	echo '</style>';
}

add_action( 'add_meta_boxes', 'simple_css_metabox' );
/**
 * Add our Simple CSS meta box.
 *
 * @since 0.1
 */
function simple_css_metabox() {
	// Set user role - make filterable
	$allowed = apply_filters( 'simple_css_metabox_capability', 'activate_plugins' );

	// If not an administrator, don't show the metabox
	if ( ! current_user_can( $allowed ) ) {
		return;
	}

	$args = array( 'public' => true );
	$post_types = get_post_types( $args );
	foreach ($post_types as $type) {
		add_meta_box
		(
			'simple_css_metabox',
			__( 'Simple CSS','simple-css' ),
			'simple_css_show_metabox',
			$type,
			'normal',
			'default'
		);
	}
}

/**
 * Outputs the content of the metabox.
 *
 * @since 0.1
 *
 * @param $post Object
 */
function simple_css_show_metabox( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'simple_css_nonce' );
	$options = get_post_meta( $post->ID );
	$css = isset( $options[ '_simple_css' ] ) ? $options[ '_simple_css' ][0] : false;
	?>
	<p>
		<textarea style="width:100%;height:300px;" name="_simple_css" id="simple-css-textarea"><?php echo strip_tags( $css ); ?></textarea>
	</p>
	<?php
}

add_action( 'save_post', 'simple_css_save_metabox' );
/**
 * Save our meta box value.
 *
 * @since 0.1
 *
 * @param $post_id boolean
 */
function simple_css_save_metabox( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'simple_css_nonce' ] ) && wp_verify_nonce( $_POST[ 'simple_css_nonce' ], basename( __FILE__ ) ) ) ? true : false;

	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}

	if ( isset( $_POST[ '_simple_css' ] ) && $_POST[ '_simple_css' ] !== '' ) {
		update_post_meta( $post_id, '_simple_css', strip_tags( $_POST[ '_simple_css' ] ) );
	} else {
		delete_post_meta( $post_id, '_simple_css' );
	}
}
