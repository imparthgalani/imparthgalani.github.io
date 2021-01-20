<?php

namespace WTS_EAE\Modules\ContentSwitcher;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Content_Switcher',
        ];
    }

    public function get_name() {
        return 'eae-content-switcher';
    }

}