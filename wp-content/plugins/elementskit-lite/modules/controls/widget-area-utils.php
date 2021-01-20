<?php 
namespace ElementsKit_Lite\Modules\Controls;

defined( 'ABSPATH' ) || exit;

class Widget_Area_Utils{

	function init(){
		add_action('elementor/editor/after_enqueue_styles', array( $this, 'modal_content' ) );
	}

	public function modal_content() { 
		ob_start(); ?>
		<div class="widgetarea_iframe_modal">
			<?php include 'widget-area-modal.php'; ?>
		</div>
		<?php
			$output = ob_get_contents();
			ob_end_clean();
	
			echo \ElementsKit_Lite\Utils::render($output);
	}

	public static function parse($content, $widget_key, $index = 1){
		$key = ($content == '') ? $widget_key : $content;
		$extract_key = explode('***', $key);
		$extract_key = $extract_key[0];
		ob_start(); ?>

		<div class="widgetarea_warper widgetarea_warper_editable" data-elementskit-widgetarea-key="<?php echo esc_attr($extract_key); ?>"  data-elementskit-widgetarea-index="<?php echo esc_attr($index); ?>">
			<div class="widgetarea_warper_edit" data-elementskit-widgetarea-key="<?php echo esc_attr($extract_key); ?>" data-elementskit-widgetarea-index="<?php echo esc_attr($index); ?>">
				<i class="eicon-edit" aria-hidden="true"></i>
				<span class="elementor-screen-only"><?php esc_html_e('Edit', 'elementskit-lite'); ?></span>
			</div>

			<div class="elementor-widget-container">
				<?php
 				$builder_post_title = 'dynamic-content-widget-' . $extract_key . '-' . $index;
				$builder_post = get_page_by_title($builder_post_title, OBJECT, 'elementskit_content');
				$elementor = \Elementor\Plugin::instance();

				if(isset($builder_post->ID)){
					echo str_replace('#elementor', '', \ElementsKit_Lite\Utils::render_tab_content($elementor->frontend->get_builder_content_for_display( $builder_post->ID ), $builder_post->ID)); 
				}else{
					echo esc_html__('Click here to add content.', 'elementskit-lite');
				}
 				?>
			</div>
		</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}