import ctEvents from 'ct-events'

export const handleWidgetAreaVariables = ({ selector }) => ({
	// css here
})

export const handleWidgetAreaOptions = ({
	selector,
	changeDescriptor: { optionId, optionValue, values }
}) => {}

ctEvents.on(
	'ct:footer:sync:collect-variable-descriptors',
	variableDescriptors => {
		variableDescriptors['widget-area-1'] = handleWidgetAreaVariables({
			selector: '[data-column="widget-area-1"]'
		})
	}
)

ctEvents.on('ct:footer:sync:item:widget-area-1', changeDescriptor =>
	handleWidgetAreaOptions({
		selector: '[data-column="widget-area-1"]',
		changeDescriptor
	})
)
