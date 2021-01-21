<?php
namespace ElementsKit_Lite\Modules\Widget_Builder;

defined( 'ABSPATH' ) || exit;


class Live_Action{
    private $id;

    public function __construct(){
        $this->id = (int) (!isset($_GET['post']) ? 0 : $_GET['post']);

        if($this->id == 0 || !isset($_GET['action']) || $_GET['action'] != 'elementor'){
            return;
        }

        if(get_post_type($this->id) != 'elementskit_widget'){
            return;
        }

        add_action('init', [$this, 'reset']);
    }

    public function reset(){
        update_post_meta( $this->id, '_wp_page_template', 'elementor_canvas' );

        update_post_meta( $this->id, '_elementor_data', 
            '[{"id":"e3a6ad6","elType":"section","settings":[],"elements":[{"id":"77605d8","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"0d8eeb3","elType":"widget","settings":{},"elements":[],"widgetType":"ekit_wb_'.$this->id.'"}],"isInner":false}],"isInner":false}]'
        );
    }
}