import ctEvents from 'ct-events'
import {
	shortenItemId,
	getOriginalId,
} from '../panels-builder/placements/helpers'

export const assembleSelector = (selector) =>
	Array.isArray(selector) ? selector.join(' ') : selector

export const mutateSelector = (args = {}) => {
	args = {
		selector: null,
		// prefix | suffix | between | replace-last
		operation: 'between',
		to_add: '',
		...args,
	}

	if (args.operation === 'between') {
		let [first, ...rest] = args.selector
		return [first, args.to_add, ...rest]
	}

	if (args.operation === 'el-prefix' && args.selector.length > 1) {
		let [first, second, ...rest] = args.selector

		return [first, `${args.to_add}${second}`, ...rest]
	}

	if (args.operation === 'container-suffix') {
		let [first, ...rest] = args.selector

		return [`${first}${args.to_add}`, ...rest]
	}

	if (args.operation === 'suffix') {
		return [...args.selector, args.to_add]
	}

	if (args.operation === 'prefix') {
		return [args.to_add, ...args.selector]
	}

	if (args.operation === 'replace-last') {
		let last = args.selector.pop()
		return [...args.selector, args.to_add]
	}

	return args.selector
}

export const getColumnSelectorFor = (args = {}) => {
	args = {
		itemId: null,
		...args,
	}

	let result = getOriginalId(args.itemId)

	if (getOriginalId(args.itemId) !== shortenItemId(args.itemId)) {
		result = `${result}:${shortenItemId(args.itemId)}`
	}

	console.log('here', { result })

	return `[data-column="${result}"]`
}

export const getRootSelectorFor = (args = {}) => {
	args = {
		// header | footer
		panelType: 'header',
		itemId: null,
		...args,
	}

	let selector = ''

	if (args.itemId) {
		selector = `[data-id="${args.itemId}"]`

		if (['middle-row', 'top-row', 'bottom-row'].indexOf(args.itemId) > -1) {
			selector = `[data-row="${args.itemId.replace('-row', '')}"]`
		}

		if (args.itemId === 'socials') {
			selector = `${selector}.ct-${args.panelType}-socials`
		}

		if (args.itemId === 'offcanvas') {
			selector = '#offcanvas'
		}
	}

	let section = document.querySelector(
		args.panelType === 'header' ? 'header#header' : 'footer.ct-footer'
	)

	let header_prefix = `[data-${args.panelType}*="${
		section ? section.dataset.id || 'type-1' : 'type-1'
	}"]`

	if (
		args.itemId &&
		[
			'middle-row',
			'top-row',
			'bottom-row',
			'menu',
			'menu-secondary',
			'menu-tertiary',
			'logo',
			'language-switcher',
			'button',
			'text',
			'search-input',
		].indexOf(args.itemId) > -1
	) {
		if (args.panelType === 'header') {
			header_prefix = `${header_prefix} .ct-header`
		}

		if (args.panelType === 'footer') {
			header_prefix = `${header_prefix} footer.ct-footer`
		}
	}

	if (!selector) {
		return [header_prefix]
	}

	return [header_prefix, selector]
}

export const applyPrefixFor = (selector, prefix) => {
	if (prefix && prefix.length > 0) {
		return `[data-prefix="${prefix}"] ${selector}`
	}

	return selector
}

export const getPrefixFor = ({
	allowed_prefixes = null,
	default_prefix = null,
} = {}) => {
	let actualPrefix = document.body.dataset.prefix

	if (
		allowed_prefixes &&
		actualPrefix.indexOf('_archive') === -1 &&
		allowed_prefixes.indexOf(actualPrefix) === -1
	) {
		actualPrefix = default_prefix
	}

	return actualPrefix
}

export const maybeInsertBefore = ({ el, selector, destination }) => {
	if (destination.querySelector(selector)) {
		destination.insertBefore(el, destination.querySelector(selector))
	} else {
		destination.appendChild(el)
	}
}

export const withKeys = (keys, descriptor) =>
	keys.reduce(
		(result, currentKey) => ({
			...result,
			[currentKey]: descriptor,
		}),
		{}
	)

