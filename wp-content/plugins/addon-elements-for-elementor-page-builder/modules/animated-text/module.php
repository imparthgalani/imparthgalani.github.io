<?php

namespace WTS_EAE\Modules\AnimatedText;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'AnimatedText',
		];
	}

	public function get_name() {
		return 'eae-animatedtext';
	}

	public function add_dependent_js_css(){
		wp_enqueue_script('animated-main');
	}

}