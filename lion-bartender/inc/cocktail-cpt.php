<?php
/**
 * Cocktail Menu custom post type + taxonomy.
 *
 * Lets the bar showcase its signature drinks list (with price, photo and
 * description) independently from the WooCommerce shop catalog.
 *
 * @package Lion_Bartender
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the "cocktail" post type.
 */
function lion_bartender_register_cocktail_cpt() {
	$labels = array(
		'name'               => __( 'Cocktail Menu', 'lion-bartender' ),
		'singular_name'      => __( 'Cocktail', 'lion-bartender' ),
		'add_new'            => __( 'Add Cocktail', 'lion-bartender' ),
		'add_new_item'       => __( 'Add New Cocktail', 'lion-bartender' ),
		'edit_item'          => __( 'Edit Cocktail', 'lion-bartender' ),
		'new_item'           => __( 'New Cocktail', 'lion-bartender' ),
		'view_item'          => __( 'View Cocktail', 'lion-bartender' ),
		'search_items'       => __( 'Search Cocktails', 'lion-bartender' ),
		'not_found'          => __( 'No cocktails found', 'lion-bartender' ),
		'menu_name'          => __( 'Cocktail Menu', 'lion-bartender' ),
	);

	register_post_type( 'cocktail', array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-coffee',
		'menu_position'=> 6,
		'rewrite'      => array( 'slug' => 'cocktails' ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest' => true,
	) );

	register_taxonomy( 'cocktail_category', 'cocktail', array(
		'labels'       => array(
			'name'          => __( 'Drink Categories', 'lion-bartender' ),
			'singular_name' => __( 'Drink Category', 'lion-bartender' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'drink-category' ),
	) );
}
add_action( 'init', 'lion_bartender_register_cocktail_cpt' );

/**
 * Price meta box for cocktails.
 */
function lion_bartender_cocktail_meta_box() {
	add_meta_box(
		'lion_bartender_cocktail_details',
		__( 'Cocktail Details', 'lion-bartender' ),
		'lion_bartender_cocktail_meta_box_cb',
		'cocktail',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'lion_bartender_cocktail_meta_box' );

function lion_bartender_cocktail_meta_box_cb( $post ) {
	wp_nonce_field( 'lion_bartender_save_cocktail', 'lion_bartender_cocktail_nonce' );
	$price = get_post_meta( $post->ID, '_lb_cocktail_price', true );
	$abv   = get_post_meta( $post->ID, '_lb_cocktail_abv', true );
	$badge = get_post_meta( $post->ID, '_lb_cocktail_badge', true );
	?>
	<p>
		<label for="lb_cocktail_price"><strong><?php esc_html_e( 'Price', 'lion-bartender' ); ?></strong></label><br>
		<input type="text" id="lb_cocktail_price" name="lb_cocktail_price" value="<?php echo esc_attr( $price ); ?>" placeholder="$14" style="width:100%;">
	</p>
	<p>
		<label for="lb_cocktail_abv"><strong><?php esc_html_e( 'ABV / Strength', 'lion-bartender' ); ?></strong></label><br>
		<input type="text" id="lb_cocktail_abv" name="lb_cocktail_abv" value="<?php echo esc_attr( $abv ); ?>" placeholder="12% ABV" style="width:100%;">
	</p>
	<p>
		<label for="lb_cocktail_badge"><strong><?php esc_html_e( 'Badge', 'lion-bartender' ); ?></strong></label><br>
		<input type="text" id="lb_cocktail_badge" name="lb_cocktail_badge" value="<?php echo esc_attr( $badge ); ?>" placeholder="Signature" style="width:100%;">
	</p>
	<?php
}

function lion_bartender_save_cocktail_meta( $post_id ) {
	if ( ! isset( $_POST['lion_bartender_cocktail_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lion_bartender_cocktail_nonce'] ) ), 'lion_bartender_save_cocktail' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$fields = array(
		'_lb_cocktail_price' => 'lb_cocktail_price',
		'_lb_cocktail_abv'   => 'lb_cocktail_abv',
		'_lb_cocktail_badge' => 'lb_cocktail_badge',
	);
	foreach ( $fields as $meta_key => $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post_cocktail', 'lion_bartender_save_cocktail_meta' );

/**
 * Helper to render a single cocktail menu item (used on the front page).
 */
function lion_bartender_render_cocktail_item( $post_id ) {
	$price = get_post_meta( $post_id, '_lb_cocktail_price', true );
	$badge = get_post_meta( $post_id, '_lb_cocktail_badge', true );
	$thumb = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
	?>
	<div class="lb-menu-item">
		<?php if ( $thumb ) : ?>
			<img class="lb-menu-item__img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
		<?php endif; ?>
		<div class="lb-menu-item__body">
			<div class="lb-menu-item__head">
				<h3><?php echo esc_html( get_the_title( $post_id ) ); ?></h3>
				<span class="lb-menu-item__dots"></span>
				<?php if ( $price ) : ?>
					<span class="lb-menu-item__price"><?php echo esc_html( $price ); ?></span>
				<?php endif; ?>
			</div>
			<p class="lb-menu-item__desc"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>
			<?php if ( $badge ) : ?>
				<span class="lb-tag"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
