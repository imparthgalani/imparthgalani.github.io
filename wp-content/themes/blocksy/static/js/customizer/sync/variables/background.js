import { maybePromoteScalarValueIntoResponsive } from 'customizer-sync-helpers/dist/promote-into-responsive'

const componentToHex = (c) => {
	var hex = c.toString(16)
	return hex.length == 1 ? '0' + hex : hex
}

const withResponsive = ({ responsive, value, cb }) => {
	value = maybePromoteScalarValueIntoResponsive(value, responsive)

	if (responsive) {
		return {
			desktop: cb(value.desktop),
			tablet: cb(value.tablet),
			mobile: cb(value.mobile),
		}
	}

	return cb(value)
}

export const handleBackgroundOptionFor = ({
	id,

	selector,

	responsive = false,
	valueExtractor = (value) => value,
	addToDescriptors = {},
}) => ({
	[id]: [
		{
			variable: 'background-color',
			selector,

			responsive,
			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: (value) => value.backgroundColor.default.color,
				}),

			...addToDescriptors,
		},

		{
			variable: 'pattern-color',
			selector,

			responsive,
			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: (value) =>
						value.background_type === 'pattern'
							? value.patternColor.default.color
							: 'CT_CSS_SKIP_RULE',
				}),

			...addToDescriptors,
		},

		{
			variable: 'overlay',
			selector,

			responsive,
			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: (value) =>
						value.background_type === 'image' &&
						value.background_image.url
							? value.overlayColor.default.color
							: 'CT_CSS_SKIP_RULE',
				}),

			...addToDescriptors,
		},

		{
			variable: 'background-image',
			selector,

			responsive,
			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: ({
						background_type,
						gradient,
						background_image,
						background_pattern,
						patternColor,
						backgroundColor,
					}) => {
						if (background_type === 'color') {
							if (
								backgroundColor.default.color !==
								'CT_CSS_SKIP_RULE'
							) {
								return 'none'
							}

							return 'CT_CSS_SKIP_RULE'
						}

						const str_replace = ($old, $new, $text) =>
							($text + '').split($old).join($new)

						if (background_type === 'image') {
							if (!background_image.url) {
								if (
									backgroundColor['default'] !==
									'CT_CSS_SKIP_RULE'
								) {
									return 'none'
								}

								return 'CT_CSS_SKIP_RULE'
							}

							return `url(${background_image.url})`
						}

						if (background_type === 'gradient') {
							return gradient
						}

						let opacity = 1
						let color = patternColor.default.color

						if (color.indexOf('paletteColor1') > -1) {
							color = getComputedStyle(
								document.body
							).getPropertyValue('--paletteColor1')
						}

						if (color.indexOf('paletteColor2') > -1) {
							color = getComputedStyle(
								document.body
							).getPropertyValue('--paletteColor2')
						}

						if (color.indexOf('paletteColor3') > -1) {
							color = getComputedStyle(
								document.body
							).getPropertyValue('--paletteColor3')
						}

						if (color.indexOf('paletteColor4') > -1) {
							color = getComputedStyle(
								document.body
							).getPropertyValue('--paletteColor4')
						}

						if (color.indexOf('paletteColor5') > -1) {
							color = getComputedStyle(
								document.body
							).getPropertyValue('--paletteColor5')
						}

						if (color.indexOf('rgb') > -1) {
							const rgb_array = str_replace(
								'rgb(',
								'',
								str_replace(
									')',
									'',
									str_replace(
										'rgba(',
										'',
										str_replace(' ', '', color)
									)
								)
							).split(',')

							color = `#${componentToHex(
								parseInt(rgb_array[0], 10)
							)}${componentToHex(
								parseInt(rgb_array[1], 10)
							)}${componentToHex(parseInt(rgb_array[2], 10))}`

							if (rgb_array.length > 3) {
								opacity = rgb_array[3]
							}
						}

						color = str_replace('#', '', color)

						return `url("${str_replace(
							'OPACITY',
							opacity,
							str_replace(
								'COLOR',
								color,
								ct_localizations.customizer_sync.svg_patterns[
									background_pattern
								] ||
									ct_localizations.customizer_sync
										.svg_patterns['type-1']
							)
						)}")`
					},
				}),

			...addToDescriptors,
		},

		{
			variable: 'background-position',
			selector,
			responsive,
			...addToDescriptors,

			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: ({ background_type, background_image: { x, y } }) => {
						if (background_type !== 'image') {
							return 'CT_CSS_SKIP_RULE'
						}

						return `${Math.round(
							parseFloat(x) * 100
						)}% ${Math.round(parseFloat(y) * 100)}%`
					},
				}),
		},

		{
			variable: 'background-size',
			selector,

			responsive,
			...addToDescriptors,

			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: ({ background_type, background_size }) => {
						if (background_type !== 'image') {
							return 'CT_CSS_SKIP_RULE'
						}

						return background_size
					},
				}),
		},

		{
			variable: 'background-attachment',
			selector,

			responsive,
			...addToDescriptors,

			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: ({ background_type, background_attachment }) => {
						if (background_type !== 'image') {
							return 'CT_CSS_SKIP_RULE'
						}

						return background_attachment
					},
				}),
		},

		{
			selector,
			variable: 'background-repeat',
			responsive,
			...addToDescriptors,
			extractValue: (value) =>
				withResponsive({
					value: valueExtractor(value),
					responsive,
					cb: ({ background_type, background_repeat }) => {
						if (background_type !== 'image') {
							return 'CT_CSS_SKIP_RULE'
						}

						return background_repeat
					},
				}),
		},
	],
})

export const getBackgroundVariablesFor = () => ({
	// Site background
	...handleBackgroundOptionFor({
		id: 'site_background',
		selector: 'body',
		responsive: true,
	}),
})
