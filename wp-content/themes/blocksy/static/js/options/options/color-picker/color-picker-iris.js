import { createElement, Component, createRef } from '@wordpress/element'
import { ColorPicker } from '@wordpress/components'
import _ from '_'
import $ from 'jquery'
import { __ } from 'ct-i18n'

const ColorPickerIris = ({ onChange, value, value: { color } }) => {
	return (
		<div>
			<ColorPicker
				color={color}
				onChangeComplete={({ color, hex }) => {
					onChange({
						...value,
						color:
							color.getAlpha() === 1 ? hex : color.toRgbString()
					})
				}}
			/>
		</div>
	)
}

export default ColorPickerIris
