<?php
class wan_widget_login extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_widget_login
     */


    function __construct() {
        $this->defaults = array(
            'title' 	=> '', 
            'class'           => 'color_default form_right s-10',
            'icon'           => 'fa fa-user',
            'classname'           => 'color_default form_right s-10',
            );

        parent::__construct(
            'widget_wan_login',
            esc_html__( 'Go - Login', 'wan' ),
            array(
                'classname'   => 'widget-wan-login',
                'description' => esc_html__( 'Login', 'wan' ),
                'icon'           => 'fa fa-user',
                'class'           => 'color_default form_right s-10',
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
            if (function_exists('wan_myaccount')) {
				echo wan_myaccount($instance);
			}
        echo $after_widget;
}

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['icon']      = strip_tags( $new_instance['icon'] );
        $instance['class']      = strip_tags( $new_instance['class'] );

        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
              ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon Class:', 'wan' ); ?></label>
            <br><i><?php _e('Leave empty to hide icon, default: ','wan');?>fa fa-user</i>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon'] ); ?>">
        </p>
            <?php
        }

    }

    add_action( 'widgets_init', 'wan_widget_login' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function wan_widget_login() {
    register_widget( 'wan_widget_login' );
}

