<?php
/**
 * General purpose helpers
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

add_filter('body_class', function ($classes) {
	// if (get_theme_mod('has_passepartout', 'no') === 'yes') {
	// 	$classes[] = 'ct-passepartout';
	// };

	$classes[] = 'ct-loading';

	if (function_exists('is_product_category')) {
		if (is_product_category() || is_product_tag()) {
			$classes[] = 'woocommerce-archive';
		}

		if (is_product() || is_woocommerce() || is_cart()) {
			if (get_theme_mod('has_ajax_add_to_cart', 'no') === 'yes') {
				$classes[] = 'ct-ajax-add-to-cart';
			}
		}
	}

	return $classes;
});

add_filter('llms_get_theme_default_sidebar', function ($id) {
	return 'sidebar-1';
});

add_action(
	'dynamic_sidebar_before',
	function () {
		ob_start();
	}
);

add_action(
	'dynamic_sidebar_after',
	function () {
		$text = str_replace(
			'textwidget',
			'textwidget entry-content',
			ob_get_clean()
		);

		echo $text;
	}
);

if (! function_exists('blocksy_body_attr')) {
	function blocksy_body_attr() {
		$attrs = [];

		if (get_theme_mod('has_passepartout', 'no') === 'yes') {
			$attrs['data-frame'] = 'default';
		};

		$attrs['data-forms'] = str_replace(
			'-forms',
			'',
			get_theme_mod('forms_type', 'classic-forms')
		);

		$attrs['data-prefix'] = blocksy_manager()->screen->get_prefix();
		$attrs['data-header'] = substr(str_replace(
			'ct-custom-',
			'',
			blocksy_manager()->header_builder->get_current_section_id()
		), 0, 6);

		$attrs['data-footer'] = substr(str_replace(
			'ct-custom-',
			'',
			blocksy_manager()->footer_builder->get_current_section_id()
		), 0, 6);

		$footer_render = new Blocksy_Footer_Builder_Render();
		$footer_atts = $footer_render->get_current_section()['settings'];

		$reveal_result = [];

		if (blocksy_default_akg(
			'has_reveal_effect/desktop',
			$footer_atts,
			false
		)) {
			$reveal_result[] = 'desktop';
		}

		if (blocksy_default_akg(
			'has_reveal_effect/tablet',
			$footer_atts,
			false
		)) {
			$reveal_result[] = 'tablet';
		}

		if (blocksy_default_akg(
			'has_reveal_effect/mobile',
			$footer_atts,
			false
		)) {
			$reveal_result[] = 'mobile';
		}

		if (count($reveal_result) > 0) {
			$attrs['data-footer'] .= ':reveal';
		}

		return blocksy_attr_to_html(array_merge([
			'data-link' => get_theme_mod('content_link_type', 'type-2'),
		], $attrs, blocksy_schema_org_definitions('single', ['array' => true])));
	}
}

if (! function_exists('blocksy_assert_args')) {
	function blocksy_assert_args($args, $fields = []) {
		foreach ($fields as $single_field) {
			if (
				! isset($args[$single_field])
				||
				!$args[$single_field]
			) {
				throw new Error($single_field . ' missing in args!');
			}
		}
	}
}

add_filter('widget_nav_menu_args', function ($nav_menu_args, $nav_menu, $args, $instance) {
	$nav_menu_args['menu_class'] = 'widget-menu';
	return $nav_menu_args;
}, 10, 4);

class Blocksy_Walker_Page extends Walker_Page {
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if (
			isset( $args['item_spacing'] )
			&&
			'preserve' === $args['item_spacing']
		) {
			$t = "\t";
			$n = "\n";
		} else {
			$t = '';
			$n = '';
		}

		$indent  = str_repeat( $t, $depth );
		$output .= "{$n}{$indent}<ul class='sub-menu'>{$n}";
	}

	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		parent::start_el(
			$output,
			$page,
			$depth,
			$args,
			$current_page
		);

		$output = str_replace(
			"</a><ul class='sub-menu'>",
			"~</a><ul class='sub-menu'>",
			$output
		);

		$output = preg_replace('/~~+/', '~', $output);
	}
}

if (! function_exists('blocksy_get_with_percentage')) {
	function blocksy_get_with_percentage( $id, $value ) {
		$val = get_theme_mod( $id, $value );

		if ( strpos( $value, '%' ) !== false && is_numeric($val)) {
			$val .= '%';
		}

		return str_replace( '%%', '%', $val );
	}
}

if (! function_exists('blocksy_main_menu_fallback')) {
	function blocksy_main_menu_fallback($args) {
		extract($args);

		$list_pages_args = [
			'sort_column' => 'menu_order, post_title',
			'menu_id' => 'primary-menu',
			'menu_class' => 'primary-menu menu',
			'container' => 'ul',
			'echo' => false,
			'link_before' => '',
			'link_after' => '',
			'before' => '<ul>',
			'after' => '</ul>',
			'item_spacing' => 'discard',
			'walker' => new Blocksy_Walker_Page(),
			'title_li' => ''
		];

		if (isset($args['blocksy_mega_menu'])) {
			$list_pages_args['blocksy_mega_menu'] = $args['blocksy_mega_menu'];
		}

		$menu = wp_list_pages($list_pages_args);

		$svg = '<span class="child-indicator"><svg width="8" height="8" viewBox="0 0 15 15"><path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/></svg></span>';

		$menu = str_replace(
			'~',
			$svg,
			$menu
		);

		if (empty(trim($menu))) {
			$args['echo'] = false;
			$menu = blocksy_link_to_menu_editor($args);
		} else {
			$attrs = '';

			if (! empty($args['menu_id'])) {
				$attrs .= ' id="' . esc_attr($args['menu_id']) . '"';
			}

			if (! empty($args['menu_class'])) {
				$attrs .= ' class="' . esc_attr($args['menu_class']) . '"';
			}

			$menu = "<ul{$attrs}>" . $menu . "</ul>";
		}

		if ($echo) {
			echo $menu;
		}

		return $menu;
	}
}

/**
 * Link to menus editor for every empty menu.
 *
 * @param array  $args Menu args.
 */
