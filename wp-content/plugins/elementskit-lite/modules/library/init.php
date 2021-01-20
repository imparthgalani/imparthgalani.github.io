<?php
namespace ElementsKit_Lite\Modules\Library;

defined( 'ABSPATH' ) || exit;

class Init{
    private $dir;
    private $url;

    public function __construct(){

        // get current directory path.
        $this->dir = dirname(__FILE__) . '/';

        // get current module's url.
        $this->url = \ElementsKit_Lite::plugin_url() . 'modules/library/';

        // enqueue editor js for elementor.
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ), 1);

        // print views and tab variables on footer.
        add_action( 'elementor/editor/footer', array($this, 'admin_inline_js') );
        add_action( 'elementor/editor/footer', array( $this, 'print_views' ) );

        // enqueue editor css.
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

        // enqueue modal's preview css.
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_styles' ) );

        // call api manager.
        new Manager\Api();
        Library_Manager::init();
    }

    public function editor_scripts(){
		wp_enqueue_script( 
			'elementskit-library-editor-script', 
			$this->url . 'assets/js/editor.js', 
			array('jquery', 'underscore', 'backbone-marionette'), 
			\ElementsKit_Lite::version(),
			true
		);
	}

	public function editor_styles(){
		wp_enqueue_style( 'elementskit-library-editor-style', $this->url . 'assets/css/editor.css', array(), \ElementsKit_Lite::version());
	}

	public function preview_styles(){
		wp_enqueue_style( 'elementskit-library-preview-style', $this->url . 'assets/css/preview.css', array(), \ElementsKit_Lite::version() );
	}

	public function admin_inline_js() { ?>
		<script type="text/javascript" >

		var ElementsKitLibreryData = {
			"libraryButton": "Elements Button",
			"modalRegions": {
				"modalHeader": ".dialog-header",
				"modalContent": ".dialog-message"
			},
			"license": {
				"activated": true,
				"link": ""
			},
			"tabs": {
				"elementskit_page": {
					"title": "Ready Pages",
					"data": [],
					"sources": ["elementskit-theme", "elementskit-api"],
					"settings": {
						"show_title": true,
						"show_keywords": true
					}
				},
				"elementskit_header": {
					"title": "Headers",
					"data": [],
					"sources": ["elementskit-theme", "elementskit-api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				"elementskit_footer": {
					"title": "Footers",
					"data": [],
					"sources": ["elementskit-theme", "elementskit-api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				"elementskit_section": {
					"title": "Sections",
					"data": [],
					"sources": ["elementskit-theme", "elementskit-api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				"elementskit_widget": {
					"title": "Widget Presets",
					"data": [],
					"sources": ["elementskit-theme", "elementskit-api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				// "local": {
				// 	"title": "My Library",
				// 	"data": [],
				// 	"sources": ["elementskit-local"],
				// 	"settings": []
				// }
			},
			"defaultTab": "elementskit_page"
		};

		</script> <?php
	}

	public function print_views(){
		foreach ( glob( $this->dir . 'views/editor/*.php' ) as $file ) {
			$name = basename( $file, '.php' );
			ob_start();
			include $file;
			printf( '<script type="text/html" id="view-elementskit-%1$s">%2$s</script>', $name, ob_get_clean() );
		}
	}
}