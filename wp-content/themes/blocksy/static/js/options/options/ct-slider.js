import {
	createElement,
	Component,
	createRef,
	Fragment,
} from '@wordpress/element'
import classnames from 'classnames'
import linearScale from 'simple-linear-scale'

import OutsideClickHandler from './react-outside-click-handler'

const clamp = (min, max, value) => Math.max(min, Math.min(max, value))
const clampMax = (max, value) => Math.min(max, value)

const round = (value, decimalPlaces = 1) => {
	// return Math.round(value)

	const multiplier = Math.pow(10, decimalPlaces)
	const rounded = Math.round(value * multiplier + Number.EPSILON) / multiplier
	return rounded
}

const UnitsList = ({
	option,
	onChange,
	is_open,
	toggleOpen,
	currentUnit,
	getNumericValue,
	getAllowedDecimalPlaces,
}) => {
	const pickUnit = (unit) => {
		const numericValue = getNumericValue()

		onChange(
			`${round(
				clamp(
					option.units.find(({ unit: u }) => u === unit).min,
					option.units.find(({ unit: u }) => u === unit).max,
					numericValue === '' ? -Infinity : numericValue
				),
				getAllowedDecimalPlaces(unit)
			)}${unit}`
		)
	}

	return (
		<Fragment>
			<span onClick={() => toggleOpen()} className="ct-current-value">
				{currentUnit || '―'}
			</span>

			<OutsideClickHandler
				onOutsideClick={() => {
					if (!is_open) {
						return
					}

					toggleOpen()
				}}>
				<ul className="ct-units-list">
					{option.units
						.filter(({ unit }) => unit !== currentUnit)

						.reduce(
							(current, el, index) => [
								...current.slice(
									0,
									index % 2 === 0 ? undefined : -1
								),
								...(index % 2 === 0
									? [[el]]
									: [[current[current.length - 1][0], el]]),
							],
							[]
						)

						.map((group) => (
							<li key={group[0].unit}>
								{group.map(({ unit }) => (
									<span
										key={unit}
										onClick={() => {
											pickUnit(unit)
											toggleOpen()
										}}>
										{unit || '―'}
									</span>
								))}
							</li>
						))}
				</ul>
			</OutsideClickHandler>
		</Fragment>
	)
}

export default class Slider extends Component {
	state = {
		is_dragging: false,
		is_open: false,
	}

	el = createRef()

	hasUnitsList = () =>
		this.props.option.units && this.props.option.units.length > 1

	getAllowedDecimalPlaces = (properUnit = null) => {
		const decimals = this.props.option.units
			? this.props.option.units.find(
					({ unit }) => unit === (properUnit || this.getCurrentUnit())
			  ).decimals
			: this.props.option.decimals

		return decimals !== 0 && !decimals ? 0 : decimals
	}

	withDefault = (currentUnit, defaultUnit) =>
		this.props.option.units
			? this.props.option.units.find(({ unit }) => unit === currentUnit)
				? currentUnit
				: currentUnit || defaultUnit
			: currentUnit || defaultUnit

	getCurrentUnit = () =>
		this.props.option.units
			? this.withDefault(
					this.props.value
						.toString()
						.replace(/[0-9]/g, '')
						.replace(/\-/g, '')
						.replace(/\./g, '')
						.replace('CT_CSS_SKIP_RULE', ''),
					this.props.option.units[0].unit
			  )
			: ''

	getMax = () =>
		this.props.option.units
			? this.props.option.units.find(
					({ unit }) => unit === this.getCurrentUnit()
			  ).max
			: this.props.option.max

	getMin = () =>
		this.props.option.units
			? this.props.option.units.find(
					({ unit }) => unit === this.getCurrentUnit()
			  ).min
			: this.props.option.min

	getNumericValue = ({ forPosition = false } = {}) => {
		const maybeValue = parseFloat(this.props.value, 10)

		if (maybeValue === 0) {
			return maybeValue
		}

		if (!maybeValue) {
			if (
				this.props.option.defaultPosition &&
				this.props.option.defaultPosition === 'center' &&
				forPosition
			) {
				let min = parseFloat(this.getMin(), 10)
				let max = parseFloat(this.getMax(), 10)

				return (max - min) / 2 + min
			}

			return ''
		}

		return maybeValue
	}

	computeAndSendNewValue({ pageX }) {
		let {
			top,
			left,
			right,
			width,
		} = this.el.current.getBoundingClientRect()

		let elLeftOffset = pageX - left - pageXOffset

		this.props.onChange(
			`${round(
				linearScale(
					[0, width],
					[
						parseFloat(this.getMin(), 10),
						parseFloat(this.getMax(), 10),
					],
					true
				)(
					document.body.classList.contains('rtl')
						? width - elLeftOffset
						: elLeftOffset
				),
				this.getAllowedDecimalPlaces()
			)}${this.getCurrentUnit()}`
		)
	}

