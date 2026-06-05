<?php
/**
 * Nonelab theme functions.
 *
 * Design fidelity: faithfully recreates the Nonelab "Editorial Split" design
 * (assets/nonelab.css + site.js + i18n).
 * Performance: assets are split so they cache well, scripts load deferred in
 * the footer, fonts are preconnected, and only the strings a page needs are
 * loaded.
 *
 * @package Nonelab
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NONELAB_VERSION', '1.0.0' );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function nonelab_setup() {
	load_theme_textdomain( 'nonelab', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'nonelab' ),
		)
	);
}
add_action( 'after_setup_theme', 'nonelab_setup' );

/* -------------------------------------------------------------------------
 * Asset URL helper
 * ---------------------------------------------------------------------- */
function nonelab_asset( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Cache-busting version for an asset, based on file mtime when available.
 */
function nonelab_asset_ver( $relative ) {
	$file = get_template_directory() . '/assets/' . ltrim( $relative, '/' );
	$mtime = @filemtime( $file );
	return $mtime ? (string) $mtime : NONELAB_VERSION;
}

/* -------------------------------------------------------------------------
 * Which "design page" are we on? (home|about|brands|partners|contact|'')
 * Used for the active nav link and for loading the right i18n bundle.
 * ---------------------------------------------------------------------- */
function nonelab_current_page() {
	static $page = null;
	if ( null !== $page ) {
		return $page;
	}

	$page = '';
	if ( is_front_page() ) {
		$page = 'home';
	} else {
		foreach ( array( 'about', 'brands', 'partners', 'contact' ) as $key ) {
			if ( is_page_template( "templates/{$key}.php" ) ) {
				$page = $key;
				break;
			}
		}
	}
	return $page;
}

/* -------------------------------------------------------------------------
 * Resolve the permalink for a design page, with sensible fallbacks.
 * On activation we store a key => page-ID map in the 'nonelab_pages' option.
 * ---------------------------------------------------------------------- */
function nonelab_page_url( $key ) {
	if ( 'home' === $key ) {
		return home_url( '/' );
	}

	$map = get_option( 'nonelab_pages', array() );
	if ( ! empty( $map[ $key ] ) ) {
		$permalink = get_permalink( (int) $map[ $key ] );
		if ( $permalink ) {
			return $permalink;
		}
	}

	// Fallback: look up a page that uses the matching template.
	$found = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => "templates/{$key}.php",
			'number'     => 1,
		)
	);
	if ( ! empty( $found ) ) {
		return get_permalink( $found[0]->ID );
	}

	// Last resort: a pretty URL guess.
	return home_url( '/' . $key . '/' );
}

/* -------------------------------------------------------------------------
 * Enqueue styles & scripts
 * ---------------------------------------------------------------------- */
