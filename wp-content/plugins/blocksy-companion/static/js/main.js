import ctEvents from 'ct-events'
import { mountAccount } from './frontend/account'
import { mountStickyHeader } from './frontend/sticky'

export const onDocumentLoaded = (cb) => {
	if (/comp|inter|loaded/.test(document.readyState)) {
		cb()
	} else {
		document.addEventListener('DOMContentLoaded', cb, false)
	}
}

onDocumentLoaded(() => {
	mountAccount()
	mountStickyHeader()
})

ctEvents.on('blocksy:frontend:init', () => {
	mountAccount()
	mountStickyHeader()
})
