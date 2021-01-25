<?php
/**
 * Main Preloader Plus Pro plugin class/file.
 *
 * @package preloader-plus
 */

namespace Preloader_Plus_Pro;

/**
 * Preloader Plus class, so we don't have to worry about namespaces.
 */
class Preloader_Plus_Pro {
	/**
	 * The instance *Singleton* of this class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Preloader_Plus_Pro the *Singleton* instance.
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Class construct function, to initiate the plugin.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		// Loads files
		require_once PRELOADER_PLUS_PRO_PATH . 'inc/customizer.php';
	}


	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}


	/**
	 * Get preloader options.
	 *
	 * @since 1.0
	 */
	 public function get_options() {
		 // Get preloader options.
	 	$preloader_plus_settings = wp_parse_args(
	 		get_option( 'preloader_plus_settings', array() ),
	 		preloader_plus_get_default()
	 	);
		return $preloader_plus_settings;
	}




}
