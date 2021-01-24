// @jsx h
import { h } from 'dom-chef'
import classnames from 'classnames'

let alreadyRunning = false

const store = {}

const cachedFetch = (url) =>
	store[url]
		? new Promise((resolve) => {
				resolve(store[url])
				store[url] = store[url].clone()
		  })
		: new Promise((resolve) =>
				fetch(url).then((response) => {
					resolve(response)
					store[url] = response.clone()
				})
		  )

export const mount = (formEl, args = {}) =>
	((t, c) => c(t))(
		{
			clickOutsideHandler: (e) =>
				({ mode: 'inline', ...args }.mode !== 'modal' &&
				!formEl.contains(e.target) &&
				fadeOutAndRemove(formEl.querySelector('.ct-search-results'))),
			maybeEl: formEl.querySelector('input[type="search"]'),
		},
		({ clickOutsideHandler, maybeEl }) => {
			const options = {
				postType: 'ct_forced_any',

				// inline | modal
				mode: 'inline',

				perPage: 5,
				...args,
			}

			if (!maybeEl) {
				return
			}

			options.postType = formEl.querySelector('[name="post_type"]')
				? `ct_forced_${
						formEl.querySelector('[name="post_type"]').value
				  }`
				: formEl.querySelector('[name="ct_post_type"]')
				? `ct_forced_${
						formEl.querySelector('[name="ct_post_type"]').value
				  }`
				: 'ct_forced_any'

			if (!window.fetch) return

			let listener = debounce((e) => {
				document.removeEventListener('click', clickOutsideHandler)
				document.addEventListener('click', clickOutsideHandler)

				if (e.target.value.trim().length === 0) {
					fadeOutAndRemove(formEl.querySelector('.ct-search-results'))

					return
				}

				formEl.classList.add('ct-searching')

				cachedFetch(
					`${ct_localizations.rest_url}wp/v2/posts${
						ct_localizations.rest_url.indexOf('?') > -1 ? '&' : '?'
					}_embed=1&post_type=${options.postType}&per_page=${
						options.perPage
					}&search=${e.target.value}`
				).then((response) => {
					let totalAmountOfPosts = parseInt(
						response.headers.get('X-WP-Total'),
						10
					)

					response.json().then((posts) => {
						if (alreadyRunning) {
							return
						}

						formEl.classList.remove('ct-searching')

						let itHadSearchResultsBefore = !!formEl.querySelector(
							'.ct-search-results'
						)

						alreadyRunning = true

						let searchResults = formEl.querySelector(
							'.ct-search-results'
						)

						let { height: heightBeforeRemoval } = searchResults
							? searchResults.getBoundingClientRect()
							: 0

						if (
							searchResults &&
							!(
								e.target.value.trim().length === 0 ||
								posts.length === 0
							)
						) {
							/**
							 * Should just quickly replace the list
							 * when results are available
							 */
							searchResults && formEl.removeChild(searchResults)
						} else {
							if (
								e.target.value.trim().length === 0 ||
								posts.length === 0
							) {
								fadeOutAndRemove(searchResults)
							}
						}

						if (
							posts.length > 0 &&
							e.target.value.trim().length > 0
						) {
							let searchResultsEl = (
								<div class="ct-search-results">
									{posts.map(
										({
											title: { rendered },
											link: href,
											_embedded = {},
										}) => (
											<a
												className="ct-search-item"
												key={href}
												{...{ href }}>
												{_embedded[
													'wp:featuredmedia'
												] && (
													<div
														{...{
															class: classnames({
																['ct-image-container']: true,
																['ct-no-image']: !_embedded[
																	'wp:featuredmedia'
																],
															}),
														}}>
														{_embedded[
															'wp:featuredmedia'
														] ? (
															<img
																{...{
																	src: (
																		_embedded[
																			'wp:featuredmedia'
																		][0]
																			.media_details || {
																			sizes: {},
																		}
																	).sizes
																		.thumbnail
																		? (
																				_embedded[
																					'wp:featuredmedia'
																				][0]
																					.media_details || {
																					sizes: [],
																				}
																		  )
																				.sizes
																				.thumbnail
																				.source_url
																		: values(
																				(
																					_embedded[
																						'wp:featuredmedia'
																					][0]
																						.media_details || {
																						sizes: [],
																					}
																				)
																					.sizes
																		  ).reduce(
																				(
																					currentSmallest,
																					current
																				) =>
																					current.width <
																					currentSmallest.width
																						? current
																						: currentSmallest,
																				{
																					width: 9999999999,
																				}
																		  )
																				.source_url ||
																		  _embedded[
																				'wp:featuredmedia'
																		  ][0]
																				.source_url,
																}}
															/>
														) : (
															[]
														)}
														<div class="ct-ratio" />
													</div>
												)}
												<span
													dangerouslySetInnerHTML={{
														__html: rendered,
													}}
													key="span"
												/>
											</a>
										)
									)}

									{totalAmountOfPosts > options.perPage ? (
										<a
											className="ct-search-more"
											{...{
												href: ct_localizations.search_url.replace(
													/QUERY_STRING/,
													e.target.value
												),
											}}>
											{ct_localizations.show_more_text}
										</a>
									) : (
										[]
									)}
								</div>
							)

							formEl.appendChild(searchResultsEl)

							if (!itHadSearchResultsBefore) {
								fadeIn(
									formEl.querySelector('.ct-search-results')
								)
							} else {
								let searchResults = formEl.querySelector(
									'.ct-search-results'
								)

								let {
									height: heightAfterReplace,
								} = searchResults.getBoundingClientRect()

								if (
									heightBeforeRemoval !== heightAfterReplace
								) {
									searchResults.style.height = `${heightBeforeRemoval}px`
									searchResults.classList.add('ct-slide')

									requestAnimationFrame(() => {
										searchResults.style.height = `${heightAfterReplace}px`

										whenTransitionEnds(
											searchResults,
											() => {
												searchResults.removeAttribute(
													'style'
												)

												searchResults.classList.remove(
													'ct-slide'
												)
											}
										)
									})
								}
							}

							if (formEl.querySelector('.ct-search-more')) {
								formEl
									.querySelector('.ct-search-more')
									.addEventListener('click', (e) => {
										e.preventDefault()
										formEl.submit()
									})
							}
						}

						alreadyRunning = false
					})
				})
			}, 200)

			maybeEl.addEventListener('input', listener)
			;({ mode: 'inline', ...args }.mode === 'modal' &&
				maybeEl.addEventListener('blur', (e) =>
					setTimeout(() => listener(e))
				))
			maybeEl.addEventListener('focus', listener)
		}
	)

