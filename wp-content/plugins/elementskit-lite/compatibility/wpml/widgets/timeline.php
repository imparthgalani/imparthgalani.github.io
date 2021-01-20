<?php
namespace ElementsKit_Lite\Compatibility\WPML\Widgets;

use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Ekit_Image_Accordion
 *
 * @since 1.2.6
 */
class Ekit_Timeline extends WPML_Elementor_Module_With_Items {

	/**
	 * Retrieve the field name.
	 *
	 * @since 1.2.6
	 * @return string
	 */
	public function get_items_field() {
		return 'ekit_timelinehr_content_repeater';
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
			'ekit_timeline_line_subtitle',
			'ekit_timeline_line_title',
			'ekit_timeline_line_content',
			'ekit_timeline_content_date',
			'ekit_timelinehr_content_address',
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
			case 'ekit_timeline_line_subtitle':
				return esc_html__( 'Sub Title (Timeline)', 'elementskit-lite' );
				break;

			case 'ekit_timeline_line_title':
				return esc_html__( 'Title (Timeline)', 'elementskit-lite' );
				break;

			case 'ekit_timeline_line_content':
				return esc_html__( 'Description (Timeline)', 'elementskit-lite' );
				break;

			case 'ekit_timeline_content_date':
				return esc_html__( 'Date (Timeline)', 'elementskit-lite' );
				break;

			case 'ekit_timelinehr_content_address':
				return esc_html__( 'Address (Timeline)', 'elementskit-lite' );
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
			case 'ekit_timeline_line_subtitle':
				return 'LINE';

			case 'ekit_timeline_line_title':
				return 'LINE';

			case 'ekit_timeline_line_content':
				return 'AREA';

			case 'ekit_timeline_content_date':
				return 'LINE';

			case 'ekit_timelinehr_content_address':
				return 'LINE';

			default:
				return '';
		}

	}
}
