<?php
/**
 * savi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package savi
 */
// remove_theme_mods();
add_filter('show_admin_bar', '__return_false');
define( 'WAN_DIR', trailingslashit( get_template_directory() )) ;
define( 'WAN_LINK', trailingslashit( get_template_directory_uri() ) );
define( 'WAN_ICON', WAN_LINK.'icon/favicon.png' );
remove_action('shutdown', 'wp_ob_end_flush_all', 1);
if ( ! function_exists( 'wan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wan_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on savi, use a find and replace
		 * to change 'wan' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wan', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wan' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		$thumb = trim(wan_choose_opt('thumbnails'));
		$thumbAr = explode("\n", $thumb);
		$thumbAr = array_filter($thumbAr, 'trim'); // remove any extra \r characters left behind
		foreach ($thumbAr as $line) {
		    // processing here. 
		    $t1=[250,250,250,true];
		    $t = explode('|', $line) + $t1;
			add_image_size($t[0],$t[1],$t[2],$t[3]);
		} 
		add_image_size('wan_recentpost',100,76,true);
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wan_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );


	}
endif;
add_action( 'after_setup_theme', 'wan_setup' );
function wan_fonts_url() {
	global $wan_mainID,$scheme;
    $fonts_url = ''; 
    $body_font_name = wan_get_json('body_font_name');
    $headings_font_name = wan_get_json('headings_font_name');
    $menu_font_name = wan_get_json('menu_font_name');
    $extrafont1 = wan_get_json('extra_font_name1');
    $extrafont2 = wan_get_json('extra_font_name2');
    $header_font_name = wan_get_json('header_font_name');
    $footer_font_name = wan_get_json('footer_font_name');
    $font_custom = wan_decode(wan_meta('mw_custom_fonts'));
    $font_families = array(); 
    if (is_array($font_custom)) {
    	foreach ($font_custom as $key => $value){
    		if ($key != '') {
				$font_families[$key][] = '300,400,500,600,700,900';
	    	}
    	}
    }
    if ( '' != $body_font_name ) {
        $font_families[$body_font_name['family']][] = wan_get_style($body_font_name['style']);
    } else {
        $font_families['Lato'][] = '400,400i,700,700i,900';
    }   

    if ( '' != $footer_font_name ) {
        $font_families[$footer_font_name['family']][] = wan_get_style($footer_font_name['style']);
    }
    if ( '' != $header_font_name ) {
		$hexweight = wan_choose_opt('header_middle_bold') ? ',700':'';
        $font_families[$header_font_name['family']][] = wan_get_style($header_font_name['style']).$hexweight;
    } 
	
    if ( '' != $extrafont1 ) {
        $font_families[$extrafont1['family']][] = wan_get_style($extrafont1['style']);
    }
     if ( '' != $extrafont2 ) {
        $font_families[$extrafont2['family']][] = wan_get_style($extrafont2['style']);
    }
    if ( '' != $headings_font_name ) {
        $font_families[$headings_font_name['family']][] = wan_get_style($headings_font_name['style']);
    }
	
     else {
        $font_families['Lato'][] = '400,400i,700,700i,900';
    }    

    if ( '' != $menu_font_name ) {
        $font_families[$headings_font_name['family']][] = wan_get_style($headings_font_name['style']);
    } else {
        $font_families['Lato'][] = '400,400i,700,700i,900';
	}    
	$font_render = [];
	foreach($font_families as $key => $fontitem) {
		$style = array_unique($fontitem);
		$font_render[] = $key .':'. implode(',',$style);
	}
    $query_args = array(
        'family' => urlencode( implode( '|', $font_render ) ),        
    );

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    return esc_url_raw( $fonts_url );
}

