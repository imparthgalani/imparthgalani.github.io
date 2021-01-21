<?php
$widgets_all = \ElementsKit_Lite\Config\Widget_List::instance()->get_list();
$widgets_active = $this->utils->get_option('widget_list', $widgets_all);
$widgets_active = (!isset($widgets_active[0]) ? array_keys($widgets_active) : $widgets_active);

?>

<div class="ekit-admin-fields-container">
    <span class="ekit-admin-fields-container-description"><?php esc_html_e('You can disable the elements you are not using on your site. That will disable all associated assets of those widgets to improve your site loading speed.', 'elementskit-lite'); ?></span>

    <div class="ekit-admin-fields-container-fieldset">
        <div class="attr-row">
            <?php foreach($widgets_all as $widget => $widget_config): ?>
            <div class="attr-col-md-6 attr-col-lg-4"  <?php echo ($widget_config['package'] != 'pro-disabled' ? '' : 'data-attr-toggle="modal" data-target="#elementskit_go_pro_modal"'); ?>>
                <?php
                    $this->utils->input([
                        'type' => 'switch',
                        'name' => 'widget_list[]',
                        'label' => $widget_config['title'],
                        'value' => $widget,
                        'attr' => ($widget_config['package'] != 'pro-disabled' ? [] : ['disabled' => 'disabled' ]),
                        'class' => 'ekit-content-type-' . $widget_config['package'],
                        'options' => [
                            'checked' => ((in_array($widget, $widgets_active) && $widget_config['package'] != 'pro-disabled') ? true : false),
                        ]
                    ]);
                ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

