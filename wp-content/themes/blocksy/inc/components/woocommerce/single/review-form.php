<?php

add_filter('woocommerce_product_review_comment_form_args', function ($comment_form) {
	$comment_form['comment_field'] = '';
	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
		$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'blocksy' ) . '</label><select name="rating" id="rating" required>
			<option value="">' . esc_html__( 'Rate&hellip;', 'blocksy' ) . '</option>
			<option value="5">' . esc_html__( 'Perfect', 'blocksy' ) . '</option>
			<option value="4">' . esc_html__( 'Good', 'blocksy' ) . '</option>
			<option value="3">' . esc_html__( 'Average', 'blocksy' ) . '</option>
			<option value="2">' . esc_html__( 'Not that bad', 'blocksy' ) . '</option>
			<option value="1">' . esc_html__( 'Very poor', 'blocksy' ) . '</option>
		</select></div>';
	}

	$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required></textarea><label for="comment">' . esc_html__( 'Your review', 'blocksy' ) . '&nbsp;<span class="required">*</span></label></p>';
	$comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s woo-review-submit" value="%4$s">%4$s</button>';

	$comment_form['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" value="" size="30" required /><label for="author">Name&nbsp;<span class="required">*</span></label></p>';
	$comment_form['fields']['email'] = '<p class="comment-form-email"> <input id="email" name="email" type="email" value="" size="30" required /><label for="email">Email&nbsp;<span class="required">*</span></label></p>';

	return $comment_form;
}, 10, 1);