if (! function_exists('blocksy_link_to_menu_editor')) {
	function blocksy_link_to_menu_editor($args) {
		if (! current_user_can('manage_options')) {
			return;
		}

		// see wp-includes/nav-menu-template.php for available arguments
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract($args);

		$output = '<a class="ct-create-menu" href="' . admin_url('nav-menus.php') . '" target="_blank">' . $before . __('You don\'t have a menu yet, please create one here &rarr;', 'blocksy') . $after . '</a>';

		if (! empty($container)) {
			$output = "<$container>$output</$container>";
		}

		if ($echo) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post($output);
		}

		return $output;
	}
}

add_filter(
	'rest_post_query',
	function ($args, $request) {
		if (
			isset($request['post_type'])
			&&
			(strpos($request['post_type'], 'ct_forced') !== false)
		) {
			$post_type = explode(
				':',
				str_replace('ct_forced_', '', $request['post_type'])
			);

			if ($post_type[0] === 'any') {
				$post_type = get_post_types(['public' => true]);
			}

			$args = [
				'posts_per_page' => $args['posts_per_page'],
				'post_type' => $post_type,
				'paged' => 1,
				's' => $args['s'],
			];
		}

		if (
			isset($request['post_type'])
			&&
			(strpos($request['post_type'], 'ct_cpt') !== false)
		) {
			$next_args = [
				'posts_per_page' => $args['posts_per_page'],
				'post_type' => array_diff(
					get_post_types(['public' => true]),
					['post', 'page', 'attachment']
				),
				'paged' => 1
			];

			if (isset($args['s'])) {
				$next_args['s'] = $args['s'];
			}

			$args = $next_args;
		}

		return $args;
	},
	10,
	2
);

