import {
	createElement,
	Fragment,
	Component,
	useCallback,
	useRef,
	useEffect,
	useState,
} from '@wordpress/element'
import { registerPlugin, withPluginContext } from '@wordpress/plugins'
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post'
import { withSelect, withDispatch } from '@wordpress/data'
import { compose } from '@wordpress/compose'
import { IconButton } from '@wordpress/components'
import { handleMetaboxValueChange } from './editor/sync'

import ctEvents from 'ct-events'

import { __ } from 'ct-i18n'

import {
	OptionsPanel,
	getValueFromInput,
	PanelLevel,
	DeviceManagerProvider,
} from 'blocksy-options'

const BlocksyOptions = ({
	name,
	value,
	options,
	onChange,
	isActive,
	isPinnable = true,
	isPinned,
	togglePin,
	toggleSidebar,
	closeGeneralSidebar,
}) => {
	const containerRef = useRef()
	const parentContainerRef = useRef()
	const [values, setValues] = useState(null)

	useEffect(() => {
		document.body.classList[isActive ? 'add' : 'remove'](
			'blocksy-sidebar-active'
		)
	}, [isActive])

	const handleChange = useCallback(({ id: key, value: v }) => {
		const futureValue = {
			...(values || getValueFromInput(options, value || {})),
			[key]: v,
		}

		handleMetaboxValueChange(key, v)

		onChange(futureValue)
		setValues(futureValue)
	}, [])

	useEffect(() => {
		ctEvents.on('ct:metabox:options:trigger-change', handleChange)

		return () => {
			ctEvents.off('ct:metabox:options:trigger-change', handleChange)
		}
	}, [])

	return (
		<Fragment>
			<PluginSidebarMoreMenuItem target="blocksy" icon="admin-customizer">
				{__('Blocksy Page Settings', 'blocksy')}
			</PluginSidebarMoreMenuItem>

			<PluginSidebar
				name={name}
				icon={
					
						<svg width="20" height="20" viewBox="0 0 60 60"><path d="M30 0c16.569 0 30 13.431 30 30 0 16.569-13.431 30-30 30C13.431 60 0 46.569 0 30 0 13.431 13.431 0 30 0zm8.07 30.552a.381.381 0 00-.507 0L21.08 45.718c-.113.104-.033.282.126.282h15.424c.19 0 .372-.07.506-.193l7.233-6.657c.84-.774.84-2.027 0-2.8zm0-16.5a.381.381 0 00-.507 0L19.21 30.94a.635.635 0 00-.21.467v12.56c0 .148.193.222.306.118l23.784-22c.84-.773.84-2.622 0-3.395zM34.72 13H19.358c-.197 0-.358.148-.358.33v14.138c0 .147.193.22.306.117l15.54-14.303c.114-.104.033-.282-.126-.282z" fill-rule="evenodd"/></svg>
					
				}
				className="ct-components-panel"
				title={__('Blocksy Page Settings', 'blocksy')}>
				<div id="ct-page-options" ref={parentContainerRef}>
					<div className="ct-options-container" ref={containerRef}>
						<DeviceManagerProvider>
							<PanelLevel
								containerRef={containerRef}
								parentContainerRef={parentContainerRef}
								useRefsAsWrappers>
								<div className="ct-panel-options-header components-panel__header edit-post-sidebar-header">
									<strong>
										{__('Blocksy Page Settings', 'blocksy')}
									</strong>

									{isPinnable && (
										<IconButton
											icon={
												isPinned
													? 'star-filled'
													: 'star-empty'
											}
											label={
												isPinned
													? __(
															'Unpin from toolbar',
															'blocksy'
													  )
													: __(
															'Pin to toolbar',
															'blocksy'
													  )
											}
											onClick={togglePin}
											isPressed={isPinned}
											aria-expanded={isPinned}
										/>
									)}

									<IconButton
										onClick={closeGeneralSidebar}
										icon="no-alt"
										label={__('Close plugin', 'blocksy')}
									/>
								</div>
								<OptionsPanel
									onChange={(key, v) => {
										const futureValue = {
											...(values ||
												getValueFromInput(
													options,
													value || {}
												)),
											[key]: v,
										}

										handleMetaboxValueChange(key, v)

										onChange(futureValue)
										setValues(futureValue)
									}}
									value={
										values ||
										getValueFromInput(options, value || {})
									}
									options={options}
								/>
							</PanelLevel>
						</DeviceManagerProvider>
					</div>
				</div>
			</PluginSidebar>
		</Fragment>
	)
}

const BlocksyOptionsComposed = compose(
	withPluginContext((context, { name }) => ({
		sidebarName: `${context.name}/${name}`,
	})),

	withSelect((select, { sidebarName }) => {
		const value = select('core/editor').getEditedPostAttribute(
			'blocksy_meta'
		)

		const { getActiveGeneralSidebarName, isPluginItemPinned } = select(
			'core/edit-post'
		)

		return {
			isActive: getActiveGeneralSidebarName() === sidebarName,
			isPinned: isPluginItemPinned(sidebarName),
			value: Array.isArray(value) ? {} : value || {},
			options: ct_editor_localizations.post_options,
		}
	}),
	withDispatch((dispatch, { sidebarName }) => {
		const {
			closeGeneralSidebar,
			openGeneralSidebar,
			togglePinnedPluginItem,
		} = dispatch('core/edit-post')

		return {
			closeGeneralSidebar,
			togglePin: () => {
				togglePinnedPluginItem(sidebarName)
			},

			onChange: (blocksy_meta) => {
				dispatch('core/editor').editPost({
					blocksy_meta,
				})
			},
		}
	})
)(BlocksyOptions)

if (ct_editor_localizations.post_options) {
	registerPlugin('blocksy', {
		render: () => <BlocksyOptionsComposed name="blocksy" />,
	})
}
