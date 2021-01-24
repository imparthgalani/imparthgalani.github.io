<?php

namespace Blocksy;

class DemoInstallPluginsInstaller {
	protected $has_streaming = true;
	protected $plugins = null;

	public function __construct($args = []) {
		$args = wp_parse_args($args, [
			'has_streaming' => true,
			'plugins' => null
		]);

		if (
			!$args['plugins']
			&&
			isset($_REQUEST['plugins'])
			&&
			$_REQUEST['plugins']
		) {
			$args['plugins'] = $_REQUEST['plugins'];
		}

		$this->has_streaming = $args['has_streaming'];
		$this->plugins = $args['plugins'];
	}

	public function import() {
		if ($this->has_streaming) {
			Plugin::instance()->demo->start_streaming();

			if (! current_user_can('edit_theme_options')) {
				Plugin::instance()->demo->emit_sse_message([
					'action' => 'complete',
					'error' => false,
				]);
				exit;
			}

			if (! isset($_REQUEST['plugins']) || !$_REQUEST['plugins']) {
				Plugin::instance()->demo->emit_sse_message([
					'action' => 'complete',
					'error' => false,
				]);
				exit;
			}
		}

		$plugins = explode(':', $this->plugins);

		$plugins_manager = Plugin::instance()->demo->get_plugins_manager();

		foreach ($plugins as $single_plugin) {
			if ($this->has_streaming) {
				Plugin::instance()->demo->emit_sse_message([
					'action' => 'install_plugin',
					'name' => $single_plugin
				]);
			}

			$plugins_manager->prepare_install($single_plugin);
			echo $single_plugin;

			if ($this->has_streaming) {
				Plugin::instance()->demo->emit_sse_message([
					'action' => 'activate_plugin',
					'name' => $single_plugin
				]);
			}

			$plugins_manager->plugin_activation($single_plugin);
		}

		if ($this->has_streaming) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => false,
			]);

			exit;
		}
	}
}

