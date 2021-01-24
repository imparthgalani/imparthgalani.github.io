<?php
/**
 * Comments helpers.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

/**
 * Reorder respond form fields
 */
add_filter(
	'comment_form_fields',
	function ( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
);


/**
 * Comment view.
 *
 * @param object $comment comment instance.
 * @param array  $args comment display args.
 * @param int $depth current depth of the comments.
 */
if (! function_exists('blocksy_custom_comment_template')) {
function blocksy_custom_comment_template($comment, $args, $depth) {
	$is_by_author = get_the_author_meta( 'email' ) === $comment->comment_author_email;

	$has_avatar = (
		0 !== $args['avatar_size']
		&&
		get_comment_type($comment) === 'comment'
		&&
		get_option('show_avatars', 1)
	);

	$class = '';

	if ($has_avatar) {
		$class = 'ct-has-avatar';
	}

	if ($is_by_author) {
		$class .= ' ct-author-comment';
	}

	?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class($class); ?>>
		<div class="ct-comment-inner" id="ct-comment-inner-<?php comment_ID(); ?>">

			<div class="ct-comment-info">
				<?php
					if ($has_avatar) {
						echo blocksy_simple_image(
							get_avatar_url(
								$comment,
								['size' => $args['avatar_size']]
							),
							[
								'tag_name' => 'figure',
								'img_atts' => [
									'width' => intval($args['avatar_size']),
									'height' => intval($args['avatar_size']),
									'alt' => $comment->comment_author
								],
							]
						);
					}
				?>

				<section>
					<div class="ct-comment-author">
						<?php echo get_comment_author_link(); ?>
					</div>

					<div class="ct-comment-meta">
						<a href="<?php echo esc_attr( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
								printf(
									/* translators: 1: date, 2: time */
									wp_kses_post( __( '%1$s / %2$s', 'blocksy' ) ),
									wp_kses_post( get_comment_date( 'M j, Y' ) ),
									wp_kses_post( get_comment_time() )
								);
							?>
						</a>

						<?php edit_comment_link( __( 'Edit', 'blocksy' ), '  ', '' ); ?>

						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => 'ct-comment-inner',
									'reply_text' => __('Reply', 'blocksy'),
									'depth' => $depth,
									'max_depth' => $args['max_depth'],
								)
							)
						)
						?>
					</div>
				</section>
			</div>


			<div class="ct-comment-content entry-content">
				<?php comment_text(); ?>

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<em class="ct-awaiting-moderation">
						<?php esc_html_e( 'Your comment is awaiting moderation.', 'blocksy' ); ?>
					</em>
				<?php endif; ?>
			</div>

		</div>
	<?php
}
}
