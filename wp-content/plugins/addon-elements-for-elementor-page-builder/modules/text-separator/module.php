<?php

namespace WTS_EAE\Modules\TextSeparator;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'TextSeparator',
		];
	}

	public function get_name() {
		return 'eae-textseparator';
	}

}