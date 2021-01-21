<?php

namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Gmap extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'markers';
    }

    public function get_fields() {
        return array( 'address' );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'address':
                return esc_html__( 'Google Map: Address', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {

            case 'address':
                return 'VISUAL';

            default:
                return '';
        }
    }
}