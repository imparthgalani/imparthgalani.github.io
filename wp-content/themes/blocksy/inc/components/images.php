<?php
/**
 * Images generators
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

if (! function_exists('blocksy_has_lazyload')) {
	function blocksy_has_lazyload() {
		if (
			wp_doing_ajax()
			&&
			isset($_REQUEST['action'])
			&&
			$_REQUEST['action'] = 'brizy_shortcode_content'
		) {
			return false;
		}

		if (class_exists('WP_Smush_Lazy_Load')) {
			if (WP_Smush_Settings::get_instance()->get('lazy_load')) {
				return false;
			}
		}

		if (class_exists('Jetpack') && Jetpack::is_module_active('lazy-images')) {
			return false;
		}

		return get_theme_mod('has_lazy_load', 'yes') === 'yes';
	}
}

/**
 * Output image container for an attachment.
 *
 * @param array $args various params that the function accepts.
 */
if (! function_exists('blocksy_image')) {
	function blocksy_image($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'attachment_id' => null,
				'other_images' => [],
				'ratio' => '1/1',
				'class' => '',
				'ratio_blocks' => true,
				'tag_name' => 'div',
				'html_atts' => [],
				'img_atts' => [],
				'inner_content' => '',
				'lazyload' => blocksy_has_lazyload(),
				'lazyload_type' => get_theme_mod('lazy_load_type', 'fade'),
				'size' => 'medium',

				// default | woo
				'no_image_type' => 'default'
			]
		);

		$classes = $args['class'];

		$attachment_exists = !!get_attached_file($args['attachment_id']);

		$other_html_atts = '';

		$args['html_atts']['class'] = 'ct-image-container' . (
			empty( $classes ) ? '' : ' ' . $classes
		);

		if (! $attachment_exists) {
			if ($args['no_image_type'] === 'woo') {
				$placeholder_image = get_option('woocommerce_placeholder_image', 0);

				if ($placeholder_image) {
					if (is_numeric($placeholder_image)) {
						$args['attachment_id'] = $placeholder_image;
						$attachment_exists = !!get_attached_file($args['attachment_id']);
					} else {
						return blocksy_simple_image($placeholder_image, $args);
					}
				}
			}
		}

		if (! $attachment_exists) {
			$no_image_class = 'ct-no-image';
			$args['html_atts']['class'] .= ' ' . $no_image_class;
		}

		if ($args['lazyload'] && $attachment_exists) {
			$args['html_atts']['class'] .= ' ct-lazy';

			if ($args['lazyload_type'] === 'none') {
				$args['html_atts']['class'] .= ' ct-lazy-static';
			}

			if ($args['lazyload_type'] === 'circle') {
				$args['inner_content'] .= '<span data-loader="circles"><span></span><span></span><span></span></span>';
			}
		}

		if ( $args['ratio_blocks'] ) {
			$args['inner_content'] .= blocksy_generate_ratio($args['ratio'], $args['attachment_id']);
		}

		if ( isset( $args['html_atts']['class'] ) ) {
			$other_html_atts .= 'class="' . $args['html_atts']['class'] . '" ';
			unset( $args['html_atts']['class'] );
		}

		if ($args['attachment_id']) {
			if (get_attached_file($args['attachment_id'])) {
				$info = wp_get_attachment_metadata($args['attachment_id']);

				if (
					$info
					&&
					isset($info['width'])
					&&
					intval($info['width']) !== 0
					&&
					is_customize_preview()
				) {
					$args['html_atts']['data-w'] = $info['width'];
					$args['html_atts']['data-h'] = $info['height'];
				}
			}
		}

		foreach ( $args['html_atts'] as $attr => $value ) {
			$other_html_atts .= $attr . '="' . $value . '" ';
		}

		$other_html_atts = trim( $other_html_atts );

		return '<' . $args['tag_name'] . ' ' . $other_html_atts . '>' .
			blocksy_get_image_element( $args ) .
			$args['inner_content'] .
			'</' . $args['tag_name'] . '>';
	}
}


/**
 * Output image element for all the cases.
 *
 * @param array $args various params that the function accepts.
 */
