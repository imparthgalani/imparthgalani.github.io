import { handleVariablesFor } from 'customizer-sync-helpers'
import {
	handleBackgroundOptionFor,
	responsiveClassesFor
} from 'blocksy-customizer-sync'

handleVariablesFor({
	trendingBlockContainerSpacing: {
		selector: '.ct-trending-block',
		variable: 'padding',
		responsive: true,
		unit: ''
	},

	trendingBlockFontColor: [
		{
			selector: '.ct-trending-block',
			variable: 'color',
			type: 'color:default'
		},

		{
			selector: '.ct-trending-block',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	...handleBackgroundOptionFor({
		id: 'trending_block_background',
		selector: '.ct-trending-block'
	})
})

wp.customize('trending_block_visibility', value =>
	value.bind(to =>
		responsiveClassesFor(
			'trending_block_visibility',
			document.querySelector('.ct-trending-block')
		)
	)
)
