<?php
namespace WTS_EAE;


class WPML_Compatibility {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {

		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets' ] );

	}

	public function wpml_widgets($widgets){

		$widgets = $this->split_text($widgets);
		$widgets = $this->flip_box($widgets);
		$widgets = $this->dual_button($widgets);
		$widgets = $this->image_compare($widgets);
		$widgets = $this->modal_popup($widgets);
		$widgets = $this->progress_bar($widgets);
		$widgets = $this->text_separator($widgets);
		$widgets = $this->twitter($widgets);
		$widgets = $this->post_list($widgets);
		$widgets = $this->animated_text($widgets);
		$widgets = $this->gmap($widgets);
		$widgets = $this->filterable_gallery($widgets);
		$widgets = $this->price_table($widgets);
		$widgets = $this->timeline($widgets);
		$widgets = $this->info_circle($widgets);
		$widgets = $this->comparison_table($widgets);


		return $widgets;
	}

	private function split_text($widgets){

		$widgets[ 'wts-splittext' ] = [
			'conditions'    => ['widgetType' => 'wts-splittext'],
			'fields'        => [
				[
					'field' => 'text',
					'type'  => __('Split Text: Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			]
		];



		return $widgets;

	}

	private function flip_box($widgets){



		$widgets[ 'wts-flipbox' ] = [
			'conditions'    => ['widgetType' => 'wts-flipbox'],
			'fields'        => [
				[
					'field' => 'front_title',
					'type'  => __('Flip Box: Front Title', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'front-text',
					'type'  => __('Flip Box: Front Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'back_title',
					'type'  => __('Flip Box: Back Title', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'back_text',
					'type'  => __('Flip Box: Back Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'action_text',
					'type'  => __('Flip Box: Button Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			]
		];

		return $widgets;

	}

	private function dual_button($widgets){

		$widgets[ 'eae-dual-button' ] = [
			'conditions'    => ['widgetType' => 'eae-dual-button'],
			'fields'        => [
				[
					'field' => 'button1_text',
					'type'  => __('Dual Button: Button 1 Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'button2_text',
					'type'  => __('Dual Button: Button 2 Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'separator_text',
					'type'  => __('Dual Button: Separator Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			]
		];

		return $widgets;

	}

	private function image_compare($widgets){

		$widgets[ 'wts-ab-image' ] = [
			'conditions'    => ['widgetType' => 'wts-ab-image'],
			'fields'        => [
				[
					'field' => 'text_before',
					'type'  => __('Image Compare: Before Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'text_after',
					'type'  => __('Image Compare: After Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			]
		];

		return $widgets;

	}

	private function modal_popup($widgets){

		$widgets[ 'wts-modal-popup' ] = [
			'conditions'    => ['widgetType' => 'wts-modal-popup'],
			'fields'        => [
				[
					'field' => 'modal_title',
					'type'  => __('Modal Popup: Title', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'modal_content',
					'type'  => __('Modal Popup: Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'button_text',
					'type'  => __('Modal Popup: Button Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			]
		];

		return $widgets;

	}

	private function progress_bar($widgets){

		$widgets[ 'eae-progress-bar' ] = [
			'conditions'    => ['widgetType' => 'eae-progress-bar'],
			'fields'        => [
				[
					'field' => 'progress_title',
					'type'  => __('Progress Bar: Title', 'wts-eae'),
					'editor_type'   => 'LINE'
				],

			]
		];

		return $widgets;

	}

	private function text_separator($widgets){

		$widgets[ 'wts-textseparator' ] = [
			'conditions'    => ['widgetType' => 'wts-textseparator'],
			'fields'        => [
				[
					'field' => 'title',
					'type'  => __('Text Separator: Title', 'wts-eae'),
					'editor_type'   => 'AREA'
				],

			]
		];

		return $widgets;

	}

	private function twitter($widgets){

		$widgets[ 'wts-twitter' ] = [
			'conditions'    => ['widgetType' => 'wts-twitter'],
			'fields'        => [
				[
					'field' => 'username',
					'type'  => __('Twitter: Username', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'hashtag',
					'type'  => __('Twitter: Hashtag', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'dm_username',
					'type'  => __('Twitter: Username', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'dm_prefill_text',
					'type'  => __('Twitter: Prefill Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'share_username',
					'type'  => __('Twitter: Share Username', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'share_prefill_text',
					'type'  => __('Twitter: Share Prefill Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'share_hashtags',
					'type'  => __('Twitter: Share Hashtag Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'prefill_text',
					'type'  => __('Twitter: Prefill Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'prefill_custom',
					'type'  => __('Twitter: Prefill Custom Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],

			]
		];

		return $widgets;

	}

	private function post_list($widgets){

		$widgets[ 'wts-postlist' ] = [
			'conditions'    => ['widgetType' => 'wts-postlist'],
			'fields'        => [
				[
					'field' => 'read_more_text',
					'type'  => __('Post List: Read More Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],

			]
		];

		return $widgets;

	}

	private function animated_text($widgets){

		$widgets[ 'wts-AnimatedText'] = [

			'conditions' => [ 'widgetType' => 'wts-AnimatedText' ],
			'fields'     => [
				[
					'field' => 'pre-text',
					'type'  => __('Animated Text: Pre Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
				[
					'field' => 'post-text',
					'type'  => __('Animated Text: Post Text', 'wts-eae'),
					'editor_type'   => 'AREA'
				],
			],
			'integration-class' => '\WTS_EAE\WPML_EAE_Animated_Text'
		];

		return $widgets;
	}

	private function gmap($widgets){

		$widgets[ 'wts-gmap'] = [

			'conditions' => [ 'widgetType' => 'wts-gmap' ],
			'fields'     => [],
			'integration-class' => '\WTS_EAE\WPML_EAE_Gmap'
		];

		return $widgets;
	}

	private function filterable_gallery($widgets){

		$widgets[ 'eae-filterableGallery'] = [

			'conditions' => [ 'widgetType' => 'eae-filterableGallery' ],
			'fields'     => [],
			'integration-class' => '\WTS_EAE\WPML_EAE_Filterable_Gallery'
		];

		return $widgets;
	}

	private function price_table($widgets){

		$widgets[ 'wts-pricetable'] = [

			'conditions' => [ 'widgetType' => 'wts-pricetable' ],
			'fields'     => [
				[
					'field' => 'heading',
					'type'  => __('Price Table: Plan Heading', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'sub-heading',
					'type'  => __('Price Table: Plan Sub Heading', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'price-box-text',
					'type'  => __('Price Table: Price Box Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'price-box-subtext',
					'type'  => __('Price Table: Price Box SubText', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'action_text',
					'type'  => __('Price Table: Button Text', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			],
			'integration-class' => '\WTS_EAE\WPML_EAE_Price_Table'
		];

		return $widgets;
	}

	private function timeline($widgets){

		$widgets[ 'eae-timeline'] = [

			'conditions' => [ 'widgetType' => 'eae-timeline' ],
			'fields'     => [],
			'integration-class' => '\WTS_EAE\WPML_EAE_Timeline'
		];

		return $widgets;
	}

	private function info_circle($widgets){

		$widgets[ 'eae-info-circle'] = [

			'conditions' => [ 'widgetType' => 'eae-info-circle' ],
			'fields'     => [],
			'integration-class' => '\WTS_EAE\WPML_EAE_Info_Circle'
		];

		return $widgets;
	}

	private function comparison_table($widgets){

		$widgets[ 'eae-comparisontable'] = [

			'conditions' => [ 'widgetType' => 'eae-comparisontable' ],
			'fields'     => [
				[
					'field' => 'feature_box_heading',
					'type'  => __('Comparison Table: Feature Box Heading', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
				[
					'field' => 'button_heading_text',
					'type'  => __('Comparison Table: Button Heading', 'wts-eae'),
					'editor_type'   => 'LINE'
				],
			],
			'integration-class' => '\WTS_EAE\WPML_EAE_Comparison_Table'
		];

		return $widgets;
	}



}

WPML_Compatibility::instance();