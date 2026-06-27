<?php
/**
 * Lion Bartender functions and definitions.
 *
 * @package Lion_Bartender
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LION_BARTENDER_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function lion_bartender_setup() {
	load_theme_textdomain( 'lion-bartender', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => '0d0d0f',
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	// WooCommerce support.
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 900,
		'product_grid'          => array(
			'default_columns' => 4,
			'default_rows'    => 3,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lion-bartender' ),
		'footer'  => __( 'Footer Menu', 'lion-bartender' ),
	) );

	add_image_size( 'lion-bartender-card', 600, 450, true );
	add_image_size( 'lion-bartender-hero', 1920, 1080, true );
}
add_action( 'after_setup_theme', 'lion_bartender_setup' );

/**
 * Content width.
 */
function lion_bartender_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lion_bartender_content_width', 1180 );
}
add_action( 'after_setup_theme', 'lion_bartender_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function lion_bartender_assets() {
	// Google Fonts.
	wp_enqueue_style(
		'lion-bartender-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'lion-bartender-style', get_stylesheet_uri(), array(), LION_BARTENDER_VERSION );

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'lion-bartender-woocommerce',
			get_template_directory_uri() . '/assets/css/woocommerce.css',
			array( 'lion-bartender-style' ),
			LION_BARTENDER_VERSION
		);
	}

	wp_enqueue_script(
		'lion-bartender-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		LION_BARTENDER_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lion_bartender_assets' );

/**
 * Register widget areas.
 */
function lion_bartender_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'lion-bartender' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears on blog and archive pages.', 'lion-bartender' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			/* translators: %d: footer column number */
			'name'          => sprintf( __( 'Footer Column %d', 'lion-bartender' ), $i ),
			'id'            => 'footer-' . $i,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		) );
	}

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar( array(
			'name'          => __( 'Shop Sidebar', 'lion-bartender' ),
			'id'            => 'shop-sidebar',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'lion_bartender_widgets_init' );

/**
 * Custom pagination markup.
 */
function lion_bartender_pagination() {
	$links = paginate_links( array( 'type' => 'array', 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) );
	if ( $links ) {
		echo '<nav class="lb-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'lion-bartender' ) . '">';
		echo implode( '', array_map( 'wp_kses_post', $links ) );
		echo '</nav>';
	}
}

/**
 * Cart fragment refresh for the header mini-cart count.
 */
function lion_bartender_cart_count_fragment( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	ob_start();
	?>
	<span class="lb-cart__count"><?php echo esc_html( $count ); ?></span>
	<?php
	$fragments['span.lb-cart__count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'lion_bartender_cart_count_fragment' );

/**
 * Render the header cart link.
 */
function lion_bartender_cart_link() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	printf(
		'<a class="lb-cart" href="%1$s">%2$s <span class="lb-cart__count">%3$s</span></a>',
		esc_url( wc_get_cart_url() ),
		esc_html__( 'Cart', 'lion-bartender' ),
		esc_html( $count )
	);
}

/**
 * WooCommerce tweaks: layout wrappers & columns.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function lion_bartender_wc_wrapper_start() {
	echo '<main id="main" class="lb-page"><div class="lb-container"><div class="woocommerce-wrapper">';
}
add_action( 'woocommerce_before_main_content', 'lion_bartender_wc_wrapper_start', 10 );

function lion_bartender_wc_wrapper_end() {
	echo '</div></div></main>';
}
add_action( 'woocommerce_after_main_content', 'lion_bartender_wc_wrapper_end', 10 );

// Products per row in shop.
add_filter( 'loop_shop_columns', function () { return 4; } );
// Products per page.
add_filter( 'loop_shop_per_page', function () { return 12; } );

// Remove default WooCommerce sidebar (we provide our own).
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Include theme modules.
 */
require get_template_directory() . '/inc/cocktail-cpt.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/plugin-activation.php';