export const setRatioFor = (ratio, el) => {
	let imgEl = el.parentNode.querySelector('[width]')

	let thumb_ratio =
		ratio === 'original'
			? imgEl
				? [
						imgEl.parentNode.dataset.w
							? parseInt(imgEl.parentNode.dataset.w)
							: imgEl.width,
						imgEl.parentNode.dataset.h
							? parseInt(imgEl.parentNode.dataset.h)
							: imgEl.height,
				  ]
				: [1, 1]
			: (ratio || '4/3').split(
					(ratio || '4/3').indexOf('/') > -1 ? '/' : ':'
			  )

	el.style.paddingBottom = `${Math.round(
		(parseFloat(thumb_ratio[1]) / parseFloat(thumb_ratio[0])) * 100
	)}%`
}

export function changeTagName(node, name) {
	var renamed = document.createElement(name)

	;[...node.attributes].map(({ name, value }) => {
		renamed.setAttribute(name, value)
	})

	while (node.firstChild) {
		renamed.appendChild(node.firstChild)
	}

	return node.parentNode.replaceChild(renamed, node)
}

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

	const newHtml = cache.querySelector(
		`.ct-customizer-preview-cache [data-${attr}="${id}"]`
	).innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml

	return e
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
		beforeInsert: (el) => {},
		watch: [],

		onChange: null,

		...args,
	}

	const render = () => {
		const to = wp.customize(args.id)()

		if (args.strategy === 'hide') {
			Array.from(
				document.querySelectorAll(
					`${args.parent_selector} ${args.selector}`
				)
			).map((el) => {
				el.removeAttribute('data-customize-hide')

				if (to !== 'yes') {
					el.dataset.customizeHide = ''
				}
			})
			return
		}

		const parent = document.querySelector(args.parent_selector)
		;[
			...document.querySelectorAll(
				`${args.parent_selector} ${args.selector}`
			),
		].map((el) => el.parentNode.removeChild(el))

		if (to !== 'yes') return

		const el = getFreshHtmlFor(args.fragment_id)

		while (el.firstElementChild) {
			args.beforeInsert(el.firstElementChild)

			if (args.strategy === 'append') {
				parent.appendChild(el.firstElementChild)
			}

			if (args.strategy === 'firstChild') {
				parent.insertBefore(
					el.firstElementChild,
					parent.firstElementChild
				)
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

	wp.customize(args.id, (val) => val.bind((to) => render()))
	args.watch.map((opt) =>
		wp.customize(opt, (val) => val.bind(() => render()))
	)
}

export const getOptionFor = (key, prefix = '') => {
	const id = `${prefix}${prefix.length > 0 ? '_' : ''}${key}`

	if (wp.customize(id)) {
		return wp.customize(id)()
	}

	return false
}

export const watchOptionsWithPrefix = (args = {}) => {
	const {
		getPrefix = getPrefixFor,
		getOptionsForPrefix = ({ prefix }) => [],
		render = () => {},
		events = [],
	} = args

	let prefix = getPrefix()

	events.map((evt) => ctEvents.on(evt, () => render({ prefix })))

	getOptionsForPrefix({ prefix }).map((id) =>
		wp.customize(id, (val) => val.bind((to) => render({ prefix, id })))
	)
}

export const handleResponsiveSwitch = ({
	selector,
	variable = 'visibility',
	on = 'block',
	off = 'none',
}) => ({
	selector,
	variable,
	responsive: true,
	extractValue: ({ mobile, tablet, desktop }) => ({
		mobile: mobile ? on : off,
		tablet: tablet ? on : off,
		desktop: desktop ? on : off,
	}),
})

export const isVisibleFor = (data) => data.mobile || data.tablet || data.desktop

export const responsiveClassesFor = (data, el) => {
	el.classList.remove('ct-hidden-sm', 'ct-hidden-md', 'ct-hidden-lg')

	if (typeof data !== 'object') {
		if (!wp.customize(data)) return

		data = wp.customize(data)() || {
			mobile: false,
			tablet: true,
			desktop: true,
		}
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

export const replaceFirstTextNode = (el, newText) => {
	let textNode = [...el.childNodes].find(
		(elm) => elm.nodeType != 1 && elm.textContent.trim().length !== 0
	)

	if (!textNode) {
		el.insertAdjacentText('afterbegin', newText)
		return
	}

	textNode.textContent = `${newText}${String.fromCharCode(160)}`
}

export const disableTransitionsStart = (el) => {
	Array.from(el).map((el) => {
		el.classList.add('ct-disable-transitions')
	})
}

export const disableTransitionsEnd = (el) => {
	setTimeout(() => {
		Array.from(el).map((el) => {
			el.classList.remove('ct-disable-transitions')
		})
	}, 50)
}
