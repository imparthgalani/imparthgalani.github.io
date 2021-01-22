<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_Install 
 */
class CustomCSSandJS_Install {

    public static function install() {
        self::create_roles();
        self::register_post_type();
        flush_rewrite_rules();
    }  


    /**
     * Create the custom-css-js post type
     */
    public static function register_post_type() {
        $labels = array(
            'name'                   => _x( 'Custom Code', 'post type general name', 'custom-css-js'),
            'singular_name'          => _x( 'Custom Code', 'post type singular name', 'custom-css-js'),
            'menu_name'              => _x( 'Custom CSS & JS', 'admin menu', 'custom-css-js'),
            'name_admin_bar'         => _x( 'Custom Code', 'add new on admin bar', 'custom-css-js'),
            'add_new'                => _x( 'Add Custom Code', 'add new', 'custom-css-js'),
            'add_new_item'           => __( 'Add Custom Code', 'custom-css-js'),
            'new_item'               => __( 'New Custom Code', 'custom-css-js'),
            'edit_item'              => __( 'Edit Custom Code', 'custom-css-js'),
            'view_item'              => __( 'View Custom Code', 'custom-css-js'),
            'all_items'              => __( 'All Custom Code', 'custom-css-js'),
            'search_items'           => __( 'Search Custom Code', 'custom-css-js'),
            'parent_item_colon'      => __( 'Parent Custom Code:', 'custom-css-js'),
            'not_found'              => __( 'No Custom Code found.', 'custom-css-js'),
            'not_found_in_trash'     => __( 'No Custom Code found in Trash.', 'custom-css-js')
        );

        $capability_type = 'custom_css';
        $capabilities = array(
            'edit_post'              => "edit_{$capability_type}",
            'read_post'              => "read_{$capability_type}",
            'delete_post'            => "delete_{$capability_type}",
            'edit_posts'             => "edit_{$capability_type}s",
            'edit_others_posts'      => "edit_others_{$capability_type}s",
            'publish_posts'          => "publish_{$capability_type}s",
            'read'                   => "read",
            'delete_posts'           => "delete_{$capability_type}s",
            'delete_published_posts' => "delete_published_{$capability_type}s",
            'delete_others_posts'    => "delete_others_{$capability_type}s",
            'edit_published_posts'   => "edit_published_{$capability_type}s",
            'create_posts'           => "edit_{$capability_type}s",
        );

        $args = array(
            'labels'                 => $labels,
            'description'            => __( 'Custom CSS and JS code', 'custom-css-js' ),
            'public'                 => false,
            'publicly_queryable'     => false,
            'show_ui'                => true,
            'show_in_menu'           => true,
            'menu_position'          => 100,
            'menu_icon'              => 'dashicons-plus-alt',
            'query_var'              => false,
            'rewrite'                => array( 'slug' => 'custom-css-js' ),
            'capability_type'        => $capability_type,
            'capabilities'           => $capabilities, 
            'has_archive'            => true,
            'hierarchical'           => false,
            'exclude_from_search'    => true,
            'menu_position'          => null,
            'can_export'             => false,
            'supports'               => array( 'title' )
        );

        register_post_type( 'custom-css-js', $args );
    }

 
    /**
     * Create roles and capabilities.
     */
    public static function create_roles() {
        global $wp_roles;


        if ( !current_user_can('update_plugins') )
            return;

        if ( ! class_exists( 'WP_Roles' ) ) {
            return;
        }

        if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        if ( isset($wp_roles->roles['css_js_designer'])) 
            return;

        // Add Web Designer role
        add_role( 'css_js_designer', __( 'Web Designer', 'custom-css-js'), array() );

        $capabilities = array();

        $capability_types = array( 'custom_css' );

        foreach ( $capability_types as $capability_type ) {

            $capabilities[ $capability_type ] = array(
                // Post type
                "edit_{$capability_type}",
                "read_{$capability_type}",
                "delete_{$capability_type}",
                "edit_{$capability_type}s",
                "edit_others_{$capability_type}s",
                "publish_{$capability_type}s",
                "delete_{$capability_type}s",
                "delete_published_{$capability_type}s",
                "delete_others_{$capability_type}s",
                "edit_published_{$capability_type}s",
            );
        }

        foreach ( $capabilities as $cap_group ) {
            foreach ( $cap_group as $cap ) {
                $wp_roles->add_cap( 'css_js_designer', $cap );
                $wp_roles->add_cap( 'administrator', $cap );
            }
        }
    }




}

?>
