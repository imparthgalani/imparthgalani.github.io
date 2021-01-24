import { getPrefixFor, watchOptionsWithPrefix, getOptionFor } from '../helpers'
import { handleBackgroundOptionFor } from '../variables/background'

watchOptionsWithPrefix({
	getPrefix: () => getPrefixFor(),
	getOptionsForPrefix: ({ prefix }) => [`${prefix}_content_area_spacing`],
	render: ({ prefix, id }) => {
		if (id === `${prefix}_content_area_spacing`) {
			let el = document.querySelector('.site-main > div')

			if (!el) {
				return
			}

			let spacingComponents = []

			let contentAreaSpacing = getOptionFor(
				'content_area_spacing',
				prefix
			)

			if (contentAreaSpacing === 'both' || contentAreaSpacing === 'top') {
				spacingComponents.push('top')
			}

			if (
				contentAreaSpacing === 'both' ||
				contentAreaSpacing === 'bottom'
			) {
				spacingComponents.push('bottom')
			}

			el.removeAttribute('data-v-spacing')

			if (spacingComponents.length > 0) {
				el.dataset.vSpacing = spacingComponents.join(':')
			}
		}
	},
})

export const getSingleContentVariablesFor = () => {
	const prefix = getPrefixFor()

	return {
		...handleBackgroundOptionFor({
			id: `${prefix}_background`,
			selector: `body[data-prefix="${prefix}"]`,
			responsive: true,
		}),

		...handleBackgroundOptionFor({
			id: `${prefix}_content_background`,
			selector: `body[data-prefix="${prefix}"] [data-structure*="boxed"]`,
			responsive: true,
		}),

		[`${prefix}_boxed_content_spacing`]: {
			selector: `body[data-prefix="${prefix}"] [data-structure*="boxed"]`,
			type: 'spacing',
			variable: 'boxed-content-spacing',
			responsive: true,
			unit: '',
		},

		[`${prefix}_content_boxed_radius`]: {
			selector: `body[data-prefix="${prefix}"] [data-structure*="boxed"]`,
			type: 'spacing',
			variable: 'border-radius',
			responsive: true,
		},

		[`${prefix}_content_boxed_shadow`]: {
			selector: `body[data-prefix="${prefix}"] [data-structure*="boxed"]`,
			type: 'box-shadow',
			variable: 'box-shadow',
			responsive: true,
		},
	}
}
