<?php
/**
 * The homepage template.
 *
 * Sections: Hero, Feature strip, About, Cocktail Menu (CPT), Shop teaser
 * (WooCommerce), Testimonials and a booking CTA.
 *
 * @package Lion_Bartender
 */

get_header();

$hero_image = get_theme_mod( 'lb_hero_image' );
?>

<main id="main" class="lb-main">

	<!-- ============ HERO ============ -->
	<section class="lb-hero" aria-labelledby="lb-hero-title" <?php if ( $hero_image ) : ?>style="background-image:url('<?php echo esc_url( $hero_image ); ?>');"<?php endif; ?>>
		<div class="lb-container">
			<div class="lb-hero__inner">
				<span class="lb-eyebrow"><?php echo wp_kses_post( get_theme_mod( 'lb_hero_eyebrow', __( 'Craft Cocktails &amp; Late Nights', 'lion-bartender' ) ) ); ?></span>
				<h1 id="lb-hero-title"><?php echo wp_kses_post( get_theme_mod( 'lb_hero_title', __( 'Where the Lion Pours', 'lion-bartender' ) ) ); ?></h1>
				<p><?php echo wp_kses_post( get_theme_mod( 'lb_hero_subtitle', __( 'A bold cocktail lounge serving signature drinks, premium spirits and unforgettable nights. Now bottling our craft at home — shop the collection.', 'lion-bartender' ) ) ); ?></p>
				<div class="lb-hero__cta">
					<?php
					$btn1_text = get_theme_mod( 'lb_hero_btn1_text', __( 'Reserve a Table', 'lion-bartender' ) );
					$btn1_url  = get_theme_mod( 'lb_hero_btn1_url', '#contact' );
					$btn2_text = get_theme_mod( 'lb_hero_btn2_text', __( 'Shop the Bar', 'lion-bartender' ) );
					$btn2_url  = get_theme_mod( 'lb_hero_btn2_url', '/shop' );
					if ( $btn1_text ) {
						printf( '<a class="lb-btn" href="%s">%s</a>', esc_url( $btn1_url ), esc_html( $btn1_text ) );
					}
					if ( $btn2_text ) {
						printf( '<a class="lb-btn lb-btn--ghost" href="%s">%s</a>', esc_url( $btn2_url ), esc_html( $btn2_text ) );
					}
					?>
				</div>
			</div>
		</div>
		<a class="lb-hero__scroll" href="#about" aria-label="<?php esc_attr_e( 'Scroll to discover more', 'lion-bartender' ); ?>">
			<span><?php esc_html_e( 'Scroll', 'lion-bartender' ); ?></span>
			<svg class="lb-hero__scroll-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m6 9 6 6 6-6"/></svg>
		</a>
	</section>

	<!-- ============ FEATURE STRIP ============ -->
	<section class="lb-section lb-section--flush" aria-label="<?php esc_attr_e( 'Why Lion Bartender', 'lion-bartender' ); ?>">
		<div class="lb-container lb-features-wrap">
			<ul class="lb-features">
				<li class="lb-feature">
					<span class="lb-feature__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M8 22h8"/><path d="M12 11v11"/><path d="m19 3-7 8-7-8Z"/></svg>
					</span>
					<h3><?php esc_html_e( 'Signature Craft', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'Drinks mixed by award-winning bartenders.', 'lion-bartender' ); ?></p>
				</li>
				<li class="lb-feature">
					<span class="lb-feature__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/></svg>
					</span>
					<h3><?php esc_html_e( 'Premium Spirits', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'A curated shelf of rare and small-batch labels.', 'lion-bartender' ); ?></p>
				</li>
				<li class="lb-feature">
					<span class="lb-feature__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
					</span>
					<h3><?php esc_html_e( 'Shipped to You', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'Cocktail kits &amp; bottles delivered to your door.', 'lion-bartender' ); ?></p>
				</li>
			</ul>
		</div>
	</section>

	<!-- ============ ABOUT ============ -->
	<section class="lb-section" id="about" aria-labelledby="lb-about-title">
		<div class="lb-container">
			<div class="lb-about">
				<div class="lb-about__media">
					<?php $about_img = get_theme_mod( 'lb_about_image' ); ?>
					<img src="<?php echo esc_url( $about_img ? $about_img : 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=900&q=80' ); ?>" alt="<?php esc_attr_e( 'Bartenders mixing cocktails inside the Lion Bartender lounge', 'lion-bartender' ); ?>" width="900" height="1100" loading="lazy" decoding="async">
					<div class="lb-about__badge">
						<strong><?php echo esc_html( get_theme_mod( 'lb_about_years', '12' ) ); ?></strong>
						<span><?php echo esc_html( get_theme_mod( 'lb_about_years_label', __( 'Years Pouring', 'lion-bartender' ) ) ); ?></span>
					</div>
				</div>
				<div class="lb-about__body">
					<span class="lb-eyebrow"><?php esc_html_e( 'Our Story', 'lion-bartender' ); ?></span>
					<h2 id="lb-about-title"><?php echo wp_kses_post( get_theme_mod( 'lb_about_title', __( 'Born in the Den, Crafted with Pride', 'lion-bartender' ) ) ); ?></h2>
					<div class="lb-rule lb-rule--left"></div>
					<p><?php echo wp_kses_post( get_theme_mod( 'lb_about_text', __( 'For over a decade Lion Bartender has been mixing fearless flavours in the heart of the city. Our master bartenders blend heritage techniques with a wild, modern edge — and now you can bring that spirit home.', 'lion-bartender' ) ) ); ?></p>
					<a class="lb-btn lb-btn--ghost" href="#menu"><?php esc_html_e( 'View the Menu', 'lion-bartender' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ COCKTAIL MENU ============ -->
	<section class="lb-section lb-section--alt" id="menu" aria-labelledby="lb-menu-title">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'On the Menu', 'lion-bartender' ); ?></span>
				<h2 id="lb-menu-title"><?php esc_html_e( 'Signature Cocktails', 'lion-bartender' ); ?></h2>
				<div class="lb-rule"></div>
				<p><?php esc_html_e( 'A taste of what is shaking behind the bar tonight.', 'lion-bartender' ); ?></p>
			</div>

			<?php
			$cocktails = new WP_Query( array(
				'post_type'      => 'cocktail',
				'posts_per_page' => 6,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );

			if ( $cocktails->have_posts() ) : ?>
				<div class="lb-menu-grid">
					<?php while ( $cocktails->have_posts() ) : $cocktails->the_post(); ?>
						<?php lion_bartender_render_cocktail_item( get_the_ID() ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata();
			else : ?>
				<p class="lb-empty">
					<?php esc_html_e( 'Add cocktails under “Cocktail Menu” in the dashboard to populate this section.', 'lion-bartender' ); ?>
				</p>
			<?php endif; ?>

			<div class="lb-center-cta">
				<a class="lb-btn" href="<?php echo esc_url( home_url( '/cocktails' ) ); ?>"><?php esc_html_e( 'Full Drinks List', 'lion-bartender' ); ?></a>
			</div>
		</div>
	</section>

	<!-- ============ SHOP TEASER ============ -->
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	<section class="lb-section" id="shop" aria-labelledby="lb-shop-title">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'From Our Shelf to Yours', 'lion-bartender' ); ?></span>
				<h2 id="lb-shop-title"><?php esc_html_e( 'Shop the Bar', 'lion-bartender' ); ?></h2>
				<div class="lb-rule"></div>
				<p><?php esc_html_e( 'Cocktail kits, premium bottles, glassware and gift cards — delivered.', 'lion-bartender' ); ?></p>
			</div>

			<div class="lb-products woocommerce">
				<?php
				echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" class="lb-shop-teaser"]' );
				?>
			</div>

			<div class="lb-center-cta">
				<a class="lb-btn" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Visit the Shop', 'lion-bartender' ); ?></a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ============ TESTIMONIALS ============ -->
	<section class="lb-section lb-section--alt" aria-labelledby="lb-quotes-title">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'The Pride Speaks', 'lion-bartender' ); ?></span>
				<h2 id="lb-quotes-title"><?php esc_html_e( 'Loved by Night Owls', 'lion-bartender' ); ?></h2>
				<div class="lb-rule"></div>
			</div>
			<div class="lb-quotes">
				<?php
				$quotes = array(
					array( __( 'The best Old Fashioned in the city — and the home kit is just as good. Pure magic in a glass.', 'lion-bartender' ), 'Amara K.' ),
					array( __( 'Atmosphere, service, drinks: a perfect 10. The lion roars and so do the cocktails.', 'lion-bartender' ), 'Diego R.' ),
					array( __( 'Ordered the negroni bundle for a party and everyone asked where I got it. Lion Bartender, obviously.', 'lion-bartender' ), 'Priya S.' ),
				);
				$star_label = esc_attr__( 'Rated 5 out of 5 stars', 'lion-bartender' );
				$star_svg   = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="m12 2 2.9 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l7.1-1.01z"/></svg>';
				foreach ( $quotes as $q ) : ?>
					<figure class="lb-quote">
						<div class="lb-quote__stars" role="img" aria-label="<?php echo $star_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
							<?php echo str_repeat( $star_svg, 5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<blockquote>
							<p>&ldquo;<?php echo esc_html( $q[0] ); ?>&rdquo;</p>
						</blockquote>
						<figcaption class="lb-quote__author"><?php echo esc_html( $q[1] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ============ CTA BAND ============ -->
	<section class="lb-cta-band" id="contact" aria-labelledby="lb-cta-title">
		<div class="lb-container">
			<h2 id="lb-cta-title"><?php esc_html_e( 'Reserve Your Table or Book the Bar', 'lion-bartender' ); ?></h2>
			<p><?php esc_html_e( 'Private events, cocktail masterclasses and bartender-for-hire. Let the Lion handle your next celebration.', 'lion-bartender' ); ?></p>
			<a class="lb-btn" href="mailto:<?php echo esc_attr( get_theme_mod( 'lb_contact_email', 'hello@lionbartender.com' ) ); ?>"><?php esc_html_e( 'Get in Touch', 'lion-bartender' ); ?></a>
		</div>
	</section>

</main>

<?php
get_footer();
