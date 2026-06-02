<?php
/**
 * Comments template.
 *
 * @package Lion_Bartender
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="lb-comments" style="margin-top:48px;">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %s comment count */
				esc_html( _n( '%s Comment', '%s Comments', $count, 'lion-bartender' ) ),
				esc_html( number_format_i18n( $count ) )
			);
			?>
		</h3>
		<ol class="comment-list" style="list-style:none;padding:0;">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'avatar_size'=> 48,
			) );
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_submit' => 'lb-btn',
		'title_reply'  => __( 'Leave a Comment', 'lion-bartender' ),
	) );
	?>
</div>
