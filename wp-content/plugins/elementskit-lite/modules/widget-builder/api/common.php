<?php 
namespace ElementsKit_Lite\Modules\Widget_Builder\Api;

defined( 'ABSPATH' ) || exit;

class Common extends \ElementsKit_Lite\Core\Handler_Api {

    public function config(){
        $this->prefix = 'widget-builder';
        $this->param  = "/(?P<id>\w+(|[-]\w+))/";
    }

    private function fix_title($title){
        return ($title == '') ? ('ElementsKit_Lite Custom Widget #' . time()) : $title;
    }


    public function post_push(){

         if(!is_user_logged_in() || !current_user_can( 'manage_options' )){

	         return [
		         'success' => false,
		         'message' => [
			         esc_html__("Not enough permission.", 'elementskit-lite')
		         ],
	         ];
         }


        $id = $this->request['id'];
        $data = json_decode($this->request['data']);

        if(!property_exists($data, 'title') || !property_exists($data, 'tabs') || !($data->tabs instanceof \stdClass) ) {

	        return [
		        'success' => false,
		        'message' => [
			        esc_html__("Invalid data.", 'elementskit-lite')
		        ],
	        ];
        }

        $title = $this->fix_title($data->title);

        $widget_data = [
            'post_title' => $title,
            'post_status' => 'publish',
            'post_type' => 'elementskit_widget',
        ];

        $widget = get_post($id);
        
        if($widget == null){
            $id = wp_insert_post($widget_data);
        }else{
            $widget_data['ID'] = $id;
            wp_update_post( $widget_data );
        }
        update_post_meta( $id, '_elementor_edit_mode', 'builder' );
        update_post_meta( $id, '_wp_page_template', 'elementor_canvas' );

        $data->push_id = $id;

        //update_post_meta( $id, '_wp_page_template', 'elementor_canvas' );
        update_post_meta( $id, 'elementskit_custom_widget_data', $data );
        \ElementsKit_Lite\Modules\Widget_Builder\Widget_File::instance()->create($data, $id);

        return [
            'success' => true,
            'message' => [
                esc_html__("Widget data saved!", 'elementskit-lite')
            ],
            'push_id' => $id
        ];

    }

    public function post_pull(){

	    if(!is_user_logged_in() || !current_user_can( 'manage_options' )){

		    return [
			    'success' => false,
			    'message' => [
				    esc_html__("Not enough permission.", 'elementskit-lite')
			    ],
		    ];
	    }

        $id = $this->request['id'];
        $default = [
            'title' => 'New Widget',
            'icon' => 'eicon-cog',
            'categories' => ['basic'],
            'push_id' => $id,
            'markup' => '',
            'css' => '',
            'js' => '',
            'css_includes' => '',
            'js_includes' => '',
            'tabs' => [
                'content' => [],
                'style' => [],
                'advanced' => []
            ]            
        ];

        $widget_data = get_post_meta($id, 'elementskit_custom_widget_data', true);

        // var_dump(is_object($widget_data));
        return is_object($widget_data) ? $widget_data : $default;
    }


    public function post_import() {


		//$id = $this->request['id'];


		return [
			'success' => true,
			'message' => 'hi',
			//'file' => $this->request
		];
	}
}
