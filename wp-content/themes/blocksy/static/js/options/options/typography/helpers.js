export const fontFamilyToCSSFamily = (family) => {
	if (family === 'System Default') {
		return "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'"
	}

	return family.replace('ct_typekit_', '')
}

const findSourceTypeSettingsFor = (font_family, fonts_list) =>
	Object.values(fonts_list).find(
		(single_font_source) =>
			single_font_source.families
				.map(({ family }) => family)
				.indexOf(font_family) > -1
	)

export const findSourceTypeFor = (font_family, fonts_list) => {
	let source = findSourceTypeSettingsFor(font_family, fonts_list)
	if (!source) return false
	return source.type
}

export const findSelectedFontFamily = (font_family, fonts_list) => {
	let source = findSourceTypeSettingsFor(font_family, fonts_list)

	if (!source) {
		return null
	}

	return source.families.find(({ family }) => family === font_family)
}

export const decideVariationToSelect = (newValue, oldValue) => {
	if (newValue.all_variations.indexOf(oldValue.variation) > -1) {
		return oldValue.variation
	}

	if (newValue.all_variations.indexOf('n4') > -1) {
		return 'n4'
	}

	return newValue.all_variations[0]
}

export const humanizeVariationsShort = (variation) => {
	var all = {
		n1: '100',
		i1: '100',
		n2: '200',
		i2: '200',
		n3: '300',
		i3: '300',
		n4: '400',
		i4: '400',
		n5: '500',
		i5: '500',
		n6: '600',
		i6: '600',
		n7: '700',
		i7: '700',
		n8: '800',
		i8: '800',
		n9: '900',
		i9: '900',
		Default: 'Default',
	}

	return all[variation]
}

export const humanizeVariations = (variation) => {
	var all = {
		n1: 'Thin 100',
		i1: 'Thin 100 Italic',
		n2: 'Extra-Light 200',
		i2: 'Extra-Light 200 Italic',
		n3: 'Light 300',
		i3: 'Light 300 Italic',
		n4: 'Regular',
		i4: 'Regular 400 Italic',
		n5: 'Medium 500',
		i5: 'Medium 500 Italic',
		n6: 'Semi-Bold 600',
		i6: 'Semi-Bold 600 Italic',
		n7: 'Bold 700',
		i7: 'Bold 700 Italic',
		n8: 'Extra-Bold 800',
		i8: 'Extra-Bold 800 Italic',
		n9: 'Ultra-Bold 900',
		i9: 'Ultra-Bold 900 Italic',
		Default: 'Default Weight',
	}

	return all[variation]
}

export const familyForDisplay = (family) => {
	if (family.indexOf('ct_font') === 0) {
		return family
			.replace('ct_font_', '')
			.replace(/([-_][a-z])/gi, ($1) =>
				$1.toUpperCase().replace('-', '').replace('_', '')
			)
	}

	if (family.indexOf('ct_typekit') === 0) {
		return family
			.replace('ct_typekit_', '')
			.replace(/([-_][a-z])/gi, ($1) =>
				$1.toUpperCase().replace('-', ' ').replace('_', ' ')
			)
	}

	return family
}
