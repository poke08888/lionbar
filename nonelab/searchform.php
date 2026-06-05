<?php
/**
 * Themed search form.
 *
 * @package Nonelab
 */
?>
<form role="search" method="get" class="form-field" style="max-width:420px;margin-top:24px" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="nl-search"><?php esc_html_e( 'Search for:', 'nonelab' ); ?></label>
	<input type="search" id="nl-search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search…', 'nonelab' ); ?>" />
	<button type="submit" class="btn solid" style="margin-top:12px;justify-content:center"><?php esc_html_e( 'Search', 'nonelab' ); ?></button>
</form>
