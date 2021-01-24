import { createElement, Component } from '@wordpress/element'
import classnames from 'classnames'
import { normalizeCondition, matchValuesWithCondition } from 'match-conditions'

export default class Radio extends Component {
	renderAsText() {}

	renderAsRadio() {
		const { inline = false } = this.props.option

		return (
			<div
				className="ct-radio-option"
				{...(inline ? { ['data-inline']: '' } : {})}
				{...(this.props.option.attr || {})}>
				{Object.keys(this.props.option.choices).map((choice) => (
					<label key={choice}>
						<input
							type="radio"
							checked={choice === this.props.value}
							onChange={() => this.props.onChange(choice)}
						/>

						{this.props.option.choices[choice]}
					</label>
				))}
			</div>
		)
	}

	render() {
		if (this.props.option.view === 'radio') {
			return this.renderAsRadio()
		}

		const { inline = false } = this.props.option

		return (
			<ul
				className="ct-radio-option ct-buttons-group"
				{...(inline ? { ['data-inline']: '' } : {})}
				{...(this.props.option.attr || {})}>
				{Object.keys(this.props.option.choices)
					.filter((choice) => {
						if (!this.props.option.conditions) {
							return true
						}

						if (!this.props.option.conditions[choice]) {
							return true
						}

						return matchValuesWithCondition(
							normalizeCondition(
								this.props.option.conditions[choice]
							),
							this.props.values
						)
					})
					.map((choice) => (
						<li
							className={classnames({
								active: choice === this.props.value,
							})}
							onClick={() => this.props.onChange(choice)}
							key={choice}
							dangerouslySetInnerHTML={{
								__html: this.props.option.choices[choice],
							}}
							{...(this.props.singleChoiceProps
								? this.props.singleChoiceProps(choice)
								: {})}
						/>
					))}
			</ul>
		)
	}
}
