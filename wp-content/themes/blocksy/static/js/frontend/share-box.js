function isTouchDevice() {
	try {
		document.createEvent('TouchEvent')
		return true
	} catch (e) {
		return false
	}
}

const render = () => {
	const shareBox = document.querySelector('.ct-share-box[data-type="type-2"]')

	if (!shareBox) {
		return
	}

	const entryContent = document
		.querySelector('.site-main article[id*="post"] .entry-content')
		.getBoundingClientRect()

	const upperThanMiddle = entryContent.top < innerHeight / 2
	const bottomIntersectsTopEdge = entryContent.bottom <= 0

	shareBox.classList[
		upperThanMiddle && !bottomIntersectsTopEdge ? 'add' : 'remove'
	]('ct-visible')
}

export const mount = () => {
	render()
	document.addEventListener('scroll', () => render())

	const shareBox = document.querySelector('.ct-share-box[data-type="type-2"]')

	if (!shareBox) {
		return
	}

	if (isTouchDevice()) {
		shareBox.parentNode
			.querySelector('.ct-share-box > span')
			.addEventListener('click', (e) => {
				shareBox.classList.toggle('active')
				e.stopPropagation()
			})

		document.body.addEventListener('click', (e) => {
			shareBox.classList.remove('active')
		})
	} else {
		shareBox.addEventListener('mouseenter', (e) => {
			shareBox.classList.toggle('active')
		})

		shareBox.addEventListener('mouseleave', (e) => {
			shareBox.classList.toggle('active')
		})
	}
}
