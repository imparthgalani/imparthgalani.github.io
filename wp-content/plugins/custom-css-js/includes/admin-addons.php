<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_Addons 
 */
class CustomCSSandJS_Addons {

    /**
     * Constructor
     */
    public function __construct() {

        // Add actions
        $actions = array(
            'add_meta_boxes' => 'add_meta_boxes',
            'edit_form_advanced' => 'only_premium',
        );
        foreach( $actions as $_key => $_value ) {
            add_action( $_key, array( $this, $_value ) );
        }

    }

    function only_premium() {
        $current_screen = get_current_screen();

        if ( $current_screen->post_type != 'custom-css-js' ) {
            return false;
        }

?>
    <div class="ccj_only_premium ccj_only_premium-first">
        <div> 
        <a href="https://www.silkypress.com/simple-custom-css-js-pro/?utm_source=wordpress&utm_campaign=ccj_free&utm_medium=banner" target="_blank"><?php _e('Available only in <br />Simple Custom CSS and JS Pro', 'custom-css-js'); ?></a>
        </div>
    </div>
    <?php
    }


    /**
     * Add the URL Preview meta box
     */
    function add_meta_boxes() {
        
        add_meta_box( 'previewdiv', __('Preview', 'custom-css-js'), array( $this, 'previews_meta_box_callback' ), 'custom-css-js', 'normal' );
        add_meta_box( 'url-rules', __('Apply only on these URLs', 'custom-css-js'), array( $this, 'url_rules_meta_box_callback' ), 'custom-css-js', 'normal' );
        add_meta_box( 'revisionsdiv', __('Code Revisions', 'custom-css-js'), array( $this, 'revisions_meta_box_callback' ), 'custom-css-js', 'normal' );
    }


    /**
     * The Preview meta box content
     */
    function previews_meta_box_callback( $post ) {
?>
<div id="preview-action">
    <div>
    <input type="text" name="preview_url" id="ccj-preview_url" placeholder="<?php _e('Full URL on which to preview the changes ...', 'custom-css-js'); ?>" disabled="disabled" />
    <a class="preview button button-primary button-large" id="ccj-preview"><?php _e('Preview Changes', 'custom-css-js'); ?></a>
    </div>
</div>
<?php
        
    }


    /**
     * Show the URL Rules metabox
     */
    function url_rules_meta_box_callback( $post ) {

        $filters = array(
            'all'           => __('All Website', 'custom-css-js'),
            'first-page'    => __('Homepage', 'custom-css-js'),
            'contains'      => __('Contains', 'custom-css-js'),
            'not-contains'  => __('Not contains', 'custom-css-js'),
            'equal-to'      => __('Is equal to', 'custom-css-js'),
            'not-equal-to'  => __('Not equal to', 'custom-css-js'),
            'begins-with'   => __('Starts with', 'custom-css-js'),
            'ends-by'       => __('Ends by', 'custom-css-js'),
        );
        $filters_html = '';
        foreach( $filters as $_key => $_value ) {
            $filters_html .= '<option value="'.$_key.'">' . $_value . '</option>';
        }

        $applied_filters = '[{"value":"","type":"all","index":1}]';

?>
        <input type="hidden" name="scan_anchor_filters" id="wplnst-scan-anchor-filters" value='<?php echo $applied_filters; ?>' />
    <table id="wplnst-elist-anchor-filters" class="wplnst-elist" cellspacing="0" cellpadding="0" border="0" data-editable="true" data-label="<?php _e('URL', 'custom-css-js'); ?>"></table>
        <?php _e('URL', 'custom-css-js'); ?> <select id="wplnst-af-new-type"><?php echo $filters_html ?></select>&nbsp;
        <input id="wplnst-af-new" type="text" class="regular-text" value="" placeholder="<?php _e('Text filter', 'custom-css-js'); ?>" />&nbsp;
        <input class="button button-primary" type="button" id="wplnst-af-new-add" value="<?php _e('Add', 'custom-css-js'); ?>" /></td>

<?php
    }



    /**
     * Output the revisions 
     */
    function revisions_meta_box_callback( $post ) {
        $datef = _x( 'F j, Y @ H:i:s', 'revision date format' );
        $users = get_users(array('number' => 3));
        $revisions = array(
            array(
                'ID' => 1,
                'post_author' => $users[0]->display_name,
                'title' => date_i18n( $datef, mktime( 8, 3, 0, 3, 20, 1996 ) ),
            ),
            array(
                'ID' => 2,
                'post_author' => isset($users[1]) ? $users[1]->display_name : $users[0]->display_name,
                'title' => date_i18n( $datef, mktime( 8, 20, 0, 6, 20, 1997 ) ),
            ),
            array(
                'ID' => 3,
                'post_author' => isset($users[2]) ? $users[2]->display_name : $users[0]->display_name,
                'title' => date_i18n( $datef, mktime( 5, 37, 0, 9, 22, 1998 ) ),
            ),
        );
?>
    <table class="revisions">
        <thead><tr>
        <th class="revisions-compare"><?php _e('Compare', 'custom-css-js'); ?></th>
        <th><?php _e('Revision', 'custom-css-js'); ?></th>
        <th><?php _e('Author', 'custom-css-js'); ?></th>
        <th><input type="checkbox" name="delete[]" value="all" id="ccj-delete-checkbox" /> <?php _e('Delete', 'custom-css-js'); ?></th>
        <th><?php _e('Restore', 'custom-css-js'); ?></th>
        </tr></thead>
        <tbody>
        <?php foreach( $revisions as $revision ) : ?>
        <?php

        $restore_url = '#';

        $delete_disabled = '';
        $delete_tooltip = '';
        $class = '';
        ?>
        <tr class="<?php echo $class; ?>" id="<?php echo 'revision-row-' . $revision['ID']; ?>">
            <td class="revisions-compare">
            <input type="radio" name="compare_left" value="<?php echo $revision['ID']; ?>" />
            <input type="radio" name="compare_right" value="<?php echo $revision['ID']; ?>" />
            </td>
            <td><?php echo $revision['title']; ?></td>
            <td><?php echo $revision['post_author']; ?></td>
            <td class="revisions-delete">
            <input type="checkbox" name="delete[]" value="<?php echo $revision['ID']; ?>" <?php echo $delete_disabled . $delete_tooltip; ?>/>
            </td>
            <td class="revisions-restore">
                <a href="<?php echo $restore_url; ?>"><?php _e('Restore', 'custom-css-js'); ?></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td>
                <input type="button" class="button-secondary" value="<?php esc_attr_e('Compare', 'custom-css-js'); ?>" id="revisions-compare-button" />
            </td>
			<td colspan="2" style="text-align: center;"> <p>&uarr; This is only an example, not real data. &uarr; </p>
			<p>Note: currently the revisions are not being saved. They start getting saved at the moment the plugin's pro version is installed.</td>
            <td>
                <input type="button" class="button-secondary" value="<?php esc_attr_e('Delete', 'custom-css-js'); ?>" id="revisions-delete-button" />
            </td>
            <td> &nbsp; </td>
        </tr> 
        </tbody>
    </table>
<?php 
    }
        


}

return new CustomCSSandJS_Addons();
