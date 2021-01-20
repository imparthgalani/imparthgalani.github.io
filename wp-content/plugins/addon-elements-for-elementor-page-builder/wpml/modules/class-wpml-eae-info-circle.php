<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Info_Circle extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'info_circle_items';
    }

    public function get_fields() {
        return array( 'ic_item_title', 'ic_item_content'  );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'ic_item_title':
                return esc_html__( 'Info Circle: Title', 'wts-eae' );

            case 'ic_item_content':
                return esc_html__( 'Info Circle: Content', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {
            case 'ic_item_title':
                return 'LINE';

            case 'ic_item_content':
                return 'AREA';

            default:
                return '';
        }
    }
}