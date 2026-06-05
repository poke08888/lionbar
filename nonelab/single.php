<?php
/**
 * Single post template.
 *
 * @package Nonelab
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class(); ?>>
		<section class="section" style="padding-top:clamp(120px,15vh,170px);padding-bottom:0">
			<div class="wrap" style="max-width:860px">
				<div class="eyebrow"><?php echo esc_html( get_the_date() ); ?></div>
				<h1 class="section-title" style="margin-top:14px"><?php the_title(); ?></h1>
			</div>
		</section>

		<?php if ( has_post_thumbnail() ) : ?>
			<section class="section tight">
				<div class="wrap" style="max-width:980px">
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;border-radius:22px;display:block' ) ); ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="section tight" style="padding-top:0">
			<div class="wrap" style="max-width:860px">
				<div class="lead" style="color:var(--ink)">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before' => '<div style="margin-top:24px">' . esc_html__( 'Pages:', 'nonelab' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>
		</section>
	</article>
	<?php
endwhile;

get_footer();
