<?php
class nova_Recent_Post extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return nova_Recent_Post
     */
    function __construct() {
        $this->defaults = array(
            'title' 	=> 'Recent Post', 
            'category'  => '',
            'post_type'  => 'post',
            'count' 	=> 4,
            'show_content' => false,
            'just_thumbnail' => false,
            'show_date' => true           
        );

        parent::__construct(
            'widget_recent_post',
            esc_html__( 'nova - Recent Post', 'nova' ),
            array(
                'classname'   => 'widget-recent-news',
                'description' => esc_html__( 'Recent Post.', 'nova' )
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

        $query_args = array(
            'post_type' => $post_type,
            'posts_per_page' => intval($count)
        );

        if ( !empty( $category ) )
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'terms'    => $category,
                ),
            );             
       
        $nova_post = new WP_Query( $query_args );
        echo $before_widget;

        $class =array('nova-recent-news clearfix');
        if ( $just_thumbnail != false ) {
            $class[] = 'just_thumbnail';
        }

		if ( !empty($title) ) { echo $before_title.esc_html($title).$after_title; } ?>		
        <ul class="<?php echo implode(' ',$class);?>">  
		<?php if ( $nova_post->have_posts() ) : ?>
			<?php while ( $nova_post->have_posts() ) : $nova_post->the_post(); ?>
				<li>
                    <?php if ( has_post_thumbnail()) : ?>
                    <div class="thumb">
                        <span class="overlay-pop"></span>
                        <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'nova-recent-news-thumb'); ?>
                        </a>
                    </div>
                    <?php endif; ?>  
                    <?php if ($just_thumbnail == false):?>                     
                    <div class="text">
                        <?php 
                        the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
                        ?>                        
                        <?php if ( $show_content ) : ?>
                        <p><?php echo wp_trim_words( get_the_content(), 8, '...' ); ?></p>
                        <?php endif; ?>
                        <?php if ( $show_date ) : ?>
                        <p><time class="date updated" datetime="<?php esc_attr(the_time( 'c' )); ?>"><?php esc_html_e('on ','nova') ;the_time( get_option( 'date_format' ) ); ?></time></p>
                        <?php endif; ?>
                    </div><!-- /.text -->      
                    <?php endif;?>                  
			    </li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php else : ?>  
            <?php printf( '<li>%s</li>',esc_html__('Oops, category not found.', 'nova' )); ?>
		<?php endif; ?>        
        </ul>		
		<?php echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;

        $instance['post_type']      = ( $new_instance['post_type'] );
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['count']      =  intval($new_instance['count']);
        $instance['show_date']     = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_content']     = isset( $new_instance['show_content'] ) ? (bool) $new_instance['show_content'] : false;       
         $instance['just_thumbnail']     = isset( $new_instance['just_thumbnail'] ) ? (bool) $new_instance['just_thumbnail'] : false;   
        $instance['category']           = array_filter( $new_instance['category'] );        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        $show_content = $instance['show_content'] ? "checked" : "";
        $show_content   = isset( $instance['show_content'] ) ? (bool) $instance['show_content'] : false;
        $just_thumbnail   = isset( $instance['just_thumbnail'] ) ? (bool) $instance['just_thumbnail'] : false;
        $show_date = $instance['show_date'] ? "checked" : "";
        $show_date   = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Select Post Type:', 'nova' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>[]">
                <option value="post" <?php selected($instance['post_type'][0],'post')?>><?php esc_html_e( 'Post', 'nova' ); ?></option>
                <option value="portfolios" <?php selected($instance['post_type'][0],'portfolios')?>><?php esc_html_e( 'Portfolio', 'nova' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'nova' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select Category:', 'nova' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>[]">
                <option value=""<?php selected( empty( $instance['category'] ) ); ?>><?php esc_html_e( 'All', 'nova' ); ?></option>
                <?php               
                $categories = get_categories();
                foreach ($categories as $category) {
                    printf('<option value="%1$s" %4$s>%2$s (%3$s)</option>', esc_attr($category->term_id), esc_attr($category->name), esc_attr($category->count), (in_array($category->term_id, $instance['category'] )) ? 'selected="selected"' : '');
                }               

                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'nova' ); ?></label>
            <input class="widefat" type="number" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>">
        </p>

         <p>
            <input class="checkbox" type="checkbox" <?php checked( $just_thumbnail ); ?> id="<?php echo esc_attr( $this->get_field_id( 'just_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'just_thumbnail' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'just_thumbnail' ) ); ?>"><?php esc_html_e( 'Just Show Thumbnail ?', 'nova' ) ?></label>
        </p>     

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_content ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php esc_html_e( 'Show Content ?', 'nova' ) ?></label>
        </p>       

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date ?', 'nova' ); ?></label>
        </p>

    <?php
    }

}

add_action( 'widgets_init', 'nova_register_recent_post' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function nova_register_recent_post() {
    register_widget( 'nova_Recent_Post' );
    register_widget('Nova_Widget_Recent_Comments');
}

?>

<?php
/*
widget recent comment
*/
class Nova_Widget_Recent_Comments extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_recent_comments',
            'description' => __( 'Your site&#8217;s most recent comments.','nova' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'recent-comments', esc_html__( 'Recent Comments','nova' ), $widget_ops );
        $this->alt_option_name = 'widget_recent_comments';

        if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
            add_action( 'wp_head', array( $this, 'recent_comments_style' ) );
        }
    }

    /**
     * Outputs the default styles for the Recent Comments widget.
     *
     * @since 2.8.0
     * @access public
     */
    public function recent_comments_style() {
        /**
         * Filters the Recent Comments default widget styles.
         *
         * @since 3.1.0
         *
         * @param bool   $active  Whether the widget is active. Default true.
         * @param string $id_base The widget ID.
         */
        if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
            || ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
            return;
        ?>
        
        <?php
    }

    /**
     * Outputs the content for the current Recent Comments widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Comments widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        $output = '';

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Comments','nova' );

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;

        /**
         * Filters the arguments for the Recent Comments widget.
         *
         * @since 3.4.0
         *
         * @see WP_Comment_Query::query() for information on accepted arguments.
         *
         * @param array $comment_args An array of arguments used to retrieve the recent comments.
         */
        $comments = get_comments( apply_filters( 'widget_comments_args', array(
            'number'      => $number,
            'status'      => 'approve',
            'post_status' => 'publish'
        ) ) );

        $output .= $args['before_widget'];
        if ( $title ) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $output .= '<ul id="recentcomments">';
        if ( is_array( $comments ) && $comments ) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

            foreach ( (array) $comments as $comment ) {
                $output .= '<li class="recentcomments">';
                /* translators: comments widget: 1: comment author, 2: post link */
                $output .= '<span class="by">'.esc_html__('By ','nova').'</span><span class="comment-author-link">' . get_comment_author_link( $comment ) . '</span><span class="on">'.esc_html__(' on','nova').'</span><a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>';
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        $output .= $args['after_widget'];

        echo $output;
    }

    /**
     * Handles updating settings for the current Recent Comments widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = absint( $new_instance['number'] );
        return $instance;
    }

    /**
     * Outputs the settings form for the Recent Comments widget.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','nova' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of comments to show:','nova' ); ?></label>
        <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
        <?php
    }

    /**
     * Flushes the Recent Comments widget cache.
     *
     * @since 2.8.0
     * @access public
     *
     * @deprecated 4.4.0 Fragment caching was removed in favor of split queries.
     */
    public function flush_widget_cache() {
        _deprecated_function( __METHOD__, '4.4.0' );
    }
}
