<?php

namespace WTS_EAE\Modules\InfoCircle;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Info_Circle',
		];
	}

	public function get_name() {
		return 'eae-info-circle';
	}

}