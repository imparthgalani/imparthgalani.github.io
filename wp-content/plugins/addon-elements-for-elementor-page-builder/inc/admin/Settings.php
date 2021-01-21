<?php
/**
 * Created by PhpStorm.
 * User: anand
 * Date: 10/01/18
 * Time: 12:18 PM
 */

namespace WTS_EAE;


class Settings extends Settings_Page {

	const PAGE_ID = 'eae';

	public function __construct() {
		parent::__construct();
		add_action('wp_ajax_eae_save_gmap',[ $this, 'eae_save_gmap_key']);
		add_action('wp_ajax_eae_elements_save',[ $this, 'eae_save_elements']);
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
	}

	public function register_admin_menu() {
		/*add_menu_page(
			__( 'Elementor Addon Elements', 'wts-eae' ),
			__( 'Elementor Addon Elements', 'wts-eae' ),
			'manage_options',
			self::PAGE_ID,
			[ $this, 'display_settings_page' ],
			'',
			99
		);*/
		add_menu_page(
			__( 'Elementor Addons Elements', 'wts-eae' ),
			__( 'Elementor Addons Elements', 'wts-eae' ),
			'manage_options',
			'eae-settings',
			[ $this, 'display_settings_page_new' ],
			'',
			99
		);
	}

	public function eae_save_gmap_key(){
		$key = sanitize_text_field($_REQUEST['mapkey']);

		if(current_user_can( 'manage_options' ) && check_ajax_referer('eae_ajax_nonce','nonce')){
			update_option('wts_eae_gmap_key',$key);
		}
    }

	public function eae_save_elements(){
		$elements = $_REQUEST['eae_items'];
        $items = [];
		for($i=0; $i <count($elements);$i++){
			if($elements[$i]['enabled'] === 'true' || $elements[$i]['enabled'] === 'false'){
				$items[$elements[$i]['key']] = $elements[$i]['enabled'];
			}
        }

		if(current_user_can( 'manage_options' ) && check_ajax_referer('eae_ajax_nonce','nonce')) {
			update_option('wts_eae_elements',$items);
		}

    }

	public function display_settings_page_new(){
		?>
		<div id="eae-settings"></div>
    <?php
	}

	protected function get_page_title() {
		return __( 'Elementor Addons Elements', 'wts-eae' );
	}

	public function create_tabs() {

		return [
			'general' => [
				'label' => __( 'General', 'wts-eae' ),
				'sections' => [
					'general' => [
						'fields' => [
							'gmap_key' => [
								'label' => __( 'Google Map Key', 'wts-eae' ),
								'field_args' => [
									'type' => 'text',
									'desc' => '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">'
                           						. __('Click Here', 'wts-eae') .
                                '</a> to generate API KEY'
								],
							]
						]
					]
				]
			],
			'other_products' => [
				'label' => __('Other Products', 'wts-eae'),
				'sections'   => [
					'other_products' => [
						'fields'    => [
							'aepro' => [
								'field_args' => [
									'type'  => 'raw_html',
									'html'  =>  $this->get_aepro_promo()
								]
							]
						]
					]
				]
			]
		];
	}

	function get_aepro_promo(){

		$promo_html = '<h2>AnyWhere Elementor Pro</h2>';

		$promo_html .= '<style type="text/css">
							.elementor_aepro th{ display:none; }
							.desc-box{ width:50%; float:left; }
							.logo-box{ width:50%; float:left; text-align: center; }
							.logo-box img{ width:200px;  }
							.elementor_aepro h2{ font-size:30px; }
							.eae-ae-actions a{ display:inline-block; margin-right:10px; text-decoration: none; padding: 10px 15px; background:#5cc4b6; color:#FFF; border-radius:3px;     }
							.eae-ae-actions a.demo{ background:#667eea; }
						</style>
						<div class="eae-ae-actions">
							<a href="https://shop.webtechstreet.com/downloads/anywhere-elementor-pro/?ref=eae" target="_blank" class="learmore">Learn More</a>	
							<a href="https://aedemo.elementoraddons.com/?ref=eae" target="_blank" class="demo">See Demo</a>	
						</div>
						<div class="desc-box">
						<p>Supercharge your Elementor with the ability to design global layouts
						  	
						<ul>
							<li>Design global single post layouts</li>
							<li>Design layout for Blog Page</li>
							<li>Design layouts for Post Type Archives, Category/Custom Taxonomy Archives</li>
							<li>Get the ability to design layouts for Author Archives, Search Page and 404 Pages</li>
							<li>Use data from custom fields in your Elementor Layouts</li>
							<li>Support many field types of ACF & Pods</li>
							<li>Design WooCommerce Product, Shop and Category page layouts.</li>													
						</ul>
						</p></div>
						
						<div class="logo-box">
								<img src="'.EAE_URL.'assets/aep.png" title="AnyWhere Elementor Pro" />
						</div> ';

		return $promo_html;
	}
}

new Settings();