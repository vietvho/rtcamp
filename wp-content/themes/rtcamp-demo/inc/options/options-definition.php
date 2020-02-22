<?php
/**
 * Return the default options of the theme
 * 
 * @return  void
 */

global $localscheme;
$localscheme = get_theme_mod('wan_skin');
function wan_portfolio_name() {
	$test = wan_get_opt('wan_skin');
	switch ($test) {
		case 'wan_restaurant':
			return esc_html__('Menu Item','wan');
			break;
		
		default:
			return esc_html__('Portfolios','wan');
			break;
	}
}

function wan_customize_default_options2($key,$scheme='default',$reset=false,$mode = 'meta',$id = 0) {
	global $scheme;

	$default['nochange'] = array(
		'page_title_container' => 'strech_row',
		'wan_skin' => 'default',
		'portfolio_slug' => 'accomodations',
		'portfolios_category' => 'All',
		'outsite_postmeta' => 'readmore',
		'postmeta_items' => 'date,comment,readmore,category,author',
		'postmeta_single_items' => 'date,comment,category,author',
		'portfolio_single_style' => 'normal',
		'topbar_container' => 'wan-container',
		'topbar_height' => '30px',
		'lowan_controls' => array('padding-top' => 0,'padding-left' => 15,'padding-right'=>0),
		'wan_show_topbar'=>true,
		'header_shadow'=>true,
		'top_footers_widgets'	=> "col-sm-6 col-md-4 order-md-6 \n order-md-7 col-sm-6 col-md-4 \n col-sm-6 col-md-2 \n col-sm-6 col-md-2",
		'center_footers_widgets'	=> "col-sm-4\ncol-sm-4\ncol-sm-4",
		'bottom_footers_widgets'	=> "col-sm-4\ncol-sm-4\ncol-sm-4 d-flex text-md-right",
		'htag_color'	=> '#000',
		'page_title_height' => '482px',
		'footer_controls' => array('padding-top' => 50,'padding-bottom'=>80,'border-bottom-width'=>1),
		'show_portfolio_title' => 1,
		'show_portfolio_category' => 1,
		'show_portfolio_details' => 0,
		'show_portfolio_description' => 0,
		'show_related_portfolio_title' => 1,
		'related_post_columns' => 3,
		'author_img_size' => 100,
		'show_author_info' => true,
		'show_related_portfolio_category' => 0,
		'show_related_portfolio_details' => 0,
		'show_related_portfolio_description' => 0,
		'show_vertical_menu'=>1,
		'show_primary_menu'=>0,
		'columns_space' => '',
		'portfolio_length' => 25,
		'portfolio_archive_style' => 'portfolio-grid',
		'portfolio_related_style' => 'portfolio-grid',
		'body_background_image' => '',
		'body_background_color' => '#fff',
		'bottom_fullwidth' => 0,
		'lowan_width' => 105,
		'enable_pagecallout' =>1,
		'page_callout_in_footer' => 0,
		'pagecallout_background_image' =>'',
		'pagecallout_background_color'=>'#fff',
		'menu_location_primary' => 'primary',
		'menu_hide_on'=>'hidden-md-up',
		'show_topbar_on_sticky' => false,
		'mobile_btn_scheme'=>'primary',
		'mobile_btn_style'=>'square',	
		'hamburger_position'	=> 'menu-left',
		'show-primary-location' => 0,

		'logo_normal'	=> WAN_LINK . 'images/logo.svg',

		'logo_sticky' => WAN_LINK . 'images/logo.svg',
		'put' => 'left',

		'social_links'	=> array ("facebook" => '#', "twitter"=>"#", "instagram"=>"#", "behance"=>"#"),
		'socials_font_size'=>'14px',
		'socials_spacing'=>'20px',
		'wan_excerpt_more'   => '',

		'socials_link_footer' => 0,
		'woocommerce_sidebar_cls'=>'col-md-4 col-lg-3',
		'woocommerce_layout' => 'sidebar-left',
		'woocommerce_columns'=>3,
		'woosingle_layout' => 'no-sidebar',
		'woosingle_extra_content' => '[wan_get_block_in_post id="307"]',
		'enable_social_link'  => 1,

		'lowan_margin_left' 	  => 0,
		'lowan_pos'=> 'left-header',

		'show_page_title'	  => 1,

		'page_title_overlay_color' => 'rgba(0,0,0,0)',

		'page_title_text_color' => '#222',

		'page_title_overlay_opacity' => 0,

		'page_title_controls' => array('padding-top' => 21,'margin-bottom' => 20),

		'page_title_background_image' => WAN_LINK.'/images/page-title.jpg',
		'title_position'=>'text-left',
		'breadcrumb_separator' => '<i class="fa fa-chevron-right"></i>',
		'breadcrumb_prefix' => '',

		'enable_content_right_top'  => 1,

		'topbar_background'	=> '#eeeaeb',

		'topbar_textcolor'	=> '#ffffffcc',
		'btheader_background' => '#e6c36e',
		'btheader_text_color' => '#333',
		'btheader_text_hover_color' => '#c8a551',
		'mainnav_backgroundcolor'=>'#ed1c24',

		'mainnav_color'		=> '#505050',

		'mainnav_hover_color'=>'#e60f1e',

		'sub_nav_color'		=>'#000',
		
		'sub_nav_background'=>'#fff',
		'dropdown_padding' => '20px',
		'dropdown_border_color'=>'#ececec',
		'dropdown_background_color'=>'#fff',
		'dropdown_max_columns'=>'4',
		'dropdown_text_style' => 'capitalize',
		'dropdown_listitem_spacing' => array('padding-top' => '8px','padding-bottom' => '8px','margin-left' => '10px','margin-right'=>'10px','border-bottom-width'=>1),
		'dropdown_listitem_border_color' => '#ececec',
		'dropdown_listitem_border_hover_color' => '#ececec',
		'dropdown_listitem_background_color' => 'rgba(255,255,255)',
		'dropdown_listitem_background_hover_color' => 'rgba(255,255,255)',
		'dropdown_text_color' => '#666666d9',
		'dropdown_text_hover_color' => '#111111d9',
		'dropdown_font_size' => '16px',
		'border_clor_sub_nav'=>'#cc4204',

		'sub_nav_background_hover'=>'#fff',

		'primary_color'=>'#8971a6',
		//~ 'primary_color'=>'rgba(122, 83, 81, 0.69)',
		'secondary_color' => '#dc7f9b',
		'success_color'=>'#71b02f',
		'alert_color' => '#b81c23',
		'button_transform'=>'uppercase',
		'default_button_size' => '0.875em',
		'slide_arrows'=> 'circle',
		'slide_bullets'=> 'simple',
		'link_color'=> '#333',

		'link_hover_color' => '#ed1c24',

		'body_text_color'=>'#1C1C1B',

		'body_secondary_text_color' => '#888',

		'body_font_name'	=> array(
			'family' => 'Open Sans',
			'style'  => '400',
			'size'   => '16',
			'line_height'=>'1.6',
			'letter_spacing'=>'0',

			), 
		'dropdown_arrow'=>true,
		'header_style'	=> 'header-default',
		'header_background'	=> '#fff',
		'header_middle_text_color'	=> '#232e3bb3',
		'header_middle_bold'=>true,
		'header_middle_height'	=> '90px',
		'header_middle_text_hover_color'	=> '#232E3B',
		'header_middle_text_style' => 'text-uppercase',
		'topbar_text_color' => '#fff',
		'topbar_text_hover_color' => '#FFBE00',
		'header_container' => 'wan-container',
		'header_content'	=> '
				<ul>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i> 120 Isaac Dr, Bunker Hill, WV, 25413    
					</li>
					<li>
						<i class="fa fa-envelope"></i> Contact us directly at +01 (985) 526-7099
					</li>
				</ul>	
		',
		'menu-breakpoint' => '1080px',
		'thumbnails' => "single|750|470|true\nblog-grid|470|320|true",
		'single_thumbnail' => 'single',
		'headings_font_name'	=> array(
			'family' => 'Open Sans',
			'style'  => '600',
			'line_height' =>  1.25,
			'letter_spacing'=>'0',
			),

		'header_font_name'	=> array(
			'family' => 'Open Sans',
			'style'  => '400',
			'size'	=> '12px',
			'letter_spacing'=>'0',
			),

		'footer_font_name'	=> array(
			'family' => 'Open Sans',
			'style'  => 'regular',			
			'size'	=> '14px',
			'letter_spacing'=>'0',
			),
		'cls_extra_font_name2'=>'extrabold',
		'cls_extra_font_name1'=>'chewy',
		'extra_font_name1'	=> array(
			'family' => 'Chewy',
			'style'  => '400',
			),
		'extra_font_name2'	=> array(
			'family' => 'Open Sans',
			'style'  => '800',
			),
		'h1_size' => 'inherit',

		'h2_size' => '1.875em',

		'h3_size' => '1.5em',

		'h4_size' => '1.25em',

		'h5_size' => '1.125em',

		'h6_size' => '1em',

		'show_post_paginator' => 0,

		'blog_grid_columns' => 2,
		'portfolio_grid_columns' => 'one-four',

		'testimonial_rating' => 0,

		'blog_layout' => 'sidebar-right',
		'blog_single_layout' => 'sidebar-right',
		'blog_style'=>'wan-grid',
		'blog_archive_show_zoom_btn' => true,
		'blog_archive_show_category' => false,
		'blog_archive_show_title' => true,
		'blog_archive_show_date' => true,
		'blog_archive_show_metas' => true,
		'blog_archive_show_content' => true,
		'blog_archive_metas' => '<li><i class="fa-folder-open fa"></i> [post_category]</li><li><i class="fa fa-comment-o"></i> [post_comments]</li>',
		'blog_single_style' => 'default',
		'gsidebar_cls'=>'col-md-4 pl-md-50 ',
		'gcontent_cls'=>'col-md-8',
		'blog_columns_spaces' => '30px',
		'blog_text_scales' => 89,
		'page_layout' => 'no-sidebar',
		'post_metas' => '<li><i class="fa fa-calendar"></i> [post_date]</li>
		<li><i class="fa fa-user"></i> [post_author]</li>
		<li><i class="fa-folder-open fa"></i> [post_category]</li><li><i class="fa-tag fa"></i> [post_tags]</li><li><i class="fa fa-comment-o"></i> [post_comments]</li>',
		'portfolios_sidebar' => 'sidebar-right',

		'blog_archive_layout' => 'blog-list',

		'blog_archive_post_excepts_length' => 20,

		'related_post_style'	=> 'blog-grid',

		'blog_sidebar_list'		  => 'sidebar-1',
		'blog_single_sidebar_list'		  => 'blog-sidebar',
		'show_related_post' => true,
		'number_related_post'=> 3,
		'blog_archive_htag' => 'h5',

		'show_post_navigator'	=> 1,	
		'show_post_title_in_navigator'	=> 1,
		'navigator_prev_label' => '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>',
		'navigator_next_label' => '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>',

		'blog_archive_readmore_text' => esc_html__('Continue reading ','wan').'<i class="fa fa-caret-right" aria-hidden="true"></i>',

		'blog_archive_pagination_style' => 'pager-numeric',

		'blog_posts_per_page'	=> 9,

		'blog_order_by'	=> 'date',

		'blog_order_direction' => 'DESC',
		'blog_thumbnail_size' => 'blog-grid',

		'page_sidebar_list'	=> 'sidebar-1',

		'menu_font_name'	=> array(
			'family' => 'Open Sans',
			'style'  => '700',
			'size'   => '12',
			'line_height'=>'1.2',
			'letter_spacing'=>'0',
			),

		'show_readmore'	  => 1,

		'show_filter_portfolio' => 0,

		'enable_single_gallery_slider' => 1,

		'grid_columns_portfolio' => 'one-three',

		'portfolio_single_layout' =>'portfolio',

		'portfolio_exclude' =>'',
		'portfolio_readmore_text' => '',

		'portfolio_archive_pagination_style' => 'pager-numeric',

		'portfolio_columns' => 'one-four',		

		'portfolio_post_perpage'	=> 12,

		'portfolio_order_by'	=> 'date',

		'portfolio_order_direction' => 'DESC',

		'portfolio_category_order' => '',

		'portfolio_single_style'	=> 'right_content',

		'grid_columns_portfolio_related' => 'one-three',

		'number_related_portfolio' =>3,

		'show_related_portfolio' => 1,		

		'enable_custom_topbar'  => 1,

		'breadcrumb_enabled'	=>true,
		'absolute_header'  => false,
		'enable_page_callout'	=> 0,

		'topbar_enabled' => true,
		'show_tagline' => false,
		'header_sticky' => true,
		'header_sticky_height'=>'70px',
		'header_searchbox' => 0,		
		'footer_container' => 'wan-container',
		'footer_top_line_color'	=> '#d1d1d1',
		'footer_widget_title_font_size' => '1.143em',
		'footer_background_color'	=> '#8971a6',
		'footer_top_line_color' => '#fff',
		'footer_widget_color'			=> '#fff',

		'footer_txt_color'			=> '#ffffffcc',

		'footer_text_color_hover'   => '#ed1c24',

		'bottom_background_color'	=> '#8971a6',
		'bottom_text_color'			=> '#8971a6',

		'wan_top'					=> 1,

		'layout_version'			=> 'wan-container',		

		'footer_copyright'			=> '<p>ALL RIGHTS RESERVED. <i class="fa fa-copyright" aria-hidden="true"></i> 2012 SAVI86 THEME.</p>',

		'top_content' => '

				<ul>

					<li>

						<i class="fa fa-map-marker" aria-hidden="true"></i> 120 Isaac Dr, Bunker Hill, WV, 25413    

					</li>

					<li>

						<i class="fa fa-phone   fa-flip-horizontal"></i> Contact us directly at +01 (985) 526-7099

					</li>



				</ul>	

		',
		'portfolio_name' => esc_html__('Portfolios','wan'),

		'top_content_right' => '<div class="info-top-right">

		<span><i class="fa fa-question-circle"></i>Have any questions</span>

		<a class="appoinment" href="#">Get An Appointment</a>

	</div>',

	);
	

	if ( $reset == true && isset($default[$scheme])) {

		foreach ($default[$scheme] as $key=> $value) {

			if ($key !='site_retina_logo' && $key != 'site_logo') {

				if ($mode =='meta') {

					update_post_meta($id,$key,$value);

				}

				else {

					if ($key != 'page_on_front') {

						remove_theme_mod($key);

					}

					else {

					    update_option( 'page_on_front',$value );

					    update_option( 'show_on_front', 'page' );

					}

				}

			}

		} 

		return esc_html__('Completed','wan');

	}

	$return = '';

	if (isset($default[$scheme][$key])) {

		return $default[$scheme][$key];

	}

	elseif(isset($default['nochange'][$key])) {

		return $default['nochange'][$key];

	}

	return $return;

}



