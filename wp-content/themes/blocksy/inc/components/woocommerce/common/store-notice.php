<?php

add_filter(
	'woocommerce_demo_store',
	function ($notice) {
		$parser = new Blocksy_Attributes_Parser();

		$notice = $parser->add_attribute_to_images_with_tag(
			$notice,
			'data-position',
			get_theme_mod('store_notice_position', 'bottom'),
			'p'
		);

		return $notice;
	}
);
