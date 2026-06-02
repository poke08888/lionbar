<?php
/**
 * WooCommerce wrapper template.
 *
 * Used for every WooCommerce page (shop, product, cart, checkout, account).
 * The actual content is output by woocommerce_content() while our theme
 * supplies the surrounding chrome via the before/after hooks in functions.php.
 *
 * @package Lion_Bartender
 */

get_header();
?>

<div class="lb-page-title" style="padding-top:130px;">
	<span class="lb-eyebrow"><?php esc_html_e( 'Lion Bartender Shop', 'lion-bartender' ); ?></span>
	<?php if ( is_shop() || is_product_category() || is_product_taxonomy() ) : ?>
		<h1><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	<div class="lb-rule"></div>
</div>

<?php
woocommerce_content();

get_footer();
