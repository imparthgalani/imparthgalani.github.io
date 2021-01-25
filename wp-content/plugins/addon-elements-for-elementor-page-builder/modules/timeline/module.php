<?php

namespace WTS_EAE\Modules\Timeline;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Timeline',
		];
	}

	public function get_name() {
		return 'eae-timeline';
	}

}