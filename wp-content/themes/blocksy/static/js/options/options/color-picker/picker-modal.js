import {
	createElement,
	Component,
	useRef,
	useCallback,
	useMemo,
	createRef,
	Fragment,
} from '@wordpress/element'
import ColorPickerIris from './color-picker-iris.js'
import classnames from 'classnames'
import { __ } from 'ct-i18n'

import { nullifyTransforms } from '../../helpers/usePopoverMaker'

export const getNoColorPropFor = (option) =>
	option.noColorTransparent ? 'transparent' : `CT_CSS_SKIP_RULE`

const focusOrOpenCustomizerSectionProps = (section) => ({
	target: '_blank',
	href: `${
		window.ct_localizations ? window.ct_localizations.customizer_url : ''
	}${encodeURIComponent(`[section]=${section}`)}`,
	...(wp && wp.customize && wp.customize.section
		? {
				onClick: (e) => {
					e.preventDefault()
					wp.customize.section(section).expand()
				},
		  }
		: {}),
})

const getLeftForEl = (modal, el) => {
	if (!modal) return
	if (!el) return

	let style = getComputedStyle(modal)

	let wrapperLeft = parseFloat(style.left)

	el = el.firstElementChild.getBoundingClientRect()

	return {
		'--option-modal-arrow-position': `${
			el.left + el.width / 2 - wrapperLeft - 6
		}px`,
	}
}

const PickerModal = ({
	containerRef,
	el,
	value,
	picker,
	onChange,
	option,
	style,
	wrapperProps = {},
	inline_modal,
	appendToBody,
}) => {
	const getValueForPicker = useMemo(() => {
		if (value.color === getNoColorPropFor(option)) {
			return { color: '', key: 'empty' }
		}

		if (
			value.color.indexOf(getNoColorPropFor(option)) > -1 &&
			picker.inherit
		) {
			return {
				color: 'picker' + picker.inherit,
				key: getComputedStyle(document.documentElement)
					.getPropertyValue(
						picker.inherit.replace(/var\(/, '').replace(/\)/, '')
					)
					.trim()
					.replace(/\s/g, ''),
			}
		}

		if (value.color.indexOf('var') > -1) {
			return {
				key: 'var' + value.color,
				color: getComputedStyle(document.documentElement)
					.getPropertyValue(
						value.color.replace(/var\(/, '').replace(/\)/, '')
					)
					.trim()
					.replace(/\s/g, ''),
			}
		}

		return { key: 'color', color: value.color }
	}, [value, option, picker])

	const arrowLeft = useMemo(
		() =>
			wrapperProps.ref &&
			wrapperProps.ref.current &&
			el &&
			getLeftForEl(wrapperProps.ref.current, el.current),
		[wrapperProps.ref && wrapperProps.ref.current, el && el.current]
	)

	return (
		<Fragment>
			<div
				tabIndex="0"
				className={classnames(
					`ct-color-picker-modal`,
					{
						'ct-option-modal': !inline_modal && appendToBody,
					},
					option.modalClassName
				)}
				style={{
					...arrowLeft,
					...(style ? style : {}),
				}}
				{...wrapperProps}>
				{!option.predefined && (
					<div className="ct-color-picker-top">
						<ul className="ct-color-picker-skins">
							{[
								'paletteColor1',
								'paletteColor2',
								'paletteColor3',
								'paletteColor4',
								'paletteColor5',
							].map((color) => (
								<li
									key={color}
									style={{
										background: `var(--${color})`,
									}}
									className={classnames({
										active:
											value.color === `var(--${color})`,
									})}
									onClick={() =>
										onChange({
											...value,
											color: `var(--${color})`,
										})
									}>
									<div className="ct-tooltip-top">
										{
											{
												paletteColor1: 'Color 1',
												paletteColor2: 'Color 2',
												paletteColor3: 'Color 3',
												paletteColor4: 'Color 4',
												paletteColor5: 'Color 5',
											}[color]
										}
									</div>
								</li>
							))}

							{!option.skipNoColorPill && (
								<li
									onClick={() =>
										onChange({
											...value,
											color: getNoColorPropFor(option),
										})
									}
									className={classnames('ct-no-color-pill', {
										active:
											value.color ===
											getNoColorPropFor(option),
									})}>
									<i className="ct-tooltip-top">
										{__('No Color', 'blocksy')}
									</i>
								</li>
							)}
						</ul>

						{!option.skipEditPalette && (
							<a
								className="ct-edit-palette"
								{...focusOrOpenCustomizerSectionProps('color')}>
								<span>
									<svg viewBox="0 0 30 30">
										<path
											d="M15,0V15L7.5,2Z"
											fill="#ede604"
										/>
										<path
											d="M22.5,2,28,7.5,15,15Z"
											fill="#50b517"
										/>
										<path
											d="M15,0l7.5,2L15,15Z"
											fill="#9ed110"
										/>
										<path
											d="M15,30V15l7.5,13Z"
											fill="#cc42a2"
										/>
										<path
											d="M7.5,28,2,22.5,15,15Z"
											fill="#ff5800"
										/>
										<path
											d="M15,30,7.5,28,15,15Z"
											fill="#ff3ba7"
										/>
										<path
											d="M30,15H15L28,7.5Z"
											fill="#179067"
										/>
										<path
											d="M28,22.5,22.5,28,15,15Z"
											fill="#9f49ac"
										/>
										<path
											d="M30,15l-2,7.5L15,15Z"
											fill="#476eaf"
										/>
										<path
											d="M0,15H15L2,22.5Z"
											fill="#ff8100"
										/>
										<path
											d="M2,7.5,7.5,2,15,15Z"
											fill="#fc0"
										/>
										<path
											d="M0,15,2,7.5,15,15Z"
											fill="#feac00"
										/>
									</svg>
								</span>
								<i className="ct-tooltip-top">
									{__('Edit Palette', 'blocksy')}
								</i>
							</a>
						)}
					</div>
				)}

				<ColorPickerIris
					key={getValueForPicker.key}
					onChange={(v) => onChange(v)}
					value={{
						...value,
						color: getValueForPicker.color,
					}}
				/>
			</div>
		</Fragment>
	)
}

export default PickerModal
