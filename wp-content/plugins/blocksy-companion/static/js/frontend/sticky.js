var scrolling = false

import ctEvents from 'ct-events'
import { getCurrentScreen } from 'blocksy-frontend'

const clamp = (min, max, value) => Math.max(min, Math.min(max, value))

const computeLinearScale = (domain, range, value) =>
	range[0] +
	((range[1] - range[0]) / (domain[1] - domain[0])) * (value - domain[0])

const setTransparencyFor = (deviceContainer, value = 'yes') => {
	Array.from(
		deviceContainer.querySelectorAll('[data-row][data-transparent-row]')
	).map((el) => {
		el.dataset.transparentRow = value
	})
}

const getRowInitialHeight = (el) =>
	parseFloat(getComputedStyle(el).getPropertyValue('--height'))

const getRowStickyHeight = (el) => {
	let styles = getComputedStyle(el)

	let maybeShrink = styles.getPropertyValue('--stickyShrink')

	if (!maybeShrink) {
		return getRowInitialHeight(el)
	}

	return (parseFloat(maybeShrink) / 100) * getRowInitialHeight(el)
}

function isInViewport(element) {
	const rect = element.getBoundingClientRect()

	return (
		rect.top >= 0 &&
		rect.left >= 0 &&
		rect.bottom <=
			(window.innerHeight || document.documentElement.clientHeight) &&
		rect.right <=
			(window.innerWidth || document.documentElement.clientWidth)
	)
}

const getStartPositionFor = (stickyContainer) => {
	if (
		stickyContainer.dataset.sticky.indexOf('shrink') === -1 &&
		stickyContainer.dataset.sticky.indexOf('auto-hide') === -1
	) {
		return stickyContainer.parentNode.getBoundingClientRect().height + 200
	}

	const stickyOffset =
		stickyContainer.closest('header').getBoundingClientRect().top + scrollY

	const row = stickyContainer.parentNode

	if (
		row.parentNode.children.length === 1 ||
		row.parentNode.children[0].classList.contains('ct-sticky-container')
	) {
		return stickyOffset
	}

	return Array.from(row.parentNode.children)
		.reduce((result, el, index) => {
			if (result.indexOf(0) > -1 || !el.dataset.row) {
				return [...result, 0]
			} else {
				return [
					...result,

					el.classList.contains('ct-sticky-container')
						? 0
						: el.getBoundingClientRect().height,
				]
			}
		}, [])
		.reduce((sum, height) => sum + height, stickyOffset)
}

let hasListener = false

