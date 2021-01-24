<?php

defined( 'ABSPATH' ) || die( "Don't run this file directly!" );

add_filter(
	'excerpt_length',
	function ($length) {
		return 100;
	}
);

if (! function_exists('blocksy_trim_excerpt')) {
	function blocksy_trim_excerpt($excerpt, $length) {
		$text = $excerpt;

		if ($length !== 'original') {
			$text = wp_trim_words($excerpt, $length, '…');
		}

		foreach (wp_extract_urls($text) as $url) {
			$text = str_replace($url, '', $text);
		}

		echo $text;
	}
}

add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

