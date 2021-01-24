<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'blocksy' ); ?></label>
	<div class="ct-search-input">
		<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'blocksy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />

		<button class="search-submit" aria-label="<?php echo __('Search', 'blocksy')?>">
			<i>
				<svg
					width="12px"
					height="12px"
					viewBox="0 0 24 24">

					<path d="M23.3,23.3c-0.9,0.9-2.3,0.9-3.2,0l-4-4c-1.6,1-3.6,1.7-5.7,1.7C4.7,21,0,16.3,0,10.5S4.7,0,10.5,0C16.3,0,21,4.7,21,10.5
					c0,2.1-0.6,4-1.7,5.7l4,4C24.2,21,24.2,22.5,23.3,23.3z M10.5,3C6.4,3,3,6.4,3,10.5S6.4,18,10.5,18c4.1,0,7.5-3.4,7.5-7.5
					C18,6.4,14.7,3,10.5,3z"/>
				</svg>
			</i>

			<span data-loader="circles"><span></span><span></span><span></span></span>
		</button>
	</div>

	<input type="hidden" name="post_type" value="product" />
</form>

