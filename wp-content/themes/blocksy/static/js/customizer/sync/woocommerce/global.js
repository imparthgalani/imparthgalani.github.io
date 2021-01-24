wp.customize('sale_badge_shape', val =>
	val.bind(to => {
		Array.from(document.querySelectorAll('.onsale')).map(el => {
			el.dataset.shape = to
		})
	})
)

wp.customize('store_notice_position', val =>
	val.bind(to => {
		if (!document.querySelector('.woocommerce-store-notice')) {
			return
		}

		document.querySelector(
			'.woocommerce-store-notice'
		).dataset.position = to
	})
)
