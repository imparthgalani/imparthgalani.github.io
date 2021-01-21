<div class="attr-input attr-input-switch <?php echo esc_attr($class); ?>">
<?php
    // note:
    // $options['large_img'] $options['icon'] $options['small_img'] self::strify($name) $label $value
    // $options['checked'] true / false
    $no_demo = [
        'sticky-content',
        'nav-menu',
        'header-info'
    ];
?>
    <div class="ekit-admin-input-switch ekit-admin-card-shadow attr-card-body">
        <input <?php echo esc_attr($options['checked'] === true ? 'checked' : ''); ?> 
            type="checkbox" value="<?php echo esc_attr($value); ?>" 
            class="ekit-admin-control-input" 
            name="<?php echo esc_attr($name); ?>" 
            id="ekit-admin-switch__<?php echo esc_attr(self::strify($name) . $value); ?>"

            <?php 
            if(isset($attr)){
                foreach($attr as $k => $v){
                    echo "$k='$v'";
                }
            }
            ?>
        >

        <label class="ekit-admin-control-label"  for="ekit-admin-switch__<?php echo esc_attr(self::strify($name) . $value); ?>">
        <?php echo esc_html($label); ?>
            <span class="ekit-admin-control-label-switch" data-active="ON" data-inactive="OFF"></span>
        </label>

       
    </div>
    <?php 
    $slug = 'elementskit/';
    if( !in_array($value, $no_demo) ) :
        if($value === 'parallax'){
            $value = 'effects';
        }
    ?>
        <a target="_blank" href="https://wpmet.com/plugin/<?php echo esc_attr($slug) . esc_attr($value); ?>/?utm_source=elementskit_lite&utm_medium=inplugin_campaign&utm_campaign=widgets_modules_demo_link" class="ekit-admin-demo-tooltip"><i class="fa fa-laptop"></i><?php esc_html_e('View Demo', 'elementskit-lite'); ?></a>
    <?php endif; ?>
</div>