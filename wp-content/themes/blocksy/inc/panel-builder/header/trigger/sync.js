import ctEvents from 'ct-events'
import { updateAndSaveEl } from '../../../../static/js/frontend/header/render-loop'
import {
	getRootSelectorFor,
	assembleSelector,
	mutateSelector,
} from '../../../../static/js/customizer/sync/helpers'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		variableDescriptors['trigger'] = ({ itemId }) => ({
			triggerMargin: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),

				type: 'spacing',
				variable: 'margin',
				responsive: true,
				important: true,
			},

			// default state
			triggerIconColor: [
				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'color',
					type: 'color:default',
				},

				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'colorHover',
					type: 'color:hover',
				},
			],

			triggerSecondColor: [
				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'secondColor',
					type: 'color:default',
				},

				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'secondColorHover',
					type: 'color:hover',
				},
			],

			// transparent state
			transparentTriggerIconColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'color',
					type: 'color:default',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'colorHover',
					type: 'color:hover',
				},
			],

			transparentTriggerSecondColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'secondColor',
					type: 'color:default',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'secondColorHover',
					type: 'color:hover',
				},
			],

			// sticky state
			stickyTriggerIconColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'color',
					type: 'color:default',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'colorHover',
					type: 'color:hover',
				},
			],

			stickyTriggerSecondColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'secondColor',
					type: 'color:default',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'secondColorHover',
					type: 'color:hover',
				},
			],
		})
	}
)

ctEvents.on(
	'ct:header:sync:item:trigger',
	({ optionId, optionValue, values }) => {
		const selector = '[data-id="trigger"]'

		if (optionId === 'mobile_menu_trigger_type') {
			updateAndSaveEl(
				selector,
				(el) =>
					(el.querySelector('.ct-trigger').dataset.type = optionValue)
			)
		}

		updateAndSaveEl(selector, (el) => {
			let label = el.querySelector('.ct-label')

			label.innerHTML = values.trigger_label

			label.removeAttribute('hidden')

			if (values.has_trigger_label !== 'yes') {
				label.hidden = true
			}

			el.dataset.design = `${values.trigger_design || 'simple'}${
				values.has_trigger_label === 'yes'
					? `:${values.trigger_label_alignment || 'right'}`
					: ''
			}`
		})
	}
)
