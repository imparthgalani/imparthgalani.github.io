import { enableBodyScroll, disableBodyScroll } from 'body-scroll-lock'

export var enable = function (el) {
	enableBodyScroll(el, { reserveScrollBarGap: true })
}

export var disable = function (el) {
	disableBodyScroll(el, { reserveScrollBarGap: true })
}
