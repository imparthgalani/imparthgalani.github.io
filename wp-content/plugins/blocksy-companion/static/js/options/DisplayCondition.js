import {
	createElement,
	Fragment,
	useEffect,
	useState
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import { Switch, Select } from 'blocksy-options'
import cls from 'classnames'
import ConditionsManager from './ConditionsManager'
import { Overlay } from 'blocksy-options'

const DisplayCondition = ({
	option: {
		// inline | modal
		display = 'inline'
	},
	value,
	onChange
}) => {
	const [isEditing, setIsEditing] = useState(false)
	const [localValue, setLocalValue] = useState(null)

	if (display === 'inline') {
		return <ConditionsManager value={value} onChange={onChange} />
	}

	return (
		<Fragment>
			<button
				className="button-primary"
				style={{ width: '100%' }}
				onClick={e => {
					e.preventDefault()
					setIsEditing(true)
					setLocalValue(null)
				}}>
				{__('Add/Edit Conditions', 'blc')}
			</button>

			<Overlay
				items={isEditing}
				className="ct-admin-modal ct-builder-conditions-modal"
				onDismiss={() => {
					setIsEditing(false)
					setLocalValue(null)
				}}
				render={() => (
					<div className="ct-modal-content">
						<h2>{__('Transparent Header Display Conditions', 'blc')}</h2>
						<p>
							{__(
								'Add one or more conditions to display the transparent header.',
								'blc'
							)}
						</p>

						<div className="ct-modal-scroll">
							<ConditionsManager
								value={localValue || value}
								onChange={value => {
									setLocalValue(value)
								}}
							/>
						</div>

						<div className="ct-modal-actions has-divider">
							<button
								className="button-primary"
								disabled={!localValue}
								onClick={() => {
									onChange(localValue)
									setIsEditing(false)
								}}>
								{__('Save Conditions', 'blc')}
							</button>
						</div>
					</div>
				)}
			/>
		</Fragment>
	)
}

export default DisplayCondition
