<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_Warnings 
 */
class CustomCSSandJS_Warnings {

    private $allowed_actions = array(
        'ccj_dismiss_qtranslate',
    );

    /**
     * Constructor
     */
    public function __construct() {

        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        } 

        $this->check_qtranslatex();
        add_action( 'wp_ajax_ccj_dismiss', array( $this, 'notice_dismiss' ) );
    }

    /**
     * Check if qTranslate plugin is active and doesn't have the custom-css-js removed from the settings 
     */
    function check_qtranslatex() {

        if ( ! is_plugin_active( 'qtranslate-x/qtranslate.php' ) ) return false;

        if ( get_option('ccj_dismiss_qtranslate') !== false ) {
            return;
        }

        $qtranslate_post_type_excluded = get_option('qtranslate_post_type_excluded');

        if ( ! is_array( $qtranslate_post_type_excluded ) || array_search( 'custom-css-js', $qtranslate_post_type_excluded ) === false ) { 
            add_action( 'admin_notices', array( $this, 'check_qtranslate_notice' ) );
            return;
        }
    }

    /**
     * Show a warning about qTranslate 
     */
    function check_qtranslate_notice() {
        $id = 'ccj_dismiss_qtranslate';
        $class = 'notice notice-warning is-dismissible';
        $message = sprintf(__( 'Please remove the <b>custom-css-js</b> post type from the <b>qTranslate settings</b> in order to avoid some malfunctions in the Simple Custom CSS & JS plugin. Check out <a href="%s" target="_blank">this screenshot</a> for more details on how to do that.', 'custom-css-js'), 'https://www.silkypress.com/wp-content/uploads/2016/08/ccj_qtranslate_compatibility.png' );
        $nonce =  wp_create_nonce( $id );

        printf( '<div class="%1$s" id="%2$s" data-nonce="%3$s"><p>%4$s</p></div>', $class, $id, $nonce, $message );

        $this->dismiss_js( $id );

    }

    /**
     * Allow the dismiss button to remove the notice
     */
    function dismiss_js( $slug ) {
    ?>
        <script type='text/javascript'>
        jQuery(function($){
            $(document).on( 'click', '#<?php echo $slug; ?> .notice-dismiss', function() {
            var data = {
                action: 'ccj_dismiss',
                option: '<?php echo $slug; ?>',
                nonce: $(this).parent().data('nonce'),
            };
            $.post(ajaxurl, data, function(response ) {
                $('#<?php echo $slug; ?>').fadeOut('slow');
            });
            });
        });
        </script>
    <?php
    }


    /**
     * Ajax response for `notice_dismiss` action
     */
    function notice_dismiss() {

        $option = $_POST['option'];

        if ( ! in_array($option, $this->allowed_actions ) ) {
            return;
        }

        check_ajax_referer( $option, 'nonce' );

        update_option( $option, 1 );

        wp_die();
    }

}


return new CustomCSSandJS_Warnings();
