import {
	Fragment,
	createElement,
	useRef,
	useEffect,
	useMemo,
	useCallback,
	useState,
} from '@wordpress/element'

import classnames from 'classnames'

import { __experimentalGradientPicker as ExperimentalGradientPicker } from '@wordpress/components'

const GradientPicker = ({ value, onChange }) => {
	const allGradients = (window.ct_customizer_localizations ||
		window.ct_localizations)['gradients']
	return (
		<Fragment>
			<ExperimentalGradientPicker
				value={value.gradient || ''}
				onChange={(val) => {
					onChange({
						...value,
						gradient: val,
					})
				}}
			/>

			<ul className={'ct-gradient-swatches'}>
				{allGradients.map(({ gradient, slug }) => (
					<li
						onClick={() => {
							onChange({
								...value,
								gradient:
									value.gradient === gradient ? '' : gradient,
							})
						}}
						className={classnames({
							active: gradient === value.gradient,
						})}
						style={{
							'--background-image': gradient,
						}}
						key={slug}></li>
				))}
			</ul>
		</Fragment>
	)
}

export default GradientPicker
