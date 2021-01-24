<?php

// general
blocksy_output_colors([
	'value' => get_theme_mod('formTextColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'formTextInitialColor'
		],

		'focus' => [
			'selector' => ':root',
			'variable' => 'formTextFocusColor'
		],
	],
]);

$formFontSize = get_theme_mod('formFontSize', 15);

if ($formFontSize !== 15) {
	$css->put(':root', '--formFontSize: ' . $formFontSize . 'px');
}

blocksy_output_colors([
	'value' => get_theme_mod('formBackgroundColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'formBackgroundInitialColor'
		],

		'focus' => [
			'selector' => ':root',
			'variable' => 'formBackgroundFocusColor'
		],
	],
]);

$formInputHeight = get_theme_mod( 'formInputHeight', 40 );

if ($formInputHeight !== 40) {
	$css->put( ':root', '--formInputHeight: ' . $formInputHeight . 'px' );
}


$formTextAreaHeight = get_theme_mod( 'formTextAreaHeight', 170 );
$css->put( 'form textarea', '--formInputHeight: ' . $formTextAreaHeight . 'px' );


blocksy_output_colors([
	'value' => get_theme_mod('formBorderColor'),
	'default' => [
		'default' => [ 'color' => '#e0e5eb' ],
		'focus' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'formBorderInitialColor'
		],

		'focus' => [
			'selector' => ':root',
			'variable' => 'formBorderFocusColor'
		],
	],
]);

$formBorderSize = get_theme_mod( 'formBorderSize', 1 );
$css->put( ':root', '--formBorderSize: ' . $formBorderSize . 'px' );

// radio & checkbox
blocksy_output_colors([
	'value' => get_theme_mod('radioCheckboxColor'),
	'default' => [
		'default' => [ 'color' => '#d5d8de' ],
		'accent' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => ':root',
			'variable' => 'radioCheckboxInitialColor'
		],

		'accent' => [
			'selector' => ':root',
			'variable' => 'radioCheckboxAccentColor'
		],
	],
]);

