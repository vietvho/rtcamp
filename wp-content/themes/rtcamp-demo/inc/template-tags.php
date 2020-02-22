<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package akha
 */
remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
add_action('woocommerce_single_product_summary','wan_get_stock_html',10);
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',25);
function wan_demo_links($type='array') {
	$output = [
		'wan-ef-1'=>'<div class="wan-ef-1 d-inline-block"><a href="#">Link Effect 1</a></div>',
		'wan-ef-2'=>'<div class="wan-ef-2 d-inline-block"><a href="#">Link Effect 2</a></div>',
		'wan-ef-3'=>'<div class="wan-ef-3 d-inline-block"><a href="#">Link Effect 3</a></div>',
		'wan-ef-4'=>'<div class="wan-ef-4 d-inline-block"><a href="#">Link Effect 4</a></div>',
		'wan-ef-5'=>'<div class="wan-ef-5 d-inline-block"><a href="#">Link Effect 5</a></div>',
		'wan-ef-6'=>'<div class="wan-ef-6 d-inline-block"><a href="#">Link Effect 6</a></div>',
		'wan-ef-7'=>'<div class="wan-ef-7 d-inline-block"><a href="#">Link Effect 7</a></div>',
		'wan-ef-8'=>'<div class="wan-ef-8 d-inline-block"><a href="#">Link Effect 8</a></div>',
	];
	return $output;
}
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10);
function wan_paginations($from = 'blog_archive_pagination_style',$query='') {
	global $wp_query;
	if ($query != '') {
		$tmp = $wp_query;
		$wp_query = $query;
	}
	$key  = wan_choose_opt($from);
	echo '<div class="px-15 py-30 paginations-bar '.esc_attr($key).'">';
		switch ($key) {
			case 'pager-numeric':
				echo paginate_links(['prev_text'=>'<i class="border-ts fa fa-chevron-left"></i>','next_text'=>'<i class="border-ts fa fa-chevron-right"></i>']);
				break;
			case 'loadmore':
				echo '<div class="ajax-loadmore btn outline primary">'.get_next_posts_link(__('Load More','wan')).'</div>';
				break;
			default:
				the_posts_navigation();
				break;
		}
	echo '</div>';
	if ($query != '') {
		$wp_query = $tmp;
	}
}
function wan_theme_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
        <div class="comment-author vcard"><?php 
            if ( $args['avatar_size'] != 0 ) {
                echo get_avatar( $comment, $args['avatar_size'] ); 
			} 
			?>
		</div>
		<div class="comment-right-panel">
			
			<?php 
            printf( __( '<small><b>%1$s</b><span class="text-secondary"><b> - </b> '.__('%2$s at %3$s','wan').'</span></small>','wan'), get_comment_author_link(),get_comment_date(),get_comment_time()  );

			if ( $comment->comment_approved == '0' ) { ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','wan' ); ?></em><br/><?php 
			} ?>
			<?php comment_text(); ?>
			<div class="comment-actions small text-secondary"><?php 
					comment_reply_link( 
						array_merge( 
							$args, 
							array( 
								'add_below' => $add_below, 
								'depth'     => $depth, 
								'max_depth' => $args['max_depth'] 
							) 
						) 
					); 
					edit_comment_link( __( ' - Edit','wan' ), '  ', '' ); 
				?>
			</div>

		</div><?php 
    if ( 'div' != $args['style'] ) : ?>
        </div><?php 
    endif;
}
if ( ! function_exists( 'wan_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function wan_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'wan' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;
add_action('woocommerce_before_shop_loop_item_title','wan_open_thumbnnail_div',5);
function wan_open_thumbnnail_div(){
	global $product;
	$id = $product->get_id();
    $attachment_ids = $product->get_gallery_image_ids();
	$img = get_the_post_thumbnail($id,'woocommerce_thumbnail',['class'=>'secondary-image']);
    if (isset($attachment_ids[0])){
		$img = wp_get_attachment_image($attachment_ids[0],'woocommerce_thumbnail',false,['class'=>'secondary-image']);
	}
	echo  '<div class="wan-product thumbnail-container">';
	echo '<div class="vertical-bar">';
		if (shortcode_exists('yith_wcwl_add_to_wishlist'))	{
			echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		}
		if (shortcode_exists('yith_compare_button'))	{
			echo do_shortcode('[yith_compare_button]'); 
		}
		if (shortcode_exists('yith_quick_view'))	{
			echo do_shortcode('[yith_quick_view product_id="'.$id.'" type="icon" label=""]');
		}
	echo '</div>';
	printf('%s',$img);
}
function wan_single_product_wishlist() {
	echo do_shortcode('[yith_wcwl_add_to_wishlist icon="fa fa-heart"]');

}
add_action('woocommerce_single_product_summary','wan_single_product_wishlist',35);
add_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_add_to_cart',10);
add_action('woocommerce_before_shop_loop_item_title','wan_close_div',15);
function wan_close_div(){
	echo  '</div>';
}
add_filter('woocommerce_layered_nav_term_html','wan_color_filters',50,4);
function wan_color_filters($term_html,$term,$link,$count) {
	if ($term->taxonomy != 'pa_color') {
		return $term_html;
	}
	$term_color = get_term_meta( $term->term_id, 'color_value', true ); 
	$color_html = '<div class="color_preview" style="background-color:'.$term_color.'"></div>';
	if ( $count > 0 || $option_is_set ) {
			$link      = apply_filters( 'woocommerce_layered_nav_link', $link, $term, 'pa_color' );
			$term_html = '<a rel="nofollow" class="pa_color" href="' . esc_url( $link ) . '">' .$color_html. '<span>'.esc_html( $term->name ) . '</span></a>';
		} else {
			$link      = false;
			$term_html = '<span>' . $color_html.esc_html( $term->name ) . '</span>';
		}
	return $term_html;
}
if ( ! function_exists( 'wan_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function wan_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'wan' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;
add_action('woocommerce_archive_description','wan_open_toolbar',1);
function wan_open_toolbar() {
	echo '<div class="wan-top-product-bar">';
}
add_action('woocommerce_archive_description','wan_close_toolbar',50);
function wan_close_toolbar() {
	echo '</div>';
}
add_action('woocommerce_archive_description','wan_grid_icons',25);
function wan_grid_icons() {
	$active = wan_choose_opt('woocommerce_columns');
	echo '<div class="grid-change">';
	for($i=4;$i>=2;$i--){
		printf('<a href="#%1$s" data-col="columns-%1$s" class="grid-%1$s %2$s"></a>',$i,$i==$active ? 'active':'');
	}
	echo '</div>';
}
add_action('woocommerce_archive_description','wan_pagination_links',10);
function wan_pagination_links(){
	echo '<div class="simple-pagination">';
		previous_posts_link('<i class="border-ts fa fa-chevron-left"></i>');
		next_posts_link('<i class="border-ts fa fa-chevron-right"></i>');
	echo '</div>';
}
if ( ! function_exists( 'wan_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function wan_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'wan' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'wan' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wan' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wan' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wan' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'wan' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'wan_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function wan_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail-container">
				<div class="post-thumbnail">
					<?php printf('<a class="wan-zoom-btn simplelightbox" href="%1$s"><i class=" fa fa-search"></i></a>',get_the_post_thumbnail_url(null,'full'));
					the_post_thumbnail(wan_choose_opt('single_thumbnail')); ?>
				</div>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

add_action('woocommerce_widget_shopping_cart_before_buttons','wan_add_shipping_fee');
function wan_add_shipping_fee(){ ?>
<p class="woocommerce-mini-cart__shipping shipping "><?php _e( 'Shipping', 'wan' ); ?>: <strong class="pull-right"><?php echo get_woocommerce_currency_symbol(). WC()->cart->get_shipping_total(); ?></strong></p>
<p class="woocommerce-mini-cart__includeship  "><?php _e( 'Total', 'wan' ); ?>: <strong class="pull-right"><?php echo  WC()->cart->get_total(); ?></strong></p>
<?php }
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',15);
function wan_format_sale_price($price,$regular_price,$sale_price){
	$price ='<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>' ;
	return $price;
}
add_filter( 'woocommerce_format_sale_price', 'wan_format_sale_price',10,3);
add_action( 'woocommerce_before_shop_loop_item_title', 'wan_show_sale_percentage_loop', 10 );
add_action ('woocommerce_proceed_to_checkout','wan_proceed_to_checkout',20);
function wan_proceed_to_checkout(){
	echo '<a class="button outline w-100 text-center" href="'.get_permalink( wc_get_page_id( 'shop' ) ).'">'.__('Continue Shopping','wan').'</a>';

}
remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10);
function wan_show_sale_percentage_loop() {
	global $product;
	if ( ! $product->is_on_sale() ) return;
	$max_percentage = 0;
	if ( $product->is_type( 'simple' ) ) {
		$max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
	} elseif ( $product->is_type( 'variable' ) ) {
		$max_percentage = 0;
		foreach ( $product->get_children() as $child_id ) {
			$variation = wc_get_product( $child_id );
			$price = $variation->get_regular_price();
			$sale = $variation->get_sale_price();
			if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
			if ( $percentage > $max_percentage ) {
				$max_percentage = $percentage;
			}
		}
	}
	if ( $max_percentage > 0 ) echo "<span class='onsale percent'>-" . round($max_percentage) . "%</span>"; 
}
add_filter('woocommerce_blocks_product_grid_item_html','wan_block_product_render',10,3);
function wan_block_product_render($html,$data,$_product){
	ob_start();
	global $product ;
	$product = $_product;
	wan_show_sale_percentage_loop();
	$sale_percent = ob_get_clean();
	ob_start();
	wan_open_thumbnnail_div();
	$product_thumbnails = ob_get_clean();
	return "<li class=\"wc-block-grid__product\">
				<a href=\"{$data->permalink}\" class=\"wc-block-grid__product-link\">
					{$product_thumbnails}{$data->image}{$data->button}{$sale_percent}</div>
					{$data->title}
				</a>
				{$data->badge}
				{$data->price}
				{$data->rating}
				
			</li>";
}
			
