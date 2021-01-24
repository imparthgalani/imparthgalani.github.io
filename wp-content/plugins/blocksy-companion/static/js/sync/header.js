import ctEvents from 'ct-events'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		/*
		const handleBackgroundOptionForSpecific = id =>
			handleBackgroundOptionFor({
				id,
				selector: 'header',
				addToDescriptors: {
					fullValue: true
				},
				responsive: true,
				valueExtractor: ({
					is_absolute,
					headerBackground,
					absoluteHeaderBackground
				}) =>
					is_absolute === 'yes'
						? absoluteHeaderBackground
						: headerBackground
			})

		variableDescriptors['global'] = {
			...handleBackgroundOptionForSpecific('is_absolute'),
			...handleBackgroundOptionForSpecific('headerBackground'),
			...handleBackgroundOptionForSpecific('absoluteHeaderBackground')
		}

		variableDescriptors['global'] = {
			...handleBackgroundOptionForSpecific('is_absolute'),
			...handleBackgroundOptionForSpecific('headerBackground'),
			...handleBackgroundOptionForSpecific('absoluteHeaderBackground')
		}
        */
	}
)

ctEvents.on(
	'ct:header:sync:item:global',
	({ optionId, optionValue, values }) => {
		if (
			optionId === 'has_sticky_header' ||
			optionId === 'sticky_rows' ||
			optionId === 'sticky_behaviour'
		) {
			const { has_sticky_header, sticky_rows, sticky_behaviour } = values

			Array.from(document.querySelectorAll('[data-sticky]')).map(
				(row) => {
					row.removeAttribute('data-sticky')
				}
			)

			if (has_sticky_header === 'yes') {
				Array.from(document.querySelectorAll('[data-row]')).map(
					(row) => {
						let rowType = row.dataset.row

						if (!sticky_rows[rowType]) {
							return
						}

						let stickyResult = []

						if (sticky_behaviour.desktop) {
							stickyResult.push('desktop')
						}

						if (sticky_behaviour.mobile) {
							stickyResult.push('mobile')
						}

						row.dataset.sticky = stickyResult.join(':')
					}
				)
			}

			ctEvents.trigger('blocksy:frontend:init')
		}

		if (optionId === 'transparent_behaviour') {
			if (!document.querySelector('[data-transparent]')) {
				return
			}

			Array.from(document.querySelectorAll('[data-device]')).map(
				(device) => {
					device.removeAttribute('data-transparent')
					Array.from(
						device.querySelectorAll('[data-row]')
					).map((el) => el.removeAttribute('data-transparent-row'))

					if (optionValue[device.dataset.device]) {
						device.dataset.transparent = ''

						Array.from(device.querySelectorAll('[data-row]')).map(
							(el) => (el.dataset.transparentRow = 'yes')
						)
					}

					ctEvents.trigger('blocksy:frontend:init')
				}
			)
		}
	}
)
