<?php
namespace ElementsKit_Lite\Core;

use ElementsKit_Lite\Libs\Framework\Attr;

defined( 'ABSPATH' ) || exit;

class Build_Widgets{

	/**
	 * Collection of default widgets.
	 *
	 * @since 1.0.0
	 * @access private
	 */
    private $active_widgets;
    private $all_widgets;

    use \ElementsKit_Lite\Traits\Singleton;

    public function __construct() {

        new \ElementsKit_Lite\Widgets\Init\Enqueue_Scripts;

        $this->all_widgets = \ElementsKit_Lite\Config\Widget_List::instance()->get_list();
        $this->active_widgets = Attr::instance()->utils->get_option('widget_list', array_keys($this->all_widgets));

        // check if the widget is exists
        foreach($this->active_widgets as $widget_slug){
            if(array_key_exists($widget_slug, $this->all_widgets)){
                if($this->all_widgets[$widget_slug]['package'] != 'pro-disabled'){
                    $this->add_widget($this->all_widgets[$widget_slug]);
                }
            }
        }

        add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widget']);
    }


    public function add_widget($widget_config){

        $widget_dir = (
            isset($widget_config['path']) 
            ? $widget_config['path'] 
            : \ElementsKit_Lite::widget_dir() . $widget_config['slug'] . '/'
        );

        include $widget_dir . $widget_config['slug'] . '.php';
        include $widget_dir . $widget_config['slug'] . '-handler.php';

        $base_class_name = (
            (isset($widget_config['base_class_name']))
            ? $widget_config['base_class_name']
            : '\Elementor\ElementsKit_Widget_' . \ElementsKit_Lite\Utils::make_classname($widget_config['slug'])
        );

        $handler = $base_class_name . '_Handler';
        $handler_class = new $handler();

        if($handler_class->scripts() != false){
            add_action( 'wp_enqueue_scripts', [$handler_class, 'scripts'] );
        }

        if($handler_class->styles() != false){
            add_action( 'wp_enqueue_scripts', [$handler_class, 'styles'] );
        }

        if($handler_class->inline_css() != false){
            wp_add_inline_style( 'elementskit-init-css', $handler_class->inline_css());
        }

        if($handler_class->inline_js() != false){
            wp_add_inline_script( 'elementskit-init-js', $handler_class->inline_js());
        }

        if($handler_class->register_api() != false){
            if(\file_exists($handler_class->register_api())){
                include_once $handler_class->register_api();
                $api = $base_class_name . '_Api';
                new $api();
            }
        }

        if($handler_class->wp_init() != false){
            add_action('init', [$handler_class, 'wp_init']);
        }
    }


    public function register_widget($widgets_manager){
        foreach($this->active_widgets as $widget_slug){
            if(array_key_exists($widget_slug, $this->all_widgets)){
                $class_name = '\Elementor\ElementsKit_Widget_' . \ElementsKit_Lite\Utils::make_classname($widget_slug);
                if(class_exists($class_name)){
                    $widgets_manager->register_widget_type(new $class_name());
                }
            }
        }
    }
}