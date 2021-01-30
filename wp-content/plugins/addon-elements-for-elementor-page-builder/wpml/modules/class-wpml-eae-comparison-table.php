<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Comparison_Table extends WPML_Elementor_Module_With_Items{

    public function get_items_field() {
        return 'features_text';
    }

    public function get_fields() {
        return array( 'legend_feature_text', 'legend_feature_tooltip_text'  );
    }

    protected function get_title( $field ) {

        switch( $field ) {

            case 'legend_feature_text':
                return esc_html__( 'Comparison Table: Feature', 'wts-eae' );

            case 'legend_feature_tooltip_text':
                return esc_html__( 'Comparison Table: Tooltip', 'wts-eae' );

            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {

        switch( $field ) {
            case 'legend_feature_text':
            case 'legend_feature_tooltip_text':
                return 'LINE';

            default:
                return '';
        }
    }
}