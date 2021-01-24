import ctEvents from 'ct-events'

const activateScreen = (
	el,
	{
		// login | register | forgot
		screen = 'login',
	}
) => {
	if (el.querySelector('ul') && el.querySelector(`ul .ct-${screen}`)) {
		el.querySelector('ul .active').classList.remove('active')
		el.querySelector(`ul .ct-${screen}`).classList.add('active')
	}

	el.querySelector('[class*="-form"].active').classList.remove('active')
	el.querySelector(`.ct-${screen}-form`).classList.add('active')

	if (el.querySelector(`.ct-${screen}-form form`)) {
		el.querySelector(`.ct-${screen}-form form`).reset()
	}

	el.querySelector('.ct-account-form').classList.remove('ct-error')

	let maybeMessageContainer = el
		.querySelector(`.ct-${screen}-form`)
		.querySelector('.ct-message')

	if (maybeMessageContainer) {
		maybeMessageContainer.remove()
	}

	let maybeErrorContainer = el
		.querySelector(`.ct-${screen}-form`)
		.querySelector('.ct-errors')

	if (maybeErrorContainer) {
		maybeErrorContainer.remove()
	}
}

const maybeAddErrors = (container, html) => {
	let parser = new DOMParser()
	let doc = parser.parseFromString(html, 'text/html')

	let maybeErrorContainer = container.querySelector('.ct-errors')

	if (maybeErrorContainer) {
		maybeErrorContainer.remove()
	}

	container.closest('.ct-account-form').classList.remove('ct-error')

	let maybeLoginError = doc.querySelector('#login_error')

	if (maybeLoginError) {
		container.insertAdjacentHTML(
			'afterbegin',
			`<div class="ct-errors">${maybeLoginError.innerHTML}</div>`
		)

		requestAnimationFrame(() => {
			container.closest('.ct-account-form').classList.add('ct-error')
		})
	}

	return {
		hasError: !!maybeLoginError,
		doc,
	}
}

const maybeAddMessage = (container, html) => {
	let parser = new DOMParser()
	let doc = parser.parseFromString(html, 'text/html')

	let maybeMessageContainer = container.querySelector('.ct-message')

	if (maybeMessageContainer) {
		maybeMessageContainer.remove()
	}

	let maybeErrorContainer = container.querySelector('.ct-errors')

	if (maybeErrorContainer) {
		maybeErrorContainer.remove()
	}

	let maybeMessage = doc.querySelector('.message')

	container.closest('.ct-account-form').classList.remove('ct-error')

	if (maybeMessage) {
		container.insertAdjacentHTML(
			'afterbegin',
			`<div class="ct-message">${maybeMessage.innerHTML}</div>`
		)
	}

	return { doc }
}

const handleAccountModal = (el) => {
	if (!el) {
		return
	}

	el.addEventListener(
		'click',
		(e) => {
			if (e.target.href && e.target.href.indexOf('lostpassword') > -1) {
				activateScreen(el, { screen: 'forgot-password' })
				e.preventDefault()
			}

			if (
				e.target.href &&
				e.target.href.indexOf('wp-login') > -1 &&
				e.target.href.indexOf('lostpassword') === -1
			) {
				activateScreen(el, { screen: 'login' })
				e.preventDefault()
			}
		},
		true
	)

	let maybeLogin = el.querySelector('[name="loginform"]')
	let maybeRegister = el.querySelector('[name="registerform"]')
	let maybeLostPassword = el.querySelector('[name="lostpasswordform"]')

	if (maybeLogin) {
		maybeLogin.addEventListener('submit', (e) => {
			e.preventDefault()

			if (window.ct_customizer_localizations) {
				return
			}

			fetch(maybeLogin.action, {
				method: maybeLogin.method,
				body: new FormData(maybeLogin),
			})
				.then((response) => response.text())
				.then((html) => {
					const { doc, hasError } = maybeAddErrors(
						maybeLogin.closest('.ct-login-form'),
						html
					)

					if (!hasError) {
						location = maybeLogin.querySelector(
							'[name="redirect_to"]'
						).value
					}
				})
		})
	}

	if (maybeRegister) {
		maybeRegister.addEventListener('submit', (e) => {
			e.preventDefault()

			if (window.ct_customizer_localizations) {
				return
			}

			fetch(maybeRegister.action, {
				method: maybeRegister.method,
				body: new FormData(maybeRegister),
			})
				.then((response) => response.text())
				.then((html) => {
					const { doc, hasError } = maybeAddErrors(
						maybeRegister.closest('.ct-register-form'),
						html
					)

					if (!hasError) {
						maybeAddMessage(
							maybeRegister.closest('.ct-register-form'),
							html
						)
					}
				})
		})
	}

	if (maybeLostPassword) {
		maybeLostPassword.addEventListener('submit', (e) => {
			e.preventDefault()

			if (window.ct_customizer_localizations) {
				return
			}

			fetch(maybeLostPassword.action, {
				method: maybeLostPassword.method,
				body: new FormData(maybeLostPassword),
			})
				.then((response) => response.text())
				.then((html) => {
					const { doc, hasError } = maybeAddErrors(
						maybeLostPassword.closest('.ct-forgot-password-form'),
						html
					)

					if (!hasError) {
						maybeAddMessage(
							maybeLostPassword.closest(
								'.ct-forgot-password-form'
							),
							html
						)
					}
				})
		})
	}

	;['login', 'register', 'forgot-password'].map((screen) => {
		Array.from(el.querySelectorAll(`.ct-${screen}`)).map((itemEl) => {
			itemEl.addEventListener('click', (e) => {
				e.preventDefault()
				activateScreen(el, { screen })
			})
		})
	})
}

export const mountAccount = () => {
	Array.from(document.querySelectorAll('.ct-header-account > a[href]')).map(
		(el) => {
			if (el.hasSearchEventListener) {
				return
			}

			el.hasSearchEventListener = true

			el.addEventListener('click', (e) => {
				try {
					document.querySelector(el.hash)
				} catch (e) {
					return
				}

				activateScreen(document.querySelector(el.hash), {
					screen: 'login',
				})

				ctEvents.trigger('ct:overlay:handle-click', {
					e,
					href: el.hash,
					options: {
						isModal: true,
					},
				})
			})

			if (document.querySelector('#account-modal')) {
				handleAccountModal(document.querySelector('#account-modal'))
			}
		}
	)
}
