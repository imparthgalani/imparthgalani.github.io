import { createElement, Component } from '@wordpress/element'
import classnames from 'classnames'

const ImagePicker = ({
	option: { choices, tabletChoices, mobileChoices },
	option,
	device,
	value,
	onChange,
}) => {
	const { className, ...attr } = { ...(option.attr || {}) }

	let deviceChoices = option.choices

	if (device === 'tablet' && tabletChoices) {
		deviceChoices = tabletChoices
	}

	if (device === 'mobile' && mobileChoices) {
		deviceChoices = mobileChoices
	}

	return (
		<ul
			{...attr}
			className={classnames('ct-image-picker', className)}
			{...(option.title && null ? { 'data-title': '' } : {})}>
			{(Array.isArray(deviceChoices)
				? deviceChoices
				: Object.keys(deviceChoices).map((choice) => ({
						key: choice,
						...deviceChoices[choice],
				  }))
			).map((choice) => (
				<li
					className={classnames({
						active: choice.key === value,
					})}
					onClick={() => onChange(choice.key)}
					key={choice.key}>
					{choice.src.indexOf('<svg') === -1 ? (
						<img src={choice.src} />
					) : (
						<span
							dangerouslySetInnerHTML={{
								__html: choice.src,
							}}
						/>
					)}

					{option.title && null && <span>{choice.title}</span>}

					{choice.title && (
						<span className="ct-tooltip-top">{choice.title}</span>
					)}
				</li>
			))}
		</ul>
	)
}

export default ImagePicker
