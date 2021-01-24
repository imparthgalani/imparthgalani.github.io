import { createElement, Component, useRef, Fragment } from '@wordpress/element'
import OptionsPanel from '../OptionsPanel'
import { __ } from 'ct-i18n'
import cls from 'classnames'

const SinglePalette = ({
	singlePalette,
	properValue,
	index,
	onChange,
	option,
}) => {
	return (
		<li
			onMouseUp={(e) => {
				const { id, ...colors } = singlePalette

				onChange({
					...properValue,
					current_palette: singlePalette.id,
					...colors,
				})
			}}
			className={cls('ct-single-palette', {
				active: singlePalette.id === properValue.current_palette,
			})}
			key={singlePalette.id}>
			<label
				onClick={() => {
					const { id, ...colors } = singlePalette

					/*
                                onChange({
                                    ...properValue,
                                    current_palette: singlePalette.id,
                                    ...colors
                                })
                                */
				}}>
				<input
					onChange={() => {}}
					checked={properValue.current_palette === singlePalette.id}
					type="radio"
				/>
				Palette {index + 1}
			</label>

			<OptionsPanel
				hasRevertButton={false}
				onChange={(key, newValue) => {
					if (key !== 'color') {
						return
					}

					const { id, ...colors } = newValue

					onChange({
						...properValue,

						palettes: properValue.palettes.map((p) =>
							p.id === singlePalette.id
								? {
										...p,
										...colors,
								  }
								: p
						),
						...(properValue.current_palette === singlePalette.id
							? colors
							: {}),
					})
				}}
				value={{ color: singlePalette }}
				options={{
					color: {
						type: 'ct-color-picker',
						predefined: true,
						design: 'none',
						label: false,
						modalClassName: 'ct-color-palette-modal',
						value: option.value.palettes.find(
							({ id }) => id === singlePalette.id
						),

						pickers: [
							{
								title: __('Color 1', 'blocksy'),
								id: 'color1',
							},

							{
								title: __('Color 2', 'blocksy'),
								id: 'color2',
							},

							{
								title: __('Color 3', 'blocksy'),
								id: 'color3',
							},

							{
								title: __('Color 4', 'blocksy'),
								id: 'color4',
							},

							{
								title: __('Color 5', 'blocksy'),
								id: 'color5',
							},
						],
					},
				}}
			/>
		</li>
	)
}

const ColorPalettes = ({ option, value, onChange }) => {
	const properValue = {
		...option.value,
		...value,
		palettes: value.palettes
			? value.palettes
			: option.value.palettes.map((p, index) =>
					index === 0
						? {
								color1: value.color1 || p.color1,
								color2: value.color2 || p.color2,
								color3: value.color3 || p.color3,
								color4: value.color4 || p.color4,
								color5: value.color5 || p.color5,
								id: p.id,
						  }
						: p
			  ),
	}

	return (
		<div>
			<ul className="ct-color-palettes">
				{properValue.palettes.map((singlePalette, index) => (
					<SinglePalette
						key={singlePalette.id}
						singlePalette={singlePalette}
						properValue={properValue}
						index={index}
						onChange={onChange}
						option={option}
					/>
				))}
			</ul>
		</div>
	)
}

export default ColorPalettes
