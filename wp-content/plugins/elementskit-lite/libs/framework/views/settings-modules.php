<?php
$modules_all = \ElementsKit_Lite\Config\Module_List::instance()->get_list();
$modules_active = $this->utils->get_option('module_list', $modules_all);

$modules_active = (!isset($modules_active[0]) ? array_keys($modules_active) : $modules_active);
?>

<div class="ekit-admin-fields-container">
    <span class="ekit-admin-fields-container-description"><?php esc_html_e('You can disable the modules you are not using on your site. That will disable all associated assets of those modules to improve your site loading speed.', 'elementskit-lite'); ?></span>

    <div class="ekit-admin-fields-container-fieldset">
        <div class="attr-hidden" id="elementskit-template-admin-menu">
            <li><a href="edit.php?post_type=elementskit_template"><?php esc_html_e('Header Footer', 'elementskit-lite'); ?></a></li>
        </div>
        <div class="attr-hidden" id="elementskit-template-widget-menu">
            <li><a href="edit.php?post_type=elementskit_widget"><?php esc_html_e('Widget Builder', 'elementskit-lite'); ?></a></li>
        </div>
        <div class="attr-row">
            <?php foreach($modules_all as $module => $module_config): if(isset($module_config['package'])): ?>
            <div class="attr-col-md-6 attr-col-lg-4" <?php echo ($module_config['package'] != 'pro-disabled' ? '' : 'data-attr-toggle="modal" data-target="#elementskit_go_pro_modal"'); ?>>
            <?php
                $this->utils->input([
                    'type' => 'switch',
                    'name' => 'module_list[]',
                    'value' => $module,
                    'class' => 'ekit-content-type-' . $module_config['package'],
                    'attr' => ($module_config['package'] != 'pro-disabled' ? [] : ['disabled' => 'disabled' ]),
                    'label' => $module_config['title'],
                    'options' => [
                        'checked' => (in_array($module, $modules_active) && $module_config['package'] != 'pro-disabled' ? true : false),
                    ]
                ]);
            ?>
            </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
</div>