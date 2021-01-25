<?php

namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Price_Table extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'feature-list';
    }

    public function get_fields() {
        return array( 'text' );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'text':
                return esc_html__( 'Plan Features: Text', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {
            case 'text':
                return 'LINE';

            default:
                return '';
        }
    }
}