if (!is_admin()) {
	add_filter('pre_get_posts', function ($query) {
		if ($query->is_search && (
			is_search()
			||
			wp_doing_ajax()
		)) {
			if (!empty($_GET['ct_post_type'])) {
				$custom_post_types = blocksy_manager()->post_types->get_supported_post_types();

				$allowed_post_types = [];

				$post_types = explode(
					':',
					sanitize_text_field($_GET['ct_post_type'])
				);

				$known_cpts = ['post', 'page'];

				if (get_post_type_object('product')) {
					$known_cpts[] = 'product';
				}

				foreach ($post_types as $single_post_type) {
					if (
						in_array($single_post_type, $custom_post_types)
						||
						in_array($single_post_type, $known_cpts)
					) {
						$allowed_post_types[] = $single_post_type;
					}
				}

				$query->set('post_type', $allowed_post_types);
			}
		}

		return $query;
	});
}

/**
 * This is a print_r() alternative
 *
 * @param mixed $value Value to debug.
 */
function blocksy_print($value) {
	static $first_time = true;

	if ($first_time) {
		ob_start();
		echo '<style>
		div.ct_print_r {
			max-height: 500px;
			overflow-y: scroll;
			background: #23282d;
			margin: 10px 30px;
			padding: 0;
			border: 1px solid #F5F5F5;
			border-radius: 3px;
			position: relative;
			z-index: 11111;
		}

		div.ct_print_r pre {
			color: #78FF5B;
			background: #23282d;
			text-shadow: 1px 1px 0 #000;
			font-family: Consolas, monospace;
			font-size: 12px;
			margin: 0;
			padding: 5px;
			display: block;
			line-height: 16px;
			text-align: left;
		}

		div.ct_print_r_group {
			background: #f1f1f1;
			margin: 10px 30px;
			padding: 1px;
			border-radius: 5px;
			position: relative;
			z-index: 11110;
		}
		div.ct_print_r_group div.ct_print_r {
			margin: 9px;
			border-width: 0;
		}
		</style>';

		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The variable used here has the value escaped properly.
		 */
		echo str_replace( array( '  ', "\n" ), '', ob_get_clean() );

		$first_time = false;
	}

	/**
	 * Note to code reviewers: This line doesn't need to be escaped.
	 * The variable used here has the value escaped properly.
	 */
	if (func_num_args() === 1) {
		echo '<div class="ct_print_r"><pre>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo htmlspecialchars(Blocksy_FW_Dumper::dump($value));
		echo '</pre></div>';
	} else {
		echo '<div class="ct_print_r_group">';

		foreach (func_get_args() as $param) {
			blocksy_print($param);
		}

		echo '</div>';
	}
}

/**
 * TVar_dumper class.
 * original source: https://code.google.com/p/prado3/source/browse/trunk/framework/Util/TVar_dumper.php
 *
 * TVar_dumper is intended to replace the buggy PHP function var_dump and print_r.
 * It can correctly identify the recursively referenced objects in a complex
 * object structure. It also has a recursive depth control to avoid indefinite
 * recursive display of some peculiar variables.
 *
 * TVar_dumper can be used as follows,
 * <code>
 *   echo TVar_dumper::dump($var);
 * </code>
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id$
 * @package System.Util
 * @since 3.0
 */
class Blocksy_FW_Dumper {
	/**
	 * Object
	 *
	 * @var object objects boj
	 */
	private static $_objects;
	/**
	 * Output
	 *
	 * @var string Output output of the dumper.
	 */
	private static $_output;
	/**
	 * Depth
	 *
	 * @var int Depth depth
	 */
	private static $_depth;

