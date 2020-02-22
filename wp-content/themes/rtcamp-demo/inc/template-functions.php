<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package akha
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
add_action('wan_header_main_cls','wan_header_main_cls');
function wan_header_main_cls() {
	echo wan_get_opt('lowan_pos').' '.wan_choose_opt('header_container').' '.wan_choose_opt('header_middle_text_style');
}
add_filter('use_block_editor_for_post_type', 'wan_gutenberg_for_page', 10, 2);
function wan_gutenberg_for_page($current_status, $post_type)
{
    if (!($post_type == 'page' || $post_type == 'wp_block')) return false;
    return $current_status;
}
add_action('wan_header_cls','wan_header_cls');
function wan_header_cls() {
	$dropdownar = !wan_choose_opt('dropdown_arrow')?' disabled-arrow':'';
	$header_absolute = wan_choose_opt('absolute_header') ? 'absolute-header' : '';
	$shadow = wan_choose_opt('header_shadow')?'shadow':'';
	return "nav-cols-".wan_get_opt('dropdown_max_columns').' dropdown-' . wan_get_opt('dropdown_text_style').$dropdownar.' '.wan_choose_opt('hamburger_position').' '.$header_absolute.' '.$shadow;
}
add_filter('wan/topbar_cls','wan_topbar_cls');
function wan_topbar_cls($cls){
	$topbar_sticky = !wan_choose_opt('show_topbar_on_sticky')?' sticky-hide':'';
	$cls .= " $topbar_sticky";
	return $cls;
}
// add_filter('wan/bottom_cls','wan_bottom_cls');
// function wan_bottom_cls($cls){
// 	$topbar_sticky = !wan_choose_opt('show_topbar_on_sticky')?' sticky-hide':'';
// 	$cls .= " $topbar_sticky";
// 	return $cls;
// }
function wan_breadcrumb(){
	if (wan_choose_opt('breadcrumb_enabled') != true) return;
	$sep = wan_choose_opt('breadcrumb_separator');
	printf('<nav class="woocommerce wan-breadcrumb %1$s">',wan_choose_opt('layout_version'));
		echo '<div class="px-15">';
		echo wan_choose_opt('breadcrumb_prefix');
		if (!is_home() ) {
			echo '<a href="';
			echo esc_url(home_url());
			echo '">';
			echo 'Home';
			echo "</a>".$sep;
			if ( is_single()) {
				printf('<a href="%1$s">%2$s</a>',get_permalink(),get_the_title());
			} elseif (is_page()) {
				printf('<a href="%1$s">%2$s</a>',get_permalink(),get_the_title());
			}
			elseif(is_tax() || is_category()) {
			  $obj = get_queried_object();
			  if ( $term_ids = get_ancestors( get_queried_object_id(), $obj->taxonomy, 'taxonomy' ) ) {
				$crumbs = [];
				foreach ( $term_ids as $term_id ) {
					$term = get_term( $term_id, $obj->taxonomy );

					if ( $term && ! is_wp_error( $term ) ) {
						$crumbs[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
					}
				}
				echo implode( $sep, array_reverse( $crumbs ) ).$sep;
			  }
				$term = get_term( $obj->term_id, $obj->taxonomy );

					if ( $term && ! is_wp_error( $term ) ) {
						printf( '<a href="%s">%s</a>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
					}
				
			}
			elseif (is_tag()) {single_tag_title();}
			elseif (is_day()) {printf('<a href="%2$s">%3$s</a>%1$s<a href="%4$s">%5$s</a>%1$s<a href="%6$s">%7$s</a>',$sep,get_year_link(get_the_time('Y')),get_the_time('Y'),get_month_link(get_the_time('Y'),get_the_time('m')),get_the_time('m'),get_day_link(),get_the_time('D'));}
			elseif (is_month()) {printf('<a href="%2$s">%3$s</a>%1$s<a href="%4$s">%5$s</a>',$sep,get_year_link(get_the_time('Y')),get_the_time('Y'),get_month_link(get_the_time('Y'),get_the_time('m')),get_the_time('m'));}
			elseif (is_year()) {printf('<a href="%1$s">%2$s</a>',get_year_link(get_the_time('Y')), get_the_time('Y'));}
			elseif (is_author()) {echo get_the_author_link();}
			
			
	}
	else {
		echo '<a href="';
		echo esc_url(home_url());
		echo '">';
		echo 'Home';
		echo "</a>".$sep.'<a href="'.get_permalink(get_option('page_for_posts', true)).'">'.get_the_title( get_option('page_for_posts', true)).'</a>';
	}
	if (get_query_var('paged')>0) {echo $sep."page-".get_query_var('paged');}
	echo '</div></nav>';
}
function wan_render_logo() {
	printf('<a href="%3$s"><img src="%1$s" class="sticky-hide" alt="site-logo"/>
	<img src="%2$s" class="sticky-show" alt="site-logo"/></a>',wan_choose_opt('logo_normal'),wan_choose_opt('logo_sticky'),site_url());
	
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wan_minicart_status', 30, 1 );
function wan_minicart_status( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <span><?php echo $woocommerce->cart->cart_contents_count;?></span>
    <?php
    $fragments['.wan-minicart .cart-icon > span'] = ob_get_clean();

    return $fragments;
}
add_action('wan/after_header','wan_custom_heading_for_shop');
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);
add_action('woocommerce_archive_description','woocommerce_result_count',20);
add_action('woocommerce_archive_description','woocommerce_catalog_ordering',30);
add_filter('woocommerce_breadcrumb_defaults','wan_breadcrumb_cls');
remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display',15);
add_action('woocommerce_extra_product_details','woocommerce_output_related_products',6);
add_action('woocommerce_extra_product_details','woocommerce_upsell_display',5);
function wan_breadcrumb_cls($ar){
	$ar['wrap_before'] = '<nav class="woocommerce wan-breadcrumb '.wan_choose_opt('layout_version').' itemprop="breadcrumb"><div class="px-15">';
	$ar['delimiter'] ='<i class="fa fa-chevron-right"></i>';
	$ar['wrap_after']='</div></nav>';
	return $ar;
}
remove_action('woocommerce_review_meta','woocommerce_review_display_meta',10);
add_action('woocommerce_review_after_comment_text','woocommerce_review_display_meta',25,1);
function wan_get_sidebar_cls($option,$default='col-md-3'){
	$basecls = wan_choose_opt($option);
	if (strpos($basecls,'col-')!==false) {
		return $basecls;
	}
	return $basecls." $default";
}
add_filter('loop_shop_columns', 'wan_loop_columns', 999);
if (!function_exists('wan_loop_columns')) {
	function wan_loop_columns() {
		return wan_choose_opt('woocommerce_columns'); // 3 products per row
	}
}
add_filter ('woocommerce_pagination_args','wan_pagination_args');
function wan_pagination_args($args){
	$args['prev_text'] = '<i class="border-ts fa fa-chevron-left"></i>';
	$args['next_text'] = '<i class="border-ts fa fa-chevron-right"></i>';
	return $args;
}
function wan_prepare_post_content($atts){
	extract($atts);
	global $post;
	$id = $post->ID;
	$post_html ='';
	$post_meta_html='';
	$cat = $post_type == 'post' ? 'category' : $post_type.'_category';
	$colCls = [1 => ' col-12', 2 => ' col-xs-12 col-sm-6', 3 => ' col-xs-12 col-sm-6 col-md-4', 4 => ' col-xs-12 col-sm-6 col-lg-3'];
	$termsString = "";
				// Enqueue shortcode assets
	wp_enqueue_script( 'jquery-magnific' );
	if ($post_style != 'wan-list') {
		$item_class[] = $colCls[$_columns];
	}
	$item_class[] = $termsString;
	
	$post_html.= '<div style="font-size:'.$text_scale.'%" class="item ' .implode(' ', $item_class) . implode(' ',get_post_class()).'">';
	if ($tiles == true)	 {
		$post_html .= '<div class="position-relative">';
		}
	$post_html .=  '<div class="featured-post ">';
	if ($show_dates === true)           {
		$post_html .= sprintf('<div class="featured-absolute">%1$s</div>',get_the_date('n D'));
	}
	if ($show_zoom_btn === true) {
		$post_html .= sprintf('<a class="wan-zoom-btn simplelightbox" href="%1$s"><i class=" fa fa-search"></i></a>',get_the_post_thumbnail_url(null,'full'));
	}
	$post_html .= sprintf('<a class="post_link" href="%1$s">%2$s</a>',get_the_permalink(),get_the_post_thumbnail(null,$thumb_size));
	$post_html .= '</div>';
	if ($post_style == 'wan-list') {$post_html .= '<div class="list-content">';}
	if ($tiles == true)	 {
		$post_html .= '<div class="tiles-content">';
	}
	if ($show_title != '' || $show_cat!='')	 {
		$post_html .= '<div class="before-content">';
	}
	if ($show_title != '') {
		$post_html  .= sprintf('<%3$s class="entry-title"><a href="%1$s">%2$s</a></%3$s>',get_the_permalink(),get_the_title(),$title_tag);
	}
	if ( ($show_cat)!='') {	
		$post_html .= '<div class="category-post">';
		$_gterms = get_the_terms(get_the_ID(),$cat);
		$_gterms = wp_list_pluck($_gterms,'name','term_id');
		$tmp =[];
		foreach ($_gterms as $slug => $name){
			$tmp[] = sprintf('<a href="%1$s">%2$s</a>',get_term_link($slug,$cat),$name);
		}
		$post_html .= implode( ' / ',$tmp);                  
		$post_html .= '</div>';     
	}
		if ($show_title != '' || $show_cat!='')	 {
		$post_html .= '</div>'; // end before content
	}
	
	if ($show_content != '') {
		$content = get_the_content();
		$post_html .= '<div class="entry-content">'.wan_trim_words($content,$content_length).'</div>';
	}
	$btn_cls= [ 'h5','readmore','font-weight-bold'];
	
	if ($readmore_text != '' && $show_metas !=true) {
		$post_html .= sprintf('<a class="%3$s" href="%1$s">%2$s</a>',get_the_permalink(),$readmore_text,implode(' ', $btn_cls));
	}
	if ($show_metas===true && $post_meta_html==''){
		$post_html .= '<div class="bottom-metas-bar">';
		$post_html .= do_shortcode($metas);
		$post_html .= sprintf('<li class="%3$s"><a  href="%1$s">%2$s</a></li>',get_the_permalink(),$readmore_text,implode(' ', ['meta-readmore']));
		$post_html .="</div>";
	}

	if ($tiles == true)	 {
		$post_html .= '</div></div>'; // end tiles  // end relative
	}
			if ($post_style == 'wan-list') {$post_html .= '</div>';}// end div list
			$post_html .= '</div>';
			
	return $post_html;
}
function wan_custom_heading_for_shop(){
	if (!class_exists('WooCommerce')) return;
	$excls = '';
	if (is_cart()){
		$excls = 'cart';
	}
	if ( is_checkout()) {
		$excls = 'checkout';
	}
	if ( is_checkout() && is_wc_endpoint_url( 'order-received' ) ) {
		$excls = 'completed';
	}
	$excls .= ' '.wan_get_meta('layout_version');
	if (is_cart() || is_checkout()){
		printf('<div class="checkout-progress-bar %1$s"><span class="cart checkout completed"><a href="%5$s">%2$s</a></span><i class="fa fa-chevron-right" ></i><span class="checkout completed"><a href="%6$s">%3$s</a></span><i class="fa fa-chevron-right"></i><span class="completed">%4$s</span></div>',$excls,get_the_title(wc_get_page_id('cart')),get_the_title(wc_get_page_id('checkout')),__('Completed','wan'),wc_get_cart_url(),wc_get_checkout_url());
	}
}
function wan_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = 'nav-'.wan_get_opt('slide_arrows');
	$classes[] = 'dot-'.wan_get_opt('slide_bullets');
	$classes[] = wan_choose_opt('page_class');
	return $classes;
}
function wan_admin_body_classes( $classes ) {
	$classes .= ' nav-'.wan_get_opt('slide_arrows');
	$classes .= ' dot-'.wan_get_opt('slide_bullets');
	return $classes;
}
add_filter( 'body_class', 'wan_body_classes' );
add_filter( 'admin_body_class', 'wan_admin_body_classes' );
remove_action ('woocommerce_archive_description','woocommerce_product_archive_description',10);
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wan_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wan_pingback_header' );
