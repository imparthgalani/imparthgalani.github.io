export const getFormsVariablesFor = () => ({
	
	// general
	formTextColor: [
		{
			selector: ':root',
			variable: 'formTextInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formTextFocusColor',
			type: 'color:focus'
		}
	],

	formFontSize: {
		selector: ':root',
		variable: 'formFontSize',
		unit: 'px'
	},

	formBackgroundColor: [
		{
			selector: ':root',
			variable: 'formBackgroundInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formBackgroundFocusColor',
			type: 'color:focus'
		}
	],

	formInputHeight: {
		selector: ':root',
		variable: 'formInputHeight',
		unit: 'px'
	},

	formTextAreaHeight: {
		selector: 'form textarea',
		variable: 'formInputHeight',
		unit: 'px'
	},

	formBorderColor: [
		{
			selector: ':root',
			variable: 'formBorderInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formBorderFocusColor',
			type: 'color:focus'
		}
	],

	formBorderSize: {
		selector: ':root',
		variable: 'formBorderSize',
		unit: 'px'
	},

	// radio & checkbox
	radioCheckboxColor: [
		{
			selector: ':root',
			variable: 'radioCheckboxInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'radioCheckboxAccentColor',
			type: 'color:accent'
		}
	],

})