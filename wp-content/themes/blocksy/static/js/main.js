import './public-path.js'
import './frontend/lazy-load'
import './frontend/comments'
import { watchLayoutContainerForReveal } from './frontend/animated-element'
import { onDocumentLoaded, handleEntryPoints } from './helpers'
import { mountRenderHeaderLoop } from './frontend/header/render-loop'
import ctEvents from 'ct-events'
import $ from 'jquery'

import { mount as mountSocialButtons } from './frontend/social-buttons'
import { mount as mountBackToTop } from './frontend/back-to-top-link'
import { mount as mountShareBox } from './frontend/share-box'
import { mount as mountResponsiveHeader } from './frontend/header/responsive-desktop-menu'
import { mount as mountMobileMenu } from './frontend/mobile-menu'

export { getCurrentScreen } from './frontend/helpers/current-screen'

export const allFrontendEntryPoints = [
	{
		els: 'body[class*="woocommerce"]',
		load: () => import('./frontend/woocommerce/main'),
	},

	{
		els: '[data-parallax]',
		load: () => import('./frontend/parallax/register-listener'),
		events: ['blocksy:parallax:init'],
	},

	{
		els: '.flexy-container[data-flexy*="no"]',
		load: () => import('./frontend/flexy'),
		events: ['ct:flexy:update'],
	},

	{
		els: '.ct-share-box [data-network]',
		load: () => new Promise((r) => r({ mount: mountSocialButtons })),
	},

	{
		els: [
			...(document.querySelector('.ct-header-cart > .ct-cart-content')
				? ['.ct-header-cart']
				: []),
			'.ct-language-switcher > .ct-active-language',
		],

		load: () => import('./frontend/popper-elements'),
		events: ['ct:popper-elements:update'],
	},

	{
		els: '.ct-back-to-top',
		load: () => new Promise((r) => r({ mount: mountBackToTop })),
		events: ['ct:back-to-top:mount'],
	},

	{
		els: '.ct-share-box[data-type="type-2"]',
		load: () => new Promise((r) => r({ mount: mountShareBox })),
		events: ['ct:single:share-box:update'],
	},

	{
		els: ['.entries[data-layout]', '[data-products].products'],
		condition: () =>
			!!document.querySelector(
				'.ct-pagination:not([data-type="simple"])'
			),
		load: () => import('./frontend/layouts/infinite-scroll'),
		beforeLoad: (el) => watchLayoutContainerForReveal(el),
	},

	{
		els: () => [
			[
				...document.querySelectorAll('.search-form[data-live-results]'),
			].filter(
				(el) =>
					!el.matches(
						'[id="search-modal"] .search-form[data-live-results]'
					) &&
					!el.matches(
						'.ct-sidebar .ct-widget .woocommerce-product-search'
					)
			),
		],
		load: () => import('./frontend/search-implementation'),
		mount: ({ mount, el }) => mount(el, {}),
	},

	{
		els:
			'.ct-sidebar .ct-widget .search-form:not(.woocommerce-product-search)[data-live-results]',
		load: () => import('./frontend/search-implementation'),
	},

	{
		els: '.ct-sidebar .ct-widget .woocommerce-product-search',
		load: () => import('./frontend/search-implementation'),
		mount: ({ mount, el }) => mount(el, {}),
	},

	{
		els: '[id="search-modal"] .search-form[data-live-results]',
		condition: () => !!document.querySelector('header [data-id="search"]'),
		load: () => import('./frontend/search-implementation'),
		mount: ({ mount, el }) => {
			return mount(el, {
				mode: 'modal',
				perPage: 6,
			})
		},
	},

	{
		els: 'header [data-device="desktop"] [data-id*="menu"] > .menu',
		condition: () =>
			!!document.querySelector(
				'header [data-device="desktop"] [data-id*="menu"] .menu-item-has-children'
			),
		load: () => import('./frontend/header/menu'),
		onLoad: false,
		mount: ({ handleFirstLevelForMenu, el }) => {
			handleFirstLevelForMenu(el)
		},
		events: [
			'ct:header:init-popper',
			// ...(window.wp && wp.customize ? ['ct:header:render-frame'] : [])
		],
	},

	{
		els: [
			'header [data-device="desktop"] [data-id*="menu"] > .menu .menu-item-has-children > .sub-menu',
			'header [data-device="desktop"] [data-id*="menu"] > .menu .page_item_has_children > .sub-menu',
		],
		load: () => import('./frontend/header/menu'),
		mount: ({ handleUpdate, el }) => handleUpdate(el),
		onLoad: false,
		events: ['ct:header:init-popper'],
	},

	{
		els:
			'header [data-device="desktop"] [data-id^="menu"][data-responsive]',
		load: () => new Promise((r) => r({ mount: mountResponsiveHeader })),
		events: ['ct:header:render-frame'],
	},

	// TODO: mount this listener on offcanvas open/close
	{
		els: '#offcanvas .child-indicator',
		load: () => new Promise((r) => r({ mount: mountMobileMenu })),
	},

	{
		els: ['.ct-modal-action', '.ct-header-search > a[href]'],

		load: () => import('./frontend/overlay'),
		events: ['ct:header:update'],
	},
]

