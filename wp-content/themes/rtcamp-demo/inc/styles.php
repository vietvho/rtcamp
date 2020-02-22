<?php
/**
 * @package akha
 */
//Output all custom styles for this theme
function wan_custom_styles($admin=false) {
	$custom = '';
	global $scheme;
	$scheme = wan_choose_opt('wan_skin');
	$scheme = apply_filters('wan_global_scheme',$scheme);
	$font = wan_get_json('body_font_name');
	$font_style = wan_font_style($font['style']);
	$body_fonts = $font['family'];
	$body_line_height = $font['line_height'];
	$body_font_weight = $font_style[0];
	$body_font_style = $font_style[1];
	$body_size = $font['size'];	
	
	$headings_fonts_ = wan_get_json('headings_font_name');
	$headings_fonts_family = $headings_fonts_['family'];	
	$headings_style = wan_font_style( $headings_fonts_['style'] );
	$headings_font_weight = $headings_style[0];
	$headings_font_style = $headings_style[1];
	$headings_line_height = $headings_fonts_['line_height'];

	$header_fonts_ = wan_get_json('header_font_name');
	$header_fonts_family = $header_fonts_['family'];	
	$header_style = wan_font_style( $header_fonts_['style'] );
	$header_font_weight = $header_style[0];
	$header_font_style = $header_style[1];
	$header_font_size = $header_fonts_['size'];
	$header_middle_height = wan_choose_opt('header_middle_height');
	$header_sticky_height = wan_choose_opt('header_sticky_height');
	$topbar_height = wan_choose_opt('topbar_height');

	$footer_fonts_ = wan_get_json('footer_font_name');
	$footer_fonts_family = $footer_fonts_['family'];	
	$footer_style = wan_font_style( $footer_fonts_['style'] );
	$footer_font_weight = $footer_style[0];
	$footer_font_style = $footer_style[1];
	$footer_font_size = $footer_fonts_['size'];

	$menu_fonts_ = wan_decode(wan_load_header('menu_font_name'));
	$menu_fonts_family = $menu_fonts_['family'];
	$menu_fonts_size = $menu_fonts_['size'];
	$menu_line_height = $menu_fonts_['line_height'];
	$menu_style = wan_font_style( $menu_fonts_['style'] );
	$menu_font_weight = $menu_style[0];
	$menu_font_style = $menu_style[1];	
	$extrafont1 = wan_get_json('extra_font_name1');
	$extrafont1_style = wan_font_style($extrafont1['style']);
	$clsextrafont1 = wan_choose_opt('cls_extra_font_name1');
	$clsextrafont2 = wan_choose_opt('cls_extra_font_name2');
	$extrafont2 = wan_get_json('extra_font_name2');
	$extrafont2_style = wan_font_style($extrafont2['style']);
	$lowan_controls = wan_decode(wan_load_header('lowan_controls'));
    wan_render_box_position(".logo",$lowan_controls);
	$footer_controls = wan_decode(wan_choose_opt('footer_controls'));
    wan_render_box_position("#footer",$footer_controls);
	$page_title_controls = wan_decode(wan_get_opt('page_title_controls'));
    wan_render_box_position("div.page-title",$page_title_controls);
    $page_title_overlay = wan_choose_opt('page_title_overlay_color');
    $custom .= sprintf('div.page-title .overlay,.paper.boxed .wan-boxed{  background:%s}',$page_title_overlay);
	$socials_font_size = wan_choose_opt('socials_font_size');
	$socials_spacing = wan_choose_opt('socials_spacing');
    $page_title_img = wan_choose_opt('page_title_background_image');
   	$lowan_width = wan_render_dimensions(wan_load_scheme('lowan_width'));
	$custom .= "header .logo{flex: 0 0 $lowan_width;max-width: $lowan_width;}";
    $custom .= 'div.page-title {background: url('.$page_title_img.') center /cover no-repeat;height: '.wan_get_opt('page_title_height').'}';
	$body_background_color = wan_load_scheme('body_background_color');
	$success_color = wan_choose_opt('success_color');
	$alert_color = wan_choose_opt('alert_color');
	$dropdown_border_color = wan_choose_opt('dropdown_border_color');
	$dropdown_background_color = wan_choose_opt('dropdown_background_color');
	$dropdown_text_color = wan_choose_opt('dropdown_text_color');
	$dropdown_text_style = wan_choose_opt('dropdown_text_style');
	$dropdown_text_hover_color = wan_choose_opt('dropdown_text_hover_color');
	$dropdown_font_size = wan_choose_opt('dropdown_font_size');
	$dropdown_padding = wan_choose_opt('dropdown_padding');
	$dropdown_listitem_background_color = wan_choose_opt('dropdown_listitem_background_color');
	$dropdown_listitem_background_hover_color = wan_choose_opt('dropdown_listitem_background_hover_color');
	$dropdown_listitem_spacing = wan_decode(wan_get_opt('dropdown_listitem_spacing'));
    wan_render_box_position("header .sub-menu >li >a",$dropdown_listitem_spacing);
    $footer_widget_title_font_size = wan_choose_opt('footer_widget_title_font_size');

	$wpcls= '.wp-admin';
	$editor = '.edit-post-visual-editor.editor-styles-wrapper';
	if ($socials_font_size) {
		$custom .=".wan-socials{font-size:$socials_font_size;}";
	}
	if ($socials_spacing) {
		$custom .=".wan-socials > li{margin-right:$socials_spacing;}";
	}
if ($body_background_color != '') {
    	$custom .= "body:not($wpcls),$editor {background-color:".$body_background_color.";} ";
    }

	// Body font family
	if ( $body_fonts !='' ) {
		$custom .= "body:not($wpcls),$editor { font-family:" . $body_fonts . " ; }"."\n";
	}

	// Body font weight
	if ( $body_font_weight !='' ) {
		$custom .= "body:not($wpcls),$editor { font-weight:" . $body_font_weight . ";}"."\n";
	}

	// Body font style
	if ( isset( $body_font_style ) ) {
        $custom .= "body:not($wpcls),$editor { font-style:" . $body_font_style . "; }"."\n";        
	}

    // Body font size
    if ( $body_size !=''  ) {
        $custom .= "body:not($wpcls),$editor { font-size:" . intval( $body_size ) . "px; }"."\n";        
    }

    // Body line height
    if ( $body_line_height != '' ) {
        $custom .= "body:not($wpcls),$editor { line-height:" .  $body_line_height  . " ; }"."\n";        
    }
	$body_var = sprintf('$body_fonts:%1$s;$body_line_height:%2$s;$body_font_weight:%3$s;$body_font_style:%4$s;$body_size:%5$s',$body_fonts,$body_line_height,$body_font_weight,$body_font_style,$body_size);
	
	if ($admin==true) {
		
		$custom .= ".edit-post-layout__content{";
	}
	// Headings font family
	if ( $headings_fonts_family !='' ) {
		$custom .= "h1,h2,h3,h4,h5,h6, input[type=submit], .category-post,.editor-block-list__layout .wan-sliders + .wan-slick-dots:before,
.editor-block-list__layout .wan-sliders + .wan-slick-dots:after, edit-post-layout__content button,edit-post-layout__content .button,wan-button,.btn,.wp-block-button__link,.testimonial-information  { font-family:" . $headings_fonts_family . ";}"."\n";
	}
	// button transform 
	$custom .='$button: "button, input[type=button], input[type=reset], input[type=submit],.button,.button,.btn,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.wc-product-preview__add-to-cart.wp-block-button__link, button:not(.components-button):not(.customize-partial-edit-shortcut-button):not([id*=mceu]),.woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled],.woocommerce-cart .wc-proceed-to-checkout a.checkout-button";';
	$button_transform = wan_choose_opt('button_transform');
	if ($button_transform){
		$custom .='#{$button}{text-transform:'.$button_transform.';}';
	}
	$default_button_size = wan_choose_opt('default_button_size');
	if ($default_button_size) {
		$custom .= '#{$button}{
			font-size:'. $default_button_size.';
		}';
	}
	if($clsextrafont1) {
		$clsextrafont1 = str_replace('.','',$clsextrafont1);
		$custom .= sprintf('.%1$s{font-family:%2$s;font-weight:%3$s;font-style:%4$s;}',$clsextrafont1,$extrafont1['family'],$extrafont1_style[0],$extrafont1_style[1]);
		}
	if($clsextrafont2) {
		$clsextrafont2 = str_replace('.','',$clsextrafont2);
		$custom .= sprintf('.%1$s{font-family:%2$s;font-weight:%3$s;font-style:%4$s;}',$clsextrafont2,$extrafont2['family'],$extrafont2_style[0],$extrafont2_style[1]);
		}
	//Headings font weight
	if ( $headings_font_weight !='' ) {
		$custom .= "h1,h2,h3,h4,h5,h6 { font-weight:" . $headings_font_weight . ";}"."\n";
	}

	// Headings font style
	if ( isset( $headings_font_style )) {
        $custom .= "h1,h2,h3,h4,h5,h6  { font-style:" . $headings_font_style . "; }"."\n";        
	}

	// Headings line height
	if (isset($headings_line_height)) {
		$important = '';
		if ($admin == true ) {
			$important = '!important;';
		}
		$custom .= "h1,h2,h3,h4,h5,h6,.cols-4 .wc-product-preview .wc-product-preview__title, .cols-5 .wc-product-preview .wc-product-preview__title, .cols-6 .wc-product-preview .wc-product-preview__title{line-height:$headings_line_height$important}";
	}


	// Menu font family
	if ( $menu_fonts_family != '') {
		$custom .= "header .main-menu, .header .widget_nav_menu ,#mega-menu-vertical_menu_location a.mega-menu-link,.wan-vertical-menu-block { font-family:" . $menu_fonts_family . ";}"."\n";
	}

	// Menu font weight
	if ( $menu_font_weight != '' ) {
		$custom .= "header .main-menu, header .header-main  .widget_nav_menu { font-weight:" . $menu_font_weight . ";}"."\n";
		$custom .= ".vertical-menu-container  a.mega-menu-link,#mega-menu-vertical_menu_location a.mega-menu-link {font-weight:" . $menu_font_weight . "!important;}";
	}

	// Menu font style
	if ( isset( $menu_font_style )) {
        $custom .= "header .header-main .widget_nav_menu ,.vertical_menu_location { font-style:" . $menu_font_style . "; }"."\n";        
	}

    // Menu font size
    if ( $menu_fonts_size != '' ) {
        $custom .= "header .main-menu, .header .header-main .widget_nav_menu,.vertical_menu_location { font-size:" . (float)($menu_fonts_size) . "px;}"."\n";
        $custom .= "#mega-menu-vertical_menu_location a.mega-menu-link { font-size:" . (float)($menu_fonts_size) . "px!important;}"."\n";
    }

    // Menu line height
    if ( $menu_line_height != '' ) {
        $custom .= "header.header_main .widget_nav_menu  { line-height:" . (float)($menu_line_height) .";}"."\n";
    }
    
	// H1 font size
	if ( $h1_size = wan_get_opt( 'h1_size' ) ) {
	}

    // H2 font size
    if ( $h2_size = wan_get_opt( 'h2_size' ) ) {
		$custom .= "h2,.h2,.woocommerce-products-header__title{font-size:$h2_size}";
	}

    // H3 font size
    if ( $h3_size = wan_get_opt( 'h3_size' ) ) {
		$custom .= "h3,.h3{font-size:$h3_size}";
		}

    // H4 font size
    if ( $h4_size = wan_get_opt( 'h4_size' ) ) {
		$custom .= "h4,.h4{font-size:$h4_size}";
    }

    // H5 font size
    if ( $h5_size = wan_get_opt( 'h5_size' ) ) {
		$custom .= "h5,.h5{font-size:$h5_size}";
    }

    // H6 font size
    if ( $h6_size = wan_get_opt( 'h6_size' ) ) {
		$custom .= "h6,.h6{font-size:$h6_size}";
	}
  
    $link_color = wan_choose_opt('link_color');
    if ($link_color != '') {
    	$custom .= ' a,.wan-button.no-background,a.pdf_brochure,.blog-list .entry-title:hover a,editor-block-list__layout .button:hover, button.no-bgcolor, .button.no-bgcolor,
.editor-block-list__layout button.no-bgcolor:not(.components-button),.editor-block-list__layout .button.no-bgcolor,  input[type=submit].white ,
  button.white  {color: '.$link_color.';}';
    	$custom .= '.editor-block-list__layout .wan-sliders:after,.editor-block-list__layout .wan-sliders:before {background:'.$link_color.'}';
    }
    $link_hover_color = wan_choose_opt('link_hover_color');
    if ($link_hover_color != '') {
    	$custom .= ' a:hover, .sidebar ul li a:hover, .sidebar .widget_categories li a:hover, .sidebar .widget_nav_menu li:hover, .sidebar .widget_nav_menu li a:hover,.woocommerce #content .wan-product-single .compare.button:hover,.woocommerce #content .wan-product-single .yith-wcwl-wishlistaddedbrowse a:hover,.woocommerce #content .wan-product-single  .yith-wcwl-wishlistexistsbrowse a:hover{color: '.$link_hover_color.';}';
    	$custom .= "a.hover:hover{color:$link_hover_color!important;}";
    	//border color 
    	$custom .='.wan-button.no-background{border-color:'.$link_hover_color.';}';
    	//background link hover color 
    	$custom  .= '.wan-button.no-background:before, .button:hover,
editor-block-list__layout input[type=submit]:hover{background-color:'.$link_hover_color.'}';
    }

    $text_secondary_color = wan_choose_opt('body_secondary_text_color');
    if ( $text_secondary_color !='' ) {
		$custom .= "border-ts{border-color:$text_secondary_color;}";
    	$custom .= ".text_secondary,.text-bodysecondary,.text.bodysecondary,.checkout-progress-bar,.woocommerce.wan-breadcrumb {color: $text_secondary_color;}";
    }

    $secondary_color = wan_choose_opt('secondary_color');
    if ($secondary_color) {
		$custom .= ".text-secondary,.text_secondary,.text.secondary{color:$secondary_color;}";
		$custom .= '#{$button}{&.secondary,&.secondary:hover{background-color:'.$secondary_color.';}}';
		$custom .= '#{$button}{&.outline.secondary:not(:hover){color:'.$secondary_color.'}}';
		$custom .= '#{$button}{&.secondary,&.outline.secondary:hover{border-color:'.$secondary_color.'}}';
    	$custom .= ".woocommerce .button{ &.checkout,&.checkout:hover,&.button.alt ,&.button.alt:hover{background-color:$secondary_color;}}";
    	$custom .= ".woocommerce .button{&.checkout,&.checkout:hover,&.button.alt ,&.button.alt:hover{border-color:$secondary_color;}}";
    	$custom .=".woocommerce #review_form #respond input[type=submit]{background-color:$secondary_color;}";
    	$custom .=".woocommerce #review_form #respond input[type=submit]:hover{background-color:$secondary_color;}";
	}
	if ($success_color) {
		$custom .= ".text-success,.text_success,.text.success{color:$success_color;}";
		$custom .= '#{$button}{&.success,&.success:hover{background-color:'.$success_color.';}}';
		$custom .= '#{$button}{&.outline.success:not(:hover){color:'.$success_color.'}}';
		$custom .= '#{$button}{&.success,&.outline.success:hover{border-color:'.$success_color.'}}';
	}
	if ($alert_color) {
		$custom .= ".text-alert,.text_alert,.text.alert{color:$alert_color;}";
		$custom .= '#{$button}{&.alert,&.alert:hover{background-color:'.$alert_color.';}}';
		$custom .= '#{$button}{&.outline.alert:not(:hover){color:'.$alert_color.'}}';
		$custom .= '#{$button}{&.alert,&.outline.alert:hover{border-color:'.$alert_color.'}}';
    }
    $pagecallout_color = wan_get_opt('pagecallout_background_color');
    $custom .= '.page-callout{background-color:'.$pagecallout_color.'}';
	$pagecallout_bg = wan_get_opt('pagecallout_background_image');
    $custom .= '.page-callout{background-image:url('.$pagecallout_bg.');background-size:cover;background-attachment:fixed;}';
    // htag_color
    $htag_color = wan_load_scheme('htag_color');
    if ( $htag_color !='' ) {
    	$custom .= " h1,h2,h3,h4,h5,h6,.wc-block-grid__product-title{ color:" . esc_attr($htag_color) . ";}";	
    }
	$custom .= '@mixin pri_hover_color($color){
    	button,input[type=submit],input[type=submit], .sbtn-outline button:hover{background-color:$color;}
    	.sbtn-outline button:hover{border-color:$color!important;}
    	.sbtn-transpaprent button {
    		color: $color!important;
    	}
    }';
    $custom .= '@mixin lik_hover_color($color){
    	a:hover, a:active, a.active,  a:focus, .sbtn-outline button,.current-menu-item > a,.current-menu-ancestor >a, .nice-select:hover .current{color: $color;}
    	.wan-ef-6,.wan-ef-8{
				.menu > .current-menu-item > a,.current-menu-ancestor >a,a:hover,a.active,a:focus {
					background-color: $color;
				}
			}
			.wan-ef-8 {
				a {
					background-color: $color;
				}
			}
			.wan-ef-2,.wan-ef-3,.wan-ef-4,.wan-ef-7 {
				a:before {
					background-color: $color;
				}
			}
			.wan-ef-4 a:before {
				background-color: $color;
			}
			.wan-ef-5 {
				.current-menu-item > a,.current-menu-ancestor >a,a:hover,a.active, a:focus {
					border-color: $color;
				}
			}
			.wan-ef-5 .menu-item-has-children,
			.wan-ef-4 .menu-item-has-children,
			.wan-ef-3 .menu-item-has-children,
			.wan-ef-2 .menu-item-has-children,
			.wan-ef-1 .menu-item-has-children {
				&.current-menu-item > a,&.current-menu-ancestor >a,a:hover,a.active, a:focus {
					&:after {
						border-bottom-color: $color;
						border-right-color: $color;
					}
				}
			}
    }';
    // Primary color    
    $primary_color = wan_choose_opt( 'primary_color' );
    if ( $primary_color !='' ) {
    	$custom .= ":root { --primary_color: $primary_color; }";
		$custom .= " .dark_version .sidebar .widget_nav_menu li:not(:hover), .dark_version .sidebar .widget_nav_menu li a:not(:hover), .dark_version .blog-single .entry-title, .minimal .WAN_ICONbox:hover h5.title,.minimal .WAN_ICONbox:hover .iconbox_content_inner,.funny_yellow .WAN_ICONbox:hover h5.title,.funny_yellow .WAN_ICONbox:hover .iconbox_content_inner, .dark_version .comments-area .comment_meta .comement_reply,.dark_version .logged-in-as a:not(:hover),.paper .page-title .page-title-heading,.wan_simple_image_container.somefun:before,.portfolio-meta,.comments-area .comment_content .comment_author,.woocommerce ul.products li.product .price, .wc-product-preview .wc-product-preview__price ins,.widget_product_categories .product-categories > li > a,.wan-list-toggle>ul>li.cat-parent:before,.woocommerce #content .wan-product-single div.product .woocommerce-tabs ul.tabs li.active,.widget-wan-recent-post .date i, .wan-product.thumbnail-container .vertical-bar .yith-wcwl-wishlistexistsbrowse a:before,.wan-product.thumbnail-container .vertical-bar .add_to_wishlist:hover:before, .wan-product.thumbnail-container .vertical-bar .compare-button a:hover:before,.wan-product.thumbnail-container .vertical-bar .yith-wcqv-button:hover:before,.wan-product.thumbnail-container .vertical-bar  .yith-wcwl-wishlistaddedbrowse  a:before,.wan-product.thumbnail-container .vertical-bar .compare.button.added:before,.author-description .author-title{ color:" . esc_attr($primary_color) . ";}";	
		$custom .= "button,.btn, input[type=button], input[type=reset], input[type=submit],.button,.button,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button{&.outline.primary:not(:hover){color:$primary_color;}}";
    	//color important
    	$custom .= ".text-primary,.nav-simple .slick-arrow:hover,.wan-post.show_zoom_btn.tiles .wan-zoom-btn i  {color:".esc_attr($primary_color)."!important}";
    	$custom .= ".text.primary,.woocommerce div.product p.price, .woocommerce div.product span.price,.wc-block-grid__product-price {color:".esc_attr($primary_color)."}";

		// Background color
		// #fff
		$custom .= ".owl-theme .owl-dots .owl-dot span:hover, .owl-theme .owl-dots .owl-dot.active span,.wan-button.slider_min_12,.wan_price,.blog-shortcode.blog-grid-tile.hide_thumbnail .main-post,.btn-menu:before, .btn-menu:after, .btn-menu span ,.wan_simple_image_container.outsite .image_container .wan-button, input[type=submit],  button, .button,
.editor-block-list__layout input[type=submit], .editor-block-list__layout button:not(.components-button),.editor-block-list__layout .button,.wan-button,button:not(.components-button),.wp-block-button__link,input[type=submit], .button:hover,$editor .button:hover {color:#fff; }";

		// Background
		$custom .= ".wan-button.no-background:before,button, input[type=button], input[type=reset], input[type=submit],.button,.button,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, input[type=submit],button:not(.components-button):not(.customize-partial-edit-shortcut-button),.btn,.button ,.wie-button,.slick-arrow:hover,.woocommerce span.onsale,.wc-product-preview__add-to-cart.wp-block-button__link,.wan-productcat-breadcrumb .current-cat,.wan-productcat-breadcrumb .current-cat:after,.wan-post.tiles .featured-post:before,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.onsale.percent,.wan-product.thumbnail-container .add_to_cart_button,.wan-product.thumbnail-container .product_type_external{background-color:".esc_attr($primary_color)."}";
		//hover same color
		$custom .="button, input[type=button], input[type=reset], input[type=submit],.button,.button,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.btn{background-color:$primary_color;&:hover{background-color:".esc_attr($primary_color)."}}";
	$custom .= "@include pri_hover_color($primary_color);";
		// Border color
	$custom .= ".border-primary,.slick-arrow:hover,.wan-productcat-breadcrumb,.woocommerce #content .wan-product-single div.product .woocommerce-tabs ul.tabs li.active,blockquote{ border-color:" . esc_attr($primary_color) . "}";
	$custom .= "input[type=submit],button:not(.components-button):not(.customize-partial-edit-shortcut-button),.btn,.button ,.wie-button{ &.outline:hover{ border-color:" . esc_attr($primary_color) . "}}";
	$custom .= ".border-primary-darken{ border-color:" . darken_color(esc_attr($primary_color),1.2) . ";}";
	$custom .= " .vertical-menu-container .max-mega-menu ,  .vertical-menu-container .max-mega-menu>li>.mega-sub-menu,  .vertical-menu-widget .max-mega-menu>li>.mega-sub-menu{ border-color:" . darken_color(esc_attr($primary_color),1.2) . "!important;}";
		$custom .=".paper .page-title,.paper .sidebar .widget-title{border-bottom: 1px solid $primary_color}";

		
		// Color #fff
		$custom .= " .navigation .page-numbers, .navigation .loop-pagination a:hover{
			color: #fff ;
		}";	
		 
    }
	//bottom color 
	$btheader_background = wan_choose_opt('btheader_background');
    if ($btheader_background != '') {
		$custom .= ".header-bottom{background-color: $btheader_background;}";
    }
    $btheader_text_color = wan_choose_opt('btheader_text_color');
    if ($btheader_text_color != '') {
		$custom .= ".header-bottom{color: $btheader_text_color;}";
    }
     $btheader_text_hover_color = wan_choose_opt('btheader_text_hover_color');
    if ($btheader_text_hover_color != '') {
		$custom .= ".header-bottom .wan-ef-7 a:before {background: $btheader_text_hover_color;}";
    }
    // Header color
    $header_middle_text_color = wan_choose_opt('header_middle_text_color');
    if ($header_middle_text_color != '') {
		$custom .= ".header-main{color: $header_middle_text_color;}";
		$custom .= ".header-main{.dropdown-toggle:after, .menu-item-has-children>a:after, .nice-select>span.current:after{border-bottom-color:$header_middle_text_color;border-right-color: $header_middle_text_color;}}";
    }
    $header_middle_text_hover_color = wan_choose_opt('header_middle_text_hover_color');
	if ($header_middle_text_hover_color != '') {
		$custom .=".header-main {@include pri_hover_color($header_middle_text_hover_color);}";
		$custom .=".header-main{@include lik_hover_color($header_middle_text_hover_color);}";
    }

     $header_background = wan_choose_opt('header_background');
    if ($header_background != '') {
    	$custom .= "header .header-main{background:$header_background}";
	}
	if ($header_middle_height) {
    	$custom .= ".middle_height{min-height:$header_middle_height}";
	}
	if ($header_sticky_height) {
    	$custom .= ".sticky .middle_height{min-height:$header_sticky_height}";
	}
	$header_middle_bold = wan_choose_opt('header_middle_bold');
	if ($header_middle_bold) {
		$custom .= '.header-main{font-weight:bold;}';
	}

     // Topbar color
    $topbar_text_color = wan_choose_opt('topbar_text_color');
    if ($topbar_text_color != '') {
		$custom .= ".header-top{color:$topbar_text_color;}";
		$custom .= ".header-top{.dropdown-toggle:after, .menu-item-has-children>a:after, .nice-select>span.current:after{border-bottom-color:$topbar_text_color;border-right-color: $topbar_text_color;}}";
    }
	$topbar_text_hover_color = wan_choose_opt('topbar_text_hover_color');
    if ($topbar_text_hover_color != '') {
		$custom .= ".header-top a:hover,.header-top a.active, .header-top a:focus,.header-top .current-menu-item > a {color:$topbar_text_hover_color;}";
		$custom .= ".header-top .current-menu-item {.dropdown-toggle:after,.menu-item-has-children>a:after, .nice-select>span.current:after{border-bottom-color:$topbar_text_hover_color;border-right-color: $topbar_text_hover_color;}}";
		$custom .= ".header-top {.dropdown-toggle:hover:after, .menu-item-has-children>a:hover:after, .nice-select.open>span.current:after, .nice-select:hover>span.current:after{border-bottom-color:$topbar_text_hover_color;border-right-color: $topbar_text_hover_color;}}";
		$custom .="	.header-top {
			@include lik_hover_color($topbar_text_hover_color);
		}";
    }

    $topbar_background_color = wan_choose_opt('topbar_background');
    if ($topbar_background_color != '') {
    	$custom .= ".header-top {background-color:$topbar_background_color}";
    	$custom .= "header .sub-menu li.fa:before{color:$topbar_background_color}";
	}
	
	if($topbar_height !=''){
		$custom .= ".topbar-height{min-height:$topbar_height;}";
	}

	//dropdown color
	if($dropdown_background_color) {
		$custom .= "header {.menu > li>.sub-menu , .nice-select .list {background-color: $dropdown_background_color;}}";
	}
	if($dropdown_border_color) {
		$custom .= "	header {.menu > li>.sub-menu , .nice-select .list {border-color: $dropdown_border_color;}}";
	}
	if($dropdown_padding) {
		$custom .= "	header {.menu > li>.sub-menu , .nice-select .list {padding: $dropdown_padding;}}";
	}
	if($dropdown_text_color) {
		$custom .= "header .sub-menu a,header .nice-select .list {color: $dropdown_text_color;}";
		$custom .= " header .woocommerce a.remove{color: $dropdown_text_color!important;}";
	}
	if($dropdown_text_hover_color) {
		$custom .= "header .sub-menu {.menu-item-has-children>a,.current-menu-item >a, a:hover,a.active{color: $dropdown_text_hover_color;}}";
		$custom .= "header .nice-select .list li:hover,header .nice-select  .option.selected{color: $dropdown_text_hover_color;}";
		$custom .= "header .woocommerce a.remove:hover{color: $dropdown_text_hover_color!important;}";
	}
	if($dropdown_text_style) {
		$custom .= "header .sub-menu ,header .nice-select .list {text-transform: $dropdown_text_style;}";
	}
	if($dropdown_listitem_background_color) {
		$custom .= "header .menu .sub-menu >li >a, header .nice-select .option{background-color: $dropdown_listitem_background_color;}";
	}
	if($dropdown_listitem_background_hover_color) {
		$custom .= "header .menu .sub-menu >li > a:hover,header .nice-select .option:hover{background-color: $dropdown_listitem_background_hover_color;}";
	}
	if ($dropdown_font_size) {
		$custom .= ".nice-select .list, header .sub-menu{font-size: $dropdown_font_size;}";
	}
	// Body color
	$body_text = wan_load_scheme( 'body_text_color' );
	if ($body_text !='') {
		$custom .= ":root{--text_color:$body_text}";
		$custom .= ".wan-post .featured-post .featured-absolute, body,.product del,input:not([type=submit]), select, textarea,.paper .page-title .breadcrumb-trail, .paper .page-title .breadcrumb-trail a:not(:hover),.color_default .wan-myaccount-form,.color_default .wan-myaccount-form a:not(:hover),.bg-whtie,.text-dark,.checkout-progress-bar.cart .cart,.checkout-progress-bar.checkout .checkout,.checkout-progress-bar.completed .completed { color:" . esc_attr($body_text) . "}";
	}

	//background body image
	$background_url = wan_choose_opt('body_background_image');
	$custom .= "body {background-image:url(".esc_url($background_url).")}";

    // Menu Background
	$mainnav_backgroundcolor = wan_choose_opt( 'mainnav_backgroundcolor');
	if ( $mainnav_backgroundcolor !='' ) {
		$custom .= " .main-nav,.pink .header .wan_relative{background:" . esc_attr( $mainnav_backgroundcolor ) ."!important ;} ";
		$custom .= '.header-style2-absolute.header-sticky{background: rgba(0,0,0,0.65)!important}';
		
	} 
   
	// Menu mainnav a color
	$mainnav_color = wan_choose_opt( 'mainnav_color');
	if ( $mainnav_color !='' ) {
		$custom .= ".main-menu > ul > li > a { color:" . esc_attr( $mainnav_color ) . "!important;}"."\n";
	}

	// mainnav_hover_color
	$mainnav_hover_color = wan_choose_opt( 'mainnav_hover_color');
	if ( $mainnav_hover_color !='' ) {
		$custom .= ".main-menu > ul > li:hover > a,.main-menu > ul > li.current-menu-item > a,.main-menu .header-action a , .main-menu ul.dropdown-menu > li > a:hover, .main-menu ul.dropdown-menu > li.current-menu-item > a{ color:" . esc_attr( $mainnav_hover_color ) . " !important;}"."\n";
	}

	//Subnav a color
	$sub_nav_color = wan_load_scheme( 'sub_nav_color');
	if ( $sub_nav_color !='' ) {
		$custom .= ".main-menu ul.dropdown-menu > li > a,.vertical-menu-container li:not(.mega-current-menu-item) a:not(:hover) { color:" . esc_attr( $sub_nav_color ) . "!important;}"."\n";
	}

	//Subnav background color
	$sub_nav_background = wan_choose_opt( 'sub_nav_background');
	if ( $sub_nav_background !='' ) {
		$custom .= ".main-menu ul li { background-color:" . esc_attr( $sub_nav_background ) . ";}";			
		$custom .=".paper .WAN_ICONbox:hover:before, .paper .WAN_ICONbox:hover,.sky .WAN_ICONbox:hover:before, .sky .WAN_ICONbox:hover {background: $sub_nav_background !important}";
	}

	//sub_nav_background_hover
	$sub_nav_background_hover = wan_choose_opt( 'sub_nav_background_hover');
	if ( $sub_nav_background_hover !='' ) {
		$custom .= ".main-menu .dropdown-item:hover, .main-menu .dropdown-item:focus{background-color:" . esc_attr($sub_nav_background_hover) . "!important;}"."\n";
	}

	//border color sub nav
	$border_clor_sub_nav = wan_get_opt( 'border_clor_sub_nav');
	if ( $border_clor_sub_nav !='' ) {
		$custom .= " .main-menu ul.dropdown-menu > li,.main-nav-mobi ul li { border-color:" . esc_attr($border_clor_sub_nav) . "!important;}";
	}	

	$custom .= " #footer {font-family:$footer_fonts_family;font-size:".wan_render_dimensions($footer_font_size).";font-weight:$footer_font_weight !important;}";
	$custom .= " header {font-family:$header_fonts_family;font-size:$header_font_size;font-weight:$header_font_weight }";
	$custom .= "header .sub-menu, header ul ul,header .product_list_widget {font-weight: $header_font_weight;}";
	// Footer simple background color
	$footer_background_color = wan_choose_opt( 'footer_background_color');
	if ( $footer_background_color !='' ) {
		$custom .= " #footer { background-color:" . esc_attr($footer_background_color) . ";}";
		//color 
		$custom .= ".dark_version .bottom ul li a:hover,.blance_white .bottom ul li a:hover{color:$footer_background_color}";
	}
	$footer_top_line_color  = wan_choose_opt('footer_top_line_color');
	if ($footer_top_line_color){
		$custom .="#footer{border-color:$footer_top_line_color}";
	}
	if ($footer_widget_title_font_size !=''){
		$custom .= "#footer .widget-title{font-size:$footer_widget_title_font_size;}";
	}
	$bottom_background_color = wan_choose_opt( 'bottom_background_color');
	if ( $bottom_background_color !='' ) {
		$custom .= " #bottom{ background-color:" . esc_attr($bottom_background_color) . ";}";
	}

	// Footer Top Line Color
	$footer_top_line_color = wan_load_scheme('footer_top_line_color');
	if ($footer_top_line_color != '') {
		//border-color
		$custom .= ".footer{border-color:$footer_top_line_color}";
	}


	//Footer Widget Title Color 
	$footer_widget_color = wan_load_scheme('footer_widget_color');
	if ($footer_widget_color != '') {
		$custom .="#footer .widget-title{color: $footer_widget_color!important}";
	}

	// Footer simple text color
	$footer_text_color = wan_choose_opt( 'footer_txt_color');
	if ( $footer_text_color !='' ) {
		$custom .= "#footer,#footer a:not(:hover),#bottom,#bottom a:not(:hover){ color:" . esc_attr($footer_text_color) . ";}";
	}

	//footer text hover color
	$footer_text_color_hover = wan_load_scheme('footer_text_color_hover');
	if ($footer_text_color_hover != ''){
		//color
		$custom .= "#footer ul li:hover:before,#footer a:hover,#footer ul li a:hover,#bottom ul li:hover:before,#bottom ul li a:hover{color:$footer_text_color_hover}";
		//border
		$custom .="#footer ul li a:before, .bottom ul li:hover{border-color:$footer_text_color_hover}";
		//border important
		$custom .=" .bottom ul li:hover,.paper .bottom .bottom_content {border-color:$footer_text_color_hover!important}";
		//background
		// background important
		$custom .=" .bottom ul li:before{background:$footer_text_color_hover!important}";

	}

	// Bottom text color
	$bottom_text_color = wan_choose_opt( 'bottom_text_color');
	if ( $bottom_text_color !='' ) {
		$custom .= " .bottom{ color:" . esc_attr( $bottom_text_color ) . ";}";
	}
	$custom .= '@media only screen and (max-width: '.esc_attr(wan_choose_opt('menu-breakpoint')).'){
					header .navbar-toggler {
					    display: block!important;
					}
					header .navbar-nav {
						flex-direction: column!important;
					}
					.header-default .logo,  {
						max-width: '.wan_scale_dimensions($lowan_width,0.8).'
					}
					.header-default .widget_search {
						width: 100%;
					}
					.header-default .widget_search .search-form {
						    width: 100%;
						    opacity: 1;
						    visibility: visible;
						    left: 0;
						    right: auto;
						    top: 0;
					}
					.header-default .widget_search .show-search {
						height: 40px;
					}
					.header-default .show-search {
						pointer-events: none;
					    opacity: 0;
					}
					.bottom-header-widgets {
						padding: 15px 0;
					} 
					.navbar-expand-lg .navbar-collapse {
						flex-basis: 100%;
					}
					.navbar-expand-lg .navbar-nav .nav-link {
						padding-left: 0;
					}
					.collapse:not(.show) {
						display: none;
					}
			}';
	$basevar = array('_primary_color' => $primary_color);
	$custom .= strtr(get_theme_mod('default_theme_css',''),$basevar);
	$resh1 = wan_scale_dimensions($h1_size,0.83);
	$resh2 = wan_scale_dimensions($h2_size,0.83);
	$custom .= "@media screen and (max-width:960px){";
	$custom .= "h2,.h2{font-size:$resh2;}";
	$custom .= "}";
	$resh1 = wan_scale_dimensions($h1_size,0.63);
	$resh2 = wan_scale_dimensions($h2_size,0.63);
	$custom .= "@media screen and (max-width:600px){";
	$custom .= "h2,.h2{font-size:$resh2;}";
	$custom .= "}";
	$typekitkey = get_theme_mod('add_typekit_font','');
	if ($admin==true) {
		$custom .= "}";
	}
	if ($typekitkey!=''):?>
		<script>
		  (function(d) {
		    var config = {
		      kitId: "<?php printf('%s', $typekitkey);?>",
		      scriptTimeout: 3000,
		      async: true
		    },
		    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		  })(document);
		</script>
	<?php 
	endif;
	$localfont = get_theme_mod('add_local_font','');
	$localfont = wan_decode($localfont);
	if ($localfont != '') {
		foreach ($localfont as $key => $value) {
			$font_weight = wan_font_style($value['font_weight']);
			$local_font_weight = $font_weight[0];
			$local_font_style = $font_weight[1];
			printf('<style>@font-face {
					    font-family: %1$s;
					    src: url(%2$s);
					    font-style: %3$s;
					    font-weight: %4$s;
					}</style>',$value['font_name'],$value['font_url'],$local_font_style,$local_font_weight);
		}
	}
	return $custom;
}
include_once WAN_DIR . "inc/scss.inc.php";
use Leafo\ScssPhp\Compiler;
function wan_custom_styles_front() {
	$scss = new Compiler();
	$scss->setFormatter("Leafo\ScssPhp\Formatter\Compressed");
	$css = wan_custom_styles();
	$css =  $scss->compile($css);
	wp_add_inline_style('wan-theme',$css);
}

function wan_custom_styles_admin() {
	$scss = new Compiler();
	$scss->setFormatter("Leafo\ScssPhp\Formatter\Compressed");
	$css = wan_custom_styles(true);
	$css =  $scss->compile($css);
	wp_add_inline_style('wan_customizer_css',$css);
}
add_action( 'wp_enqueue_scripts', 'wan_custom_styles_front',10 );
add_action( 'admin_enqueue_scripts', 'wan_custom_styles_admin',15 );

function load_css() {
	$skin = wan_choose_opt('wan_skin');
    $primary_color = wan_load_scheme( 'primary_color' );

	$current_css = get_option('wan_current_css');
	//disable if for test mode;
		$css= choose_css('default');
		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if (empty($wp_filesystem)) {
		  wan_wpfilesystem();
		}
		$css .= get_theme_mod('default_theme_css','');
		$a = $wp_filesystem->put_contents(WAN_DIR."css/inline-css.css",$css);
		update_option('wan_current_css',$skin);
}

function choose_css($skin) {
	$skins = array();
    $primary_color = wan_load_scheme( 'primary_color' );
	
	
	if (isset($skin) && isset($skins[$skin])) {
		return $skins[$skin];
	}
}

