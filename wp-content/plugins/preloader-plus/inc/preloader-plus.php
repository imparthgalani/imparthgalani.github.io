<?php
/**
 * Main Preloader Plus plugin class/file.
 *
 * @package preloader-plus
 */

namespace Preloader_Plus;

/**
 * Preloader Plus class, so we don't have to worry about namespaces.
 */
class Preloader_Plus {
	/**
	 * The instance *Singleton* of this class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Preloader_Plus the *Singleton* instance.
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Class construct function, to initiate the plugin.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
			// Registers filters to display custom content in the preloader.
			 add_filter( 'preloader_plus_content', 'wptexturize'                       );
			 add_filter( 'preloader_plus_content', 'convert_smilies',               20 );
			 add_filter( 'preloader_plus_content', 'wpautop'                           );
			 add_filter( 'preloader_plus_content', 'shortcode_unautop'                 );
			 add_filter( 'preloader_plus_content', 'wp_filter_content_tags' );
			 add_filter( 'preloader_plus_content', 'do_shortcode', 11 ); // AFTER wpautop()

			// Actions.
			add_action( 'inside_preloader_plus', array( $this, 'custom_content', ) );

			//Add new elements in the pro version
			add_filter( 'preloader_plus_elements_choices', array( $this, 'add_new_elements' ) );

			// Loads files
			require_once PRELOADER_PLUS_PRO_PATH . 'inc/customizer.php';

		// Actions.
		add_action( 'admin_menu', array( $this, 'create_top_menu_page' ) );
		add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ) );
		add_action( 'wp_footer', array( $this, 'preloader_view' ) );
		add_action( 'before_preloader_plus', array( $this, 'show_prog_bar' ) );
		add_action( 'upload_mimes', array( $this, 'add_svg_mime' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'show_once' ) );

		// Rate reminder actions.
		add_action( 'activated_plugin', array( $this, 'set_rate_reminder' ) );
		add_action( 'admin_notices', array( $this, 'show_rate_reminder' ) );
		add_action( 'upgrader_process_complete', array( $this, 'set_update_rate_reminder' ), 10, 2 );
		add_action( 'wp_ajax_preloader_plus_update_rate_reminder', array( $this, 'preloader_plus_update_rate_reminder' ) );

		// Loads files
		require_once PRELOADER_PLUS_PATH . 'inc/customizer.php';
	}


	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}


		/**
		 * Creates the main settings page.
		 */
		public function create_top_menu_page() {
				add_menu_page(
		 			'Preloader Plus',
		 			'Preloader Plus',
		 			'manage_options',
		 			'preloader_plus_setting_page',
					'',
					PRELOADER_PLUS_URL . 'assets/img/preloader-plus-logo.png'
		 		);
		}


		/**
		 * Creates the plugin page and a submenu item in WP menu.
		 */
		public function create_plugin_page() {
			$plugin_page_setup = array(
				'parent_slug' => 'preloader_plus_setting_page',
				'page_title'  => esc_html__( 'Preloader Plus' , 'bie' ),
				'menu_title'  => esc_html__( 'Preloader Plus' , 'bie' ),
				'capability'  => 'import',
				'menu_slug'   => 'preloader_plus_setting_page',
			);

			$this->plugin_page = add_submenu_page(
				$plugin_page_setup['parent_slug'],
				$plugin_page_setup['page_title'],
				$plugin_page_setup['menu_title'],
				$plugin_page_setup['capability'],
				$plugin_page_setup['menu_slug'],
				array( $this, 'display_plugin_page' )
			);
		}


		/**
		 * Plugin page display.
		 * Output (HTML) is in another file.
		 */
		public function display_plugin_page() {
			require_once PRELOADER_PLUS_PATH . 'views/plugin-page.php';
		}


