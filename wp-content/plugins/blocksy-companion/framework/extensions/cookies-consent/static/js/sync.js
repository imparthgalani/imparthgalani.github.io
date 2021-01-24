import './variables'
import ctEvents from 'ct-events'

import { renderWithStrategy } from './sync/helpers'

const maybeAnimateCookiesConsent = cb => {
	if (document.querySelector('.cookie-notification')) return

	renderWithStrategy({
		fragment_id: 'blocksy-cookies-consent-section',
		selector: '.cookie-notification',
		parent_selector: '#main-container'
	})

	return true
}

const render = () => {
	const didInsert = maybeAnimateCookiesConsent()

	const notification = document.querySelector('.cookie-notification')

	if (!notification) {
		return
	}

	if (notification.querySelector('.ct-cookies-content')) {
		notification.querySelector(
			'.ct-cookies-content'
		).innerHTML = wp.customize('cookie_consent_content')()
	}

	notification.querySelector('button.ct-accept').innerHTML = wp.customize(
		'cookie_consent_button_text'
	)()

	const type = wp.customize('cookie_consent_type')()

	notification.dataset.type = type

	notification.firstElementChild.classList.remove('ct-container', 'container')
	notification.firstElementChild.classList.add(
		type === 'type-1' ? 'container' : 'ct-container'
	)

	if (didInsert) {
		setTimeout(() => ctEvents.trigger('blocksy:cookies:init'))
	}
}

wp.customize('cookie_consent_content', val =>
	val.bind(to => {
		render()
	})
)
wp.customize('cookie_consent_button_text', val => val.bind(to => render()))
wp.customize('cookie_consent_type', val => val.bind(to => render()))

wp.customize('forms_cookie_consent_content', val =>
	val.bind(to =>
		[...document.querySelectorAll('.gdpr-confirm-policy label')].map(
			el => (el.innerHTML = to)
		)
	)
)
