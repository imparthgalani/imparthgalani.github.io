<?php

namespace ElementsKit_Lite\Traits;

/**
 * Trait for making singleton instance
 *
 * @package ElementsKit_Lite\Traits
 */
trait Singleton {

	private static $instance;


	public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
	}
}