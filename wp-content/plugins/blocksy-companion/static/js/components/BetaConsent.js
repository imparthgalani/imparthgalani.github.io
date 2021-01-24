import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { Switch } from 'blocksy-options'

const BetaConsent = () => {
	const [hasConsent, setHasConsent] = useState(
		ctDashboardLocalizations.plugin_data.has_beta_consent
	)

	const [isLoading, setIsLoading] = useState(false)

	const toggleValue = async () => {
		if (isLoading) {
			return
		}

		setHasConsent(hasConsent => !hasConsent)

		setIsLoading(true)

		const body = new FormData()

		body.append('action', 'blocksy_toggle_has_beta_consent')

		const response = await fetch(ctDashboardLocalizations.ajax_url, {
			method: 'POST',
			body
		})

		window.ctDashboardLocalizations.plugin_data.has_beta_consent = !hasConsent

		setIsLoading(false)
	}

	return (
		<div className="ct-beta-consent">
			<h2 onClick={() => toggleValue()}>
				{__('Receive βeta Updates', 'blc')}

				<Switch value={hasConsent ? 'yes' : 'no'} onChange={() => {}} />
			</h2>

			<p>
				{__(
					'Receive beta updates for Blocksy theme and companion and help us test the new versions. Please note that installing beta versions is not recommended on production sites.',
					'blc'
				)}
			</p>
		</div>
	)
}

export default BetaConsent
