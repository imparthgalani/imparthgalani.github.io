import {
	getOptionFor,
	watchOptionsWithPrefix,
	responsiveClassesFor
} from './helpers'
import { typographyOption } from './variables/typography'
import { handleBackgroundOptionFor } from './variables/background'
import { renderSingleEntryMeta } from './helpers/entry-meta'
import ctEvents from 'ct-events'

export const getPrefixFor = () => document.body.dataset.prefix

const getMetaSpacingVariables = () =>
	[
		{
			key: 'author_social_channels',
			selector: '.hero-section .author-box-social'
		},
		{
			key: 'custom_description',
			selector: '.hero-section .page-description'
		},
		{
			key: 'custom_title',
			selector: '.hero-section .page-title, .hero-section .ct-author-name'
		},
		{ key: 'breadcrumbs', selector: '.hero-section .ct-breadcrumbs' },
		{ key: 'custom_meta', selector: '.hero-section .entry-meta' },
		{
			second_meta: true,
			key: 'custom_meta',
			selector: '.hero-section .entry-meta[data-id="second"]'
		}
	].map(({ key, selector, second_meta }) => ({
		variable: 'itemSpacing',
		unit: 'px',
		responsive: true,
		selector,
		extractValue: value => {
			let component = value.find(component => component.id === key)

			if (second_meta) {
				let allMeta = value.filter(
					component => component.id === 'custom_meta'
				)

				if (allMeta.length === 2) {
					component = allMeta[1]
				} else {
					return 'CT_CSS_SKIP_RULE'
				}
			}

			return (
				(
					component || {
						hero_item_spacing: 20
					}
				).hero_item_spacing || 20
			)
		}
	}))

