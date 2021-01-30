<?php

namespace WTS_EAE;

use Elementor;
use WTS_EAE\Classes\Helper;
use const EAE_PATH;

class Plugin
{

	public static $instance;

	public $module_manager;

	public static $helper = null;
	private static $show_notice = true;

	public static function get_instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct()
	{
		//die('---');
		$this->register_autoloader();
		self::$helper = new Helper();

		add_action('elementor/init', [$this, 'eae_elementor_init'], -10);
		add_action('elementor/elements/categories_registered', [$this, 'register_category']);
		add_action('wp_enqueue_scripts', [$this, 'eae_scripts']);
		add_action('elementor/editor/wp_head', [$this, 'eae_editor_enqueue_scripts']);
		add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
		add_action('plugins_loaded', [$this, '_plugins_loaded']);
		//add_action('elementor/widgets/widgets_registered','widgets_registered');
		add_action('admin_enqueue_scripts', [$this, 'eae_admin_scripts']);

		$this->_includes();

		$this->module_manager = new Managers\Module_Manager();

		$this->eae_review();
		$this->fv_download_box();
	}

	function eae_elementor_init()
	{
	}

	public function _plugins_loaded()
	{


		if (!did_action('elementor/loaded')) {
			/* TO DO */
			add_action('admin_notices', array($this, 'wts_eae_pro_fail_load'));

			return;
		}
		$elementor_version_required = '3.0';


		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
			add_action('admin_notices', array($this, 'elementor_requried_version_fail'));
			return;
		}

