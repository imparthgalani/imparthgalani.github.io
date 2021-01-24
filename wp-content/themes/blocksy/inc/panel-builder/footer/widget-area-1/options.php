<?php

if (! isset($sidebarId)) {
	$sidebarId = 'ct-footer-sidebar-1';
}

$options = [

	'widget' => [
		'type' => 'ct-widget-area',
		'sidebarId' => $sidebarId
	],

];
