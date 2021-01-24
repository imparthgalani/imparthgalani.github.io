import {
	Fragment,
	createElement,
	Component,
	useRef,
	useEffect,
	useMemo,
	useCallback,
	useState,
} from '@wordpress/element'
import classnames from 'classnames'
import { getDefaultFonts } from './default-data'
import {
	humanizeVariationsShort,
	decideVariationToSelect,
	familyForDisplay,
} from './helpers'
import { __ } from 'ct-i18n'

import bezierEasing from 'bezier-easing'

import { Transition, animated } from '@react-spring/web'

import FontsList from './FontsList'
import VariationsList from './VariationsList'
import FontOptions from './FontOptions'

import GenericOptionType from '../../GenericOptionType'

const combineRefs = (...refs) => (el) => {
	refs.map((ref) => {
		if (typeof ref === 'function') {
			ref(el)
		} else if (
			typeof ref === 'object' &&
			ref !== null &&
			ref.hasOwnProperty('current')
		) {
			ref.current = el
		} else if (ref === null) {
			// No-op
		}
	})
}

function fuzzysearch(needle, haystack) {
	var hlen = haystack.length
	var nlen = needle.length
	if (nlen > hlen) {
		return false
	}
	if (nlen === hlen) {
		return needle === haystack
	}
	outer: for (var i = 0, j = 0; i < nlen; i++) {
		var nch = needle.charCodeAt(i)
		while (j < hlen) {
			if (haystack.charCodeAt(j++) === nch) {
				continue outer
			}
		}
		return false
	}

	return true
}

