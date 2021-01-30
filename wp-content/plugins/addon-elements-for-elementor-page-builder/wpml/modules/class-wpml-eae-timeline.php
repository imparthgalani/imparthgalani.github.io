<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Timeline extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'timeline_items';
    }

    public function get_fields() {
        return array( 'item_date', 'item_title_text', 'item_content'  );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'item_date':
                return esc_html__( 'Timeline: Date', 'wts-eae' );

            case 'item_title_text':
                return esc_html__( 'Timeline: Title', 'wts-eae' );

            case 'item_content':
                return esc_html__( 'Timeline: Content', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {
            case 'item_date':
                return 'LINE';

            case 'item_title_text':
                return 'LINE';

            case 'item_content':
                return 'VISUAL';

            default:
                return '';
        }
    }
}