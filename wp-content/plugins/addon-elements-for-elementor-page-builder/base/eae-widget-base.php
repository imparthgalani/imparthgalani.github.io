<?php

namespace WTS_EAE\Base;

use Elementor\Widget_Base;

abstract class EAE_Widget_Base extends Widget_Base{

	public function get_categories() {
		return [ 'wts-eae' ];
	}
}