<?php
/**
 *Theme Customizer
 *
 * @package
  */
function wan_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_section( 'header_image' )->title = esc_html__('Backgound PageTitle', 'wan');
    $wp_customize->get_section( 'header_image' )->priority = '22';   
    $wp_customize->get_section( 'title_tagline' )->priority = '1';
    $wp_customize->get_section( 'title_tagline' )->title = esc_html__('Logo & Site Informations', 'wan');
    $wp_customize->get_section( 'title_tagline' )->panel = 'wan_header';
    
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    
    //Heading
    class wan_Info extends WP_Customize_Control {
        public $type = 'heading';
        public $label = '';
        public function render_content() {
        ?>
            <h3 class="wan-title-control"><?php echo esc_html($this->label) ; ?></h3>
        <?php
        }
    }   


    //Reset To Scheme
    class wan_reset2scheme extends WP_Customize_Control {
        public $type = 'reset2scheme';
        public $label = '';
        public function render_content() {
        echo '<a class="reset_meta" href="#" data-id="'.wan_get_opt('wan_skin').'" data-mode="customizer">'.esc_html__('Clear Your Custom And Apply To This Style','wan').'</a>';
        }
    }    

    $scheme = wan_get_opt('wan_skin');
 

    //Title
    class wan_Title_Info extends WP_Customize_Control {
        public $type = 'title';
        public $label = '';
        public function render_content() {
        ?>
            <h4><?php echo esc_html( $this->label ); ?></h4>
        <?php
        }
    }    

    //Desc
    class wan_Theme_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //Desc
    class wan_Desc_Info extends WP_Customize_Control {
        public $type = 'desc';
        public $label = '';
        public function render_content() {
        ?>
            <p class="wan-desc-control"><?php echo esc_html( $this->label ); ?></p>
        <?php
        }
    }       
      // Top bar
      $wp_customize->add_setting(
        'show_tagline',
          array(
              'sanitize_callback' => 'wan_sanitize_checkbox',
              'default' => wan_customize_default_options2('show_tagline'),     
          )   
      );
  
      $wp_customize->add_control(
          'show_tagline',
          array(
              'type' => 'checkbox',
              'label' => esc_html__('Display with Logo', 'wan'),
              'section' => 'title_tagline',
              'priority' => 11,
          )
      );      
    $wp_customize->remove_control('custom_logo');
     //Logo
     $wp_customize->add_setting(
        'logo_normal',
        array(
            'default' => wan_customize_default_options2('logo_normal',$scheme),
            'sanitize_callback' => 'esc_url_raw',
        )
    );    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'logo_normal',
            array(
               'label'          => esc_html__( 'Upload your logo ', 'wan' ),
               'description'    => esc_html__( 'The best size is 168x50px ( If you don\'t display logo please remove it your website display 
                Site Title default in General )', 'wan' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 20,
            )
        )
    );

    // Logo sticky
    $wp_customize->add_setting(
        'logo_sticky',
        array(
            'default'           => wan_customize_default_options2('logo_sticky',$scheme),
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'logo_sticky',
            array(
               'label'          => esc_html__( 'Upload your logo on Sticky Header', 'wan' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 20,
            )
        )
    );

    // Logo Size
    $wp_customize->add_control( new wan_Title_Info( $wp_customize, 'lowan-size', array(
        'label' => esc_html__('Logo Size', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 7
        ) )
    );  

    // Height
    $wp_customize->add_setting(
        'lowan_width',
        array(
            'default' => wan_customize_default_options2('lowan_width'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'lowan_width',
        array(
            'label' => esc_html__( 'Width (px)', 'wan' ),
            'section' => 'title_tagline',
            'type' => 'text',
            'priority' => 20
        )
    );  
     // Logo Position
     $wp_customize->add_setting(
        'lowan_pos',
        array(
            'default' => wan_customize_default_options2('lowan_pos'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'lowan_pos',
        array(
            'label' => esc_html__( 'Logo Position', 'wan' ),
            'section' => 'title_tagline',
            'type' => 'select',
            'choices'   => array(
                'left-header'     => esc_html__('Top Left','wan'), // add center-header, right-header next version
         
            ),
            'priority' => 20
        )
    );  
    // margin top
    $wp_customize->add_setting(
        'lowan_controls',
        array(
            'default' => '',
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control( new BoxControls($wp_customize,
        'lowan_controls',
        array(
            'label' => esc_html__( 'Logo Spacing (px)', 'wan' ),
            'section' => 'title_tagline',
            'type' => 'box-controls',
            'priority' => 20
        ))
    );  
    //___General___//
    $wp_customize->add_setting('wan_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );

    // Heading site infomation
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-stie-infomation', array(
        'label' => esc_html__('SITE INFORMATION', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc site infomaton
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_siteinfomation', array(
        'label' => esc_html__('This section have basic information of your site, just change it to match with you need.', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );  
     // Body Background
     $wp_customize->add_control( new wan_Info( $wp_customize, 'body-background-info', array(
        'label' => esc_html__('Body Background', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 15
        ) )
    );    
      //Body Background image
    $wp_customize->add_setting(
        'body_background_image',
        array(
            'default' => wan_customize_default_options2('body_background_image',$scheme),
            'sanitize_callback' => 'esc_url_raw',
        )
    );    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'body_background_image',
            array(
               'label'          => esc_html__( 'Upload Your Background Image ', 'wan' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 15,
            )
        )
    );


     // Body background color
    $wp_customize->add_setting(
        'body_background_color',
        array(
            'default'           => wan_customize_default_options2('body_background_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_background_color',
            array(
                'label'         => esc_html__('Body Backgound Color', 'wan'),
                'section'       => 'title_tagline',
                'settings'      => 'body_background_color',
                'priority'      => 15
            )
        )
    );

  //  =============================
    //  // Socials              //
    //  =============================
    $wp_customize->add_section(
        'wan_socials',
        array(
            'title'         => esc_html__('Socials', 'wan'),
            'priority'      => 2,
            'sanitize_callback' => 'wan_sanitize_text',
        )
    ); 

      // social links
    $wp_customize->add_setting(
      'social_links',
      array(
        'sanitize_callback' => 'esc_attr',
        'default' => wan_customize_default_options2('social_links'),     
      )   
    );

    $wp_customize->add_control( new SocialIcons($wp_customize,
        'social_links',
        array(
            'type' => 'social-icons',
            'label' => esc_html__('Social', 'wan'),
            'section' => 'wan_socials',
            'priority' => 1,
        ))
    );      
    $wp_customize->add_setting (
        'socials_font_size',
        array(
            'default' => wan_customize_default_options2('socials_font_size'),
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control(
        'socials_font_size',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Socials Font Size', 'wan'),
            'section'   => 'wan_socials',
            'priority'  => 1
        )
    );    
     
    $wp_customize->add_setting (
        'socials_spacing',
        array(
            'default' => wan_customize_default_options2('socials_spacing'),
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control(
        'socials_spacing',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Socials spacing', 'wan'),
            'section'   => 'wan_socials',
            'priority'  => 1
        )
    );    
    //___ Global settings ____//
    $wp_customize->add_section(
        'global_panel',
        array(
            'title'         => esc_html__('Button', 'wan'),
            'priority'      => 1,
            'panel'=> 'global_panel',
            'sanitize_callback' => 'wan_sanitize_text',
        )
    ); 
    $wp_customize->add_setting(
        'button_transform',
        array(
            'default'           => wan_customize_default_options2('button_transform'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'button_transform',
        array (
            'type'      => 'radio',           
            'section'   => 'global_panel',
            'priority'  => 1,
            'label'         => esc_html__('Button Text Transform', 'wan'),
            'choices'   => array (
                'capitalize' => esc_html__( 'Capitalize','wan' ),
                'uppercase'=>  esc_html__( 'UPPERCASE','wan' ),
                ) ,
        )
    );
    $wp_customize->add_setting(
        'default_button_size',
        array(
            'default'           => wan_customize_default_options2('default_button_size'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'button_transform',
        array (
            'type'      => 'radio',           
            'section'   => 'global_panel',
            'priority'  => 1,
            'label'         => esc_html__('Button Text Transform', 'wan'),
            'choices'   => array (
                'capitalize' => esc_html__( 'Capitalize','wan' ),
                'uppercase'=>  esc_html__( 'UPPERCASE','wan' ),
                ) ,
        )
    );
    $wp_customize->add_setting(
        'slide_arrows',
        array(
            'default'           => wan_customize_default_options2('slide_arrows'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'slide_arrows',
        array (
            'type'      => 'radio',           
            'section'   => 'global_panel',
            'priority'  => 1,
            'label'         => esc_html__('Arrows Style', 'wan'),
            'choices'   => array (
                'circle' => esc_html__( 'Circle','wan' ),
                'simple'=>  esc_html__( 'Simple','wan' ),
                'square'=>  esc_html__( 'Square','wan' ),
                ) ,
        )
    );
     $wp_customize->add_setting(
        'slide_bullets',
        array(
            'default'           => wan_customize_default_options2('slide_bullets'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'slide_bullets',
        array (
            'type'      => 'radio',           
            'section'   => 'global_panel',
            'priority'  => 1,
            'label'         => esc_html__('Bullets Style', 'wan'),
            'choices'   => array (
                'circle' => esc_html__( 'Circle','wan' ),
                'simple'=>  esc_html__( 'Simple','wan' ),
                'square'=>  esc_html__( 'Square','wan' ),
                'dashes'=>  esc_html__( 'Dashes','wan' ),
                'dashes-spaced'=>  esc_html__( 'Dashes( Spaced)','wan' ),
                ) ,
        )
    );
    //___Header___//
    $wp_customize->add_section(
        'wan_header',
        array(
            'title'         => esc_html__('Header Style', 'wan'),
            'panel'=> 'wan_header',
            'priority'      => 2,
        )
    );
     // Heading site infomation
    $wp_customize->add_control( new wan_Info( $wp_customize, 'lowan-infomation', array(
        'label' => esc_html__('Logo Settings', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 19
        ) )
    );    
    
    $sidebars = ['topbar-center'=>__('Center Area Topbar Elements','wan'),'topbar-right'=>__('Right Area Topbar Elements','wan'),'header-right'=>__('Right Area Header Elements','wan'),'header-bottom'=>__('Bottom Area Header Elements','wan'),'hamburger-menu'=>__('Header Mobile Elements','wan')];

    foreach ($sidebars as $id=>$name):
        $section_args =[
            'title'=>$name,
            'description' => __('Elements for ','wan').$name,
            'priority'=> 3,
            'panel'=>'wan_header',
            'sidebar_id'=>$id,
        ];
        $section_id = sprintf( 'sidebar-widgets-%s', $id );
        $section = new WP_Customize_Sidebar_Section( $wp_customize, $section_id, $section_args );
        $wp_customize->add_section($section);
    endforeach;
      // Header general options
    $wp_customize->add_control( new wan_Info( $wp_customize, 'header-general-opt', array(
        'label' => esc_html__('General', 'wan'),
        'section' => 'wan_header',
        'settings' => 'wan_options[info]',
        'priority' => 11
        ) )
    );   
   
      // absolute
    $wp_customize->add_setting(
      'absolute_header',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('absolute_header'),     
        )   
    );

    $wp_customize->add_control(
        'absolute_header',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Absolute Header', 'wan'),
            'section' => 'wan_header',
            'priority' => 11,
        )
    );    
      // absolute
    $wp_customize->add_setting(
      'header_shadow',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('header_shadow'),     
        )   
    );

    $wp_customize->add_control(
        'header_shadow',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Header Shadow', 'wan'),
            'section' => 'wan_header',
            'priority' => 11,
        )
    );   
     // Top bar
       // Header general options
    $wp_customize->add_control( new wan_Info( $wp_customize, 'header-general', array(
        'label' => esc_html__('TopBar', 'wan'),
        'section' => 'wan_header',
        'settings' => 'wan_options[info]',
        'priority' => 11
        ) )
    );   
    $wp_customize->add_setting(
      'topbar_enabled',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('topbar_enabled'),     
        )   
    );

    $wp_customize->add_control(
        'topbar_enabled',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Show Topbar', 'wan'),
            'section' => 'wan_header',
            'priority' => 11,
        )
    );      
    $wp_customize->add_setting(
        'show_topbar_on_sticky',
          array(
              'sanitize_callback' => 'wan_sanitize_checkbox',
              'default' => wan_customize_default_options2('show_topbar_on_sticky'),     
          )   
      );
  
      $wp_customize->add_control(
          'show_topbar_on_sticky',
          array(
              'type' => 'checkbox',
              'label' => esc_html__('Show on Header Sticky', 'wan'),
              'section' => 'wan_header',
              'priority' => 11,
          )
      );  
    // Tobar Container
    $wp_customize->add_setting(
        'topbar_container',
        array(
            'default'           => wan_customize_default_options2('topbar_container'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'topbar_container',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header',
            'priority'  => 11,
            'label'         => esc_html__('Topbar container', 'wan'),
            'choices'   => array(
                'fluid'         =>  esc_html__('Full Width','wan'),
                'wan-container'         =>  esc_html__('Container','wan'),
            ),
        )
    );

    $wp_customize->add_setting (
        'topbar_height',
        array(
            'default' => wan_customize_default_options2('topbar_height'),
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control(
        'topbar_height',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Topbar Height', 'wan'),
            'section'   => 'wan_header',
            'priority'  => 11
        )
    );  
 
      // Bottom bar
       // Header general options
       $wp_customize->add_control( new wan_Info( $wp_customize, 'header-general', array(
        'label' => esc_html__('Bottom Header', 'wan'),
        'section' => 'wan_header',
        'settings' => 'wan_options[info]',
        'priority' => 11
        ) )
    );   
    $wp_customize->add_setting(
      'bottom_enabled',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('bottom_enabled'),     
        )   
    );

    $wp_customize->add_control(
        'bottom_enabled',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Show Bottom', 'wan'),
            'section' => 'wan_header',
            'priority' => 11,
        )
    );      
   
    // Tobar Container
    $wp_customize->add_setting(
        'btheader_container',
        array(
            'default'           => wan_customize_default_options2('btheader_container'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'btheader_container',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header',
            'priority'  => 11,
            'label'         => esc_html__('Bottom Header container', 'wan'),
            'choices'   => array(
                'fluid'         =>  esc_html__('Full Width','wan'),
                'wan-container'         =>  esc_html__('Container','wan'),
            ),
        )
    );

    // $wp_customize->add_setting (
    //     'topbar_height',
    //     array(
    //         'default' => wan_customize_default_options2('topbar_height'),
    //         'sanitize_callback' => 'esc_attr'
    //     )
    // );

    // $wp_customize->add_control(
    //     'topbar_height',
    //     array(
    //         'type'      => 'text',
    //         'label'     => esc_html__('Topbar Height', 'wan'),
    //         'section'   => 'wan_header',
    //         'priority'  => 11
    //     )
    // );  
 
    
     //Breadcrumb//
     $wp_customize->add_section(
        'wan_breadcrumb',
        array(
            'title'         => __('Breadcrumb','wan'),
            'priority'      => 2,
        )
    );

    // Breadcrumb
    $wp_customize->add_setting(
      'breadcrumb_enabled',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_choose_opt('breadcrumb_enabled'),     
        )   
    );

    $wp_customize->add_control( 
        'breadcrumb_enabled',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Enable Breadcrumb', 'wan'),
            'section' => 'wan_breadcrumb',
            'priority' => 15,
        )
    );    

    $wp_customize->add_setting (
        'breadcrumb_prefix',
        array(
            'default' => wan_choose_opt('breadcrumb_prefix'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'breadcrumb_prefix',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Breadcrumb Prefix', 'wan'),
            'section'   => 'wan_breadcrumb',
            'priority'  => 15
        )
    );  

    $wp_customize->add_setting (
        'breadcrumb_separator',
        array(
            'default' => wan_customize_default_options2('breadcrumb_separator'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'breadcrumb_separator',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Breadcrumb Separator', 'wan'),
            'section'   => 'wan_breadcrumb',
            'priority'  => 15
        )
    );  

    //___mobile___//
    $wp_customize->add_section(
    'wan_header_mobile',
        array(
            'title'         => esc_html__('Mobile Options', 'wan'),
            'panel'=> 'wan_header',
            'priority'      => 2,
        )
    );
    // mnu btn
    $wp_customize->add_setting(
    'menu_hide_on',
    array(
        'default'           => wan_customize_default_options2('menu_hide_on'),
        'sanitize_callback' => 'esc_attr',
    )
    );
    $wp_customize->add_control( 
        'menu_hide_on',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header_mobile',
            'priority'  => 1,
            'label'         => esc_html__('Mobile Button Hide on Great than or Equal Screen:', 'wan'),
            'choices'   => wan_arr_responsive_utilities('up')
        )
    );
    // scheme
    $wp_customize->add_setting(
        'mobile_btn_scheme',
        array(
            'default'           => wan_customize_default_options2('mobile_btn_scheme'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'mobile_btn_scheme',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header_mobile',
            'priority'  => 1,
            'label'         => esc_html__('Mobile Button Scheme ', 'wan'),
            'choices'   => wan_btn_scheme()
        )
    );
     // style
     $wp_customize->add_setting(
        'mobile_btn_style',
        array(
            'default'           => wan_customize_default_options2('mobile_btn_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'mobile_btn_style',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header_mobile',
            'priority'  => 1,
            'label'         => esc_html__('Mobile Button Style ', 'wan'),
            'choices'   => [
                'border-0'=>__('No Border','wan'),
                'square'=>__('Square','wan'),
                'square-outline'=>__('Square Outline','wan'),
                'rounded-circle'=>__('Circle','wan'),
                'circle-outline'=>__('Circle Outline','wan'),
            ]
        )
    );
    // mnu btn
    $wp_customize->add_setting(
        'hamburger_position',
        array(
            'default'           => wan_customize_default_options2('hamburger_position'),
            'sanitize_callback' => 'esc_attr',
        )
        );
        $wp_customize->add_control( 
            'hamburger_position',
            array(
                'type'      => 'select',           
                'section'   => 'wan_header_mobile',
                'priority'  => 1,
                'label'         => esc_html__('Hamburger Panel Position', 'wan'),
                'choices'   => [
                    'menu-left' => __('on Left','wan'),
                    'menu-right' => __('on Right','wan'),
                ]
            )
        );
     // Heading site infomation
    $wp_customize->add_control( new wan_Info( $wp_customize, 'lowan-infomation', array(
        'label' => esc_html__('Logo Settings', 'wan'),
        'section' => 'title_tagline',
        'settings' => 'wan_options[info]',
        'priority' => 19
        ) )
    );    

    
  
    // Header page title
    $wp_customize->add_setting(
        'show_page_title',
          array(
              'sanitize_callback' => 'wan_sanitize_checkbox',
              'default' => wan_customize_default_options2('show_page_title'),     
          )   
      );
  
      $wp_customize->add_control(
          'show_page_title',
          array(
              'type' => 'checkbox',
              'label' => esc_html__('Show page title', 'wan'),
              'section' => 'wan_pagetitle',
              'priority' => 15,
          )
      );    
     // Header page tilte options
    $wp_customize->add_control( new wan_Info( $wp_customize, 'header-page-title', array(
        'label' => esc_html__('PAGE TITLE', 'wan'),
        'section' => 'wan_pagetitle',
        'settings' => 'wan_options[info]',
        'priority' => 15
        ) )
    );

    // Page Title background color
    $wp_customize->add_setting(
        'page_title_overlay_color',
        array(
            'default' => wan_customize_default_options2('page_title_overlay_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'page_title_overlay_color',
            array(
                'label'         => esc_html__('Page Title Backgound/Overlay Color', 'wan'),
                'section'       => 'wan_pagetitle',
                'settings'      => 'page_title_overlay_color',
                'priority'      => 15
            )
        )
    );


    $wp_customize->add_setting(
        'page_title_height',
        array(
            'default' => wan_customize_default_options2('page_title_height'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );   

     $wp_customize->add_control(
        'page_title_height',
        array(
            'label' => esc_html__( 'Page title Height (px)', 'wan' ),
            'section' => 'wan_pagetitle',
            'type' => 'text',
            'priority' => 15
        )
    ); 

    // Pagination
    $wp_customize->add_setting(
        'page_title_position',
        array(
            'default'           => wan_customize_default_options2('page_title_position'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'page_title_position',
        array(
            'type'      => 'select',           
            'section'   => 'wan_pagetitle',
            'priority'  => 15,
            'label'         => esc_html__('Page Title Position', 'wan'),
            'choices'   => array(
                'top-left'     => esc_html__('Top Left','wan'),
                'top-right'         =>  esc_html__('Top Right','wan'),
                'center'         =>  esc_html__('Center','wan'),
                'bottom-left' =>  esc_html__( 'Bottom Left', 'wan' ),
                'bottom-right' =>  esc_html__( 'Bottom Right', 'wan' )
            ),
        )
    );

     // page title position
    $wp_customize->add_setting(
        'page_title_controls',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new BoxControls($wp_customize,
        'page_title_controls',
        array(
            'label' => esc_html__( 'Page title positions (px)', 'wan' ),
            'section' => 'wan_pagetitle',
            'type' => 'box-controls',
            'priority' => 15
        ))
    );  

     // page title style
    $wp_customize->add_setting(
        'page_title_container',
        array(
            'default'           => wan_customize_default_options2('page_title_container'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'page_title_container',
        array(
            'type'      => 'select',           
            'section'   => 'wan_pagetitle',
            'priority'  => 15,
            'label'         => esc_html__('Page Title Row Style', 'wan'),
            'choices'   => array(
                'strech_content'     => esc_html__('Strech Row and Content','wan'),
                'strech_row'         =>  esc_html__('Strech Row','wan'),
                'container'         =>  esc_html__('Container','wan'),
            ),
        )
    );

    // Heading Top Bar 
    $wp_customize->add_control( new wan_Info( $wp_customize, 'top-bar', array(
        'label' => esc_html__('Header Middle Area', 'wan'),
        'section' => 'wan_header',
        'settings' => 'wan_options[info]',
        'priority' => 16
        ) )
    );   

     // Header style
    $wp_customize->add_setting(
        'header_container',
        array(
            'default'           => wan_customize_default_options2('header_container'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'header_container',
        array(
            'type'      => 'select',           
            'section'   => 'wan_header',
            'priority'  => 16,
            'label'         => esc_html__('Header container', 'wan'),
            'choices'   => array(
                'fluid'         =>  esc_html__('Full Width','wan'),
                'wan-container'         =>  esc_html__('Container','wan'),
            ),
        )
    );
    $wp_customize->add_setting(
        'header_middle_height',
        array(
            'default' => wan_customize_default_options2('header_middle_height'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );   

     $wp_customize->add_control(
        'header_middle_height',
        array(
            'label' => esc_html__( 'Header Middle Height', 'wan' ),
            'section' => 'wan_header',
            'type' => 'text',
            'priority' => 16
        )
    ); 

    
    $wp_customize->add_setting(
        'header_middle_text_style',
        array(
            'default'           => wan_customize_default_options2('header_middle_text_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'header_middle_text_style',
        array (
            'type'      => 'radio',           
            'section'   => 'wan_header',
            'priority'  => 16,
            'label'         => esc_html__('Text Style', 'wan'),
            'choices'   => array (
                'text-capitalize' => esc_html__( 'Capitalize','wan' ),
                'text-uppercase'=>  esc_html__( 'UPPERCASE','wan' ),
                ) ,
        )
    );
      // Enable page callout
      $wp_customize->add_setting ( 
        'header_middle_bold',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('header_middle_bold'),     
        )
    );

    $wp_customize->add_control(
        'header_middle_bold',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Font Bold', 'wan'),
            'section'   => 'wan_header',
            'priority'  => 16
        )
    );
    // sticky
    
    // Header Sticky
    $wp_customize->add_control( new wan_Info( $wp_customize, 'header-sticky', array(
        'label' => esc_html__('Header Sticky', 'wan'),
        'section' => 'wan_header',
        'settings' => 'wan_options[info]',
        'priority' => 17
        ) )
    );   

    $wp_customize->add_setting(
        'header_sticky',
        array(
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('header_sticky'),     
        )   
    );

    $wp_customize->add_control(
        'header_sticky',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Enable sticky header', 'wan'),
            'section' => 'wan_header',
            'priority' => 17,
        )
      );  
    $wp_customize->add_setting(
        'header_sticky_height',
        array(
            'default' => wan_customize_default_options2('header_sticky_height'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );   

     $wp_customize->add_control(
        'header_sticky_height',
        array(
            'label' => esc_html__( 'Header Sticky Height', 'wan' ),
            'section' => 'wan_header',
            'type' => 'text',
            'priority' => 17
        )
    ); 
     // Dropdown
    $wp_customize->add_section('dropdown_settings',array(
        'title'         => 'Dropdown Style',
        'priority'      => 2,
        'panel'         => 'wan_header',
    ));
    $wp_customize->add_control( new wan_Info( $wp_customize, 'dropdown-heading', array(
        'label' => esc_html__('Dropdown Style', 'wan'),
        'section' => 'dropdown_settings',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );   
    // Border color
    $wp_customize->add_setting(
        'dropdown_border_color',
        array(
            'default' => wan_customize_default_options2('dropdown_border_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'dropdown_border_color',
            array(
                'label'         => esc_html__('Dropdown Border Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_border_color',
                'priority'      => 1
            )
        )
    );
    // Background color
    $wp_customize->add_setting(
        'dropdown_background_color',
        array(
            'default' => wan_customize_default_options2('dropdown_background_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'dropdown_background_color',
            array(
                'label'         => esc_html__('Dropdown Backgound Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_background_color',
                'priority'      => 1
            )
        )
    );
    // Background color
    $wp_customize->add_setting(
        'dropdown_listitem_background_color',
        array(
            'default' => wan_customize_default_options2('dropdown_listitem_background_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'dropdown_listitem_background_color',
            array(
                'label'         => esc_html__('Dropdown List Item Backgound Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_listitem_background_color',
                'priority'      => 1
            )
        )
    );
    // Background color
    $wp_customize->add_setting(
        'dropdown_listitem_background_hover_color',
        array(
            'default' => wan_customize_default_options2('dropdown_listitem_background_hover_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'dropdown_listitem_background_hover_color',
            array(
                'label'         => esc_html__('Dropdown List Item Backgound Hover Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_listitem_background_hover_color',
                'priority'      => 1
            )
        )
    );
    // txt color
    $wp_customize->add_setting(
        'dropdown_text_color',
        array(
            'default' => wan_customize_default_options2('dropdown_text_color',$scheme),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'dropdown_text_color',
            array(
                'label'         => esc_html__('Dropdown Text Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_text_color',
                'priority'      => 1
            )
        )
    );
    // txt hover color
    $wp_customize->add_setting(
        'dropdown_text_hover_color',
        array(
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'dropdown_text_hover_color',
            array(
                'label'         => esc_html__('Dropdown Text Hover Color', 'wan'),
                'section'       => 'dropdown_settings',
                'settings'      => 'dropdown_text_hover_color',
                'priority'      => 1
            )
        )
    );

     $wp_customize->add_setting(
        'dropdown_text_style',
        array(
            'default'           => wan_customize_default_options2('dropdown_text_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'dropdown_text_style',
        array (
            'type'      => 'radio',           
            'section'   => 'dropdown_settings',
            'priority'  => 1,
            'label'         => esc_html__('Text Style', 'wan'),
            'choices'   => array (
                'capitalize' => esc_html__( 'Capitalize','wan' ),
                'uppercase'=>  esc_html__( 'UPPERCASE','wan' ),
                ) ,
        )
    );
    $wp_customize->add_setting(
        'dropdown_font_size',
        array(
            'default' => wan_customize_default_options2('dropdown_font_size'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );   

     $wp_customize->add_control(
        'dropdown_font_size',
        array(
            'label' => esc_html__( 'Dropdown FontSize', 'wan' ),
            'section' => 'dropdown_settings',
            'type' => 'text',
            'priority' => 1
        )
    ); 
    
    $wp_customize->add_setting(
        'dropdown_padding',
        array(
            'default' => wan_customize_default_options2('dropdown_padding'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );   

     $wp_customize->add_control(
        'dropdown_padding',
        array(
            'label' => esc_html__( 'Dropdown Padding (px)', 'wan' ),
            'section' => 'dropdown_settings',
            'type' => 'text',
            'priority' => 1
        )
    ); 
    // Enable page callout
    $wp_customize->add_setting ( 
        'dropdown_arrow',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('dropdown_arrow'),     
        )
    );

    $wp_customize->add_control(
        'dropdown_arrow',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Display Arrow on Top Dropdown Panel', 'wan'),
            'section'   => 'dropdown_settings',
            'priority'  => 1
        )
    );
    $wp_customize->add_setting(
        'dropdown_listitem_spacing',
        array(
            'default' => wan_customize_default_options2('dropdown_listitem_spacing'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control( new BoxControls($wp_customize,
        'dropdown_listitem_spacing',
        array(
            'label' => esc_html__( 'Dropdown List Item Spacing', 'wan' ),
            'section' => 'dropdown_settings',
            'type' => 'box-controls',
            'priority' => 1
        ))
    );  
     

   //___Footer___//
    $wp_customize->add_section(
        'wan_footer',
        array(
            'title'         => esc_html__('General Settings', 'wan'),
            'priority'      => 4,
        )
    );        

    $wp_customize->remove_control('display_header_text');
    $top_footers = wan_get_opt('top_footers_widgets');
    $top_footers = explode("\n", $top_footers);
    foreach ($top_footers as $id => $name):
        $_id = $id+1;
        $section_args =[
            'title'=>"Top Footer Elements ".$_id,
            'description' => __('Elements for top footer ','wan').$_id,
            'priority'=> 11,
            'panel'=>'wan_footer',
            'sidebar_id'=>'top-footer-'.$_id,
        ];
        $section_id = sprintf( 'sidebar-widgets-top-footer-%s', $_id );
        $section = new WP_Customize_Sidebar_Section( $wp_customize, $section_id, $section_args );
        $wp_customize->add_section($section);
    endforeach;
    $center_footers = wan_get_opt('center_footers_widgets');
    $center_footers = explode("\n", $center_footers);
    foreach ($center_footers as $id => $name):
        $_id = $id+1;
        $section_args =[
            'title'=>"Middle Footer Elements ".$_id,
            'description' => __('Elements for Middle footer ','wan').$_id,
            'priority'=> 11,
            'panel'=>'wan_footer',
            'sidebar_id'=>'center-footer-'.$_id,
        ];
        $section_id = sprintf( 'sidebar-widgets-center-footer-%s', $_id );
        $section = new WP_Customize_Sidebar_Section( $wp_customize, $section_id, $section_args );
        $wp_customize->add_section($section);
    endforeach;
    $bottom_footers = wan_get_opt('bottom_footers_widgets');
    $bottom_footers = explode("\n", $bottom_footers);
    foreach ($bottom_footers as $id => $name):
        $_id = $id+1;
        $section_args =[
            'title'=>"Bottom Footer Elements ".$_id,
            'description' => __('Elements for Bottom footer ','wan').$_id,
            'priority'=> 11,
            'panel'=>'wan_footer',
            'sidebar_id'=>'bottom-footer-'.$_id,
        ];
        $section_id = sprintf( 'sidebar-widgets-bottom-footer-%s', $_id );
        $section = new WP_Customize_Sidebar_Section( $wp_customize, $section_id, $section_args );
        $wp_customize->add_section($section);
    endforeach;
    
      // Gird columns Related Posts
    $wp_customize->add_setting(
        'top_footers_widgets',
        array(
            'default'           => wan_customize_default_options2('top_footers_widgets'),
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'top_footers_widgets',
        array(
            'type'      => 'textarea',
            'label'     => esc_html__('Top Footer Areas columns', 'wan'),
            'description' =>__("Columns and class for column. Each Row is 1 Column. <br>Example: 3 columns; each column has class col-md-4",'wan')."<div class='border p-1'>col-md-4<br>col-md-4<br>col-md-4</div>",
            'section'   => 'wan_footer',
            'priority'  => 11
        )
    );
   // Gird columns Related Posts
    $wp_customize->add_setting(
        'center_footers_widgets',
        array(
            'default'           => wan_customize_default_options2('center_footers_widgets'),
           'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'center_footers_widgets',
        array(
            'type'      => 'textarea',
            'label'     => esc_html__('Middle Footer Areas columns', 'wan'),
            'description' =>__("Columns and class for column. Each Row is 1 Column. <br>Example: 3 columns; each column has class col-md-4",'wan')."<div class='border p-1'>col-md-4<br>col-md-4<br>col-md-4</div>",
            'section'   => 'wan_footer',
            'priority'  => 11
        )
    );

    $wp_customize->add_setting(
        'bottom_footers_widgets',
        array(
            'default'           => wan_customize_default_options2('bottom_footers_widgets'),
             'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'bottom_footers_widgets',
        array(
            'type'      => 'textarea',
            'label'     => esc_html__('Bottom Footer Areas columns', 'wan'),
            'description' =>__("Columns and class for column. Each Row is 1 Column. <br>Example: 3 columns; each column has class col-md-4",'wan')."<div class='border p-1'>col-md-4<br>col-md-4<br>col-md-4</div>",
            'section'   => 'wan_footer',
            'priority'  => 11
        )
    );
 

    // Footer title
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-footer-content', array(
        'label' => esc_html__('Footer Style', 'wan'),
        'section' => 'wan_footer',
        'settings' => 'wan_options[info]',
        'priority' => 10
        ) )
    );    

    // Desc
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_footer', array(
        'label' => esc_html__('You can change the copyright text, show/hide the social icons on the footer.', 'wan'),
        'section' => 'wan_footer',
        'settings' => 'wan_options[info]',
        'priority' => 15
        ) )
    );   

    $wp_customize->add_setting(
        'footer_controls',
        array(
            'default' => '',
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control( new BoxControls($wp_customize,
        'footer_controls',
        array(
            'label' => esc_html__( 'Footer Spacing', 'wan' ),
            'section' => 'wan_footer',
            'type' => 'box-controls',
            'priority' => 16
        ))
    );  

    $wp_customize->add_setting(
        'footer_container',
        array(
            'default'           => wan_customize_default_options2('footer_container'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'footer_container',
        array (
            'type'      => 'select',           
            'section'   => 'wan_footer',
            'priority'  => 3,
            'label'         => esc_html__('Footer container', 'wan'),
            'choices'   => array (
                'fullwidth' => esc_html__( 'Full Width','wan' ),
                'wan-container'=>  esc_html__( 'Container','wan' ),
                ) ,
        )
    );

   
    // Thumbnail Options
    // ADD SECTION GENERAL
    $wp_customize->add_section('thumbnail_section',array(
        'title'         => 'Thumbnails',
        'priority'      => 9,        
    ));

    $wp_customize->add_control( new wan_Info( $wp_customize, 'thumbnail_blog_des', array(
        'label' => esc_html__('Thumbnails', 'wan'),
        'section' => 'thumbnail_section',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    
     $wp_customize->add_setting (
        'thumbnails',
        array(
            'default'           => wan_choose_opt('thumbnails'),
             'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'thumbnails',
        array(
            'label' => esc_html__( 'Add custom thumbnails.', 'wan' ),
            'description' => esc_html__("name|width|height|crop",'wan'),
            'section' => 'thumbnail_section',
            'type' => 'textarea',
            'priority' => 1
        )
    );  
   
    //  =============================
    //  Global Panel              //
    //  ============================= 
    $wp_customize->add_panel('global_panel',array(
        'title'         => __('Global Settings','wan'),
        'priority'      => 10,
    ));
   
    //  =============================
    //  // Color              //
    //  ============================= 
    $wp_customize->add_panel('color_panel',array(
        'title'         => __('Color','wan'),
        'description'   => __('This is panel Description','wan'),
        'priority'      => 10,
    ));
    $wp_customize->add_panel('wan_header',array(
        'title'         => __('Header','wan'),
        'description'   => __('This is panel Description','wan'),
        'priority'      => 10,
    ));
     $wp_customize->add_panel('wan_footer',array(
        'title'         => __('Footer','wan'),
        'description'   => __('This is panel Description','wan'),
        'priority'      => 10,
    ));

    // ADD SECTION GENERAL
    $wp_customize->add_section('color_general',array(
        'title'         => 'General',
        'priority'      => 10,
        'panel'         => 'color_panel',
    ));

    // Heading Color Scheme
    $wp_customize->add_control( new wan_Info( $wp_customize, 'color_scheme', array(
        'label' => esc_html__('SCHEME COLOR', 'wan'),
        'section' => 'color_general',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc color scheme
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_color_schemer', array(
        'label' => esc_html__('Select the color that will be used for theme color.','wan'),
        'section' => 'color_general',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );   


    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => wan_customize_default_options2('primary_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => esc_html__('Primary color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'primary_color',
                'priority'      => 3
            )
        )
    );   

    $wp_customize->add_setting(
        'secondary_color',
        array(
            'default'           => wan_customize_default_options2('secondary_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'         => esc_html__('Secondary color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'secondary_color',
                'priority'      => 3
            )
        )
    ); 
    $wp_customize->add_setting(
        'success_color',
        array(
            'default'           => wan_customize_default_options2('success_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'success_color',
            array(
                'label'         => esc_html__('Succss color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'success_color',
                'priority'      => 3
            )
        )
    );   
    $wp_customize->add_setting(
        'alert_color',
        array(
            'default'           => wan_customize_default_options2('alert_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'alert_color',
            array(
                'label'         => esc_html__('Alert color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'alert_color',
                'priority'      => 3
            )
        )
    );    

    $wp_customize->add_setting(
        'link_color',
        array(
            'default'           => wan_customize_default_options2('link_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'         => esc_html__('Link color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'link_color',
                'priority'      => 3
            )
        )
    );  

    $wp_customize->add_setting(
        'link_hover_color',
        array(
            'default'           => wan_customize_default_options2('link_hover_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_hover_color',
            array(
                'label'         => esc_html__('Link Hover Color', 'wan'),
                'section'       => 'color_general',
                'settings'      => 'link_hover_color',
                'priority'      => 3
            )
        )
    );  

    // H tag Color
    $wp_customize->add_setting(
        'htag_color',
        array(
            'default'           => wan_customize_default_options2('htag_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'htag_color',
            array(
                'label' => esc_html__('H Tag Text Color', 'wan'),
                'section' => 'color_general',
                'priority' => 4
            )
        )
    ); 
 

    // Body Color
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => wan_customize_default_options2('body_text_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => esc_html__('Body Text Color', 'wan'),
                'section' => 'color_general',
                'priority' => 4
            )
        )
    ); 

    $wp_customize->add_setting(
        'body_secondary_text_color',
        array(
            'default'           => wan_customize_default_options2('body_secondary_text_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_secondary_text_color',
            array(
                'label' => esc_html__('Body Secondary Text Color', 'wan'),
                'section' => 'color_general',
                'priority' => 4
            )
        )
    ); 

     // ADD SECTION HEADER COLOR
    $wp_customize->add_section('color_header',array(
        'title'=>'Header',
        'priority'=>11,
        'panel'=>'color_panel',
    ));
      // TOPBAR COLOR
    $wp_customize->add_control( new wan_Info( $wp_customize, 'topbar_customizer', array(
        'label' => esc_html__('TOPBAR COLOR', 'wan'),
        'section' => 'color_header',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_topbar_customizer', array(
        'label' => esc_html__('Select color for background topbar,text topbar.','wan'),
        'section' => 'color_header',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );   

    // Topbar Background
    $wp_customize->add_setting(
        'topbar_background',
        array(
            'default'   => wan_customize_default_options2('topbar_background'),
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'topbar_background',
            array(
                'label' => esc_html__('TopBar Background Color', 'wan'),
                'section' => 'color_header',
                'priority' =>1
            )
        )
    );   

     // Topbar Text Color
    $wp_customize->add_setting(
        'topbar_text_color',
        array(
            'default'   => wan_customize_default_options2('topbar_text_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'topbar_text_color',
            array(
                'label' => esc_html__('Topbar Text Color', 'wan'),
                'section' => 'color_header',
                'priority' => 1
            )
        )
    );   
      // Topbar Text Hover Color
    $wp_customize->add_setting(
        'topbar_text_hover_color',
        array(
            'default'   => wan_customize_default_options2('topbar_text_hover_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'topbar_text_hover_color',
            array(
                'label' => esc_html__('Topbar Text Hover Color', 'wan'),
                'section' => 'color_header',
                'priority' => 1
            )
        )
    );   
      // HEADER COLOR
    $wp_customize->add_control( new wan_Info( $wp_customize, 'header_customizer', array(
        'label' => esc_html__('HEADER COLOR', 'wan'),
        'section' => 'color_header',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_header_customizer', array(
        'label' => esc_html__('Select color for background header,text header.','wan'),
        'section' => 'color_header',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );   

    // Header Background
    $wp_customize->add_setting(
        'header_background',
        array(
            'default'   => wan_customize_default_options2('header_background',$scheme),
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'header_background',
            array(
                'label' => esc_html__('Header Background Color', 'wan'),
                'section' => 'color_header',
                'priority' =>3
            )
        )
    );   

     // Header Text Color
    $wp_customize->add_setting(
        'header_middle_text_color',
        array(
            'default'   => wan_customize_default_options2('header_middle_text_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_middle_text_color',
            array(
                'label' => esc_html__('Header Text Color', 'wan'),
                'section' => 'color_header',
                'priority' => 3
            )
        )
    );   

     // Header Text Hover Color
    $wp_customize->add_setting(
        'header_middle_text_hover_color',
        array(
            'default'   => wan_customize_default_options2('header_middle_text_hover_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_middle_text_hover_color',
            array(
                'label' => esc_html__('Header Text Hover Color', 'wan'),
                'section' => 'color_header',
                'priority' => 3
            )
        )
    );   
    
   
   
       // BOTTOM COLOR
    $wp_customize->add_control( new wan_Info( $wp_customize, 'btheader_customizer', array(
        'label' => esc_html__('BOTTOM COLOR', 'wan'),
        'section' => 'color_header',
        'settings' => 'wma_options[info]',
        'priority' => 4
        ) )
    );    

    // Desc
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_btheader_customizer', array(
        'label' => esc_html__('Select color for background bottom,text bottom.','wan'),
        'section' => 'color_header',
        'settings' => 'wma_options[info]',
        'priority' => 4
        ) )
    );   

    // bottom Background
    $wp_customize->add_setting(
        'btheader_background',
        array(
            'default'   => wan_customize_default_options2('btheader_background',$scheme),
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new ColorOverlay(
            $wp_customize,
            'btheader_background',
            array(
                'label' => esc_html__('Bottom Background Color', 'wan'),
                'section' => 'color_header',
                'priority' =>4
            )
        )
    );   

     // bottom Text Color
    $wp_customize->add_setting(
        'btheader_text_color',
        array(
            'default'   => wan_customize_default_options2('btheader_text_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'btheader_text_color',
            array(
                'label' => esc_html__('Bottom Text Color', 'wan'),
                'section' => 'color_header',
                'priority' => 4
            )
        )
    );   
      // bottom Text Hover Color
    $wp_customize->add_setting(
        'btheader_text_hover_color',
        array(
            'default'   => wan_customize_default_options2('btheader_text_hover_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'btheader_text_hover_color',
            array(
                'label' => esc_html__('Bottom Text Hover Color', 'wan'),
                'section' => 'color_header',
                'priority' => 4
            )
        )
    );    
     

    // ADD SECTION COLOR FOOTER
    $wp_customize->add_section('color_footer',array(
        'title'=>'Footer',
        'priority'=>12,
        'panel'=>'color_panel',
    ));    

      // Footer top line color
    $wp_customize->add_setting(
        'footer_top_line_color',
        array(
            'default' => wan_customize_default_options2('footer_top_line_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_top_line_color',
            array(
                'label'         => esc_html__('Footer Border Color', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'footer_top_line_color',
                'priority'      => 12
            )
        )
    );

     // Footer background color
    $wp_customize->add_setting(
        'footer_background_color',
        array(
            'default' => wan_customize_default_options2('footer_background_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background_color',
            array(
                'label'         => esc_html__('Footer Backgound', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'footer_background_color',
                'priority'      => 12
            )
        )
    );

      // Footer widget color
    $wp_customize->add_setting(
        'footer_widget_color',
        array(
            'default'           => wan_customize_default_options2('footer_widget_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_widget_color',
            array(
                'label'         => esc_html__('Footer Widget Title Color', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'footer_widget_color',
                'priority'      => 13
            )
        )
    ); 

    // Footer text color
    $wp_customize->add_setting(
        'footer_txt_color',
        array(
            'default'           => wan_customize_default_options2('footer_txt_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_txt_color',
            array(
                'label'         => esc_html__('Footer Text Color', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'footer_txt_color',
                'priority'      => 13
            )
        )
    ); 

      // Footer text color hover
    $wp_customize->add_setting(
        'footer_text_color_hover',
        array(
            'default'           => wan_customize_default_options2('footer_text_color_hover',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_text_color_hover',
            array(
                'label'         => esc_html__('Footer Text Color Hover', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'footer_text_color_hover',
                'priority'      => 13
            )
        )
    ); 
     // Bottom background color
    $wp_customize->add_setting(
        'bottom_background_color',
        array(
            'default' => wan_customize_default_options2('bottom_background_color',$scheme),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'bottom_background_color',
            array(
                'label'         => esc_html__('Bottom Backgound', 'wan'),
                'section'       => 'color_footer',
                'settings'      => 'bottom_background_color',
                'priority'      => 13
            )
        )
    );
    //bottom color //
    $wp_customize->add_section('color_bottom',array(
        'title'=>'Bottom',
        'priority'=>12,
        'panel'=>'color_panel',
    ));    

   

   //___Footer___//
    $wp_customize->add_section(
        'wan_footer',
        array(
            'title'         => esc_html__('General Settings', 'wan'),
            'priority'      => 2,
            'panel'=>'wan_footer',

        )
    );        

    $wp_customize->remove_control('display_header_text');

   
    // Section Blog
    $wp_customize->add_section(
        'blog_options',
        array(
            'title' => esc_html__('Post', 'wan'),
            'priority' => 13,
        )
    );



    // Heading Blog
    $wp_customize->add_control( new wan_Info( $wp_customize, 'bloglist', array(
        'label' => esc_html__('Blog Layout', 'wan'),
        'section' => 'blog_options',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc blog
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_bloglist', array(
        'label' => esc_html__('All options in this section will be used to make style for blog page.','wan'),
        'section' => 'blog_options',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );   

    $wp_customize->add_setting(
        'blog_layout',
        array(
            'default'           => wan_customize_default_options2('blog_layout'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'blog_layout',
        array (
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 3,
            'label'         => esc_html__('List Sidebar Position', 'wan'),
            'choices'   => array (
                'sidebar-right' => esc_html__( 'Sidebar Right','wan' ),
                'sidebar-left'=>  esc_html__( 'Sidebar Left','wan' ),
                'no-sidebar' =>   esc_html__( 'No Sidebar','wan' )
                ) ,
        )
    );
    $wp_customize->add_setting (
        'blog_sidebar_list',
        array(
            'default'           => wan_customize_default_options2('blog_sidebar_list'),
            'sanitize_callback' => 'esc_html',
        )
    );

    $wp_customize->add_control( new DropdownSidebars($wp_customize,
        'blog_sidebar_list',
        array(
            'type'      => 'dropdown',           
            'section'   => 'blog_options',
            'priority'  => 3,
            'label'         => esc_html__('List Sidebar', 'wan'),
            
        ))
    );
   
 
     // blog Syle
    $wp_customize->add_setting(
        'blog_style',
        array(
            'default'           => wan_customize_default_options2('blog_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'blog_style',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 4,
            'label'         => esc_html__('Layout Style', 'wan'),
            'choices'   => array(
                'wan-grid'=>   esc_html__( 'Grid','wan' ),
                'wan-grid-tile'=>   esc_html__( 'Grid Tile','wan' ),
                'wan-list'=>   esc_html__( 'List','wan' ),
                'wan-masonry'=>   esc_html__( 'Masonry','wan' ),
                'wan-masonry-tile'=>   esc_html__( 'Masonry Tile','wan' ),
        ))
    );
    
     $wp_customize->add_setting (
        'blog_sidebar_list',
        array(
            'default'           => wan_customize_default_options2('blog_sidebar_list'),
            'sanitize_callback' => 'esc_html',
        )
    );
      // blog thumbnail
      $wp_customize->add_setting(
        'blog_thumbnail_size',
        array(
            'default'           => wan_customize_default_options2('blog_thumbnail_size'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'blog_thumbnail_size',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 4,
            'label'         => esc_html__('Image Size', 'wan'),
            'choices'   => wan_customizer_image_size_options()
        )
    );
    
    $wp_customize->add_setting(
        'blog_text_scales',
        array(
            'sanitize_callback' => 'absint',
            'default'           => wan_customize_default_options2('blog_text_scales'),
        )       
    );
    $wp_customize->add_control( 'blog_text_scales', array(
        'type'        => 'number',
        'priority'    => 4,
        'section'     => 'blog_options',
        'label'       => esc_html__('Blog Text Scales', 'wan'),
        'input_attrs' => array(
            'min'   => 50,
            'max'   => 200,
            'step'  => 1
        ),
    ) );

        // Gird columns Related Posts
    $wp_customize->add_setting(
        'blog_grid_columns',
        array(
            'default'           => wan_customize_default_options2('blog_grid_columns'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_grid_columns',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 4,
            'label'     => esc_html__('Post Columns', 'wan'),
            'choices'   => array(                
                1     => esc_html__( '1 Column', 'wan' ),
                2     => esc_html__( '2 Columns', 'wan' ),
                3     => esc_html__( '3 Columns', 'wan' ),
                4     => esc_html__( '4 Columns', 'wan' ),                
            )
        )
    );
    // columns spaces
    $wp_customize->add_setting (
        'blog_columns_spaces',
        array(
            'default' => wan_customize_default_options2('blog_columns_spaces'),
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control(
        'blog_columns_spaces',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Blog Column Spacing', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 4
        )
    );
    // Show Zoom Button
    $wp_customize->add_setting ( 
        'blog_archive_show_zoom_btn',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_zoom_btn'),     
        )
    );

    $wp_customize->add_control(
        'blog_archive_show_zoom_btn',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Zoom Button', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );

     // Show Category 
     $wp_customize->add_setting ( 
        'blog_archive_show_category',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_category'),     
        )
    );

    $wp_customize->add_control(
        'blog_archive_show_category',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Category', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );
      // Show title 
      $wp_customize->add_setting ( 
        'blog_archive_show_title',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_title'),     
        )
    );

    $wp_customize->add_control(
        'blog_archive_show_title',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Title', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );
    // Gird columns Related Posts
    $wp_customize->add_setting(
        'blog_archive_htag',
        array(
            'default'           => wan_customize_default_options2('blog_archive_htag'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_archive_htag',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 5,
            'label'     => esc_html__('H Tag', 'wan'),
            'choices'   => wan_htags_list()
        )
    );

    // Show date 
    $wp_customize->add_setting ( 
        'blog_archive_show_date',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_date'),     
        )
    );

    $wp_customize->add_control(
        'blog_archive_show_date',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Date', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );
    // Show metas 
    $wp_customize->add_setting ( 
        'blog_archive_show_metas',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_metas'),     
        )
    );
    $wp_customize->add_setting (
        'blog_archive_metas',
        array(
            'default'           => wan_customize_default_options2('blog_archive_metas'),
             'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'blog_archive_metas',
        array(
            'label' => esc_html__( 'Add custom blog_archive_metas.', 'wan' ),
            'description' => __("Accept Shortcode. <br> Some default theme shortcode: [post_date][post_comments][post_author][post_category][post_tags]<br>",'wan').esc_html__("Default Value:",'wan')."<br>".esc_html(wan_customize_default_options2('blog_archive_metas')),
            'section' => 'blog_options',
            'type' => 'textarea',
            'priority' => 5
        )
    ); 
    $wp_customize->add_control(
        'blog_archive_show_metas',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Metas', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );
     // Show content 
     $wp_customize->add_setting ( 
        'blog_archive_show_content',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox' ,
            'default' => wan_customize_default_options2('blog_archive_show_content'),     
        )
    );

    $wp_customize->add_control(
        'blog_archive_show_content',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Content', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );
    // Excerpt
    $wp_customize->add_setting(
        'blog_archive_post_excepts_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => wan_customize_default_options2('blog_archive_post_excepts_length'),
        )       
    );
    $wp_customize->add_control( 'blog_archive_post_excepts_length', array(
        'type'        => 'number',
        'priority'    => 5,
        'section'     => 'blog_options',
        'label'       => esc_html__('Post Excepts Length. Leave Empty for Hide Content', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 1
        ),
    ) );

    // Read More Text
    $wp_customize->add_setting (
        'blog_archive_readmore_text',
        array(
            'default' => wan_customize_default_options2('blog_archive_readmore_text'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'blog_archive_readmore_text',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Read More Text', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 5
        )
    );

    // Pagination
    $wp_customize->add_setting(
        'blog_archive_pagination_style',
        array(
            'default'           => wan_customize_default_options2('blog_archive_pagination_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'blog_archive_pagination_style',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 8,
            'label'         => esc_html__('Pagination Style', 'wan'),
            'choices'   => array(
                'pager'     => esc_html__('Pager','wan'),
                'pager-numeric'         =>  esc_html__('Pager & Numeric','wan'),
                'loadmore' =>  esc_html__( 'Load More', 'wan' )
            ),
        )
    );

    // Header Blog Single    
    $wp_customize->add_control( new wan_Info( $wp_customize, 'blogsingle', array(
        'label' => esc_html__('Blog Single', 'wan'),
        'section' => 'blog_options',
        'settings' => 'wan_options[info]',
        'priority' => 9
        ) )
    );    

    // Desc Blog Single
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_blogsingle', array(
        'label' => esc_html__('Also, you can change the style for blog single to make your site unique.','wan'),
        'section' => 'blog_options',
        'settings' => 'wan_options[info]',
        'priority' => 10
        ) )
    );   
   
    $wp_customize->add_setting(
        'single_thumbnail',
        array(
            'default'           => wan_customize_default_options2('single_thumbnail'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'single_thumbnail',
        array (
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 10,
            'label'         => esc_html__('Single Thumbnail', 'wan'),
            'choices'   => wan_customizer_image_size_options(),
        )
    );

    // Show Post Navigator
    $wp_customize->add_setting (
        'show_post_navigator',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('show_post_navigator'),     
        )
    );

    $wp_customize->add_control( 
        'show_post_navigator',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Post Navigator', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 12
        )
    );

    
    $wp_customize->remove_section('header_image');

    // Next Label
    $wp_customize->add_setting (
        'navigator_next_label',
        array(
            'default' => wan_customize_default_options2('navigator_next_label'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

     // Show Related Posts
    $wp_customize->add_setting (
        'show_related_post',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('show_related_post'),     
        )
    );

    $wp_customize->add_control( 
        'show_related_post',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Related Posts', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 15
        )
    );
         // Gird columns Related Posts
    $wp_customize->add_setting(
        'related_post_columns',
        array(
            'default'           => wan_customize_default_options2('related_post_columns'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'related_post_columns',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 18,
            'label'     => esc_html__('Related Columns', 'wan'),
            'choices'   => array(                
                1     => esc_html__( '1 Column', 'wan' ),
                2     => esc_html__( '2 Columns', 'wan' ),
                3     => esc_html__( '3 Columns', 'wan' ),
                4     => esc_html__( '4 Columns', 'wan' ),                
            )
        )
    );
    // Number Of Related Posts
    $wp_customize->add_setting (
        'number_related_post',
        array(
            'default' => esc_html__('3', 'wan'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'number_related_post',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Number Of Related Posts', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 18
        )
    );

	// Author
    $wp_customize->add_setting (
        'show_author_info',
        array (
            'sanitize_callback' => 'wan_sanitize_checkbox',
            'default' => wan_customize_default_options2('show_author_info'),     
        )
    );

    $wp_customize->add_control( 
        'show_author_info',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Show Author Info', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 18
        )
    );
    $wp_customize->add_setting (
        'author_img_size',
        array(
            'default' => wan_customize_default_options2('author_img_size'),
            'sanitize_callback' => 'wan_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'author_img_size',
        array(
            'type'      => 'text',
            'label'     => esc_html__('Author Gavatar Size', 'wan'),
            'section'   => 'blog_options',
            'priority'  => 18
        )
    );
    
    // Section Typography
    $wp_customize->add_section(
        'wan_typography',
        array(
            'title' => esc_html__('Typography', 'wan'),
            'priority' => 6,            
        )
    );
     // Heading Typography
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-add-font', array(
        'label' => esc_html__('ADD FONTS', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    ); 
     // Body fonts
    $wp_customize->add_setting(
        'add_typekit_font',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new Typekit($wp_customize,
        'add_typekit_font',
        array(
            'label' => esc_html__( 'Enter Typekit Api Key', 'wan' ),
            'description' => esc_html__( 'Please restart after publish/update.Thanks', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typekit',
            'priority' => 2
        ))
    ); 
      // Body fonts
    $wp_customize->add_setting(
        'add_local_font',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control( 
        new LocalFont( 
        $wp_customize, 
        'add_local_font', 
        array(
            'label'      => esc_html__( 'Upload Local Font', 'wan' ),
            'description'      => esc_html__( 'Wordpress Just Support TTF for security reason', 'wan' ),
            'section'    => 'wan_typography',
            'priority' => 2,
            'mime_type' => 'application/x-font-ttf'
        ) ) 
    );

    // Heading Typography
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-typography-body', array(
        'label' => esc_html__('BODY FONT', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );    

    // Desc Typography
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_logo', array(
        'label' => esc_html__('You can modify the font family, size, color, ... for global content.', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 3
        ) )
    );

      // Body fonts
    $wp_customize->add_setting(
        'body_font_name',
        array(
            'default' => wan_customize_default_options2('body_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'body_font_name',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style','line_height','size','letter_spacing'),
            'priority' => 4
        ))
    );

    // Headings fonts
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-heading-font', array(
        'label' => esc_html__('Headings fonts', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 8
        ) )
    );    

    // Desc font
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_heading-font', array(
        'label' => esc_html__('You can modify the font options for your headings. h1, h2, h3, h4, ...', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 9
        ) )
    );   

    $wp_customize->add_setting(
        'headings_font_name',
        array(
            'default' => wan_customize_default_options2('headings_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'headings_font_name',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style','line_height','letter_spacing'),
            'priority' => 11
        ))
    );

   

    // H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           =>  wan_customize_default_options2('h2_size'),
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'text',
        'priority'    => 14,
        'section'     => 'wan_typography',
        'label'       => esc_html__('H2 font size', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           => wan_customize_default_options2('h3_size'),
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'text',
        'priority'    => 15,
        'section'     => 'wan_typography',
        'label'       => esc_html__('H3 font size', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           =>  wan_customize_default_options2('h4_size'),
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'text',
        'priority'    => 16,
        'section'     => 'wan_typography',
        'label'       => esc_html__('H4 font size', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           =>  wan_customize_default_options2('h5_size'),
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'text',
        'priority'    => 17,
        'section'     => 'wan_typography',
        'label'       => esc_html__('H5 font size', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           =>  wan_customize_default_options2('h6_size'),
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'text',
        'priority'    => 18,
        'section'     => 'wan_typography',
        'label'       => esc_html__('H6 font size', 'wan'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // Heading Menu fonts
    $wp_customize->add_setting('wan_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new wan_Info( $wp_customize, 'menu_fonts', array(
        'label' => esc_html__('Menu fonts', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 19
        ) )
    );

    $wp_customize->add_setting(
        'menu_font_name',
        array(
            'default' => wan_customize_default_options2('menu_font_name'),
                'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'menu_font_name',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style','size','line_height','letter_spacing'),
            'priority' => 20
        ))
    );

     // Heading Typography
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-typography-footer', array(
        'label' => esc_html__('FOOTER FONT', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 20
        ) )
    );    

    // Desc Typography
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_logo', array(
        'label' => esc_html__('You can modify the font family, size, color, ... for global content.', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 20
        ) )
    );

      // Footer fonts
    $wp_customize->add_setting(
        'footer_font_name',
        array(
            'default' => wan_customize_default_options2('footer_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'footer_font_name',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style','size'),
            'priority' => 20
        ))
    );

    // footer widget title
    $wp_customize->add_setting(
        'footer_widget_title_font_size',
        array(
            'sanitize_callback' => 'esc_attr',
            'default'           =>  wan_customize_default_options2('footer_widget_title_font_size'),
        )       
    );
    $wp_customize->add_control(
        'footer_widget_title_font_size',
        array(
            'label' => esc_html__( 'Widget Title Font Size', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'text',
            'priority' => 20
        )
    );  
    
      // Header fonts
      // Heading Typography
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-typography-header', array(
        'label' => esc_html__('HEADER FONT', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 20
        ) )
    );    

    // Desc Typography
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_logo', array(
        'label' => esc_html__('You can modify the font family, size, color, ... for global content.', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 20
        ) )
    );
    $wp_customize->add_setting(
        'header_font_name',
        array(
            'default' => wan_customize_default_options2('header_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'header_font_name',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style','size'),
            'priority' => 20
        ))
    );
    // Extra Fonts
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-extra-font', array(
        'label' => esc_html__('Extra fonts', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 21
        ) )
    );    
      // Desc font
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_customizer_heading-font', array(
        'label' => esc_html__('You can add 2 Extra Font. With will apply to Class Name', 'wan'),
        'section' => 'wan_typography',
        'settings' => 'wan_options[info]',
        'priority' => 21
        ) )
    );   
	$wp_customize->add_setting(
        'cls_extra_font_name1',
        array(
            'sanitize_callback' => 'sanitize_title',
            'default'           => wan_customize_default_options2('cls_extra_font_name1'),
        )       
    );
    $wp_customize->add_control( 'cls_extra_font_name1', array(
        'type'        => 'text',
        'priority'    => 21,
        'section'     => 'wan_typography',
        'label'       => esc_html__('Class Name Extra Font 1', 'wan'),
        'description' => __('This class will using for apply Extra Typography1','wan')
    ) );
  

    $wp_customize->add_setting(
        'extra_font_name1',
        array(
            'default' => wan_customize_default_options2('extra_font_name1'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'extra_font_name1',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style'),
            'priority' => 21
        ))
    );
    $wp_customize->add_setting(
        'cls_extra_font_name2',
        array(
            'sanitize_callback' => 'sanitize_title',
            'default'           => wan_customize_default_options2('cls_extra_font_name2'),
        )       
    );
    $wp_customize->add_control( 'cls_extra_font_name2', array(
        'type'        => 'text',
        'priority'    => 21,
        'section'     => 'wan_typography',
        'label'       => esc_html__('Class Name Extra Font 2', 'wan'),
        'description' => __('This class will using for apply Extra Typography 2','wan')
    ) );
     $wp_customize->add_setting(
        'extra_font_name2',
        array(
            'default' => wan_customize_default_options2('extra_font_name2'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'extra_font_name2',
        array(
            'label' => esc_html__( 'Font name/style/sets', 'wan' ),
            'section' => 'wan_typography',
            'type' => 'typography',
            'fields' => array('family','style'),
            'priority' => 21
        ))
    );


    // Section Layout
    $wp_customize->add_section(
        'layouts',
        array(
            'title' => esc_html__('Layout Style', 'wan'),
            'priority' => 6,            
        )
    );
    // general page
    $wp_customize->add_control( new wan_Info( $wp_customize, 'custom-general-layout-header', array(
        'label' => esc_html__('General', 'wan'),
        'section' => 'layouts',
        'settings' => 'wan_options[info]',
        'priority' => 1
        ) )
    );    

    $wp_customize->add_setting(
        'layout_version',
        array(
            'default'           => wan_customize_default_options2('layout_version'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'layout_version',
        array(
            'type'      => 'select',           
            'section'   => 'layouts',
            'priority'  => 1,
            'label'         => esc_html__('Layout version', 'wan'),
            'choices'   => array(
               'fluid'         =>  esc_html__('Full Width','wan'),
                'wan-container'         =>  esc_html__('Container','wan'),
        ))
    );
    $wp_customize->add_setting(
        'gsidebar_cls',
        array(
            'default' => wan_customize_default_options2('gsidebar_cls'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        'gsidebar_cls',
        array(
            'label' => esc_html__( 'Sidebar Class', 'wan' ),
            'description'    => __( "Define general sidebar width/class.\nExample: col-lg-9 col-md-8", 'wan' ),
            'section' => 'layouts',
            'type' => 'text',
            'priority' => 1
        )
    );  
     $wp_customize->add_setting(
        'gcontent_cls',
        array(
            'default' => wan_customize_default_options2('gcontent_cls'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        'gcontent_cls',
        array(
            'label' => esc_html__( 'Primary Area Class', 'wan' ),
            'description'    => __( "Define general Primary width/class.\nExample: col-lg-3 col-md-4", 'wan' ),
            'section' => 'layouts',
            'type' => 'text',
            'priority' => 1
        )
    );  
    // Sidebars
    $wp_customize->add_control( new wan_Info( $wp_customize, 'layout_body', array(
        'label' => esc_html__('Page Sidebar', 'wan'),
        'section' => 'layouts',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );    

    // Desc
    $wp_customize->add_control( new wan_Desc_Info( $wp_customize, 'desc_color_scheme', array(
        'label' => esc_html__('Select the sidebar that you wish to display.','wan'),
        'section' => 'layouts',
        'settings' => 'wan_options[info]',
        'priority' => 2
        ) )
    );   

  
    $wp_customize->add_setting (
        'page_sidebar_list',
        array(
            'default'           => wan_customize_default_options2('page_sidebar_list'),
            'sanitize_callback' => 'esc_html',
        )
    );

    $wp_customize->add_control( new DropdownSidebars($wp_customize,
        'page_sidebar_list',
        array(
            'type'      => 'dropdown',           
            'section'   => 'layouts',
            'priority'  => 2,
            'label'         => esc_html__('Sidebar choose', 'wan'),            
        ))
    );
    update_option('show_default_css',1);
    if (get_option('show_default_css')==1):
    $wp_customize->add_setting (
        'default_theme_css',
        array(
            'default'           =>'',
            'sanitize_callback' => 'sanitize_textarea_field'
        )
    );
    endif;
    //___ Woocommerce ____//
    $wp_customize->add_section(
        'layout',
        array(
            'title'         => esc_html__('Layout', 'wan'),
            'priority'      => 1,
            'panel'=> 'woocommerce',
        )
    ); 
    $wp_customize->add_setting(
        'woocommerce_sidebar_cls',
        array(
            'default' => wan_customize_default_options2('woocommerce_sidebar_cls'),
            'sanitize_callback' => 'wan_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'woocommerce_sidebar_cls',
        array(
            'label' => esc_html__( 'Sidebar Class', 'wan' ),
            'section' => 'layout',
            'type' => 'text',
            'priority' => 2
        )
    );  
    $wp_customize->add_setting(
        'woocommerce_layout',
        array(
            'default'           => wan_customize_default_options2('woocommerce_layout'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'woocommerce_layout',
        array (
            'type'      => 'select',           
            'section'   => 'layout',
            'priority'  => 2,
            'label'         => esc_html__('Archive Sidebar Position', 'wan'),
            'choices'   => array (
                'sidebar-right' => esc_html__( 'Sidebar Right','wan' ),
                'sidebar-left'=>  esc_html__( 'Sidebar Left','wan' ),
                'no-sidebar' =>   esc_html__( 'No Sidebar','wan' )
                ) ,
        )
    );
  
    // columns
    $wp_customize->add_setting(
        'woocommerce_columns',
        array(
            'default' => wan_customize_default_options2('woocommerce_columns'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        'woocommerce_columns',
        array(
            'label' => esc_html__( 'Woocommerce Columns', 'wan' ),
            'section' => 'layout',
            'type' => 'select',
            'choices'   => array(
                1       => esc_html__('1 Column','wan'),
                2       =>  esc_html__('2 Columns','wan'),
                3        =>  esc_html__('3 Columns','wan'),
                4        =>  esc_html__('4 Columns','wan'),
                5        =>  esc_html__('5 Columns','wan'),
                6        =>  esc_html__('6 Columns','wan'),
            ),
            'priority' => 2
        )
    );  
 
	 $wp_customize->add_setting(
        'woosingle_layout',
        array(
            'default'           => wan_customize_default_options2('woosingle_layout'),
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( 
        'woosingle_layout',
        array (
            'type'      => 'select',           
            'section'   => 'layout',
            'priority'  => 2,
            'label'         => esc_html__('Product Details Sidebar Position', 'wan'),
            'choices'   => array (
                'sidebar-right' => esc_html__( 'Sidebar Right','wan' ),
                'sidebar-left'=>  esc_html__( 'Sidebar Left','wan' ),
                'no-sidebar' =>   esc_html__( 'No Sidebar','wan' )
                ) ,
        )
    );
    
    
    $wp_customize->add_section(
        'wan_customjs',
        array(
            'title'         => esc_html__('Additional JS', 'wan'),
            'priority'      => 200,
        )
    ); 

      // Top Content
    $wp_customize->add_setting(
        'wan_custom_js',
        array(
            'default'=>'',
            'sanitize_callback' => 'sanitize_textarea_field'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control(
            $wp_customize,
        'wan_custom_js',
            array(
                'label' => esc_html__( 'You can add your own JS here.', 'wan' ),
                'description'    => esc_html__( 'Do not need include <script></script> Tag', 'wan' ),
                'section' => 'wan_customjs',
                'code_type' => 'javascript',
                'priority' => 23
            )
        )
    );  

}
add_action( 'customize_register', 'wan_customize_register' );

/**
 * Sanitize
 */

// Text
function wan_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

// Background size
function wan_sanitize_bg_size( $input ) {
    $valid = array(
        'cover'     => esc_html__('Cover', 'wan'),
        'contain'   => esc_html__('Contain', 'wan'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Blog Layout
function wan_sanitize_blog( $input ) {
    $valid = array(
        'sidebar-right'    => esc_html__( 'Sidebar right', 'wan' ),
        'sidebar-left'    => esc_html__( 'Sidebar left', 'wan' ),
        'fullwidth'  => esc_html__( 'Full width (no sidebar)', 'wan' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// wan_sanitize_pagination
function wan_sanitize_pagination ( $input ) {
    $valid = array(
        'pager' => esc_html__('Pager', 'wan'),
        'numeric' => esc_html__('Numeric', 'wan'),
        'page_numeric' => esc_html__('Pager & Numeric', 'wan')                
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// wan_sanitize_pagination
function wan_sanitize_layout_version ( $input ) {
    $valid = array(
        'boxed' => esc_html__('Boxed', 'wan'),
        'wide' => esc_html__('Wide', 'wan')          
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// wan_sanitize_related_post
function wan_sanitize_related_post ( $input ) {
    $valid = array(
        'simple_list' => esc_html__('Simple List', 'wan'),
        'grid' => esc_html__('Grid', 'wan')        
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Footer widget areas
function wan_sanitize_fw( $input ) {
    $valid = array(
        '0' => esc_html__('footer_default', 'wan'),
        '1' => esc_html__('One', 'wan'),
        '2' => esc_html__('Two', 'wan'),
        '3' => esc_html__('Three', 'wan'),
        '4' => esc_html__('Four', 'wan')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Header style sanitize
function wan_sanitize_headerstyle( $input ) {
    $valid = wan_predefined_header_styles();
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Checkboxes
function theme_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
function wan_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
  }

// Pictor_sanitize_related_portfolio
function wan_sanitize_related_portfolio( $input ) {
    $valid = array(
        'grid'                 => esc_html__( 'Grid', 'wan' ),
        'grid_masonry'         => esc_html__( 'Grid Masonry', 'wan' ),
        'grid_nomargin'        => esc_html__( 'Grid Masonry No Margin', 'wan' ),
        'carosuel'             => esc_html__( 'Carosuel', 'wan' ),
        'carosuel_nomargin'    => esc_html__( 'Carosuel No Margin', 'wan' )       
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_pagination
function wan_sanitize_portfolio_pagination( $input ) {
    $valid = array(
        'page_numeric'         => esc_html__( 'Pager & Numeric', 'wan' ),
        'load_more'         => esc_html__( 'Load More', 'wan' )     
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_order
function wan_sanitize_portfolio_order( $input ) {
    $valid = array(
        'date'          => esc_html__( 'Date', 'wan' ),
        'id'            => esc_html__( 'Id', 'wan' ),
        'author'        => esc_html__( 'Author', 'wan' ),
        'title'         => esc_html__( 'Title', 'wan' ),
        'modified'      => esc_html__( 'Modified', 'wan' ),
        'comment_count' => esc_html__( 'Comment Count', 'wan' ),
        'menu_order'    => esc_html__( 'Menu Order', 'wan' )     
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_order_direction
function wan_sanitize_portfolio_order_direction( $input ) {
    $valid = array(
        'DESC' => esc_html__( 'Descending', 'wan' ),
        'ASC'  => esc_html__( 'Assending', 'wan' )       
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_grid_portfolio
function wan_sanitize_grid_portfolio( $input ) {
    $valid = array(
        'portfolio-two-columns'     => esc_html__( '2 Columns', 'wan' ),
        'portfolio-three-columns'     => esc_html__( '3 Columns', 'wan' ),
        'portfolio-four-columns'     => esc_html__( '4 Columns', 'wan' ),
        'portfolio-five-columns'     => esc_html__( '5 Columns', 'wan' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// wan_sanitize_grid_portfolio_related
function wan_sanitize_grid_portfolio_related( $input ) {
    $valid = array(
        'portfolio-one-columns'     => esc_html__( '1 Columns', 'wan' ),
        'portfolio-two-columns'     => esc_html__( '2 Columns', 'wan' ),
        'portfolio-three-columns'     => esc_html__( '3 Columns', 'wan' ),
        'portfolio-four-columns'     => esc_html__( '4 Columns', 'wan' ),
        'portfolio-five-columns'     => esc_html__( '5 Columns', 'wan' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

if (!function_exists('wan_sanitize_layout_product')):
    // wan_sanitize_layout_product
function wan_sanitize_layout_product( $input ) {
    $valid = array(        
        'fullwidth'         => esc_html__( 'No Sidebar', 'wan' ),
        'sidebar-right'           => esc_html__( 'Sidebar Right', 'wan' ),
        'sidebar-left'         => esc_html__( 'Sidebar Left', 'wan' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
endif;
if (!function_exists('wan_load_customizer_style')):
function wan_load_customizer_style() {   
    wp_register_style( 'wan_customizer_css', WAN_LINK .'css/admin/customizer.css', false, '1.0.0' );
    wp_enqueue_style( 'wan_customizer_css' );
    wp_enqueue_script('jquery-ui');
    wp_enqueue_script( 'wan-color-alpha', WAN_LINK . 'js/wp-color-picker-alpha.js', array('wp-color-picker'),'1.1',true);
    wp_enqueue_script( 'wan-func', WAN_LINK . 'js/func.js', [],'1.1',true);
    wp_enqueue_script( 
          'select2',            //Give the script an ID
          'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js',//Point to file
          array( 'jquery'),    //Define dependencies
          '',                       //Define a version (optional) 
          true                      //Put script in footer?
    );
    if (is_customize_preview()) {
        wp_enqueue_script( 
            'wan_customizer_js',            //Give the script an ID
            WAN_LINK .'js/customizer.js',//Point to file
            array( 'jquery','customize-preview' ),    //Define dependencies
            '',                       //Define a version (optional) 
            true                      //Put script in footer?
        );
    }
    wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css', array(), true ); 
}
endif;
add_action( 'admin_enqueue_scripts', 'wan_load_customizer_style' );
