import {
	createPortal,
	useState,
	useEffect,
	useRef,
	createElement,
	Component,
	Fragment,
} from '@wordpress/element'
import { maybeTransformUnorderedChoices } from '../helpers/parse-choices.js'
import Downshift from 'downshift'
import classnames from 'classnames'

import usePopoverMaker from '../helpers/usePopoverMaker'

const Select = ({
	value,
	option: {
		choices,
		tabletChoices,
		mobileChoices,
		placeholder,
		defaultToFirstItem = true,
		search = false,
		inputClassName = '',
		selectInputStart,

		appendToBody = false,
	},
	renderItemFor = (item) => item.value,
	onChange,
	device = 'desktop',
}) => {
	const inputRef = useRef(null)
	const [tempState, setTempState] = useState(null)

	let deviceChoices = choices

	if (device === 'tablet' && tabletChoices) {
		deviceChoices = tabletChoices
	}

	if (device === 'mobile' && mobileChoices) {
		deviceChoices = mobileChoices
	}

	const orderedChoices = maybeTransformUnorderedChoices(deviceChoices)

	let potentialValue =
		value || !defaultToFirstItem
			? value
			: parseInt(value, 10) === 0
			? value
			: (orderedChoices[0] || {}).key

	const { styles, popoverProps } = usePopoverMaker({
		ref: inputRef,
		defaultHeight: 228,
		shouldCalculate: appendToBody,
	})

	useEffect(() => {
		if (!appendToBody) {
			return
		}

		setTimeout(() => {
			setTempState(Math.round())
		}, 50)
	}, [])

	if (orderedChoices.length === 0) {
		return null
	}

	return (
		<Downshift
			selectedItem={
				orderedChoices.find(({ key }) => key === potentialValue) ||
				!defaultToFirstItem
					? potentialValue
					: (orderedChoices[0] || {}).key
			}
			onChange={(selection) => {
				onChange(selection)
			}}
			itemToString={(item) =>
				item && orderedChoices.find(({ key }) => key === item)
					? orderedChoices.find(({ key }) => key === item).value
					: ''
			}>
			{({
				getInputProps,
				getItemProps,
				getLabelProps,
				getMenuProps,
				isOpen,
				inputValue,
				highlightedIndex,
				selectedItem,
				openMenu,
				toggleMenu,
				setState,
			}) => {
				let dropdown = null

				if (isOpen) {
					dropdown = (
						<div
							{...getMenuProps({
								className: classnames('ct-select-dropdown', {
									'ct-fixed': appendToBody,
								}),

								...(appendToBody ? popoverProps : {}),
							})}
							style={appendToBody ? styles : {}}>
							{orderedChoices
								.filter(
									(item) =>
										!inputValue ||
										(orderedChoices.find(
											({ key }) =>
												key.toString() ===
												selectedItem.toString()
										) &&
											orderedChoices.find(
												({ key }) =>
													key.toString() ===
													selectedItem.toString()
											).value === inputValue) ||
										item.value
											.toLowerCase()
											.includes(inputValue.toLowerCase())
								)
								.map((item, index) => (
									<Fragment key={index}>
										{item.group &&
											(index === 0 ||
												orderedChoices[index - 1]
													.group !==
													orderedChoices[index]
														.group) && (
												<div
													className="ct-select-dropdown-group"
													key={`${index}-group`}>
													{item.group}
												</div>
											)}
										<div
											{...getItemProps({
												key: item.key,
												index,
												item: item.key,
												className: classnames(
													'ct-select-dropdown-item',
													{
														active:
															highlightedIndex ===
															index,
														selected:
															selectedItem ===
															item.key,
													}
												),
											})}>
											{renderItemFor(item)}
										</div>
									</Fragment>
								))}
						</div>
					)

					if (appendToBody) {
						dropdown = createPortal(dropdown, document.body)
					}
				}

				return (
					<div
						className={classnames(
							'ct-select-input 1',
							inputClassName
						)}>
						{selectInputStart && selectInputStart()}
						<input
							{...getInputProps({
								onClick: () => {
									toggleMenu()

									setTimeout(() => {
										setTempState(Math.round())
									}, 50)

									if (search) {
										setState({
											inputValue: '',
										})
									}
								},
								ref: inputRef,
							})}
							placeholder={
								search && isOpen
									? 'Type to search...'
									: placeholder || 'Select value...'
							}
							disabled={orderedChoices.length === 0}
							readOnly={search ? !isOpen : true}
						/>

						{dropdown}
					</div>
				)
			}}
		</Downshift>
	)
}

export default Select
