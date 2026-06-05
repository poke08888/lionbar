<?php
/**
 * Header: <head>, fixed navigation and mobile menu.
 *
 * The nav and footer are rendered server-side (rather than injected by JS as
 * in the prototype's chrome.js) so there is no layout shift and the markup is
 * crawlable. The data-i18n hooks are preserved so i18n.js still translates it.
 *
 * @package Nonelab
 */

$nl_page = nonelab_current_page();
$nl_act  = static function ( $key ) use ( $nl_page ) {
	return $key === $nl_page ? ' class="active"' : '';
};
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-page="<?php echo esc_attr( $nl_page ); ?>">
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nonelab' ); ?></a>

<header class="nav">
	<div class="nav-inner">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="orb"></span>nonelab</a>
		<?php endif; ?>

		<nav class="nav-links" aria-label="<?php esc_attr_e( 'Primary', 'nonelab' ); ?>">
			<a href="<?php echo esc_url( nonelab_page_url( 'about' ) ); ?>"<?php echo $nl_act( 'about' ); ?> data-i18n="nav.about"><?php esc_html_e( 'About', 'nonelab' ); ?></a>
			<a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>"<?php echo $nl_act( 'brands' ); ?> data-i18n="nav.brands"><?php esc_html_e( 'Brands', 'nonelab' ); ?></a>
			<a href="<?php echo esc_url( nonelab_page_url( 'partners' ) ); ?>"<?php echo $nl_act( 'partners' ); ?> data-i18n="nav.partners"><?php esc_html_e( 'Partners', 'nonelab' ); ?></a>
			<a href="<?php echo esc_url( nonelab_page_url( 'contact' ) ); ?>"<?php echo $nl_act( 'contact' ); ?> data-i18n="nav.contact"><?php esc_html_e( 'Contact', 'nonelab' ); ?></a>
		</nav>

		<div class="nav-right">
			<div class="lang">
				<button type="button" data-lang="en">EN</button>
				<button type="button" data-lang="vi">VI</button>
				<button type="button" data-lang="zh">中文</button>
			</div>
			<a class="btn grad" href="<?php echo esc_url( nonelab_page_url( 'contact' ) ); ?>"><span data-i18n="nav.cta"><?php esc_html_e( 'Partner with us', 'nonelab' ); ?></span></a>
			<button class="nav-burger" aria-label="<?php esc_attr_e( 'Menu', 'nonelab' ); ?>"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>

<div class="mobile-menu">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-i18n="foot.home"><?php esc_html_e( 'Home', 'nonelab' ); ?></a>
	<a href="<?php echo esc_url( nonelab_page_url( 'about' ) ); ?>" data-i18n="nav.about"><?php esc_html_e( 'About', 'nonelab' ); ?></a>
	<a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>" data-i18n="nav.brands"><?php esc_html_e( 'Brands', 'nonelab' ); ?></a>
	<a href="<?php echo esc_url( nonelab_page_url( 'partners' ) ); ?>" data-i18n="nav.partners"><?php esc_html_e( 'Partners', 'nonelab' ); ?></a>
	<a href="<?php echo esc_url( nonelab_page_url( 'contact' ) ); ?>" data-i18n="nav.contact"><?php esc_html_e( 'Contact', 'nonelab' ); ?></a>
	<div class="mm-lang lang" style="width:max-content">
		<button type="button" data-lang="en">EN</button>
		<button type="button" data-lang="vi">VI</button>
		<button type="button" data-lang="zh">中文</button>
	</div>
</div>

<main id="content">
