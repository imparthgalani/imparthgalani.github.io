<?php
namespace ElementsKit_Lite\Compatibility\Wpml;

defined( 'ABSPATH' ) || exit;


/**
 * Init
 * Initiate all necessary classes, hooks, configs.
 *
 * @since 1.2.6
 */
class Init {

	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;


    /**
     * Instance.
     *
     * Ensures only one instance of the plugin class is loaded or can be loaded.
     *
     * @since 1.2.6
     * @access public
     * @static
     *
     * @return Init An instance of the class.
     */
	public static function instance() {
        if ( is_null( self::$instance ) ) {

            // Fire when ElementsKit_Lite instance.
            self::$instance = new self();
        }

        return self::$instance;
	}


    /**
     * Construct the plugin object.
     *
     * @since 1.2.6
     * @access public
     */
	public function __construct() {
		// WPML String Translation plugin exist check.
		if ( self::is_wpml_active() ) {

			$this->includes();

			add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'translatable_widgets' ] );
		}
	}


    /**
     * WPML String Translation plugin active check
     *
     * @since 1.2.6
     * @access public
     */
	public static function is_wpml_active() {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$wpml_active = is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );

		$string_translation_active = is_plugin_active( 'wpml-string-translation/plugin.php' );

		return $wpml_active && $string_translation_active;

	}


    /**
     * includes
     *
     * Integrations class for complex widgets.
     *
     * @since 1.2.6
     * @access public
     */
	public function includes() {

		include_once( 'widgets/image-accordion.php' );
		include_once( 'widgets/accordion.php' );
		include_once( 'widgets/faq.php' );
		include_once( 'widgets/testimonial.php' );
		include_once( 'widgets/pricing.php' );
		include_once( 'widgets/social.php' );
		include_once( 'widgets/tab.php' );
		include_once( 'widgets/business-hours.php' );
		include_once( 'widgets/social-share.php' );
		include_once( 'widgets/advanced-accordion.php' );
		include_once( 'widgets/advanced-tab.php' );
		include_once( 'widgets/hotspot.php' );
		include_once( 'widgets/gallery.php' );
		include_once( 'widgets/chart.php' );
		include_once( 'widgets/table.php' );
		include_once( 'widgets/timeline.php' );
		include_once( 'widgets/cat-list.php' );
		include_once( 'widgets/page-list.php' );
		include_once( 'widgets/post-list.php' );
		include_once( 'widgets/header-info.php' );

	}


    /**
     * Widgets to translate
     *
     * @since 1.2.6
     * @param array $widgets Widget array.
     * @return array
     */
	function translatable_widgets( $widgets ) {

		$widgets['elementskit-image-accordion'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-image-accordion' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Image_Accordion',
		];

		$widgets['elementskit-accordion'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-accordion' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Accordion',
		];

		$widgets['elementskit-button'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-button' ],
			'fields'		=> [
				[
					'field'       => 'ekit_btn_text',
					'type'        => esc_html__( 'Label (Button)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-heading'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-heading' ],
			'fields'		=> [
				[
					'field'       => 'ekit_heading_title',
					'type'        => esc_html__( 'Title (Heading)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_heading_sub_title',
					'type'        => esc_html__( 'Sub Title (Heading)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_heading_extra_title',
					'type'        => esc_html__( 'Description (Heading)', 'elementskit-lite' ),
					'editor_type' => 'VISUAL',
				],
			],
		];

		$widgets['elementskit-icon-box'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-icon-box' ],
			'fields'		=> [
				[
					'field'       => 'ekit_icon_box_title_text',
					'type'        => esc_html__( 'Title (Icon Box)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_icon_box_description_text',
					'type'        => esc_html__( 'Content (Icon Box)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_icon_box_btn_text',
					'type'        => esc_html__( 'Button Label (Icon Box)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_icon_box_badge_title',
					'type'        => esc_html__( 'Badge Text (Icon Box)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-image-box'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-image-box' ],
			'fields'		=> [
				[
					'field'       => 'ekit_image_box_title_text',
					'type'        => esc_html__( 'Title (Image Box)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_image_box_description_text',
					'type'        => esc_html__( 'Description (Image Box)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_image_box_btn_text',
					'type'        => esc_html__( 'Button Label (Image Box)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-countdown-timer'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-countdown-timer' ],
			'fields'		=> [
				[
					'field'       => 'ekit_countdown_timer_weeks_label',
					'type'        => esc_html__( 'Weeks (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_countdown_timer_days_label',
					'type'        => esc_html__( 'Days (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_countdown_timer_hours_label',
					'type'        => esc_html__( 'Hours (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_countdown_timer_minutes_hours_label',
					'type'        => esc_html__( 'Minutes (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_countdown_timer_seconds_hours_label',
					'type'        => esc_html__( 'Seconds (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_countdown_timer_title',
					'type'        => esc_html__( 'On Expiry Title (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_countdown_timer_expiry_content',
					'type'        => esc_html__( 'On Expiry Content (Countdown Timer)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$widgets['elementskit-faq'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-faq' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Faq',
		];

		$widgets['elementskit-funfact'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-funfact' ],
			'fields'		=> [
				[
					'field'       => 'ekit_funfact_number_suffix',
					'type'        => esc_html__( 'Number Suffix (Funfact)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_funfact_title_text',
					'type'        => esc_html__( 'Title (Funfact)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_funfact_super_text',
					'type'        => esc_html__( 'Super (Funfact)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-image-comparison'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-image-comparison' ],
			'fields'		=> [
				[
					'field'       => 'ekit_img_comparison_label_before',
					'type'        => esc_html__( 'Before Label (Image Comparison)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_img_comparison_label_after',
					'type'        => esc_html__( 'After Label (Image Comparison)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-testimonial'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-testimonial' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Testimonial',
		];

		$widgets['elementskit-pricing'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-pricing' ],
			'fields'		=> [
				[
					'field'       => 'ekit_pricing_table_title',
					'type'        => esc_html__( 'Table Title (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_pricing_table_subtitle',
					'type'        => esc_html__( 'Table Subtitle (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_pricing_currency_icon',
					'type'        => esc_html__( 'Currency (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_pricing_table_price', // Doesn't work for numbers
					'type'        => esc_html__( 'Price (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_pricing_table_duration',
					'type'        => esc_html__( 'Duration (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_pricing_table_content',
					'type'        => esc_html__( 'Table Content (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_pricing_btn_text',
					'type'        => esc_html__( 'Button Label (Pricing Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Pricing',
		];

		$widgets['elementskit-team'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-team' ],
			'fields'		=> [
				[
					'field'       => 'ekit_team_name',
					'type'        => esc_html__( 'Member Name (Team)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_team_position',
					'type'        => esc_html__( 'Member Position (Team)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_team_short_description',
					'type'        => esc_html__( 'Short Description (Team)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_team_description',
					'type'        => esc_html__( 'Popup Description (Team)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ekit_team_phone',
					'type'        => esc_html__( 'Phone (Team)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_team_email',
					'type'        => esc_html__( 'Email (Team)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-social-media'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-social-media' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Social',
		];

		$widgets['elementskit-progressbar'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-progressbar' ],
			'fields'		=> [
				[
					'field'       => 'ekit_progressbar_title',
					'type'        => esc_html__( 'Title (Progress Bar)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-mail-chimp'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-mail-chimp' ],
			'fields'		=> [
				[
					'field'       => 'ekit_mail_chimp_first_name_label',
					'type'        => esc_html__( 'First Name (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_first_name_placeholder',
					'type'        => esc_html__( 'First Name Placeholder (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_last_name_label',
					'type'        => esc_html__( 'Last Name (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_last_name_placeholder',
					'type'        => esc_html__( 'First Name Placeholder (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_phone_label',
					'type'        => esc_html__( 'Phone (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_phone_placeholder',
					'type'        => esc_html__( 'Phone Placeholder (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_email_address_label',
					'type'        => esc_html__( 'Email (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_email_address_placeholder',
					'type'        => esc_html__( 'Email Placeholder (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_submit',
					'type'        => esc_html__( 'Submit Button Text (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_mail_chimp_success_message',
					'type'        => esc_html__( 'Success Message (Mail Chimp)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$widgets['elementskit-piechart'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-piechart' ],
			'fields'		=> [
				[
					'field'       => 'ekit_piechart_title',
					'type'        => esc_html__( 'Title (Pie Chart)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_piechart_item_description',
					'type'        => esc_html__( 'Description (Pie Chart)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-simple-tab'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-simple-tab' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Tab',
		];

		$widgets['elementskit-video'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-video' ],
			'fields'		=> [
				[
					'field'       => 'ekit_video_popup_button_title',
					'type'        => esc_html__( 'Button Title (Video)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-business-hours'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-business-hours' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Business_Hours',
		];

		$widgets['elementskit-drop-caps'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-drop-caps' ],
			'fields'		=> [
				[
					'field'       => 'ekit_dropcaps_text',
					'type'        => esc_html__( 'Content (Drop Caps)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$widgets['elementskit-social-share'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-social-share' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Social_Share',
		];

		$widgets['elementskit-advance-accordion'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-advance-accordion' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Advanced_Accordion',
		];

		$widgets['elementskit-tab'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-tab' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Advanced_Tab',
		];

		$widgets['elementskit-hotspot'] = [
			'conditions'		=> [ 'widgetType' => 'elementskit-hotspot' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Hotspot',
		];

		$widgets['elementskit-motion-text'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-motion-text' ],
			'fields'		=> [
				[
					'field'       => 'ekit_motion_text_content_text',
					'type'        => esc_html__( 'Title (Motion Text)', 'elementskit-lite' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$widgets['elementskit-twitter-feed'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-twitter-feed' ],
			'fields'		=> [
				[
					'field'       => 'ekit_twitter_follow_btn_text',
					'type'        => esc_html__( 'Label (Twitter)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-instagram-feed'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-instagram-feed' ],
			'fields'		=> [
				[
					'field'       => 'ekit_instagram_feed_ins_follow_text',
					'type'        => esc_html__( 'Follow Button Text (Instagram Feed)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-gallery'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-gallery' ],
			'fields'		=> [
				[
					'field'       => 'ekit_gallery_filter_all_label',
					'type'        => esc_html__( '"All" Filter Label (Gallery)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Gallery',
		];

		$widgets['elementskit-chart'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-chart' ],
			'fields'		=> [
				[
					'field'       => 'ekit_charts_title_text',
					'type'        => esc_html__( 'Title (Chart)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Chart',
		];

		$widgets['elementskit-table'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-table' ],
			'fields'		=> [
				[
					'field'       => 'ekit_table_navigation_prev_text',
					'type'        => esc_html__( 'Prev Text (Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_table_navigation_next_text',
					'type'        => esc_html__( 'Next Text (Table)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Table',
		];

		$widgets['elementskit-timeline'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-timeline' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Timeline',
		];

		$widgets['elementskit-dual-button'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-dual-button' ],
			'fields'		=> [
				[
					'field'       => 'ekit_button_middle_text',
					'type'        => esc_html__( 'Middle Text (Dual Button)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_button_one_text',
					'type'        => esc_html__( 'Button One Text (Dual Button)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ekit_button_two_text',
					'type'        => esc_html__( 'Button Two Text (Dual Button)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-creative-button'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-creative-button' ],
			'fields'		=> [
				[
					'field'       => 'ekit_btn_text',
					'type'        => esc_html__( 'Label (Creative Button)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['elementskit-category-list'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-category-list' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Cat_List',
		];

		$widgets['elementskit-page-list'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-page-list' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Page_List',
		];

		$widgets['elementskit-post-list'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-post-list' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Post_List',
		];

		$widgets['elementskit-header-info'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-header-info' ],
			'integration-class'	=> 'ElementsKit_Lite\Compatibility\WPML\Widgets\Ekit_Header_Info',
		];

		$widgets['elementskit-header-search'] = [
			'conditions'	=> [ 'widgetType' => 'elementskit-header-search' ],
			'fields'		=> [
				[
					'field'       => 'ekit_search_placeholder_text',
					'type'        => esc_html__( 'Placeholder Text (Header Search)', 'elementskit-lite' ),
					'editor_type' => 'LINE',
				],
			],
		];

		return $widgets;
	}
}