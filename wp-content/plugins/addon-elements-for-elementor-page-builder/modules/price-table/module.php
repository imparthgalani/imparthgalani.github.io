<?php

namespace WTS_EAE\Modules\PriceTable;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'PriceTable',
		];
	}

	public function get_name() {
		return 'eae-pricetable';
	}

}