		// WPML Compatibility
		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php') && is_plugin_active('wpml-string-translation/plugin.php')) {
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-animated-text.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-gmap.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-filterable-gallery.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-price-table.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-timeline.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-info-circle.php';
			require_once EAE_PATH . 'wpml/modules/class-wpml-eae-comparison-table.php';
			require_once EAE_PATH . 'wpml/wpml-compatibility.php';
		}
	}

	public function register_category($elements)
	{

		\Elementor\Plugin::instance()->elements_manager->add_category(
			'wts-eae',
			[
				'title' => 'Elementor Addon Elements',
				'icon'  => 'font'
			],
			1
		);

		//require_once EAE_PATH.'modules/animated-gradient.php';
		//require_once EAE_PATH.'modules/particles.php';
		//require_once EAE_PATH.'modules/bg-slider.php';
	}

	public function _includes()
	{
		if (is_admin()) {
			require_once EAE_PATH . 'inc/admin/settings-page.php';
			require_once EAE_PATH . 'inc/admin/controls.php';
			require_once EAE_PATH . 'inc/admin/Settings.php';
		}
	}
	public function register_controls(Elementor\Controls_Manager $controls_manager)
	{

		require_once EAE_PATH . 'controls/group/icon.php';
		require_once EAE_PATH . 'controls/group/icon_timeline.php';
		require_once EAE_PATH . 'controls/group/grid-control.php';

		//$controls_manager->register_control( self::BPEL_HOVER_TRANSITION, new \BPEL\Controls\Hover_Transition() );

		$controls_manager->add_group_control('eae-icon', new \WTS_EAE\Controls\Group\Group_Control_Icon());

		$controls_manager->add_group_control('eae-icon-timeline', new \WTS_EAE\Controls\Group\Group_Control_Icon_Timeline());

		$controls_manager->add_group_control('eae-grid', new \WTS_EAE\Controls\Group\Group_Control_Grid());
	}
	function eae_admin_scripts()
	{
		$screen = get_current_screen();

		wp_enqueue_style('eae-admin-css', EAE_URL . 'assets/css/eae-admin.css');

		if ($screen->id == 'toplevel_page_eae-settings') {
			add_action('admin_print_scripts', [$this, 'eae_disable_admin_notices']);

			wp_enqueue_script('eae-admin', EAE_URL . 'assets/js/admin.js', ['wp-components'], '1.0', true);

			$modules = self::$helper->get_eae_modules();

			wp_localize_script('eae-admin', 'eaeGlobalVar', array(
				'site_url'     => site_url(),
				'eae_dir'      => EAE_URL,
				'ajax_url'     => admin_url('admin-ajax.php'),
				'map_key'      => get_option('wts_eae_gmap_key'),
				'eae_elements' => $modules,
				'eae_version' => EAE_VERSION,
				'nonce'        => wp_create_nonce('eae_ajax_nonce')
			));
		}
	}

	function eae_disable_admin_notices()
	{
		global $wp_filter;
		if (is_user_admin()) {
			if (isset($wp_filter['user_admin_notices'])) {
				unset($wp_filter['user_admin_notices']);
			}
		} elseif (isset($wp_filter['admin_notices'])) {
			unset($wp_filter['admin_notices']);
		}
		if (isset($wp_filter['all_admin_notices'])) {
			unset($wp_filter['all_admin_notices']);
		}
	}

	function eae_scripts()
	{
		wp_enqueue_style('eae-css', EAE_URL . 'assets/css/eae' . EAE_SCRIPT_SUFFIX . '.css');

		/* chart js file */
		wp_register_script('eae-chart', EAE_URL . 'assets/js/Chart.bundle' . EAE_SCRIPT_SUFFIX . '.js');


		/* animated text css and js file*/


		wp_register_script('animated-main', EAE_URL . 'assets/js/animated-main' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '1.0', true);

		wp_enqueue_script('eae-main', EAE_URL . 'assets/js/eae' . EAE_SCRIPT_SUFFIX . '.js', array(
			'jquery',
		), '1.0', true);
		if (is_plugin_active('elementor/elementor.php')) {
			wp_localize_script('eae-main', 'eae', array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'current_url' => base64_encode(self::$helper->get_current_url_non_paged()),
				'breakpoints' => Elementor\Core\Responsive\Responsive::get_breakpoints()
			));
		}
		wp_register_script('eae-particles', EAE_URL . 'assets/js/particles' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '1.0', true);

		wp_register_style('vegas-css', EAE_URL . 'assets/lib/vegas/vegas' . EAE_SCRIPT_SUFFIX . '.css');
		wp_register_script('vegas', EAE_URL . 'assets/lib/vegas/vegas' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '2.4.0', true);
		//wp_register_script('wts-swiper-script', EAE_URL . 'assets/lib/swiper/js/swiper' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '4.4.6', true);
		//wp_register_script('wts-swiper-style', EAE_URL . 'assets/lib/swiper/css/swiper' . EAE_SCRIPT_SUFFIX . '.css');

		wp_register_script('wts-magnific', EAE_URL . 'assets/lib/magnific' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '1.9', true);
		wp_register_script('wts-isotope', EAE_URL . 'assets/lib/isotope/isotope.pkgd' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '2.6.2', true);
		wp_register_script('wts-tilt', EAE_URL . 'assets/lib/tilt/tilt.jquery' . EAE_SCRIPT_SUFFIX . '.js', array('jquery'), '', true);
		if (is_plugin_active('elementor/elementor.php')) {
			wp_register_style(
				'font-awesome-5-all',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css'
			);
			wp_register_style(
				'font-awesome-4-shim',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/v4-shims.min.css'
			);
			wp_register_script(
				'font-awesome-4-shim',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/js/v4-shims.min.js'
			);
		}
		$map_key = get_option('wts_eae_gmap_key');
		if (isset($map_key) && $map_key != '') {
			wp_register_script('eae-gmap', 'https://maps.googleapis.com/maps/api/js?key=' . $map_key);
		}

		wp_register_script('pinit', '//assets.pinterest.com/js/pinit.js', '', '', false);


		wp_register_script('eae-stickyanything', EAE_URL . 'assets/js/stickyanything.js', array('jquery'), '1.1.2', true);

		$localize_data = array(
			'plugin_url' => EAE_URL
		);
		wp_localize_script('eae-main', 'eae_editor', $localize_data);
	}

	function eae_editor_enqueue_scripts()
	{

		wp_enqueue_style('eae-icons', EAE_URL . 'assets/lib/eae-icons/style.css');
	}

	private function register_autoloader()
	{
		spl_autoload_register([__CLASS__, 'autoload']);
	}

	function autoload($class)
	{

		/*require_once EAE_PATH.'inc/helper.php';*/
		if (0 !== strpos($class, __NAMESPACE__)) {
			return;
		}


		if (!class_exists($class)) {

			$filename = strtolower(
				preg_replace(
					['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'],
					['', '$1-$2', '-', DIRECTORY_SEPARATOR],
					$class
				)
			);

			$filename = EAE_PATH . $filename . '.php';

			if (is_readable($filename)) {
				include($filename);
			}
		}
	}
	function elementor_requried_version_fail()
	{
		if (!current_user_can('update_plugins')) {
			return;
		}
		$elementor_version_required = '3.0.0';
		$file_path = 'elementor/elementor.php';

		$upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
		$message = '<p>' . __('Elementor Addon Elements requires Elementor ' . $elementor_version_required . '. Please update Elementor to continue.', 'wts-eae') . '</p>';
		$message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, __('Update Elementor Now', 'elementor-pro')) . '</p>';

		echo '<div class="error">' . $message . '</div>';
	}

	public function wts_eae_pro_fail_load()
	{

		$plugin = 'elementor/elementor.php';

		if (_is_elementor_installed()) {
			if (!current_user_can('activate_plugins')) {
				return;
			}

			$message = sprintf(__('<b>Elementor Addon Elements</b> is not working because you need to activate the <b>Elementor</b> plugin.', 'wts-eae'), '<strong>', '</strong>');
			$action_url   = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
			$button_label = __('Activate Elementor', 'wts-eae');
		} else {
			if (!current_user_can('install_plugins')) {
				return;
			}
			$message = sprintf(__('<b>Elementor Addon Elements</b> is not working because you need to install the <b>Elementor</b> plugin.', 'wts-eae'), '<strong>', '</strong>');
			$action_url   = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
			$button_label = __('Install Elementor', 'wts-eae');
		}

		$button = '<p><a href="' . $action_url . '" class="button-primary">' . $button_label . '</a></p><p></p>';

		printf('<div class="%1$s"><p>%2$s</p>%3$s</div>', 'notice notice-error', $message, $button);
	}
	function dateDiff($start, $end)
	{
		$start_time = strtotime($start);
		$end_time = strtotime($end);
		$datediff = $end_time - $start_time;
		return round($datediff / 86400);
	}
	function eae_review()
	{

		if (isset($_GET['remind_later'])) {
			add_action('admin_notices', [$this, 'eae_remind_later']);
		} else if (isset($_GET['review_done'])) {
			add_action('admin_notices', [$this, 'eae_review_done']);
		} else {
			add_action('admin_notices', [$this, 'eae_review']);
		}

		$check_review = get_option('eae_review');

		if (!$check_review) {
			$review = [
				'installed' => current_time('yy/m/d'),
				'status' => '',
			];


			update_option('eae_review', $review);
		}

		$check_review = get_option('eae_review');

		$start = $check_review['installed'];
		$end = current_time('yy/m/d');

		$days = $this->dateDiff($start, $end);

		$usage = [];
		$usage = get_option('elementor_controls_usage');

		if ($usage) {
			if (array_key_exists('wp-page', $usage)) {
				$usage = $usage['wp-page'];
			} else {
				$usage = [];
			}
		} else {
			$usage = [];
		}

		$eae_widget = ['eae-info-circle', 'eae-dual-button', 'wts-flipbox', 'wts-splittext', 'wts-modal-popup', 'eae-timeline', 'wts-AnimatedText', 'wts-ab-image', 'wts-gmap', 'eae-progress-bar', 'wts-textseparator', 'wts-postlist', 'eae-content-switcher', 'eae-filterableGallery', 'wts-shape-separator', 'wts-twitter', 'wts-pricetable'];
		$widget_count = 0;
		foreach ($eae_widget as $key => $value) {
			if (array_key_exists($value, $usage)) {
				$widget_count = $widget_count + $usage[$value]['count'];
			}
		}

		if ($days < 11 || $widget_count < 5) {
			return;
		}
		if ($check_review['status'] === '' || $check_review['status'] === 'remind_later') {
			add_action('admin_notices', [$this, 'eae_review_box'], 10);
		}
	}

	function eae_review_box($review)
	{

		$review = get_option('eae_review');

		$remind_later = get_transient('eae_remind_later');
		$status = $review['status'];

		if ($status !== 'done') {
			if ($status == '' && $remind_later == '' && self::$show_notice) {
				self::$show_notice = false;
?>
				<div class="notice notice-success is-dismissible">
					<p><?php _e('I hope you are enjoying using <b>Elementor Addon Elements</b>. Could you please do a BIG favor and give it a 5-star rating on WordPress.org ? <br/> Just to help us spread the word and boost our motivation. <br/><b>~ Anand Upadhyay</b>', 'wts-eae'); ?></p>
					<p>
						<a class="eae-notice-link" style="padding-right: 5px;" target="_blank" href="https://wordpress.org/support/plugin/addon-elements-for-elementor-page-builder/reviews/#new-post" class="button button-primary"><span class="dashicons dashicons-heart" style="text-decoration : none; margin : 0px 3px 0px 0px;"></span><?php _e('Ok, you deserve it!', 'wts-eae'); ?></a>
						<a class="eae-notice-link" style="padding-right: 5px;" href="<?php echo add_query_arg('remind_later', 'later'); ?>"><span class="dashicons dashicons-schedule" style="text-decoration : none; margin : 0px 3px;"></span><?php _e('May Be Later', 'wts-eae'); ?></a>
						<a class="eae-notice-link" style="padding-right: 5px;" href="<?php echo add_query_arg('review_done', 'done'); ?>"><span class="dashicons dashicons-smiley" style="text-decoration : none; margin : 0px 3px;"></span><?php _e('Already Done', 'wts-eae'); ?></a>
					</p>
				</div>
		<?php
			}
		}
	}


	function eae_remind_later()
	{
		set_transient('eae_remind_later', 'show again', WEEK_IN_SECONDS);
	}

	function eae_review_done()
	{
		$review = get_option('eae_review');
		$review['status'] = 'done';
		$review['reviwed'] = current_time('yy/m/d');
		update_option('eae_review', $review, false);
	}

	function fv_download_box()
	{
		if (isset($_GET['fv_download_later'])) {
			add_action('admin_notices', [$this, 'fv_download_later']);
		} else if (isset($_GET['fv_not_interested'])) {
			add_action('admin_notices', [$this, 'fv_not_interested']);
		} else {
			$this->check_form_used();
		}
	}
	function check_form_used()
	{
		$query = array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'meta_query'  => array(
				array(
					'key'     => '_elementor_data',
					'value'   => '"widgetType":"form"',
					'compare' => 'LIKE',
				),
			),
		);
		//print_r($query);
		$data = new \WP_Query($query);

		if (count($data->posts) > 0) {
			if (!is_plugin_active('form-vibes/form-vibes.php')) {
				add_action('admin_notices', [$this, 'fv_add_box'], 10);
			}
		}
	}

	function fv_add_box()
	{
		$download_later = get_transient('fv_download_later');

		$fv_downloaded = get_option('fv_downloaded');

		//echo 'notice '. self::$show_notice;
		if ($fv_downloaded === 'done' || $download_later) {
			return;
		}
		if (!self::$show_notice) {
			return;
		}
		self::$show_notice = false;
		?>
		<div class="fv-add-box notice notice-success is-dismissible">
			<div class="fv-logo">
				<svg viewBox="0 0 1340 1340" version="1.1">
					<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<g id="Artboard" transform="translate(-534.000000, -2416.000000)" fill-rule="nonzero">
							<g id="g2950" transform="translate(533.017848, 2415.845322)">
								<circle id="circle2932" fill="#FF6634" cx="670.8755" cy="670.048026" r="669.893348"></circle>
								<path d="M1151.33208,306.590013 L677.378555,1255.1191 C652.922932,1206.07005 596.398044,1092.25648 590.075594,1079.88578 L589.97149,1079.68286 L975.423414,306.590013 L1151.33208,306.590013 Z M589.883553,1079.51122 L589.97149,1079.68286 L589.940317,1079.74735 C589.355382,1078.52494 589.363884,1078.50163 589.883553,1079.51122 Z M847.757385,306.589865 L780.639908,441.206555 L447.47449,441.984865 L493.60549,534.507865 L755.139896,534.508386 L690.467151,664.221407 L558.27749,664.220865 L613.86395,775.707927 L526.108098,951.716924 L204.45949,306.589865 L847.757385,306.589865 Z" id="Combined-Shape" fill="#FFFFFF"></path>
							</g>
						</g>
					</g>
				</svg>
			</div>
			<div class="fv-add-content">
				<?php
				/*
			<div>
					<p><?php _e('Look like You are using elementor forms on your site.! <br/> Save elementor form submission to database!', 'wpv-fv'); ?></p>
				</div>
				<div>
					<?php echo '<a class="fv-download" href="'.admin_url().'plugin-install.php?s=form+vibes&tab=search&type=term">Download Now</a>' ?>
				</div> */
				?>
				<div>
					<p><?php _e('I hope you are enjoying using <b>Elementor Addon Elements</b>. Here is another useful plugin by us - <b>Form Vibes</b>. <br/>If you are using Elementor Pro Form, then you can capture form submissions within WordPress Admin.', 'wpv-fv'); ?></p>

					<p>
						<?php echo '<a class="eae-notice-link" style="padding: 5px;"  href="' . admin_url() . 'plugin-install.php?s=form+vibes&tab=search&type=term">Download Now</a>' ?>
						<a class="eae-notice-link" style="padding: 5px;" href="<?php echo add_query_arg('fv_download_later', 'later'); ?>"><span class="dashicons dashicons-schedule" style="text-decoration : none; margin : 0px 3px;"></span><?php _e('May Be Later', 'wts-eae'); ?></a>
						<a class="eae-notice-link" style="padding: 5px;" href="<?php echo add_query_arg('fv_not_interested', 'done'); ?>"><span class="dashicons dashicons-smiley" style="text-decoration : none; margin : 0px 3px;"></span><?php _e('Not Interested', 'wts-eae'); ?></a>
					</p>
				</div>
			</div>
		</div>
<?php
	}

	function fv_download_later()
	{
		set_transient('fv_download_later', 'show again', WEEK_IN_SECONDS);
	}

	function fv_not_interested()
	{
		//set_transient( 'fv_review_done', 'Already Reviewed !', 3 * MONTH_IN_SECONDS );

		update_option('fv_downloaded', 'done', false);
	}
}

Plugin::get_instance();
