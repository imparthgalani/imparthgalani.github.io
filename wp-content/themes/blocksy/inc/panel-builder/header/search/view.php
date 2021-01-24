<?php

$class = 'ct-header-search';

$search_visibility = blocksy_default_akg('header_search_visibility', $atts, [
	'desktop' => true,
	'tablet' => true,
	'mobile' => true,
]);

$class .= ' ' . blocksy_visibility_classes($search_visibility);

?>

<div
	class="<?php echo esc_attr($class) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>

	<a href="#search-modal" aria-label="<?php echo __('Search', 'blocksy')?>">
		<svg viewBox="0 0 10 10">
			<path d="M9.7,9.7c-0.4,0.4-1,0.4-1.3,0L6.7,8.1C6.1,8.5,5.3,8.8,4.4,8.8C2,8.8,0,6.8,0,4.4S2,0,4.4,0s4.4,2,4.4,4.4
		c0,0.9-0.3,1.7-0.7,2.4l1.7,1.7C10.1,8.8,10.1,9.4,9.7,9.7z M4.4,1.3c-1.7,0-3.1,1.4-3.1,3.1s1.4,3.1,3.1,3.1c1.7,0,3.1-1.4,3.1-3.1
		S6.1,1.3,4.4,1.3z"/>
		</svg>
	</a>
</div>
