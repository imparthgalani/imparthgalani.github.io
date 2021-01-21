<?php
namespace ElementsKit_Lite;

defined( 'ABSPATH' ) || exit;

/**
 * Global helper class.
 *
 * @since 1.0.0
 */

class Utils {

    /**
     * Auto generate classname from path.
     *
     * @since 1.0.0
     * @access public
     */
    public static function make_classname( $dirname ) {
        $dirname = pathinfo($dirname, PATHINFO_FILENAME);
        $class_name	 = explode( '-', $dirname );
        $class_name	 = array_map( 'ucfirst', $class_name );
        $class_name	 = implode( '_', $class_name );

        return $class_name;
	}

	public static function google_fonts($font_families = []) {
		$fonts_url         = '';
		if ( $font_families ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) )
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

  	public static function kses( $raw ) {

		$allowed_tags = array(
			'a'								 => array(
				'class'	 => array(),
				'href'	 => array(),
				'rel'	 => array(),
				'title'	 => array(),
				'target' => array(),
			),
			'abbr'							 => array(
				'title' => array(),
			),
			'b'								 => array(),
			'blockquote'					 => array(
				'cite' => array(),
			),
			'cite'							 => array(
				'title' => array(),
			),
			'code'							 => array(),
			'del'							 => array(
				'datetime'	 => array(),
				'title'		 => array(),
			),
			'dd'							 => array(),
			'div'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'dl'							 => array(),
			'dt'							 => array(),
			'em'							 => array(),
			'h1'							 => array(
				'class' => array(),
			),
			'h2'							 => array(
				'class' => array(),
			),
			'h3'							 => array(
				'class' => array(),
			),
			'h4'							 => array(
				'class' => array(),
			),
			'h5'							 => array(
				'class' => array(),
			),
			'h6'							 => array(
				'class' => array(),
			),
			'i'								 => array(
				'class' => array(),
			),
			'img'							 => array(
				'alt'	 => array(),
				'class'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'width'	 => array(),
			),
			'li'							 => array(
				'class' => array(),
			),
			'ol'							 => array(
				'class' => array(),
			),
			'p'								 => array(
				'class' => array(),
			),
			'q'								 => array(
				'cite'	 => array(),
				'title'	 => array(),
			),
			'span'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'iframe'						 => array(
				'width'			 => array(),
				'height'		 => array(),
				'scrolling'		 => array(),
				'frameborder'	 => array(),
				'allow'			 => array(),
				'src'			 => array(),
			),
			'strike'						 => array(),
			'br'							 => array(),
			'strong'						 => array(),
			'data-wow-duration'				 => array(),
			'data-wow-delay'				 => array(),
			'data-wallpaper-options'		 => array(),
			'data-stellar-background-ratio'	 => array(),
			'ul'							 => array(
				'class' => array(),
			),
		);

		if ( function_exists( 'wp_kses' ) ) { // WP is here
			return wp_kses( $raw, $allowed_tags );
		} else {
			return $raw;
		}
	}

	public static function kspan($text){
		return str_replace(['{', '}'], ['<span>', '</span>'], self::kses($text));
	}

	public static function ekit_get__forms($post_type) {
		$wpuf_form_list = get_posts(array(
            'post_type' => $post_type,
            'showposts' => 999,
        ));

        $options = array();

        if (!empty($wpuf_form_list) && !is_wp_error($wpuf_form_list)) {
            $options[0] = esc_html__('Select Form', 'elemetskit');
            foreach ($wpuf_form_list as $post) {
                $options[$post->ID] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__('Create a form first', 'elemetskit');
        }

        return $options;
	}
	
	public static function ekit_get_ninja_form() {
        $options = array();

        if (class_exists('Ninja_Forms')) {
            $contact_forms = Ninja_Forms()->form()->get_forms();

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {

                $options[0] = esc_html__('Select Ninja Form', 'elementskit-lite');

                foreach ($contact_forms as $form) {
                    $options[$form->get_id()] = $form->get_setting('title');
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'elementskit-lite');
        }

        return $options;
	}

	public static function tablepress_table_list() {
		$table_options = array();

		if (class_exists('TablePress')) {
			$table_ids          = \TablePress::$model_table->load_all( false );
			$table_options[0] = esc_html__( 'Select Table', 'elemenetskit' );

			foreach ( $table_ids as $table_id ) {
				// Load table, without table data, options, and visibility settings.
				$table = \TablePress::$model_table->load( $table_id, false, false );
	
				if ( '' === trim( $table['name'] ) ) {
					$table['name'] = __( '(no name)', 'tablepress' );
				}
				
				$table_options[$table['id']] = $table['name'];
			}
		} else {
            $table_options[0] = esc_html__('Create a Table First', 'elementskit-lite');
        }

		return $table_options;
	}
    
    public static function ekit_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;
		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}
		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}

	public static function trim_words($text, $num_words){
		return wp_trim_words( $text, $num_words, '' );
	}

	public static function array_push_assoc($array, $key, $value){
		$array[$key] = $value;
		return $array;
	}

	public static function render_elementor_content_css($content_id){
		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
			$css_file->enqueue();
		}
	}

	public static function render_elementor_content($content_id){
		$elementor_instance = \Elementor\Plugin::instance();
		return $elementor_instance->frontend->get_builder_content_for_display( $content_id , true);
	}
	
	public static function render($content){
		if (stripos($content, "elementskit-has-lisence") !== false) {
			return null;
		}

		return $content;
	}
	
	public static function render_tab_content($content, $id){
		return str_replace('.elementor-'.$id.' ', '#elementor .elementor-'.$id.' ', $content);
	}

	public static function img_meta($id){
		$attachment = get_post($id);
		if($attachment == null || $attachment->post_type != 'attachment'){
			return null;
		}
		return [
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink( $attachment->ID ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
		];
	}
}
