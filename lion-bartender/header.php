<?php
/**
 * The header.
 *
 * @package Lion_Bartender
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'lion-bartender' ); ?></a>

<header class="lb-header" id="lb-header">
	<div class="lb-container lb-header__inner">

		<div class="lb-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="lb-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration:none;">
					<span class="lb-brand__mark">L</span>
					<span class="lb-brand__name"><?php bloginfo( 'name' ); ?><small><?php esc_html_e( 'Cocktail House', 'lion-bartender' ); ?></small></span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="lb-nav" id="lb-nav" aria-label="<?php esc_attr_e( 'Primary', 'lion-bartender' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
				) );
			} else {
				echo '<ul>';
				echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'lion-bartender' ) . '</a></li>';
				echo '<li><a href="#about">' . esc_html__( 'About', 'lion-bartender' ) . '</a></li>';
				echo '<li><a href="#menu">' . esc_html__( 'Menu', 'lion-bartender' ) . '</a></li>';
				if ( class_exists( 'WooCommerce' ) ) {
					echo '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'lion-bartender' ) . '</a></li>';
				}
				echo '<li><a href="#contact">' . esc_html__( 'Contact', 'lion-bartender' ) . '</a></li>';
				echo '</ul>';
			}
			?>
		</nav>

		<div class="lb-header__actions">
			<?php lion_bartender_cart_link(); ?>
			<button class="lb-burger" id="lb-burger" aria-label="<?php esc_attr_e( 'Toggle menu', 'lion-bartender' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>

	</div>
</header>
