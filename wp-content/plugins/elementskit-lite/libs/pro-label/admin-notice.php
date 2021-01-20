<?php 
namespace ElementsKit_Lite\Libs\Pro_Label;
defined( 'ABSPATH' ) || exit;

trait Admin_Notice{

    public function footer_alert_box(){
        include 'views/modal.php';
    }

    public function show_go_pro_notice(){

    $btn = [
        'default_class' => 'button',
        'class' => 'button-primary ', // button-primary button-secondary button-small button-large button-link
    ];
    $btn['text'] = esc_html__('Go Premium', 'elementskit-lite');
    $btn['url'] = 'https://go.wpmet.com/ekitpro';

    \Oxaim\Libs\Notice::instance('elementskit-lite', 'go-pro-noti2ce')
    ->set_dismiss('global', (3600 * 24 * 300))
    ->set_type('warning')
    ->set_message('
        <div class="ekit-go-pro-notice">
            <p><strong>Thank you for using ElementsKit Lite.</strong> To get more amaizing features and the outstanding pro readymade layouts, please get the <a style="color: #FCB214;" target="_blank" href="https://go.wpmet.com/ekitpro">Premium Version</a>.</p>
        </div>
    ')
    ->call();

    }
}