<?php
namespace ElementsKit_Lite\Modules\Controls;

defined( 'ABSPATH' ) || exit;

class Icons{
	public static $_instance = null;
	public function ekit_icons_pack(){
		add_filter( 'elementor/icons_manager/additional_tabs', [ $this, '__add_font']);
	}

	public function __add_font( $font){
        $font_new['ekiticons'] = [
			'name' => 'ekiticons',
			'label' => __( 'ElementsKit_Lite - Icons', 'elementskit-lite' ),
			'url' => Init::get_url() . 'assets/css/ekiticons.css',
			'prefix' => 'icon-',
			'displayPrefix' => 'icon',
			'labelIcon' => 'icon icon-ekit',
			'ver' => '5.9.0',
			'fetchJson' => Init::get_url() . 'assets/js/ekiticons.json',
			'native' => true,
		];
        return  array_merge($font, $font_new);
    }
	
	
	public static function __generate_font(){
		global $wp_filesystem;
		require_once ( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
		$css_file =  Init::get_url() . 'assets/css/ekiticons.css';
		// $css_file =  Init::get_dir() . 'assets/css/ekiticons.css';
		if ( $wp_filesystem->exists( $css_file ) ) {
			$css_source = $wp_filesystem->get_contents( $css_file );
		} 
		
		preg_match_all( "/\.(icon-.*?):\w*?\s*?{/", $css_source, $matches, PREG_SET_ORDER, 0 );
		$iconList = [];
		foreach ( $matches as $match ) {
			//$new_icons[$match[1] ] = str_replace('ekit-wid-con .icon-', '', $match[1]);
			$iconList[] = str_replace('icon-', '', $match[1]);
		}
		$icons = new \stdClass();
		$icons->icons = $iconList;
		$icon_data = json_encode($icons);
		$file = Init::get_dir() . 'assets/js/ekiticons.json';
		global $wp_filesystem;
		require_once ( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
		if ( $wp_filesystem->exists( $file ) ) {
			$content =  $wp_filesystem->put_contents( $file, $icon_data) ;
		} 
		
	}

	public static function _get_instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

}
