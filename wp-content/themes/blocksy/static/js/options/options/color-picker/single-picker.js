import {
	createElement,
	Component,
	createPortal,
	useRef,
	createRef,
} from '@wordpress/element'
import PickerModal, { getNoColorPropFor } from './picker-modal'
import { Transition } from 'react-spring/renderprops'
import bezierEasing from 'bezier-easing'
import classnames from 'classnames'

import usePopoverMaker from '../../helpers/usePopoverMaker'

const SinglePicker = ({
	option,
	value,
	onChange,
	picker,

	onPickingChange,
	stopTransitioning,

	innerRef,

	containerRef,
	modalRef,

	isTransitioning,
	isPicking,
}) => {
	const el = useRef()

	const { appendToBody = true } = option

	const { refreshPopover, styles, popoverProps } = usePopoverMaker({
		contentRef: modalRef,
		ref: containerRef || {},
		defaultHeight: 379,
		shouldCalculate: !option.inline_modal || appendToBody,
	})

	if (option.inline_modal) {
		return (
			<PickerModal
				containerRef={containerRef}
				option={option}
				onChange={onChange}
				picker={picker}
				value={value}
				inline_modal={!!option.inline_modal}
			/>
		)
	}

	let modal = null

	if (
		isTransitioning === picker.id ||
		(isPicking || '').split(':')[0] === picker.id
	) {
		modal = createPortal(
			<Transition
				items={isPicking}
				onRest={() => stopTransitioning()}
				config={{
					duration: 100,
					easing: bezierEasing(0.25, 0.1, 0.25, 1.0),
				}}
				from={
					(isPicking || '').indexOf(':') === -1
						? {
								transform: 'scale3d(0.95, 0.95, 1)',
								opacity: 0,
						  }
						: { opacity: 1 }
				}
				enter={
					(isPicking || '').indexOf(':') === -1
						? {
								transform: 'scale3d(1, 1, 1)',
								opacity: 1,
						  }
						: {
								opacity: 1,
						  }
				}
				leave={
					(isPicking || '').indexOf(':') === -1
						? {
								transform: 'scale3d(0.95, 0.95, 1)',
								opacity: 0,
						  }
						: {
								opacity: 1,
						  }
				}>
				{(isPicking) =>
					(isPicking || '').split(':')[0] === picker.id &&
					((props) => (
						<PickerModal
							style={{
								...props,
								...(appendToBody ? styles : {}),
							}}
							option={option}
							onChange={onChange}
							picker={picker}
							value={value}
							el={el}
							wrapperProps={
								appendToBody
									? popoverProps
									: {
											ref: modalRef,
									  }
							}
							appendToBody={appendToBody}
						/>
					))
				}
			</Transition>,
			appendToBody
				? document.body
				: el.current.closest('section').parentNode
		)
	}

	return (
		<div
			ref={(instance) => {
				el.current = instance

				if (innerRef) {
					innerRef.current = instance
				}
			}}
			className={classnames('ct-color-picker-single', {
				[`ct-no-color`]:
					(value || {}).color === getNoColorPropFor(option),
			})}>
			<span tabIndex="0">
				<span
					tabIndex="0"
					onClick={(e) => {
						e.stopPropagation()

						refreshPopover()

						let futureIsPicking = isPicking
							? isPicking.split(':')[0] === picker.id
								? null
								: `${picker.id}:${isPicking.split(':')[0]}`
							: picker.id

						onPickingChange(futureIsPicking)
					}}
					style={
						((value || {}).color || '').indexOf(
							getNoColorPropFor(option)
						) === -1
							? {
									background: (value || {}).color,
							  }
							: {
									...(picker.inherit &&
									(value || {}).color !==
										getNoColorPropFor(option)
										? {
												background: picker.inherit,
										  }
										: {}),
							  }
					}>
					<i className="ct-tooltip-top">{picker.title}</i>
				</span>
			</span>

			{modal}
		</div>
	)
}

export default SinglePicker
