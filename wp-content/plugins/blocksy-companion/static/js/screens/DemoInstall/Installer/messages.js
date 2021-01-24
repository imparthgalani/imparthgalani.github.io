import { sprintf, __ } from 'ct-i18n'
import { getNameForPlugin } from '../Wizzard/Plugins'

export const getMessageForAction = (message, stepsDescriptors) => {
	const { action } = message

	if (action === 'complete') {
		return ''
	}

	if (action === 'import_install_child') {
		return __('copying child theme sources', 'blc')
	}

	if (action === 'import_activate_child') {
		return __('activating child theme', 'blc')
	}

	if (action === 'install_plugin') {
		return sprintf(
			__('installing plugin %s', 'blc'),
			getNameForPlugin(message.name) || message.name
		)
	}

	if (action === 'activate_plugin') {
		return sprintf(
			__('activating plugin %s', 'blc'),
			getNameForPlugin(message.name) || message.name
		)
	}

	if (action === 'download_demo_widgets') {
		return __('downloading demo widgets', 'blc')
	}

	if (action === 'apply_demo_widgets') {
		return __('installing demo widgets', 'blc')
	}

	if (action === 'download_demo_options') {
		return __('downloading demo options', 'blc')
	}

	if (action === 'import_mods_images') {
		return __('importing images from customizer', 'blc')
	}

	if (action === 'import_customizer_options') {
		return __('import customizer options', 'blc')
	}

	if (action === 'activate_required_extensions') {
		return __('activating required extensions', 'blc')
	}

	if (action === 'erase_previous_posts') {
		return __('removing previously installed posts', 'blc')
	}

	if (action === 'erase_previous_terms') {
		return __('removing previously installed taxonomies', 'blc')
	}

	if (action === 'erase_default_pages') {
		return __('removing default WordPress pages', 'blc')
	}

	if (action === 'erase_customizer_settings') {
		return __('resetting customizer options', 'blc')
	}

	if (action === 'erase_widgets_data') {
		return __('resetting widgets', 'blc')
	}

	if (action === 'content_installer_progress') {
		if (!message.kind) {
			return ''
		}

		const total =
			stepsDescriptors.content.preliminary_data[`${message.kind}_count`]

		const processed = stepsDescriptors.content[`${message.kind}_count`]

		return `${Math.min(processed, total)} of ${total} ${
			{
				users: __('users', 'blc'),
				term: __('terms', 'blc'),
				media: __('images', 'blc'),
				post: __('posts', 'blc'),
				comment: __('comments', 'blc')
			}[message.kind]
		}`
	}

	return ''
}
