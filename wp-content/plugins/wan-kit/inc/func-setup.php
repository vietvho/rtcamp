<?php

/**
 * Prevent direct access to this file
 */

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}
// if (!function_exists('wan_customize_default_options2')) {
//     return;
// }
add_action( 'wp_enqueue_scripts', 'wan_portfolio_scripts' );
/**
  * Load the scripts
*/
function wan_portfolio_scripts() {  
    wp_register_script( 'wan-isotope', plugin_dir_url( __FILE__ ) . '/3rd/jquery.isotope.min.js', array('wan-imagesloaded'), true );
    wp_register_script( 'wan-imagesloaded', plugin_dir_url( __FILE__ ) . '/lib/js/imagesloaded.min.js', array('jquery'), true );    
}

function wan_register_blocks() {
    wp_enqueue_script(
        'wan-gutenberg-imagebox',
        WAN_KIT_URL.'blocks/wan-imagebox/block.build.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor','wp-html-entities' ),
        filemtime( WAN_KIT_PATH.'blocks/wan-imagebox/block.build.js' )
    );
}
add_action('enqueue_block_editor_assets', 'wan_register_blocks');

/**
  * Register Portfolio post type
*/
function register_portfolio_post_type() {
    $menu = esc_html__('Gallery','wan');
    $menu =apply_filters('mw/portfolio/name',$menu);
    //~ $menu = wan_portfolio_name();
    $labels = array(
        'name'                  => $menu,
        'singular_name'         => $menu,
        'rewrite'               => array( 'slug' =>'portfolio'),
        'menu_name'             => $menu,
        'add_new'               => esc_html__( 'New ','wan').$menu,
        'add_new_item'          => esc_html__( 'Add New ', 'wan' ).$menu,
        'new_item'              => esc_html__( 'New ','wan').$menu.esc_html__(' Item', 'wan' ),
        'edit_item'             => esc_html__( 'Edit ','wan').$menu.esc_html__(' Item', 'wan' ),
        'view_item'             => esc_html__( 'View ', 'wan' ).$menu,
        'all_items'             => esc_html__( 'All ', 'wan' ).$menu,
        'search_items'          => esc_html__( 'Search ', 'wan' ).$menu,
        'not_found'             => esc_html__( 'No ','wan').$menu.esc_html__(' Items Found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No ','wan').$menu.esc_html__(' Items Found In Trash', 'wan' ),
        'parent_item_colon'     => esc_html__( 'Parent ', 'wan' ) .$menu,
        'not_found'             => esc_html__( 'No ','wan').$menu.esc_html__(' found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No ','wan').$menu.esc_html__(' found in Trash', 'wan' )

    );
    $args = array(
        'labels'      => $labels,
        'supports'    => array( 'title', 'editor','thumbnail' ),
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-format-gallery',
        'show_in_rest'       => true,
    );
    register_post_type( 'portfolio', $args );

     
        $labels = array(
        'name'                  => esc_html__( 'FAQ', 'wan' ),
        'singular_name'         => esc_html__( 'FAQ', 'wan' ),
        'rewrite'               => array( 'slug' =>'faq' ),
        'menu_name'             => esc_html__( 'FAQ', 'wan' ),
        'add_new'               => esc_html__( 'New FAQ', 'wan' ),
        'add_new_item'          => esc_html__( 'Add New FAQ', 'wan' ),
        'new_item'              => esc_html__( 'New FAQ Item', 'wan' ),
        'edit_item'             => esc_html__( 'Edit FAQ Item', 'wan' ),
        'view_item'             => esc_html__( 'View FAQ', 'wan' ),
        'all_items'             => esc_html__( 'All FAQ', 'wan' ),
        'search_items'          => esc_html__( 'Search FAQ', 'wan' ),
        'not_found'             => esc_html__( 'No FAQ Items Found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No FAQ Items Found In Trash', 'wan' ),
        'parent_item_colon'     => esc_html__( 'Parent FAQ:', 'wan' ),
        'not_found'             => esc_html__( 'No FAQ found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No FAQ found in Trash', 'wan' )

    );
    $args = array(
        'labels'      => $labels,
        'supports'    => array( 'title', 'editor', 'thumbnail','post-formats' ),
        'public'      => true,
        'has_archive' => false,
        'menu_icon'   => 'dashicons-testimonial',

    );
    register_post_type( 'faq', $args );

    flush_rewrite_rules();
}