const TypographyModal = ({
	option,
	value,
	initialView,
	currentView,
	previousView,
	setCurrentView,
	setInititialView,
	onChange,
	wrapperProps = {},
}) => {
	const [typographyList, setTypographyList] = useState(
		getDefaultFonts(option)
	)
	const [isSearch, setIsSearch] = useState(false)
	const [searchTerm, setSearchTerm] = useState('')

	const direction = useMemo(() => {
		if (previousView === '_') {
			return 'static'
		}

		if (
			(currentView === 'search' && previousView === 'fonts') ||
			(previousView === 'search' && currentView === 'fonts')
		) {
			return 'static'
		}

		if (previousView === 'options') {
			return 'right'
		}

		if (previousView === 'fonts' && currentView === 'variations') {
			return 'right'
		}

		return 'left'
	}, [currentView, previousView])

	const inputEl = useRef(null)
	const sizeEl = useRef(null)

	const linearFontsList = Object.keys(typographyList).reduce(
		(currentList, currentSource) => [
			...currentList,
			...(
				typographyList[currentSource].families || []
			).filter(({ family }) =>
				fuzzysearch(searchTerm.toLowerCase(), family.toLowerCase())
			),
		],
		[]
	)

	const fetchFontsList = async () => {
		const body = new FormData()

		body.append('action', 'blocksy_get_fonts_list')

		try {
			const response = await fetch(ajaxurl, {
				method: 'POST',
				body,
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					setTypographyList({
						...data.fonts,
						system: {
							...data.fonts.system,
							families: [
								...(option.isDefault
									? []
									: [
											{
												source: 'system',
												family: 'Default',
												variations: [],
												all_variations: [
													'Default',
													'n1',
													'i1',
													'n2',
													'i2',
													'n3',
													'i3',
													'n4',
													'i4',
													'n5',
													'i5',
													'n6',
													'i6',
													'n7',
													'i7',
													'n8',
													'i8',
													'n9',
													'i9',
												],
											},
									  ]),

								...data.fonts.system.families,
							],
						},
					})
				}
			}
		} catch (e) {}
	}

	useEffect(() => {
		if (initialView && initialView !== 'done') {
			setSearchTerm('')
			setTimeout(() => {
				// setInititialView('done')
			})
		}

		if (initialView === 'font_size') {
			setTimeout(() => sizeEl.current && sizeEl.current.focus(), 100)
		}
	}, [initialView])

	useEffect(() => {
		fetchFontsList()
	}, [])

	useEffect(() => {
		if (currentView === 'search') {
			inputEl.current.focus()
		}
	}, [currentView])

	const pickFontFamily = (family) => {
		onChange({
			...value,
			family: family.family,
			variation: decideVariationToSelect(family, value),
		})
	}

	return (
		<animated.div
			className="ct-option-modal ct-typography-modal"
			{...wrapperProps}>
			<div className="ct-typography-container">
				<ul
					className={classnames('ct-typography-top', {
						'ct-switch-panel': currentView !== 'options',
						'ct-static': previousView === '_',
					})}>
					<li
						className="ct-back"
						onClick={() => setCurrentView('options')}>
						<svg width="10" height="10" viewBox="0 0 15 15">
							<path d="M14.2,6.8H2.6l4-4c0.3-0.3,0.3-0.8,0-1.1c-0.3-0.3-0.8-0.3-1.1,0L0.2,7l0,0c0,0-0.1,0.1-0.1,0.1c0,0,0,0,0,0.1c0,0,0,0,0,0.1c0,0,0,0.1,0,0.1c0,0,0,0,0,0.1c0,0,0,0.1,0,0.1l0,0c0,0,0,0,0,0c0,0,0,0.1,0,0.1c0,0,0,0,0,0.1c0,0,0,0.1,0,0.1c0,0,0,0,0,0.1c0,0,0,0,0,0.1C0.2,8,0.2,8,0.2,8l5.3,5.3c0.3,0.3,0.8,0.3,1.1,0c0.3-0.3,0.3-0.8,0-1.1l-4-4h11.7c0.4,0,0.8-0.3,0.8-0.8S14.7,6.8,14.2,6.8z" />
						</svg>
					</li>

					<li
						className={classnames('ct-font', {
							active:
								currentView === 'search' ||
								currentView === 'fonts',
						})}
						onClick={() => {
							setCurrentView(
								currentView === 'fonts' ? 'search' : 'fonts'
							)
							setSearchTerm('')
						}}>
						{currentView !== 'search' && (
							<span>{familyForDisplay(value.family)}</span>
						)}

						{currentView === 'search' && (
							<input
								onClick={(e) => e.stopPropagation()}
								ref={inputEl}
								autoFocus
								value={searchTerm}
								onKeyUp={(e) => {
									if (e.keyCode == 13) {
										if (linearFontsList.length > 0) {
											pickFontFamily(linearFontsList[0])
											setCurrentView('options')
											setSearchTerm('')
										}
									}
								}}
								onChange={({ target: { value } }) =>
									setSearchTerm(value)
								}
							/>
						)}

						<svg width="8" height="8" viewBox="0 0 15 15">
							{currentView === 'search' && (
								<path d="M8.9,7.5l4.6-4.6c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L7.5,6.1L2.9,1.5c-0.4-0.4-1-0.4-1.4,0c-0.4,0.4-0.4,1,0,1.4l4.6,4.6l-4.6,4.6c-0.4,0.4-0.4,1,0,1.4c0.4,0.4,1,0.4,1.4,0l4.6-4.6l4.6,4.6c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L8.9,7.5z" />
							)}

							{currentView !== 'search' && (
								<path d="M14.6,14.6c-0.6,0.6-1.4,0.6-2,0l-2.5-2.5c-1,0.7-2.2,1-3.5,1C2.9,13.1,0,10.2,0,6.6S2.9,0,6.6,0c3.6,0,6.6,2.9,6.6,6.6c0,1.3-0.4,2.5-1,3.5l2.5,2.5C15.1,13.1,15.1,14,14.6,14.6z M6.6,1.9C4,1.9,1.9,4,1.9,6.6s2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C11.3,4,9.2,1.9,6.6,1.9z" />
							)}
						</svg>
					</li>

					<li
						className={classnames('ct-weight', {
							active: currentView === 'variations',
						})}
						onClick={() => setCurrentView('variations')}>
						<span data-variation={value.variation}>
							{humanizeVariationsShort(value.variation)}
						</span>
					</li>
				</ul>

				<Transition
					items={currentView}
					immediate={direction === 'static'}
					config={(item, type) => ({
						duration: 210,
						easing: bezierEasing(0.455, 0.03, 0.515, 0.955),
					})}
					from={{
						transform:
							direction === 'left'
								? 'translateX(100%)'
								: 'translateX(-100%)',

						position: 'absolute',
					}}
					enter={{
						transform: 'translateX(0%)',
						position: 'absolute',
					}}
					leave={{
						position: 'absolute',
						transform:
							direction === 'left'
								? 'translateX(-100%)'
								: 'translateX(100%)',
					}}>
					{(props, currentView, transition, key) => {
						if (currentView === 'options') {
							return (
								<FontOptions
									sizeRef={sizeEl}
									value={value}
									option={option}
									onChange={onChange}
									props={props}
									currentView={currentView}
								/>
							)
						}

						if (
							currentView === 'fonts' ||
							currentView === 'search'
						) {
							return (
								<animated.div style={props} key={currentView}>
									<FontsList
										typographyList={typographyList}
										searchTerm={searchTerm}
										linearFontsList={linearFontsList}
										currentView={`${currentView}:${previousView}`}
										onPickFamily={(family) => {
											pickFontFamily(family)
											// setCurrentView('options')
											// setSearchTerm('')
										}}
										value={value}
									/>
								</animated.div>
							)
						}

						if (currentView === 'variations') {
							return (
								<VariationsList
									currentView={currentView}
									props={props}
									typographyList={typographyList}
									onChange={(value) => {
										onChange(value)
										// setCurrentView('options')
									}}
									value={value}
								/>
							)
						}
					}}
				</Transition>
			</div>
		</animated.div>
	)
}

export default TypographyModal
