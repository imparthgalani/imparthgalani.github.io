__webpack_public_path__ = ct_localizations.public_url

if (
	ct_localizations.internet_explorer_template &&
	(navigator.userAgent.indexOf('MSIE') !== -1 ||
		navigator.userAgent.indexOf('Trident') !== -1)
) {
	document.body.insertAdjacentHTML(
		'beforeend',
		ct_localizations.internet_explorer_template
	)

	document.body.classList.add('ct-ie')
}
