<?php 
function wan_testimonial_render($atts) {
	$query  = new WP_Query(['post_type'=>'testimonial','posts_per_page'=>$atts['limit']]);
	extract($atts);
	$class[] = "scheme-$testimonial_scheme";
	$class[] = "$testimonial_style";
	$output = sprintf('<div data-items="%1$s" data-nav="%2$s" data-dots="%3$s" class="wan-sliders testimonial-container %4$s">',$col,$show_nav,$show_dots,implode(' ', $class));
		while ($query->have_posts() ) : $query->the_post();
			$output .= sprintf('<div class="testimonial-item item">
						<div class="testimonial-item-inner">
							<div class="testimonial-image">
								%1$s
							</div>
							<div class="testimonial-right-panel">
								%2$s
								<div class="testimonial-rating rate-%3$s">
								</div>
								<div class="testimonial-quotes">
									%4$s
								</div>
								<div class="testimonial-information">
									%5$s
								</div>
							</div>
						</div>
					</div>',$show_image == 'yes' ? get_the_post_thumbnail(null,'thumbnail'):'',isset($show_name)&&$show_name==true? '<h2>'.get_the_title().'</h2>':'',esc_attr(wan_meta('testimonial_rating')),get_the_content(),wpautop(wan_meta('testimonial_inforation')));
		endwhile;
	
	$output .= '</div>';

	wp_reset_postdata();
	return $output;
}
function wan_register_testimonial() {
	wp_register_script(
		'wan-gutenberg-testimonial',
		WAN_KIT_URL.'blocks/wan-testimonial/block.build.js',
		// 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCG5tstTAJNFU2_8q--LEeZdTtynOFfRRE&callback=initMap',
		array(  ),
		filemtime( WAN_KIT_PATH.'blocks/wan-testimonial/block.build.js' )
	);
	register_block_type(
			'wan-gutenberg/testimonial',
			[
			'attributes'      => [
									'testimonial_scheme'=> ['type'=>'string','default'=>'dark'],
									'testimonial_style'=> ['type'=>'string','default'=>'left'],
									'show_dots'=> ['type'=>'string','default'=>''],
									'show_nav'=> ['type'=>'string','default'=>''],
									'show_name'=> ['type'=>'boolean','default'=>false],
									'show_image'=> ['type'=>'string','default'=>'yes'],
									'col' => ['type'=>'string','default'=>'1'],
									'limit' => ['type'=>'string','default'=>'3']
								 ],
			'style' => 'wan-inline',
			'editor_style' => 'wan-inline',
			'editor_script' => 'wan-gutenberg-testimonial',
			'render_callback' => 'wan_testimonial_render',
			]
		);
}
add_action( 'init', 'wan_register_testimonial' );
?>
