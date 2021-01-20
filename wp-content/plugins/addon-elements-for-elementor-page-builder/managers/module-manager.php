<?php
namespace WTS_EAE\Managers;
use WTS_EAE\Classes\Helper;

class Module_Manager {
	protected $modules = [];
	public function __construct() {
		$helper = new Helper();
		$this->modules = $helper->get_eae_modules() ;

		$this->modules = apply_filters('wts_eae_active_modules', $this->modules);
		// Todo:: apply filter for modules that depends on third party plugins

		foreach ( $this->modules as $key => $module_name ) {
			if($module_name['enabled'] == 'true' || trim($module_name['enabled']) === '' || $module_name['enabled'] == null){
				$class_name = str_replace( '-', ' ', $key );
				//$class_name = $module_name['Name'];
				$class_name = str_replace( ' ', '', ucwords( $class_name ) );
				$class_name = 'WTS_EAE' . '\\Modules\\' . $class_name . '\Module';

				$this->modules[ $module_name['name'] ] = $class_name::instance();
			}

		}
	}
}