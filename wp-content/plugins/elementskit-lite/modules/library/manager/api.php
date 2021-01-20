<?php
namespace ElementsKit_Lite\Modules\Library\Manager;

defined( 'ABSPATH' ) || exit;

class Api {
	private $dir;
	private $url;
	private $server_url;
	private $sources;

	public function __construct() {

		$this->sources = [
			'elementskit-api',
		];

		// set server api url.
		$this->server_url = \ElementsKit_Lite::api_url() . 'elementor-layouts/';

		// get current directory path.
		$this->dir = dirname(__FILE__) . '/';

		// get current module's url.
        $this->url = \ElementsKit_Lite::plugin_url() . 'modules/library/templates/';

		add_action( 'wp_ajax_elementskit_get_templates', array( $this, 'get_templates' ) );
		add_action( 'wp_ajax_elementskit_core_clone_template', array( $this, 'clone_template' ) );

		
		add_action( 'wp_ajax_elementskit_get_layouts', [$this, 'get_layouts'] );

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.2.8', '>' ) ) {
			add_action( 'elementor/ajax/register_actions', array( $this, 'register_ajax_actions' ), 20 );
		} else {
			add_action( 'wp_ajax_elementor_get_template_data', array( $this, 'get_template_data' ), -1 );
		}

	}

	public function get_license(){
		return [
			'key' => null,
			'oppai' => get_option('__validate_oppai__'),
			'package_type' => \ElementsKit_Lite::package_type(),
			'store_name' => \ElementsKit_Lite::store_name(),
            'product_id' => \ElementsKit_Lite::product_id(),
            'version' => \ElementsKit_Lite::version(),
		];
	}

	public function get_layouts(){
		isset($_GET['tab']) || exit();

        $query = array_merge([
            'action' => 'get_layouts',
            'tab' => (empty($_GET['tab']) ? 'elementskit_page' : $_GET['tab']),
		], $this->get_license());
		
		$request_url = $this->server_url . '?' . http_build_query($query);

		$response = wp_remote_get( $request_url,
			array(
				'timeout'     => 120,
				'httpversion' => '1.1',
			)
		);
		if($response['body'] != ''){
			echo \ElementsKit_Lite\Utils::kses($response['body']);
			exit;
		}
	}

	public function get_layout_data(){
		$actions = !isset($_POST['actions']) ? '' : $_POST['actions'];
		$actions = json_decode(stripslashes($actions), true);
		$template_data = reset($actions);

        $query = array_merge([
            'action' => 'get_layout_data',
            'id' => $template_data['data']['template_id'],
		], $this->get_license());

		$request_url = $this->server_url . '?' . http_build_query($query);
		$response = wp_remote_get( $request_url,
			array(
				'timeout'     => 120,
				'httpversion' => '1.1',
			)
		);

		$content = json_decode($response['body'], true);
		@$content = $this->process_import_ids($content);
		@$content = $this->process_import_content( $content, 'on_import' );

		return $content;
	}

	public function register_ajax_actions( $ajax ) {
		

		if ( ! isset( $_POST['actions'] ) ) {
			return;
		}

		$actions     = json_decode( stripslashes( $_REQUEST['actions'] ), true );
		$data        = false;

		foreach ( $actions as $id => $action_data ) {
			if ( ! isset( $action_data['get_template_data'] ) ) {
				$data = $action_data;
			}
		}

		if ( ! $data ) {
			return;
		}

		if ( ! isset( $data['data'] ) ) {
			return;
		}

		if ( ! isset( $data['data']['source'] ) ) {
			return;
		}

		$source = $data['data']['source'];
		if ( ! in_array( $source, $this->sources ) ) {
			return;
		}
	
		$ajax->register_ajax_action( 'get_template_data', function( $data ) {
			return $this->get_layout_data( );
		} );

	}

	protected function process_import_ids( $content ) {
		return \Elementor\Plugin::$instance->db->iterate_data( $content, function( $element ) {
			$element['id'] = \Elementor\Utils::generate_random_string();
			return $element;
		} );
	}


	protected function process_import_content( $content, $method ) {
		return \Elementor\Plugin::$instance->db->iterate_data(
			$content, function( $element_data ) use ( $method ) {
				$element = \Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );

				// If the widget/element isn't exist, like a plugin that creates a widget but deactivated
				if ( ! $element ) {
					return null;
				}

				$r = $this->process_import_element( $element, $method );
				return $r;
			}
		);
	}

	protected function process_import_element( $element, $method ) {

		$element_data = $element->get_data();

		if ( method_exists( $element, $method ) ) {
			$element_data = $element->{$method}( $element_data );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = \ELementor\Plugin::$instance->controls_manager->get_control( $control['type'] );

			// If the control isn't exist, like a plugin that creates the control but deactivated.
			if ( ! $control_class ) {
				return $element_data;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_data['settings'][ $control['name'] ] = $control_class->{$method}( $element->get_settings( $control['name'] ), $control );
			}
		}

		return $element_data;
	}
}