	public function enqueue_scripts() {
		if( $this->is_preloader_active() ) {
			$preloader_plus_settings = wp_parse_args(
				get_option( 'preloader_plus_settings', array() ),
				preloader_plus_get_default()
			);
			if( ( false !== $preloader_plus_settings['show_on_front'] && ! is_front_page() ) || ( false !== $preloader_plus_settings['show_once'] && isset( $_COOKIE['show_preloader_once'] ) ) ) {
				return;
			}
			wp_enqueue_style( 'preloader-plus', PRELOADER_PLUS_URL . 'assets/css/preloader-plus.min.css', array() , PRELOADER_PLUS_VERSION );
			if( is_customize_preview() ) {
				wp_enqueue_script( 'preloader-plus-preview', PRELOADER_PLUS_URL . '/assets/js/preloader-plus-preview.js', array( 'jquery' ), PRELOADER_PLUS_VERSION, false );
				wp_localize_script( 'preloader-plus-preview', 'preloader_plus', array(
						'animation_delay'    => $preloader_plus_settings['animation_delay'],
						'animation_duration' => $preloader_plus_settings['animation_duration'],
				));
			} else {
				wp_enqueue_script( 'preloader-plus', PRELOADER_PLUS_URL . '/assets/js/preloader-plus.min.js', array( 'jquery' ), PRELOADER_PLUS_VERSION, false );
				// Get preloader options.
				wp_localize_script( 'preloader-plus', 'preloader_plus', array(
						'animation_delay'   => $preloader_plus_settings['animation_delay'],
						'animation_duration' => $preloader_plus_settings['animation_duration'],
				));
			}
		}
	}