export const mountStickyHeader = () => {
	const stickyHeader = document.querySelector('[data-sticky]')

	if (!stickyHeader) {
		return
	}

	let prevScrollY = window.scrollY

	const compute = () => {
		const stickyContainer = document.querySelector(
			`[data-device="${getCurrentScreen()}"] [data-sticky]`
		)

		if (!stickyContainer) {
			return
		}

		const startPosition = getStartPositionFor(stickyContainer)

		const isSticky =
			(startPosition > 0 &&
				Math.abs(window.scrollY - startPosition) < 3) ||
			window.scrollY > startPosition

		const stickyComponents = stickyContainer.dataset.sticky
			.split(':')
			.filter((c) => c !== 'yes' && c !== 'no')

		let containerInitialHeight = Array.from(
			stickyContainer.querySelectorAll('[data-row]')
		).reduce((sum, el) => {
			let rowInitialHeight = parseFloat(
				getComputedStyle(el).getPropertyValue('--height')
			)

			return sum + rowInitialHeight
		}, 0)

		if (stickyComponents.indexOf('auto-hide') > -1) {
			if (window.scrollY < startPosition) {
				prevScrollY = window.scrollY
			}

			if (isSticky && window.scrollY - prevScrollY === 0) {
				document.body.style.setProperty(
					'--headerStickyHeightAnimated',
					`0px`
				)
			}

			if (isSticky && window.scrollY - prevScrollY < -5) {
				if (stickyContainer.dataset.sticky.indexOf('yes') === -1) {
					stickyContainer.dataset.sticky = [
						'yes-start',
						...stickyComponents,
					].join(':')

					requestAnimationFrame(() => {
						stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
							'yes-start',
							'yes-end'
						)

						setTimeout(() => {
							stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
								'yes-end',
								'yes'
							)
						}, 200)
					})
				}

				setTransparencyFor(stickyContainer, 'no')
				document.body.removeAttribute('style')

				stickyContainer.parentNode.style.setProperty(
					'--minHeight',
					`${containerInitialHeight}px`
				)
			} else {
				if (!isSticky) {
					stickyContainer.dataset.sticky = stickyComponents
						.filter((c) => c !== 'yes-end')
						.join(':')

					stickyContainer.parentNode.removeAttribute('style')

					Array.from(
						stickyContainer.querySelectorAll('[data-row]')
					).map((row) => row.removeAttribute('style'))
					setTransparencyFor(stickyContainer, 'yes')

					document.body.style.setProperty(
						'--headerStickyHeightAnimated',
						`0px`
					)

					prevScrollY = window.scrollY
					return
				}

				if (
					stickyContainer.dataset.sticky.indexOf('yes-hide') === -1 &&
					stickyContainer.dataset.sticky.indexOf('yes:') > -1 &&
					window.scrollY - prevScrollY > 5
				) {
					stickyContainer.dataset.sticky = [
						'yes-hide-start',
						...stickyComponents,
					].join(':')

					document.body.style.setProperty(
						'--headerStickyHeightAnimated',
						`0px`
					)

					requestAnimationFrame(() => {
						stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
							'yes-hide-start',
							'yes-hide-end'
						)

						setTimeout(() => {
							stickyContainer.dataset.sticky = stickyComponents.join(
								':'
							)

							stickyContainer.parentNode.removeAttribute('style')

							Array.from(
								stickyContainer.querySelectorAll('[data-row]')
							).map((row) => row.removeAttribute('style'))
							setTransparencyFor(stickyContainer, 'yes')
						}, 200)
					})
				}
			}

			prevScrollY = window.scrollY
		}

		if (
			stickyComponents.indexOf('slide') > -1 ||
			stickyComponents.indexOf('fade') > -1
		) {
			if (isSticky) {
				if (stickyContainer.dataset.sticky.indexOf('yes') === -1) {
					stickyContainer.dataset.sticky = [
						'yes-start',
						...stickyComponents,
					].join(':')

					requestAnimationFrame(() => {
						stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
							'yes-start',
							'yes-end'
						)

						setTimeout(() => {
							stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
								'yes-end',
								'yes'
							)
						}, 200)
					})
				}

				setTransparencyFor(stickyContainer, 'no')

				stickyContainer.parentNode.style.setProperty(
					'--minHeight',
					`${containerInitialHeight}px`
				)
			} else {
				if (
					stickyContainer.dataset.sticky.indexOf('yes-hide') === -1 &&
					stickyContainer.dataset.sticky.indexOf('yes:') > -1
				) {
					if (Math.abs(window.scrollY - startPosition) > 10) {
						stickyContainer.dataset.sticky = stickyComponents.join(
							':'
						)

						setTimeout(() => {
							stickyContainer.parentNode.removeAttribute('style')

							Array.from(
								stickyContainer.querySelectorAll('[data-row]')
							).map((row) => row.removeAttribute('style'))
						}, 300)

						setTransparencyFor(stickyContainer, 'yes')
					} else {
						stickyContainer.dataset.sticky = [
							'yes-hide-start',
							...stickyComponents,
						].join(':')

						requestAnimationFrame(() => {
							stickyContainer.dataset.sticky = stickyContainer.dataset.sticky.replace(
								'yes-hide-start',
								'yes-hide-end'
							)

							setTimeout(() => {
								stickyContainer.dataset.sticky = stickyComponents.join(
									':'
								)

								setTimeout(() => {
									stickyContainer.parentNode.removeAttribute(
										'style'
									)

									Array.from(
										stickyContainer.querySelectorAll(
											'[data-row]'
										)
									).map((row) => row.removeAttribute('style'))
								}, 300)

								setTransparencyFor(stickyContainer, 'yes')
							}, 200)
						})
					}
				}
			}
		}

		if (stickyComponents.indexOf('shrink') > -1) {
			if (isSticky) {
				setTransparencyFor(stickyContainer, 'no')

				stickyContainer.parentNode.style.setProperty(
					'--minHeight',
					`${containerInitialHeight}px`
				)

				let containerStickyHeight = Array.from(
					stickyContainer.querySelectorAll('[data-row]')
				).reduce((sum, el, index) => {
					let rowStickyHeight = getRowStickyHeight(el)
					return sum + rowStickyHeight
				}, 0)

				;[
					...stickyContainer.querySelectorAll('[data-row="middle"]'),
				].map((row) => {
					if (
						row.querySelector(
							'[data-id="logo"] .site-logo-container'
						)
					) {
						const logo = row.querySelector(
							'[data-id="logo"] .site-logo-container'
						)

						let initialHeight = parseFloat(
							getComputedStyle(logo).getPropertyValue(
								'--maxHeight'
							) || 50
						)

						const stickyShrink = parseFloat(
							getComputedStyle(logo).getPropertyValue(
								'--logoStickyShrink'
							) || 1
						)

						const stickyHeight = initialHeight * stickyShrink

						if (stickyShrink === 1) {
							return
						}

						let rowInitialHeight = getRowInitialHeight(row)
						let rowStickyHeight = getRowStickyHeight(row)

						logo.style.setProperty(
							'--logo-shrink-height',
							computeLinearScale(
								[
									startPosition,
									startPosition +
										Math.abs(
											rowInitialHeight === rowStickyHeight
												? initialHeight - stickyHeight
												: rowInitialHeight -
														rowStickyHeight
										),
								],
								[1, stickyShrink],
								clamp(
									startPosition,
									startPosition +
										Math.abs(
											rowInitialHeight === rowStickyHeight
												? initialHeight - stickyHeight
												: rowInitialHeight -
														rowStickyHeight
										),

									scrollY
								)
							)
						)
					}
				})

				if (
					containerStickyHeight !== containerInitialHeight &&
					stickyContainer.querySelector('[data-row="middle"]')
				) {
					;[stickyContainer.querySelector('[data-row="middle"]')].map(
						(row) => {
							let rowInitialHeight = getRowInitialHeight(row)
							let rowStickyHeight = getRowStickyHeight(row)

							row.style.setProperty(
								'--shrinkHeight',
								`${computeLinearScale(
									[
										startPosition,
										startPosition +
											Math.abs(
												rowInitialHeight -
													rowStickyHeight
											),
									],
									[rowInitialHeight, rowStickyHeight],
									clamp(
										startPosition,

										startPosition +
											Math.abs(
												rowInitialHeight -
													rowStickyHeight
											),

										scrollY
									)
								)}px`
							)
						}
					)
				}
			} else {
				stickyContainer.parentNode.removeAttribute('style')

				Array.from(
					stickyContainer.querySelectorAll('[data-row]')
				).map((row) => row.removeAttribute('style'))

				Array.from(
					stickyContainer.querySelectorAll(
						'[data-row="middle"] .site-logo-container'
					)
				).map((el) => el.removeAttribute('style'))

				setTransparencyFor(stickyContainer, 'yes')
			}

			const stickyComponents = stickyContainer.dataset.sticky
				.split(':')
				.filter((c) => c !== 'yes' && c !== 'no')

			stickyContainer.dataset.sticky = (isSticky
				? ['yes', ...stickyComponents]
				: stickyComponents
			).join(':')
		}
	}

	compute()

	if (!hasListener) {
		hasListener = true

		window.addEventListener('scroll', () => {
			if (scrolling) return

			scrolling = true

			requestAnimationFrame(() => {
				compute()
				scrolling = false
			})
		})
	}
}
