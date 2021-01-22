( function( $ ) {
	wp.customize( 'simple_css[css]', function( value ) {
		value.bind( function( newval ) {
			if ( ! $( '#simple-css-output' ).length ) {
				$( '<style id="simple-css-output"></style>' ).appendTo( 'head' );
			}

			$( '#simple-css-output' ).text( newval );
		} );
	} );
} )( jQuery );
