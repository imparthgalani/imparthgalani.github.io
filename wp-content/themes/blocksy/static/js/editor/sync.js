export const handleMetaboxValueChange = (optionId, optionValue) => {
	if (
		optionId === 'page_structure_type' ||
		optionId === 'content_block_structure'
	) {
		let structure = ct_editor_localizations.default_page_structure

		if (optionValue !== 'default') {
			structure = optionValue === 'type-4' ? 'normal' : 'narrow'
		}

		document.body.classList.remove(
			'ct-structure-narrow',
			'ct-structure-normal'
		)

		document.body.classList.add(`ct-structure-${structure}`)
	}
}
