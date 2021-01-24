import { getHeroVariables } from './hero-section'
import { getPostListingVariables } from './template-parts/content-loop'
import { getTypographyVariablesFor } from './variables/typography'
import { getBackgroundVariablesFor } from './variables/background'
import { getWooVariablesFor } from './variables/woocommerce'
import { getFormsVariablesFor } from './variables/forms'
import { getPaginationVariables } from './pagination'
import { getCommentsVariables } from './comments'

import { getSingleContentVariablesFor } from './single/structure'

import { getSingleElementsVariables } from './variables/single/related-posts'

import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	colorPalette: [
		{
			variable: 'paletteColor1',
			type: 'color:color1',
		},

		{
			variable: 'paletteColor2',
			type: 'color:color2',
		},

		{
			variable: 'paletteColor3',
			type: 'color:color3',
		},

		{
			variable: 'paletteColor4',
			type: 'color:color4',
		},

		{
			variable: 'paletteColor5',
			type: 'color:color5',
		},
	],

	background_pattern: [
		{
			variable: 'backgroundPattern',
		},
	],

	// Page Hero
	...getSingleContentVariablesFor(),

	...getHeroVariables(),

	...getPostListingVariables(),
	...getPaginationVariables(),

	...getTypographyVariablesFor(),
	...getBackgroundVariablesFor(),
	...getFormsVariablesFor(),
	...getCommentsVariables(),
	...getWooVariablesFor(),

	// Single
	...getSingleElementsVariables(),

	// Colors
	fontColor: {
		selector: ':root',
		variable: 'color',
		type: 'color',
	},

	linkColor: [
		{
			selector: ':root',
			variable: 'linkInitialColor',
			type: 'color:default',
		},

		{
			selector: ':root',
			variable: 'linkHoverColor',
			type: 'color:hover',
		},
	],

	selectionColor: [
		{
			selector: ':root',
			variable: 'selectionTextColor',
			type: 'color:default',
		},

		{
			selector: ':root',
			variable: 'selectionBackgroundColor',
			type: 'color:hover',
		},
	],

	border_color: {
		variable: 'border-color',
		type: 'color',
		selector: ':root',
	},

	headingColor: {
		variable: 'headingColor',
		type: 'color',
		selector: ':root',
	},

	// Content spacing
	contentSpacing: [
		{
			selector: ':root',
			variable: 'contentSpacing',
			extractValue: (value) =>
				({
					none: '0',
					compact: '0.8em',
					comfortable: '1.5em',
					spacious: '2em',
				}[value]),
		},
	],

	// Buttons
	buttonMinHeight: {
		selector: ':root',
		variable: 'buttonMinHeight',
		responsive: true,
		unit: 'px',
	},

	buttonHoverEffect: [
		{
			selector: ':root',
			variable: 'buttonShadow',
			extractValue: (value) =>
				value === 'yes' ? 'CT_CSS_SKIP_RULE' : 'none',
		},

		{
			selector: ':root',
			variable: 'buttonTransform',
			extractValue: (value) =>
				value === 'yes' ? 'CT_CSS_SKIP_RULE' : 'none',
		},
	],

	buttonRadius: {
		selector: ':root',
		type: 'spacing',
		variable: 'buttonBorderRadius',
		responsive: true,
	},

	buttonTextColor: [
		{
			selector: ':root',
			variable: 'buttonTextInitialColor',
			type: 'color:default',
		},

		{
			selector: ':root',
			variable: 'buttonTextHoverColor',
			type: 'color:hover',
		},
	],

	buttonColor: [
		{
			selector: ':root',
			variable: 'buttonInitialColor',
			type: 'color:default',
		},

		{
			selector: ':root',
			variable: 'buttonHoverColor',
			type: 'color:hover',
		},
	],

	siteBackground: {
		variable: 'siteBackground',
		type: 'color',
	},

	// Layout
	maxSiteWidth: {
		selector: ':root',
		variable: 'container-max-width',
		unit: 'px',
	},

	contentAreaSpacing: {
		selector: ':root',
		variable: 'content-vertical-spacing',
		responsive: true,
		unit: '',
	},

	narrowContainerWidth: {
		selector: ':root',
		variable: 'narrow-container-max-width',
		unit: 'px',
	},

	wideOffset: {
		selector: ':root',
		variable: 'wide-offset',
		unit: 'px',
	},

	// Sidebar
	sidebarWidth: [
		{
			selector: '[data-sidebar]',
			variable: 'sidebarWidth',
			unit: '%',
		},
		{
			selector: '[data-sidebar]',
			variable: 'sidebarWidthNoUnit',
			unit: '',
		},
	],

	sidebarGap: {
		selector: '[data-sidebar]',
		variable: 'sidebarGap',
		unit: '',
	},

	sidebarOffset: {
		selector: '[data-sidebar]',
		variable: 'sidebarOffset',
		unit: 'px',
	},

	sidebarWidgetsTitleColor: {
		selector: '.ct-sidebar .widget-title',
		variable: 'headingColor',
		type: 'color',
		responsive: true,
	},

	sidebarWidgetsFontColor: [
		{
			selector: '.ct-sidebar > *',
			variable: 'color',
			type: 'color:default',
			responsive: true,
		},

		{
			selector: '.ct-sidebar',
			variable: 'linkInitialColor',
			type: 'color:link_initial',
			responsive: true,
		},

		{
			selector: '.ct-sidebar',
			variable: 'linkHoverColor',
			type: 'color:link_hover',
			responsive: true,
		},
	],

	sidebarWidgetsHeadingFontColor: [
		{
			selector: '.ct-widget > *:not(.widget-title)',
			variable: 'headingColor',
			type: 'color:default',
			responsive: true,
		},
	],

	sidebarBackgroundColor: {
		selector: '[data-sidebar] > aside',
		variable: 'sidebarBackgroundColor',
		type: 'color',
		responsive: true,
	},

	sidebarBorder: {
		selector: 'aside[data-type="type-2"]',
		variable: 'border',
		type: 'border',
		responsive: true,
	},

	sidebarDivider: {
		selector: 'aside[data-type="type-3"]',
		variable: 'border',
		type: 'border',
		responsive: true,
	},

	sidebarWidgetsSpacing: {
		selector: '.ct-sidebar',
		variable: 'sidebar-widgets-spacing',
		responsive: true,
		unit: 'px',
	},

	sidebarInnerSpacing: {
		selector: '[data-sidebar] > aside',
		variable: 'sidebarInnerSpacing',
		responsive: true,
		unit: 'px',
	},

	sidebarRadius: {
		selector: 'aside[data-type="type-2"]',
		type: 'spacing',
		variable: 'borderRadius',
		responsive: true,
	},

	sidebarShadow: {
		selector: 'aside[data-type="type-2"]',
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true,
	},

	// To top button
	topButtonSize: {
		selector: '.ct-back-to-top',
		variable: 'icon-size',
		responsive: true,
		unit: 'px',
	},

	topButtonOffset: {
		selector: '.ct-back-to-top',
		variable: 'back-top-bottom-offset',
		responsive: true,
		unit: 'px',
	},

	sideButtonOffset: {
		selector: '.ct-back-to-top',
		variable: 'back-top-side-offset',
		responsive: true,
		unit: 'px',
	},

	topButtonIconColor: [
		{
			selector: '.ct-back-to-top',
			variable: 'color',
			type: 'color:default',
		},

		{
			selector: '.ct-back-to-top',
			variable: 'colorHover',
			type: 'color:hover',
		},
	],

	topButtonShapeBackground: [
		{
			selector: '.ct-back-to-top',
			variable: 'backgroundColor',
			type: 'color:default',
		},

		{
			selector: '.ct-back-to-top',
			variable: 'backgroundColorHover',
			type: 'color:hover',
		},
	],

	topButtonShadow: {
		selector: '.ct-back-to-top',
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true,
	},

	// Passepartout
	passepartoutSize: {
		selector: '[data-frame]',
		variable: 'frame-size',
		responsive: true,
		unit: 'px',
	},

	passepartoutColor: {
		selector: '[data-frame]',
		variable: 'frame-color',
		type: 'color',
	},
})
