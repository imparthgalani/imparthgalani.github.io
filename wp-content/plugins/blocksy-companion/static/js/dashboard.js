import { createElement, Component } from '@wordpress/element'
import * as check from '@wordpress/element'
import ctEvents from 'ct-events'

import { __ } from 'ct-i18n'

import Extensions from './screens/Extensions'
import DemoInstall from './screens/DemoInstall'
import SiteExport from './screens/SiteExport'
import DemoToInstall from './screens/DemoInstall/DemoToInstall'
import OptIn from './screens/OptIn'
import BetaConsent from './components/BetaConsent'

ctEvents.on('ct:dashboard:routes', (r) => {
	r.push({
		Component: () => <Extensions />,
		path: '/extensions',
	})

	if (ctDashboardLocalizations.plugin_data.has_demo_install === 'yes') {
		r.push({
			Component: (props) => <DemoInstall {...props} />,
			path: '/demos',
		})
	}
})

ctEvents.on('ct:dashboard:navigation-links', (r) => {
	if (ctDashboardLocalizations.plugin_data.has_demo_install === 'yes') {
		r.push({
			text: __('Starter Sites', 'blc'),
			path: 'demos',
			getProps: ({ isPartiallyCurrent, isCurrent }) =>
				isPartiallyCurrent
					? {
							'aria-current': 'page',
					  }
					: {},
		})
	}

	r.push({
		text: __('Extensions', 'blc'),
		path: '/extensions',
	})
})

ctEvents.on('ct:dashboard:home:before', (r) => {
	if (!ctDashboardLocalizations.plugin_data.is_anonymous) {
		return
	}

	r.content = <OptIn />
})

ctEvents.on('ct:dashboard:home:after', (r) => {
	if (ctDashboardLocalizations.plugin_data.hide_beta_updates) {
		return
	}

	r.content = <BetaConsent />
})

ctEvents.on('ct:dashboard:heading:after', (r) => {
	if (!ctDashboardLocalizations.plugin_data.is_pro) {
		return
	}

	r.content = <span>PRO</span>
})
