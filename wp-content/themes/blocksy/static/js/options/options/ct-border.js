import {
	createElement,
	Component,
	useState,
	useRef,
	useContext,
} from '@wordpress/element'
import OutsideClickHandler from './react-outside-click-handler'
import classnames from 'classnames'
import ColorPicker from './ct-color-picker'

import { __ } from 'ct-i18n'

const clamp = (min, max, value) => Math.max(min, Math.min(max, value))

const Border = ({ value, option, onChange }) => {
	const [isOpen, setIsOpen] = useState(false)

	return (
		<div className={classnames('ct-option-border')}>
			<div
				className={classnames('ct-value-changer', {
					['active']: isOpen,
					['ct-disabled']: value.style === 'none' || value.inherit,
				})}>
				<input
					type="number"
					value={value.width}
					// disabled={value.style === 'none'}
					onChange={({ target: { value: width } }) =>
						onChange({
							...value,
							width: clamp(1, 5, parseInt(width, 10) || 1),
						})
					}
				/>

				<span className="ct-value-divider"></span>

				<span
					className="ct-current-value"
					data-style={value.inherit ? 'none' : value.style}
					onClick={() => setIsOpen(!isOpen)}>
					{value.inherit
						? __('Inherit', 'blc')
						: value.style === 'none'
						? value.style
						: null}
				</span>
				<OutsideClickHandler
					disabled={!isOpen}
					onOutsideClick={() => {
						if (!isOpen) return
						setIsOpen(false)
					}}>
					<ul className="ct-styles-list">
						{['solid', 'dashed', 'dotted', 'none']
							.reduce(
								(current, el, index) => [
									...current.slice(
										0,
										index % 2 === 0 ? undefined : -1
									),
									...(index % 2 === 0
										? [[el]]
										: [
												[
													current[
														current.length - 1
													][0],
													el,
												],
										  ]),
								],
								[]
							)
							.map((group) => (
								<li key={group[0]}>
									{group.map((style) => (
										<span
											className={classnames({
												active: style === value.style,
											})}
											data-style={style}
											key={style}
											onClick={() => {
												onChange({
													...value,
													style,
													...(Object.keys(
														option.value
													).indexOf('inherit') > -1
														? {
																inherit: false,
														  }
														: {}),
												})
												setIsOpen(false)
											}}
											data-style={style}>
											{style === 'none' ? style : null}
										</span>
									))}
								</li>
							))}
					</ul>
				</OutsideClickHandler>
			</div>

			<ColorPicker
				onChange={(colorValue) =>
					onChange({
						...value,
						color: colorValue.default,
					})
				}
				option={{
					pickers: [
						{
							id: 'default',
							title: 'Initial',
						},
					],
				}}
				value={{
					default: value.color,
				}}
			/>
		</div>
	)
}

export default Border
