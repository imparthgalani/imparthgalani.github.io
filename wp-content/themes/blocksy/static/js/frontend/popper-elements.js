import Popper from 'popper.js'

export const mount = (reference) => {
	if (!reference.nextElementSibling) {
		return
	}

	if (reference.hasPoppers) {
		reference.hasPoppers.scheduleUpdate()
		return
	}

	reference.hasPoppers = new Popper(reference, reference.nextElementSibling, {
		modifiers: {
			applyStyle: { enabled: false },
			setCustomStyle: {
				enabled: true,
				order: 100000000,
				fn: ({
					flipped,
					instance,
					instance: { reference, popper },
					popper: { left },
					placement,
					styles,
				}) =>
					(popper.dataset.placement =
						placement === 'left' ? 'left' : 'right'),
			},
		},
		placement: 'right',
	})
}
