<?php

// Mailchimp
blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('mailchimpContent'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'linkHoverColor'
		],
	],
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('mailchimpButton'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'buttonHoverColor'
		]
	],
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('mailchimpBackground'),
	'default' => ['default' => [ 'color' => '#ffffff' ]],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'backgroundColor'
		],
	],
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('mailchimpShadow'),
	'default' => ['default' => [ 'color' => 'rgba(210, 213, 218, 0.4)' ]],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'mailchimpShadow'
		],
	],
]);

blc_call_fn(['fn' => 'blocksy_output_box_shadow'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-mailchimp-block',
	'value' => get_theme_mod(
		'mailchimpShadow',
		blc_call_fn(['fn' => 'blocksy_box_shadow_value'], [
			'enable' => true,
			'h_offset' => 0,
			'v_offset' => 50,
			'blur' => 90,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(210, 213, 218, 0.4)',
			],
		])
	),
	'responsive' => true
]);

blc_call_fn(['fn' => 'blocksy_output_responsive'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-mailchimp-block',
	'variableName' => 'padding',
	'value' => get_theme_mod('mailchimpSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);