	/**
	 * Converts a variable into a string representation.
	 * This method achieves the similar functionality as var_dump and print_r
	 * but is more robust when handling complex objects such as PRADO controls.
	 *
	 * @param mixed   $var     Variable to be dumped.
	 * @param integer $depth Maximum depth that the dumper should go into the variable. Defaults to 10.
	 * @return string the string representation of the variable
	 */
	public static function dump( $var, $depth = 10 ) {
		self::reset_internals();

		self::$_depth = $depth;
		self::dump_internal( $var, 0 );

		$output = self::$_output;

		self::reset_internals();

		return $output;
	}

	/**
	 * Reset internals.
	 */
	private static function reset_internals() {
		self::$_output = '';
		self::$_objects = array();
		self::$_depth = 10;
	}

	/**
	 * Dump
	 *
	 * @param object $var var.
	 * @param int    $level level.
	 */
	private static function dump_internal( $var, $level ) {
		switch ( gettype( $var ) ) {
			case 'boolean':
				self::$_output .= $var ? 'true' : 'false';
				break;
			case 'integer':
				self::$_output .= "$var";
				break;
			case 'double':
				self::$_output .= "$var";
				break;
			case 'string':
				self::$_output .= "'$var'";
				break;
			case 'resource':
				self::$_output .= '{resource}';
				break;
			case 'NULL':
				self::$_output .= 'null';
				break;
			case 'unknown type':
				self::$_output .= '{unknown}';
				break;
			case 'array':
				if ( self::$_depth <= $level ) {
					self::$_output .= 'array(...)';
				} elseif ( empty( $var ) ) {
					self::$_output .= 'array()';
				} else {
					$keys = array_keys( $var );
					$spaces = str_repeat( ' ', $level * 4 );
					self::$_output .= "array\n" . $spaces . '(';
					foreach ( $keys as $key ) {
						self::$_output .= "\n" . $spaces . "    [$key] => ";
						self::$_output .= self::dump_internal( $var[ $key ], $level + 1 );
					}
					self::$_output .= "\n" . $spaces . ')';
				}
				break;
			case 'object':
				$id = array_search( $var, self::$_objects, true );

				if ( false !== $id ) {
					self::$_output .= get_class( $var ) . '(...)';
				} elseif ( self::$_depth <= $level ) {
					self::$_output .= get_class( $var ) . '(...)';
				} else {
					$id = array_push( self::$_objects, $var );
					$class_name = get_class( $var );
					$members = (array) $var;
					$keys = array_keys( $members );
					$spaces = str_repeat( ' ', $level * 4 );
					self::$_output .= "$class_name\n" . $spaces . '(';
					foreach ( $keys as $key ) {
						$key_display = strtr(
							trim( $key ),
							array( "\0" => ':' )
						);
						self::$_output .= "\n" . $spaces . "    [$key_display] => ";
						self::$_output .= self::dump_internal(
							$members[ $key ],
							$level + 1
						);
					}
					self::$_output .= "\n" . $spaces . ')';
				}
				break;
		}
	}
}

/**
 * Extract variable from a file.
 *
 * @param string $file_path path to file.
 * @param array  $_extract_variables variables to return.
 * @param array  $_set_variables variables to pass into the file.
 */
if (! function_exists('blocksy_get_variables_from_file')) {
	function blocksy_get_variables_from_file(
		$file_path,
		array $_extract_variables,
		array $_set_variables = array()
	) {
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract($_set_variables, EXTR_REFS);
		unset($_set_variables);
		require $file_path;

		foreach ($_extract_variables as $variable_name => $default_value) {
			if (isset($$variable_name) ) {
				$_extract_variables[$variable_name] = $$variable_name;
			}
		}

		return $_extract_variables;
	}
}

/**
 * Transform ID to title.
 *
 * @param string $id initial ID.
 */
