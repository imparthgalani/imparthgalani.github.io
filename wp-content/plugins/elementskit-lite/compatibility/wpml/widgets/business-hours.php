<?php
namespace ElementsKit_Lite\Compatibility\WPML\Widgets;

use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Ekit_Image_Accordion
 *
 * @since 1.2.6
 */
class Ekit_Business_Hours extends WPML_Elementor_Module_With_Items {

	/**
	 * Retrieve the field name.
	 *
	 * @since 1.2.6
	 * @return string
	 */
	public function get_items_field() {
		return 'ekit_business_openday_list';
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
			'ekit_business_day',
			'ekit_business_time',
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
			case 'ekit_business_day':
				return esc_html__( 'Day (Business Hours)', 'elementskit-lite' );
				break;

			case 'ekit_business_time':
				return esc_html__( 'Time (Business Hours)', 'elementskit-lite' );
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
			case 'ekit_business_day':
				return 'LINE';

			case 'ekit_business_time':
				return 'LINE';

			default:
				return '';
		}

	}
}
