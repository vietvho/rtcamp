<?php

defined( 'ABSPATH' ) || exit;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */


function wan_attr() {
	$imgsizes = get_image_sizes();
	foreach ($imgsizes as $key => $value) {
		$crop = $value['crop'] == true ? ' - crop' : '';
		$imgdata[] = ['label'=>$value['width'].'x'.$value['height'].$crop,'value'=>$key];
	}
	$pages = (get_pages());$output = [];foreach ($pages as $page) {
	array_push($output,["label"=>$page->post_title,'value'=>$page->ID]);}
	$attributes = [	
		'className' => ['type'=>'string','default'=>''],
		'content_length' => ['type'=>'text','default'=>10],
		'thumb_size' => ['type'=>'text','default'=>'thumbnail','data'=>$imgdata],
		'thumb_border'=>['type'=>'boolean','default'=>true],
		'page_id' => ['type'=>'text','default'=>'','data'=>$output],
	];
	return $attributes;
}
function wma_render_meta_item($meta) {
    preg_match_all('/{(.*?)}/', $meta, $matches);
    foreach ($matches[1] as $item){
    	// ( explode(':', $item));
    	list($key,$value) = explode(':', $item);
    	return  $key .$value .' <br>';
    }
   
}
function wma_rtcamp_render($atts) {
	extract($atts);
	$output = __('Choose a page to load','wan');
	if ($thumb_border == true) {
		$className .= ' border_thumb';
	}
	if($page_id != '') {
		$post = get_post($page_id);
		$output = sprintf('<div class="wan-specified-page p-10 %s">',$className);
		$output .= sprintf('<h2 class="wan-title">%s</h2>',$post->post_title);
		$output .= get_the_post_thumbnail($page_id,$thumb_size);
		$output .= wp_trim_words($post->post_content,$content_length);
		$output .= sprintf('<a class="readmore" href="%s">%s</a>',get_permalink($page_id),__('Read More...','wan'));
		$output .= '</div>';
	}
	return $output ;
}
function wma_sidebar_render($atts){
	//~ return $atts['sidebar'];
	ob_start();
	echo '<div class="wan-sidebar '.$atts['className'].'">';
		dynamic_sidebar($atts['sidebar']);
	echo '</div>';
	return ob_get_clean();
}
function wan_register_rtcamp() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
	wp_register_script(
		'wan-rtcamp-cpo',
		WAN_KIT_URL.'blocks/wan-rtcamp/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-rtcamp/block.build.js' )
		);
	wp_localize_script('wan-rtcamp-cpo','wanlist',wan_attr());
	wp_localize_script('wan-rtcamp-cpo','wansidebars',$GLOBALS['wp_registered_sidebars']);
	
	register_block_type(
		'wan-gutenberg/wan-show-page',
		[
		'attributes'      => wan_attr(),
		'editor_script' => 'wan-rtcamp-cpo',
		'render_callback' => 'wma_rtcamp_render',
		]
		);
	register_block_type(
		'wan-gutenberg/wan-sidebarareas',
		[
		'attributes'      => ['sidebar'=> ['type'=>'string','default'=>'sidebar-1'],'className'=> ['type'=>'string','default'=>'']],
		'editor_script' => 'wan-rtcamp-cpo',
		'render_callback' => 'wma_sidebar_render',
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
add_action( 'init', 'wan_register_rtcamp' );
