<?php
namespace WTS_EAE\Modules\ContentSwitcher\Skins;

use Elementor\Icons_Manager;
use Elementor\Plugin as EPlugin;use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) exit;
abstract class Skin_Base extends Elementor_Skin_Base{
    protected function _register_controls_actions()
    {

    }

    public function register_controls( Widget_Base  $widget){

        $this->parent = $widget;

    }


    public function render_header_button_skin($settings ){
        //echo '<pre>'; print_r($settings['content_list']); echo '</pre>';
        $active_sec = $this->get_active_section($settings['content_list']);
        if(empty($active_sec)){
            $active_sec['section_id'] = $settings['content_list'][0]['_id'];
            $active_sec['index_no'] = 0;
        }
        ?>
        <div class="eae-cs-switch-container">
            <div class="eae-cs-switch-wrapper">
                <?php
                foreach ($settings['content_list'] as $index =>  $item){
                    $id = $index + 1;
                    if($item['_id'] === $active_sec['section_id']){
                        $active_class = "active";
                    }else{
                        $active_class = '';
                    }
                    $this->parent->set_render_attribute('switch-label' , 'id' , $item['_id']);
                    $this->parent->set_render_attribute('switch-label' , 'class',['eae-cs-icon-align-'. $item['icon_align'],'eae-content-switch-label']);
                    ?>
                    <div <?php echo $this->parent->get_render_attribute_string( 'switch-wrapper' ); ?>>
                        <a href="#" class="eae-content-switch-button <?php echo $active_class;?>">
                            <div <?php echo $this->parent->get_render_attribute_string( 'switch-label' ); ?>>
                                <?php if(!empty($item['icon']) && $item['icon_align'] === 'left'){
                                    Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                                }?>
                                <span><?php echo $item['title']; ?></span>
                                <?php if(!empty($item['icon']) && $item['icon_align'] === 'right'){
                                    Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                                }?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function get_active_section($items){
        $active_sec_data = [];
        foreach ($items as $index =>  $item){
            if($item['active'] == 'yes'){
                $active_sec_data['section_id'] = $item['_id'];
                $active_sec_data['index_no'] = $index;
            }
        }
        return $active_sec_data;
    }

    public function render_content($settings){
        $active_sec = $this->get_active_section($settings['content_list']);
        if(empty($active_sec)){
            $active_sec['section_id'] = $settings['content_list'][0]['_id'];
            $active_sec['index_no'] = 0;
        }
        $count = count($settings['content_list']);
        if($settings['_skin'] == 'skin3' || $settings['_skin'] == 'skin4'){
            if($active_sec['index_no'] >= 1){
                $active_sec['section_id'] =  $settings['content_list']['1']['_id'];
            }else{
                $active_sec['section_id'] =  $settings['content_list']['0']['_id'];
            }
        }

    ?>
        <div class="eae-cs-content-container">
                    <div class="eae-cs-content-wrapper">
                        <?php
                            foreach ($settings['content_list'] as $index =>  $item) {

                                $id = $index + 1;

                                if($item['_id'] === $active_sec['section_id']){
                                    $active_class = "active";
                                }else{
                                    $active_class = '';
                                }

                                $this->parent->set_render_attribute('switch-content', 'id', $item['_id']);
                                $this->parent->set_render_attribute('switch-content', 'class', ['eae-content-section-'.$item['_id'] , 'eae-cs-content-section' , $active_class]);
                                if($index < $count){
                                ?>

                                <div <?php echo $this->parent->get_render_attribute_string( 'switch-content' ); ?>>
                                    <?php
                                        $contetn_type = $item['content_type'];
                                        switch ($contetn_type){
                                            case 'plain_content' :
                                                echo do_shortcode($item['plain_content']);
                                                break;
                                            case 'saved_section' :
                                                if(empty($item['saved_section'])){
                                                    return;
                                                }
                                                echo EPlugin::instance()->frontend->get_builder_content_for_display( $item['saved_section'] );
                                                break;
                                            case 'saved_page' :
                                                if(empty($item['saved_pages'])){
                                                    return;
                                                }
                                                echo EPlugin::instance()->frontend->get_builder_content_for_display( $item['saved_pages'] );
                                                break;
                                            case 'ae_template' :
                                                if(empty($item['ae_templates'])){
                                                    return;
                                                }
                                                echo EPlugin::instance()->frontend->get_builder_content_for_display( $item['ae_templates'] );
                                                break;
                                        }
                                    ?>
                                    <?php //echo EPlugin::instance()->frontend->get_builder_content_for_display( $settings['saved_sections'] ); ?>
                                </div>
                                <?php }
                            }
                        ?>

                    </div>
                </div>
        <?php
    }
}