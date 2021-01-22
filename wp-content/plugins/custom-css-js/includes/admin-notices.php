<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_Notices
 */
class CustomCSSandJS_Notices {

    var $prefix = 'ccj_';
    var $activation_time = '';
    var $version = '';
    var $dismiss_notice = '';
    var $expiration_days = 2;

    /**
     * Constructor
     */
    public function __construct() {

        $this->set_variables();

        if ( $this->dismiss_notice == 1 ) {
            return;
        }

        $p = $this->prefix;

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
        add_action( 'wp_ajax_'.$p.'_notice_dismiss', array( $this, 'notice_dismiss' ) );
    }

    /**
     * Hooked from 'admin_notices'
     */
    public function admin_notices() {
        $screen = get_current_screen();

        if ( !isset($screen->post_type) || $screen->post_type !== 'custom-css-js' )
            return;

        if ( ! $notice = $this->choose_notice() )
            return;

        if ( time() - $this->activation_time <= 3600 )
            return;

        $message = $this->get_message( $notice );

        $this->print_message( $notice, $message );
       
    }

    /**
     * Get the options from the database or set them on install or upgrade
     */
    public function set_variables() {
        $now = time();
        $p = $this->prefix;

        $this->activation_time = get_option( $p . '_activation_time', '' );
        $this->version = get_option( $p.'_version', '' );
        $this->dismiss_notice = get_option( $p.'_dismiss_notice', false );

        if ( empty( $this->activation_time ) || version_compare( $this->version, CCJ_VERSION, '<' ) ) {
            $this->activation_time = $now; 
            update_option( $p.'_activation_time', $now );
            update_option( $p.'_version', CCJ_VERSION );
            update_option( $p.'_dismiss_notice', false );
        }

    }

    /**
     * Choose which notice to be shown
     */
    public function choose_notice() {
        $now = time();

        $days_passed = floor( ( $now - $this->activation_time ) / 86400 );

        switch ( $days_passed ) {
            case 0 : return '1_day';
            case 1 : return '2_day';
            case 2 : break; //return '3_day';
            case 3 : break;
            case 4 : break;
            case 5 : break;
            case 6 : break; // return '7_day';
            case 7 : break;
            case 8 : break;
            case 9 : break;
            case 10 : break;
            case 11 : break; //return '12_day';
			default: break;
        }
    }

    /**
     * Get the text of the message
     */
    public function get_message( $notice ) {

        $message = '';
        $percentage = '30';
        $product_name = 'Simple Custom CSS and JS PRO';

        $expiration_date = $this->activation_time + ( $this->expiration_days * 86400 ); 
        $expiration_date = date( get_option( 'date_format') , $expiration_date );

        $expiration_period = date('j M', $this->activation_time - 3*86400 ) . ' - ' . date('j M', $this->activation_time + 2*86400 );


        if ( $notice == '12_days' ) {
            $link = 'https://www.silkypress.com/simple-custom-css-js-pro/?utm_source=wordpress&utm_campaign=ccj_free&utm_medium=banner';
        } else {
            $link = 'https://www.silkypress.com/simple-custom-css-js-pro/?a=' . $this->convert_numbers_letters( $this->activation_time ) . '&utm_source=wordpress&utm_campaign=ccj_free&utm_medium=banner';
        }

        $lower_part = sprintf( '<div style="margin-top: 7px;"><a href="%s" target="_blank">%s</a> | <a href="#" class="dismiss_notice"  target="_parent">%s</a></div>', $link, __('Get your discount now', 'custom-css-js'), __('Dismiss this notice', 'custom-css-js') ); 

        switch ( $notice ) {
            case '1_day' :
                $message = '<div>Only between '. $expiration_period .': <b>'.$percentage.'% Off from <a href="'.$link.'" target="_blank">'.$product_name.'</a></b> for our WordPress.org users.</div>' . $lower_part;
                break;

            case '2_day' : 
                $message = '<div><b>Limited offer ending today</b>. '.$percentage.'% Off from <a href="'.$link.'" target="_blank">'.$product_name.'</a> for our WordPress.org users. </div>' . $lower_part;
                break;

            case '3_day' : 
                $message = '<div><b>Limited offer ending today</b>. '.$percentage.'% Off from '.$product_name.' for our WordPress.org users. </div>' . $lower_part;
                break;

            case '7_day' :
                $message = '';
                break;

            case '12_day' :
                $message = '<div><b>Special Offer</b>: 30% Off from '.$product_name.' for our WordPress.org users.</div>' . $lower_part;
                break;
        }

        return $message;
    }



    /**
     * Print the message
     */
    public function print_message( $option_name = '', $message = '' ) {
        if ( empty( $message ) || empty( $option_name ) )
            return;

        $p = $this->prefix;

            ?>
            <style type="text/css">
                .<?php echo $p; ?>_note{ color: #bc1117; }
                #<?php echo $p; ?>_notice { display: block; padding:  }
                #<?php echo $p; ?>_notice b { color: #bc1117; }
                #<?php echo $p; ?>_notice a { text-decoration: none; font-weight: bold; }
                #<?php echo $p; ?>_notice a.dismiss_notice { font-weight: normal; }
            </style>

            <script type='text/javascript'>
                jQuery(function($){
                    $(document).on( 'click', '.<?php echo $p; ?>_notice .dismiss_notice', function() {
                        var data = {
                            action: '<?php echo $p; ?>_notice_dismiss',
                            option: '<?php echo $option_name; ?>',
                            nonce: $(this).parent().parent().data('nonce'),
                        };
                        $.post(ajaxurl, data, function(response ) {
                            $('#<?php echo $p; ?>_notice').fadeOut('slow');
                        });
                    });
                });
            </script>

                <div id="<?php echo $p; ?>_notice" class="updated notice <?php echo $p; ?>_notice is-dismissible" data-nonce="<?php echo wp_create_nonce( $this->prefix .'_notice'); ?>">
            <p><?php echo $message ?></p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php _e('Dismiss this notice'); ?></span>
            </button>
            </div>
<?php

    }

    function convert_numbers_letters( $text, $from = 'numbers' ) {
        $alphabet = str_split('abcdefghij');
        $numbers = str_split('0123456789');

        if ( $from == 'numbers' ) {
            return str_replace( $numbers, $alphabet, $text );
        } else {
            return str_replace( $alphabet, $numbers, $text );
        }
    }

    /**
     * Ajax response for `notice_dismiss` action
     */
    function notice_dismiss() {
        $p = $this->prefix;

        check_ajax_referer( $p . '_notice', 'nonce' );

        update_option( $p.'_dismiss_notice', 1 );

        wp_die();
    }
}


return new CustomCSSandJS_Notices();
