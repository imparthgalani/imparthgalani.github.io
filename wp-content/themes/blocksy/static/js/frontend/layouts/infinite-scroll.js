import InfiniteScroll from 'infinite-scroll'
import { watchLayoutContainerForReveal } from '../animated-element'
import ctEvents from 'ct-events'

/**
 * Monkey patch imagesLoaded. We are using here another strategy for detecting
 * images loaded event.
 */
InfiniteScroll.imagesLoaded = (fragment, fn) => fn()
InfiniteScroll.Button.prototype.hide = () => {}

export const mount = (layoutEl, outlayer = null) => {
	let paginationContainer = layoutEl.parentNode.parentNode.querySelector(
		'.ct-pagination'
	)

	if (!paginationContainer) return

	let paginationType = paginationContainer.dataset.pagination

	if (paginationType.indexOf('simple') > -1) return
	if (paginationType.indexOf('next_prev') > -1) return

	if (!paginationContainer.querySelector('.next')) return

	let inf = new InfiniteScroll(layoutEl, {
		checkLastPage: '.next',
		path: '.next',
		append: getAppendSelectorFor(layoutEl),
		outlayer,
		hideNav: paginationContainer.querySelector('nav'),
		button:
			paginationType === 'load_more'
				? paginationContainer.querySelector('.ct-load-more')
				: null,

		scrollThreshold: paginationType === 'infinite_scroll' ? 400 : false,

		onInit() {
			this.on('load', (response) => {
				paginationContainer
					.querySelector('.ct-load-more-helper')
					.classList.remove('ct-loading')

				setTimeout(() => {
					ctEvents.trigger('ct:images:lazyload:update')
					ctEvents.trigger('ct:infinite-scroll:load')
				}, 100)
			})

			this.on('append', () => watchLayoutContainerForReveal(layoutEl))

			this.on('request', () => {
				paginationContainer
					.querySelector('.ct-load-more-helper')
					.classList.add('ct-loading')
			})

			this.on('last', () => {
				paginationContainer.classList.add(
					!paginationContainer.querySelector('.ct-last-page-text')
						? 'ct-last-page-no-info'
						: 'ct-last-page'
				)
			})
		},
	})
}

function getAppendSelectorFor(layoutEl) {
	return layoutEl.classList.contains('products')
		? '#main [data-products] > li'
		: '.entries > article'

	let maybeClosestShortcode = layoutEl.closest('[data-ct="latest-posts"]')

	let prefix = ''

	if (maybeClosestShortcode) {
		prefix = `.${maybeClosestShortcode.classList[0]} `
	}

	return `${prefix}.${
		[...layoutEl.classList].filter((c) => /ct-layout-.*/.test(c))[0]
	} article:not(.ct-ghost-card)`
}
