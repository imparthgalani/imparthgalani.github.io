import ctEvents from 'ct-events'
import cookie from 'js-cookie'
import { onDocumentLoaded } from './helpers'

const initCookies = () => {
	const notification = document.querySelector('.cookie-notification')

	if (!notification) return

	if (cookie.get('blocksy_cookies_consent_accepted')) {
		notification.remove()
		return
	}

	requestAnimationFrame(() => {
		notification.classList.remove('ct-fade-in-start')
		notification.classList.add('ct-fade-in-end')

		whenTransitionEnds(notification, () => {
			notification.classList.remove('ct-fade-in-end')
		})
	})
	;[...notification.querySelectorAll('button')].map((el) => {
		el.addEventListener('click', (e) => {
			e.preventDefault()

			if (el.classList.contains('ct-accept')) {
				const periods = {
					onehour: 36e5,
					oneday: 864e5,
					oneweek: 7 * 864e5,
					onemonth: 31 * 864e5,
					threemonths: 3 * 31 * 864e5,
					sixmonths: 6 * 31 * 864e5,
					oneyear: 365 * 864e5,
					forever: 10000 * 864e5,
				}

				cookie.set('blocksy_cookies_consent_accepted', 'true', {
					expires: new Date(
						new Date() * 1 +
							periods[el.closest('[data-period]').dataset.period]
					),
				})
			}

			notification.classList.add('ct-fade-start')

			requestAnimationFrame(() => {
				notification.classList.remove('ct-fade-start')
				notification.classList.add('ct-fade-end')

				whenTransitionEnds(notification, () => {
					notification.parentNode.removeChild(notification)
				})
			})
		})
	})
}

onDocumentLoaded(() => {
	initCookies()

	ctEvents.on('blocksy:cookies:init', () => {
		initCookies()
	})
})

function whenTransitionEnds(el, cb) {
	setTimeout(() => {
		cb()
	}, 300)
	return

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
