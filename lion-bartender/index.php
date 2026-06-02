<?php
/**
 * The main template file (blog / archive fallback).
 *
 * @package Lion_Bartender
 */

get_header();
?>

<main id="main" class="lb-page">
	<div class="lb-container">

		<header class="lb-page-title">
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<span class="lb-eyebrow"><?php esc_html_e( 'The Journal', 'lion-bartender' ); ?></span>
				<h1><?php single_post_title(); ?></h1>
			<?php elseif ( is_archive() ) : ?>
				<span class="lb-eyebrow"><?php esc_html_e( 'Archive', 'lion-bartender' ); ?></span>
				<h1><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<p>', '</p>' ); ?>
			<?php elseif ( is_search() ) : ?>
				<span class="lb-eyebrow"><?php esc_html_e( 'Search', 'lion-bartender' ); ?></span>
				<h1><?php printf( esc_html__( 'Results for: %s', 'lion-bartender' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			<?php else : ?>
				<h1><?php esc_html_e( 'Latest Stories', 'lion-bartender' ); ?></h1>
			<?php endif; ?>
		</header>

		<div class="lb-content-wrap">
			<div class="lb-primary">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
					<?php endwhile; ?>
					<?php lion_bartender_pagination(); ?>
				<?php else : ?>
					<article class="lb-post"><div class="lb-post__body">
						<h2><?php esc_html_e( 'Nothing here yet', 'lion-bartender' ); ?></h2>
						<p><?php esc_html_e( 'No posts were found. Try a different search.', 'lion-bartender' ); ?></p>
						<?php get_search_form(); ?>
					</div></article>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>

	</div>
</main>

<?php
get_footer();
