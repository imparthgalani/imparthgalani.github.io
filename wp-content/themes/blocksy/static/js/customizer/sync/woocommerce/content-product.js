import { getCache, getFreshHtmlFor, checkAndReplace } from '../helpers'

wp.customize('gallery_style', (val) =>
	val.bind((to) => {
		const product = document.querySelector('.product')
		if (!product) return

		product.classList.remove('thumbs-left')

		if (
			to !== 'horizontal' &&
			document.querySelector('.woocommerce-product-gallery__wrapper') &&
			document.querySelector('.woocommerce-product-gallery__wrapper')
				.children.length > 1
		) {
			product.classList.add('thumbs-left')
		}
	})
)
