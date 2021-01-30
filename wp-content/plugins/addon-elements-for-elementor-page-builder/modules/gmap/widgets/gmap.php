<?php
namespace WTS_EAE\Modules\Gmap\Widgets;


use Elementor\Repeater;
use Elementor\Controls_Manager;
use WTS_EAE\Base\EAE_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gmap extends EAE_Widget_Base {

	public function get_name() {
		return 'wts-gmap';
	}

	public function get_title() {
		return __( 'EAE - Google Map', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-google-maps wts-eae-map';
	}


    public function get_categories() {
		return [ 'wts-eae' ];
	}

	public function get_script_depends() {
		return ['eae-gmap'];
	}


	protected function _register_controls() {

	    $this->start_controls_section(
	        'general',
            [
                    'label' => __('General', 'wts-eae')
            ]
        );


	    $map_key = get_option('wts_eae_gmap_key');
	    if(!isset($map_key) || $map_key == ''){
		    $this->add_control(
			    'notice',
			    [
				    'type'  => Controls_Manager::RAW_HTML,
				    'raw'   => '<div class="eae-notice">
                                <a target="_blank" href="'.admin_url('admin.php?page=eae').'">Click Here</a> to add google map api key.
                            </div>'
			    ]
		    );
        }


	    $repeater = new Repeater();

	    $repeater->add_control(
	    	'lat',
		    [
		    	'label' => __('Latitude', 'wts-eae'),
			    'type'  => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
			    'placeholder' => __('Enter latitude value here', 'wts-eae')
		    ]
	    );

		$repeater->add_control(
			'long',
			[
				'label' => __('Longitude', 'wts-eae'),
				'type'  => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __('Enter latitude value here', 'wts-eae')
			]
		);

		$repeater->add_control(
			'address',
			[
				'label' => __('Address', 'wts-eae'),
				'type'  => Controls_Manager::WYSIWYG,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __('Enter address', 'wts-eae')
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => __('Icon', 'wts-eae'),
				'type'  => Controls_Manager::MEDIA
			]
		);

		$repeater->add_control(
		    'icon_size',
            [
                'label' => __('Icon Size', 'wts-eae'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
	                'px' => [
		                'min' => 20,
		                'max' => 200,
	                ],
                ],
                'default' => [
	                'size' => 50,
	                'unit' => 'px',
                ]
            ]
        );

		$repeater->add_control(
			'info_window_onload',
			[
				'label' =>  __('Info Window On Load' , 'wts-eae'),
				'type'  =>  Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Open', 'wts-eae' ),
				'label_off'    => __( 'Close', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control('markers',
			[
				'label' => __('Markers', 'wts-eae'),
				'type'  => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'default' => [
                        [
                            'lat' => '28.612912',
                            'long' => '77.229510',
                            'address' => __('Put Address Here', 'wts-eae')
                        ]
                ]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height','wts-eae'),
				'type'  => Controls_Manager::NUMBER,
				'default' => 200,
				'selectors' => [
					'{{WRAPPER}} .eae-markers' => 'height:{{VALUE}}px'
				]
			]
		);
		$this->add_control(
			'zoom',
			[
				'label' => __('Zoom','wts-eae'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
			]
		);

		$this->add_control(
		        'animate',
                [
                        'label' =>  __('Animate Marker' , 'wts-eae'),
                        'type'  =>  Controls_Manager::SWITCHER,
                        'default'      => '',
                        'label_on'     => __( 'Yes', 'wts-eae' ),
                        'label_off'    => __( 'No', 'wts-eae' ),
                        'return_value' => 'yes',
                ]
        );

		$this->add_control(
			'snazzy_style',
			[
				'label' => __( 'Snazzy Style', 'wts-eae' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __('Add style from Snazzy Maps. Copy and Paste style array from here -> <a href="https://snazzymaps.com/explore" target="_blank">Snazzy Maps</a>')
			]
		);

	    $this->end_controls_section();

	}

	protected function render( ) {
        $settings = $this->get_settings_for_display();

        $markers = $settings['markers'];

        $this->add_render_attribute('wrapper', 'data-zoom', $settings['zoom']['size']);

        $this->add_render_attribute('wrapper', 'data-style', $settings['snazzy_style']);

        $this->add_render_attribute('wrapper' , 'data-animate' , 'animate-'.$settings['animate']);

        //$this->add_render_attribute('wrapper' , 'data-show-info-window-onload' , $settings['open_info_window_onload']);

        if(count($markers)){
        	?>
	        <div class="eae-markers" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<?php
        	foreach($markers as $marker){
				?>
		        <div class="marker" data-lng="<?php echo $marker['long']; ?>" data-lat="<?php echo $marker['lat']; ?>" data-icon="<?php echo $marker['icon']['url']; ?>" data-icon-size="<?php echo $marker['icon_size']['size']; ?>" data-info-window="<?php echo $marker['info_window_onload']; ?>">
			        <?php echo $marker['address']; ?>
		        </div>
		        <?php
	        }
	        ?>
	        </div>
			<?php
        }


	}
}


//Plugin::instance()->widgets_manager->register_widget_type( new Widget_TextSeparator() );
