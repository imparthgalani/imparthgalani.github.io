<?php
namespace ElementsKit_Lite\Compatibility\WPML\Widgets;

use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Ekit_Image_Accordion
 *
 * @since 1.2.6
 */
class Ekit_Faq extends WPML_Elementor_Module_With_Items {

	/**
	 * Retrieve the field name.
	 *
	 * @since 1.2.6
	 * @return string
	 */
	public function get_items_field() {
		return 'ekit_faq_content_items';
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
			'ekit_faq_title',
			'ekit_faq_content',
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
			case 'ekit_faq_title':
				return esc_html__( 'Title (FAQ)', 'elementskit-lite' );
				break;

			case 'ekit_faq_content':
				return esc_html__( 'Content (FAQ)', 'elementskit-lite' );
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
			case 'ekit_faq_title':
				return 'LINE';

			case 'ekit_faq_content':
				return 'VISUAL';

			default:
				return '';
		}

	}
}
