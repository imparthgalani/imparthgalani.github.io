<?php

namespace WTS_EAE\Modules\ProgressBar;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Progress_Bar',
		];
	}

	public function get_name() {
		return 'eae-progress-bar';
	}

}