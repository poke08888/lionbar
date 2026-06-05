<?php
/**
 * Fallback template — blog index, archives and search.
 * The brochure pages use front-page.php and the page templates; this keeps
 * the theme valid and gracefully styles any posts/archives.
 *
 * @package Nonelab
 */

get_header();
?>

<section class="section" style="padding-top:clamp(120px,15vh,170px)">
	<div class="wrap">
		<?php if ( is_search() ) : ?>
			<div class="eyebrow"><?php esc_html_e( 'Search', 'nonelab' ); ?></div>
			<h1 class="section-title" style="margin-top:14px">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Results for “%s”', 'nonelab' ), '<span class="grad-text">' . esc_html( get_search_query() ) . '</span>' );
				?>
			</h1>
		<?php elseif ( is_archive() ) : ?>
			<div class="eyebrow"><?php esc_html_e( 'Archive', 'nonelab' ); ?></div>
			<h1 class="section-title" style="margin-top:14px"><?php the_archive_title(); ?></h1>
		<?php else : ?>
			<div class="eyebrow"><?php esc_html_e( 'Journal', 'nonelab' ); ?></div>
			<h1 class="section-title" style="margin-top:14px"><?php bloginfo( 'name' ); ?></h1>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="grid cols-3" style="margin-top:clamp(36px,5vw,56px)">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'card' ); ?> style="overflow:hidden">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="img-zoom" style="display:block">
								<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:200px;object-fit:cover;display:block' ) ); ?>
							</a>
						<?php endif; ?>
						<div style="padding:24px 26px 28px">
							<div class="bc-tag" style="color:var(--b1);font-size:12.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase"><?php echo esc_html( get_the_date() ); ?></div>
							<h3 style="margin:10px 0 8px;font-size:22px"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p style="color:var(--muted)"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<div style="margin-top:16px;font-weight:600;color:var(--b1)"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'nonelab' ); ?> →</a></div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div style="margin-top:48px">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => esc_html__( '← Previous', 'nonelab' ),
						'next_text' => esc_html__( 'Next →', 'nonelab' ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="lead" style="margin-top:30px"><?php esc_html_e( 'Nothing found.', 'nonelab' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
