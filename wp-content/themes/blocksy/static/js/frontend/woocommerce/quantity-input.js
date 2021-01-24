import $ from 'jquery'

const listenToClicks = () =>
	[...document.querySelectorAll('.quantity')].map(singleQuantity => {
		if (
			singleQuantity.querySelector('.ct-increase') &&
			!singleQuantity.querySelector('.ct-increase').ctHasListener
		) {
			singleQuantity.querySelector('.ct-increase').ctHasListener = true

			singleQuantity
				.querySelector('.ct-increase')
				.addEventListener('click', e => {
					const input = singleQuantity.querySelector('input')

					const max = input.getAttribute('max')
						? parseInt(input.getAttribute('max'), 0)
						: Infinity

					const properValue = parseInt(input.value, 10) || 0

					input.value = properValue < max ? properValue + 1 : max
					$(input).trigger('change')
				})
		}

		if (
			singleQuantity.querySelector('.ct-decrease') &&
			!singleQuantity.querySelector('.ct-decrease').ctHasListener
		) {
			singleQuantity.querySelector('.ct-decrease').ctHasListener = true
			singleQuantity
				.querySelector('.ct-decrease')
				.addEventListener('click', e => {
					const input = singleQuantity.querySelector('input')

					const min = input.getAttribute('min')
						? parseInt(input.getAttribute('min'), 0)
						: 0

					const properValue = parseInt(input.value, 10) || 0

					input.value = properValue > min ? properValue - 1 : min
					$(input).trigger('change')
				})
		}
	})

export const mount = () => {
	if ($) {
		$(document.body).on('updated_cart_totals', listenToClicks)
	}

	listenToClicks()
}
