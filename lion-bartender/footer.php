<?php
/**
 * The footer.
 *
 * @package Lion_Bartender
 */
?>
<footer class="lb-footer" id="contact">
	<div class="lb-container">
		<div class="lb-footer__grid">

			<div class="lb-footer__about">
				<div class="lb-brand" style="margin-bottom:18px;">
					<span class="lb-brand__mark">L</span>
					<span class="lb-brand__name"><?php bloginfo( 'name' ); ?></span>
				</div>
				<p><?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : __( 'Bold cocktails, premium spirits and unforgettable nights — bottled for your home.', 'lion-bartender' ) ); ?></p>
				<div class="lb-social">
					<?php
					$socials = array(
						'lb_social_instagram' => 'IG',
						'lb_social_facebook'  => 'Fb',
						'lb_social_tiktok'    => 'Tk',
					);
					foreach ( $socials as $mod => $label ) {
						$url = get_theme_mod( $mod );
						if ( $url ) {
							printf( '<a href="%s" aria-label="%s">%s</a>', esc_url( $url ), esc_attr( $label ), esc_html( $label ) );
						}
					}
					?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Visit', 'lion-bartender' ); ?></h4>
				<p><?php echo esc_html( get_theme_mod( 'lb_contact_address', '88 Mane Street, Downtown' ) ); ?></p>
				<p><?php echo esc_html( get_theme_mod( 'lb_contact_hours', __( 'Tue–Sun · 5pm – 2am', 'lion-bartender' ) ) ); ?></p>
			</div>

			<div>
				<h4><?php esc_html_e( 'Contact', 'lion-bartender' ); ?></h4>
				<?php
				$phone = get_theme_mod( 'lb_contact_phone', '+1 (555) 010-2030' );
				$email = get_theme_mod( 'lb_contact_email', 'hello@lionbartender.com' );
				?>
				<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			</div>

			<div>
				<h4><?php esc_html_e( 'Explore', 'lion-bartender' ); ?></h4>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => '',
						'depth'          => 1,
					) );
				} else {
					echo '<ul>';
					if ( class_exists( 'WooCommerce' ) ) {
						echo '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'lion-bartender' ) . '</a></li>';
						echo '<li><a href="' . esc_url( wc_get_cart_url() ) . '">' . esc_html__( 'Cart', 'lion-bartender' ) . '</a></li>';
						echo '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '">' . esc_html__( 'My Account', 'lion-bartender' ) . '</a></li>';
					}
					echo '<li><a href="' . esc_url( home_url( '/cocktails' ) ) . '">' . esc_html__( 'Cocktail Menu', 'lion-bartender' ) . '</a></li>';
					echo '</ul>';
				}
				?>
			</div>

		</div>

		<div class="lb-footer__bottom">
			<p>
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'Please drink responsibly. 21+ only.', 'lion-bartender' ); ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
