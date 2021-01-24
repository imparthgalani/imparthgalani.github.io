import { createElement, useContext } from '@wordpress/element'
import { __ } from 'ct-i18n'
import cls from 'classnames'
import DraggableItems from './DraggableItems'
import { PanelContext } from '../../../options/components/PanelLevel'
import Row from './PlacementsBuilder/Row'

const PlacementsBuilder = ({
	inlinedItemsFromBuilder,
	view,
	builderValueWithView,
}) => {
	let hasOffcanvas =
		view === 'mobile' || inlinedItemsFromBuilder.indexOf('trigger') > -1

	return (
		<div
			className={cls('placements-builder', {
				'ct-mobile': hasOffcanvas,
			})}>
			{hasOffcanvas && (
				<ul className="offcanvas-container">
					<Row
						direction="vertical"
						bar={builderValueWithView.find(
							({ id }) => id === 'offcanvas'
						)}
					/>
				</ul>
			)}

			<ul className="horizontal-rows">
				{['top-row', 'middle-row', 'bottom-row'].map((bar) => (
					<Row
						bar={builderValueWithView.find(({ id }) => id === bar)}
						key={bar}
					/>
				))}
			</ul>
		</div>
	)
}

export default PlacementsBuilder
