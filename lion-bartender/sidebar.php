<?php
/**
 * The sidebar.
 *
 * @package Lion_Bartender
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="lb-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'lion-bartender' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