/**
 * Return an array that used to declare options
 * for the page
 * 
 * @return  array
 */
function wan_portfolio_options_thumbnail_fields(){
	$options['gallery_images'] = array(

		'type'    => 'image-control',

		'section' => 'general',

		'title' => esc_html__( 'Images', 'wan'),

		'default' => ''

		);
	wan_prepare_options($options);

	return $options;
}

function wan_portfolio_options_fields() {
	global $localscheme;
	switch ($localscheme) {
		case 'wan_restaurant':
			$options['portfolio_meta1'] = array(
				'type'    => 'text',
				'section' => 'general',
				'title' => esc_html__( 'Food/Drink... Price', 'wan'),
				'default' => ''
				);
			
			break;
		
		default:

	$options['gallery_images_heading'] = array(

		'type' => 'heading',

		'section' => 'general',

		'title' => esc_html__( 'Post Format: Gallery .', 'wan'),


		);

	$options['project_details_heading'] = array(

		'type' => 'heading',

		'section' => 'general',

		'title' => esc_html__( 'Project Details', 'wan'),


		);

	$options['project_details'] = array(

		'type'    => 'editor',

		'section' => 'general',

		'title' => esc_html__( 'Information For Your Project', 'wan'),

		'description' => 'Shortcode support'

		);
	
			break;
	}

	wan_prepare_options($options);

	return $options;

}



