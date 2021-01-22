<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_AdminConfig 
 */
class CustomCSSandJS_AdminConfig {

    var $settings_default;

    var $settings;

    /**
     * Constructor
     */
    public function __construct() {
        // Get the "default settings"
        $settings_default = apply_filters( 'ccj_settings_default', array() );

        // Get the saved settings
        $settings = get_option('ccj_settings');
        if ( $settings == false ) {
            $settings = $settings_default;
        } else {
            foreach( $settings_default as $_key => $_value ) {
                if ( ! isset($settings[$_key] ) ) {
                    $settings[$_key] = $_value;
                }
            }
        }
        $this->settings = $settings;
        $this->settings_default = $settings_default;

        //Add actions and filters
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );


        add_action( 'ccj_settings_form', array( $this, 'general_extra_form' ), 11 );
        add_filter( 'ccj_settings_default', array( $this, 'general_extra_default' ) );
        add_filter( 'ccj_settings_save', array( $this, 'general_extra_save' ) );
    }


    /**
     * Add submenu pages
     */
    function admin_menu() {
        $menu_slug = 'edit.php?post_type=custom-css-js';

        add_submenu_page( $menu_slug, __('Settings', 'custom-css-js'), __('Settings', 'custom-css-js'), 'manage_options', 'custom-css-js-config', array( $this, 'config_page' ) );

    }


    /**
     * Enqueue the scripts and styles
     */
    public function admin_enqueue_scripts( $hook ) {

        $screen = get_current_screen();

        // Only for custom-css-js post type
        if ( $screen->post_type != 'custom-css-js' ) 
            return false;

        if ( $hook != 'custom-css-js_page_custom-css-js-config' ) 
            return false;

        // Some handy variables
        $a = plugins_url( '/', CCJ_PLUGIN_FILE). 'assets';
        $v = CCJ_VERSION; 

        wp_enqueue_script( 'tipsy', $a . '/jquery.tipsy.js', array('jquery'), $v, false );
        wp_enqueue_style( 'tipsy', $a . '/tipsy.css', array(), $v );
    }



    /**
     * Template for the config page
     */
    function config_page() {

        if ( isset( $_POST['ccj_settings-nonce'] ) ) {
            check_admin_referer('ccj_settings', 'ccj_settings-nonce');

            $data = apply_filters( 'ccj_settings_save', array() );

            $settings = get_option('ccj_settings');
            if ( !isset($settings['add_role'] ) ) $settings['add_role'] = false;
            if ( !isset($settings['remove_comments'] ) ) $settings['remove_comments'] = false;

            // If the "add role" option changed
            if ( $data['add_role'] !== $settings['add_role'] && current_user_can('update_plugins')) {
                // Add the 'css_js_designer' role
                if ( $data['add_role'] ) {
                    CustomCSSandJS_Install::create_roles();
                }

                // Remove the 'css_js_designer' role
                if ( !$data['add_role'] ) {
                    remove_role('css_js_designer');
                }
                flush_rewrite_rules();
            }

            update_option( 'ccj_settings', $data );

        } else {
            $data = $this->settings;
        }

        ?>
        <div class="wrap">

        <?php $this->config_page_header('editor'); ?>

        <form action="<?php echo admin_url('edit.php'); ?>?post_type=custom-css-js&page=custom-css-js-config" id="ccj_settings" method="post">

        <?php do_action( 'ccj_settings_form' ); ?>
        
        </form>
        </div>
        <?php
    }


    /**
     * Template for config page header 
     */
    function config_page_header( $tab = 'editor' ) {
  
        $url = '?post_type=custom-css-js&page=custom-css-js-config';

        $active = array('editor' => '', 'general' => '', 'debug' => '');
        $active[$tab] = 'nav-tab-active';

        ?>
        <style type="text/css">
            .custom-css-js_page_custom-css-js-config h1 { margin-bottom: 40px; }
            .form-table { margin-left: 2%; width: 98%;}
            .form-table th { width: 500px; } 
        </style>
        <h1><?php _e('Custom CSS & JS Settings'); ?></h1>

        <?php     
    }



    /**
     * Add the defaults for the `General Settings` form 
     */
    function general_extra_default( $defaults = array() ) {
        return array_merge( $defaults, array( 
            'ccj_htmlentities'      => false, 
            'ccj_htmlentities2'     => false,
			'ccj_autocomplete'		=> true,
            'add_role'              => false,
            'remove_comments'       => false,
        ) );
    }


    /**
     * Add the `General Settings` form values to the $_POST for the Settings page
     */
    function general_extra_save( $data = array() ) {
        $values = $this->general_extra_default();

        foreach($values as $_key => $_value ) {
            $values[$_key] = isset($_POST[$_key]) ? true : false;
        }

        return array_merge( $data, $values );
    }


    /**
     * Extra fields for the `General Settings` Form 
     */
    function general_extra_form() {

        // Get the setting
        $settings = get_option('ccj_settings');
        $defaults = $this->general_extra_default();

        foreach( $defaults as $_key => $_value ) {
            if ( !isset($settings[$_key] ) ) {
                $settings[$_key] = $_value;
            }
        }

        if ( !get_role('css_js_designer') && $settings['add_role'] ) {
            $settings['add_role'] = false;
            update_option( 'ccj_settings', $settings );
        }

        if ( get_role('css_js_designer') && !$settings['add_role']) {
            $settings['add_role'] = true;
            update_option( 'ccj_settings', $settings );
        }

        $ccj_htmlentities_help = __('If you want to use an HTML entity in your code (for example '. htmlentities('&gt; or &quot;').'), but the editor keeps on changing them to its equivalent character (&gt; and &quot; for the previous example), then you might want to enable this option.', 'custom-css-js');

        $ccj_htmlentities2_help = __('If you use HTML tags in your code (for example '.htmlentities('<input> or <textarea>').') and you notice that they disappear and the editor looks weird, then you need to enable this option.', 'custom-css-js');

        $remove_comments_help = __('In your page\'s HTML there is a comment added before and after the internal CSS or JS in order to help you locate your custom code. Enable this option in order to remove that comment.', 'custom-css-js');

        ?>

        <h2><?php echo __('Editor Settings', 'custom-css-js'); ?></h2>
        <table class="form-table">
        <tr>
        <th scope="row"><label for="ccj_htmlentities"><?php _e('Keep the HTML entities, don\'t convert to its character', 'custom-css-js') ?> <span class="dashicons dashicons-editor-help tipsy-no-html" rel="tipsy" title="<?php echo $ccj_htmlentities_help; ?>"></span>
        </label></th>
        <td><input type="checkbox" name="ccj_htmlentities" id="ccj_htmlentities" value="1" <?php checked($settings['ccj_htmlentities'], true); ?> />
        </td>
        </tr>
        <tr>
        <th scope="row"><label for="ccj_htmlentities2"><?php _e('Encode the HTML entities', 'custom-css-js') ?> <span class="dashicons dashicons-editor-help tipsy-no-html" rel="tipsy" title="<?php echo $ccj_htmlentities2_help; ?>"></span></label></th>
        <td><input type="checkbox" name="ccj_htmlentities2" id="ccj_htmlentities2" value="1" <?php checked($settings['ccj_htmlentities2'], true); ?> />
        </td>
        </tr>
        <tr>
        <th scope="row"><label for="ccj_autocomplete"><?php _e('Autocomplete in the editor', 'custom-css-js') ?></label></th>
        <td><input type="checkbox" name="ccj_autocomplete" id="ccj_autocomplete" value="1" <?php checked($settings['ccj_autocomplete'], true); ?> />
        </td>
        </tr>



        </table>


        
        <?php if ( current_user_can('update_plugins') ) : ?> 
            <?php $add_role_help = esc_html__('By default only the Administrator will be able to publish/edit/delete Custom Codes. By enabling this option there is also a "Web Designer" role created which can be assigned to a non-admin user in order to publish/edit/delete Custom Codes.', 'custom-css-js'); ?>
            <h2><?php echo __('General Settings', 'custom-css-js'); ?></h2>
            <table class="form-table">
            <tr>
            <th scope="row"><label for="add_role"><?php _e('Add the "Web Designer" role', 'custom-css-js') ?> <span class="dashicons dashicons-editor-help" rel="tipsy" title="<?php echo $add_role_help; ?>"></span></label></th>
            <td><input type="checkbox" name="add_role" id = "add_role" value="1" <?php checked($settings['add_role'], true); ?> />
            </td>
            </tr>
            </table>
        <?php endif; ?>
        <table class="form-table">
        <tr>
        <th scope="row"><label for="remove_comments"><?php _e('Remove the comments from HTML', 'custom-css-js') ?> <span class="dashicons dashicons-editor-help" rel="tipsy" title="<?php echo $remove_comments_help; ?>"></span></label></th>
        <td><input type="checkbox" name="remove_comments" id = "remove_comments" value="1" <?php checked($settings['remove_comments'], true); ?> />
        </td>
        </tr>
        </table>

        <table class="form-table">
        <tr>
        <th>&nbsp;</th>
        <td>
        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save'); ?>" />
        <?php wp_nonce_field('ccj_settings', 'ccj_settings-nonce', false); ?>
        </td>
        </tr>
        </table>

        <?php
    }


}

return new CustomCSSandJS_AdminConfig();
