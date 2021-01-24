import { onDocumentLoaded } from '../../../cookies-consent/static/js/helpers'

onDocumentLoaded(() => {
	;[
		...document.querySelectorAll(
			'.ct-mailchimp-widget-form, .ct-mailchimp-block-form'
		),
	].map((el) => {
		if (el.matches('[data-skip-submit]')) {
			return
		}

		el.addEventListener('submit', (e) => {
			e.preventDefault()
			const form = e.target

			if (!form.querySelector('[type="email"]').value.trim()) {
				return
			}

			// Check for spam
			if (
				document.getElementById('js-validate-robot') &&
				document.getElementById('js-validate-robot').value !== ''
			) {
				return false
			}

			// Get url for mailchimp
			var url = form.action.replace('subscribe', 'subscribe/post-json')

			// Add form data to object
			var data = ''

			var callback = 'mailchimpCallback'

			var inputs = form.querySelectorAll('input')

			for (var i = 0; i < inputs.length; i++) {
				data +=
					'&' +
					inputs[i].name +
					'=' +
					encodeURIComponent(inputs[i].value)
			}

			data += `&c=${callback}`

			// Create & add post script to the DOM
			var script = document.createElement('script')
			script.src = url + data

			document.body.appendChild(script)

			form.classList.remove('subscribe-error', 'subscribe-success')
			form.classList.add('subscribe-loading')

			// Callback function
			window[callback] = function (data) {
				// Remove post script from the DOM
				delete window[callback]
				document.body.removeChild(script)

				form.classList.remove('subscribe-loading')

				if (!data) {
					return
				}

				form.classList.add(
					data.result === 'error'
						? 'subscribe-error'
						: 'subscribe-success'
				)

				form.querySelector(
					'.ct-mailchimp-message'
				).innerHTML = data.msg.replace('0 - ', '')
			}
		})
	})
})
