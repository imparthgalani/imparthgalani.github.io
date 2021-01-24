import ctEvents from 'ct-events'
import {
	updateAndSaveEl,
	handleBackgroundOptionFor,
	assembleSelector,
	typographyOption,
	mutateSelector,
	getRootSelectorFor,
	responsiveClassesFor,
} from 'blocksy-customizer-sync'
import { markImagesAsLoaded } from '../../../../extensions/cookies-consent/static/js/lazy-load-helpers'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		variableDescriptors['account'] = ({ itemId }) => ({
			accountHeaderIconSize: {
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '[data-state="out"]',
					})
				),
				variable: 'icon-size',
				responsive: true,
				unit: 'px',
			},

			account_loggedin_icon_size: {
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '[data-state="in"]',
					})
				),
				variable: 'icon-size',
				responsive: true,
				unit: 'px',
			},

			accountHeaderAvatarSize: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),
				variable: 'avatar-size',
				responsive: true,
				unit: 'px',
			},

			...handleBackgroundOptionFor({
				id: 'accountHeaderFormBackground',
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '#account-modal .ct-account-form',
					})
				),
			}),

			...handleBackgroundOptionFor({
				id: 'accountHeaderBackground',
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '#account-modal',
					})
				),
			}),

			cart_panel_shadow: {
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '#account-modal .ct-account-form',
					})
				),
				type: 'box-shadow',
				variable: 'box-shadow',
				responsive: true,
			},

			accountHeaderMargin: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),
				type: 'spacing',
				variable: 'margin',
				responsive: true,
				important: true,
			},

			...typographyOption({
				id: 'account_label_font',
				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '.ct-header-account .ct-label',
					})
				),
			}),

			// default state
			accountHeaderColor: [
				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			// transparent state
			transparentAccountHeaderColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			// sticky state
			stickyAccountHeaderColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],
		})
	}
)

ctEvents.on(
	'ct:header:sync:item:account',
	({ values: { loggedin_style, loggedin_label }, optionId, optionValue }) => {
		const selector = '[data-id="account"]'

		if (optionId === 'account_label_visibility') {
			updateAndSaveEl(selector, (el) => {
				;[...el.querySelectorAll('.ct-label')].map((label) => {
					responsiveClassesFor(optionValue, label)
				})
			})
		}

		if (optionId === 'loggedin_label') {
			updateAndSaveEl(selector, (el) => {
				;[...el.querySelectorAll('.ct-label')].map((label) => {
					label.innerHTML = optionValue
				})
			})
		}

		if (optionId === 'login_label') {
			updateAndSaveEl(selector, (el) => {
				;[...el.querySelectorAll('.ct-label')].map((label) => {
					label.innerHTML = optionValue
				})
			})
		}
	}
)
