<?php

namespace ElementsKit_Lite\Helpers;

defined('ABSPATH') || exit;

class Widget_List {

	use \ElementsKit_Lite\Traits\Singleton;


	/**
	 * todo: format the comment appropriately
	 *
	 * Usage :
	 *  get full list >> get_list() []
	 *  get full list of active widgets >> get_list(true, '', 'active') // []
	 *  get specific widget data >> get_list(true, 'image-accordion') [] or false
	 *  get specific widget data (if active) >> get_list(true, 'image-accordion', 'active') [] or false
	 *
	 * @param bool $filtered
	 * @param string $widget
	 * @param string $check_method - active|list
	 *
	 * @return array|bool|mixed
	 */
	public function get_list($filtered = true, $widget = '', $check_method = 'list') {
		$all_list = self::$list;

		if($filtered == true) {
			$all_list = apply_filters('elementskit/widgets/list', self::$list);
		}

		if($check_method == 'active') {
			$active_list = \ElementsKit_Lite\Libs\Framework\Attr::instance()->utils->get_option('widget_list', array_keys($all_list));

			foreach($all_list as $widget_slug => $info) {
				if(!in_array($widget_slug, $active_list)) {
					unset($all_list[$widget_slug]);
				}
			}
		}

		if($widget != '') {
			return (isset($all_list[$widget]) ? $all_list[$widget] : false);
		}

		return $all_list;
	}


	/**
	 * Check if a widget is active or not, free package are considered inactive
	 *
	 * Usage : \ElementsKit_Lite\Helpers\Widget_List::instance()->is_active('facebook-review')
	 *
	 *
	 * @param $widget - widget slug
	 *
	 * @return bool
	 */
	public function is_active($widget) {

		$act = Widget_List::instance()->get_list(true, $widget, 'active');

		return empty($act['package']) ? false : (($act['package'] == 'free' || $act['package'] == 'pro'));
	}


