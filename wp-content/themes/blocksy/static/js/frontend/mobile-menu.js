const activateSubMenu = (container) => {
	const subMenu = container.querySelector('ul')

	requestAnimationFrame(() => {
		const actualHeight = subMenu.getBoundingClientRect().height
		subMenu.style.height = '0px'
		subMenu.classList.add('is-animating')

		requestAnimationFrame(() => {
			subMenu.style.height = `${actualHeight}px`

			whenTransitionEnds(subMenu, () => {
				subMenu.classList.remove('is-animating')
				subMenu.removeAttribute('style')
			})
		})
	})
}

const deactivateSubMenu = (container, cb) => {
	const subMenu = container.querySelector('ul')

	requestAnimationFrame(() => {
		const actualHeight = subMenu.getBoundingClientRect().height

		subMenu.style.height = `${actualHeight}px`
		subMenu.classList.add('is-animating')

		requestAnimationFrame(() => {
			subMenu.style.height = '0px'

			whenTransitionEnds(subMenu, () => {
				subMenu.classList.remove('is-animating')
				subMenu.removeAttribute('style')
				cb()
			})
		})
	})
}

const handleContainer = (container) => {
	if (!container) {
		return
	}

	if (container.classList.contains('current-menu-active')) {
		deactivateSubMenu(container, () => {
			container.classList.toggle('current-menu-active')
			;[
				...container.querySelectorAll(
					'.menu-item-has-children.current-menu-active, .page_item_has_children.current-menu-active'
				),
			].map((el) => el.classList.remove('current-menu-active'))
		})
	} else {
		;[...container.parentNode.children].map(
			(el) =>
				el.classList.contains('current-menu-active') &&
				handleContainer(el)
		)

		container.classList.toggle('current-menu-active')
		activateSubMenu(container)
	}
}

export const mount = (arrow) => {
	if (arrow.hasListener) {
		return
	}

	arrow.hasListener = true

	let parentHref = arrow.parentNode.getAttribute('href')

	if (!parentHref || parentHref === '#') {
		arrow.parentNode.addEventListener('click', (e) => {
			e.preventDefault()
			e.stopPropagation()

			handleContainer(
				arrow.closest(
					'.menu-item-has-children, .page_item_has_children'
				)
			)
		})
	}

	arrow.addEventListener('click', (e) => {
		e.preventDefault()
		e.stopPropagation()

		handleContainer(
			arrow.closest('.menu-item-has-children, .page_item_has_children')
		)
	})
}

function whenTransitionEnds(el, cb) {
	const end = () => {
		el.removeEventListener('transitionend', onEnd)
		cb()
	}

	const onEnd = (e) => {
		if (e.target === el) {
			end()
		}
	}

	el.addEventListener('transitionend', onEnd)
}
