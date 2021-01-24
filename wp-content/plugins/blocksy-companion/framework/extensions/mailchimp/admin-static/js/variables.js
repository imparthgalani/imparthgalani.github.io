import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({

	mailchimpContent: [
		{
			selector: '.ct-mailchimp-block',
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: '.ct-mailchimp-block',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	mailchimpButton: [
		{
			selector: '.ct-mailchimp-block',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-mailchimp-block',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	mailchimpBackground: {
		selector: '.ct-mailchimp-block',
		variable: 'mailchimpBackground',
		type: 'color'
	},

	mailchimpShadow: {
		selector: '.ct-mailchimp-block',
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true
	},	

	mailchimpSpacing: {
		selector: '.ct-mailchimp-block',
		variable: 'padding',
		responsive: true,
		unit: ''
	}
})