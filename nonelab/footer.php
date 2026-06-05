<?php
/**
 * Footer: brand, link columns, contact details (server-rendered, translatable).
 *
 * @package Nonelab
 */
?>
</main><!-- #content -->

<footer class="footer">
	<div class="wrap">
		<div class="footer-grid">
			<div>
				<a class="brand on-dark" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="orb"></span>nonelab</a>
				<p style="color:rgba(255,255,255,.6);margin-top:18px;max-width:340px;font-size:15px" data-i18n="foot.tag"><?php esc_html_e( 'A Vietnamese beauty & wellness group.', 'nonelab' ); ?></p>
			</div>
			<div>
				<h4 data-i18n="foot.explore"><?php esc_html_e( 'Explore', 'nonelab' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-i18n="foot.home"><?php esc_html_e( 'Home', 'nonelab' ); ?></a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'about' ) ); ?>" data-i18n="foot.about"><?php esc_html_e( 'About us', 'nonelab' ); ?></a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>" data-i18n="foot.brands"><?php esc_html_e( 'Our brands', 'nonelab' ); ?></a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'partners' ) ); ?>" data-i18n="foot.partners"><?php esc_html_e( 'Partners', 'nonelab' ); ?></a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'contact' ) ); ?>" data-i18n="foot.contact"><?php esc_html_e( 'Contact', 'nonelab' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4 data-i18n="foot.brandsCol"><?php esc_html_e( 'Our brands', 'nonelab' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>">Nerman</a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>">Mistory</a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>">Lion Bartender</a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>">Menow</a></li>
					<li><a href="<?php echo esc_url( nonelab_page_url( 'brands' ) ); ?>">Spenny</a></li>
				</ul>
			</div>
			<div>
				<h4 data-i18n="foot.reach"><?php esc_html_e( 'Reach us', 'nonelab' ); ?></h4>
				<ul>
					<li style="color:#fff;font-weight:600" data-i18n="foot.hn"><?php esc_html_e( 'Hanoi', 'nonelab' ); ?></li>
					<li data-i18n="foot.hnAddr">43 ngõ 100 Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam</li>
					<li style="color:#fff;font-weight:600;margin-top:8px" data-i18n="foot.emailLabel"><?php esc_html_e( 'Email', 'nonelab' ); ?></li>
					<li><a href="mailto:hello@nonelab.net" data-i18n="foot.email">hello@nonelab.net</a></li>
					<li style="color:#fff;font-weight:600;margin-top:8px" data-i18n="foot.hotlineLabel"><?php esc_html_e( 'Hotline', 'nonelab' ); ?></li>
					<li><a href="tel:19004628" data-i18n="foot.hotline">1900 4628</a></li>
				</ul>
			</div>
		</div>
		<div class="footer-bottom">
			<span data-i18n="foot.rights"><?php esc_html_e( '© 2025 Nonelab Group. All rights reserved.', 'nonelab' ); ?></span>
			<span data-i18n="foot.beauty"><?php esc_html_e( 'Beauty in your own way.', 'nonelab' ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
