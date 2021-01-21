<?php

namespace WTS_EAE\Modules\Twitter;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Twitter',
		];
	}

	public function get_name() {
		return 'eae-twitter';
	}

}