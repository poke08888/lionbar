<?php
/**
 * Template part for displaying a post in lists.
 *
 * @package Lion_Bartender
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'lb-post' ); ?>>
	<?php if ( has_post_thumbnail() && ! is_single() ) : ?>
		<a class="lb-post__thumb" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'lion-bartender-card' ); ?>
		</a>
	<?php endif; ?>
	<div class="lb-post__body">
		<div class="lb-post__meta">
			<?php echo esc_html( get_the_date() ); ?>
			<?php
			$cats = get_the_category_list( ', ' );
			if ( $cats ) {
				echo ' &middot; ' . wp_kses_post( $cats );
			}
			?>
		</div>

		<?php
		if ( is_singular() ) {
			the_title( '<h1>', '</h1>' );
		} else {
			the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}
		?>

		<?php if ( is_singular() ) : ?>
			<div class="lb-entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lion-bartender' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		<?php else : ?>
			<p><?php echo esc_html( get_the_excerpt() ); ?></p>
			<a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more &rarr;', 'lion-bartender' ); ?></a>
		<?php endif; ?>
	</div>
</article>