if (! function_exists('blocksy_id_to_title')) {
	function blocksy_id_to_title($id) {
		if (
			function_exists('mb_strtoupper')
			&&
			function_exists('mb_substr')
			&&
			function_exists('mb_strlen')
		) {
			$id = mb_strtoupper(mb_substr($id, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(
				$id,
				1,
				mb_strlen($id, 'UTF-8'),
				'UTF-8'
			);
		} else {
			$id = strtoupper(substr($id, 0, 1)) . substr($id, 1, strlen($id));
		}

		return str_replace(['_', '-'], ' ', $id);
	}
}

/**
 * Extract a key from an array with defaults.
 *
 * @param string       $keys 'a/b/c' path.
 * @param array|object $array_or_object array to extract from.
 * @param null|mixed   $default_value defualt value.
 */
if (! function_exists('blocksy_default_akg')) {
	function blocksy_default_akg($keys, $array_or_object, $default_value) {
		return blocksy_akg($keys, $array_or_object, $default_value);
	}
}

/**
 * Recursively find a key's value in array
 *
 * @param string       $keys 'a/b/c' path.
 * @param array|object $array_or_object array to extract from.
 * @param null|mixed   $default_value defualt value.
 *
 * @return null|mixed
 */
if (! function_exists('blocksy_akg')) {
	function blocksy_akg($keys, $array_or_object, $default_value = null) {
		if (! is_array($keys)) {
			$keys = explode('/', (string) $keys);
		}

		$array_or_object = $array_or_object;
		$key_or_property = array_shift($keys);

		if (is_null($key_or_property)) {
			return $default_value;
		}

		$is_object = is_object($array_or_object);

		if ($is_object) {
			if (! property_exists($array_or_object, $key_or_property)) {
				return $default_value;
			}
		} else {
			if (! is_array($array_or_object) || ! array_key_exists($key_or_property, $array_or_object)) {
				return $default_value;
			}
		}

		if (isset($keys[0])) { // not used count() for performance reasons.
			if ($is_object) {
				return blocksy_akg($keys, $array_or_object->{$key_or_property}, $default_value);
			} else {
				return blocksy_akg($keys, $array_or_object[$key_or_property], $default_value);
			}
		} else {
			if ($is_object) {
				return $array_or_object->{$key_or_property};
			} else {
				return $array_or_object[ $key_or_property ];
			}
		}
	}
}

if (! function_exists('blocksy_akg_or_customizer')) {
	function blocksy_akg_or_customizer($key, $source, $default = null) {
		$source = wp_parse_args(
			$source,
			[
				'prefix' => '',

				// customizer | array
				'strategy' => 'customizer',
			]
		);

		if ($source['strategy'] !== 'customizer' && !is_array($source['strategy'])) {
			throw new Error(
				'strategy wrong value provided. Array or customizer is required.'
			);
		}

		if (! empty($source['prefix'])) {
			$source['prefix'] .= '_';
		}

		if ($source['strategy'] === 'customizer') {
			return get_theme_mod($source['prefix'] . $key, $default);
		}

		return blocksy_akg($source['prefix'] . $key, $source['strategy'], $default);
	}
}

if (! function_exists('blocksy_collect_and_return')) {
	function blocksy_collect_and_return($cb) {
		ob_start();

		if ($cb) {
			call_user_func($cb);
		}

		return ob_get_clean();
	}
}

/**
 * Generate a random ID.
 */
if (! function_exists('blocksy_rand_md5')) {
	function blocksy_rand_md5() {
		return md5(time() . '-' . uniqid(wp_rand(), true) . '-' . wp_rand());
	}
}

/**
 * Generate attributes string for html tag
 *
 * @param array $attr_array array('href' => '/', 'title' => 'Test').
 *
 * @return string 'href="/" title="Test"'
 */
if (! function_exists('blocksy_attr_to_html')) {
	function blocksy_attr_to_html(array $attr_array) {
		$html_attr = '';

		foreach ($attr_array as $attr_name => $attr_val) {
			if (false === $attr_val) {
				continue;
			}

			$html_attr .= $attr_name . '="' . htmlspecialchars($attr_val) . '" ';
		}

		return $html_attr;
	}
}

/**
 * Generate html tag
 *
 * @param string      $tag Tag name.
 * @param array       $attr Tag attributes.
 * @param bool|string $end Append closing tag. Also accepts body content.
 *
 * @return string The tag's html
 */
if (! function_exists('blocksy_html_tag')) {
	function blocksy_html_tag($tag, $attr = [], $end = false) {
		$html = '<' . $tag . ' ' . blocksy_attr_to_html($attr);

		if (true === $end) {
			// <script></script>
			$html .= '></' . $tag . '>';
		} elseif (false === $end) {
			// <br/>
			$html .= '/>';
		} else {
			// <div>content</div>
			$html .= '>' . $end . '</' . $tag . '>';
		}

		return $html;
	}
}

/**
 * Safe render a view and return html
 * In view will be accessible only passed variables
 * Use this function to not include files directly and to not give access to current context variables (like $this)
 *
 * @param string $file_path File path.
 * @param array  $view_variables Variables to pass into the view.
 *
 * @return string HTML.
 */
if (! function_exists('blocksy_render_view')) {
	function blocksy_render_view(
		$file_path,
		$view_variables = [],
		$default_value = ''
	) {
		if (! is_file($file_path)) {
			return $default_value;
		}

		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract($view_variables, EXTR_REFS);
		unset($view_variables);

		ob_start();
		require $file_path;

		return ob_get_clean();
	}
}

if (! function_exists('blocksy_get_wp_theme')) {
	function blocksy_get_wp_theme() {
		return apply_filters('blocksy_get_wp_theme', wp_get_theme());
	}
}

if (! function_exists('blocksy_get_wp_parent_theme')) {
	function blocksy_get_wp_parent_theme() {
		return apply_filters('blocksy_get_wp_theme', wp_get_theme(get_template()));
	}
}

if (! function_exists('blocksy_get_social_networks_list')) {
	function blocksy_get_social_networks_list() {
		return [
			'facebook' => [
				'label' => __( 'Facebook', 'blocksy' ),
			],

			'twitter' => [
				'label' => __( 'Twitter', 'blocksy' ),
			],

			'instagram' => [
				'label' => __( 'Instagram', 'blocksy' ),
			],

			'pinterest' => [
				'label' => __( 'Pinterest', 'blocksy' ),
			],

			'dribbble' => [
				'label' => __( 'Dribbble', 'blocksy' ),
			],

			'behance' => [
				'label' => __( 'Behance', 'blocksy' ),
			],

			'linkedin' => [
				'label' => __( 'LinkedIn', 'blocksy' ),
			],

			'wordpress' => [
				'label' => __( 'WordPress', 'blocksy' ),
			],

			'parler' => [
				'label' => __( 'Parler', 'blocksy' ),
			],

			'medium' => [
				'label' => __( 'Medium', 'blocksy' ),
			],

			'slack' => [
				'label' => __( 'Slack', 'blocksy' ),
			],

			'codepen' => [
				'label' => __( 'CodePen', 'blocksy' ),
			],

			'reddit' => [
				'label' => __( 'Reddit', 'blocksy' ),
			],

			'twitch' => [
				'label' => __( 'Twitch', 'blocksy' ),
			],

			'tiktok' => [
				'label' => __( 'TikTok', 'blocksy' ),
			],

			'snapchat' => [
				'label' => __( 'Snapchat', 'blocksy' ),
			],

			'spotify' => [
				'label' => __( 'Spotify', 'blocksy' ),
			],

			'soundcloud' => [
				'label' => __( 'SoundCloud', 'blocksy' ),
			],

			'apple_podcast' => [
				'label' => __( 'Apple Podcasts', 'blocksy' ),
			],

			'patreon' => [
				'label' => __( 'Patreon', 'blocksy' ),
			],

			'skype' => [
				'label' => __( 'Skype', 'blocksy' ),
			],

			'github' => [
				'label' => __( 'GitHub', 'blocksy' ),
			],

			'gitlab' => [
				'label' => __( 'GitLab', 'blocksy' ),
			],

			'youtube' => [
				'label' => __( 'YouTube', 'blocksy' ),
			],

			'vimeo' => [
				'label' => __( 'Vimeo', 'blocksy' ),
			],

			'dtube' => [
				'label' => __( 'DTube', 'blocksy' ),
			],

			'facebook_group' => [
				'label' => __( 'Facebook Group', 'blocksy' ),
			],

			'discord' => [
				'label' => __( 'Discord', 'blocksy' ),
			],

			'tripadvisor' => [
				'label' => __( 'TripAdvisor', 'blocksy' ),
			],

			'foursquare' => [
				'label' => __( 'Foursquare', 'blocksy' ),
			],

			'yelp' => [
				'label' => __( 'Yelp', 'blocksy' ),
			],

			'vk' => [
				'label' => __( 'VK', 'blocksy' ),
			],

			'ok' => [
				'label' => __( 'Odnoklassniki', 'blocksy' ),
			],

			'rss' => [
				'label' => __( 'RSS', 'blocksy' ),
			],

			'xing' => [
				'label' => __( 'Xing', 'blocksy' ),
			],

			'whatsapp' => [
				'label' => __( 'WhatsApp', 'blocksy' ),
			],

			'viber' => [
				'label' => __( 'Viber', 'blocksy' ),
			],

			'telegram' => [
				'label' => __( 'Telegram', 'blocksy' ),
			],

			'weibo' => [
				'label' => __( 'Weibo', 'blocksy' ),
			],

			'tumblr' => [
				'label' => __('Tumblr', 'blocksy'),
			],

			'qq' => [
				'label' => __( 'QQ', 'blocksy' ),
			],

			'wechat' => [
				'label' => __( 'WeChat', 'blocksy' ),
			],

			'strava' => [
				'label' => __( 'Strava', 'blocksy' ),
			],

			'flickr' => [
				'label' => __( 'Flickr', 'blocksy' ),
			],

			'phone' => [
				'label' => __( 'Phone', 'blocksy' ),
			],

			'email' => [
				'label' => __( 'Email', 'blocksy' ),
			],
		];
	}
}

function blocksy_current_url() {
	static $url = null;

	if ($url === null) {
		if (is_multisite() && !(defined('SUBDOMAIN_INSTALL') && SUBDOMAIN_INSTALL)) {
			switch_to_blog(1);
			$url = home_url();
			restore_current_blog();
		} else {
			$url = home_url();
		}

		//Remove the "//" before the domain name
		$url = ltrim(preg_replace('/^[^:]+:\/\//', '//', $url), '/');

		//Remove the ulr subdirectory in case it has one
		$split = explode('/', $url);

		//Remove end slash
		$url = rtrim($split[0], '/');

		$url .= '/' . ltrim(blocksy_akg('REQUEST_URI', $_SERVER, ''), '/');
		$url = set_url_scheme('//' . $url); // https fix
	}

	return $url;
}

/**
 * Treat non-posts home page as a simple page.
 */
if (! function_exists('blocksy_is_page')) {
	function blocksy_is_page($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'shop_is_page' => true,
				'blog_is_page' => true
			]
		);

		static $static_result = null;

		if ($static_result !== null) {
		}

		$result = (
			(
				$args['blog_is_page']
				&&
				is_home()
				&&
				!is_front_page()
			) || is_page() || (
				$args['shop_is_page'] && function_exists('is_shop') && is_shop()
			) || is_attachment()
		);

		if ($result) {
			$post_id = get_the_ID();

			if (is_home() && !is_front_page()) {
				$post_id = get_option('page_for_posts');
			}

			if (function_exists('is_shop') && is_shop()) {
				$post_id = get_option('woocommerce_shop_page_id');
			}

			$static_result = $post_id;

			return $post_id;
		}

		$static_result = false;
		return false;
	}
}

