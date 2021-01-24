import {
	createElement,
	Fragment,
	Component,
	useState,
	useEffect,
} from '@wordpress/element'
import classnames from 'classnames'
import ResponsiveControls, {
	maybePromoteScalarValueIntoResponsive,
	isOptionEnabledFor,
	getValueForDevice,
	isOptionResponsiveFor,
} from '../customizer/components/responsive-controls'
import deepEqual from 'deep-equal'
import { normalizeCondition, matchValuesWithCondition } from 'match-conditions'
import { __ } from 'ct-i18n'
import { getOptionLabelFor } from './helpers/get-label'
import ctEvents from 'ct-events'

const CORE_OPTIONS_CONTEXT = require.context('./options/', false, /\.js$/)
CORE_OPTIONS_CONTEXT.keys().forEach(CORE_OPTIONS_CONTEXT)

const hasCoreOptionModifier = (type) => {
	let index = CORE_OPTIONS_CONTEXT.keys()
		.map((module) => module.replace(/^\.\//, '').replace(/\.js$/, ''))
		.indexOf(type)

	return index > -1 && CORE_OPTIONS_CONTEXT.keys()[index]
}

export const capitalizeFirstLetter = (str) => {
	str = str == null ? '' : String(str)
	return str.charAt(0).toUpperCase() + str.slice(1)
}

export const getOptionFor = (option) => {
	const dynamicOptionTypes = {}
	ctEvents.trigger('blocksy:options:register', dynamicOptionTypes)

	if (hasCoreOptionModifier(option.type)) {
		return CORE_OPTIONS_CONTEXT(hasCoreOptionModifier(option.type)).default
	}

	if (dynamicOptionTypes[option.type]) {
		return dynamicOptionTypes[option.type]
	}

	return null
}

export const optionWithDefault = ({ option, value }) =>
	value === undefined ? option.value : value

const GenericOptionType = ({
	option,
	value,
	values,
	onChange,
	onChangeFor,
	hasRevertButton,
	id,
	purpose,
}) => {
	const [device, setInnerDevice] = useState(
		wp.customize && wp.customize.previewedDevice
			? wp.customize.previewedDevice()
			: 'desktop'
	)

	const listener = () => {
		setInnerDevice(
			wp.customize && wp.customize.previewedDevice
				? wp.customize.previewedDevice()
				: 'desktop'
		)
	}

	const setDevice = (device) => {
		setInnerDevice(device)
		wp.customize && wp.customize.previewedDevice.set(device)
	}

	useEffect(() => {
		if (option.type !== 'ct-typography') {
			if (!isOptionResponsiveFor(option)) {
				return
			}
		}

		if (!wp.customize) return
		setTimeout(() => wp.customize.previewedDevice.bind(listener), 1000)

		return () => {
			if (option.type !== 'ct-typography') {
				if (!isOptionResponsiveFor(option)) {
					return
				}
			}

			if (!wp.customize) return
			wp.customize.previewedDevice.unbind(listener)
		}
	}, [])

	let OptionComponent = getOptionFor(option)
	let BeforeOptionContent = { content: null, option }

	ctEvents.trigger('blocksy:options:before-option', BeforeOptionContent)

	const globalResponsiveValue = maybePromoteScalarValueIntoResponsive(
		optionWithDefault({ value, option }),
		isOptionResponsiveFor(option)
	)

	const valueWithResponsive = isOptionResponsiveFor(option, {
		ignoreHidden: true,
	})
		? getValueForDevice({ option, value: globalResponsiveValue, device })
		: globalResponsiveValue

	const onChangeWithMobileBridge = (value) => {
		if (option.triggerRefreshOnChange) {
			wp.customize &&
				wp.customize.previewer &&
				wp.customize.previewer.refresh()
		}

		if (
			option.switchDeviceOnChange &&
			wp.customize &&
			wp.customize.previewedDevice() !== option.switchDeviceOnChange
		) {
			wp.customize.previewedDevice.set(option.switchDeviceOnChange)
		}

		if (
			option.sync &&
			(Object.keys(option.sync).length > 0 ||
				Array.isArray(option.sync)) &&
			wp.customize &&
			wp.customize.previewer
		) {
			wp.customize.previewer.send('ct:sync:refresh_partial', {
				id: option.sync.id || option.id,
				option,
			})
		}

		onChange(value)
	}

	const onChangeWithResponsiveBridge = (scalarValue) => {
		const responsiveValue = maybePromoteScalarValueIntoResponsive(
			optionWithDefault({ value, option }),
			isOptionResponsiveFor(option)
		)

		onChangeWithMobileBridge(
			isOptionResponsiveFor(option, { ignoreHidden: true })
				? {
						...responsiveValue,
						[device === 'tablet' &&
						isOptionEnabledFor('tablet', option.responsive) ===
							'skip'
							? 'mobile'
							: device]: scalarValue,
						...(device === 'desktop'
							? Object.keys(responsiveValue).reduce(
									(currentValue, key) => ({
										...currentValue,
										...(key !== 'desktop' &&
										key !== '__changed' &&
										Object.keys(
											maybePromoteScalarValueIntoResponsive(
												option.value
											)
										).reduce(
											(result, key) =>
												result
													? maybePromoteScalarValueIntoResponsive(
															option.value
													  )[key] ===
													  maybePromoteScalarValueIntoResponsive(
															option.value
													  ).desktop
													: false,
											true
										) &&
										(
											responsiveValue.__changed || []
										).indexOf('tablet') === -1
											? {
													[key]: scalarValue,
											  }
											: {}),
									}),
									{}
							  )
							: {}),
						...(device === 'tablet' &&
						isOptionEnabledFor('tablet', option.responsive) !==
							'skip'
							? Object.keys(responsiveValue).reduce(
									(currentValue, key) => ({
										...currentValue,
										...(key !== 'desktop' &&
										key !== 'tablet' &&
										key !== '__changed' &&
										Object.keys(
											maybePromoteScalarValueIntoResponsive(
												option.value
											)
										).reduce(
											(result, key) =>
												result
													? maybePromoteScalarValueIntoResponsive(
															option.value
													  )[key] ===
													  maybePromoteScalarValueIntoResponsive(
															option.value
													  ).desktop
													: false,
											true
										) &&
										(
											responsiveValue.__changed || []
										).indexOf(key) === -1
											? {
													[key]: scalarValue,
											  }
											: {}),
									}),
									{}
							  )
							: {}),
						__changed: [
							...(responsiveValue.__changed || []),
							...(device !== 'desktop' ? [device] : []),
						].filter(
							(value, index, self) =>
								self.indexOf(value) === index
						),
				  }
				: scalarValue
		)
	}

	/**
	 * Handle transparent components
	 */
	if (!OptionComponent) {
		return <div>Unimplemented option: {option.type}</div>
	}

	let renderingConfig = { design: true, label: true, wrapperAttr: {} }
	let LabelToolbar = () => null
	let OptionMetaWrapper = null
	let ControlEnd = () => null
	let sectionClassName = () => ({})

	renderingConfig = {
		...renderingConfig,
		...(OptionComponent.renderingConfig || {}),
	}

	if (option.design) {
		renderingConfig.design = option.design
	}

	if (OptionComponent.LabelToolbar) {
		LabelToolbar = OptionComponent.LabelToolbar
	}

	if (OptionComponent.ControlEnd) {
		ControlEnd = OptionComponent.ControlEnd
	}

	if (OptionComponent.MetaWrapper) {
		OptionMetaWrapper = OptionComponent.MetaWrapper
	}

	if (OptionComponent.sectionClassName) {
		sectionClassName = OptionComponent.sectionClassName
	}

	let OptionComponentWithoutDesign = (
		<Fragment>
			{BeforeOptionContent && BeforeOptionContent.content}
			<OptionComponent
				key={id}
				{...{
					option: {
						...option,
						value: isOptionResponsiveFor(option, {
							ignoreHidden: true,
						})
							? getValueForDevice({
									device,
									option,
									value: maybePromoteScalarValueIntoResponsive(
										option.value || ''
									),
							  })
							: maybePromoteScalarValueIntoResponsive(
									option.value || '',
									isOptionResponsiveFor(option)
							  ),
					},
					value: valueWithResponsive,
					id,
					values,
					onChangeFor,
					device,
					onChange: onChangeWithResponsiveBridge,
				}}
			/>
		</Fragment>
	)

	if (!renderingConfig.design || renderingConfig.design === 'none') {
		return OptionComponentWithoutDesign
	}

	let maybeLabel = getOptionLabelFor({
		id,
		option,
		values,
		renderingConfig,
	})

	let maybeDesc =
		Object.keys(option).indexOf('desc') === -1 ? false : option.desc

	let maybeLink =
		Object.keys(option).indexOf('link') === -1 ? false : option.link || ' '

	const actualDesignType =
		typeof renderingConfig.design === 'boolean'
			? 'block'
			: renderingConfig.design

	if (renderingConfig.design === 'compact') {
		return (
			<section {...(option.sectionAttr || {})}>
				{maybeLabel && <label>{maybeLabel}</label>}

				{((isOptionResponsiveFor(option) &&
					isOptionEnabledFor(device, option.responsive)) ||
					!isOptionResponsiveFor(option)) &&
					OptionComponentWithoutDesign}
				{maybeLink && (
					<a
						dangerouslySetInnerHTML={{
							__html: maybeLink,
						}}
						{...(option.linkAttr || {})}
					/>
				)}
			</section>
		)
	}

	const getActualOption = ({
		wrapperAttr: { className, ...additionalWrapperAttr } = {},
		...props
	} = {}) => (
		<Fragment>
			<div
				className={classnames('ct-control', className, {})}
				data-design={actualDesignType}
				{...(option.divider ? { 'data-divider': option.divider } : {})}
				{...{
					...((isOptionResponsiveFor(option) &&
						!isOptionEnabledFor(device, option.responsive)) ||
					option.state === 'disabled'
						? { 'data-state': 'disabled' }
						: {}),
				}}
				{...{
					...(option.wrapperAttr || {}),
					...additionalWrapperAttr,
				}}>
				<header>
					{maybeLabel && <label>{maybeLabel}</label>}

					{option.type !== 'ct-image-picker' &&
						option.type !== 'ct-layers' &&
						option.type !== 'ct-image-uploader' &&
						option.type !== 'ct-panel' &&
						hasRevertButton &&
						!option.disableRevertButton && (
							<button
								type="button"
								disabled={deepEqual(
									option.value,
									optionWithDefault({ value, option })
								)}
								className="ct-revert"
								onClick={() =>
									onChangeWithMobileBridge(option.value)
								}
							/>
						)}

					<LabelToolbar
						{...{
							option,
							value: valueWithResponsive,
							id,
							onChange: onChangeWithResponsiveBridge,
						}}
					/>

					{isOptionResponsiveFor(option, {
						ignoreHidden: true,
					}) &&
						actualDesignType.indexOf('block') > -1 && (
							<ResponsiveControls
								device={device}
								responsiveDescriptor={option.responsive}
								setDevice={setDevice}
							/>
						)}
				</header>

				{isOptionResponsiveFor(option) &&
					!isOptionEnabledFor(device, option.responsive) && (
						<div className="ct-disabled-notification">
							{option.disabledDeviceMessage ||
								__(
									"Option can't be edited for current device",
									'blocksy'
								)}
						</div>
					)}

				{((isOptionResponsiveFor(option) &&
					isOptionEnabledFor(device, option.responsive)) ||
					!isOptionResponsiveFor(option)) && (
					<Fragment>
						<section
							{...(option.sectionAttr || {})}
							className={classnames(
								{
									'ct-responsive-container':
										isOptionResponsiveFor(option, {
											ignoreHidden: true,
										}) && actualDesignType === 'inline',
								},
								sectionClassName({
									design: actualDesignType,
									option,
								}),
								(option.sectionAttr || {}).class || ''
							)}>
							{isOptionResponsiveFor(option, {
								ignoreHidden: true,
							}) &&
								actualDesignType === 'inline' && (
									<ResponsiveControls
										device={device}
										responsiveDescriptor={option.responsive}
										setDevice={setDevice}
									/>
								)}
							{OptionComponentWithoutDesign}

							{maybeLink && (
								<a
									dangerouslySetInnerHTML={{
										__html: maybeLink,
									}}
									{...(option.linkAttr || {})}
								/>
							)}
						</section>

						<ControlEnd />

						{maybeDesc && (
							<div
								dangerouslySetInnerHTML={{
									__html: maybeDesc,
								}}
								className="ct-option-description"
							/>
						)}
					</Fragment>
				)}
			</div>
		</Fragment>
	)

	return OptionMetaWrapper ? (
		<OptionMetaWrapper
			id={id}
			option={option}
			value={valueWithResponsive}
			onChangeFor={onChangeFor}
			values={values}
			getActualOption={getActualOption}
		/>
	) : (
		getActualOption()
	)
}

export default GenericOptionType
