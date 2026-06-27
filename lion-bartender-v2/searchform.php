<?php
/**
 * Custom search form.
 *
 * @package Lion_Bartender
 */
?>
<form role="search" method="get" class="lb-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="lb-s"><?php esc_html_e( 'Search for:', 'lion-bartender' ); ?></label>
	<div style="display:flex;gap:10px;">
		<input type="search" id="lb-s" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search the bar…', 'lion-bartender' ); ?>">
		<button type="submit" class="lb-btn"><?php esc_html_e( 'Go', 'lion-bartender' ); ?></button>
	</div>
</form>
