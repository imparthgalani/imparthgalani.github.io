import { onDocumentLoaded, handleEntryPoints } from '../../helpers'

import { mount as mountSingleProductGallery } from './single-product-gallery'
import { mount as mountQuantityInput } from './quantity-input'
import { mount as mountAddToCartSingle } from './add-to-cart-single'
import { mount as mountMiniCart } from './mini-cart'

export const mount = () => {
	handleEntryPoints(
		[
			{
				els: 'body.single-product',
				load: () =>
					new Promise((r) => r({ mount: mountSingleProductGallery })),
				forcedEvents: ['ct:flexy:update'],
			},

			{
				els: '.quantity .ct-increase',
				load: () =>
					new Promise((r) => r({ mount: mountQuantityInput })),
				events: ['ct:add-to-cart:update'],
				forcedEvents: ['ct:add-to-cart:quantity'],
			},

			{
				els: 'body.ct-ajax-add-to-cart',
				load: () =>
					new Promise((r) => r({ mount: mountAddToCartSingle })),
				events: ['ct:add-to-cart:update'],
				forcedEvents: ['ct:flexy:update'],
			},

			{
				els: '.ct-header-cart',
				load: () => new Promise((r) => r({ mount: mountMiniCart })),
				events: ['ct:header:update'],
			},
		],
		{ immediate: true }
	)
}
