<?php

namespace WTS_EAE\Modules\ThumbGallery;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'ThumbGallery',
		];
	}

	public function get_name() {
		return 'eae-thumbgallery';
	}

}