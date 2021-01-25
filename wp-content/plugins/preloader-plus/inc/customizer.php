<?php
if( !function_exists('preloader_plus_get_default' )) {
	function preloader_plus_get_default() {
		$preloader_plus_default = array(
			'enable_preloader'          => true,
			'elements'                  => apply_filters( 'preloader_plus_elements_default', array( 'icon', 'progress_bar' ) ),
			'show_on_front'             => false,
			'show_once'                 => false,
			'custom_content'            => '',
			'bg_color'                  => '#141414',
			'text_color'                => '#65615F',
			'title_font_weight'         => 'bold',
			'title_font_transform'      => 'none',
			'title_font_size'           => '50',
			'percentage_font_weight'    => 'bold',
			'percentage_font_size'      => '24',
			'content_font_weight'       => 'bold',
			'content_font_transform'    => 'none',
			'content_font_size'         => '24',
			'icon_image'                => 'Rolling',
			'icon_image_dimension'      => 80,
			'custom_icon_image'         => '',
			'custom_img_dimension'      => 250,
			'custom_img_animation'      => 'none',
			'custom_img_speed'          => 1500,
			'prog_bar_position'         => 'top',
			'prog_bar_height'           => '5',
			'prog_bar_width'            => '100%',
			'prog_bar_color'            => '#dd3333',
			'prog_bar_bg_color'         => '#919191',
			'prog_bar_pad_y'            => '0',
			'animation_delay'           => '500',
			'animation_duration'        => '1000',
			'preloader_opacity'         => '0',
			'preloader_direction'       => 'none',
			'preloader_distance'        => '0',
			'preloader_scale'           => '1',
			'enable_content_animation'  => false,
			'content_selector'          => '',
			'content_direction'         => 'none',
			'content_distance'          => '0',
			'content_scale'             => '1',
		);

		return apply_filters('preloader_plus_default_options', $preloader_plus_default );
	}
}

