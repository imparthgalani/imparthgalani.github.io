import { createElement, Component, Fragment } from '@wordpress/element'
import classnames from 'classnames'
import { __ } from 'ct-i18n'
import _ from 'underscore'

export default class MultiImageUploader extends Component {
	params = {
		height: 250,
		width: 250,
		flex_width: true,
		flex_height: true,
	}

	state = {
		attachment_info: [],
	}

	getUrlFor = (attachmentInfo) =>
		attachmentInfo
			? (attachmentInfo.width < 700
					? attachmentInfo.sizes.full
					: _.max(
							_.values(
								_.keys(attachmentInfo.sizes).length === 1
									? attachmentInfo.sizes
									: _.omit(attachmentInfo.sizes, 'full')
							),
							({ width }) => width
					  )
			  ).url || attachmentInfo.url
			: null

	initFrame() {
		this.frame = wp.media({
			button: {
				text: 'Select',
				close: false,
			},
			states: [
				new wp.media.controller.Library({
					title: 'Select images',
					library: wp.media.query({ type: 'image' }),
					multiple: true,
					date: false,
					priority: 20,
				}),
			],
		})

		this.frame.on('select', this.onSelect, this)
		this.frame.on('close', () => {
			this.props.option.onFrameClose && this.props.option.onFrameClose()
		})

		this.frame.on('open', () => {
			if (Array.isArray(this.props.value)) {
				this.props.value.map(({ attachment_id }) => {
					var selection = this.frame.state().get('selection')
					const attachment = wp.media.attachment(attachment_id)
					attachment.fetch()
					selection.add(attachment ? [attachment] : [])
				})
			}
		})
	}

	openFrame() {
		this.initFrame()
		this.frame.setState('library').open()
	}

	onSelect = () => {
		const result = this.frame
			.state()
			.get('selection')
			.toArray()
			.map((attachment) => ({
				url: this.getUrlFor(attachment.toJSON()),
				attachment_id: attachment.toJSON().id,
			}))

		this.props.onChange(result)
		this.frame.close()
	}

	render() {
		return (
			<div
				className={classnames('ct-attachment-multi', {})}
				{...(this.props.option.attr || {})}>
				<Fragment>
					{Array.isArray(this.props.value) &&
						this.props.value.length > 0 && (
							<div className="ct-thumbnails-list">
								{this.props.value.map(
									({ url, attachment_id }) => (
										<div
											key={attachment_id}
											className="thumbnail thumbnail-image"
											onClick={() => {
												this.openFrame()
											}}>
											<img
												className="attachment-thumb"
												src={url}
												draggable="false"
												alt=""
											/>

											<div className="actions">
												<button
													type="button"
													className="button edit-button control-focus"
													title="Edit"
													onClick={() => this.openFrame()}
													id="customize-media-control-button-35"></button>
												<button
													title="Remove"
													type="button"
													className="button remove-button"
													onClick={(e) => {
														e.stopPropagation()

														this.props.onChange(
															this.props.value.filter(
																(a) =>
																	a.attachment_id !==
																	attachment_id
															)
														)
													}}>
												</button>
											</div>
										</div>
									)
								)}
							</div>
						)}

					<button
						type="button"
						className="button edit-button control-focus"
						title="Edit"
						onClick={() => this.openFrame()}>
						Add/Edit Gallery
					</button>
				</Fragment>
			</div>
		)
	}
}
