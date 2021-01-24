export const getCache = () => {
	const div = document.createElement('div')

	div.innerHTML = document.querySelector(
		'.ct-customizer-preview-cache-container'
	).value

	return div
}

export const getFreshHtmlFor = (id, cache = null, attr = 'id') => {
	if (!cache) {
		cache = getCache()
	}

	if (
		!cache.querySelector(
			`.ct-customizer-preview-cache [data-${attr}="${id}"]`
		)
	) {
		return
	}

	const newHtml = cache.querySelector(
		`.ct-customizer-preview-cache [data-${attr}="${id}"]`
	).innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml

	return e
}

export const renderWithStrategy = (args = {}) => {
	args = {
		fragment_id: null,

		selector: null,
		parent_selector: null,

		// append | firstChild | maybeBefore:selector
		strategy: 'append',
		whenInserted: () => {},
		beforeInsert: el => {},

		should_insert: true,

		...args
	}

	const parent = document.querySelector(args.parent_selector)
	;[
		...document.querySelectorAll(`${args.parent_selector} ${args.selector}`)
	].map(el => el.parentNode.removeChild(el))

	if (!args.should_insert) return

	const el = getFreshHtmlFor(args.fragment_id)

	if (!el) {
		return
	}

	while (el.firstElementChild) {
		args.beforeInsert(el.firstElementChild)

		if (args.strategy === 'append') {
			parent.appendChild(el.firstElementChild)
		}

		if (args.strategy === 'firstChild') {
			parent.insertBefore(el.firstElementChild, parent.firstElementChild)
		}

		if (args.strategy.indexOf('maybeBefore') > -1) {
			const [_, selector] = args.strategy.split(':')

			if (parent.querySelector(selector)) {
				parent.insertBefore(
					el.firstElementChild,
					parent.querySelector(selector)
				)
			} else {
				parent.appendChild(el.firstElementChild)
			}
		}
	}

	args.whenInserted()
}

export const checkAndReplace = (args = {}) => {
	args = {
		id: null,

		fragment_id: null,

		selector: null,
		parent_selector: null,

		// append | firstChild | maybeBefore:selector
		strategy: 'append',
		whenInserted: () => {},
		beforeInsert: el => {},
		watch: [],

		...args
	}

	const render = () => {
		const to = wp.customize(args.id)()

		renderWithStrategy({
			...args,
			should_insert: to === 'yes'
		})
	}

	wp.customize(args.id, val => val.bind(to => render()))
	args.watch.map(opt => wp.customize(opt, val => val.bind(() => render())))
}

export const responsiveClassesFor = (id, el) => {
	el.classList.remove('ct-hidden-sm', 'ct-hidden-md', 'ct-hidden-lg')

	if (!wp.customize(id)) return

	const data = wp.customize(id)() || {
		mobile: false,
		tablet: true,
		desktop: true
	}

	if (!data.mobile) {
		el.classList.add('ct-hidden-sm')
	}

	if (!data.tablet) {
		el.classList.add('ct-hidden-md')
	}

	if (!data.desktop) {
		el.classList.add('ct-hidden-lg')
	}
}
