<?php
/* Wan_weater - WARREN NGUYEN*/
class wan_ldate extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_ldate
     */
    function __construct() {
        $this->defaults = array(
            'title' 	=> 'Location Date Widget', 
            'city' 	=> 'America/New_York', 
        );

        parent::__construct(
            'wan_ldate',
            esc_html__( 'wan - Location Date', 'wan' ),
            array(
                'classname'   => 'widget-wan-ldate',
                'description' => esc_html__( 'Widget Location Date', 'wan' )
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
		if ( !empty($title) ) { echo $before_title.esc_html($title).$after_title; }	
		echo '<div class="wan-date">';
		echo '<input class="wan-date-city" value="'.$city.'" type="hidden"/>';
		echo '<div class="wan-date-day"></div>';
		echo '<div class="wan-date-time"></div>';
		echo '</div>';
		echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;

        $instance['city']      = ( $new_instance['city'] );
        $instance['title']      = ( $new_instance['title'] );
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>"><?php esc_html_e( 'Select Time Zone', 'wan' ); ?></label>
			<select class="wan-zones select2" id="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'city' ) ); ?>">
            <?php
				$OptionsArray = timezone_identifiers_list();
				$select = '';
				echo $instance['city'];
				while (list ($key, $row) = each ($OptionsArray) ){
					$select .='<option value="'.$row.'"';
					$select .= ($row == $instance['city'] ? ' selected' : '');
					$select .= '>'.$row.'</option>';
				}  // endwhile;
				echo $select; ?>
            </select>
        </p>

    <?php
    }

}
/* Wan List Page - WARREN NGUYEN*/
class wan_list_pages extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_list_pages
     */
    function __construct() {
        $this->defaults = array(
			'title' => '',
            'numpost' 	=> 5, 
            'pages' 	=> [], 
        );

        parent::__construct(
            'wan_list_pages',
            esc_html__( 'wan - List Pages', 'wan' ),
            array(
                'classname'   => 'widget-wan-list_pages',
                'description' => esc_html__( 'Widget List Pages', 'wan' )
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
		if ( !empty($title) ) { echo $before_title.esc_html($title).$after_title; }	
		if ($pages==null || $pages ==[]) {
			echo '<div>';
			_e('No selected pages','wan');
			echo '</div>';
		}
		else {
			echo '<ul>';
				foreach ($pages as $page_id){
					printf('<li><a href="%s">%s</a></li>',get_permalink($page_id),get_the_title($page_id));
				}
			echo '</ul>';
		}
		echo $after_widget;
	}
    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
		$instance['title']      = ( $new_instance['title'] );
		$instance['pages']           = ( $new_instance['pages'] );        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
		$instance['pages'] = $instance['pages']==null ? []:$instance['pages'];
        ?>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>"><?php esc_html_e( 'Select Pages to build List', 'wan' ); ?></label>
			<select multiple class="wan-list_pages select2" id="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pages' ) ); ?>[]">
            <?php
				$pages = get_pages();
				$select = '';
				foreach ($pages as $page) {
					$select .='<option value="'.$page->ID.'"';
					$select .= in_array($page->ID, $instance['pages']) ? ' selected' : '';
					$select .= '>'.$page->post_title.'</option>';
				}
				echo $select;
				?>
            </select>
        </p>

    <?php
    }

}
function wan_ldate_js(){
	wp_enqueue_script( 'jquery-moment', get_template_directory_uri() . '/js/moment.js', array(), '1.5.7', true );
	wp_enqueue_script( 'jquery-moment-data', get_template_directory_uri() . '/js/moment-timezone-with-data.js', array(), '1.5.7', true );
	wp_enqueue_script( 'wan-pkg', get_template_directory_uri() . '/js/wan-pkg.js', array(),'20151215' , true );
}
function wan_register_ldate() {
    register_widget( 'wan_ldate' );
	register_widget( 'wan_list_pages' );
    add_action('admin_enqueue_scripts','wan_ldate_js');
}
add_action( 'widgets_init', 'wan_register_ldate' );
