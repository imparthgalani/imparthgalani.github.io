import { markImagesAsLoaded } from '../../frontend/lazy-load-helpers'
import {
	getCache,
	setRatioFor,
	watchOptionsWithPrefix,
	changeTagName,
	getOptionFor,
	getPrefixFor,
	maybeInsertBefore,
	applyPrefixFor
} from './helpers'
import { handleBackgroundOptionFor } from './variables/background'
import { relatedOptions } from './single/page-elements'

const getPrefix = () => {
	if (document.body.classList.contains('single')) {
		return 'post'
	}

	if (
		document.body.classList.contains('page') ||
		document.body.classList.contains('blog') ||
		document.body.classList.contains('post-type-archive-product')
	) {
		return 'page'
	}

	return false
}

export const renderComments = ({ prefix }) => {
	const commentsContainer = document.querySelector(
		'.site-main .ct-comments-container'
	)

	const comments = document.querySelector('.site-main .ct-comments')
	if (commentsContainer) {
		commentsContainer.remove()
	}
	if (comments) {
		comments.remove()
	}

	if (getOptionFor('has_comments', prefix) !== 'yes') {
		return
	}

	const newWrapper = document.createElement('div')
	if (
		!getCache().querySelector(
			'.ct-customizer-preview-cache [data-part="comments"]'
		)
	) {
		return
	}
	newWrapper.innerHTML = getCache().querySelector(
		'.ct-customizer-preview-cache [data-part="comments"]'
	).innerHTML

	const commentsContainment = getOptionFor('comments_containment', prefix)
	const relatedPostsContainment = wp.customize('related_posts_containment')()

	if (newWrapper.firstElementChild) {
		if (commentsContainment === 'separated') {
			maybeInsertBefore({
				el: newWrapper.firstElementChild,
				destination: document.querySelector('.site-main'),
				selector: '.ct-trending-block'
			})

			let container = document.querySelector(
				'.ct-comments-container > div'
			)
			container.classList.remove('ct-container', 'ct-container-narrow')
			container.classList.add(
				getOptionFor('comments_structure', prefix) === 'narrow'
					? 'ct-container-narrow'
					: 'ct-container'
			)

			if (relatedPostsContainment === 'separated') {
				if (wp.customize('related_location')() === 'after') {
					let relatedPostsContainer = document.querySelector(
						'.site-main .ct-related-posts-container'
					)

					if (relatedPostsContainer) {
						relatedPostsContainer.parentNode.appendChild(
							relatedPostsContainer
						)
					}
				}
			}
		} else {
			document
				.querySelector('.site-main #primary > div > section > article')
				.appendChild(
					newWrapper.firstElementChild.querySelector('.ct-comments')
				)

			if (relatedPostsContainment === 'contained') {
				if (wp.customize('related_location')() === 'after') {
					let relatedPostsContainer = document.querySelector(
						'.site-main #primary > div > section > article .ct-related-posts'
					)

					if (relatedPostsContainer) {
						relatedPostsContainer.parentNode.appendChild(
							relatedPostsContainer
						)
					}
				}
			}
		}
	}

	if (window.DISQUS) {
		window.DISQUS.host._loadEmbed()
	}
	markImagesAsLoaded(document.querySelector('.site-main'))
}

watchOptionsWithPrefix({
	getPrefix,

	getOptionsForPrefix: ({ prefix }) => [
		`${prefix}_has_comments`,
		`${prefix}_comments_structure`,
		`${prefix}_comments_containment`
	],

	render: renderComments
})

export const getCommentsVariables = () => {
	const prefix = getPrefixFor()

	return {
		[`${prefix}_comments_narrow_width`]: {
			variable: 'narrow-container-max-width',
			selector: applyPrefixFor('.ct-comments-container', prefix),
			unit: 'px'
		},

		[`${prefix}_comments_font_color`]: [
			{
				selector: applyPrefixFor('.ct-comments', prefix),
				variable: 'color',
				type: 'color:default'
			},

			{
				selector: applyPrefixFor('.ct-comments', prefix),
				variable: 'linkHoverColor',
				type: 'color:hover'
			}
		],

		...handleBackgroundOptionFor({
			id: `${prefix}_comments_background`,
			selector: applyPrefixFor('.ct-comments-container', prefix)
		})
	}
}
