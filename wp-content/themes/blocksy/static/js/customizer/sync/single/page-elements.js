import { markImagesAsLoaded } from '../../../frontend/lazy-load-helpers'
import {
	getCache,
	setRatioFor,
	changeTagName,
	getOptionFor,
	watchOptionsWithPrefix,
	maybeInsertBefore,
} from '../helpers'
import { renderComments } from '../comments'
import { renderSingleEntryMeta } from '../helpers/entry-meta'

export const refreshRelatedPosts = () => {
	if (!document.body.classList.contains('single')) {
		return
	}

	const relatedPostsContainer = document.querySelector(
		'.ct-related-posts-container'
	)
	const relatedPosts = document.querySelector('.ct-related-posts')

	if (relatedPostsContainer) {
		relatedPostsContainer.remove()
	}

	if (relatedPosts) {
		relatedPosts.remove()
	}

	if (wp.customize('has_related_posts')() !== 'yes') {
		return
	}

	const newWrapper = document.createElement('div')
	if (
		!getCache().querySelector(
			'.ct-customizer-preview-cache [data-part="related-posts"]'
		)
	) {
		return
	}

	newWrapper.innerHTML = getCache().querySelector(
		'.ct-customizer-preview-cache [data-part="related-posts"]'
	).innerHTML

	const relatedPostsContainment = wp.customize('related_posts_containment')()

	if (newWrapper.firstElementChild) {
		if (relatedPostsContainment === 'separated') {
			maybeInsertBefore({
				el: newWrapper.firstElementChild,
				destination: document.querySelector('.site-main'),
				selector: '.ct-trending-block',
			})

			document
				.querySelector('.ct-related-posts-container')
				.firstElementChild.classList.remove(
					'ct-container',
					'ct-container-narrow'
				)

			document
				.querySelector('.ct-related-posts-container')
				.firstElementChild.classList.add(
					wp.customize('related_structure')() === 'normal'
						? 'ct-container'
						: 'ct-container-narrow'
				)
		} else {
			document
				.querySelector('.site-main #primary > div > section > article')
				.appendChild(
					newWrapper.firstElementChild.querySelector(
						'.ct-related-posts'
					)
				)
		}
	}

	Array.from(
		new Array(
			20 - parseInt(wp.customize('related_posts_count')() || 20, 10)
		)
	).map(
		() =>
			document.querySelector(
				'.site-main .ct-related-posts[data-column-set]'
			).children.length -
				1 >
				parseInt(wp.customize('related_posts_count')() || 20, 10) &&
			document
				.querySelector('.site-main .ct-related-posts[data-column-set]')
				.removeChild(
					document.querySelector(
						'.site-main .ct-related-posts[data-column-set]'
					).lastElementChild
				)
	)

	document.querySelector(
		'.site-main .ct-related-posts[data-column-set]'
	).dataset.columnSet = wp.customize('related_posts_columns')() || 3

	document.querySelector(
		'.site-main .ct-related-posts .ct-block-title'
	).innerHTML = wp.customize('related_label')()

	changeTagName(
		document.querySelector('.site-main .ct-related-posts .ct-block-title'),
		wp.customize('related_label_wrapper')()
	)

	Array.from(
		document.querySelectorAll('.site-main .ct-related-posts .entry-meta')
	).map((el) =>
		renderSingleEntryMeta({
			el,
			meta_elements: wp.customize('related_single_meta_elements')(),
			meta_divider: 'slash',
		})
	)
	;[
		...document.querySelectorAll(
			'.ct-related-posts[data-column-set] .ct-image-container .ct-ratio'
		),
	].map((el) =>
		setRatioFor(wp.customize('related_featured_image_ratio')(), el)
	)

	markImagesAsLoaded(document.querySelector('.site-main'))
	renderComments({ prefix: 'post' })
}

export const relatedOptions = [
	'has_related_posts',
	'related_location',
	'related_single_meta_elements',
	'related_structure',
	'related_posts_columns',
	'related_posts_count',
	'related_label',
	'related_label_wrapper',
	'related_featured_image_ratio',
	'related_posts_containment',
]

watchOptionsWithPrefix({
	getOptionsForPrefix: () => relatedOptions,
	render: () => refreshRelatedPosts(),
})
