import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment,
} from '@wordpress/element'

import classnames from 'classnames'
import { __, sprintf } from 'ct-i18n'
import ListPicker from './ListPicker'
import Overlay from '../../../../../static/js/helpers/Overlay'
import { Select } from 'blocksy-options'

const EditCredentials = ({
	extension,
	isEditingCredentials,
	setIsEditingCredentials,
	onCredentialsValidated,
}) => {
	const [apiKey, setApiKey] = useState(extension.data.api_key)
	const [listId, setListId] = useState(extension.data.list_id)
	const [isLoading, setIsLoading] = useState(false)
	const [isApiKeyInvalid, makeKeyInvalid] = useState(false)

	const attemptToSaveCredentials = async () => {
		const body = new FormData()

		body.append('api_key', apiKey)
		body.append('list_id', listId)

		body.append('action', 'blocksy_ext_mailchimp_maybe_save_credentials')

		setIsLoading(true)

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body,
			})

			if (response.status === 200) {
				const body = await response.json()

				if (body.success) {
					if (body.data.result !== 'api_key_invalid') {
						onCredentialsValidated()
						makeKeyInvalid(false)
					}
				}
			}

			makeKeyInvalid(true)
		} catch (e) {
			makeKeyInvalid(true)
		}

		await new Promise((r) => setTimeout(() => r(), 1000))

		setIsLoading(false)
	}

	return (
		<Overlay
			items={isEditingCredentials}
			onDismiss={() => setIsEditingCredentials(false)}
			className={'ct-mailchimp-modal'}
			render={() => (
				<div
					className={classnames('ct-modal-content', {
						'ct-key-invalid': isApiKeyInvalid,
					})}>
					<h2>{__('API Credentials', 'blc')}</h2>

					<p
						dangerouslySetInnerHTML={{
							__html: sprintf(
								__(
									'Enter your Mailchimp API credentials in the form below. More info on how to generate an API key can be found %shere%s.',
									'blc'
								),
								'<a target="_blank" href="https://mailchimp.com/help/about-api-keys/">',
								'</a>'
							),
						}}
					/>

					{null && (
						<Fragment>
							<h4>{__('Pick service', 'blc')}</h4>

							<Select
								onChange={(copy) => {}}
								option={{
									placeholder: __(
										'Pick Mailing Service',
										'blocksy'
									),
									choices: [
										{
											key: 'mailchimp',
											value: 'Mailchimp',
										},
									],
								}}
								value={'mailchimp'}
							/>
						</Fragment>
					)}

					<div className="mailchimp-credentials">
						<section>
							<label>{__('API Key', 'blc')}</label>

							<div className="ct-option-input">
								<input
									type="text"
									onChange={({ target: { value } }) =>
										setApiKey(value)
									}
									value={apiKey || ''}
								/>
							</div>
						</section>

						<section>
							<label>{__('List ID', 'blc')}</label>

							<ListPicker
								listId={listId}
								onChange={(id) => setListId(id)}
								apiKey={apiKey}
							/>
						</section>

						<section>
							<label>&nbsp;</label>
							<button
								className="ct-button"
								data-button="blue"
								disabled={!apiKey || !listId || isLoading}
								onClick={() => attemptToSaveCredentials()}>
								{isLoading
									? __('Loading...', 'blc')
									: !extension.__object
									? __('Activate', 'blc')
									: __('Save Settings', 'blc')}
							</button>
						</section>
					</div>
				</div>
			)}
		/>
	)
}

export default EditCredentials
