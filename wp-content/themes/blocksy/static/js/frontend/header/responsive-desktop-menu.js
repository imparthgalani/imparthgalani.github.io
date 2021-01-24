import ctEvents from 'ct-events'
import { getItemsDistribution } from './get-items-distribution'

const isEligibleForSubmenu = (el) =>
	el.classList.contains('animated-submenu') &&
	(!el.parentNode.classList.contains('menu') ||
		(el.className.indexOf('ct-mega-menu') === -1 &&
			el.parentNode.classList.contains('menu')))

let cacheInfo = {}

export const getCacheFor = (id) => cacheInfo[id]

ctEvents.on('ct:header:update', () => (cacheInfo = {}))

const maybeCreateMoreItemsFor = (nav, onDone) => {
	if (nav.querySelector('.more-items-container')) {
		onDone()
		return
	}

	const moreContainer = document.createElement('li')

	moreContainer.classList.add('menu-item-has-children')
	moreContainer.classList.add('more-items-container')
	moreContainer.classList.add('animated-submenu')
	moreContainer.classList.add('menu-item')

	moreContainer.insertAdjacentHTML(
		'afterbegin',
		`<a href="#">
      ${ct_localizations.more_text}
      <span class="child-indicator">
        <svg width="8" height="8" viewBox="0 0 15 15">
            <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"></path>
        </svg>
      </span>
    </a>
    <ul class="sub-menu"></ul>`
	)

	nav.firstElementChild.appendChild(moreContainer)
	onDone && onDone()
}

const computeItemsWidth = (nav) =>
	Array.from(nav.firstElementChild.children)
		.filter((el) => !el.classList.contains('.more-items-container'))
		.map((el) => {
			const a = el.firstElementChild
			a.innerHTML = `<span>${a.innerHTML}</span>`

			const props = window.getComputedStyle(a, null)

			let actualWidth =
				a.firstElementChild.getBoundingClientRect().width +
				parseInt(props.getPropertyValue('padding-left'), 10) +
				parseInt(props.getPropertyValue('padding-right'), 10) +
				(a.querySelector('.child-indicator') ? 13 : 0)

			a.innerHTML = a.firstElementChild.innerHTML

			return actualWidth
		})

export const mount = (nav) => {
	if (!nav.firstElementChild) {
		return
	}

	if (!cacheInfo[nav.dataset.id]) {
		cacheInfo[nav.dataset.id] = {
			el: nav,
			previousRenderedWidth: null,
			children: [
				...Array.from(nav.firstElementChild.children).filter(
					(el) => !el.classList.contains('more-items-container')
				),

				...(nav.firstElementChild.querySelector('.more-items-container')
					? [
							...nav.firstElementChild.querySelector(
								'.more-items-container .sub-menu'
							).children,
					  ]
					: []),
			],
			itemsWidth: computeItemsWidth(nav),
		}

		nav.dataset.responsive = 'yes'
	}

	if (
		cacheInfo[nav.dataset.id].previousRenderedWidth &&
		cacheInfo[nav.dataset.id].previousRenderedWidth === window.innerWidth
	) {
		return
	}

	cacheInfo[nav.dataset.id].previousRenderedWidth = window.innerWidth

	let { fit, notFit } = getItemsDistribution(nav)

	if (notFit.length === 0) {
		if (nav.querySelector('.more-items-container')) {
			fit.map((el) => {
				nav.firstElementChild.insertBefore(
					el,
					nav.querySelector('.more-items-container')
				)

				Array.from(
					el.querySelectorAll(
						'.menu-item-has-children, .page_item_has_children'
					)
				)
					.filter((el) => !!el.closest('[class*="ct-mega-menu"]'))
					.map((el) => el.classList.remove('animated-submenu'))
			})

			nav.querySelector('.more-items-container').remove()
		}

		resetSubmenus()
		ctEvents.trigger('ct:header:init-popper')

		return
	}

	if (!document.querySelector('header [data-device="desktop"]')) {
		return
	}

	maybeCreateMoreItemsFor(nav, () => {
		notFit.map((el) => {
			nav.querySelector('.more-items-container .sub-menu').appendChild(el)

			el.classList.add('animated-submenu')

			Array.from(
				el.querySelectorAll(
					'.menu-item-has-children, .page_item_has_children'
				)
			).map((el) => el.classList.add('animated-submenu'))
		})

		fit.map((el) => {
			nav.firstElementChild.insertBefore(
				el,
				nav.querySelector('.more-items-container')
			)

			Array.from(
				el.querySelectorAll(
					'.menu-item-has-children, .page_item_has_children'
				)
			)
				.filter((el) => !!el.closest('[class*="ct-mega-menu"]'))
				.map((el) => el.classList.remove('animated-submenu'))
		})

		resetSubmenus()
		ctEvents.trigger('ct:header:init-popper')
	})
}

const resetSubmenus = () => {
	;[
		...document.querySelectorAll(
			'header [data-device="desktop"] [data-id*="menu"] > .menu'
		),
	].map((menu) => {
		menu.hasFirstLevelPoppers = false
		;[...menu.children]
			.filter((el) => el.querySelector('.sub-menu'))
			.filter((el) => isEligibleForSubmenu(el))
			.map((el) => el.querySelector('.sub-menu'))
			.map((menu) => {
				;[...menu.querySelectorAll('[data-submenu]')].map((el) => {
					el.removeAttribute('data-submenu')
				})

				if (menu._popper) {
					menu._popper.destroy()
					menu._popper = null
				}
			})
	})
}
