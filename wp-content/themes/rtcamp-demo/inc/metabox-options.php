<?php
add_action( 'admin_init', 'wan_page_options_init' );

function wan_page_options_init() {   

    new wan_meta_boxes(array(
    	// Portfolio
    	'id'	 => 'portfolio-options',
		'label'  => esc_html__( 'Settings', 'wan' ),
		'post_types'  => 'portfolios',
	    'context'     => 'normal',
        'priority'    => 'default',
		'sections' => array(
            'general'   => array( 'title' => esc_html__( 'General', 'wan' ) ),
			),
		'options' => wan_portfolio_options_fields()
	));	

    new wan_meta_boxes(array(
        // Portfolio Thumbnails
        'id'     => 'portfolio-thumbnail-options',
        'label'  => esc_html__( 'Gallery', 'wan' ),
        'post_types'  => 'portfolios',
        'context'     => 'side',
        'priority'    => 'default',
        'sections' => array(
            'general'   => array( 'title' => esc_html__( 'Gallery', 'wan' ) ),
            ),
        'options' => wan_portfolio_options_thumbnail_fields()
    )); 

	new wan_meta_boxes(array( 
        'id'          => 'page-options',
        'label'       => esc_html__( 'Page Options', 'wan' ),
        'post_types'  => 'page',
        'context'     => 'side',
        'priority'    => 'default',       

        'sections' => array(
            'general'   => array( 'title' => esc_html__( 'General', 'wan' ) ),
            'header'    => array( 'title' => esc_html__( 'Header', 'wan' ) ),
            'footer'    => array( 'title' => esc_html__( 'Footer', 'wan' ) ),
            'portfolio' => array( 'title' => esc_html__( 'Portfolio', 'wan' ) ),
            'blog'      => array( 'title' => esc_html__( 'Blog', 'wan' ) )
        ),

        'options' => wan_page_options_fields()
    ) );
	/*
	 Leave here for customer could add & use
    new wan_meta_boxes(array(
		// event
		'id' 	=> 'blog-options',
		'label'	=> esc_html__( 'Post settings', 'wan' ),
		'post_types'	=> array('post','faq'),
		'context'     => 'side',
        'priority'    => 'default',
		'sections' => array(
            'blog'   => array( 'title' => esc_html__( 'Blog', 'wan' ) ),
			),
		'options' => wan_post_options_fields()
	));
	*/
    new wan_meta_boxes(array(
        // event
        'id'    => 'testimonial-options',
        'label' => esc_html__( 'Testimonial Details', 'wan' ),
        'post_types'    => 'testimonial',
        'context'     => 'side',
        'priority'    => 'default',
        'sections' => array(
            'testimonial_details'   => array( 'title' => esc_html__( 'Testimonial Details', 'wan' ) ),
            ),
        'options' => wan_testimonial_options_fields()
    ));
}
global $pagenow;


/**
 * Enqueue script for handling actions with meta boxes
 *
 * @return void
 * @since 1.0
 */
