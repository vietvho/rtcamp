<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div class="row">
		<div class="col-md-6">
			<h4><?php __('Reviews','wan');?></h4>
			<big><?php echo $product->get_average_rating();?></big>
			<p><?php _e('overall','wan');?></p>
			<p class="base_on"><?php printf(__('Based on %s review','wan'), $product->get_review_count());?></p>
			<ul class="reviews-summary">
				<?php $rating_count = $product->get_rating_count();?>
				<?php foreach([5,4,3,2,1] as $i) {
					$_count = $product->get_rating_count($i);
					printf('<li>%1$s<div class="percent-bar"><div class="percent" style="width:%2$s;height:12px;"></div></div><small>%3$s</small></li>', wc_get_rating_html($i),wan_render_percent($_count,$rating_count),$_count);
				}?>
				
			</ul>
		</div>
		<div class="col-md-6">
			
			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
				<div id="review_form_wrapper">
					<div id="review_form">
						<?php
						$commenter = wp_get_current_commenter();

						$comment_form = array(
							/* translators: %s is product title */
							'title_reply'         => have_comments() ? __( 'Add a review', 'wan' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'wan' ), get_the_title() ),
							/* translators: %s is product title */
							'title_reply_to'      => __( 'Leave a Reply to %s', 'wan' ),
							'title_reply_before'  => '<h4 id="reply-title" class="comment-reply-title">',
							'title_reply_after'   => '</h4>',
							'comment_notes_after' => '',
							'fields'              => array(
								'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'wan' ) . '&nbsp;<span class="required">*</span></label> ' .
											'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
								'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'wan' ) . '&nbsp;<span class="required">*</span></label> ' .
											'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
							),
							'label_submit'        => __( 'ADD REVIEW', 'wan' ),
							'logged_in_as'        => '',
							'comment_field'       => '',
						);

						$account_page_url = wc_get_page_permalink( 'myaccount' );
						if ( $account_page_url ) {
							/* translators: %s opening and closing link tags respectively */
							$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'wan' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
						}

						if ( wc_review_ratings_enabled() ) {
							$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'wan' ) . '</label><select name="rating" id="rating" required>
								<option value="">' . esc_html__( 'Rate&hellip;', 'wan' ) . '</option>
								<option value="5">' . esc_html__( 'Perfect', 'wan' ) . '</option>
								<option value="4">' . esc_html__( 'Good', 'wan' ) . '</option>
								<option value="3">' . esc_html__( 'Average', 'wan' ) . '</option>
								<option value="2">' . esc_html__( 'Not that bad', 'wan' ) . '</option>
								<option value="1">' . esc_html__( 'Very poor', 'wan' ) . '</option>
							</select></div>';
						}

						$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'wan' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
						?>
					</div>
				</div>
			<?php else : ?>
				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'wan' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div id="comments">
		
		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'wan' ); ?></p>
		<?php endif; ?>
	</div>


	<div class="clear"></div>
</div>