function wan_scripts_styles() {
	
	wp_enqueue_style( 'jquery-select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css', array(), null );
	wp_enqueue_script( 'jquery-select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js', array('jquery'),'20151215' , true );

	$response =  wp_remote_get(wan_fonts_url());
	$response_code = wp_remote_retrieve_response_code( $response );
	if ($response_code != 400) {
	    wp_enqueue_style( 'wan-theme-slug-fonts', wan_fonts_url(), array(), null );
	}
	?>
	<script type="text/javascript">
		if (window.jQuery) {
			jQuery(function ($) {
				"use strict";
				<?php echo wan_get_opt('wan_custom_js') . "\n"; ?>
			});
		}
	</script>
	<?php 
}

add_action( 'wp_footer', 'wan_scripts_styles' );
add_action( 'admin_enqueue_scripts', 'wan_scripts_styles' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wan_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'wan_content_width', 640 );
}
add_action( 'after_setup_theme', 'wan_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wan_widgets_init() {
	$sidebars = [
		'topbar-center'=>esc_html__("Center Area Topbar",'wan'),
		'topbar-right'=>esc_html__("Right Area Topbar",'wan'),
		'header-right'=>esc_html__("Right Area Header Main",'wan'),
		'header-bottom'=>esc_html__("Bottom Area Header Main",'wan'),
		'hamburger-menu'=>esc_html__("Header Hamburger Menu",'wan'),
	];
	foreach ($sidebars as $slug=>$name){
		register_sidebar( array(
			'name'          => $name,
			'id'            => $slug,
			'description'   => esc_html__( 'Add ','wan').$name.esc_html__(' Element here.', 'wan' ),
			'before_widget' => '<div id="%1$s" class="widget align-middle %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	$top_footers = wan_get_opt('top_footers_widgets');
	$top_footers = explode("\n", $top_footers);
    foreach ($top_footers as $id=>$name):
       register_sidebar( array(
			'name'          => "Top Footer ".($id+1),
			'id'            => sprintf( 'top-footer-%s', ($id+1) ),
            'description' => __('Elements for top footer ','wan').($id+1),
			'before_widget' => '<div id="%1$s" class="widget align-middle %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	endforeach;
	$center_footers = wan_get_opt('center_footers_widgets');
    $center_footers = explode("\n", $center_footers);
    foreach ($center_footers as $id=>$name):
       register_sidebar( array(
			'name'          => "Middle Footer ".($id+1),
			'id'            => sprintf( 'center-footer-%s', ($id+1) ),
            'description' => __('Elements for middle footer ','wan').($id+1),
			'before_widget' => '<div id="%1$s" class="widget align-middle %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	endforeach;
	$bottom_footers = wan_get_opt('bottom_footers_widgets');
    $bottom_footers = explode("\n", $bottom_footers);
    foreach ($bottom_footers as $id=>$name):
       register_sidebar( array(
			'name'          => "Bottom Footer ".($id+1),
			'id'            => sprintf( 'bottom-footer-%s', ($id+1) ),
            'description' => __('Elements for Bottom footer ','wan').($id+1),
			'before_widget' => '<div id="%1$s" class="widget align-middle %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	endforeach;
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wan' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wan' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Shop', 'wan' ),
		'id'            => 'shop',
		'description'   => esc_html__( 'Add widgets here.', 'wan' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'wan_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wan_scripts() {
	wp_enqueue_style( 'wan-3rd', esc_url_raw(WAN_LINK . 'css/base.css') );
	wp_enqueue_style( 'wan-theme', esc_url_raw(WAN_LINK . 'css/main.css') );
	wp_enqueue_style( 'wan-responsive', esc_url_raw(WAN_LINK . 'css/responsive.css') );
	wp_enqueue_style( 'wan-style', get_stylesheet_uri() );

	wp_enqueue_script( 'wan-simplelightbox', get_template_directory_uri() . '/js/simpleLightbox.min.js', array(), '20151215', true );
	wp_enqueue_script( 'wan-html5lightbox', get_template_directory_uri() . '/js/html5lightbox.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery-moment', get_template_directory_uri() . '/js/moment.js', array(), '1.5.7', true );
	wp_enqueue_script( 'jquery-moment-data', get_template_directory_uri() . '/js/moment-timezone-with-data.js', array(), '1.5.7', true );
	wp_enqueue_script( 'wan-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery-nice-select', get_template_directory_uri() . '/js/jquery.nice-select.min.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/js/slick.min.js', array(), '1.5.7', true );
	wp_enqueue_script( 'jquery-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array(), '1.5.7', true );
	wp_enqueue_script( 'wan-pkg', get_template_directory_uri() . '/js/wan-pkg.js', array('jquery'),'20151215' , true );
	wp_localize_script( 'wan-pkg', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'wan-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wan_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/widgets/recent-post.php';
require get_template_directory() . '/widgets/rtcamp.php';
require get_template_directory() . '/inc/styles.php';
require get_template_directory() . '/inc/options/options-definition.php';
require get_template_directory() . '/inc/options/options.php';
require get_template_directory() . '/inc/metabox-options.php';
require_once(WAN_DIR .'/inc/plugins/plugins.php');
require_once(WAN_DIR .'inc/options/controls/social_icons.php');
require_once(WAN_DIR .'inc/options/controls/dropdown-sidebars.php');
require_once(WAN_DIR .'inc/options/controls/box-control.php');
require_once(WAN_DIR .'inc/options/controls/overlaypicker.php');
require_once(WAN_DIR .'inc/options/controls/sidebars.php');
require_once(WAN_DIR .'inc/options/controls/typography.php');
require_once(WAN_DIR .'inc/options/controls/radio-images.php');
require_once(WAN_DIR .'inc/options/controls/multi-select.php');
require_once(WAN_DIR .'inc/widgets/login.php');
require_once(WAN_DIR .'inc/widgets/wan_minicart.php');
function wan_enqueue_bootstrap() {
	global $pagenow;
	if ($pagenow =='edit.php' ||  $pagenow == 'post.php' || $pagenow == 'post-new.php'){
		wp_enqueue_style( 'wan-3rd', esc_url_raw(WAN_LINK . 'css/admin/base.css') );
		wp_enqueue_script( 
            'jquery-boostrap',            //Give the script an ID
            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js',//Point to file
            array( 'jquery','customize-preview' ),    //Define dependencies
            '',                       //Define a version (optional) 
            true                      //Put script in footer?
		);
		wp_enqueue_script( 'wan-html5lightbox', get_template_directory_uri() . '/js/html5lightbox.js', array(), '20151215', true );
		wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/js/slick.min.js', array(), '1.5.7', true );
		wp_enqueue_script( 'jquery-moment', get_template_directory_uri() . '/js/moment.js', array(), '1.5.7', true );
		wp_enqueue_script( 'jquery-moment-data', get_template_directory_uri() . '/js/moment-timezone-with-data.js', array(), '1.5.7', true );
		wp_enqueue_script( 'wan-pkg', get_template_directory_uri() . '/js/wan-pkg.js', array('jquery','jquery-slick'),'20151215' , true );
		wp_enqueue_script( 'jquery-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array(), '1.5.7', true );
		wp_enqueue_script( 
            'jquery-fontpicker',            //Give the script an ID
			WAN_LINK.'js/fontawesome-iconpicker.js',//Point to file
			[],
            '',                       //Define a version (optional) 
            true                      //Put script in footer?
		);
	}
}
add_action( 'admin_enqueue_scripts', 'wan_enqueue_bootstrap', 9 );
function wan_register_general() {
	wp_register_style( 'wan-inline', esc_url_raw(WAN_LINK . 'css/inline-css.css') );
}
add_filter( 'upload_mimes', 'wan_myme_types', 1, 1 );
function wan_myme_types( $mime_types ) {
  $mime_types['ttf'] = 'application/x-font-ttf';     // Adding .ttf extension
  
  
  return $mime_types;
}
add_action( 'init', 'wan_register_general');
function wan_add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
	}
add_action('upload_mimes', 'wan_add_file_types_to_uploads');
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

