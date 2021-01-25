<?php

/*
Plugin Name: Preloader Plus
Plugin URI: https://wordpress.org/plugins/preloader-plus/
Description: Add a page loading screen to your website with style and animations, easy to customize, works on all major browsers and with any theme, any device.
Version: 2.2.1
Author: Massimo Sanfelice | Maxsdesign
Author URI: https://wp-brandtheme.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: preloader-plus
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Main plugin class with initialization tasks.
 */
if ( ! class_exists( 'Preloader_Plus_Plugin' ) ) {
	class Preloader_Plus_Plugin {
		/**
	 	* Constructor for this class.
	 	*/
		public function __construct() {
			/**
		 	* Display admin error message if PHP version is older than 5.4.
		 	* Otherwise check the active theme.
		 	*/
			if ( version_compare( phpversion(), '5.4', '<' ) ) {
				add_action( 'admin_notices', array( $this, 'old_php_admin_error_notice' ) );
			}

			else {
				// Set plugin constants.
				$this->set_plugin_constants();

				// Load main class.
				require_once PRELOADER_PLUS_PATH . 'inc/preloader-plus.php';

				// Instantiate the main plugin class *Singleton*.
				$preloader_plus = Preloader_Plus\Preloader_Plus::get_instance();

				// Load premium.
				require_once PRELOADER_PLUS_PATH . 'preloader-plus-pro/inc/preloader-plus-pro.php';
				// Instantiate the pro class *Singleton*.
				$preloader_plus = Preloader_Plus_Pro\Preloader_Plus_Pro::get_instance();
			}
		}

		/**
	 	* Display an admin error notice when PHP is older the version 5.4.
	 	* Hook it to the 'admin_notices' action.
	 	*/
		public function old_php_admin_error_notice() {
			$message = sprintf( esc_html__( 'The %2$sPreloader Plus%3$s plugin requires %2$sPHP 5.4+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.4%4$s Your current version of PHP: %2$s%1$s%3$s', 'preloader-plus' ), phpversion(), '<strong>', '</strong>', '<br>' );

			printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
		}

		/**
	 	* Set plugin constants.
	 	*
	 	* Path/URL to root of this plugin, with trailing slash and plugin version.
	 	*/
		private function set_plugin_constants() {
			// Path/URL to root of this plugin, with trailing slash.
			if ( ! defined( 'PRELOADER_PLUS_PATH' ) ) {
				define( 'PRELOADER_PLUS_PATH', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'PRELOADER_PLUS_URL' ) ) {
				define( 'PRELOADER_PLUS_URL', plugin_dir_url( __FILE__ ) );
			}
			if ( ! defined( 'PRELOADER_PLUS_PRO_PATH' ) ) {
				define( 'PRELOADER_PLUS_PRO_PATH', plugin_dir_path( __FILE__ ) . 'preloader-plus-pro/' );
			}
			// Action hook to set the plugin version constant.
			add_action( 'init', array( $this, 'set_plugin_version_constant' ) );
		}


		/**
	 	* Set plugin version constant -> PRELOADER_PLUS_VERSION.
	 	*/
		public function set_plugin_version_constant() {
			if ( ! defined( 'PRELOADER_PLUS_VERSION' ) ) {
				define( 'PRELOADER_PLUS_VERSION', '2.2.1' );
			}
		}
	}

	// Instantiate the plugin class.
	$preloader_plus_plugin = new Preloader_Plus_Plugin();

}