function blocksy_sync_whole_page($args = []) {
	return array_merge(
		[
			'selector' => 'main#main',
			'container_inclusive' => true,
			'render' => function () {
				echo blocksy_replace_current_template();
			}
		],
		$args
	);
}

function blocksy_get_v_spacing() {
	$v_spacing_output = 'data-v-spacing="top:bottom"';

	if (is_singular()) {
		$prefix = blocksy_manager()->screen->get_prefix();
		$post_options = blocksy_get_post_options();

		$page_vertical_spacing_source = blocksy_default_akg(
			'vertical_spacing_source',
			$post_options,
			'inherit'
		);

		$post_content_area_spacing = get_theme_mod(
			$prefix . '_content_area_spacing',
			'both'
		);

		if ($page_vertical_spacing_source === 'custom') {
			$post_content_area_spacing = blocksy_default_akg(
				'content_area_spacing',
				$post_options,
				'both'
			);
		}

		$v_spacing_components = [];

		if (
			$post_content_area_spacing === 'top'
			||
			$post_content_area_spacing === 'both'
		) {
			$v_spacing_components[] = 'top';
		}

		if (
			$post_content_area_spacing === 'bottom'
			||
			$post_content_area_spacing === 'both'
		) {
			$v_spacing_components[] = 'bottom';
		}

		$v_spacing_output = empty($v_spacing_components) ? '' : 'data-v-spacing="' . implode(
			':',
			$v_spacing_components
		) . '"';
	}

	return $v_spacing_output;
}

