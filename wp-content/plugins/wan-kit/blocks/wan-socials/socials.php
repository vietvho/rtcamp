<?php
class wan_socials extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_socials
     */
    function __construct() {
        $this->defaults = array(
            'title'         => 'Go: Socials',
            'value'         => '',
            'show_social_name' => false,
        );

        parent::__construct(
            'widget_wan_socials',
            esc_html__( 'Go: Socials', 'savit' ),
            array(
                'classname'   => 'widget_wan_socials',
                'description' => esc_html__( 'wan Socials.', 'savit' )
            )
        );
    }

    /**
     * Display widget
     */
    function widget( $args, $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );

        extract( $args );

        echo $before_widget;
        if ( !empty($title) ) echo $before_title.esc_html($title).$after_title;?>

        <?php wan_render_social('',$instance['value'],$instance['show_social_name']);?>

        <?php echo $after_widget;

    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance                   = $old_instance;

        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['value']          = ( $new_instance['value'] );
        $instance['show_social_name']      =  intval($new_instance['show_social_name']);
        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {
        // wp_enqueue_script('wan_customizer_js');
        $instance = wp_parse_args( $instance, $this->defaults );
        $show_content   = isset( $instance['show_social_name'] ) ? (bool) $instance['show_social_name'] : false;
        $icons = wan_available_social_icons();
        $value = $instance['value'];
        $order = $icons['__ordering__'];
        if ( ! is_array( $value ) ) {
            $decoded_value = json_decode(str_replace('&quot;', '"', $value), true );
            $value = is_array( $decoded_value ) ? $decoded_value : array();
        }

        if ( isset( $value['__ordering__'] ) && is_array( $value['__ordering__'] ) )
            $order = $value['__ordering__'];
            /*
        ?>
        <div style="display:table;" class="wan_widget_socials wan-options-control-social-icons">
            <ul class="wan_ICONs">
                <li class="item-properties">
                    <label>
                        <span class="input-title"></span>
                        <input type="text" class="input-field" />
                    </label>
                    <button type="button" class="button button-primary confirm"><i class="fa fa-check"></i></button>
                </li>

                <?php foreach ( $order as $id ):
                    $params = $icons[$id];
                    $link = isset( $value[$id] ) ? sprintf( 'data-link="%s"', esc_attr( $value[$id] ) ) : '';
                    ?>
                    <li class="item wan-<?php wan_esc_attr( $id ) ?>" data-id="<?php wan_esc_attr( $id ) ?>" <?php wan_esc_attr($link) ?> data-title="<?php wan_esc_attr( $params['title'] ) ?>">
                        <i class="fa <?php wan_esc_attr( $params['iclass'] ) ?>"></i>
                    </li>
                <?php endforeach ?>
            </ul>
            <input type="hidden" id="typography-value"  name="<?php wan_esc_attr($this->get_field_name('value'));?>"  value="<?php wan_esc_attr(  $instance['value'] ) ?>" />
        </div>
        */ ?>
        <?php
            esc_html_e('Add/Edit Socials Items ','savit');
            printf('<a href="%s" target="_blank">%s</a>',admin_url( '/customize.php?autofocus[section]=wan_socials' ),esc_html('here','savit'));
        ?>
          <p>
                <input class="checkbox" value="1" type="checkbox" <?php checked( $instance['show_social_name'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_social_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_social_name' ) ); ?>" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_social_name' ) ); ?>"><?php esc_html_e( 'Show Social Name ?', 'savit' ) ?></label>
            </p>      
    <?php
    }

}

add_action( 'widgets_init', 'wan_socials_widget' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function wan_socials_widget() {
    register_widget( 'wan_socials' );
}
