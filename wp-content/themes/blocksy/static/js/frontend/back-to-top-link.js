export const mount = () => {
	var backTop = document.querySelector('.ct-back-to-top')

	if (!backTop) return

	// browser window scroll (in pixels) after which the "back to top" link is shown
	// browser window scroll (in pixels) after which the "back to top" link opacity is reduced
	var scrolling = false

	const compute = () => {
		var backTop = document.querySelector('.ct-back-to-top')

		if (!backTop) return

		window.scrollY > 500
			? backTop.classList.add('ct-show')
			: backTop.classList.remove('ct-show')
	}

	compute()

	window.addEventListener('scroll', () => {
		if (scrolling) return

		scrolling = true

		requestAnimationFrame(() => {
			compute()

			scrolling = false
		})
	})

	backTop.addEventListener('click', event => {
		event.preventDefault()

		var start = window.scrollY
		var currentTime = null

		const animateScroll = timestamp => {
			if (!currentTime) currentTime = timestamp
			var progress = timestamp - currentTime

			const easeInOutQuad = (t, b, c, d) => {
				t /= d / 2
				if (t < 1) return (c / 2) * t * t + b
				t--
				return (-c / 2) * (t * (t - 2) - 1) + b
			}

			var val = Math.max(easeInOutQuad(progress, start, -start, 700), 0)

			scrollTo(0, val)

			if (progress < 700) {
				requestAnimationFrame(animateScroll)
			}
		}

		requestAnimationFrame(animateScroll)
	})
}