function wan_testimonial_options_fields() {

	$options['cover_heading'] = array(

		'type' => 'heading',

		'section' => 'testimonial_details',

		'title' => esc_html__( 'Testimonial Details', 'wan'),

		);



	$options['testimonial_inforation'] = array(

		'type'    => 'editor',

		'section' => 'testimonial_details',

		'title' => esc_html__( 'Information', 'wan'),

		'default' => ''

	);


	$options['testimonial_rating'] = array(

		'type'    => 'select',

		'section' => 'testimonial_details',

		'title'   => esc_html__( 'Ratings', 'wan'),

		'default' => wan_get_opt('testimonial_rating'),

		'choices'   => array(

				'5' => esc_html__('5 Stars','wan'),

				'4' => esc_html__('4 Stars','wan'),

				'3' => esc_html__('3 Stars','wan'),

				'2' => esc_html__('2 Stars','wan'),

				'1' => esc_html__('1 Stars','wan'),

				'0' => esc_html__('No Rating','wan')

			)

	);



	$options['testimonial_link'] = array(

		'type'    => 'text',

		'section' => 'testimonial_details',

		'title' => esc_html__( 'Link', 'wan'),

		'default' => ''

	);



	wan_prepare_options($options);

	return $options;

}



function wan_post_options_fields() {

	$options['blog_heading'] = array(

		'type' => 'heading',

		'section' => 'blog',

		'title' => esc_html__( 'Dear friends,', 'wan'),

		'description' => esc_html__( 'Option just view if post format is gallery or video! <br/>Thanks!', 'wan')

		);

	$options['gallery_images_heading'] = array(

		'type' => 'heading',

		'section' => 'blog',

		'title' => esc_html__( 'Post Format: Gallery .', 'wan'),


		);



	$options['gallery_images'] = array(

		'type'    => 'image-control',

		'section' => 'blog',

		'title' => esc_html__( 'Images', 'wan'),

		'default' => ''

		);



	$options['video_url_heading'] = array(

		'type' => 'heading',

		'section' => 'blog',

		'title' => esc_html__( 'Post Format: Video ( Embeded video from youtube, vimeo ...).', 'wan'),


		);



	$options['video_url'] = array(

		'type'    => 'textarea',

		'section' => 'blog',

		'title' => esc_html__( 'iframe video link', 'wan'),

		'default' => ''

		);
	

	return $options;

}



