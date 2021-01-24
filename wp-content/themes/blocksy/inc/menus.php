<?php

add_filter(
	'page_css_class',
	function ($css_class, $page, $depth, $args, $current_page) {
		if (isset($args['pages_with_children'][$page->ID])) {
			$css_class[] = 'menu-item-has-children';
		}

		if (! empty($current_page)) {
			$_current_page = get_post($current_page);

			if (
				$_current_page
				&&
				in_array($page->ID, $_current_page->ancestors)
			) {
				$css_class[] = 'current-menu-ancestor';
			}

			if ($page->ID === $current_page) {
				$css_class[] = 'current-menu-item';
			} elseif (
				$_current_page
				&&
				$page->ID === $_current_page->post_parent
			) {
				$css_class[] = 'current-menu-parent';
			}
		} elseif (get_option('page_for_posts') === $page->ID) {
			$css_class[] = 'current-menu-parent';
		}

		if (
			! isset($args['blocksy_mega_menu'])
			||
			! $args['blocksy_mega_menu']
		) {
			return $css_class;
		}

		$classes_str = implode(' ', $css_class);

		if (
			strpos($classes_str, 'has-children') === false
			&&
			strpos($classes_str, 'has_children') === false
		) {
			return $css_class;
		}

		$css_class[] = 'animated-submenu';

		return $css_class;
	},
	10, 5
);

add_filter(
	'nav_menu_css_class',
	function ($classes, $item, $args, $depth) {
		if (
			! isset($args->blocksy_mega_menu)
			||
			! $args->blocksy_mega_menu
		) {
			return $classes;
		}

		$classes_str = implode(' ', $classes);

		if (
			strpos($classes_str, 'has-children') === false
			&&
			strpos($classes_str, 'has_children') === false
		) {
			return $classes;
		}

		if (
			apply_filters('blocksy:menu:has_animated_submenu', true, $item, $args)
			||
			$depth === 0
		) {
			$classes[] = 'animated-submenu';
		}

		return $classes;
	},
	50, 4
);

if (! function_exists('blocksy_handle_nav_menu_item_title')) {
	function blocksy_handle_nav_menu_item_title($item_output, $item, $depth, $args) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join(' ', array_filter($classes));

		if (
			strpos($class_names, 'has-children') !== false
			||
			strpos($class_names, 'has_children') !== false
		) {
			return $item_output . '<span class="child-indicator"><svg width="8" height="8" viewBox="0 0 15 15"><path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/></svg></span>';
		}

		return $item_output;
	}
}

if (! function_exists('blocksy_get_menus_items')) {
	function blocksy_get_menus_items($location = '') {
		$menus = [
			// 'blocksy_location' => $location
			'blocksy_location' => __('Default', 'blocksy')
		];

		$all_menus = get_terms('nav_menu', ['hide_empty' => true]);

		if (is_array($all_menus) && count($all_menus)) {
			foreach($all_menus as $row) {
				$menus[$row->term_id] = $row->name;
			}
		}

		$result = [];

		foreach ($menus as $id => $menu){
			$result[$id] = $menu;
		}

		return $result;
	}
}

