import ctEvents from 'ct-events'
import $ from 'jquery'
import { onDocumentLoaded } from '../helpers'
let lz = null

const maybeInit = () => {
	if (lz) {
		lz.update()
		return
	}

	import('vanilla-lazyload').then(({ default: lazyload }) => {
		lz = new lazyload({
			data_src: 'ct-lazy',
			data_srcset: 'ct-lazy-set',

			elements_selector: 'img[data-ct-lazy]',

			callback_load(img) {
				let container = img.closest('[class*="ct-image-container"]')

				let action = () => {
					if (!container) return

					container.classList.remove('ct-lazy')
					container.classList.add('ct-lazy-loading-start')

					requestAnimationFrame(() => {
						container.classList.remove('ct-lazy-loading-start')
						container.classList.add('ct-lazy-loading')

						whenTransitionEnds(container.firstElementChild, () => {
							container.classList.remove('ct-lazy-loading')
							container.classList.add('ct-lazy-loaded')
						})
					})
				}

				if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
					setTimeout(action, 500)
				} else {
					action()
				}
			},
		})
	})
}

onDocumentLoaded(() => {
	if ($) {
		$(window).on('elementor/frontend/init', () => {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/global',
				() => ctEvents.trigger('ct:images:lazyload:update')
			)
		})

		$(document.body).on('ubermenuopen', function () {
			ctEvents.trigger('ct:images:lazyload:update')
		})

		$(window).on('wcpf_update_products', function () {
			ctEvents.trigger('ct:images:lazyload:update')
		})

		$(document).on('wpf_ajax_success', () =>
			ctEvents.trigger('ct:images:lazyload:update')
		)
	}

	if (document.querySelector('img[data-ct-lazy]')) {
		maybeInit()
	}

	ctEvents.on('ct:images:lazyload:update', () => {
		$ && $('body').trigger('jetpack-lazy-images-load')

		if (window.jetpackLazyImagesModule) {
			window.jetpackLazyImagesModule()
		}

		let jetpackEvent = new Event('jetpack-lazy-images-load')
		document.body.dispatchEvent(jetpackEvent)

		maybeInit()
	})
})

function whenTransitionEnds(el, cb) {
	const end = () => {
		el.removeEventListener('transitionend', onEnd)
		cb()
	}

	const onEnd = (e) => {
		if (e.target === el) {
			end()
		}
	}

	el.addEventListener('transitionend', onEnd)
}
