import { typographyOption } from '../../../../static/js/customizer/sync/variables/typography'
import ctEvents from 'ct-events'
import { updateAndSaveEl } from '../../../../static/js/frontend/header/render-loop'
import { responsiveClassesFor } from '../../../../static/js/customizer/sync/helpers'
import {
	getRootSelectorFor,
	assembleSelector,
	mutateSelector,
} from '../../../../static/js/customizer/sync/helpers'

export const handleMenuVariables = ({ itemId }) => ({
	headerMenuItemsSpacing: {
		selector: assembleSelector(getRootSelectorFor({ itemId })),
		variable: 'menu-items-spacing',
		unit: 'px',
	},

	headerMenuItemsHeight: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '> ul > li > a',
			})
		),
		variable: 'menu-item-height',
		unit: '%',
	},

	...typographyOption({
		id: 'headerMenuFont',

		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '> ul > li > a',
			})
		),
	}),

	dropdownTopOffset: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		variable: 'dropdown-top-offset',
		unit: 'px',
	},

	dropdownMenuWidth: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		variable: 'dropdown-width',
		unit: 'px',
	},

	dropdownItemsSpacing: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		variable: 'dropdown-items-spacing',
		unit: 'px',
	},

	...typographyOption({
		id: 'headerDropdownFont',

		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
	}),

	headerDropdownFontColor: [
		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '.sub-menu',
				})
			),
			variable: 'linkInitialColor',
			type: 'color:default',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '.sub-menu',
				})
			),
			variable: 'linkHoverColor',
			type: 'color:hover',
		},
	],

	headerDropdownBackground: [
		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '.sub-menu',
				})
			),
			variable: 'background-color',
			type: 'color:default',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '.sub-menu',
				})
			),
			variable: 'background-hover-color',
			type: 'color:hover',
		},
	],

	headerDropdownDivider: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		variable: 'dropdown-divider',
		type: 'border',
	},

	headerMenuMargin: {
		selector: assembleSelector(getRootSelectorFor({ itemId })),
		type: 'spacing',
		variable: 'margin',
		responsive: true,
		important: true,
	},

	headerDropdownShadow: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true,
	},

	headerDropdownRadius: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'suffix',
				to_add: '.sub-menu',
			})
		),
		type: 'spacing',
		variable: 'border-radius',
		responsive: true,
	},

	// default state
	menuFontColor: [
		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '> ul > li > a',
				})
			),
			variable: 'linkInitialColor',
			type: 'color:default',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '> ul > li > a',
				})
			),
			variable: 'linkHoverColor',
			type: 'color:hover',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: getRootSelectorFor({ itemId }),
					operation: 'suffix',
					to_add: '> ul > li > a',
				})
			),
			variable: 'colorHoverType3',
			type: 'color:hover-type-3',
		},
	],

	menuIndicatorColor: {
		selector: assembleSelector(getRootSelectorFor({ itemId })),
		variable: 'menu-indicator-active-color',
		type: 'color:active',
		responsive: true,
	},

	// transparent state
	transparentMenuFontColor: [
		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-transparent-row="yes"]',
				})
			),

			variable: 'linkInitialColor',
			type: 'color:default',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-transparent-row="yes"]',
				})
			),

			variable: 'linkHoverColor',
			type: 'color:hover',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-transparent-row="yes"]',
				})
			),

			variable: 'colorHoverType3',
			type: 'color:hover-type-3',
		},
	],

	transparentMenuIndicatorColor: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'between',
				to_add: '[data-transparent-row="yes"]',
			})
		),

		variable: 'menu-indicator-active-color',
		type: 'color:active',
		responsive: true,
	},

	// sticky state
	stickyMenuFontColor: [
		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-sticky*="yes"]',
				})
			),
			variable: 'linkInitialColor',
			type: 'color:default',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-sticky*="yes"]',
				})
			),
			variable: 'linkHoverColor',
			type: 'color:hover',
		},

		{
			selector: assembleSelector(
				mutateSelector({
					selector: mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '> ul > li > a',
					}),
					operation: 'between',
					to_add: '[data-sticky*="yes"]',
				})
			),
			variable: 'colorHoverType3',
			type: 'color:hover-type-3',
		},
	],

	stickyMenuIndicatorColor: {
		selector: assembleSelector(
			mutateSelector({
				selector: getRootSelectorFor({ itemId }),
				operation: 'between',
				to_add: '[data-sticky*="yes"]',
			})
		),
		variable: 'menu-indicator-active-color',
		type: 'color:active',
		responsive: true,
	},
})

export const handleMenuOptions = ({
	selector,
	changeDescriptor: { optionId, optionValue, values },
}) => {
	if (
		optionId === 'header_menu_type' ||
		optionId === 'menu_indicator_effect'
	) {
		updateAndSaveEl(selector, (el) => {
			el.dataset.menu = `${values.header_menu_type}${
				values.header_menu_type === 'type-2'
					? `:${values.menu_indicator_effect}`
					: ``
			}`
		})
	}

	if (optionId === 'headerMenuItemsSpacing') {
		ctEvents.trigger('ct:header:update')
		ctEvents.trigger('ct:header:render-frame')
	}

	if (
		optionId === 'dropdown_animation' ||
		optionId === 'dropdown_items_type'
	) {
		const {
			dropdown_animation = 'type-1',
			dropdown_items_type = 'simple',
		} = values

		updateAndSaveEl(
			selector,
			(el) =>
				(el.dataset.dropdown = `${dropdown_animation}:${dropdown_items_type}`)
		)
	}

	if (optionId === 'stretch_menu') {
		updateAndSaveEl(selector, (el) => {
			el.removeAttribute('data-stretch')

			if (optionValue === 'yes') {
				el.dataset.stretch = ''
			}
		})
	}
}

ctEvents.on('ct:header:sync:item:menu', (changeDescriptor) => {
	const selector = '.header-menu-1'
	handleMenuOptions({ selector, changeDescriptor })
})

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		variableDescriptors['menu'] = handleMenuVariables
	}
)