function fadeOutAndRemove(el) {
	if (!el) return

	let { height } = el.getBoundingClientRect()

	el.classList.add('ct-fade-leave')
	el.style.height = `${height}px`

	el.closest('form').classList.remove('ct-has-dropdown')

	requestAnimationFrame(() => {
		el.classList.remove('ct-fade-leave')
		el.classList.add('ct-fade-leave-active')
		el.style.height = 0

		whenTransitionEnds(
			el,
			() => el.parentNode && el.parentNode.removeChild(el)
		)
	})
}

function whenTransitionEnds(el, cb) {
	const end = () => {
		el.removeEventListener('transitionend', onEnd)
		cb()
	}

	const onEnd = (e) => {
		if (e.target === el) {
			end()
		}
	}

	el.addEventListener('transitionend', onEnd)
}

function fadeIn(el) {
	el.classList.add('ct-fade-enter')

	let { height } = el.getBoundingClientRect()

	el.classList.add('ct-fade-leave')
	el.style.height = 0

	el.closest('form').classList.add('ct-has-dropdown')

	requestAnimationFrame(() => {
		el.style.height = `${height}px`
		el.classList.remove('ct-fade-enter')
		el.classList.add('ct-fade-enter-active')

		whenTransitionEnds(el, () => el.removeAttribute('style'))
	})
}

function debounce(fn, wait) {
	var timeout
	return function () {
		if (!wait) {
			return fn.apply(this, arguments)
		}
		var context = this
		var args = arguments
		clearTimeout(timeout)
		timeout = setTimeout(function () {
			timeout = null
			return fn.apply(context, args)
		}, wait)
	}
}

function values(obj) {
	var result = []

	if (typeof obj == 'object' || typeof obj == 'function') {
		var keys = Object.keys(obj)
		var len = keys.length

		for (var i = 0; i < len; i++) {
			result.push(obj[keys[i]])
		}

		return result
	}
}
