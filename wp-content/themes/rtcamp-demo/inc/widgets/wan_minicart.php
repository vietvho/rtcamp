<?php
class wan_minicart_widget extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_minicart_widget
     */


    function __construct() {
        $this->defaults = array(
            'title'     => '', 
            'cart_text' 	=> 'Cart / ', 
            'class'           => 'form_right',
            'classname'           => 'form_right',
            'icon_pos' => '',
            'icon_style'=>'ministyle1',
            'cart_icon'  => WAN_LINK.'images/cart_icon.svg'
            );

        parent::__construct(
            'widget_wan_minicart',
            esc_html__( 'Go - MiniCart', 'wan' ),
            array(
                'classname'   => 'widget-wan-minicart',
                'description' => esc_html__( 'Mini Cart', 'wan' ),
                'class'           => 'form_right',
	            'cart_text' 	=> 'Cart / ', 
                'icon_pos' => '',
                'icon_style'=>'ministyle1',
                'cart_icon'  => WAN_LINK.'images/cart_icon.svg'
                )
            );
    }

    /**
     * Display widget
     */
    function widget( $args, $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        extract($args);
        extract($instance);
        echo $before_widget;
        if ( !empty($title) ) echo $before_title.esc_html($title).$after_title;
			if (function_exists('wan_minicart')) {
				echo wan_minicart($instance);
			}
        echo $after_widget;
}

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['icon_pos']	= $new_instance['icon_pos'];
        $instance['icon_style']	= $new_instance['icon_style'];
        $instance['cart_text']      = strip_tags( $new_instance['cart_text'] );
        $instance['class']      = strip_tags( $new_instance['class'] );

        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        $placeholder = $instance['icon_style'] == 'ministyle2' ? 'left: 120%;top: 0;' : 'left: 50%;top: 60%';
        $icon_styles = ['ministyle1','ministyle2'];
              ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_style' ) ); ?>"><?php esc_html_e( 'Icon Style:', 'wan' ); ?></label>
            <?php foreach ($icon_styles as $icon_style):
                    $selected = $icon_style == $instance['icon_style'] ? 'checked="checked"':'';
                ?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_style' ) ); ?>" type="radio" value="<?php echo $icon_style; ?>" <?php echo $selected;?>> <img src="<?php echo WAN_LINK."/images/$icon_style.png";?>"/>
            <?php endforeach;?>
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_pos' ) ); ?>"><?php esc_html_e( 'Icon Text Position:', 'wan' ); ?></label>
            <input class="widefat" placeholder="<?php echo $placeholder;?>" id="<?php echo esc_attr( $this->get_field_id( 'icon_pos' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_pos' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_pos'] ); ?>">
        </p>
        
         <div class="wan-uploads-panel small-icon">
            <label for="<?php echo esc_attr( $this->get_field_id( 'cart_icon' ) ); ?>"><?php esc_html_e( 'Cart Icon:', 'wan' ); ?></label>
            <div class="wan_preview d-inline-block"><img src="<?php echo $instance['cart_icon'];?>"/></div>
            <button class="wan_upload_image_button"><?php _e('Update Icon','wan');?></button>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cart_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cart_icon' ) ); ?>" type="hidden" value="<?php echo esc_attr( $instance['cart_icon'] ); ?>">
        </div>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cart_text' ) ); ?>"><?php esc_html_e( 'Cart Text:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cart_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cart_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['cart_text'] ); ?>">
        </p>
      
            <?php
        }

    }

    add_action( 'widgets_init', 'wan_minicart_widget' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function wan_minicart_widget() {
    register_widget( 'wan_minicart_widget' );
}


