<?php
/**
 * Template item
 */
?>
<# var activeTab = window.ElementsKitLibreryData.tabs[ type ]; #>
<div class="elementor-template-library-template-body">
	<# if ( 'elementskit-local' !== source ) { #>
	<div class="elementor-template-library-template-screenshot">
		<# if ( 'elementskit-local' !== source ) { #>
		<div class="elementor-template-library-template-preview">
			<i class="fa fa-search-plus"></i>
		</div>
		<# } #>
		<img src="{{ thumbnail }}" alt="">
	</div>
	<# } #>
</div>
<div class="elementor-template-library-template-controls">
	<# if ( 'pro' != package ) { #>
		<button class="elementor-template-library-template-action elementskit-template-library-template-insert elementor-button elementor-button-success">
			<i class="eicon-file-download"></i>
			<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'elementskit-lite' ); ?></span>
		</button>
	<# } else { #>
		<a class="elementor-template-library-template-action elementor-button elementskit-template-library-template-go-pro" href="https://go.wpmet.com/ekitpro" target="_blank">
			<i class="eicon-heart"></i><span class="elementor-button-title"><?php
				esc_html_e( 'Go Premium', 'elementskit-lite' );
			?></span>
		</a>
	<# } #>
</div>
<# if ( 'elementskit-local' === source || true == activeTab.settings.show_title ) { #>
<div class="elementor-template-library-template-name">{{{ title }}}</div>
<# } else { #>
<div class="elementor-template-library-template-name-holder"></div>
<# } #>
<# if ( 'elementskit-local' === source ) { #>
<div class="elementor-template-library-template-type">
	<?php esc_html_e( 'Type:', 'elementskit-lite' ); ?> {{{ typeLabel }}}
</div>
<# } #>