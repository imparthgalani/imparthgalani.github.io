<?php
namespace WTS_EAE\Modules\Particles;

use Elementor\Controls_Manager;

class Module{

	private static $_instance = null;

	public function __construct()
	{
		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 3 );

		// Add print template for editor preview
		add_action( 'elementor/section/print_template', [ $this, '_print_template'],10,2);
		add_action( 'elementor/column/print_template', [ $this, '_print_template'],10,2);

		add_action( 'elementor/frontend/column/before_render', [ $this, '_before_render'],10,1);
		add_action( 'elementor/frontend/section/before_render', [ $this, '_before_render'],10,1);

		add_action( 'wp_enqueue_scripts', [ $this, 'eae_add_particles' ] );
		add_action( 'elementor/editor/wp_head', [ $this, 'eae_add_particles_admin' ] );
	}

	function eae_add_particles(){
        wp_enqueue_script('eae-particles');
    }

    function eae_add_particles_admin(){
	    wp_enqueue_script( 'eae-partices', EAE_URL . 'assets/js/particles.js', array( 'jquery' ), '1.0', true );
    }
	public function register_controls($element, $section_id, $args){

		if ( ('section' === $element->get_name() && 'section_background' === $section_id) || ('column' === $element->get_name() && 'section_style' === $section_id)) {

			$element->start_controls_section(
				'eae_particles',
				[
					'tab' => Controls_Manager::TAB_STYLE,
					'label' => __( 'EAE - Particles', 'wts-eae' )
				]
			);

			$element->add_control(
				'eae_enable_particles',
				[
					'type'  => Controls_Manager::SWITCHER,
					'label' => __('Enable Particle Background', 'wts-eae'),
					'default' => '',
					'label_on' => __( 'Yes', 'wts-eae' ),
					'label_off' => __( 'No', 'wts-eae' ),
					'return_value' => 'yes',
					'prefix_class' => 'eae-particle-',
					'render_type' => 'template',
				]
			);

			$element->add_control(
				'eae_enable_particles_alert',
				[
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'eae_enable_particles_alert elementor-control-field-description',
					'raw' => __( '<a href="https://vincentgarreau.com/particles.js/" target="_blank">Click here</a> to generate JSON for the below field. </br><a href="https://goo.gl/pHziXj" target="_blank">Know more</a> about using this feature.', 'wts-eae' ),
					'separator' => 'none',
					'condition' => [
						'eae_enable_particles' => 'yes',
					],
				]
			);

			$element->add_control(
				'eae_particle_json',
				[
					'type'    => Controls_Manager::CODE,
					'label'   => __('Add Particle Json'),
					'default' => '{
  "particles": {
    "number": {
      "value": 80,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.5,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 6,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "repulse"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
}',
					'render_type' => 'template',
					'condition' => [
						'eae_enable_particles' => 'yes'
					]
				]
			);

			$element->end_controls_section();

		}
	}

	public function _before_render($element){

		if($element->get_name() != 'section' && $element->get_name() != 'column'){
			return;
		}

		$settings = $element->get_settings();
		if($settings['eae_enable_particles'] == 'yes'){
			$element->add_render_attribute('_wrapper', 'data-eae-particle', $settings['eae_particle_json']);
		}

	}

	function _print_template($template,$widget){
		if($widget->get_name() != 'section' && $widget->get_name() != 'column'){
			return $template;
		}

		$old_template = $template;
		ob_start();
		?>

        <div class="eae-particle-wrapper" id="eae-particle-{{ view.getID() }}" data-eae-pdata=" {{ settings.eae_particle_json }}"></div>
		<?php
		$slider_content = ob_get_contents();
		ob_end_clean();
		$template = $slider_content.$old_template;
		return $template;
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

//Particles::instance();