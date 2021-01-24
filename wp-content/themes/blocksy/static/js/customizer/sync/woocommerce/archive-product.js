import { markImagesAsLoaded } from '../../../frontend/lazy-load-helpers'
import {
	getCache,
	getOptionFor,
	getFreshHtmlFor,
	setRatioFor,
	changeTagName,
	checkAndReplace,
	watchOptionsWithPrefix,
} from '../helpers'
import ctEvents from 'ct-events'

checkAndReplace({
	id: 'has_shop_sort',

	parent_selector: '.woo-listing-top',
	selector: '.woocommerce-ordering',
	fragment_id: 'shop-sort',
	whenInserted: () => {
		ctEvents.trigger('ct:custom-select:init')
	},
})

checkAndReplace({
	id: 'has_shop_results_count',

	parent_selector: '.woo-listing-top',
	selector: '.woocommerce-result-count',
	fragment_id: 'shop-results-count',

	strategy: 'maybeBefore:.woocommerce-ordering',
})

export const replaceCards = () => {
	if (!document.querySelector('[data-products]')) {
		return
	}

	;[...document.querySelectorAll('[data-products]')].map((el) => {
		el.classList.add('ct-disable-transitions')
	})
	;[...document.querySelectorAll('[data-products] > *')].map((product) => {
		const productsContainer = product.closest('[data-products]')
		const nextType = productsContainer.dataset.products

		productsContainer.removeAttribute('data-alignment')

		if (nextType === 'type-1') {
			productsContainer.dataset.alignment = getOptionFor(
				'shop_cards_alignment_1'
			)
		}

		const ratio = wp.customize('woocommerce_thumbnail_cropping')()

		setRatioFor(
			ratio === 'uncropped'
				? 'original'
				: ratio === 'custom' || ratio === 'predefined'
				? `${wp.customize(
						'woocommerce_thumbnail_cropping_custom_width'
				  )()}/${wp.customize(
						'woocommerce_thumbnail_cropping_custom_height'
				  )()}`
				: '1/1',
			product.querySelector('.ct-image-container .ct-ratio')
		)
	})
	;[...document.querySelectorAll('[data-products]')].map((el) => {
		el.classList.remove('columns-2', 'columns-3', 'columns-4', 'columns-5')

		el.classList.add(
			`columns-${getOptionFor('woocommerce_catalog_columns')}`
		)
	})

	setTimeout(() => {
		;[...document.querySelectorAll('[data-products]')].map((el) => {
			el.classList.remove('ct-disable-transitions')
		})
	})

	markImagesAsLoaded(document.querySelector('.shop-entries'))
}

watchOptionsWithPrefix({
	getOptionsForPrefix: () => [
		'woocommerce_catalog_columns',
		'woocommerce_thumbnail_cropping',
		'woocommerce_thumbnail_cropping_custom_width',
		'woocommerce_thumbnail_cropping_custom_height',
		'shop_cards_alignment_1',
	],

	events: ['ct:archive-product-replace-cards:perform'],

	render: () => replaceCards(),
})
