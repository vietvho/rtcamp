<?php 

if (!function_exists('wan_render_dimensions')) {
	function wan_render_dimensions($val,$scale=1,$unit=array('px','%','em')) {
    foreach ($unit as $_unit) {
        if (strpos((string)$val,(string)$_unit) !== false) {
            return $val;
        }
    }
    return floatval($val) . 'px';
}
}
add_shortcode('post_date','wan_post_date');
function wan_post_date(){
	return get_the_date();
}
add_shortcode('post_author','wan_post_author');
function wan_post_author($atts){
	$atts = shortcode_atts(
		array(
			'label' => __('author: ','wan'),
		), $atts, 'post_author' );

	return $atts['label'].get_the_author();
}
add_shortcode('post_comments','wan_post_comments');
function wan_post_comments(){
	return get_comments_number();
	return get_comments(['count'=>true]);
}
add_shortcode('post_category','wan_post_category');
function wan_post_category($atts){
	$atts = shortcode_atts(
		array(
			'separator' => ', '
		), $atts, 'post_category' );
	return get_the_category_list($atts['separator']);
}
add_shortcode('post_tags','wan_post_tags');
function wan_post_tags($atts){
	$atts = shortcode_atts(
		array(
			'separator' => ', '
		), $atts, 'post_tags' );
	return get_the_tag_list('',$atts['separator']);
}

add_shortcode('wan-myaccount','wan_myaccount');
add_shortcode('wan-socials','wan_socials');
function wan_socials() {
	wan_render_social();
}
add_shortcode('wan_minicart','wan_minicart');
function wan_minicart($atts) {
	if ( !class_exists( 'WooCommerce' ) ) return;

	ob_start();
	woocommerce_mini_cart();
	$mini_cart = ob_get_clean();
	$atts = shortcode_atts(['cart_text'=>'Cart / ','cart_icon'  => wan_LINK.'images/cart_icon.svg','icon_pos'=>'left: 50%;top: 74%;','icon_style'=>'ministyle1'],$atts,'wan_minicart');
	$cart_icon = sprintf('<span class="cart-icon"><img src="%1$s" alt="cart-icon"/><span style="%3$s"><span>%2$s<span></span></span>',$atts['cart_icon'],WC()->cart->get_cart_contents_count(),$atts['icon_pos']);
	$output =  '<div class="wan-minicart woocommerce '.$atts['icon_style'].'"><ul class="menu">';
	$output .= sprintf('<li class="menu-item"><a href="%3$s"><span class="hidden-md-down">%1$s%2$s</span>%4$s</a>',$atts['cart_text'],WC()->cart->get_cart_subtotal(),wc_get_cart_url(),$cart_icon);
	$output .= '<ul class="sub-menu"><div class="widget_shopping_cart_content">'.$mini_cart.'</div></ul>';
	$output .= '</li>';
	$output .= '</ul></div>';
	return $output;
}
function wan_myaccount($atts){
  $atts = shortcode_atts(['class'=>'color_default form_right s-10','form_title'=>'Login','icon'=>'fa fa-user'],$atts,'wan-myaccount');
  $current_user = wp_get_current_user();
  $output = '<div class="wan-myaccount '.$atts['class'].'"><ul class="menu">';
  $icon = (isset($atts['icon'])&& $atts['icon']!='') ? '<i class="'.$atts['icon'].'"></i>':'';
  if ($current_user->ID  > 0) {
	// return $current_user->user_login;
	$output .= sprintf('<li class="menu-item"><a href="javascript:void(0)">%4$s%1$s</a><ul class="sub-menu"><li class="menu-item"><a href="%2$s">%3$s</a></li></ul></li>',$current_user->user_login,wp_logout_url(home_url()),esc_html__('LogOut','wan'),$icon);
   
  }
  else {
	$output .= sprintf('<li class="menu-item"><a href="javascript:void(0)">%3$s%1$s</a><ul class="sub-menu"><li class="menu-item">%2$s</li></ul></li>',__('Login','wan'),wp_login_form(['form_id'=>'wan_ajax_login','echo'=>false,'remember'=>false]),$icon);
  }
  $output .= '</ul></div>';
  return $output;
}
add_shortcode ('post_by_cat','post_by_cat');
function post_by_cat($atts) {
	$atts = shortcode_atts(
		array(
			'cat' => '',
			'numposts' => '9',
		), $atts, 'bartag' );
    $query_args = array(
		'category_name' => $atts['cat'],
		'posts_per_page' => $atts['numposts'],
	);
	$query = new WP_Query($query_args);
	$post_html = '';
              
	if ($query->have_posts()):
			while ($query->have_posts()) :
				$query->the_post();
					$post_html .= '<div class="col-lg-3 col-sm-6 mb-2 new-1 ">'.
							'<div class="inner-content shadow">'.
		                        get_the_post_thumbnail(null,'wan-post-grid',['class'=>'w-100']).'
		                        <div class="text-news p-1">
		                            <p class="news-title pt-2 pb-2"><a href="'.get_the_permalink().'">'.get_the_title().' </a></p>
		                            <span class="news-date pb-2">'.get_the_date().'</span>
		                            <p class="news-text">'.wan_trim_words(get_the_content(),16).' </p>
		                            <a class="btn-demo btn" href="'.get_the_permalink().'">Chi tiết</a>
		                        </div>
	                        </div>
	                    </div>';

			endwhile;
			wp_reset_postdata();
	endif;
	$post_html .= '</div>';
	return '<div class="news row">'.$post_html.'</div>';

}
if (!function_exists('wan_get_terms')) { 
    function wan_get_terms($data,$field='slug') {
       $default_text = __('All');
        $data = wp_list_pluck($data,'value');
        $cats = $return=[];
        foreach ($data as $value) {
            switch ($value) {
                case 'post':
                   $cats[]='category';
                    break;
                case 'product':
                   $cats[]='product_cat';
                    break;
                default:
                    $cats[] = $value.'_category';
                    break;
            }
        }
        $taxonomies = get_terms($cats,[ 'hide_empty' => false]);
        foreach ($cats as $cat) {
            $return[$cat][] = ['label'=>$default_text,'value'=> $default_text];
        }
        if (is_array($taxonomies)):
            foreach ($taxonomies as $tx) {
                $return[$tx->taxonomy][] = ['label'=>$tx->name,'value'=>$tx->{$field}];
            }
        endif;
        return $return;
    }
}
function wan_add_quotes($string) {
    return '"'.$string.'"';
}
function wan_boolean($val,$base='yes') {
    return $val==$base?true:false;
}
if (!function_exists('get_image_sizes')):
function get_image_sizes() {
    global $_wp_additional_image_sizes;
    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }

    return $sizes;
}
endif;
if(!function_exists('wan_wpfilesystem')) {
	function wan_wpfilesystem(){
		require_once(ABSPATH . 'wp-admin/includes/file.php');
	}
}
function is_set_true($value) {
    return ($value == true || $value == 'true') ?  true : false;
}

add_action( 'enqueue_block_editor_assets', 'wan_base_import' );
function wan_base_import() {
  
    wp_enqueue_script(
        'wan-gutenberg-simple-sliders',
        WAN_KIT_URL.'blocks/wan-simple-button/block.build.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        filemtime( WAN_KIT_PATH.'blocks/wan-slider/block.build.js' )
    );
}
