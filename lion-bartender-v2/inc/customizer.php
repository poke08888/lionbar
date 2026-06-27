<?php
/**
 * Lion Bartender Theme Customizer.
 *
 * Controls the homepage hero, brand accents and contact / booking details.
 *
 * @package Lion_Bartender
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lion_bartender_customize_register( $wp_customize ) {

	/* ---------------------------------------------------------
	 * Hero section
	 * --------------------------------------------------------- */
	$wp_customize->add_section( 'lion_bartender_hero', array(
		'title'    => __( 'Homepage Hero', 'lion-bartender' ),
		'priority' => 30,
	) );

	$hero_defaults = array(
		'lb_hero_eyebrow'   => __( 'Craft Cocktails &amp; Late Nights', 'lion-bartender' ),
		'lb_hero_title'     => __( 'Where the Lion Pours', 'lion-bartender' ),
		'lb_hero_subtitle'  => __( 'A bold cocktail lounge serving signature drinks, premium spirits and unforgettable nights. Now bottling our craft at home — shop the collection.', 'lion-bartender' ),
		'lb_hero_btn1_text' => __( 'Reserve a Table', 'lion-bartender' ),
		'lb_hero_btn1_url'  => '#contact',
		'lb_hero_btn2_text' => __( 'Shop the Bar', 'lion-bartender' ),
		'lb_hero_btn2_url'  => '/shop',
	);

	foreach ( $hero_defaults as $id => $default ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => ucwords( str_replace( array( 'lb_hero_', '_' ), array( '', ' ' ), $id ) ),
			'section' => 'lion_bartender_hero',
			'type'    => ( false !== strpos( $id, 'subtitle' ) ) ? 'textarea' : 'text',
		) );
	}

	$wp_customize->add_setting( 'lb_hero_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lb_hero_image', array(
		'label'   => __( 'Hero Background Image', 'lion-bartender' ),
		'section' => 'lion_bartender_hero',
	) ) );

	/* ---------------------------------------------------------
	 * About section
	 * --------------------------------------------------------- */
	$wp_customize->add_section( 'lion_bartender_about', array(
		'title'    => __( 'Homepage About', 'lion-bartender' ),
		'priority' => 31,
	) );

	$about_defaults = array(
		'lb_about_title'   => __( 'Born in the Den, Crafted with Pride', 'lion-bartender' ),
		'lb_about_text'    => __( 'For over a decade Lion Bartender has been mixing fearless flavours in the heart of the city. Our master bartenders blend heritage techniques with a wild, modern edge — and now you can bring that spirit home.', 'lion-bartender' ),
		'lb_about_years'   => '12',
		'lb_about_years_label' => __( 'Years Pouring', 'lion-bartender' ),
	);
	foreach ( $about_defaults as $id => $default ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => ucwords( str_replace( array( 'lb_about_', '_' ), array( '', ' ' ), $id ) ),
			'section' => 'lion_bartender_about',
			'type'    => ( false !== strpos( $id, 'text' ) ) ? 'textarea' : 'text',
		) );
	}
	$wp_customize->add_setting( 'lb_about_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lb_about_image', array(
		'label'   => __( 'About Image', 'lion-bartender' ),
		'section' => 'lion_bartender_about',
	) ) );

	/* ---------------------------------------------------------
	 * Contact / booking
	 * --------------------------------------------------------- */
	$wp_customize->add_section( 'lion_bartender_contact', array(
		'title'    => __( 'Contact &amp; Booking', 'lion-bartender' ),
		'priority' => 32,
	) );

	$contact_defaults = array(
		'lb_contact_address' => __( '88 Mane Street, Downtown', 'lion-bartender' ),
		'lb_contact_phone'   => '+1 (555) 010-2030',
		'lb_contact_email'   => 'hello@lionbartender.com',
		'lb_contact_hours'   => __( 'Tue–Sun · 5pm – 2am', 'lion-bartender' ),
		'lb_social_instagram'=> '#',
		'lb_social_facebook' => '#',
		'lb_social_tiktok'   => '#',
	);
	foreach ( $contact_defaults as $id => $default ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => ucwords( str_replace( array( 'lb_contact_', 'lb_social_', '_' ), array( '', 'Social ', ' ' ), $id ) ),
			'section' => 'lion_bartender_contact',
			'type'    => 'text',
		) );
	}

	/* ---------------------------------------------------------
	 * Accent color
	 * --------------------------------------------------------- */
	$wp_customize->add_setting( 'lb_accent_color', array(
		'default'           => '#c9a227',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lb_accent_color', array(
		'label'   => __( 'Gold Accent Color', 'lion-bartender' ),
		'section' => 'colors',
	) ) );
}
add_action( 'customize_register', 'lion_bartender_customize_register' );

/**
 * Output the customizable accent color as a CSS variable override.
 */
function lion_bartender_customizer_css() {
	$accent = get_theme_mod( 'lb_accent_color', '#c9a227' );
	if ( $accent && '#c9a227' !== $accent ) {
		printf( '<style id="lion-bartender-customizer">:root{--lb-gold:%s;}</style>', esc_attr( $accent ) );
	}
}
add_action( 'wp_head', 'lion_bartender_customizer_css' );
