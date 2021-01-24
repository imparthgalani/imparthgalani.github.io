/*
import { checkAndReplace, responsiveClassesFor } from './helpers'
import { markImagesAsLoaded } from '../../frontend/lazy-load-helpers'

checkAndReplace({
	id: 'has_trending_block',
	parent_selector: '#main',
	selector: '.ct-trending-block',
	fragment_id: 'blocksy-trending-block',
	strategy: 'maybeBefore:.ct-instagram-block',
	watch: ['trending_block_visibility'],
	whenInserted: () => {
		const trending = document.querySelector('.ct-trending-block')

		markImagesAsLoaded(trending)
		ctEvents.trigger('ct:trending-block:mount')
		responsiveClassesFor('trending_block_visibility', trending)
	}
})
*/