function nonelab_assets() {
	// Google Fonts — Bricolage Grotesque (display) + Hanken Grotesk (text) + Noto Sans SC (CJK).
	wp_enqueue_style(
		'nonelab-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Hanken+Grotesk:ital,wght@0,300..800;1,400..600&family=Noto+Sans+SC:wght@400..800&display=swap',
		array(),
		null
	);

	// Design system.
	wp_enqueue_style(
		'nonelab-core',
		nonelab_asset( 'nonelab.css' ),
		array( 'nonelab-fonts' ),
		nonelab_asset_ver( 'nonelab.css' )
	);

	// WordPress theme header stylesheet (helpers only).
	wp_enqueue_style(
		'nonelab-style',
		get_stylesheet_uri(),
		array( 'nonelab-core' ),
		NONELAB_VERSION
	);

	// Per-page translation bundle (defines window.PAGE_I18N) — must load
	// before the i18n engine. Reusing one handle keeps the dependency simple.
	$page    = nonelab_current_page();
	$bundles = array(
		'home'     => 'i18n-home.js',
		'about'    => 'i18n-about.js',
		'brands'   => 'i18n-brands.js',
		'partners' => 'i18n-partners.js',
		'contact'  => 'i18n-contact.js',
	);
	$i18n_deps = array();
	if ( isset( $bundles[ $page ] ) ) {
		wp_enqueue_script(
			'nonelab-i18n-page',
			nonelab_asset( $bundles[ $page ] ),
			array(),
			nonelab_asset_ver( $bundles[ $page ] ),
			true
		);
		$i18n_deps[] = 'nonelab-i18n-page';
	}

	// i18n engine (nav + footer strings, language switcher, persistence).
	wp_enqueue_script(
		'nonelab-i18n',
		nonelab_asset( 'i18n.js' ),
		$i18n_deps,
		nonelab_asset_ver( 'i18n.js' ),
		true
	);

	// Interactions: nav scroll state, mobile menu, reveal, parallax, count-up, marquee.
	wp_enqueue_script(
		'nonelab-site',
		nonelab_asset( 'site.js' ),
		array(),
		nonelab_asset_ver( 'site.js' ),
		true
	);

	// Contact form: only on the contact page. Talks to admin-ajax.
	if ( 'contact' === $page ) {
		wp_enqueue_script(
			'nonelab-contact',
			nonelab_asset( 'contact.js' ),
			array(),
			nonelab_asset_ver( 'contact.js' ),
			true
		);
		wp_localize_script(
			'nonelab-contact',
			'NL_CONTACT',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'nonelab_enquiry' ),
			)
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nonelab_assets' );

/* -------------------------------------------------------------------------
 * Defer theme scripts for faster rendering (they all guard on DOM readiness).
 * ---------------------------------------------------------------------- */
function nonelab_defer_scripts( $tag, $handle ) {
	$defer = array( 'nonelab-i18n-page', 'nonelab-i18n', 'nonelab-site', 'nonelab-contact' );
	if ( in_array( $handle, $defer, true ) && false === strpos( $tag, ' defer' ) ) {
		$tag = str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'nonelab_defer_scripts', 10, 2 );

/* -------------------------------------------------------------------------
 * Preconnect to the Google Fonts hosts (matches the design's <head>).
 * ---------------------------------------------------------------------- */
function nonelab_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'nonelab_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * Contact / partnership enquiry — AJAX handler (works for guests too).
 * Validates server-side and emails the site admin via wp_mail().
 * The front end always shows the success state on a clean response, matching
 * the design; mail-delivery problems are logged, not surfaced to visitors.
 * ---------------------------------------------------------------------- */
function nonelab_handle_enquiry() {
	check_ajax_referer( 'nonelab_enquiry', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$type    = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || strlen( $message ) < 3 ) {
		wp_send_json_error( array( 'reason' => 'invalid' ), 400 );
	}

	$to      = apply_filters( 'nonelab_enquiry_recipient', get_option( 'admin_email' ) );
	$subject = sprintf(
		/* translators: %s: enquirer name. */
		__( 'Partnership enquiry from %s', 'nonelab' ),
		$name
	);
	$body = sprintf(
		"Name: %s\nCompany: %s\nEmail: %s\nEnquiry type: %s\n\nMessage:\n%s\n",
		$name,
		$company,
		$email,
		$type,
		$message
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $subject, $body, $headers );
	if ( ! $sent && function_exists( 'error_log' ) ) {
		error_log( '[Nonelab] Enquiry email could not be sent for ' . $email );
	}

	wp_send_json_success( array( 'sent' => (bool) $sent ) );
}
add_action( 'wp_ajax_nonelab_enquiry', 'nonelab_handle_enquiry' );
add_action( 'wp_ajax_nopriv_nonelab_enquiry', 'nonelab_handle_enquiry' );

/* -------------------------------------------------------------------------
 * First-run scaffolding: create the five pages, assign templates, set the
 * static front page and pretty permalinks so the site works immediately.
 * ---------------------------------------------------------------------- */
function nonelab_scaffold_site() {
	$defs = array(
		'home'     => array(
			'title'    => __( 'Home', 'nonelab' ),
			'template' => '', // Uses front-page.php automatically.
		),
		'about'    => array(
			'title'    => __( 'About', 'nonelab' ),
			'template' => 'templates/about.php',
		),
		'brands'   => array(
			'title'    => __( 'Brands', 'nonelab' ),
			'template' => 'templates/brands.php',
		),
		'partners' => array(
			'title'    => __( 'Partners', 'nonelab' ),
			'template' => 'templates/partners.php',
		),
		'contact'  => array(
			'title'    => __( 'Contact', 'nonelab' ),
			'template' => 'templates/contact.php',
		),
	);

	$map = get_option( 'nonelab_pages', array() );

	foreach ( $defs as $key => $def ) {
		$existing_id = ! empty( $map[ $key ] ) ? (int) $map[ $key ] : 0;
		if ( $existing_id && 'page' === get_post_type( $existing_id ) && 'trash' !== get_post_status( $existing_id ) ) {
			continue; // Already created.
		}

		// Avoid duplicates if a page with this slug already exists.
		$by_slug = get_page_by_path( $key );
		if ( $by_slug ) {
			$page_id = $by_slug->ID;
		} else {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $def['title'],
					'post_name'    => $key,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
		}

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			if ( $def['template'] ) {
				update_post_meta( $page_id, '_wp_page_template', $def['template'] );
			}
			$map[ $key ] = (int) $page_id;
		}
	}

	update_option( 'nonelab_pages', $map );

	// Static front page → the "Home" page (front-page.php renders the design).
	if ( ! empty( $map['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $map['home'] );
	}

	// Assign a primary menu if none exists, so the (server-rendered) nav also
	// has a managed counterpart for site owners who prefer the menu editor.
	nonelab_maybe_create_menu( $map );

	// Pretty permalinks make the page URLs clean.
	$structure = get_option( 'permalink_structure' );
	if ( empty( $structure ) ) {
		global $wp_rewrite;
		update_option( 'permalink_structure', '/%postname%/' );
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$wp_rewrite->flush_rules();
	} else {
		flush_rewrite_rules();
	}
}
add_action( 'after_switch_theme', 'nonelab_scaffold_site' );

/**
 * Build a Primary menu from the scaffolded pages if the location is empty.
 */
function nonelab_maybe_create_menu( $map ) {
	if ( has_nav_menu( 'primary' ) ) {
		return;
	}
	$menu_name = __( 'Primary Menu', 'nonelab' );
	$menu      = wp_get_nav_menu_object( $menu_name );
	$menu_id   = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	foreach ( array( 'about', 'brands', 'partners', 'contact' ) as $key ) {
		if ( empty( $map[ $key ] ) ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-object-id' => (int) $map[ $key ],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/* -------------------------------------------------------------------------
 * Trim <head> bloat the brochure site doesn't need (small perf win).
 * ---------------------------------------------------------------------- */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* Default meta description for the front page (matches the design). */
function nonelab_meta_description() {
	$desc = '';
	if ( is_front_page() ) {
		$desc = __( 'Nonelab Group — a Vietnamese beauty & wellness group developing and distributing the brands that define modern self-care.', 'nonelab' );
	} elseif ( is_singular() ) {
		$desc = wp_strip_all_tags( get_the_excerpt() );
	}
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( wp_trim_words( $desc, 30, '' ) ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'nonelab_meta_description', 1 );
