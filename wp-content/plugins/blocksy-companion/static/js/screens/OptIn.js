import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'

const OptIn = () => {
	const optinAgain = async () => {
		const body = new FormData()
		body.append('action', 'blocksy_fs_connect_again')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					const div = document.createElement('div')
					div.innerHTML =
						ctDashboardLocalizations.plugin_data.connect_template

					const form = div.querySelector('form')
					document.body.appendChild(form)
					form.submit()
				}
			}
		} catch (e) {}
	}

	return (
		<div className="ct-freemius-optin-message">
			<i>
				<svg
					width="20"
					height="20"
					viewBox="0 0 24 24"
					fill="currentColor"
					stroke="currentColor"
					strokeWidth="2"
					strokeLinecap="round"
					strokeLinejoin="round">
					<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
					<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
				</svg>
			</i>

			<h2>{__('Stay Updated', 'blc')}</h2>

			<p>
				{__(
					'Never miss an important update - opt in to our security & feature updates notifications, and non-sensitive diagnostic tracking.',
					'blc'
				)}
			</p>
			<button
				className="ct-button-primary"
				onClick={e => {
					e.preventDefault()
					optinAgain()
				}}>
				{__('Allow & Continue', 'blc')}
			</button>
		</div>
	)
}

export default OptIn
