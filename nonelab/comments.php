<?php
/**
 * Comments template.
 *
 * @package Nonelab
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area" style="margin-top:48px">
	<?php if ( have_comments() ) : ?>
		<h3>
			<?php
			$nl_count = get_comments_number();
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s comment', '%s comments', $nl_count, 'nonelab' ) ),
				esc_html( number_format_i18n( $nl_count ) )
			);
			?>
		</h3>
		<ol class="comment-list" style="list-style:none;padding:0;margin:24px 0">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 44,
				)
			);
			?>
		</ol>
		<?php
		the_comments_pagination(
			array(
				'prev_text' => esc_html__( '← Older', 'nonelab' ),
				'next_text' => esc_html__( 'Newer →', 'nonelab' ),
			)
		);
		?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'btn grad',
		)
	);
	?>
</div>
