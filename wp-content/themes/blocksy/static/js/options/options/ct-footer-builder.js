import {
	createElement,
	Fragment,
	useRef,
	Component,
	useEffect,
	useMemo,
	createPortal,
	useState,
	useCallback,
	createContext,
	useReducer,
} from '@wordpress/element'
import { __ } from 'ct-i18n'

import ColumnsBuilder from '../../customizer/panels-builder/columns/ColumnsBuilder'
import AvailableItems from '../../customizer/panels-builder/columns/AvailableItems'

import { builderReducer } from '../../customizer/panels-builder/columns/builderReducer'
export const DragDropContext = createContext({})

const getDocument = (x) =>
	x.document || x.contentDocument || x.contentWindow.document

export const fetchCurrentFooter = () => {
	const document = getDocument(
		wp.customize.previewer.container.find('iframe')[0]
	)

	if (
		wp.customize.previewer.container
			.find('iframe')[0]
			.contentDocument.querySelector('footer.ct-footer')
	) {
		return wp.customize.previewer.container
			.find('iframe')[0]
			.contentDocument.querySelector('footer.ct-footer').dataset.id
	}

	return null
}

const FooterBuilder = ({
	value: allBuilderSections,
	option,
	onChange: onBuilderValueChange,
}) => {
	const currentFooter = useRef(null)

	if (currentFooter.current === null) {
		currentFooter.current = (
			allBuilderSections.sections.find(
				({ id }) => id.indexOf(fetchCurrentFooter()) > -1
			) || allBuilderSections.sections[0]
		).id
	}

	useEffect(() => {
		let {
			__forced_static_footer__,
			__should_refresh__,
			...old
		} = wp.customize('footer_placements')()

		Object.keys(old).map((key) => {
			if (parseFloat(key)) {
				delete old[key]
			}
		})

		wp.customize('footer_placements')({
			...old,
			__forced_static_footer__: (
				allBuilderSections.sections.find(
					({ id }) => id.indexOf(fetchCurrentFooter()) > -1
				) || allBuilderSections.sections[0]
			).id,
		})

		return () => {
			const { __forced_static_footer__, ...old } = wp.customize(
				'footer_placements'
			)()

			wp.customize('footer_placements')({
				__should_refresh__: true,
				[Math.random()]: 'update',
				...old,
			})
		}
	}, [])

	const [builderValueCollection, builderValueDispatchInternal] = useReducer(
		builderReducer,
		{
			...allBuilderSections,
			...(currentFooter.current
				? {
						__forced_static_footer__: currentFooter.current,
				  }
				: {}),
		}
	)

	const [builderCollapsed, setBuilderCollapsed] = useState(false)

	const builderValue = useMemo(
		() =>
			builderValueCollection.sections.find(
				({ id }) =>
					id === builderValueCollection.__forced_static_footer__
			) || builderValueCollection.sections[0],
		[builderValueCollection]
	)

	const [isDragging, setIsDragging] = useState(false)

	const inlinedItemsFromBuilder = builderValue.rows.reduce(
		(currentItems, { columns }) => [
			...currentItems,
			...(columns || []).reduce((c, items) => [...c, ...items], []),
		],
		[]
	)

	const builderValueDispatch = useCallback(
		(payload) =>
			builderValueDispatchInternal({
				...payload,
				onBuilderValueChange,
			}),
		[builderValueDispatchInternal, onBuilderValueChange]
	)

	const setList = (lists) =>
		builderValueDispatch({
			type: 'SET_LIST',
			onBuilderValueChange,
			payload: {
				lists,
			},
		})

	useEffect(() => {
		return () => {
			document
				.querySelector('.wp-full-overlay')
				.classList.remove('ct-builder-collapsed')
		}
	}, [])

	return (
		<Fragment>
			<DragDropContext.Provider
				value={{
					isDragging,
					setIsDragging,
					setList,
					builderValueDispatch,
					builderValueCollection,
					builderValue,
					onChange: ({ id, value }) => setList({ [id]: value }),
				}}>
				<AvailableItems
					builderValue={builderValue}
					inlinedItemsFromBuilder={inlinedItemsFromBuilder}
					builderValueDispatch={builderValueDispatch}
					builderValueCollection={builderValueCollection}
				/>

				{createPortal(
					<div className="ct-builder-footer">
						<ul className="ct-view-switch">
							<li
								className="ct-builder-toggle"
								onClick={() => {
									setBuilderCollapsed(!builderCollapsed)

									if (builderCollapsed) {
										document
											.querySelector('.wp-full-overlay')
											.classList.remove(
												'ct-builder-collapsed'
											)
									} else {
										document
											.querySelector('.wp-full-overlay')
											.classList.add(
												'ct-builder-collapsed'
											)
									}
								}}>
								{builderCollapsed
									? __('Show Builder', 'blocksy')
									: __('Hide Builder', 'blocksy')}
							</li>
						</ul>

						<ColumnsBuilder builderValue={builderValue} />
					</div>,
					document.querySelector('.ct-panel-builder')
				)}
			</DragDropContext.Provider>
		</Fragment>
	)
}

FooterBuilder.renderingConfig = { design: 'none' }

export default FooterBuilder
