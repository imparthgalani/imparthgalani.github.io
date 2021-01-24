<?php

// Content color
blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('cookieContentColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.cookie-notification',
			'variable' => 'colorHover'
		],
	],
]);

// Button color
blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('cookieButtonBackground'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.cookie-notification',
			'variable' => 'buttonHoverColor'
		]
	],
]);


// Background color
blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('cookieBackground'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'backgroundColor'
		],
	],
]);

$cookieMaxWidth = get_theme_mod( 'cookieMaxWidth', 400 );
$css->put(
	'.cookie-notification',
	'--maxWidth: ' . $cookieMaxWidth . 'px'
);

