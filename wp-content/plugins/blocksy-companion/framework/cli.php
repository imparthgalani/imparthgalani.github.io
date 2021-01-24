<?php

namespace Blocksy;

class Cli {
	public function __construct() {
		\WP_CLI::add_command('blocksy demo plugins', function ($args) {
			$plugins = [
				'coblocks',
				'elementor',
				'contact-form-7',
				'woocommerce'
			];

			foreach ($plugins as $plugin) {
				\WP_CLI::runcommand('plugin install ' . $plugin, [] );
				\WP_CLI::runcommand('plugin activate ' . $plugin, [] );
			}
		});

		\WP_CLI::add_command('blocksy demo options', function ($args) {
			$options = new DemoInstallOptionsInstaller([
				'has_streaming' => false,
				'demo_name' => 'Main:elementor'
			]);

			$options->import();
		});

		\WP_CLI::add_command('blocksy widgets drop', function ($args) {
			$sidebars_widgets = get_option('sidebars_widgets', array());

			if (! isset($sidebars_widgets['wp_inactive_widgets'])) {
				$sidebars_widgets['wp_inactive_widgets'] = [];
			}

			foreach ($sidebars_widgets as $sidebar_id => $widgets) {
				if (! $widgets) continue;
				if ($sidebar_id === 'wp_inactive_widgets') {
					continue;
				}

				if ($sidebar_id === 'array_version') {
					continue;
				}

				foreach ($widgets as $widget_id) {
					$sidebars_widgets['wp_inactive_widgets'][] = $widget_id;
				}

				$sidebars_widgets[$sidebar_id] = [];
			}

			update_option('sidebars_widgets', $sidebars_widgets);
			unset($sidebars_widgets['array_version']);

			set_theme_mod('sidebars_widgets', [
				'time' => time(),
				'data' => $sidebars_widgets
			]);
		});

		\WP_CLI::add_command('blocksy demo widgets', function ($args) {
			$options = new DemoInstallWidgetsInstaller([
				'has_streaming' => false,
				'demo_name' => 'Blocksy News:elementor'
			]);

			$options->import();
		});

		\WP_CLI::add_command('blocksy demo content', function ($args) {
			$options = new DemoInstallContentInstaller([
				'has_streaming' => false,
				'demo_name' => 'Main:elementor'
			]);

			$options->import();
		});
	}
}

