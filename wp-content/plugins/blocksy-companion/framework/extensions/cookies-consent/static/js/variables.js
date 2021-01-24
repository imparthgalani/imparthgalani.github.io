import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	cookieContentColor: [
		{
			selector: '.cookie-notification',
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: '.cookie-notification',
			variable: 'colorHover',
			type: 'color:hover'
		}
	],

	cookieBackground: {
		selector: '.cookie-notification',
		variable: 'backgroundColor',
		type: 'color'
	},

	cookieButtonBackground: [
		{
			selector: '.cookie-notification',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.cookie-notification',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	cookieMaxWidth: {
		selector: '.cookie-notification',
		variable: 'maxWidth',
		unit: 'px'
	}
})