/**
  * Portfolio update messages.
*/
function portfolio_updated_messages ( $messages ) {
    Global $post, $post_ID;
    $messages['portfolio'] = array(
        0  => '',
        1  => sprintf( esc_html__( 'Portfolio Updated. <a href="%s">View portfolio</a>', 'wan' ), esc_url( get_permalink( $post_ID ) ) ),
        2  => esc_html__( 'Custom Field Updated.', 'wan' ),
        3  => esc_html__( 'Custom Field Deleted.', 'wan' ),
        4  => esc_html__( 'Portfolio Updated.', 'wan' ),
        5  => isset( $_GET['revision']) ? sprintf( esc_html__( 'Portfolio Restored To Revision From %s', 'wan' ), wp_post_revision_title((int)$_GET['revision'], false)) : false,
        6  => sprintf( esc_html__( 'Portfolio Published. <a href="%s">View Portfolio</a>', 'wan' ), esc_url( get_permalink( $post_ID ) ) ),
        7  => esc_html__( 'Portfolio Saved.', 'wan' ),
        8  => sprintf( esc_html__('Portfolio Submitted. <a target="_blank" href="%s">Preview Portfolio</a>', 'wan' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
        9  => sprintf( esc_html__( 'Portfolio Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Portfolio</a>', 'wan' ),date_i18n( esc_html__( 'M j, Y @ G:i', 'wan' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
        10 => sprintf( esc_html__( 'Portfolio Draft Updated. <a target="_blank" href="%s">Preview Portfolio</a>', 'wan' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    );
    return $messages;
}

add_action( 'init', 'register_portfolio_taxonomy' );
add_action( 'init', 'register_portfolio_post_type' );

/**
  * Register portfolio taxonomy
*/
function register_portfolio_taxonomy() {
    $labels = array(
        'name'                       => esc_html__( 'Categories', 'wan' ),
        'singular_name'              => esc_html__( 'Categories', 'wan' ),
        'search_items'               => esc_html__( 'Search Categories', 'wan' ),
        'menu_name'                  => esc_html__( 'Categories', 'wan' ),
        'all_items'                  => esc_html__( 'All Categories', 'wan' ),
        'parent_item'                => esc_html__( 'Parent Categories', 'wan' ),
        'parent_item_colon'          => esc_html__( 'Parent Categories:', 'wan' ),
        'new_item_name'              => esc_html__( 'New Categories Name', 'wan' ),
        'add_new_item'               => esc_html__( 'Add New Categories', 'wan' ),
        'edit_item'                  => esc_html__( 'Edit Categories', 'wan' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'wan' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used Categories', 'wan' ),
        'not_found'                  => esc_html__( 'No Categories found.','wan' ),
        'menu_name'                  => esc_html__( 'Categories','wan' ),
    );
    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'portfolio_category', 'portfolio', $args );
        $labels = array(
        'name'                       => esc_html__( 'Categories', 'wan' ),
        'singular_name'              => esc_html__( 'Categories', 'wan' ),
        'search_items'               => esc_html__( 'Search Categories', 'wan' ),
        'menu_name'                  => esc_html__( 'Categories', 'wan' ),
        'all_items'                  => esc_html__( 'All Categories', 'wan' ),
        'parent_item'                => esc_html__( 'Parent Categories', 'wan' ),
        'parent_item_colon'          => esc_html__( 'Parent Categories:', 'wan' ),
        'new_item_name'              => esc_html__( 'New Categories Name', 'wan' ),
        'add_new_item'               => esc_html__( 'Add New Categories', 'wan' ),
        'edit_item'                  => esc_html__( 'Edit Categories', 'wan' ),
        'update_item'                => esc_html__( 'Update Categories', 'wan' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'wan' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used Categories', 'wan' ),
        'not_found'                  => esc_html__( 'No Categories found.' ),
        'menu_name'                  => esc_html__( 'Categories' ),
    );
    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'faq_category', 'faq', $args );
    flush_rewrite_rules();
    
       $labels = array(
        'name'                  => esc_html__( 'Testimonial', 'wan' ),
        'singular_name'         => esc_html__( 'Testimonial', 'wan' ),
        'rewrite'               => array( 'slug' => esc_html__( 'testimonial' ) ),
        'menu_name'             => esc_html__( 'Testimonial', 'wan' ),
        'show_in_nav_menus' => false,  
        'show_in_menu' => false,
        'show_in_admin_bar' => false,
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
        'add_new'               => esc_html__( 'New Testimonial', 'wan' ),
        'add_new_item'          => esc_html__( 'Add New Testimonial', 'wan' ),
        'new_item'              => esc_html__( 'New Testimonial Item', 'wan' ),
        'edit_item'             => esc_html__( 'Edit Testimonial Item', 'wan' ),
        'view_item'             => esc_html__( 'View Testimonial', 'wan' ),
        'all_items'             => esc_html__( 'All Testimonial', 'wan' ),
        'search_items'          => esc_html__( 'Search Testimonial', 'wan' ),
        'not_found'             => esc_html__( 'No Testimonial Items Found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No Testimonial Items Found In Trash', 'wan' ),
        'parent_item_colon'     => esc_html__( 'Parent Testimonial:', 'wan' ),
        'not_found'             => esc_html__( 'No Testimonial found', 'wan' ),
        'not_found_in_trash'    => esc_html__( 'No Testimonial found in Trash', 'wan' )

    );
    $args = array(
        'labels'      => $labels,
        'supports'    => array( 'title', 'editor', 'thumbnail' ),
        'public'      => true,
        'has_archive' => false,
        'menu_icon'   => 'dashicons-format-quote
',
    );
    register_post_type( 'testimonial', $args );
}

add_action( 'init', 'register_portfolio_tag' );

/**
 * Register tag taxonomy
 */
function register_portfolio_tag() {
    $labels = array(
        'name'                       => esc_html__( 'Tags', 'wan' ),
        'singular_name'              => esc_html__( 'Tags', 'wan' ),
        'search_items'               => esc_html__( 'Search Tags', 'wan' ),        
        'all_items'                  => esc_html__( 'All Tags', 'wan' ),
        'new_item_name'              => esc_html__( 'Add New Tag', 'wan' ),
        'add_new_item'               => esc_html__( 'New Tag Name', 'wan' ),
        'edit_item'                  => esc_html__( 'Edit Tag', 'wan' ),
        'update_item'                => esc_html__( 'Update Tag', 'wan' ),
        'menu_name'                  => esc_html__( 'Tags' ),
    );
    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'portfolio_tag', 'portfolio', $args );
    flush_rewrite_rules();
}

add_action( 'load-post.php',     'wan_post_format_support_filter' );
add_action( 'load-post-new.php', 'wan_post_format_support_filter' );
add_action( 'load-edit.php',     'wan_post_format_support_filter' );

function wan_post_format_support_filter() {

    $screen = get_current_screen();

    // Bail if not on the projects screen.
    if ( empty( $screen->post_type ) ||  $screen->post_type !== 'portfolio' )
        return;

    // Check if the current theme supports formats.
    if ( current_theme_supports( 'post-formats' ) ) {

        $formats = get_theme_support( 'post-formats' );

        // If we have formats, add theme support for only the allowed formats.
        if ( isset( $formats[0] ) ) {
            $new_formats = array_intersect( $formats[0], array('video','gallery','standard'));

            // Remove post formats support.
            remove_theme_support( 'post-formats' );

            // If the theme supports the allowed formats, add support for them.
            if ( $new_formats )
                add_theme_support( 'post-formats', $new_formats );
        }
    }
}
add_filter( 'register_post_type_args', 'wan_register_post_type_args', 10, 2 );
function wan_register_post_type_args( $args, $post_type ) {

    if ( 'portfolio' === $post_type ) {
        $args['rewrite']['slug'] = wan_get_opt('portfolio_slug');
    }

    return $args;
}
function wan_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'wan-blocks',
				'title' => __( 'WAN-RTCAMP', 'wan' ),
			),
		)
	);
}
add_filter( 'block_categories', 'wan_block_category', 10, 2);