function wan_blog_options_fields() {

	$options['position_field_heading'] = array(

		'type' => 'heading',

		'section' => 'events',

		'title' => esc_html__( 'Events', 'wan'),

		'description' => esc_html__( 'This is an special option, it allow to set Causes informations.', 'wan')

		);



	$options['position_field'] = array(

		'type'    => 'text',

		'section' => 'events',

		'title' => esc_html__( 'Position', 'wan'),

		'default' => ''

		);



	$options['address'] = array(

		'type'    => 'textarea',

		'section' => 'events',

		'title' => esc_html__( 'Address', 'wan'),

		'default' => ''

		);



	$options['event_time'] = array(

		'type'    => 'datetime',

		'section' => 'events',

		'title' => esc_html__( 'Event date time', 'wan'),

		'default' => ''

		);



	$options['event_link'] = array(

		'type'    => 'text',

		'section' => 'events',

		'title' => esc_html__( 'Link to join', 'wan'),

		'default' => ''

		);

	wan_prepare_options($options);

	return $options;

}


function wan_page_options_fields() {

	global $wp_registered_sidebars;

	$scheme = wan_choose_opt('wan_skin');

	add_filter('wan/portfolios/name','wan_edit_name');

	$options  = array();

	$sidebars = array();



	// Retrieve all registered sidebars

	foreach( $wp_registered_sidebars as $params )

		$sidebars[$params['id']] = $params['name'];


	/**
	 * General
	 */	


	$options['layout_version'] = array(

		'type'    => 'radio',

		'title'   => esc_html__( 'Display Style', 'wan'),

		'section' => 'general',

		'default' => 'wan-container',

		'choices' => array(

			'fullwidth'  => array(

				'src' => WAN_LINK . 'images/controls/layout-wide.png',

				'tooltip' => esc_html__( 'Full Width', 'wan')

				),



			'wan-container'  => array(

				'src' => WAN_LINK . 'images/controls/layout-boxed.png',

				'tooltip' => esc_html__( 'Container', 'wan')

				),

			)

		);

	$options['title_position'] = array(

		'type'    => 'radio',

		'title'   => esc_html__( 'Title', 'wan'),

		'section' => 'general',

		'default' => 'text-left',

		'choices' => array(

			'text-left'  => array(

				'src' => WAN_LINK . 'images/controls/layout-wide.png',

				'tooltip' => esc_html__( 'Left', 'wan')

				),



			'text-center'  => array(

				'src' => WAN_LINK . 'images/controls/layout-boxed.png',

				'tooltip' => esc_html__( 'Center', 'wan')

				),
			'text-right'  => array(

				'src' => WAN_LINK . 'images/controls/layout-boxed.png',

				'tooltip' => esc_html__( 'Right', 'wan')

				),
			'none'  => array(

				'src' => WAN_LINK . 'images/controls/layout-boxed.png',

				'tooltip' => esc_html__( 'None', 'wan')

				),


			)

		);
    $options['breadcrumb_enabled'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Enabled Breadcrumb', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('breadcrumb_enabled'),
		);
	 $options['absolute_header'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Absolute Header', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('absolute_header'),
		);
	$options['header_shadow'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Header Shadow', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('header_shadow'),
		);
	$options['page_layout'] = array(

		'type'    => 'radio',

		'title'   => esc_html__( 'Sidebar Position', 'wan'),

		'section' => 'general',

		'default' => 'no-sidebar',

		'choices' => array(

			'no-sidebar' => array(

				'src' => WAN_LINK . 'images/controls/no-sidebar.png',

				'tooltip' => esc_html__( 'No Sidebar', 'wan')

				),

			'sidebar-left' => array(

				'src' => WAN_LINK . 'images/controls/sidebar-left.png',

				'tooltip' => esc_html__( 'Sidebar Left', 'wan')

				),

			'sidebar-right' => array(

				'src' => WAN_LINK . 'images/controls/sidebar-right.png',

				'tooltip' => esc_html__( 'Sidebar Right', 'wan')

				)

			)

		);
	$options['primary_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Primary Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('primary_color'),
		);
	$options['topbar_background'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Topbar Background Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('topbar_background'),
		);
	$options['topbar_text_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Topbar Text Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('topbar_text_color'),
		);
	$options['topbar_text_hover_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Topbar Text Hover Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('topbar_text_hover_color'),
		);
	$options['header_background'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Header Background Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('header_background'),
		);
	$options['header_middle_text_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Header Text Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('header_middle_text_color'),
		);
	$options['header_middle_text_hover_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Header Text Hover Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('header_middle_text_hover_color'),
		);
	
	$options['footer_background_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Footer Background Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('footer_background_color'),
		);
	$options['bottom_background_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Bottom Background Color', 'wan'),
		'section' => 'general',
		'default' => wan_customize_default_options2('bottom_background_color'),
		);
	$options['page_class'] = array(
		'type'    => 'text',
		'title'   => esc_html__( 'Page Class', 'wan'),
		'section' => 'general',
		'default' => '',
		);
	$options = apply_filters('wan/skin_option',$options);

	

	// wan_prepare_options($options);

	

	return $options;

}

function return_children($ar) {

	if (isset($ar['children'])){ return $ar['children'];}

}

function wan_prepare_options($options) {

	$wan_data = get_option('wanoptions');

	$wanoptions = array();

	if(!is_array($wan_data)) $wan_data = array();

	$children = array_map('return_children', $options);

	$children = array_filter($children);

	foreach ($children as $key => $value) {

		if (is_array($value)) {

			foreach ($value as $_key => $_value) {

				$wanoptions[$_value] = $key;

			}

		}

		else {

			$wanoptions[$value] = $key;

		}

	}

	$wan_data = array_merge($wan_data,$wanoptions);

	update_option('wanoptions',$wan_data);

}

