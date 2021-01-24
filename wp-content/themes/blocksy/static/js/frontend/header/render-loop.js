import ctEvents from 'ct-events'
import { getCurrentScreen } from '../helpers/current-screen'

const renderHeader = () => {
	ctEvents.trigger('ct:header:render-frame')

	requestAnimationFrame(renderHeader)
}

export const mountRenderHeaderLoop = () => {
	if (window.wp && wp && wp.customize && wp.customize.selectiveRefresh) {
		wp.customize.selectiveRefresh.bind('partial-content-rendered', (e) => {
			ctEvents.trigger('ct:header:update')
			ctEvents.trigger('ct:header:render-frame')
		})
	}

	requestAnimationFrame(renderHeader)
}

export const updateAndSaveEl = (selector, cb, { isRoot = false } = {}) => {
	if (!isRoot) {
		;[
			...document.querySelectorAll(`header#header ${selector}`),
			...document.querySelectorAll(`#offcanvas ${selector}`),
		].map((el) => cb(el))
	}

	if (isRoot) {
		cb(document.querySelector(`header#header`))
	}
}
