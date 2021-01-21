<?php
namespace ElementsKit_Lite\Compatibility\WPML\Widgets;

use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Ekit_Image_Accordion
 *
 * @since 1.2.6
 */
class Ekit_Cat_List extends WPML_Elementor_Module_With_Items {

	/**
	 * Retrieve the field name.
	 *
	 * @since 1.2.6
	 * @return string
	 */
	public function get_items_field() {
		return 'icon_list';
	}

	/**
	 * Retrieve the fields inside the repeater
	 *
	 * @since 1.2.6
	 *
	 * @return array
	 */
	public function get_fields() {
		return array(
			'text',
		);
	}

	/**
	 * Method for setting the title for each translatable field
	 *
	 * @since 1.2.6
	 *
	 * @param string $field The name of the field.
	 * @return string
	 */
	protected function get_title( $field ) {

		switch ( $field ) {
			case 'text':
				return esc_html__( 'Test (Category List)', 'elementskit-lite' );
				break;

			default:
				return '';
		}

	}

	/**
	 * Method for determining the editor type for each field
	 *
	 * @since 1.2.6
	 *
	 * @param  string $field Name of the field.
	 * @return string
	 */
	protected function get_editor_type( $field ) {

		switch ( $field ) {
			case 'text':
				return 'LINE';

			default:
				return '';
		}

	}
}
