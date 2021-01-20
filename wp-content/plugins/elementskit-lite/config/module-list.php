<?php

namespace ElementsKit_Lite\Config;

use ElementsKit_Lite\Libs\Framework\Attr;

defined('ABSPATH') || exit;

class Module_List{
    use \ElementsKit_Lite\Traits\Singleton;

	/*
	todo: format the comment appropiatly
	Usage:
	get full list >> get_list() []

	get full list of active modules >> get_list(true, '', 'active') // []

	get specific module data >> get_list(true, 'image-accordion') [] or false

	get specific module data (if active) >> get_list(true, 'header-footer', 'active') [] or false
	*/
	public function get_list($filtered = true, $module = '', $check_mathod = 'list') {
		$all_list = self::$list;

		if($filtered == true) {
			$all_list = apply_filters('elementskit/modules/list', self::$list);
		}

		if($check_mathod == 'active') {
			$active_list = Attr::instance()->utils->get_option('module_list', array_keys($all_list));
			$active_list = array_merge($active_list, self::$system_modules);

			// checking active widgets

			foreach($all_list as $widget_slug => $info) {
				if(!in_array($widget_slug, $active_list)) {
					unset($all_list[$widget_slug]);
				}
			}
		}

		if($module != '') {
			return (!isset($all_list[$module]) ? false : $all_list[$module]);
		}

		return $all_list;
	}


	/**
	 * Check if a module is active or not, pro-disabled package are considered inactive
	 *
	 * Usage : \ElementsKit_Lite\Config\Module_List::instance()->is_active('facebook-messenger')
	 *
	 * @param $module_slug
	 *
	 * @return bool
	 */
	public function is_active($module_slug) {

		$act = Module_List::instance()->get_list(true, $module_slug, 'active');

		return empty($act['package']) ? false : (($act['package'] == 'free' || $act['package'] == 'pro'));
	}
    
    private static $system_modules = [
        'dynamic-content',
        'library',
        'controls',
    ];

    private static $list = [
        'header-footer' => [
            'slug' => 'header-footer',
            'title' => 'Header Footer',
            'package' => 'free', // free, pro, pro-disabled
            //'path' => null,
            //'base_class_name' => null,
            //'live' => null
        ],
        'megamenu' => [
            'slug' => 'megamenu',
            'package' => 'free',
            'title' => 'Mega Menu'
        ],
        'onepage-scroll' => [
            'slug' => 'onepage-scroll',
            'package' => 'free',
            'title' => 'Onepage Scroll'
        ],
        'widget-builder' => [
            'slug' => 'widget-builder',
            'package' => 'free',
            'title' => 'Widget Builder'
        ],
        'parallax' => [
            'slug' => 'parallax',
            'package' => 'pro-disabled',
            'title' => 'Parallax Effects'
        ],
        'sticky-content' => [
            'slug' => 'sticky-content',
            'package' => 'pro-disabled',
            'title' => 'Sticky Content'
        ],
        'facebook-messenger' => [
            'slug'    => 'facebook-messenger',
	        'package' => 'pro-disabled',
	        'title'   => 'Facebook Messenger',
        ],
        'conditional-content' => [
            'slug'    => 'conditional-content',
            'package' => 'pro-disabled',
            'title'   => 'Conditional Content',
        ],
        'copy-paste-cross-domain' => [
            'slug' => 'copy-paste-cross-domain',
            'package' => 'pro-disabled',
            'title' => 'Cross-Domain Copy Paste'
        ],
        'advanced-tooltip'  => [
            'slug'      => 'advanced-tooltip',
            'package'   => 'pro-disabled',
            'title'     => 'Advanced Tooltip',
        ]
    ];
    
}