	private static $list = [
		'image-accordion'  => [
			'slug'    => 'image-accordion',
			'title'   => 'Image Accordion',
			'package' => 'free', // free, pro, free
			//'path' => 'path to the widget directory',
			//'base_class_name' => 'main class name',
			//'title' => 'widget title',
			//'live' => 'live demo url'
		],
		'accordion'        => [
			'slug'    => 'accordion',
			'title'   => 'Accordion',
			'package' => 'free',
		],
		'button'           => [
			'slug'    => 'button',
			'title'   => 'Button',
			'package' => 'free',
		],
		'heading'          => [
			'slug'    => 'heading',
			'title'   => 'Heading',
			'package' => 'free',
		],
		'blog-posts'       => [
			'slug'    => 'blog-posts',
			'title'   => 'Blog Posts',
			'package' => 'free',
		],
		'icon-box'         => [
			'slug'    => 'icon-box',
			'title'   => 'Icon Box',
			'package' => 'free',
		],
		'image-box'        => [
			'slug'    => 'image-box',
			'title'   => 'Image Box',
			'package' => 'free',
		],
		'countdown-timer'  => [
			'slug'    => 'countdown-timer',
			'title'   => 'Countdown Timer',
			'package' => 'free',
		],
		'client-logo'      => [
			'slug'    => 'client-logo',
			'title'   => 'Client Logo',
			'package' => 'free',
		],
		'faq'              => [
			'slug'    => 'faq',
			'title'   => 'FAQs',
			'package' => 'free',
		],
		'funfact'          => [
			'slug'    => 'funfact',
			'title'   => 'Funfact',
			'package' => 'free',
		],
		'image-comparison' => [
			'slug'    => 'image-comparison',
			'title'   => 'Image Comparison',
			'package' => 'free',
		],
		'lottie'           => [
			'slug'    => 'lottie',
			'title'   => 'Lottie',
			'package' => 'free',
		],
		'testimonial'      => [
			'slug'    => 'testimonial',
			'title'   => 'Testimonial',
			'package' => 'free',
		],
		'pricing'          => [
			'slug'    => 'pricing',
			'title'   => 'Pricing',
			'package' => 'free',
		],
		'team'             => [
			'slug'    => 'team',
			'title'   => 'Team',
			'package' => 'free',
		],
		'social'           => [
			'slug'    => 'social',
			'title'   => 'Social',
			'package' => 'free',
		],
		'progressbar'      => [
			'slug'    => 'progressbar',
			'title'   => 'Progressbar',
			'package' => 'free',
		],
		'category-list'    => [
			'slug'    => 'category-list',
			'title'   => 'Category List',
			'package' => 'free',
		],
		'page-list'        => [
			'slug'    => 'page-list',
			'title'   => 'Page List',
			'package' => 'free',
		],
		'post-grid'        => [
			'slug'    => 'post-grid',
			'title'   => 'Post Grid',
			'package' => 'free',
		],
		'post-list'        => [
			'slug'    => 'post-list',
			'title'   => 'Post List',
			'package' => 'free',
		],
		'post-tab'         => [
			'slug'    => 'post-tab',
			'title'   => 'Post Tab',
			'package' => 'free',
		],
		'nav-menu'         => [
			'slug'    => 'nav-menu',
			'title'   => 'Nav Menu',
			'package' => 'free',
		],
		'mail-chimp'       => [
			'slug'    => 'mail-chimp',
			'title'   => 'Mail Chimp',
			'package' => 'free',
		],
		'header-info'      => [
			'slug'    => 'header-info',
			'title'   => 'Header Info',
			'package' => 'free',
		],
		'piechart'         => [
			'slug'    => 'piechart',
			'title'   => 'Piechart',
			'package' => 'free',
		],
		'header-search'    => [
			'slug'    => 'header-search',
			'title'   => 'Header Search',
			'package' => 'free',
		],
		'header-offcanvas' => [
			'slug'    => 'header-offcanvas',
			'title'   => 'Header Offcanvas',
			'package' => 'free',
		],
		'tab'              => [
			'slug'    => 'tab',
			'title'   => 'Tab',
			'package' => 'free',
		],
		'contact-form7'    => [
			'slug'    => 'contact-form7',
			'title'   => 'Contact Form 7',
			'package' => 'free',
		],
		'video'            => [
			'slug'    => 'video',
			'title'   => 'Video',
			'package' => 'free',
		],
		'business-hours'   => [
			'slug'    => 'business-hours',
			'title'   => 'Business Hours',
			'package' => 'free',
		],
		'drop-caps'        => [
			'slug'    => 'drop-caps',
			'title'   => 'Drop Caps',
			'package' => 'free',
		],
		'social-share'     => [
			'slug'    => 'social-share',
			'title'   => 'Social Share',
			'package' => 'free',
		],
		'dual-button'      => [
			'slug'    => 'dual-button',
			'title'   => 'Dual Button',
			'package' => 'free',
		],
		'caldera-forms'    => [
			'slug'    => 'caldera-forms',
			'title'   => 'Caldera Forms',
			'package' => 'free',
		],
		'we-forms'         => [
			'slug'    => 'we-forms',
			'title'   => 'We Forms',
			'package' => 'free',
		],
		'wp-forms'         => [
			'slug'    => 'wp-forms',
			'title'   => 'Wp Forms',
			'package' => 'free',
		],

		'ninja-forms'        => [
			'slug'    => 'ninja-forms',
			'title'   => 'Ninja Forms',
			'package' => 'free',
		],
		'tablepress'         => [
			'slug'    => 'tablepress',
			'title'   => 'Tablepress',
			'package' => 'free',
		],
		'advanced-accordion' => [
			'slug'    => 'advanced-accordion',
			'title'   => 'Advanced Accordion',
			'package' => 'pro-disabled',
		],
		'advanced-tab'       => [
			'slug'    => 'advanced-tab',
			'title'   => 'Advanced Tab',
			'package' => 'pro-disabled',
		],
		'hotspot'            => [
			'slug'    => 'hotspot',
			'title'   => 'Hotspot',
			'package' => 'pro-disabled',
		],
		'motion-text'        => [
			'slug'    => 'motion-text',
			'title'   => 'Motion Text',
			'package' => 'pro-disabled',
		],
		'twitter-feed'       => [
			'slug'    => 'twitter-feed',
			'title'   => 'Twitter Feed',
			'package' => 'pro-disabled',
		],

		'instagram-feed'       => [
			'slug'    => 'instagram-feed',
			'title'   => 'Instagram Feed',
			'package' => 'pro-disabled',
		],
		'gallery'              => [
			'slug'    => 'gallery',
			'title'   => 'Gallery',
			'package' => 'pro-disabled',
		],
		'chart'                => [
			'slug'    => 'chart',
			'title'   => 'Chart',
			'package' => 'pro-disabled',
		],
		'woo-category-list'    => [
			'slug'    => 'woo-category-list',
			'title'   => 'Woo Category List',
			'package' => 'pro-disabled',
		],
		'woo-mini-cart'        => [
			'slug'    => 'woo-mini-cart',
			'title'   => 'Woo Mini Cart',
			'package' => 'pro-disabled',
		],
		'woo-product-carousel' => [
			'slug'    => 'woo-product-carousel',
			'title'   => 'Woo Product Carousel',
			'package' => 'pro-disabled',
		],
		'woo-product-list'     => [
			'slug'    => 'woo-product-list',
			'title'   => 'Woo Product List',
			'package' => 'pro-disabled',
		],
		'table'                => [
			'slug'    => 'table',
			'title'   => 'Table',
			'package' => 'pro-disabled',
		],
		'timeline'             => [
			'slug'    => 'timeline',
			'title'   => 'Timeline',
			'package' => 'pro-disabled',
		],
		'creative-button'      => [
			'slug'    => 'creative-button',
			'title'   => 'Creative Button',
			'package' => 'pro-disabled',
		],
		'vertical-menu'        => [
			'slug'    => 'vertical-menu',
			'title'   => 'Vertical Menu',
			'package' => 'pro-disabled',
		],
		'advanced-toggle'      => [
			'slug'    => 'advanced-toggle',
			'title'   => 'Advanced Toggle',
			'package' => 'pro-disabled',
		],
		'video-gallery'        => [
			'slug'    => 'video-gallery',
			'title'   => 'Video Gallery',
			'package' => 'pro-disabled',
		],
		'zoom'                 => [
			'slug'    => 'zoom',
			'title'   => 'Zoom',
			'package' => 'pro-disabled',
		],
		'behance-feed'         => [
			'slug'    => 'behance-feed',
			'title'   => 'Behance Feed',
			'package' => 'pro-disabled',
		],

		'breadcrumb' => [
			'slug'    => 'breadcrumb',
			'title'   => 'Breadcrumb',
			'package' => 'pro-disabled',
		],

		'dribble-feed' => [
			'slug'    => 'dribble-feed',
			'title'   => 'Dribble Feed',
			'package' => 'pro-disabled',
		],

		'facebook-feed' => [
			'slug'    => 'facebook-feed',
			'title'   => 'Facebook Feed',
			'package' => 'pro-disabled',
		],

		'facebook-review' => [
			'slug'    => 'facebook-review',
			'title'   => 'Facebook Review',
			'package' => 'pro-disabled',
		],

		'trustpilot' => [
			'slug'    => 'trustpilot',
			'title'   => 'Trustpilot',
			'package' => 'pro-disabled',
		],

		'yelp' => [
			'slug'    => 'yelp',
			'title'   => 'Yelp',
			'package' => 'pro-disabled',
		],

		'pinterest-feed' => [
			'slug'    => 'pinterest-feed',
			'title'   => 'Pinterest Feed',
			'package' => 'pro-disabled',
        ],
        
		'popup-modal' => [
			'slug'    => 'popup-modal',
			'title'   => 'Popup Modal',
			'package' => 'pro-disabled',
		],

		'google-map' => [
			'slug'    => 'google-map',
			'title'   => 'Google Map',
			'package' => 'pro-disabled',
		],
		'unfold'         => [
			'slug'    => 'unfold',
			'title'   => 'Unfold',
			'package' => 'pro-disabled',
		],
	];
}