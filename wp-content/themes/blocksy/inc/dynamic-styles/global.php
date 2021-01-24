<?php

Blocksy_Manager::instance()->builder->dynamic_css('header', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

Blocksy_Manager::instance()->builder->dynamic_css('footer', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'typography',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'background',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'page-title',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'hero'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'comments',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global',
	'prefixes' => blocksy_manager()->screen->get_single_prefixes()
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'pagination',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global',
	'prefixes' => blocksy_manager()->screen->get_archive_prefixes([
		'has_woocommerce' => true
	])
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'posts-listing',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global',
	'prefixes' => blocksy_manager()->screen->get_archive_prefixes([
		'has_categories' => true,
		'has_author' => true,
		'has_search' => true
	])
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'woocommerce',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'forms',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'all',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global'
]);

blocksy_theme_get_dynamic_styles([
	'name' => 'single-elements',
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css,
	'context' => $context,
	'chunk' => 'global',
	'prefixes' => blocksy_manager()->screen->get_single_prefixes()
]);

$supported_post_types = blocksy_manager()->post_types->get_supported_post_types();
$supported_post_types[] = 'single_blog_post';
$supported_post_types[] = 'single_page';

if (function_exists('is_product')) {
	$supported_post_types[] = 'product';
}

if (class_exists('bbPress')) {
	$supported_post_types[] = 'bbpress';
}


foreach ($supported_post_types as $post_type) {
	if (
		$post_type !== 'single_blog_post'
		&&
		$post_type !== 'single_page'
		&&
		$post_type !== 'product'
	) {
		$post_type .= '_single';
	}

	blocksy_theme_get_dynamic_styles([
		'name' => 'single-content',
		'css' => $css,
		'mobile_css' => $mobile_css,
		'tablet_css' => $tablet_css,
		'context' => $context,
		'chunk' => 'single-content',
		'prefix' => $post_type,
	]);
}

