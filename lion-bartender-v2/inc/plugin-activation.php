<?php
/**
 * Recommended plugins prompt.
 *
 * Lion Bartender needs WooCommerce to power its shop. Rather than bundling a
 * full TGMPA copy, this lightweight notice gives the admin a one-click install
 * link via the native WordPress plugin installer.
 *
 * @package Lion_Bartender
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Show an admin notice prompting WooCommerce installation/activation.
 */
function lion_bartender_woocommerce_notice() {
	if ( class_exists( 'WooCommerce' ) ) {
		return;
	}
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	if ( get_user_meta( get_current_user_id(), 'lion_bartender_dismiss_wc', true ) ) {
		return;
	}

	// Is WooCommerce installed but inactive?
	$installed = false;
	if ( function_exists( 'get_plugins' ) ) {
		$plugins   = get_plugins();
		$installed = isset( $plugins['woocommerce/woocommerce.php'] );
	}

	if ( $installed ) {
		$action_url  = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php' ),
			'activate-plugin_woocommerce/woocommerce.php'
		);
		$action_text = __( 'Activate WooCommerce', 'lion-bartender' );
	} else {
		$action_url  = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ),
			'install-plugin_woocommerce'
		);
		$action_text = __( 'Install WooCommerce', 'lion-bartender' );
	}

	$dismiss_url = wp_nonce_url(
		add_query_arg( 'lion_bartender_dismiss_wc', '1' ),
		'lion_bartender_dismiss_wc'
	);
	?>
	<div class="notice notice-info">
		<p>
			<strong><?php esc_html_e( 'Lion Bartender', 'lion-bartender' ); ?></strong> —
			<?php esc_html_e( 'install WooCommerce to unlock the online store: sell cocktail kits, spirits, bar tools, gift cards and event packages.', 'lion-bartender' ); ?>
		</p>
		<p>
			<a href="<?php echo esc_url( $action_url ); ?>" class="button button-primary"><?php echo esc_html( $action_text ); ?></a>
			<a href="<?php echo esc_url( $dismiss_url ); ?>" class="button-link" style="margin-left:8px;"><?php esc_html_e( 'Dismiss', 'lion-bartender' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'lion_bartender_woocommerce_notice' );

/**
 * Persist the dismissal.
 */
function lion_bartender_dismiss_wc_notice() {
	if ( isset( $_GET['lion_bartender_dismiss_wc'] ) && check_admin_referer( 'lion_bartender_dismiss_wc' ) ) {
		update_user_meta( get_current_user_id(), 'lion_bartender_dismiss_wc', 1 );
	}
}
add_action( 'admin_init', 'lion_bartender_dismiss_wc_notice' );
