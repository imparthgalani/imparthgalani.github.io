const renderPassepartout = () => {
	document.body.removeAttribute('data-frame')

	if (wp.customize('has_passepartout')() === 'yes') {
		document.body.dataset.frame = 'default'
	}
}

wp.customize('has_passepartout', (val) =>
	val.bind((to) => {
		renderPassepartout()
	})
)

const renderFormsType = () => {
	document.body.dataset.forms = wp
		.customize('forms_type')()
		.replace('-forms', '')
}

wp.customize('forms_type', (val) => val.bind((to) => renderFormsType()))
wp.customize('form_elements_panel', (val) =>
	val.bind((to) => renderFormsType())
)
