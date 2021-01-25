<?php
function preloader_plus_pro_customize_register( $wp_customize ) {

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

	$wp_customize->add_setting( 'preloader_plus_settings[custom_content]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['custom_content'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[custom_content]', array(
  		'type' => 'textarea',
  		'section' => 'preloader_plus_settings',
  		'label' => __( 'Custom content', 'preloader-plus' ),
			'description' => __( 'Insert your content here, html and shortcodes are allowed.', 'preloader-plus' ),
		  'priority' => 70,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_font_weight]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_font_weight'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_font_weight',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_font_weight]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font weight', 'preloader-plus' ),
			'priority' => 110,
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

	$wp_customize->add_setting( 'preloader_plus_settings[content_font_transform]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_font_transform'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_text_transform',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_font_transform]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Text transform', 'preloader-plus' ),
			'priority' => 120,
  		'choices' => array(
    		'none'       => __( 'None', 'preloader-plus' ),
				'capitalize' => __( 'Capitalize', 'preloader-plus' ),
				'uppercase'  => __( 'Uppercase', 'preloader-plus' ),
				'lowercase'  => __( 'Lowercase', 'preloader-plus' ),
			),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_font_size]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_font_size'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_font_size]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_typography',
			'description' => __( 'Font size in pixel', 'preloader-plus' ),
			'priority' => 130,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[animation_delay]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['animation_delay'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[animation_delay]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Animation delay', 'preloader-plus' ),
			'description' => __( 'Set the time (in milliseconds) after which the animation start after the end of page loading', 'preloader-plus' ),
			'priority' => 10,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[animation_duration]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['animation_duration'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[animation_duration]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Animation duration', 'preloader-plus' ),
			'description' => __( 'Set the animation duration (in milliseconds).', 'preloader-plus' ),
			'priority' => 15,
	) );

	$wp_customize->add_setting( 'preloader_plus_line', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_line',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_animations',
				'priority' => 20,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_heading', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_heading',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_animations',
				'label' => __( 'PRELOADER ANIMATIONS', 'preloader-plus' ),
				'priority' => 25,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[preloader_opacity]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['preloader_opacity'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_float',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[preloader_opacity]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Opacity', 'preloader-plus' ),
			'description' => __( 'Set a value for animate the preloader opacity. You can use a value between 0 (transparent) and 1 (full opacity). E.g.:0.1; 0.2 etc.', 'preloader-plus' ),
			'priority' => 30,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[preloader_direction]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['preloader_direction'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_direction',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[preloader_direction]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_animations',
  		'label' => __( 'Direction', 'preloader-plus' ),
			'description' => __( 'Choose the direction of the preloader on closing.', 'preloader-plus' ),
			'priority' => 40,
  		'choices' => array(
				'none' 	 => __( 'None', 'preloader-plus' ),
    		'top'    => __( 'Top', 'preloader-plus' ),
    		'right'  => __( 'Right', 'preloader-plus' ),
				'bottom' => __( 'Bottom', 'preloader-plus' ),
				'left'   => __( 'Left', 'preloader-plus' ),
  		),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[preloader_distance]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['preloader_distance'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_units_sanitization',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[preloader_distance]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Distance', 'preloader-plus' ),
			'description' => __( 'Set the distance that the preloader will cover to the direction that you have choosen in Direction. You can use pixel or percentage.', 'preloader-plus' ),
			'priority' => 50,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[preloader_scale]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['preloader_scale'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_float',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[preloader_scale]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Scale', 'preloader-plus' ),
			'description' => __( 'Set a value for animate the dimension of the preloader. Use a value below 1 (e.g.: 0.5) to scale it down, or a value above 1 (e.g.: 1.5) to scale it up.', 'preloader-plus' ),
			'priority' => 60,
	) );

	$wp_customize->add_setting( 'preloader_plus_line_two', array(
	  'type' => 'info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_line_two',
			array(
				'type' => 'line',
				'section' => 'preloader_plus_animations',
				'priority' => 70,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_heading_two', array(
	  'type' => 'preloader_plus_info_block',
	) );

	$wp_customize->add_control(
		new Preloader_Customize_Misc_Control(
			$wp_customize,
			'preloader_plus_heading_two',
			array(
				'type' => 'big_heading',
				'section' => 'preloader_plus_animations',
				'label' => __( 'CONTENT ANIMATIONS', 'preloader-plus' ),
				'priority' => 80,
			)
		)
	);

	$wp_customize->add_setting( 'preloader_plus_settings[enable_content_animation]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['enable_content_animation'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[enable_content_animation]', array(
  		'type' => 'checkbox',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Enable content animation', 'preloader-plus' ),
			'priority' => 90,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_selector]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_selector'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_selector]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Selector', 'preloader-plus' ),
			'description' => __( 'Preloader Plus animates the #content selector inside the page. Here you can choose a different selector to animate. Use a valid css selector (e.g.: #content, .sidebar, img, etc.).', 'preloader-plus' ),
			'priority' => 100,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_direction]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_direction'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_direction',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_direction]', array(
  		'type' => 'select',
  		'section' => 'preloader_plus_animations',
  		'label' => __( 'Direction', 'preloader-plus' ),
			'description' => __( 'Choose the direction of the content when it appears.', 'preloader-plus' ),
			'priority' => 110,
  		'choices' => array(
				'none' 	 => __( 'None', 'preloader-plus' ),
    		'top'    => __( 'Top', 'preloader-plus' ),
    		'right'  => __( 'Right', 'preloader-plus' ),
				'bottom' => __( 'Bottom', 'preloader-plus' ),
				'left'   => __( 'Left', 'preloader-plus' ),
  		),
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_distance]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_distance'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_units_sanitization',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_distance]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Distance', 'preloader-plus' ),
			'description' => __( 'Set the distance that the content will cover to the direction that you have choosen in Direction. You can use pixel or percentage.', 'preloader-plus' ),
			'priority' => 120,
	) );

	$wp_customize->add_setting( 'preloader_plus_settings[content_scale]', array(
  		'type' => 'option',
  		'capability' => 'edit_theme_options',
  		'default' => $defaults['content_scale'],
  		'transport' => 'refresh',
  		'sanitize_callback' => 'preloader_plus_sanitize_float',
	) );

	$wp_customize->add_control( 'preloader_plus_settings[content_scale]', array(
  		'type' => 'text',
  		'section' => 'preloader_plus_animations',
			'label' => __( 'Scale', 'preloader-plus' ),
			'description' => __( 'Set a value for animate the dimension of the content. Use a value below 1 (e.g.: 0.5) to scale it up, or a value above 1 (e.g.: 1.5) to scale it down. ', 'preloader-plus' ),
			'priority' => 130,
	) );

}
add_action( 'customize_register', 'preloader_plus_pro_customize_register' );
