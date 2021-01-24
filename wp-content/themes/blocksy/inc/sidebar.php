<?php
/**
 * Sidebar helpers
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

if (! function_exists('blocksy_get_sidebar_to_render')) {
	function blocksy_get_sidebar_to_render() {
		if (class_exists('BlocksySidebarsManager')) {
			$manager = new BlocksySidebarsManager();

			$maybe_sidebar = $manager->maybe_get_sidebar_that_matches();

			if ($maybe_sidebar) {
				return $maybe_sidebar;
			}
		}

		$prefix = blocksy_manager()->screen->get_prefix();

		if ($prefix === 'product' || $prefix === 'woo_categories') {
			return 'sidebar-woocommerce';
		}

		return 'sidebar-1';
	}
}

if (! function_exists('blocksy_sidebar_position_attr')) {
	function blocksy_sidebar_position_attr() {
		return (
			blocksy_sidebar_position() === 'none'
		) ? '' : 'data-sidebar="' . blocksy_sidebar_position() . '"';
	}
}

if (! function_exists('blocksy_get_single_page_structure')) {
	function blocksy_get_single_page_structure() {
		$default_page_structure = blocksy_default_akg(
			'page_structure_type',
			blocksy_get_post_options(),
			'default'
		);

		if ($default_page_structure !== 'default') {
			return $default_page_structure;
		}

		$prefix = blocksy_manager()->screen->get_prefix();

		if (! is_singular()) {
			return 'none';
		}

		return get_theme_mod(
			$prefix . '_structure',
			($prefix === 'single_blog_post') ? 'type-3' : 'type-4'
		);
	}
}

if (! function_exists('blocksy_sidebar_position')) {
	function blocksy_sidebar_position($prefix = null) {
		$prefix = blocksy_manager()->screen->get_prefix();

		if ($prefix === 'lms') {
			return 'right';
		}

		$blog_post_structure = get_theme_mod(
			$prefix . '_structure',
			'grid'
		);

		if (
			strpos($prefix, '_archive') !== false
			||
			$prefix === 'search'
			||
			$prefix === 'categories'
			||
			$prefix === 'author'
			||
			$prefix === 'blog'
			||
			$prefix === 'woo_categories'
		) {
			if (
				get_theme_mod($prefix . '_has_sidebar', 'no') === 'no'
				||
				$blog_post_structure === 'gutenberg'
			) {
				return 'none';
			}

			return get_theme_mod($prefix . '_sidebar_position', 'right');
		}

		if (
			$prefix !== 'single_page'
			&&
			$prefix !== 'single_blog_post'
			&&
			$prefix !== 'product'
			&&
			strpos($prefix, '_single') === false
		) {
			return 'right';
		}

		$page_structure_type = blocksy_get_single_page_structure();

		if ('type-1' === $page_structure_type) {
			return 'right';
		}

		if ('type-2' === $page_structure_type) {
			return 'left';
		}

		return 'none';
	}
}

if (! function_exists('blocksy_get_page_structure')) {
	function blocksy_get_page_structure() {
		$page_structure_type = blocksy_get_single_page_structure();

		if ('type-3' === $page_structure_type) {
			return 'narrow';
		}

		if (
			$page_structure_type === 'type-4'
			||
			$page_structure_type === 'type-5'
		) {
			return 'normal';
		}

		return 'none';
	}
}