if (! function_exists('blocksy_get_image_element')) {
	function blocksy_get_image_element( $args ) {
		if (! get_attached_file($args['attachment_id'])) {
			return '';
		}

		$parser = new Blocksy_Attributes_Parser();

		$image = wp_get_attachment_image(
			$args['attachment_id'],
			$args['size']
		);

		$has_srcset = strpos( $image, 'srcset' ) !== false;

		$output = '';

		if ( $args['lazyload'] ) {
			$output = '<noscript>' . $image . '</noscript>';

			$image = $parser->rename_attribute_from_images(
				$image,
				'src',
				'data-ct-lazy'
			);

			if ( $has_srcset ) {
				$image = $parser->rename_attribute_from_images(
					$image,
					'srcset',
					'data-ct-lazy-set'
				);
			}
		}

		$image = $parser->add_attribute_to_images($image, 'data-object-fit', '~');

		if (blocksy_has_schema_org_markup()) {
			$image = $parser->add_attribute_to_images($image, 'itemprop', 'image');
		}

		foreach ($args['img_atts'] as $attr => $attr_value) {
			$image = $parser->add_attribute_to_images($image, $attr, $attr_value);
		}

		if (! empty($args['other_images'])) {
			foreach ($args['other_images'] as $other_image) {
				$other_image = wp_get_attachment_image(
					$other_image,
					$args['size']
				);

				$other_image = $parser->add_attribute_to_images($other_image, 'class', 'ct-swap');

				if ($args['lazyload']) {
					$other_image = $parser->rename_attribute_from_images(
						$other_image,
						'src',
						'data-ct-lazy'
					);

					if ( $has_srcset ) {
						$other_image = $parser->rename_attribute_from_images(
							$other_image,
							'srcset',
							'data-ct-lazy-set'
						);
					}
				}

				$output = $other_image . $output;
			}
		}

		$output = $image . $output;

		return $output;
	}
}

/**
 * Generate ratio div based on ratio.
 *
 * @param string $ratio 1/1 | 1/2 | 4/3 | 3/4 ...
 */
if (! function_exists('blocksy_generate_ratio')) {
	function blocksy_generate_ratio($ratio, $attachment_id = null) {
		$result = 0;

		if ('original' === $ratio) {
			if (! $attachment_id) {
				$result = 1;
			} else {
				$info = wp_get_attachment_metadata($attachment_id);

				if (
					$info
					&&
					isset($info['width'])
					&&
					intval($info['width']) !== 0
				) {
					$result = (int) $info['height'] / (int) $info['width'];
				} else {
					$result = 1;
				}
			}
		} else {
			$computed_ratio = explode(
				strpos($ratio, '/') !== false ? '/' : ':',
				$ratio
			);

			$result = (float) ($computed_ratio[1]) / (float) ($computed_ratio[0]);
		}

		$style = 'padding-bottom: ' . round($result * 100, 1) . '%';
		return '<span class="ct-ratio" style="' . $style . '"></span>';
	}
}

/**
 * Generate an image container based on image URL.
 *
 * @param string $image_src URL to the image.
 * @param array $args various params that the function accepts.
 */
if (! function_exists('blocksy_simple_image')) {
	function blocksy_simple_image( $image_src, $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'ratio' => '1/1',
				'class' => '',
				'ratio_blocks' => true,
				'tag_name' => 'div',
				'html_atts' => [],
				'img_atts' => [],
				'inner_content' => '',
				'lazyload' => blocksy_has_lazyload(),
				'lazyload_type' => get_theme_mod('lazy_load_type', 'fade'),
				'size' => 'medium',
				'has_image' => true,
				'suffix' => ''
			]
		);

		$original = 'ct-image-container';

		if (! empty($args['suffix'])) {
			$original .= '-' . $args['suffix'];
		}

		$image_attr = 'src';

		$other_img_atts = '';

		if (! isset($args['img_atts']['alt'])) {
			$args['img_atts']['alt'] = __('Default image', 'blocksy');
		}

		foreach ( $args['img_atts'] as $attr => $value ) {
			$other_img_atts .= $attr . '="' . $value . '" ';
		}

		if ( $args['lazyload'] ) {
			$original .= ' ct-lazy';

			if ($args['lazyload_type'] === 'none') {
				$original .= ' ct-lazy-static';
			}

			if ($args['has_image']) {
				$args['inner_content'] .= '<noscript>';
				$args['inner_content'] .= '<img ' . $image_attr . '="' . $image_src . '" data-object-fit="~" ' . $other_img_atts . '>';
				$args['inner_content'] .= '</noscript>';
			}

			$image_attr = 'data-ct-lazy';

			if ($args['lazyload_type'] === 'circle') {
				$args['inner_content'] .= '<span data-loader="circles"><span></span><span></span><span></span></span>';
			}
		}

		if (! isset($args['html_atts']['class'])) {
			$args['html_atts']['class'] = $original;
		} else {
			$args['html_atts']['class'] = $original . ' ' . $args['html_atts']['class'];
		}

		$other_html_atts = '';

		foreach ( $args['html_atts'] as $attr => $value ) {
			$other_html_atts .= $attr . '="' . $value . '" ';
		}

		$other_html_atts = trim( $other_html_atts );

		if ( $args['ratio_blocks'] ) {
			$args['inner_content'] .= blocksy_generate_ratio($args['ratio']);
		}

		$image_content = '';

		if ($args['has_image']) {
			$image_content = '<img ' . $image_attr . '="' . $image_src . '" data-object-fit="~" ' . $other_img_atts . '>';
		}

		return '<' . $args['tag_name'] . ' ' . $other_html_atts . '>' .
			$image_content .  $args['inner_content'] .
			'</' . $args['tag_name'] . '>';
	}
}