handleEntryPoints(allFrontendEntryPoints)

const initOverlayTrigger = () => {
	;[
		...document.querySelectorAll('.ct-header-trigger'),
		...document.querySelectorAll('.ct-offcanvas-trigger'),
	].map((menuToggle) => {
		let offcanvas = document.querySelector(menuToggle.hash)

		if (offcanvas) {
			if (!offcanvas.hasListener) {
				offcanvas.hasListener = true

				offcanvas.addEventListener('click', (event) => {
					if (event.target && event.target.matches('a')) {
						const menuToggle = document.querySelector(
							'.ct-header-trigger'
						)

						if (event.target.closest('.woocommerce-mini-cart')) {
							return
						}

						menuToggle && menuToggle.click()
					}
				})
			}
		}

		if (menuToggle && !menuToggle.hasListener) {
			menuToggle.hasListener = true

			menuToggle.addEventListener('click', (event) => {
				event.preventDefault()

				import('./frontend/overlay').then(({ handleClick }) =>
					handleClick(event, {
						container: offcanvas,
					})
				)
			})
		}
	})
}

if ($) {
	$(document.body).on('wc_fragments_refreshed', () => {
		setTimeout(() => {
			initOverlayTrigger()
			ctEvents.trigger('ct:popper-elements:update')
		})
	})

	$(document.body).on('wc_fragments_loaded', () => {
		setTimeout(() => {
			initOverlayTrigger()
			ctEvents.trigger('ct:popper-elements:update')
		})
	})
}

onDocumentLoaded(() => {
	setTimeout(() => document.body.classList.remove('ct-loading'), 1500)

	setTimeout(() => {
		initOverlayTrigger()
	}, 100)

	mountRenderHeaderLoop()

	if (location.hash) {
		let maybeModal = document.querySelector(location.hash)

		if (maybeModal.classList.contains('ct-panel')) {
			let maybeTrigger = document.querySelector(
				`[href*="${location.hash}"]`
			)

			setTimeout(() => {
				maybeTrigger.click()
			}, 300)
		}
	}
})

ctEvents.on('blocksy:frontend:init', () => {
	handleEntryPoints(allFrontendEntryPoints, {
		immediate: true,
		skipEvents: true,
	})

	initOverlayTrigger()
})

ctEvents.on('ct:overlay:handle-click', ({ e, href, options = {} }) => {
	import('./frontend/overlay').then(({ handleClick }) => {
		handleClick(e, {
			container: document.querySelector(href),
			...options,
		})
	})
})

if ($) {
	$(document).on('uael_quick_view_loader_stop', () => {
		ctEvents.trigger('ct:add-to-cart:quantity')
	})

	$(document).on('facetwp-loaded', () => {
		ctEvents.trigger('ct:custom-select:init')
		ctEvents.trigger('ct:images:lazyload:update')
	})
}

export { handleEntryPoints } from './helpers'
