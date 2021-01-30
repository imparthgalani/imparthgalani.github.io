<?php

namespace WTS_EAE\Modules\SplitText;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'SplitText',
		];
	}

	public function get_name() {
		return 'eae-splittext';
	}

}