import { setRatioFor } from '../helpers'
import ctEvents from 'ct-events'

wp.customize('gallery_style', val =>
	val.bind(to => {
		if (!document.body.classList.contains('single-product')) {
			return
		}

		const article = document.querySelector('.product.type-product')

		article.classList.remove('thumbs-left')

		if (to !== 'horizontal' && article.querySelector('.flexy-items')) {
			article.classList.add('thumbs-left')
		}
	})
)

wp.customize('has_product_sticky_summary', val =>
	val.bind(to => {
		if (!document.body.classList.contains('single-product')) {
			return
		}

		const article = document.querySelector('.product.type-product')

		article.classList.remove('sticky-summary')

		if (to !== 'no') {
			article.classList.add('sticky-summary')
		}
	})
)

wp.customize('product_gallery_ratio', val =>
	val.bind(to => {
		if (!document.body.classList.contains('single-product')) {
			return
		}

		const article = document.querySelector('.product.type-product')

		;[
			...article.querySelectorAll(
				'.flexy-items .ct-image-container .ct-ratio, .ct-product-view > .ct-image-container .ct-ratio'
			)
		].map(el => {
			ctEvents.trigger('ct:flexy:update-height')
			setRatioFor(to, el)

			const flexyItems = article.querySelector('.flexy-items')

			if (flexyItems) {
				if (to !== 'original' && flexyItems) {
					flexyItems.removeAttribute('style')
					flexyItems.removeAttribute('data-height')
				} else {
					flexyItems.dataset.height = 'dynamic'
				}
			}
		})
	})
)
