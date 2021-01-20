<?php

namespace WTS_EAE\Modules\Gmap;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Gmap',
		];
	}

	public function get_name() {
		return 'eae-gmap';
	}

}