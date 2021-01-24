import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment,
} from '@wordpress/element'
import ctEvents from 'ct-events'

import Mailchimp from './Mailchimp'

ctEvents.on('ct:extensions:card', ({ CustomComponent, extension }) => {
	if (extension.name !== 'mailchimp') return
	CustomComponent.extension = Mailchimp
})
