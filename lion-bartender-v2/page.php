<?php
/**
 * The template for displaying single pages.
 *
 * @package Lion_Bartender
 */

get_header();
?>

<main id="main" class="lb-page">
	<div class="lb-container">
		<div class="lb-content-wrap no-sidebar">
			<div class="lb-primary">
				<?php while ( have_posts() ) : the_post(); ?>
					<header class="lb-page-title">
						<h1><?php the_title(); ?></h1>
						<div class="lb-rule"></div>
					</header>
					<div class="lb-entry-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lion-bartender' ),
							'after'  => '</div>',
						) );
						?>
					</div>
					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
