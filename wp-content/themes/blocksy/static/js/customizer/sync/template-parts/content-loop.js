import ctEvents from 'ct-events'
import {
	watchOptionsWithPrefix,
	getPrefixFor,
	setRatioFor,
	disableTransitionsStart,
	disableTransitionsEnd,
	getOptionFor
} from '../helpers'
import { typographyOption } from '../variables/typography'
import { renderSingleEntryMeta } from '../helpers/entry-meta'
import { replaceFirstTextNode, applyPrefixFor } from '../helpers'

const prefix = getPrefixFor()

watchOptionsWithPrefix({
	getPrefix: () => prefix,
	getOptionsForPrefix: ({ prefix }) => [
		`${prefix}_archive_order`,
		`${prefix}_card_type`
	],

	render: ({ id }) => {
		if (id === `${prefix}_card_type`) {
			disableTransitionsStart(document.querySelectorAll('.entries'))
			;[...document.querySelectorAll('.entries')].map(el => {
				const structure = getOptionFor('structure', prefix)

				if (structure !== 'gutenberg') {
					el.dataset.cards = getOptionFor('card_type', prefix)
				}
			})

			disableTransitionsEnd(document.querySelectorAll('.entries'))
		}

		if (id === `${prefix}_archive_order`) {
			let archiveOrder = getOptionFor('archive_order', prefix)
			disableTransitionsStart(document.querySelectorAll('.entries'))

			archiveOrder.map(component => {
				if (!component.enabled) return
				;[...document.querySelectorAll('.entries > article')].map(
					article => {
						let image = article.querySelector('.ct-image-container')
						let button = article.querySelector('.entry-button')

						if (component.id === 'featured_image' && image) {
							setRatioFor(
								component.thumb_ratio,
								image.querySelector('.ct-ratio')
							)

							image.classList.remove('boundless-image')

							if (
								(component.is_boundless || 'yes') === 'yes' &&
								getOptionFor('card_type', prefix) === 'boxed' &&
								getOptionFor('structure', prefix) !==
									'gutenberg'
							) {
								image.classList.add('boundless-image')
							}
						}

						if (component.id === 'read_more' && button) {
							button.dataset.type =
								component.button_type || 'simple'

							button.classList.remove('ct-button')

							if (
								(component.button_type || 'simple') ===
								'background'
							) {
								button.classList.add('ct-button')
							}

							button.dataset.alignment =
								component.read_more_alignment || 'left'

							replaceFirstTextNode(
								button,
								component.read_more_text || 'Read More'
							)
						}

						if (component.id === 'post_meta') {
							let moreDefaults = {}
							let el = article.querySelectorAll('.entry-meta')

							if (
								archiveOrder.filter(
									({ id }) => id === 'post_meta'
								).length > 1
							) {
								if (
									archiveOrder
										.filter(({ id }) => id === 'post_meta')
										.map(({ __id }) => __id)
										.indexOf(component.__id) === 0
								) {
									moreDefaults = {
										meta_elements: [
											{
												id: 'categories',
												enabled: true
											}
										]
									}

									el = el[0]
								}

								if (
									archiveOrder
										.filter(({ id }) => id === 'post_meta')
										.map(({ __id }) => __id)
										.indexOf(component.__id) === 1
								) {
									moreDefaults = {
										meta_elements: [
											{
												id: 'author',
												enabled: true
											},

											{
												id: 'post_date',
												enabled: true
											},

											{
												id: 'comments',
												enabled: true
											}
										]
									}

									if (el.length > 1) {
										el = el[1]
									}
								}
							}

							renderSingleEntryMeta({
								el,
								...moreDefaults,
								...component
							})
						}
					}
				)
			})

			disableTransitionsEnd(document.querySelectorAll('.entries'))
		}
	}
})

export const getPostListingVariables = () => ({
	...typographyOption({
		id: `${prefix}_cardTitleFont`,
		selector: applyPrefixFor('.entry-card .entry-title', prefix)
	}),

	[`${prefix}_cardTitleColor`]: [
		{
			selector: applyPrefixFor('.entry-card .entry-title', prefix),
			variable: 'headingColor',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor('.entry-card .entry-title', prefix),
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	...typographyOption({
		id: `${prefix}_cardExcerptFont`,
		selector: applyPrefixFor('.entry-excerpt', prefix)
	}),

	[`${prefix}_cardExcerptColor`]: {
		selector: applyPrefixFor('.entry-excerpt', prefix),
		variable: 'color',
		type: 'color'
	},

	...typographyOption({
		id: `${prefix}_cardMetaFont`,
		selector: applyPrefixFor('.entry-card .entry-meta', prefix)
	}),

	[`${prefix}_cardMetaColor`]: [
		{
			selector: applyPrefixFor('.entry-card .entry-meta', prefix),
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor('.entry-card .entry-meta', prefix),
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_cardButtonSimpleTextColor`]: [
		{
			selector: applyPrefixFor(
				'.entry-button[data-type="simple"]',
				prefix
			),
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor(
				'.entry-button[data-type="simple"]',
				prefix
			),
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_cardButtonBackgroundTextColor`]: [
		{
			selector: applyPrefixFor(
				'.entry-button[data-type="background"]',
				prefix
			),
			variable: 'buttonTextInitialColor',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor(
				'.entry-button[data-type="background"]',
				prefix
			),
			variable: 'buttonTextHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_cardButtonOutlineTextColor`]: [
		{
			selector: applyPrefixFor(
				'.entry-button[data-type="outline"]',
				prefix
			),
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor(
				'.entry-button[data-type="outline"]',
				prefix
			),
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_cardButtonColor`]: [
		{
			selector: applyPrefixFor('.entry-button', prefix),
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: applyPrefixFor('.entry-button', prefix),
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_cardBackground`]: {
		selector: applyPrefixFor('[data-cards="boxed"] .entry-card', prefix),
		variable: 'cardBackground',
		type: 'color'
	},

	[`${prefix}_cardBorder`]: {
		selector: applyPrefixFor('[data-cards="boxed"] .entry-card', prefix),
		variable: 'border',
		type: 'border',
		responsive: true
	},

	[`${prefix}_cardDivider`]: {
		selector: applyPrefixFor('[data-cards="simple"] .entry-card', prefix),
		variable: 'border',
		type: 'border'
	},

	[`${prefix}_entryDivider`]: {
		selector: applyPrefixFor('.entry-card', prefix),
		variable: 'entry-divider',
		type: 'border'
	},

	[`${prefix}_cardsGap`]: {
		selector: applyPrefixFor('.entries', prefix),
		variable: 'cardsGap',
		responsive: true,
		unit: 'px'
	},

	[`${prefix}_card_spacing`]: {
		selector: applyPrefixFor('[data-cards="boxed"] .entry-card', prefix),
		variable: 'cardSpacing',
		responsive: true,
		unit: 'px'
	},

	[`${prefix}_cardRadius`]: {
		selector: applyPrefixFor('[data-cards="boxed"] .entry-card', prefix),
		type: 'spacing',
		variable: 'borderRadius',
		responsive: true
	},

	[`${prefix}_cardShadow`]: {
		selector: applyPrefixFor('[data-cards="boxed"] .entry-card', prefix),
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true
	},

	[`${prefix}_cardThumbRadius`]: {
		selector: applyPrefixFor('.entry-card .ct-image-container', prefix),
		type: 'spacing',
		variable: 'borderRadius',
		responsive: true
	}
})
