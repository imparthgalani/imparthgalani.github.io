<?php

/**
 * Search form
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

$placeholder = esc_attr_x('Search', 'placeholder', 'blocksy');

if (isset($args['search_placeholder'])) {
	$placeholder = $args['search_placeholder'];
}

if (isset($args['search_live_results'])) {
	$has_live_results = $args['search_live_results'];
} else {
	$has_live_results = get_theme_mod('search_enable_live_results', 'yes');
}

$search_live_results_output = '';

if ($has_live_results === 'yes') {
	$search_live_results_output = 'data-live-results';
}

$class_output = '';

$any = [];

if (
	isset($args['ct_post_type'])
	&&
	$args['ct_post_type']
) {
	$any = $args['ct_post_type'];
}

if (
	isset($args['enable_search_field_class'])
	&&
	$args['enable_search_field_class']
) {
	$class_output = 'class="modal-field"';
}

$home_url = home_url('');

if (function_exists('pll_home_url')) {
	$home_url = pll_home_url();
}

?>


<form
	role="search" method="get"
	class="search-form"
	action="<?php echo esc_url($home_url); ?>"
	<?php echo wp_kses_post($search_live_results_output) ?>>
	<div class="ct-search-input">
		<input type="search" <?php echo $class_output ?> placeholder="<?php echo $placeholder; ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" title="<?php echo __('Search Input', 'blocksy') ?>" />

		<button class="search-submit" aria-label="<?php echo __('Search', 'blocksy')?>">
			<span hidden><?php echo __('Search', 'blocksy') ?></span>
			<svg
				width="12px"
				height="12px"
				viewBox="0 0 24 24">

				<path d="M23.3,23.3c-0.9,0.9-2.3,0.9-3.2,0l-4-4c-1.6,1-3.6,1.7-5.7,1.7C4.7,21,0,16.3,0,10.5S4.7,0,10.5,0C16.3,0,21,4.7,21,10.5
				c0,2.1-0.6,4-1.7,5.7l4,4C24.2,21,24.2,22.5,23.3,23.3z M10.5,3C6.4,3,3,6.4,3,10.5S6.4,18,10.5,18c4.1,0,7.5-3.4,7.5-7.5
				C18,6.4,14.7,3,10.5,3z"/>
			</svg>

			<span data-loader="circles"><span></span><span></span><span></span></span>
		</button>

		<?php if (count($any) === 1) { ?>
			<input type="hidden" name="post_type" value="<?php echo $any[0] ?>">
		<?php } ?>

		<?php if (count($any) > 1) { ?>
			<input type="hidden" name="ct_post_type" value="<?php echo implode(':', $any) ?>">
		<?php } ?>
	</div>
</form>


