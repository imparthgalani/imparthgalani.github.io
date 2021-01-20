<?php

namespace WTS_EAE\Base;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Module
 *
 * Base
 *
 * @since 1.0.0
 */
abstract class Module_Base {

	/**
	 * @var \ReflectionClass
	 */
	private $reflection;

	/**
	 * @var Module_Base
	 */
	protected static $_instances = [];

	/**
	 * Abstract method for retrieveing the module name
	 *
	 * @access public
	 * @since 1.0.0
	 */
	abstract public function get_name();

	/**
	 * Return the current module class name
	 *
	 * @access public
	 * @since 1.6.0
	 *
	 * @eturn string
	 */
	public static function class_name() {
		return get_called_class();
	}

	/**
	 * @return static
	 */
	public static function instance() {
		if ( empty( static::$_instances[ static::class_name() ] ) ) {
			static::$_instances[ static::class_name() ] = new static();
		}

		return static::$_instances[ static::class_name() ];
	}

	/**
	 * Constructor
	 *
	 * Hook into Elementor to register the widgets
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->reflection = new \ReflectionClass( $this );

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'add_dependent_js_css' ] );
	}

	/**
	 * Initializes all widget for the current module
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_widgets() {
		$widget_manager = Plugin::instance()->widgets_manager;

		foreach ( $this->get_widgets() as $widget ) {

			$class_name = $this->reflection->getNamespaceName() . '\Widgets\\' . $widget;

			$widget_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Check if widget is disabled from admin or
	 * it depends on any third party plugin that is not active
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @param  string $widget_name Widget unique name
	 *
	 * @return bool
	 */
	public function is_widget_disabled( $widget_name ) {

		// Todo:: Add Enable/Disable logic
		if ( ! $widget_name ) {
			return false;
		}

		return true;
	}

	/**
	 * Method for retrieveing this module's widgets
	 *
	 * @access public
	 * @since 1.6.0
	 *
	 * @return void
	 */
	public function get_widgets() {
		return [];
	}

	public function add_dependent_js_css(){

	}
}
