import { handleVariablesFor } from 'customizer-sync-helpers/dist/simplified'

export const listenToVariables = () => {
	handleVariablesFor({
		colorPalette: [
			{
				variable: 'paletteColor1',
				type: 'color:color1'
			},

			{
				variable: 'paletteColor2',
				type: 'color:color2'
			},

			{
				variable: 'paletteColor3',
				type: 'color:color3'
			},

			{
				variable: 'paletteColor4',
				type: 'color:color4'
			},

			{
				variable: 'paletteColor5',
				type: 'color:color5'
			}
		],

		fontColor: {
			selector: ':root',
			variable: 'color',
			type: 'color',
		},

		linkColor: [
			{
				selector: ':root',
				variable: 'linkInitialColor',
				type: 'color:default'
			},

			{
				selector: ':root',
				variable: 'linkHoverColor',
				type: 'color:hover'
			}
		],

		border_color: {
			selector: ':root',
			variable: 'border-color',
			type: 'color',
		},

		headingColor: {
			selector: ':root',
			variable: 'headingColor',
			type: 'color',
		},

		buttonTextColor: [
			{
				selector: ':root',
				variable: 'buttonTextInitialColor',
				type: 'color:default'
			},

			{
				selector: ':root',
				variable: 'buttonTextHoverColor',
				type: 'color:hover'
			}
		],

		buttonColor: [
			{
				selector: ':root',
				variable: 'buttonInitialColor',
				type: 'color:default'
			},

			{
				selector: ':root',
				variable: 'buttonHoverColor',
				type: 'color:hover'
			}
		],

		global_quantity_color: [
			{
				selector: ':root',
				variable: 'quantity-initial-color',
				type: 'color:default',
			},

			{
				selector: ':root',
				variable: 'quantity-hover-color',
				type: 'color:hover',
			}
		],

	global_quantity_arrows: [
		{
			selector: ':root',
			variable: 'quantity-arrows-initial-color',
			type: 'color:default',
		},

		{
			selector: ':root',
			variable: 'quantity-arrows-hover-color',
			type: 'color:hover',
		}
	],
	})
}
