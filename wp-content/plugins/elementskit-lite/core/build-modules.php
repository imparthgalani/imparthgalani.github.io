<?php
namespace ElementsKit_Lite\Core;
use ElementsKit_Lite\Libs\Framework\Attr;

defined( 'ABSPATH' ) || exit;

/**
 * Module registrar.
 *
 * Call assosiated classes of every modules.
 *
 * @since 1.0.0
 * @access public
 */
class Build_Modules{

    private $all_modules;

    private $active_modules;

    use \ElementsKit_Lite\Traits\Singleton;

	/**
	 * Hold the module list.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */

    private $system_modules = [
        'dynamic-content',
        'library',
        'controls',
    ];

    public function __construct(){
        $this->all_modules = \ElementsKit_Lite\Config\Module_List::instance()->get_list();
        $this->active_modules = Attr::instance()->utils->get_option('module_list', array_keys($this->all_modules));
        $this->active_modules = array_merge($this->active_modules, $this->system_modules);

        foreach($this->active_modules as $module_slug){
            if(isset($this->all_modules[$module_slug]['package']) && $this->all_modules[$module_slug]['package'] == 'pro-disabled'){
                continue;
            }

            if(isset($this->all_modules[$module_slug]['path'])){
                include_once $this->all_modules[$module_slug]['path'] . 'init.php';
            }

            // make the class name and call it.
            $class_name = (
                isset($this->all_modules[$module_slug]['base_class_name'])
                ? $this->all_modules[$module_slug]['base_class_name']
                : '\ElementsKit_Lite\Modules\\'. \ElementsKit_Lite\Utils::make_classname($module_slug) .'\Init'
            );
            if(class_exists($class_name)){
                new $class_name();
            }
        }
    }
}