	public function enqueue_admin_scripts( $page ) {
		if( 'toplevel_page_preloader_plus_setting_page' == $page ) {
			wp_enqueue_style( 'preloader-plus-options', PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-options.css', array() , PRELOADER_PLUS_VERSION );
		}
		wp_enqueue_style( 'preloader-plus-admin', PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-admin.css', array() , PRELOADER_PLUS_VERSION );

		// Enqueue scripts to manage reminder
		wp_enqueue_script( 'preloader-plus-rate-reminder', PRELOADER_PLUS_URL . '/assets/admin/js/preloader-plus-rate-reminder.js', array( 'jquery' ), PRELOADER_PLUS_VERSION, false );
		$preloader_plus_rate_reminder_nonce = wp_create_nonce( 'preloader_plus_rate_reminder_nonce' );
		wp_localize_script( 'preloader-plus-rate-reminder', 'preloader_plus_rate_reminder', array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'nonce'     => $preloader_plus_rate_reminder_nonce,
				'notice'    => 'preloader-plus-reminder',
		));
	}


	public function enqueue_control_scripts() {
		wp_enqueue_style( 'preloader-plus-customizer', PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-customizer.css', array() , PRELOADER_PLUS_VERSION );
	}


	/**
	 * Get preloader options.
	 *
	 * @since 1.0
	 */
	 public function get_options() {
		 // Get preloader options.
	 	$preloader_plus_settings = wp_parse_args(
	 		get_option( 'preloader_plus_settings', array() ),
	 		preloader_plus_get_default()
	 	);
		return $preloader_plus_settings;
	}

	public function add_new_elements() {
		$new_choices = array(
			'custom_image'   => esc_html__( 'Custom image', 'preloader-plus' ),
			'icon'       		 => esc_html__( 'Built-in icon', 'preloader-plus' ),
			'blog_name' 		 => esc_html__( 'Blog name', 'preloader-plus' ),
			'custom_content' => esc_html__( 'Custom content', 'preloader-plus' ),
			'counter'   		 => esc_html__( 'Percentage counter', 'preloader-plus' ),
			'progress_bar'   => esc_html__( 'Progress bar', 'preloader-plus' ),
		);
		return $new_choices;
	}

	/**
	 * Set a cookie to show the preloader once per session.
	 *
	 * @since 2.2
	 */
	 public function show_once() {
	 	$settings = $this->get_options();
	 	if( false !== $settings['show_once'] ) {
			if ( !isset( $_COOKIE['show_preloader_once'] ) ) {
				setcookie("show_preloader_once", 'show preloader once');
			}
			else {
				return;
			}
		}
	}

	/**
	 * Display the preloader.
	 *
	 * @since 1.0
	 */
	 public function preloader_view() {
		 if( !$this->is_preloader_active() ) {
			 return;
		 }
		 // Get preloader options.
		$settings = $this->get_options();

		if( false !== $settings['show_once'] ) {
			if ( isset( $_COOKIE['show_preloader_once'] ) ) {
				return;
			}
		}

		// Doesn't show the preloader if show on front is true and this is not the front page
		if( false !== $settings['show_on_front'] && ! is_front_page() ) {
			return;
		}
		?>
		 <div class="preloader-plus"> <?php
		 do_action('before_preloader_plus'); ?>
			 <div class="preloader-content"> <?php

			 $elements = $settings['elements'];

			 if( ! empty( $elements ) && is_array( $elements ) ) {

				 foreach( $elements as $element ) {

						// Custom image
  			 		if( ! empty( $settings['custom_icon_image'] ) && 'custom_image' == $element ) { ?>
  	 					<img class="preloader-custom-img" src="<?php echo esc_url( $settings['custom_icon_image'] ); ?>" /> <?php
  	 				}

  					// Default icon
  					if( 'icon' == $element  ) {
  						if( file_exists( PRELOADER_PLUS_PATH . 'views/' . $settings['icon_image'] . '.php' ) )
  							include_once PRELOADER_PLUS_PATH .  'views/' . $settings['icon_image'] . '.php';
  					}

  					// Site title
  					if( 'blog_name' == $element ) { ?>
  						<h1 class="preloader-site-title"> <?php esc_html( bloginfo( 'name' ) ) ?></h1> <?php
  					}

						// Custom content
						if( 'custom_content' == $element && ! empty( $settings['custom_content'] ) ) {
							$content = apply_filters( 'preloader_plus_content', $settings['custom_content'] ); ?>
							<div class="preloader-plus-custom-content">
								<?php echo $content ?>
							</div> <?php
	  				}

  					// Counter
  					if( 'counter' == $element ) { ?>
  						<p id="preloader-counter">0</p> <?php
  					}

						if( 'progress_bar' == $element && 'middle' === $settings['prog_bar_position']  ) { ?>
							<div class="prog-bar-wrapper middle">
								<div class="prog-bar-bg"></div>
								<div class="prog-bar"></div>
							</div> <?php
						}
 				}
			} ?>

			 </div>
		 </div> <?php
	}

	/**
	 * Display/Hide the progress bar.
	 *
	 * @since 1.0
	 */
	public function show_prog_bar() {
		 // Get preloader options.
	 	$settings = $this->get_options();
		if( in_array( 'progress_bar', $settings['elements'] ) && 'middle' !== $settings['prog_bar_position']  ) { ?>
			<div class="prog-bar-wrapper">
				<div class="prog-bar-bg"></div>
				<div class="prog-bar"></div>
			</div> <?php
		}
	}

	/**
	 * Check if the preloader is enabled.
	 *
	 * @since 1.0
	 */
	 public function is_preloader_active() {
		 // Get preloader options.
	 	$preloader_plus_settings = wp_parse_args(
	 		get_option( 'preloader_plus_settings', array() ),
	 		preloader_plus_get_default()
	 	);
		if( $preloader_plus_settings['enable_preloader'] === false ) {
			return false;
		}
		return true;
	}


	/**
	 * Allow svg file upload.
	 *
	 * @since 1.0
	 */
	public function add_svg_mime( $mimes ) {
	  $mimes['svg']  = 'image/svg+xml';

		return $mimes;
	}


	/**
	 * Load the plugin textdomain, so that translations can be made.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'preloader-plus', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
   * Set transients on plugin activation.
   *
   * @since 2.1
   */
 	public function set_rate_reminder() {
 		if( ! get_transient( 'preloader_plus_rate_reminder_deleted' ) && ! get_transient( 'preloader_plus_rate_reminder' ) ) {
			$date = new \DateTime();
 			set_transient( 'preloader_plus_rate_reminder', $date->format( 'Y-m-d' ) );
 		}
 	}

	/**
   * Set reminder transients on plugins update.
   *
	 * @since 2.1
   */
 	function set_update_rate_reminder( $upgrader_object, $options ) {
		if ( $options['action'] == 'update' && $options['type'] == 'plugin' ) {
			if( ! get_transient( 'preloader_plus_rate_reminder_deleted' ) && ! get_transient( 'preloader_plus_rate_reminder' ) ) {
	 			$date = new \DateTime();
	 			set_transient( 'preloader_plus_rate_reminder', $date->format( 'Y-m-d' ) );
	 		}
		}
 	}

	/**
   * Show reminders.
   *
	 * @since 2.1
   */
 	function show_rate_reminder() {
 		if( get_transient( 'preloader_plus_rate_reminder' ) ) {
			$start_date = new \DateTime( get_transient( 'preloader_plus_rate_reminder' ) );
			$start_date->add( new \DateInterval( 'P7D' ) );
			$actual_date = new \DateTime();
			if( $actual_date >= $start_date ) {
				$img_msg = sprintf( esc_html( '%1$s' ), '<img src="https://secure.gravatar.com/avatar/2467ad9a4cd4baeb814aed1fe1e9c235?s=150&d=retro&r=g" alt="Preloader Plus Plugin Author" />' );
				$message = sprintf( esc_html__( '%1$s Hey, I noticed you are using my plugin %2$s that%3$ss awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation. %4$s - %5$ sMassimo Sanfelice %6$s %7$s', 'preloader-plus' ), '<b>', '&ndash;', '&apos;', '</br>', '<em>', '</em>', '</b>' );
				$message .= sprintf( esc_html__( '%1$s %2$s YES, YOU DESERVE IT %3$s %4$s REMIND ME LATER %3$s %5$s I ALREADY DID  %3$s %6$s', 'preloader-plus'  ), '<span>', '<a class="button button-primary clear-rate-reminder" href="https://wordpress.org/support/plugin/preloader-plus/reviews/?filter=5" target="_blank">', '</a>', '<a class="button ask-later" href="#">', '<a class="button delete-rate-reminder" href="#">', '</span>' );
				printf( '<div class="notice preloader-plus-reminder"><div class="preloader-plus-author-avatar">%1$s</div><div class="preloader-plus-message">%2$s</div></div>', wp_kses_post( $img_msg ), wp_kses_post( $message ) );
			}
		}
 	}

	/**
	 * Delete or update the rate reminder admin notice.
	 *
	 * @since 2.1
	 */
	function preloader_plus_update_rate_reminder() {
		check_ajax_referer( 'preloader_plus_rate_reminder_nonce' );
		if( isset( $_POST['notice'] ) && isset( $_POST['update'] ) ) {
			$notice = sanitize_text_field( $_POST['notice'] );
			if( $_POST['update'] === 'preloader_plus_delete_rate_reminder' ) {
				delete_transient( 'preloader_plus_rate_reminder' );
				if( ! get_transient( 'preloader_plus_rate_reminder' ) && set_transient( 'preloader_plus_rate_reminder_deleted', 'No reminder to show' ) ) {
					$response = array(
						'error' => false,
					);
				} else {
					$response = array(
						'error' => true,
					);
				}
			}
			if( $_POST['update'] === 'preloader_plus_ask_later' ) {
				$date = new \DateTime();
				$date->add( new \DateInterval( 'P7D' ) );
				$date_format = $date->format( 'Y-m-d' );
				delete_transient( 'preloader_plus_rate_reminder' );
				if( set_transient( 'preloader_plus_rate_reminder', $date_format ) ) {
					$response = array(
						'error' => false,
					);
				} else {
					$response = array(
						'error' => true,
						'error_type' => set_transient( 'preloader_plus_rate_reminder', $date_format ),
					);
				}
			}

			wp_send_json( $response );
		}

	}

}