const getVariablesForPrefix = prefix => ({
	[`${prefix}_hero_height`]: {
		selector: '.hero-section[data-type="type-2"]',
		variable: 'min-height',
		responsive: true,
		unit: ''
	},

	...typographyOption({
		id: `${prefix}_pageTitleFont`,
		selector: '.entry-header .page-title'
	}),

	[`${prefix}_pageTitleFontColor`]: {
		selector: '.entry-header .page-title',
		variable: 'headingColor',
		type: 'color'
	},

	...typographyOption({
		id: `${prefix}_pageMetaFont`,
		selector: '.entry-header .entry-meta'
	}),

	[`${prefix}_pageMetaFontColor`]: [
		{
			selector: '.entry-header .entry-meta',
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: '.entry-header .entry-meta',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	...typographyOption({
		id: `${prefix}_pageExcerptFont`,
		selector: '.entry-header .page-description'
	}),

	[`${prefix}_pageExcerptColor`]: {
		selector: '.entry-header .page-description',
		variable: 'color',
		type: 'color'
	},

	...typographyOption({
		id: `${prefix}_breadcrumbsFont`,
		selector: '.entry-header .ct-breadcrumbs'
	}),

	[`${prefix}_breadcrumbsFontColor`]: [
		{
			selector: '.entry-header .ct-breadcrumbs',
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: '.entry-header .ct-breadcrumbs',
			variable: 'linkInitialColor',
			type: 'color:initial'
		},

		{
			selector: '.entry-header .ct-breadcrumbs',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_hero_alignment1`]: {
		selector: '.hero-section[data-type="type-1"]',
		variable: 'alignment',
		unit: '',
		responsive: true
	},

	[`${prefix}_hero_margin`]: {
		selector: '.hero-section[data-type="type-1"]',
		variable: 'margin-bottom',
		responsive: true,
		unit: 'px',
	},

	[`${prefix}_hero_alignment2`]: {
		selector: '.hero-section[data-type="type-2"]',
		variable: 'alignment',
		unit: '',
		responsive: true
	},

	[`${prefix}_hero_vertical_alignment`]: {
		selector: '.hero-section[data-type="type-2"]',
		variable: 'vertical-alignment',
		unit: '',
		responsive: true
	},

	[`${prefix}_pageTitleOverlay`]: {
		selector: '.hero-section[data-type="type-2"]',
		variable: 'page-title-overlay',
		type: 'color'
	},

	...handleBackgroundOptionFor({
		id: `${prefix}_pageTitleBackground`,
		selector: '.hero-section[data-type="type-2"]'
	}),

	[`${prefix}_hero_elements`]: getMetaSpacingVariables()
})

export const getHeroVariables = () => getVariablesForPrefix(getPrefixFor())

watchOptionsWithPrefix({
	getPrefix: () => getPrefixFor(),
	getOptionsForPrefix: ({ prefix }) => [
		`${prefix}_hero_structure`,
		`${prefix}_hero_elements`,

		`${prefix}_parallax`
	],

	render: ({ id, prefix }) => {
		if (id === `${prefix}_hero_structure`) {
			const heroStrcture = getOptionFor('hero_structure', getPrefixFor())

			const container = document.querySelector(
				'.hero-section [class*="ct-container"]'
			)

			container.classList.remove('ct-container', 'ct-container-narrow')

			container.classList.add(
				`ct-container${heroStrcture === 'narrow' ? '-narrow' : ''}`
			)
		}

		if (id === `${prefix}_hero_elements`) {
			const heroElements = getOptionFor('hero_elements', prefix)

			const heroElementsContainer = document.querySelector(
				'.hero-section .entry-header'
			)

			heroElements.map(singleLayer => {
				if (singleLayer.id === 'custom_title' && prefix === 'author') {
					let { has_author_avatar, author_avatar_size } = singleLayer

					let image = heroElementsContainer.querySelector(
						'.ct-author-name .ct-image-container-static'
					)

					if (image) {
						const img = image.querySelector('img')

						if (img) {
							img.height = author_avatar_size || '60'
							img.width = author_avatar_size || '60'
							img.style.height = `${author_avatar_size || 60}px`
						}
					}
				}

				if (singleLayer.id === 'custom_description') {
					let description = heroElementsContainer.querySelector(
						'.page-description'
					)

					if (singleLayer.enabled && description) {
						responsiveClassesFor(
							singleLayer.description_visibility,
							description
						)
					}
				}

				if (singleLayer.id === 'custom_meta' && singleLayer.enabled) {
					if (
						prefix === 'single_blog_post' ||
						prefix === 'single_page'
					) {
						const metaElements = singleLayer.meta_elements

						let el = heroElementsContainer.querySelectorAll(
							'.entry-meta'
						)

						if (
							heroElements.filter(
								({ id }) => id === 'custom_meta'
							).length > 1
						) {
							if (
								heroElements
									.filter(({ id }) => id === 'custom_meta')
									.map(({ __id }) => __id)
									.indexOf(singleLayer.__id) === 0
							) {
								el = el[0]
							}

							if (
								heroElements
									.filter(({ id }) => id === 'custom_meta')
									.map(({ __id }) => __id)
									.indexOf(singleLayer.__id) === 1
							) {
								if (el.length > 1) {
									el = el[1]
								}
							}
						} else {
							el = el[0]
						}

						renderSingleEntryMeta({
							el,
							meta_elements: metaElements,
							...singleLayer
						})
					}
				}
			})
		}

		if (id === `${prefix}_parallax`) {
			const type = getOptionFor('hero_section', prefix)

			document.querySelector('.hero-section').dataset.parallax = ''

			if (
				type === 'type-2' &&
				(getOptionFor('page_title_bg_type', prefix) ===
					'custom_image' ||
					getOptionFor('page_title_bg_type', prefix) ===
						'featured_image')
			) {
				const parallaxResult = getOptionFor('parallax', prefix)
				const parallaxOutput = [
					...(parallaxResult.desktop ? ['desktop'] : []),
					...(parallaxResult.tablet ? ['tablet'] : []),
					...(parallaxResult.mobile ? ['mobile'] : [])
				]

				if (
					document.querySelector('.hero-section figure') &&
					parallaxOutput.length > 0
				) {
					document.querySelector(
						'.hero-section'
					).dataset.parallax = parallaxOutput.join(':')
				}
			}

			ctEvents.trigger('blocksy:parallax:init')
		}
	}
})
