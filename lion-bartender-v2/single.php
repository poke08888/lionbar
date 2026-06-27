<?php
/**
 * Single post / cocktail template.
 *
 * @package Lion_Bartender
 */

get_header();
?>

<main id="main" class="lb-page">
	<div class="lb-container">
		<div class="lb-content-wrap <?php echo is_singular( 'cocktail' ) ? 'no-sidebar' : ''; ?>">
			<div class="lb-primary">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="lb-post__thumb" style="margin-bottom:28px;border-radius:var(--lb-radius);overflow:hidden;">
							<?php the_post_thumbnail( 'full' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_singular( 'cocktail' ) ) : ?>
						<?php
						$price = get_post_meta( get_the_ID(), '_lb_cocktail_price', true );
						$abv   = get_post_meta( get_the_ID(), '_lb_cocktail_abv', true );
						$badge = get_post_meta( get_the_ID(), '_lb_cocktail_badge', true );
						?>
						<div class="lb-page-title" style="text-align:left;">
							<?php if ( $badge ) : ?><span class="lb-eyebrow"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
							<h1><?php the_title(); ?></h1>
							<p style="color:var(--lb-gold);font-family:var(--lb-serif);font-size:1.4rem;">
								<?php echo esc_html( $price ); ?>
								<?php if ( $abv ) : ?><span style="color:var(--lb-muted);font-size:1rem;"> &middot; <?php echo esc_html( $abv ); ?></span><?php endif; ?>
							</p>
						</div>
						<div class="lb-entry-content"><?php the_content(); ?></div>
					<?php else : ?>
						<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					<?php endif; ?>

				<?php endwhile; ?>
			</div>

			<?php if ( ! is_singular( 'cocktail' ) ) { get_sidebar(); } ?>
		</div>
	</div>
</main>

<?php
get_footer();
