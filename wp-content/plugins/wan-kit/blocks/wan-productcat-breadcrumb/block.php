<?php

defined( 'ABSPATH' ) || exit;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */


function wan_productcat_atts() {
	
	$post_data = [
		['label'=> 'Products', 'value' => 'product'],
	];
	
	$category = [['label'=> __('No categories Found','wan'),'value'=>'none']];
	$cats = wan_get_terms($post_data,'term_id');
	$cats['All']= __('Select One','wan');
	$attributes = [	
					'style'=>['type'=>'text','default'=>'list','data'=>[[
						'label'=>'Bread Crumb', 'name'=>'breadcrumb',
						'label'=>'List' ,'name'=>'list'
					]]],
					'category' => ['type'=>'text','default'=>'All','data'=>$cats],
					'show_all' => ['type'=>'string','default'=>esc_html__('Show All','wan')],
					'limit' => ['type'=>'string','default'=>2],
					'columns'=>['type'=>'number','default'=>2],
					'orderby'=>['type'=>'string','default'=>'rand'],
					'order'=>['type'=>'string','default'=>'desc'],
					'product_title'=>['type'=>'boolean','default'=>true],
					'product_rating'=>['type'=>'boolean','default'=>true],
					'product_price'=>['type'=>'boolean','default'=>true],
					'add_to_cart'=>['type'=>'boolean','default'=>true],
					];
	return $attributes;
}

function wan_productcat_render($atts) {
	extract (apply_filters( 'wan/shortcode/wan_productcat_atts',$atts));
	$args = ['taxonomy'=>'product_cat','echo'=>false,'child_of'=>$category,'hide_empty'=>0];
	if ( $category != 'All' ) {    
		$term =  get_term($category);
	  	$term_link = (get_term_link($term ,'product_cat'));
	 	$args['title_li']= sprintf('<a class="current-cat" href="%1$s"><strong>%2$s</strong></a>',$term_link,$term->name);
	 	$output= '<div class="wan-productcat-'.$style.'">';
		 	if ($style=='breadcrumb'):
		 		$args['title_li']= sprintf('<a class="current-cat" href="%1$s"><strong>%2$s</strong></a>',$term_link,$term->name);
			 	$output .= sprintf('%1$s<a class="pull-right" href="%2$s"><strong>%3$s</strong></a>',wp_list_categories($args),$term_link,$show_all);
			 else:
		 	  	$thumbnail_id = get_term_meta( $category, 'thumbnail_id', true );
			    $image = wp_get_attachment_url( $thumbnail_id );
			    $output .= sprintf('<img src="%1$s" alt="%2$s"/>',$image,$term->name);
			    $output .= '<div class="category-list">';
			 	$args['title_li']= sprintf('<h6>%1$s</h6><ul><li><a class="current-cat" href="%2$s"><strong>%3$s</strong></a></li></ul>',$term->name,$term_link,$show_all);
			 	$output .= wp_list_categories($args);
			 	$output .= '</div>';
			 endif;
		$output.= '</div>';

		return $output;  
	}
	return esc_html__('Please Choose Product Category');
}
 
function wan_product_crossell_render($atts) {
	if (!WC()->cart) {
		return '<div class="p-30 text-primary"><strong>'.__("The products will show base on cart items",'wan').'</strong></div>';
	}
	extract($atts);
	  // Get visible cross sells then sort them at random.
	  $cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );

	  wc_set_loop_prop( 'name', 'cross-sells' );
	  wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_cross_sells_columns', $columns ) );

	  // Handle orderby and limit results.
	  $orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
	  $order       = apply_filters( 'woocommerce_cross_sells_order', $order );
	  $cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
	  $limit       = apply_filters( 'woocommerce_cross_sells_total', $limit );
	  $cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;
	  $cls=[];
	  if ($product_title==false) {
	  	$cls[] = 'hide_title';
	  }
  	  if ($product_price==false) {
	  	$cls[] = 'hide_price';
	  }
	  if ($product_rating==false) {
	  	$cls[] = 'hide_rating';
	  }
	  if ($add_to_cart==false) {
	  	$cls[] = 'hide_cart_button';
	  }
	  ob_start();
	  wc_get_template(
		  'cart/cross-sells.php',
		  array(
			  'cross_sells'    => $cross_sells,

			  // Not used now, but used in previous version of up-sells.php.
			  'posts_per_page' => $limit,
			  'orderby'        => $orderby,
			  'columns'        => $columns,
		  )
	  );
	  return '<div class="woocommerce '.implode(' ', $cls).'">'.ob_get_clean().'</div>';
}
function wan_register_productcat() {
	if ( !class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
	wp_register_script(
		'wan-gutenberg-brc',
		WAN_KIT_URL.'blocks/wan-productcat-breadcrumb/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-productcat-breadcrumb/block.build.js' )
	);
	wp_localize_script('wan-gutenberg-brc','wan_breadcrumb',wan_productcat_atts());
	wp_register_style( 'wan-inline', esc_url_raw(wan_LINK . 'css/inline-css.css') );

	register_block_type(
		'wan-gutenberg/productcat-breadcrumb',
		[
		'attributes'      => wan_productcat_atts(),
		'style' => 'wan-inline',
		'editor_style' => 'wan-inline',
		'editor_script' => 'wan-gutenberg-brc',
		'render_callback' => 'wan_productcat_render',
		]
	);
	register_block_type(
		'wan-gutenberg/product-cross-sell',
		[
		'attributes'      => wan_productcat_atts(),
		'style' => 'wan-inline',
		'editor_style' => 'wan-inline',
		'editor_script' => 'wan-gutenberg-brc',
		'render_callback' => 'wan_product_crossell_render',
		]
	);

  if ( function_exists( 'wp_set_script_translations' ) ) {
    /**
     * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
     * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
     * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
     */
    wp_set_script_translations( 'gutenberg-wan', 'wan' );
  }

}
	add_action( 'init', 'wan_register_productcat');
