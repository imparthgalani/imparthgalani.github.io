<?php

namespace WTS_EAE\Modules\FlipBox;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'FlipBox',
		];
	}

	public function get_name() {
		return 'wts-flipbox';
	}

}