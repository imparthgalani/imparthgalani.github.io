import { createElement, Fragment } from '@wordpress/element'
import OptionsPanel from '../OptionsPanel'
import { capitalizeFirstLetter } from '../GenericOptionType'

const Group = ({ renderingChunk, value, onChange, purpose, hasRevertButton }) =>
	renderingChunk.map(conditionOption => {
		const { label, options, id, attr = {} } = conditionOption

		const groupContents = (
			<OptionsPanel
				purpose={purpose}
				onChange={onChange}
				options={options}
				value={value}
				hasRevertButton={hasRevertButton}
			/>
		)

		return (
			<div key={id} className="ct-controls-group">
				{label && (
					<header>
						<label>{label}</label>
					</header>
				)}
				<section {...attr}>{groupContents}</section>
			</div>
		)
	})

export default Group
