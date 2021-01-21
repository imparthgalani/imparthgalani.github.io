<?php
/**
 * Template Library Header Template
 */
?>
<label class="elementskit-template-library-filter-label">
	<input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="elementskit-library-filter">
	<span>{{ title }}</span>
</label>