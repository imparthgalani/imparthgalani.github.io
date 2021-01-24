<?php

add_filter(
	'fl_theme_builder_part_hooks',
	function () {
		return [
			[
				'label' => __('Header', 'blocksy'),
				'hooks' => [
					'blocksy:header:before' => __('Before Header', 'blocksy'),
					'blocksy:header:after'  => __('After Header', 'blocksy'),
				]
			],

			[
				'label' => __('Content', 'blocksy'),
				'hooks' => [
					'blocksy:content:before' => __('Before Content', 'blocksy'),
					'blocksy:content:top' => __('Top Content', 'blocksy'),
					'blocksy:content:bottom' => __('Bottom Content', 'blocksy'),
					'blocksy:content:after' => __('After Content', 'blocksy'),
				]
			],

			[

				'label' => __('Footer', 'blocksy'),
				'hooks' => [
					'blocksy:footer:before' => __('Before Footer', 'blocksy'),
					'blocksy:footer:after' => __('After Footer', 'blocksy'),
				]
			]
		];
	}
);

