<?php

namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Filterable_Gallery extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'eae_filterable_gallery_content';
    }

    public function get_fields() {
        return array( 'eae_filter_label' );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'eae_filter_label':
                return esc_html__( 'Filterable Gallery: Filter Label', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {
            case 'eae_filter_label':
                return 'LINE';

            default:
                return '';
        }
    }
}