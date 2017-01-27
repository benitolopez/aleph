<?php
/**
 * Extend Walker_Comment class adding support for BEM syntax.
 *
 * To use the default WordPress markup, ignore this file and comment out
 * this line in `comments.php`:
 *
 *		'walker'     => new Aleph_Walker_Comment
 *
 * And this line in `functions.php`:
 *
 *		require get_template_directory() . '/inc/class-walker-comment.php';
 *
 * @package Aleph
 */

class Aleph_Walker_Comment extends Walker_Comment {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.7.0
	 * @access public
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children comment__list comment__list--children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children comment__list comment__list--children">' . "\n";
				break;
		}
	}

	/**
	 * Outputs a pingback comment.
	 *
	 * @since 3.6.0
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="comment-body comment__body">
				<?php esc_html_e( 'Pingback:', 'aleph' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( esc_html__( 'Edit', 'aleph' ), '<span class="edit-link comment__edit">', '</span>' ); ?>
			</div>
		<?php
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent comment__item--parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment__body comment-body">
				<footer class="comment-meta comment__meta">
					<div class="comment-author comment__author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], false, false, array( 'class' => 'comment__avatar' ) ); ?>
						<?php
							/* translators: %s: comment author link */
							printf( __( '%s <span class="says comment__says">says:</span>', 'aleph' ),
								sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
							);
						?>
					</div><!-- .comment-author -->

					<div class="comment-metadata comment__metadata">
						<a class="comment__date" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									printf( esc_html__( '%1$s at %2$s', 'aleph' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( esc_html__( 'Edit', 'aleph' ), '<span class="edit-link comment__edit">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'aleph' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content comment__content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args[ 'max_depth' ],
					'before'    => '<div class="reply comment__reply">',
					'after'     => '</div>'
				) ) );
				?>
			</article><!-- .comment-body -->
		<?php
	}

}
