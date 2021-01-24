<?php

$options = [
	'general_visitor_eng_section_options' => [
		'type' => 'ct-options',
		'asd' => 'test',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			apply_filters(
				'blocksy_engagement_general_start_customizer_options',
				[]
			),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'enable_schema_org_markup' => [
					'label' => __( 'Schema Org Markup', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'desc' => __( 'If you use an SEO plugin, you can disable this option and let the plugin take care of it.', 'blocksy' ),
				],
			],

			apply_filters(
				'blocksy_engagement_general_end_customizer_options',
				[]
			),
		],
	],

];