	handleMove = (event) => {
		if (!this.state.is_dragging) return
		this.computeAndSendNewValue(event)
	}

	handleUp = () => {
		this.setState({
			is_dragging: false,
		})

		this.detachEvents()
	}

	handleBlur = () => {
		if (this.props.option.value === 'CT_CSS_SKIP_RULE') {
			if (this.props.value === 'CT_CSS_SKIP_RULE') {
				return
			}

			if (this.getNumericValue() === '') {
				this.props.onChange('CT_CSS_SKIP_RULE')
				return
			}
		}

		this.props.onChange(
			`${clamp(
				parseFloat(this.getMin(), 10),
				parseFloat(this.getMax(), 10),
				parseFloat(this.getNumericValue(), 10)
			)}${this.getCurrentUnit()}`
		)
	}

	handleChange = (value) => {
		if (this.props.option.value === 'CT_CSS_SKIP_RULE') {
			if (value.toString().trim() === '') {
				this.props.onChange('CT_CSS_SKIP_RULE')
				return
			}
		}

		this.props.onChange(
			`${clampMax(
				parseFloat(this.getMax(), 10),
				parseFloat(value || this.getMin())
			)}${this.getCurrentUnit()}`
		)
	}

	attachEvents() {
		document.documentElement.addEventListener(
			'mousemove',
			this.handleMove,
			true
		)

		document.documentElement.addEventListener(
			'mouseup',
			this.handleUp,
			true
		)
	}

	detachEvents() {
		document.documentElement.removeEventListener(
			'mousemove',
			this.handleMove,
			true
		)

		document.documentElement.removeEventListener(
			'mouseup',
			this.handleUp,
			true
		)
	}

	render() {
		const leftValue = `${linearScale(
			[parseFloat(this.getMin(), 10), parseFloat(this.getMax(), 10)],
			[0, 100]
		)(
			clamp(
				parseFloat(this.getMin(), 10),
				parseFloat(this.getMax(), 10),
				parseFloat(this.getNumericValue({ forPosition: true }), 10) ===
					0
					? 0
					: parseFloat(
							this.getNumericValue({ forPosition: true }),
							10
					  )
					? parseFloat(
							this.getNumericValue({ forPosition: true }),
							10
					  )
					: parseFloat(this.getMin(), 10)
			)
		)}`

		return (
			<div className="ct-option-slider">
				{this.props.beforeOption && this.props.beforeOption()}

				<div
					onMouseDown={({ pageX, pageY }) => {
						this.attachEvents()
						this.setState({ is_dragging: true })
					}}
					onClick={(e) => this.computeAndSendNewValue(e)}
					ref={this.el}
					className="ct-slider"
					{...(this.props.option.steps
						? { ['data-steps']: '' }
						: {})}>
					<div style={{ width: `${leftValue}%` }} />
					<span
						style={{
							'--position': `${leftValue}%`,
						}}
					/>

					{this.props.option.steps && (
						<section className={this.props.option.steps}>
							<i className="minus"></i>
							<i className="zero"></i>
							<i className="plus"></i>
						</section>
					)}
				</div>

				{!this.props.option.skipInput && (
					<div
						className={classnames('ct-slider-input', {
							// ['ct-unit-changer']: !!this.props.option.units,
							['ct-value-changer']: true,
							'no-unit-list': !this.hasUnitsList(),
							active: this.state.is_open,
						})}>
						<input
							type="number"
							{...(this.props.option.ref
								? { ref: this.props.option.ref }
								: {})}
							step={
								1 / Math.pow(10, this.getAllowedDecimalPlaces())
							}
							value={this.getNumericValue()}
							onBlur={() => this.handleBlur()}
							onChange={({ target: { value } }) =>
								this.handleChange(value)
							}
						/>

						<span className="ct-value-divider"></span>

						{!this.hasUnitsList() && (
							<span className="ct-current-value">
								{this.withDefault(
									this.getCurrentUnit(),
									this.props.option.defaultUnit || 'px'
								)}
							</span>
						)}

						{this.hasUnitsList() && (
							<UnitsList
								option={this.props.option}
								onChange={this.props.onChange}
								is_open={this.state.is_open}
								toggleOpen={() =>
									this.setState({
										is_open: !this.state.is_open,
									})
								}
								currentUnit={this.getCurrentUnit()}
								getNumericValue={this.getNumericValue}
								getAllowedDecimalPlaces={
									this.getAllowedDecimalPlaces
								}
							/>
						)}
					</div>
				)}
			</div>
		)
	}
}
