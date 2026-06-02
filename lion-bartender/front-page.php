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
	<section class="lb-hero" <?php if ( $hero_image ) : ?>style="background-image:url('<?php echo esc_url( $hero_image ); ?>');"<?php endif; ?>>
		<div class="lb-container">
			<div class="lb-hero__inner">
				<span class="lb-eyebrow"><?php echo wp_kses_post( get_theme_mod( 'lb_hero_eyebrow', __( 'Craft Cocktails &amp; Late Nights', 'lion-bartender' ) ) ); ?></span>
				<h1><?php echo wp_kses_post( get_theme_mod( 'lb_hero_title', __( 'Where the Lion Pours', 'lion-bartender' ) ) ); ?></h1>
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
		<span class="lb-hero__scroll"><?php esc_html_e( 'Scroll', 'lion-bartender' ); ?></span>
	</section>

	<!-- ============ FEATURE STRIP ============ -->
	<section class="lb-section lb-section--alt" style="padding-top:0;padding-bottom:0;">
		<div class="lb-container" style="transform:translateY(-50px);">
			<div class="lb-features" style="background:var(--lb-charcoal-2);">
				<div class="lb-feature">
					<div class="lb-feature__icon">&#9826;</div>
					<h3><?php esc_html_e( 'Signature Craft', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'Drinks mixed by award-winning bartenders.', 'lion-bartender' ); ?></p>
				</div>
				<div class="lb-feature">
					<div class="lb-feature__icon">&#9733;</div>
					<h3><?php esc_html_e( 'Premium Spirits', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'A curated shelf of rare and small-batch labels.', 'lion-bartender' ); ?></p>
				</div>
				<div class="lb-feature">
					<div class="lb-feature__icon">&#9758;</div>
					<h3><?php esc_html_e( 'Shipped to You', 'lion-bartender' ); ?></h3>
					<p><?php esc_html_e( 'Cocktail kits &amp; bottles delivered to your door.', 'lion-bartender' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ ABOUT ============ -->
	<section class="lb-section" id="about">
		<div class="lb-container">
			<div class="lb-about">
				<div class="lb-about__media">
					<?php $about_img = get_theme_mod( 'lb_about_image' ); ?>
					<img src="<?php echo esc_url( $about_img ? $about_img : 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=900&q=80' ); ?>" alt="<?php esc_attr_e( 'Inside Lion Bartender', 'lion-bartender' ); ?>">
					<div class="lb-about__badge">
						<strong><?php echo esc_html( get_theme_mod( 'lb_about_years', '12' ) ); ?></strong>
						<span><?php echo esc_html( get_theme_mod( 'lb_about_years_label', __( 'Years Pouring', 'lion-bartender' ) ) ); ?></span>
					</div>
				</div>
				<div class="lb-about__body">
					<span class="lb-eyebrow"><?php esc_html_e( 'Our Story', 'lion-bartender' ); ?></span>
					<h2><?php echo wp_kses_post( get_theme_mod( 'lb_about_title', __( 'Born in the Den, Crafted with Pride', 'lion-bartender' ) ) ); ?></h2>
					<div class="lb-rule" style="margin-left:0;"></div>
					<p><?php echo wp_kses_post( get_theme_mod( 'lb_about_text', __( 'For over a decade Lion Bartender has been mixing fearless flavours in the heart of the city. Our master bartenders blend heritage techniques with a wild, modern edge — and now you can bring that spirit home.', 'lion-bartender' ) ) ); ?></p>
					<a class="lb-btn lb-btn--ghost" href="#menu"><?php esc_html_e( 'View the Menu', 'lion-bartender' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ COCKTAIL MENU ============ -->
	<section class="lb-section lb-section--alt" id="menu">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'On the Menu', 'lion-bartender' ); ?></span>
				<h2><?php esc_html_e( 'Signature Cocktails', 'lion-bartender' ); ?></h2>
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
				<p style="text-align:center;color:var(--lb-muted);">
					<?php esc_html_e( 'Add cocktails under “Cocktail Menu” in the dashboard to populate this section.', 'lion-bartender' ); ?>
				</p>
			<?php endif; ?>

			<div style="text-align:center;margin-top:48px;">
				<a class="lb-btn" href="<?php echo esc_url( home_url( '/cocktails' ) ); ?>"><?php esc_html_e( 'Full Drinks List', 'lion-bartender' ); ?></a>
			</div>
		</div>
	</section>

	<!-- ============ SHOP TEASER ============ -->
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	<section class="lb-section" id="shop">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'From Our Shelf to Yours', 'lion-bartender' ); ?></span>
				<h2><?php esc_html_e( 'Shop the Bar', 'lion-bartender' ); ?></h2>
				<div class="lb-rule"></div>
				<p><?php esc_html_e( 'Cocktail kits, premium bottles, glassware and gift cards — delivered.', 'lion-bartender' ); ?></p>
			</div>

			<div class="lb-products woocommerce">
				<?php
				echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" class="lb-shop-teaser"]' );
				?>
			</div>

			<div style="text-align:center;margin-top:48px;">
				<a class="lb-btn" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Visit the Shop', 'lion-bartender' ); ?></a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ============ TESTIMONIALS ============ -->
	<section class="lb-section lb-section--alt">
		<div class="lb-container">
			<div class="lb-section-head">
				<span class="lb-eyebrow"><?php esc_html_e( 'The Pride Speaks', 'lion-bartender' ); ?></span>
				<h2><?php esc_html_e( 'Loved by Night Owls', 'lion-bartender' ); ?></h2>
				<div class="lb-rule"></div>
			</div>
			<div class="lb-quotes">
				<?php
				$quotes = array(
					array( __( 'The best Old Fashioned in the city — and the home kit is just as good. Pure magic in a glass.', 'lion-bartender' ), 'Amara K.' ),
					array( __( 'Atmosphere, service, drinks: a perfect 10. The lion roars and so do the cocktails.', 'lion-bartender' ), 'Diego R.' ),
					array( __( 'Ordered the negroni bundle for a party and everyone asked where I got it. Lion Bartender, obviously.', 'lion-bartender' ), 'Priya S.' ),
				);
				foreach ( $quotes as $q ) : ?>
					<div class="lb-quote">
						<div class="lb-quote__stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
						<p>&ldquo;<?php echo esc_html( $q[0] ); ?>&rdquo;</p>
						<div class="lb-quote__author"><?php echo esc_html( $q[1] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ============ CTA BAND ============ -->
	<section class="lb-cta-band">
		<div class="lb-container">
			<h2><?php esc_html_e( 'Reserve Your Table or Book the Bar', 'lion-bartender' ); ?></h2>
			<p><?php esc_html_e( 'Private events, cocktail masterclasses and bartender-for-hire. Let the Lion handle your next celebration.', 'lion-bartender' ); ?></p>
			<a class="lb-btn" href="mailto:<?php echo esc_attr( get_theme_mod( 'lb_contact_email', 'hello@lionbartender.com' ) ); ?>"><?php esc_html_e( 'Get in Touch', 'lion-bartender' ); ?></a>
		</div>
	</section>

</main>

<?php
get_footer();
