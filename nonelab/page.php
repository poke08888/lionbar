<?php
/**
 * Generic page template (for pages without a Nonelab template assigned).
 *
 * @package Nonelab
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="section" style="padding-top:clamp(120px,15vh,170px)">
		<div class="wrap" style="max-width:860px">
			<h1 class="section-title"><?php the_title(); ?></h1>
			<div class="lead" style="margin-top:28px;color:var(--ink)">
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
		</div>
	</section>
	<?php
	if ( comments_open() || get_comments_number() ) {
		echo '<section class="section tight" style="padding-top:0"><div class="wrap" style="max-width:860px">';
		comments_template();
		echo '</div></section>';
	}
endwhile;

get_footer();