function blocksy_values_are_similar($actual, $expected) {
	if (!is_array($expected) || !is_array($actual)) return $actual === $expected;

	foreach ($expected as $key => $value) {
		if (!blocksy_values_are_similar($actual[$key], $expected[$key])) return false;
	}

	foreach ($actual as $key => $value) {
		if (!blocksy_values_are_similar($actual[$key], $expected[$key])) return false;
	}

	return true;
}


if (! function_exists('blocksy_get_all_image_sizes')) {
	function blocksy_get_all_image_sizes() {
		$titles = [
			'thumbnail' => __('Thumbnail', 'blocksy'),
			'medium' => __('Medium', 'blocksy'),
			'medium_large' => __('Medium Large', 'blocksy'),
			'large' => __('Large', 'blocksy'),
			'full' => __('Full Size', 'blocksy'),
		];

		$all_sizes = get_intermediate_image_sizes();

		$result = [
			'full' => __('Full Size', 'blocksy')
		];

		foreach ($all_sizes as $single_size) {
			if (isset($titles[$single_size])) {
				$result[$single_size] = $titles[$single_size];
			} else {
				$result[$single_size] = $single_size;
			}
		}

		return $result;
	}
}

function blocksy_main_attr() {
	$attrs = [
		'id' => 'main',
		'class' => 'site-main'
	];

	if (blocksy_has_schema_org_markup()) {
		$attrs['class'] .= ' hfeed';
	}

	if (
		(
			is_singular() || blocksy_is_page()
		)
		&&
		blocksy_sidebar_position() === 'none'
	) {
		if (blocksy_get_content_style() !== 'boxed') {
			if (function_exists('is_woocommerce')) {
				if (! is_product() && ! is_cart() && ! is_checkout()) {
					$attrs['class'] .= ' content-wide';
				}
			} else {
				$attrs['class'] .= ' content-wide';
			}
		}
	}

	return blocksy_attr_to_html(array_merge(
		apply_filters('blocksy:main:attr', $attrs),
		blocksy_schema_org_definitions('creative_work', [
			'array' => true
		]))
	);
}

