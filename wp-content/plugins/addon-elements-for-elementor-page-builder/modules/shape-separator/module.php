<?php

namespace WTS_EAE\Modules\ShapeSeparator;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'ShapeSeparator',
		];
	}

	public function get_name() {
		return 'eae-shapeseparator';
	}

}