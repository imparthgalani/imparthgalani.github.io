import {
	Fragment,
	createElement,
	createContext,
	useEffect,
	createPortal,
	useMemo,
	useRef,
	useState,
	useReducer,
	useCallback,
} from '@wordpress/element'
import {
	getDeepLinkPanel,
	removeDeepLink,
} from '../../customizer/preview-events'
import ctEvents from 'ct-events'

export const PanelContext = createContext({
	titlePrefix: '',
	isOpen: false,
	isTransitioning: false,

	previousPanel: false,
})

const panelsReducer = (state, action) => {
	if (action.type === 'PANEL_OPEN') {
		const { panelId } = action.payload

		if (state.isOpen && state.isOpen === panelId) {
			return state
		}

		if (state.isTransitioning) {
			return state
		}

		return {
			...state,
			isOpen: panelId,
			isTransitioning: panelId,
			...(state.isOpen
				? {
						previousPanel: state.isOpen,
				  }
				: {}),
		}
	}

	if (action.type === 'PANEL_RECEIVE_TITLE') {
		const { titlePrefix } = action.payload

		return {
			...state,
			titlePrefix,
		}
	}

	if (action.type === 'PANEL_CLOSE') {
		return {
			...state,
			isTransitioning: state.isOpen,
			isOpen: false,
		}
	}

	if (action.type === 'PANEL_FINISH_TRANSITIONING') {
		return {
			...state,
			isTransitioning: false,
			...(state.isOpen && state.isOpen !== state.previousPanel
				? {
						previousPanel: false,
				  }
				: {}),
		}
	}

	return state
}

const PanelLevel = ({
	id,
	children,
	containerRef,
	parentContainerRef,
	useRefsAsWrappers,
}) => {
	const [panelsState, panelsDispatch] = useReducer(panelsReducer, {
		isOpen: false,
		isTransitioning: false,
	})

	useEffect(() => {
		ctEvents.on('ct-deep-link-start', (location) => {
			const [_, panelId] = location.split(':')

			if (!panelId) {
				panelsDispatch({
					type: 'PANEL_CLOSE',
				})

				return
			}

			panelsDispatch({
				type: 'PANEL_OPEN',
				payload: { panelId },
			})
		})

		if (getDeepLinkPanel()) {
			setTimeout(() => {
				panelsDispatch({
					type: 'PANEL_OPEN',
					payload: { panelId: getDeepLinkPanel() },
				})

				removeDeepLink()
			}, 200)
		}
	}, [])

	return (
		<PanelContext.Provider
			value={{
				id,
				containerRef,
				panelsState,
				panelsDispatch,
				panelsHelpers: {
					isOpenFor: (panelId) =>
						panelsState.isOpen && panelId === panelsState.isOpen,
					isTransitioningFor: (panelId) =>
						(panelsState.previousPanel &&
							panelId === panelsState.previousPanel) ||
						(panelsState.isTransitioning &&
							panelId === panelsState.isTransitioning),

					open: (panelId) =>
						panelsDispatch({
							type: 'PANEL_OPEN',
							payload: { panelId },
						}),

					close: () => {
						panelsDispatch({
							type: 'PANEL_CLOSE',
						})
					},

					stopTransitioning: () => {
						panelsDispatch({
							type: 'PANEL_FINISH_TRANSITIONING',
						})
					},

					getWrapperParent: () =>
						useRefsAsWrappers
							? parentContainerRef.current
							: containerRef.current.closest(
									'[id="customize-theme-controls"]'
							  ),

					getParentOptionsWrapper: () =>
						useRefsAsWrappers
							? containerRef.current
							: containerRef.current.closest(
									'.accordion-section-content'
							  ),
				},
			}}>
			{children}
		</PanelContext.Provider>
	)
}

export default PanelLevel
