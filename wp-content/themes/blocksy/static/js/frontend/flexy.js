import $ from 'jquery'
import { Flexy, adjustContainerHeightFor } from 'flexy'
import { markImagesAsLoaded } from './lazy-load-helpers'
import ctEvents from 'ct-events'

export const mount = (sliderEl) => {
	// sliderEl = sliderEl.parentNode

	if (sliderEl.flexy) {
		return
	}

	markImagesAsLoaded(sliderEl.querySelector('.flexy-items'))

	const inst = new Flexy(sliderEl.querySelector('.flexy-items'), {
		flexyAttributeEl: sliderEl,
		elementsThatDoNotStartDrag: ['.twentytwenty-handle'],
		adjustHeight: !!sliderEl.querySelector('.flexy-items').dataset.height,

		/*
				autoplay:
					Object.keys(
						el.querySelector('.flexy-container').dataset
					).indexOf('autoplay') > -1 &&
					parseInt(
						el.querySelector('.flexy-container').dataset.autoplay,
						10
					)
						? el.querySelector('.flexy-container').dataset.autoplay
						: false,
*/

		pillsContainerSelector: sliderEl.querySelector('.flexy-pills'),
		// leftArrow: sliderEl.querySelector('.flexy-arrow-prev'),
		// rightArrow: sliderEl.querySelector('.flexy-arrow-next'),
		scaleRotateEffect: false,

		onDragStart: (e) => {
			Array.from(
				e.target.closest('.flexy-items').querySelectorAll('.zoomImg')
			).map((img) => {
				$(img).stop().fadeTo(120, 0)
			})
		},

		// viewport | container
		wrapAroundMode:
			sliderEl.dataset.wrap === 'viewport' ? 'viewport' : 'container',

		...(sliderEl.nextElementSibling &&
		sliderEl.nextElementSibling.matches('.flexy-draggable-pills')
			? {
					pillsContainerSelector: sliderEl.nextElementSibling.querySelector(
						'.flexy-items'
					),

					pillsFlexyInstance: sliderEl.nextElementSibling,
			  }
			: {}),
	})

	sliderEl.flexy = inst
}

ctEvents.on('ct:flexy:update-height', () => {
	;[...document.querySelectorAll('.flexy-container')].map((el) => {
		if (!el.flexy) {
			return
		}

		adjustContainerHeightFor(el.flexy)
	})
})