function preloader_plus_customize_register( $wp_customize ) {

	// Get default header options
	$defaults = preloader_plus_get_default();

	// Get preloader options.
	$preloader_plus_settings = wp_parse_args(
		get_option( 'preloader_plus_settings', array() ),
		preloader_plus_get_default()
	);

	require_once PRELOADER_PLUS_PATH . '/inc/sanitize.php';
	require_once PRELOADER_PLUS_PATH . '/inc/controls.php';
	require_once PRELOADER_PLUS_PATH . '/inc/customizer-callbacks.php';

 	// Register js controls
	$wp_customize->register_control_type( 'Preloader_Plus_Customizer_Sortable_Control' 		);

	// Adds Preloader Plus panel
	$wp_customize->add_panel( 'preloader_plus', array(
    	'priority'       => 25,
    	'capability'     => 'edit_theme_options',
    	'title'          => __( 'Preloader Plus', 'preloader-plus' ),
			'priority'      => 180,
	) );

	// Add Settings section
	$wp_customize->add_section( 'preloader_plus_settings', array(
			'title' => __( 'Settings', 'preloader-plus' ),
			'priority' => 10,
			'description_hidden' => true,
			'capability' => 'edit_theme_options',
			'panel' => 'preloader_plus',
	) );

	$wp_customize->add_setting( 'preloader_plus_settings_one', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_settings_one',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_settings',
				'label' => __( 'GENERAL', 'preloader-plus' ),
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[enable_preloader]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['enable_preloader'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[enable_preloader]', array(
  		'type' => 'checkbox',
  		'section' => 'preloader_plus_settings',
			'label' => __( 'Enable preloader', 'preloader-plus' ),
			'priority' => 10,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[show_on_front]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['show_on_front'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[show_on_front]', array(
  		'type' => 'checkbox',
  		'section' => 'preloader_plus_settings',
			'label' => __( 'Show the preloader only on the front page', 'preloader-plus' ),
			'priority' => 10,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[show_once]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['show_once'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[show_once]', array(
  		'type' => 'checkbox',
  		'section' => 'preloader_plus_settings',
			'label' => __( 'Show the preloader only on first visit', 'preloader-plus' ),
			'priority' => 10,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[elements]', array(
		'type'              => 'option',
		'default'           =>  $defaults['elements'],
		'sanitize_callback' => 'preloader_plus_sanitize_multi_choices',
	) );

	$wp_customize->add_control( new Preloader_Plus_Customizer_Sortable_Control( $wp_customize, 'preloader_plus_settings[elements]', array(
		'label'	   				=> esc_html__( 'Elements positioning and visibility', 'preloader-plus' ),
		'section'  				=> 'preloader_plus_settings',
		'settings' 				=> 'preloader_plus_settings[elements]',
		'priority' 				=> 10,
		'choices' 				=> apply_filters( 'preloader_plus_elements_choices', array(
			'custom_image'   => esc_html__( 'Custom image', 'preloader-plus' ),
			'icon'       		 => esc_html__( 'Built-in icon', 'preloader-plus' ),
			'blog_name' 		 => esc_html__( 'Blog name', 'preloader-plus' ),
			'counter'   		 => esc_html__( 'Percentage counter', 'preloader-plus' ),
			'progress_bar'   => esc_html__( 'Progress bar', 'preloader-plus' ),
		) ),
	) ) );

	$wp_customize->add_setting(
		'preloader_plus_settings[bg_color]', array(
			'default' => $defaults['bg_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bg_color',
			array(
				'label' => __( 'Preloader background color', 'preloader-plus' ),
				'section' => 'preloader_plus_settings',
				'settings' => 'preloader_plus_settings[bg_color]',
				'priority' => 30,
			)
		)
	);

	$wp_customize->add_setting(
		'preloader_plus_settings[text_color]', array(
			'default' => $defaults['text_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'label' => __( 'Preloader text color', 'preloader-plus' ),
				'section' => 'preloader_plus_settings',
				'settings' => 'preloader_plus_settings[text_color]',
				'priority' => 40,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings_line_one', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_settings_line_one',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_settings',
				'priority' => 50,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings_two', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_settings_two',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_settings',
				'label' => __( 'CUSTOM CONTENT', 'preloader-plus' ),
				'priority' => 60,
			)
		)
	);

	if( ! function_exists( 'preloader_plus_pro_customize_register' ) ) {
		$wp_customize->add_setting( 'preloader_plus_settings_pro_one', array(
		  'type' => 'preloader_plus_pro_block',
		) );

		$wp_customize->add_control(
			new Preloader_Customize_Misc_Control(
				$wp_customize,
				'preloader_plus_settings_pro_one',
				array(
					'type' => 'pro-info',
					'section' => 'preloader_plus_settings',
					'label' => __( 'Premium Features', 'preloader-plus' ),
					'description' => __( 'Add custom content: plain text, html or even shortcodes.', 'preloader-plus' ),
					'url' => esc_url( 'https://preloader-plus.maxsdesign.net/premium/' ),
					'text_url' => __( 'SHOW ME PRO FEATURES', 'preloader-plus' ),
					'priority' => 70,
				)
			)
		);
	}

	// Add Typography section
	$wp_customize->add_section( 'preloader_plus_typography', array(
			'title' => __( 'Typography', 'preloader-plus' ),
			'priority' => 10,
			'description_hidden' => true,
			'capability' => 'edit_theme_options',
			'panel' => 'preloader_plus',
	) );

	$wp_customize->add_setting( 'preloader_plus_typography_one', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_typography_one',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_typography',
				'label' => __( 'BLOG NAME', 'preloader-plus' ),
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[title_font_weight]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['title_font_weight'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_font_weight',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[title_font_weight]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font weight', 'preloader-plus' ),
			'priority' => 10,
  		'choices' => array(
    		'normal'     => __( 'Normal', 'preloader-plus' ),
				'bold' => __( 'Bold', 'preloader-plus' ),
				'100'     => __( '100', 'preloader-plus' ),
				'200'     => __( '200', 'preloader-plus' ),
				'300'     => __( '300', 'preloader-plus' ),
				'400'     => __( '400', 'preloader-plus' ),
				'500'     => __( '500', 'preloader-plus' ),
				'600'     => __( '600', 'preloader-plus' ),
				'700'     => __( '700', 'preloader-plus' ),
				'800'     => __( '800', 'preloader-plus' ),
				'900'     => __( '900', 'preloader-plus' ),
			),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[title_font_transform]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['title_font_transform'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_text_transform',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[title_font_transform]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Text transform', 'preloader-plus' ),
			'priority' => 20,
  		'choices' => array(
    		'none'       => __( 'None', 'preloader-plus' ),
				'capitalize' => __( 'Capitalize', 'preloader-plus' ),
				'uppercase'  => __( 'Uppercase', 'preloader-plus' ),
				'lowercase'  => __( 'Lowercase', 'preloader-plus' ),
			),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[title_font_size]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['title_font_size'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[title_font_size]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font size in pixel', 'preloader-plus' ),
			'priority' => 30,
	) );

	$wp_customize->add_setting( 'preloader_plus_typography_line_one', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_typography_line_one',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_typography',
				'priority' => 40,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_typography_two', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_typography_two',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_typography',
				'label' => __( 'PERCENTAGE COUNTER', 'preloader-plus' ),
				'priority' => 50,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[percentage_font_weight]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['percentage_font_weight'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_font_weight',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[percentage_font_weight]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font weight', 'preloader-plus' ),
			'priority' => 60,
  		'choices' => array(
    		'normal'     => __( 'Normal', 'preloader-plus' ),
				'bold' => __( 'Bold', 'preloader-plus' ),
				'100'     => __( '100', 'preloader-plus' ),
				'200'     => __( '200', 'preloader-plus' ),
				'300'     => __( '300', 'preloader-plus' ),
				'400'     => __( '400', 'preloader-plus' ),
				'500'     => __( '500', 'preloader-plus' ),
				'600'     => __( '600', 'preloader-plus' ),
				'700'     => __( '700', 'preloader-plus' ),
				'800'     => __( '800', 'preloader-plus' ),
				'900'     => __( '900', 'preloader-plus' ),
			),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[percentage_font_size]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['percentage_font_size'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[percentage_font_size]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font size in pixel', 'preloader-plus' ),
			'priority' => 80,
	) );

	$wp_customize->add_setting( 'preloader_plus_typography_line_two', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_typography_line_two',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_typography',
				'priority' => 90,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_typography_three', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_typography_three',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_typography',
				'label' => __( 'CUSTOM CONTENT', 'preloader-plus' ),
				'priority' => 100,
			)
		)
	);

	if( ! function_exists( 'preloader_plus_pro_customize_register' ) ) {
		$wp_customize->add_setting( 'preloader_plus_typography_pro_one', array(
		  'type' => 'preloader_plus_pro_block',
		) );

		$wp_customize->add_control(
			new Preloader_Customize_Misc_Control(
				$wp_customize,
				'preloader_plus_typography_pro_one',
				array(
					'type' => 'pro-info',
					'section' => 'preloader_plus_typography',
					'label' => __( 'Premium Features', 'preloader-plus' ),
					'description' => __( 'Set the size, the weight and the transformation (capitalize, uppercase, lowercase) of the text of your custom content.', 'preloader-plus' ),
					'url' => esc_url( 'https://preloader-plus.maxsdesign.net/premium/' ),
					'text_url' => __( 'SHOW ME PRO FEATURES', 'preloader-plus' ),
					'priority' => 110,
				)
			)
		);
	}

	// Add Icon/Image section
	$wp_customize->add_section( 'preloader_plus_icon_image', array(
			'title' => __( 'Icon / Image', 'preloader-plus' ),
			'priority' => 20,
			'description_hidden' => true,
			'capability' => 'edit_theme_options',
			'panel' => 'preloader_plus',
	) );

	$wp_customize->add_setting( 'preloader_plus_icon_heading_one', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_icon_heading_one',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_icon_image',
				'label' => __( 'BUILT-IN ICONS', 'preloader-plus' ),
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[icon_image]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['icon_image'],
  		'transport' => 'refresh',
  		'sanitize_callback' => '',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Radio_Control(
			$wp_customize,
		 'preloader_plus_settings[icon_image]', array(
  		'type' => 'radio_images',
  		'section' => 'preloader_plus_icon_image',
  		'label' => __( 'Icons', 'preloader-plus' ),
			'description' => __( 'Choose an icon.', 'preloader-plus' ),
			'priority' => 30,
  		'choices' => array(
				'Bars' 	   => PRELOADER_PLUS_URL . 'assets/img/Bars.gif"',
				'DualRing' => PRELOADER_PLUS_URL . 'assets/img/DualRing.gif"',
				'Eclipse'  => PRELOADER_PLUS_URL . 'assets/img/Eclipse.gif"',
				'Dots'     => PRELOADER_PLUS_URL . 'assets/img/Dots.png"',
				'Ripple' 	 => PRELOADER_PLUS_URL . 'assets/img/Ripple.gif"',
				'Rolling'  => PRELOADER_PLUS_URL . 'assets/img/Rolling.gif"',
  		),
		)
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[icon_image_dimension]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['icon_image_dimension'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[icon_image_dimension]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_icon_image',
			'label' => __( 'Icon dimension', 'preloader-plus' ),
			'description' => __( 'Set the dimension of the icon in pixels.', 'preloader-plus' ),
			'priority' => 40,
	) );

	$wp_customize->add_setting( 'preloader_plus_icon_line_one', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_icon_line_one',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_icon_image',
				'priority' => 50,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_icon_heading_two', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_icon_heading_two',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_icon_image',
				'label' => __( 'CUSTOM IMAGE', 'preloader-plus' ),
				'priority' => 60,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[custom_icon_image]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['custom_icon_image'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'preloader_plus_settings[custom_icon_image]', array(
  		'label' => __( 'Custom icon / image', 'preloader-plus' ),
			'description' => __( 'Choose a custom icon or image. Also svg images are allowed', 'preloader-plus' ),
  		'section' => 'preloader_plus_icon_image',
  		'mime_type' => 'image',
			'extensions' => array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
			'priority'  => 70,
	) ) );

	$wp_customize->add_setting( 'preloader_plus_settings[custom_img_dimension]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['custom_img_dimension'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[custom_img_dimension]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_icon_image',
			'label' => __( 'Dimension', 'preloader-plus' ),
			'description' => __( 'Set the dimension of the custom image.', 'preloader-plus' ),
			'priority' => 80,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[custom_img_animation]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['custom_img_animation'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_custom_img_animation',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[custom_img_animation]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_icon_image',
  		'label' => __( 'Animation', 'preloader-plus' ),
			'description' => __( 'Choose how to animate the custom icon / image..', 'preloader-plus' ),
			'priority' => 90,
  		'choices' => array(
    		'none'     => __( 'No animation', 'preloader-plus' ),
				'rotation' => __( 'Rotation', 'preloader-plus' ),
				'fade'     => __( 'Fade', 'preloader-plus' ),
  		),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[custom_img_speed]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['custom_img_speed'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[custom_img_speed]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_icon_image',
			'label' => __( 'Animation speed', 'preloader-plus' ),
			'description' => __( 'Choose a value in milliseconds to set the animation speed of the custom image.', 'preloader-plus' ),
			'priority' => 100,
	) );

	// Add Progress bar section
	$wp_customize->add_section( 'preloader_plus_prog_bar', array(
			'title' => __( 'Progress bar', 'preloader-plus' ),
			'priority' => 30,
			'description_hidden' => true,
			'capability' => 'edit_theme_options',
			'panel' => 'preloader_plus',
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[prog_bar_position]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['prog_bar_position'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_direction',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[prog_bar_position]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_prog_bar',
  		'label' => __( 'Position', 'preloader-plus' ),
			'description' => __( 'Choose the position of the progress bar. You can display it at the top or at the bottom of the page.', 'preloader-plus' ),
			'priority' => 20,
  		'choices' => array(
    		'top'    => __( 'Top', 'preloader-plus' ),
				'middle' => __( 'Middle', 'preloader-plus' ),
				'bottom' => __( 'Bottom', 'preloader-plus' ),
  		),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[prog_bar_height]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['prog_bar_height'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[prog_bar_height]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_prog_bar',
			'label' => __( 'Height', 'preloader-plus' ),
			'description' => __( 'Set the height of the progress bar.', 'preloader-plus' ),
			'priority' => 30,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[prog_bar_width]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['prog_bar_width'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_units_sanitization',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[prog_bar_width]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_prog_bar',
			'label' => __( 'Width', 'preloader-plus' ),
			'description' => __( 'Set the width of the progress bar. Use pixels or percentage (e.g.: 300px, 60%)', 'preloader-plus' ),
			'priority' => 40,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[prog_bar_pad_y]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['prog_bar_pad_y'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_units_sanitization',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[prog_bar_pad_y]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_prog_bar',
			'label' => __( 'Distance from top / bottom', 'preloader-plus' ),
			'description' => __( 'Set the distance from the top or the bottom, depends on the value choosen in position option. Use pixels or percentage (e.g.: 20px, 10%)', 'preloader-plus' ),
			'priority' => 50,
	) );

	$wp_customize->add_setting(
		'preloader_plus_settings[prog_bar_color]', array(
			'default' => $defaults['prog_bar_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'prog_bar_color',
			array(
				'label' => __( 'Color', 'preloader-plus' ),
				'section' => 'preloader_plus_prog_bar',
				'settings' => 'preloader_plus_settings[prog_bar_color]',
				'priority' => 60,
			)
		)
	);

	$wp_customize->add_setting(
		'preloader_plus_settings[prog_bar_bg_color]', array(
			'default' => $defaults['prog_bar_bg_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'prog_bar_bg_color',
			array(
				'label' => __( 'Background color', 'preloader-plus' ),
				'section' => 'preloader_plus_prog_bar',
				'settings' => 'preloader_plus_settings[prog_bar_bg_color]',
				'priority' => 70,
			)
		)
	);

	// Add Animations section
	$wp_customize->add_section( 'preloader_plus_animations', array(
			'title' => __( 'Animations', 'preloader-plus' ),
			'priority' => 40,
			'description_hidden' => true,
			'capability' => 'edit_theme_options',
			'panel' => 'preloader_plus',
	) );

	if( ! function_exists( 'preloader_plus_pro_customize_register' ) ) {
		$wp_customize->add_setting( 'preloader_plus_animations_pro_one', array(
		  'type' => 'preloader_plus_pro_block',
		) );

		$wp_customize->add_control(
			new Preloader_Customize_Misc_Control(
				$wp_customize,
				'preloader_plus_animations_pro_one',
				array(
					'type' => 'pro-info',
					'section' => 'preloader_plus_animations',
					'label' => __( 'Premium Features', 'preloader-plus' ),
					'description' => __( 'Add preloader and content animations: choose opacity, direction, distance and scaling. Set the duration of the animation and an animation delay.', 'preloader-plus' ),
					'url' => esc_url( 'https://preloader-plus.maxsdesign.net/premium/' ),
					'text_url' => __( 'SHOW ME PRO FEATURES', 'preloader-plus' ),
					'priority' => 5,
				)
			)
		);
	}

}
add_action( 'customize_register', 'preloader_plus_customize_register' );

function preloader_plus_styles() {
	// Get preloader plus options.
	$preloader_plus_settings = wp_parse_args(
		get_option( 'preloader_plus_settings', array() ),
		preloader_plus_get_default()
	);

	$preloader_scale = $preloader_plus_settings['preloader_scale'] === '0' ? '0' :  floatval( $preloader_plus_settings['preloader_scale'] );
	$preloader_opacity = $preloader_plus_settings['preloader_opacity'] === '0' ? '0' :  floatval( $preloader_plus_settings['preloader_opacity'] );
	$preloader_minus = 'top' === $preloader_plus_settings['preloader_direction'] || 'left' === $preloader_plus_settings['preloader_direction'] ? '-' : '';
	if( 'none' !== $preloader_plus_settings['preloader_direction'] ) {
		if( 'top' === $preloader_plus_settings['preloader_direction'] || 'bottom' === $preloader_plus_settings['preloader_direction'] ) {
			$preloader_direction = 'translateY';
		} else{
			$preloader_direction = 'translateX';
		}
		$preloader_translation = $preloader_direction . '(' . $preloader_minus . $preloader_plus_settings['preloader_distance'] . ')';
	} else {
		$preloader_translation = '';
	}
	$preloader_scale = ' scale(' . $preloader_scale . ')';
	$preloader_transform = $preloader_translation . $preloader_scale;

	$content_scale = $preloader_plus_settings['content_scale'] === '0' ? '0' :  floatval( $preloader_plus_settings['content_scale'] );
	$content_minus = 'bottom' === $preloader_plus_settings['content_direction'] || 'right' === $preloader_plus_settings['content_direction'] ? '-' : '';
	if( 'none' !== $preloader_plus_settings['content_direction'] ) {
		if( 'top' === $preloader_plus_settings['content_direction'] || 'bottom' === $preloader_plus_settings['content_direction'] ) {
			$content_direction = 'translateY';
		} else{
			$content_direction = 'translateX';
		}
		$content_translation = $content_direction . '(' . $content_minus . $preloader_plus_settings['content_distance'] . ')';
	} else {
		$content_translation = '';
	}
	$content_scale = ' scale(' . $content_scale . ')';
	$content_transform = $content_translation . $content_scale;
	$content_selector_start = ! empty( $preloader_plus_settings['content_selector'] ) ? 'body ' . $preloader_plus_settings['content_selector'] : 'body #content';
	$content_selector_end = ! empty( $preloader_plus_settings['content_selector'] ) ? 'body.complete ' . $preloader_plus_settings['content_selector'] : 'body.complete #content';

	$preloader_plus = array(

		// Content
		$content_selector_start => array(
			'opacity' => '0',
			'transform' => esc_attr( $content_transform ),
			'transition' => 'transform ' . absint( $preloader_plus_settings['animation_duration'] ) . 'ms ease, opacity ' . absint( $preloader_plus_settings['animation_duration'] ) . 'ms ease',
		),

		$content_selector_end => array(
			'opacity' => '1',
			'transform' => 'translate(0,0) scale(1)',
		),

		// Main preloader container
		'.preloader-plus' => array(
			'background-color' => esc_attr( $preloader_plus_settings['bg_color'] ),
		),

		'body.complete > *:not(.preloader-plus),
		.preloader-plus' => array(
			'transition-duration' => absint( $preloader_plus_settings['animation_duration'] ) . 'ms,' . absint( $preloader_plus_settings['animation_duration'] ) . 'ms,' . '0s',
		),

		'.preloader-plus *' => array(
			'color' => esc_attr( $preloader_plus_settings['text_color'] ),
		),

		'.preloader-plus.complete' => array(
			'opacity' => esc_attr( $preloader_opacity ),
			'transform' => esc_attr( $preloader_transform ),
			'transition-delay' => '0s,' . '0s,' . $preloader_plus_settings['animation_duration'] . 'ms',
		),

		// Blog name
		'.preloader-plus .preloader-site-title' => array(
			'font-weight' => esc_attr( $preloader_plus_settings['title_font_weight'] ),
			'font-size' => absint( $preloader_plus_settings['title_font_size'] ) . 'px',
			'text-transform' => esc_attr( $preloader_plus_settings['title_font_transform'] ),
		),

		// Percentage counter
		'.preloader-plus #preloader-counter' => array(
			'font-weight' => esc_attr( $preloader_plus_settings['percentage_font_weight'] ),
			'font-size' => absint( $preloader_plus_settings['percentage_font_size'] ) . 'px',
		),

		// Custom content
		'.preloader-plus .preloader-plus-custom-content' => array(
			'font-weight' => esc_attr( $preloader_plus_settings['content_font_weight'] ),
			'font-size' => absint( $preloader_plus_settings['content_font_size'] ) . 'px',
			'text-transform' => esc_attr( $preloader_plus_settings['content_font_transform'] ),
		),

		// Default icons
		'.preloader-plus-default-icons' => array(
			'width' => absint( $preloader_plus_settings['icon_image_dimension'] ) . 'px',
			'height' => absint( $preloader_plus_settings['icon_image_dimension'] ) . 'px',
		),

		// Custom image
		'.preloader-plus .preloader-custom-img' => array(
			'animation' => 'preloader-' . esc_attr( $preloader_plus_settings['custom_img_animation'] ) . ' ' . absint( $preloader_plus_settings['custom_img_speed'] ) . 'ms linear infinite',
			'width' => absint( $preloader_plus_settings['custom_img_dimension'] ) . 'px',
		),

		// Progress bar
		'.preloader-plus .prog-bar' => array(
			'height' => absint( $preloader_plus_settings['prog_bar_height'] ) . 'px',
			'background-color' => esc_attr( $preloader_plus_settings['prog_bar_color'] ),
		),

		'.preloader-plus .prog-bar-bg' => array(
			'height' => absint( $preloader_plus_settings['prog_bar_height'] ) . 'px',
			'background-color' => esc_attr( $preloader_plus_settings['prog_bar_bg_color'] ),
		),

		'.preloader-plus .prog-bar-wrapper' => array(
			esc_attr( $preloader_plus_settings['prog_bar_position'] ) => '0',
			'padding-' . esc_attr( $preloader_plus_settings['prog_bar_position'] ) => esc_attr( $preloader_plus_settings['prog_bar_pad_y'] ),
			'width' => esc_attr( $preloader_plus_settings['prog_bar_width'] ),
		),
	);

	if( false === $preloader_plus_settings['enable_content_animation'] ) {
		$preloader_plus[$content_selector_start] = array();
		$preloader_plus[$content_selector_end] = array();
	}

	// Output the above CSS
	$output = '';
	foreach($preloader_plus as $k => $properties) {
		if(!count($properties))
			continue;

		$temporary_output = $k . ' {';
		$elements_added = 0;

		foreach($properties as $p => $v) {
			if( empty($v) && $v !== '0' )
				continue;

			$elements_added++;
			$temporary_output .= $p . ': ' . $v . '; ';
		}

		$temporary_output .= "}";

		if($elements_added > 0)
			$output .= $temporary_output;
	}

	$output = str_replace(array("\r", "\n", "\t"), '', $output);
	return $output;
}

/**
 * Enqueue header content styles
 */
add_action( 'wp_enqueue_scripts', 'preloader_plus_scripts', 50 );
function preloader_plus_scripts() {

	wp_add_inline_style( 'preloader-plus', preloader_plus_styles() );

}
