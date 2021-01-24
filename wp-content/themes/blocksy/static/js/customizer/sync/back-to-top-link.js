import { responsiveClassesFor } from './helpers'
import { checkAndReplace } from './helpers'
import ctEvents from 'ct-events'

checkAndReplace({
	id: 'has_back_top',

	parent_selector: 'body',
	selector: '.ct-back-to-top',
	fragment_id: 'back-to-top-link',

	strategy: 'maybeBefore:#search-modal',

	watch: [
		'top_button_type',
		'top_button_shape',
		'top_button_alignment',
		'back_top_visibility'
	],

	beforeInsert: el =>
		window.scrollY > 500
			? el.classList.add('ct-show')
			: el.classList.remove('ct-show'),

	whenInserted: () => {
		const backTop = document.querySelector('.ct-back-to-top')

		ctEvents.trigger('ct:back-to-top:mount')

		responsiveClassesFor('back_top_visibility', backTop)

		backTop.innerHTML = document.querySelector(
			`.ct-back-to-top [data-top="${wp.customize('top_button_type')()}"]`
		).innerHTML

		backTop.dataset.shape = wp.customize('top_button_shape')()
		backTop.dataset.alignment = wp.customize('top_button_alignment')()
	}
})
