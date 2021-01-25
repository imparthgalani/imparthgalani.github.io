<?php
function preloader_plus_sanitize_float($data) {
	if( $data == 0 ) {
		return '0';
	}
	return floatval($data);
}

function preloader_plus_sanitize_direction($data) {
	if( in_array( $data, array( 'none', 'top', 'right', 'bottom', 'left', 'middle' ) ) === true) {
		return $data;
	} else{
		return 'none';
	}
}

function preloader_plus_sanitize_alignment_array($data) {
	if(in_array($data, array('left','center', 'right')) === true) {
		return $data;
	} else{
		return 'left';
	}
}

function preloader_plus_sanitize_checkbox($data) {
	if( $data ) {
		return '1';
	} else {
		return false;
	}
}

/**
 * Sanitize typography dropdown
 * @since 1.0.0
 */
function preloader_plus_sanitize_typography( $input )
{

	// Grab all of our fonts
	$fonts = ( get_transient('preloader_plus_all_google_fonts') ? get_transient('preloader_plus_all_google_fonts') : array() );

	// Loop through all of them and grab their names
	$font_names = array();
	foreach ( $fonts as $k => $fam ) {
		$font_names[] = $fam['name'];
	}

	// Get all non-Google font names
	$not_google = array(
		'inherit',
		'Arial, Helvetica, sans-serif',
		'Century Gothic',
		'Comic Sans MS',
		'Courier New',
		'Georgia, Times New Roman, Times, serif',
		'Helvetica',
		'Impact',
		'Lucida Console',
		'Lucida Sans Unicode',
		'Palatino Linotype',
		'Tahoma, Geneva, sans-serif',
		'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif'
	);

	// Merge them both into one array
	$valid = array_merge( $font_names, $not_google );

	// Sanitize
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return 'Open Sans';
    }
}

/**
 * Sanitize font weight
 * @since 1.0.0
 */
function preloader_plus_sanitize_font_weight( $input ) {

    $valid = array(
        'normal',
		'bold',
		'100',
		'200',
		'300',
		'400',
		'500',
		'600',
		'700',
		'800',
		'900'
    );

    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return 'normal';
    }
}

/**
 * Sanitize text transform
 * @since 1.0.0
 */
function preloader_plus_sanitize_text_transform( $input ) {

    $valid = array(
        'none',
		'capitalize',
		'uppercase',
		'lowercase'
    );

    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return 'none';
    }
}

function preloader_plus_sanitize_bg_repeat($data) {
	if(in_array($data, array('repeat', 'no-repeat', 'repeat-x', 'repeat-y') ) === true) {
		return $data;
	} else{
		return 'no-repeat';
	}
}

function preloader_plus_sanitize_bg_attachment($data) {
	if(in_array($data, array('scroll', 'fixed', 'local') ) === true) {
		return $data;
	} else{
		return 'fixed';
	}
}

function preloader_plus_sanitize_bg_size($data) {
	if(in_array($data, array('auto', '100%', 'cover', 'contain') ) === true) {
		return $data;
	} else{
		return 'cover';
	}
}

function preloader_plus_units_sanitization($data) {
	$pattern = '/^\s*[0-9]+(\.[0-9])?(?:px|%)\s*$/';
	if ( preg_match( $pattern, $data ) === 1 ) {
		return $data;
	}
	return '0';
}

function preloader_plus_height_units_sanitization($data) {
	$pattern = '/^\s*[0-9]+(\.[0-9])?(?:px|%|vh)\s*$/';
	if ( preg_match( $pattern, $data ) === 1 ) {
		return $data;
	}
	return 'auto';
}

function preloader_plus_sanitize_col_numb( $data ) {
	if( $data >= 1 && $data <= 6 ) {
		return $data;
	} else{
		return 1;
	}
}

function preloader_plus_sanitize_boolopt( $data ) {
	if( in_array($data, array('yes','no')) === true ) {
		return $data;
	} else{
		return 'no';
	}
}

function preloader_plus_sanitize_custom_img_animation( $data ) {
	if( in_array( $data, array('none','rotation', 'fade' ) ) === true ) {
		return $data;
	} else{
		return 'none';
	}
}

function preloader_plus_sanitize_multi_choices( $input, $setting ) {
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$input_keys = $input;

	foreach ( $input_keys as $key => $value ) {
		if ( ! array_key_exists( $value, $choices ) ) {
			unset( $input[ $key ] );
		}
	}

	// If the input is a valid key, return it;
	// otherwise, return the default.
	return ( is_array( $input ) ? $input : $setting->default );
}
