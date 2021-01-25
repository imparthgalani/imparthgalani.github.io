<?php

namespace WTS_EAE\Modules\PostList;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'PostList',
		];
	}

	public function get_name() {
		return 'eae-postlist';
	}
}