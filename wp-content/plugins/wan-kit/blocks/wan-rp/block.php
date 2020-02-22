<?php

defined( 'ABSPATH' ) || exit;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */


function wan_post_attr() {
	$imgsizes = get_image_sizes();
	foreach ($imgsizes as $key => $value) {
		$crop = $value['crop'] == true ? ' - crop' : '';
		$imgdata[] = ['label'=>$value['width'].'x'.$value['height'].$crop,'value'=>$key];
	}
	$post_data = [
	['label'=> 'Post', 'value' => 'post'],
	['label'=> 'Gallery', 'value' => 'portfolio'],
	];
	$attributes = [	
	'post_type' => ['type'=> 'text','default'=>'post','data'=>$post_data],
	'category' => ['type'=>'text','default'=>'All','data'=>wan_get_terms($post_data)],
	'className' => ['type'=>'string','default'=>''],
	'num_posts' => ['type'=>'text','default'=>9],
	'content_length' => ['type'=>'text','default'=>10],
	'exclude' => ['type'=>'text','default'=>''],
	'post_style' => ['type'=>'text','default'=>'wan-grid','data'=>[
	['label'=> 'Grid', 'value' => 'wan-grid'],
	['label'=> 'Grid Tile', 'value' => 'wan-grid-tile'],
	['label'=> 'List', 'value' => 'wan-list'],
	['label'=> 'Masonry', 'value' => 'wan-masonry'],
	['label'=> 'Masonry Tile', 'value' => 'wan-masonry-tile'],
	]],
	'title_tag' => ['type'=> 'text','default'=>'h5'],
	'text_scale'=> ['type'=>'text', 'value'=>'89'],
	'thumb_size' => ['type'=>'text','default'=>'wan-blog-grid','data'=>$imgdata],
	'_columns' => ['type'=>'text','default'=>'4',
	'data'=>[
	['label'=> '1 Column', 'value' => '1'],
	['label'=> '2 Columns', 'value' => '2'],
	['label'=> '3 Columns', 'value' => '3'],
	['label'=> '4 Columns', 'value' => '4'],
	]],
	'blog_scheme' => ['type'=>'text','default'=>'scheme-dark'],
	'columns_spaces' => ['type'=>'text','default'=>''],
	'enabled_carousel' => ['type'=>'boolean','default'=>false],
	'show_filter' => ['type'=>'string','default'=>''],
	'show_title' => ['type'=>'boolean','default'=>true],
	'show_zoom_btn' => ['type'=>'boolean','default'=>false],
	'show_content' => ['type'=>'boolean','default'=>true],
	'show_cat' => ['type'=>'boolean','default'=> false],
	'show_nav' => ['type'=>'boolean','default'=> false],
	'show_dots' => ['type'=>'boolean','default'=> false],
	//'metas' => ['type'=>'text','default'=>'{icon:fa-calendar} {field:date},{icon:fa-comment-o}'],
	'metas' => ['type'=>'html','default'=>'<li><i class="fa-user"/>Content1</li><li><i class="fa-user"/>Content2</li>'],
	'show_metas' => ['type'=>'boolean','default'=>false],
	'show_dates' => ['type'=>'boolean','default'=>false],
	'readmore_text' => ['type'=>'text','default'=>__('Continue reading >','wan')],
	'readmore_style' => ['type'=> 'text','default'=>'']
	];
	return $attributes;
}
function wan_render_meta_item($meta) {
    preg_match_all('/{(.*?)}/', $meta, $matches);
    foreach ($matches[1] as $item){
    	// ( explode(':', $item));
    	list($key,$value) = explode(':', $item);
    	return  $key .$value .' <br>';
    }
   
}
function wan_posts_render($atts) {
	extract (apply_filters( 'wan/shortcode/wan_post_atts',$atts));
	
	$tiles = array('post-masonry-tiles','post-grid-tiles');
	$num_posts = intval( $num_posts );		
	$cat = $post_type == 'post' ? 'category' : $post_type.'_category';
	$terms = get_terms( $cat,'orderby=name&hide_empty=0');
	$terms_slug = wp_list_pluck( $terms, 'slug' );
	$terms_name = wp_list_pluck( $terms, 'name' );
	$filters =      wp_list_pluck( $terms, 'name','slug' ); 
	$ex_style = [];
	$tax =  $terms_slug;
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	
	$query_args = array(
		'post_type' => $post_type,
		'posts_per_page' => $num_posts,
		'paged' => $paged, 
		'post__not_in' =>  explode(',',$exclude),
		
		);

	if ( $category != 'All' ) {            
		$tax = $category;
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => $cat,   
				'field'    => 'slug',                   
				'terms'    => $tax,
				),
			);
	}		
	
	if ( ! empty( $atts['exclude'] ) ) {
		$exclude = $atts['exclude'];				
		if ( ! is_array( $exclude ) )
			$exclude = explode( ',', $exclude );

		$query_args['post__not_in'] = $exclude;
	}

	$query = new WP_Query( $query_args );
	$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages; 

	if ( ! $query->have_posts() )
		return esc_html__('No posts found!','wan');
	$post_html = '';

	$items = array (
		'list' => 1,
		'one-four' => 4,
		'one-half' => 2,
		'one-three' => 3
		);
	$layout_cls = [
		'wan-grid-tile' => 'wan-grid tiles',
		'wan-masonry-tile' => 'wan-grid masonry tiles'
	];
	$item_class = [];
	$tiles = false;
    $post_class =[$atts['post_style']];
	if (isset($layout_cls[$post_style])) {
		$post_class[] = $layout_cls[$post_style] ;
		$tiles = true;
	}
	// $columns = (int)$columns;
	$colCls = [1 => ' col-12', 2 => ' col-xs-12 col-sm-6', 3 => ' col-xs-12 col-sm-4', 4 => ' col-xs-12 col-md-6 col-lg-3'];
	if (isset($columns_spaces) && $columns_spaces != '' && $columns_spaces != '30px') {
		$item_class[] = "wan-$columns_spaces";
	}
	$item_class[] = $blog_scheme;
	if ($enabled_carousel && $post_style != 'wan-masonry' && $post_style != 'wan-masonry-tile') {
		wp_enqueue_style( 'wan-slick' );
		wp_enqueue_script( 'wan-slick' );
		$item_class[] = 'wan-sliders';
	}
	
	// echo wan_render_dimensions($columns_spaces);
	if (!in_array($post_style, array('post-list')) && isset($columns_spaces) && $columns_spaces != '' && $columns_spaces != '30px') {
		$post_html .= sprintf('<style>.wan-post:not(.post-list) .post-container.wan-%1$s{margin: 0 -%2$s;} .wan-post:not(.post-list) .post-container.wan-%1$s .item{padding:%2$s;}.wan-post:not(.post-list) .post-container.wan-%1$s .slick-next {right: %2$s;}.wan-post:not(.post-list) .post-container:not(.slide-top).wan-%1$s .slick-prev {left: %2$s;}.wan-post:not(.post-list) .post-container.slide-top.wan-%1$s .slick-prev {right: calc(48px + %2$s);}
			body:not(.wp-admin) .wan-sliders.wan-%1$s[data-centermode="yes"]:before,
			body:not(.wp-admin)  .wan-sliders.wan-%1$s[data-centermode="yes"]:after { width: calc(17.8%% - %2$s);}
			.wan-post:not(.post-list) .post-container:not(.slide-top).wan-%1$s[data-centermode="yes"] .slick-prev {left: calc(17.8%% + %2$s);}.wan-post:not(.post-list) .post-container:not(.slide-top).wan-%1$s[data-centermode="yes"] .slick-next {right: calc(17.8%% + %2$s);}
			</style>',$columns_spaces,wan_scale_dimensions($columns_spaces,0.5));

}
   
    if ($show_zoom_btn === true){
    	$post_class[] = 'show_zoom_btn';
    }
	$post_html .= '<div class="wan-post clearfix '.implode(' ', $post_class)." ".esc_attr( $className ).'" data-items="'.$_columns.'"  >';  // style="'.esc_attr($css).'"
	$show_filter = '';
	//Build the filter navigation
	$cls_filter = 'hide';
	if ( $show_filter != '' ) {	   
		$show_filter = 'show_filter';     
		$cls_filter = '';	
		echo '<ul class="post-filter clearfix '.esc_attr( $class ).'"><li class="active"><a data-filter="*" href="#">' . esc_html__( 'All', 'wan' ) . '</a></li>'; 
		if ($cat_order == '') { 
			foreach ($filters as $key => $value) {
				echo '<li><a data-filter=".' . esc_attr( strtolower($key)) . '" href="#" title="' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a></li>'; 
			}
		}
		else {
			$cat_order = explode(",", $cat_order);
			foreach ($cat_order as $key) {
				$key = trim($key);
				echo '<li><a data-filter=".' . esc_attr( strtolower($key)) . '" href="#" title="' . esc_attr( $filters[$key] ) . '">' . esc_html( $filters[$key] ) . '</a></li>'; 
			}
		}
            echo '</ul>'; //post-filter
        } 
        $slick = [];

        $post_html .= '<div data-slick="'.esc_attr(json_encode($slick)).'" class="post-container d-flex flex-wrap '.implode(' ', $item_class).' '.esc_attr( $_columns ).' '.esc_attr( $show_filter ).'"data-dots="yes" data-nav="yes" data-items="'.$_columns.'" >';     
        if (in_array($post_style ,array('post-masonry','post-masonry-tiles'))) {
        	$post_html.= '<div class="wan-masonry '.esc_attr( $_columns ).'"></div>';
        }  
        $post_meta_html = '';
        while ( $query->have_posts() ) : $query->the_post();
			$post_html .= wan_prepare_post_content(array_merge(['tiles'=>$tiles],$atts));
		endwhile;
	$post_html .= '</div>'; //end div post-container

	$post_html .= '</div>';
	$output = sprintf('<div class="post-container">
		%1$s
		</div>',$post_html);
	return $post_html;
}


function wan_register_rp() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
	wp_register_script(
		'wan-gutenberg-cpo',
		WAN_KIT_URL.'blocks/wan-rp/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-rp/block.build.js' )
		);

	wp_localize_script('wan-gutenberg-cpo','wan_attributes',wan_post_attr());
	wp_register_style( 'wan-inline', esc_url_raw(WAN_LINK . 'css/inline-css.css') );

	
	register_block_type(
		'wan-gutenberg/custom-post',
		[
		'attributes'      => wan_post_attr(),
		'style' => 'wan-inline',
		'editor_style' => 'wan-inline',
		'editor_script' => 'wan-gutenberg-cpo',
		'render_callback' => 'wan_posts_render',
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
add_action( 'init', 'wan_register_rp' );
add_action('enqueue_block_editor_assets','wan_register_iconbox');
function wan_register_iconbox() {
	wp_enqueue_script(
		'wan-gutenberg-iconbox',
		WAN_KIT_URL.'blocks/wan-iconbox/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-iconbox/block.build.js' )
		);
	wp_enqueue_script(
		'wan-gutenberg-slider',
		WAN_KIT_URL.'blocks/wan-slider/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-slider/block.build.js' )
		);

}
