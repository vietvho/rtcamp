<?php 
add_action( 'enqueue_block_editor_assets', 'wan_register_maps' );
function wan_register_maps() {
	// wp_enqueue_script( 'wan-pkg', esc_url_raw(wan_LINK . 'js/wan-pkg.js'), array(),'1.1',true);
	wp_enqueue_script(
		'wan-gutenberg-maps',
		WAN_KIT_URL.'blocks/wan-maps/block.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( WAN_KIT_PATH.'blocks/wan-maps/block.build.js' )
	);
	wp_register_script(
		'3rd-gmaps',
		'https://maps.googleapis.com/maps/api/js?key=AIzaSyCG5tstTAJNFU2_8q--LEeZdTtynOFfRRE',
		// 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCG5tstTAJNFU2_8q--LEeZdTtynOFfRRE&callback=initMap',
		array(  ),
		filemtime( WAN_KIT_PATH.'blocks/wan-maps/block.build.js' )
	);
	
	register_block_type(
		'wan-gutenberg/maps',
		[
			'script' => '3rd-gmaps',
			'editor_script' => '3rd-gmaps',
			'render_callback' => 'wan_maps_render',
			'attributes' => [
					'embed_code'=>['type'=>'string','default'=>'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2219.3398966786785!2d-156.44476690220512!3d20.691133659607615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7954dadaa703c761%3A0x53d2a5dce8bd0b0!2sWailea%2C+Wailea-Makena%2C+HI+96753%2C+USA!5e0!3m2!1sen!2s!4v1552313294928" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'],
					'map_height'=>['type'=>'string','default'=>'400px'],
					'map_cls'=>['type'=>'string','default'=>'wan-map-'.rand(1,1000).'-'.time()]
								]
		]
	);
	
}
function wan_maps_render($atts,$content) {
	if ($atts['map_height'] != '100%') {
		$style = sprintf('<style>.%1$s iframe{height:%2$s}</style>',$atts['map_cls'],$atts['map_height']);
	}
	else {
		$style = sprintf('<style>.%1$s,.%1$s iframe{height:%2$s}</style>',$atts['map_cls'],$atts['map_height']);
	}
	return $style.'<div class="wan-maps '.$atts['map_cls'].'">'.html_entity_decode($atts['embed_code']).'</div>';

}
?>