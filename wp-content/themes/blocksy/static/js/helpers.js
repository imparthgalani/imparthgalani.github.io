import ctEvents from 'ct-events'

const loadSingleEntryPoint = ({
	els = [],
	beforeLoad = el => {},
	events = [],
	forcedEvents = [],
	load,
	mount = ({ mount, el }) => (el ? mount(el) : mount()),
	condition
}) => {
	if (els && {}.toString.call(els) === '[object Function]') {
		els = els()
	}

	const allEls = (Array.isArray(els) ? els : [els]).reduce(
		(a, selector) => [
			...a,
			...(Array.isArray(selector)
				? selector
				: document.querySelectorAll(selector))
		],
		[]
	)

	allEls.map(beforeLoad)

	if (allEls.length === 0) {
		return
	}

	if (
		condition &&
		!condition({
			els
		})
	) {
		return
	}

	load().then(arg =>
		allEls.map(el => {
			mount({ ...arg, el })
		})
	)
}

export const onDocumentLoaded = cb => {
	if (/comp|inter|loaded/.test(document.readyState)) {
		cb()
	} else {
		document.addEventListener('DOMContentLoaded', cb, false)
	}
}

export const handleEntryPoints = (
	mountEntryPoints,
	{ immediate = false, skipEvents = false } = {}
) => {
	mountEntryPoints
		.filter(({ onLoad = true }) => !!onLoad)
		.map(entryPoint => {
			const { onLoad = true } = entryPoint

			if (onLoad && {}.toString.call(onLoad) === '[object Function]') {
				onLoad({
					entryPoint,
					reload: () => loadSingleEntryPoint(entryPoint)
				})
			}
		})

	if (!immediate) {
		onDocumentLoaded(() =>
			mountEntryPoints
				.filter(({ onLoad = true }) => !!onLoad)
				.map(loadSingleEntryPoint)
		)
	} else {
		mountEntryPoints
			.filter(({ onLoad = true }) => !!onLoad)
			.map(loadSingleEntryPoint)
	}

	if (skipEvents) {
		return
	}
	;[
		...new Set(
			mountEntryPoints.reduce(
				(currentEvents, entry) => [
					...currentEvents,
					...(entry.events || []),
					...(entry.forcedEvents || [])
				],
				[]
			)
		)
	].map(distinctEvent =>
		ctEvents.on(distinctEvent, () => {
			mountEntryPoints
				.filter(({ events = [] }) => events.indexOf(distinctEvent) > -1)
				.map(loadSingleEntryPoint)

			mountEntryPoints
				.filter(
					({ forcedEvents = [] }) =>
						forcedEvents.indexOf(distinctEvent) > -1
				)
				.map(entry =>
					loadSingleEntryPoint({
						...entry,
						els: ['body']
					})
				)
		})
	)
}
