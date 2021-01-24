import WebFontLoader from 'webfontloader'

const withPrefix = (value, prefix = '') => {
	if (prefix.trim() === '') {
		return value
	}

	return `${prefix}${value.charAt(0).toUpperCase()}${value.slice(1)}`
}

const getWeightFor = ({ variation }) => {
	if (variation === 'Default') {
		return 'CT_CSS_SKIP_RULE'
	}

	return parseInt(variation[1], 10) * 100
}
const getStyleFor = ({ variation }) => {
	if (variation === 'Default') {
		return 'CT_CSS_SKIP_RULE'
	}

	return variation[0] === 'i' ? 'italic' : 'normal'
}

let loadedFonts = {}

const systemFonts = [
	'System Default',
	'Arial',
	'Verdana',
	'Trebuchet',
	'Georgia',
	'Times New Roman',
	'Palatino',
	'Helvetica',
	'Myriad Pro',
	'Lucida',
	'Gill Sans',
	'Impact',
	'Serif',
	'monospace',
]

const loadGoogleFonts = (font_family, variation) => {
	if (systemFonts.indexOf(font_family) > -1) {
		return
	}

	if (font_family.indexOf('ct_font_') === 0) {
		return
	}

	if (font_family.indexOf('ct_typekit_') === 0) {
		return
	}

	if (font_family === 'CT_CSS_SKIP_RULE') {
		return
	}

	if (font_family === 'Default') {
		return
	}

	if (font_family.indexOf('apple-system') > -1) {
		return
	}

	if (loadedFonts[font_family]) {
		if (loadedFonts[font_family].indexOf(variation) > -1) return
		loadedFonts[font_family] = [...loadedFonts[font_family], variation]
	} else {
		loadedFonts[font_family] = [variation]
	}

	WebFontLoader.load({
		google: {
			families: [
				`${font_family}:${parseInt(variation[1], 10) * 100}${
					variation[0] === 'i' ? 'i' : ''
				}&display=swap`,
			],
		},
		classes: false,
		text: 'abcdefghijklmnopqrstuvwxyz',
	})
}

export const typographyOption = ({ id, selector, prefix = '' }) => ({
	[id]: [
		{
			variable: withPrefix('fontFamily', prefix),
			selector,
			extractValue: (value) => {
				if (value.family === 'Default') {
					return 'CT_CSS_SKIP_RULE'
				}

				return value.family === 'System Default'
					? "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'"
					: value.family.replace('ct_typekit_', '')
			},
			whenDone: (extractedValue, { variation }) =>
				loadGoogleFonts(extractedValue, variation),
		},

		{
			variable: withPrefix('fontWeight', prefix),
			selector,
			extractValue: getWeightFor,
			whenDone: (extractedValue, { family, variation }) =>
				loadGoogleFonts(family, variation),
		},

		{
			variable: withPrefix('fontStyle', prefix),
			selector,
			extractValue: getStyleFor,

			whenDone: (extractedValue, { family, variation }) =>
				loadGoogleFonts(family, variation),
		},

		{
			variable: withPrefix('textTransform', prefix),
			selector,
			extractValue: (value) => value['text-transform'],
		},

		{
			variable: withPrefix('textDecoration', prefix),
			selector,
			extractValue: (value) => value['text-decoration'],
		},

		{
			variable: withPrefix('fontSize', prefix),
			selector,
			unit: '',
			responsive: true,
			extractValue: (value) => value.size,
		},

		{
			variable: withPrefix('lineHeight', prefix),
			selector,
			unit: '',
			responsive: true,
			extractValue: (value) => value['line-height'],
		},

		{
			variable: withPrefix('letterSpacing', prefix),
			selector,
			unit: '',
			responsive: true,
			extractValue: (value) => value['letter-spacing'],
		},
	],
})

export const getTypographyVariablesFor = () => ({
	...typographyOption({
		id: 'rootTypography',
		selector: ':root',
	}),

	...typographyOption({
		id: 'h1Typography',
		selector: 'h1',
	}),

	...typographyOption({
		id: 'h2Typography',
		selector: 'h2',
	}),

	...typographyOption({
		id: 'h3Typography',
		selector: 'h3',
	}),

	...typographyOption({
		id: 'h4Typography',
		selector: 'h4',
	}),

	...typographyOption({
		id: 'h5Typography',
		selector: 'h5',
	}),

	...typographyOption({
		id: 'h6Typography',
		selector: 'h6',
	}),

	...typographyOption({
		id: 'buttons',
		selector: ':root',
		prefix: 'button',
	}),

	...typographyOption({
		id: 'blockquote',
		selector:
			'.wp-block-quote.is-style-large p, .wp-block-pullquote p, .ct-quote-widget blockquote',
	}),

	...typographyOption({
		id: 'pre',
		selector: 'code, kbd, samp, pre',
	}),

	...typographyOption({
		id: 'sidebarWidgetsTitleFont',
		selector: '.ct-sidebar .widget-title',
	}),

	...typographyOption({
		id: 'sidebarWidgetsFont',
		selector:
			'.ct-sidebar .ct-widget > *:not(.widget-title):not(blockquote)',
	}),

	...typographyOption({
		id: 'singleProductTitleFont',
		selector: '.entry-summary > .product_title',
	}),

	...typographyOption({
		id: 'singleProductPriceFont',
		selector: '.entry-summary .price',
	}),

	...typographyOption({
		id: 'cardProductTitleFont',
		selector:
			'[data-products] .woocommerce-loop-product__title, [data-products] .woocommerce-loop-category__title',
	}),
})
