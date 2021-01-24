<?php

add_filter('get_site_icon_url', function ($url) {
	if (empty($url)) {
		return get_template_directory_uri() . '/static/images/favicon.png';
	}

	return $url;
});

