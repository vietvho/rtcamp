<?php
class wan_Recent_Post extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return wan_Recent_Post
     */
    function __construct() {
        $this->defaults = array(
            'title' 	=> 'Recent Post', 
            'category'  => '',
            'post_type'  => 'post',
            'numpost' 	=> 6,
            'post_per_row'=> 3,
            'show_content' => false,
            'just_thumbnail' => false,
            'show_date' => true,
            'readmore_link' => '',
            'readmore_text' => 'More News',
            'numsticky' => 1,           
        );

        parent::__construct(
            'widget_recent_post',
            esc_html__( 'wan - Recent Post', 'wan' ),
            array(
                'classname'   => 'widget-wan-recent-post',
                'description' => esc_html__( 'Recent Post.', 'wan' )
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
		$sticky = get_option( 'sticky_posts' );
		// sticky  
        $query_args = array(
            'post_type' => $post_type,
            'posts_per_page' => intval($numsticky),
            'orderby'   => 'rand',
			'post__in' => $sticky,
			'ignore_sticky_posts' => 1

        );
       
        $wan_post = new WP_Query( $query_args );
        echo $before_widget;

        $class =array('widget-wan-recent-post clearfix');
        if ( $just_thumbnail != false ) {
            $class[] = 'just_thumbnail';
        }
		if ($readmore_link != '') {
			$link = $readmore_link;
		}
		else {
			if ($category == '') {
				echo 'page post'.get_option('page_for_posts');
				if (get_option( 'page_for_posts' ) != 0) {
					$link = get_permalink(get_option( 'page_for_posts' ) );
				}
				else {
					$link = '/';
				}
			}
			else {
				$link = get_category_link($category);
			}
		}
		if ( !empty($title) ) { echo $before_title.esc_html($title).$after_title; } ?>		
        <div class="<?php echo implode(' ',$class);?>">  
			<ul class="wan-recentpost-sticky">  
			<?php if ( $wan_post->have_posts() ) : ?>
				<?php while ( $wan_post->have_posts() ) : $wan_post->the_post(); ?>
					<li>
						<?php if ( has_post_thumbnail()) : ?>
						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'wan_recentpost'); ?>
							</a>
						</div>
						<?php endif; ?>  
						<?php if ($just_thumbnail == false):?>                     
						<div class="content">
							<?php 
							the_title( sprintf( '<h6><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
							?>                        
							<?php if ( $show_content ) : ?>
							<p><?php echo wp_trim_words( get_the_content(), 8, '...' ); ?></p>
							<?php endif; ?>
							<?php if ( $show_date ) : ?>
							<p class="date"><i class="fa fa-clock-o" aria-hidden="true"></i><?php the_time( get_option( 'date_format' ) ); ?></p>
							<?php endif; ?>
						</div><!-- /.text -->      
						<?php endif;?>                  
					</li>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else : ?> 
						<?php /*do some thing*/ ?>
			<?php endif; ?>        
			</ul>
			<?php /* other post */
				 $query_args = array(
					'post_type' => $post_type,
					'posts_per_page' => intval($numpost),
					'post__not_in' => $sticky,
					'ignore_sticky_posts' => 1
				);

				if ( !empty( $category ) )
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'category',
							'terms'    => $category,
						),
					);             
				$wan_post = new WP_Query( $query_args ); 
				$list = [];
				?>
				<div class="wan-recentpost-list wan-sliders" data-slick='{"infinite":false}' data-autoplay="false" data-nav='yes' data-items="1">  
				<?php if ( $wan_post->have_posts() ) : ?>
					<?php while ( $wan_post->have_posts() ) : $wan_post->the_post(); ?>
						<?php 
						$list[] = sprintf('<li>
								<a href="%1$s">%2$s</a>
						</li>',esc_url( get_permalink() ) ,get_the_title());
					endwhile; 
					$list_show = array_chunk($list,$post_per_row);
					foreach ($list_show as $item){
						echo '<div class="item"><ul>'.implode('',$item).'</ul></div>';
					}
					?>
					<?php wp_reset_postdata(); ?>
					<?php else : ?>  
					<?php /*do some thing*/ ?>
				<?php endif; ?>        
				</div>
				<a class="readmore-text" href="<?php echo $link;?>"><?php echo $readmore_text;?></a>
        </div>
		<?php echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;

        $instance['post_type']      = ( $new_instance['post_type'] );
        $instance['readmore_text']      = ( $new_instance['readmore_text'] );
        $instance['readmore_link']      = ( $new_instance['readmore_link'] );
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['numpost']      =  intval($new_instance['numpost']);
        $instance['post_per_row']      =  intval($new_instance['post_per_row']);
        $instance['show_date']     = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : true;
        //~ $instance['show_date']     = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_content']     = isset( $new_instance['show_content'] ) ? (bool) $new_instance['show_content'] : false;       
         $instance['just_thumbnail']     = isset( $new_instance['just_thumbnail'] ) ? (bool) $new_instance['just_thumbnail'] : false;   
        $instance['category']           = ( $new_instance['category'] );        
        //~ $instance['category']           = array_filter( $new_instance['category'] );        
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select Category:', 'wan' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
                <option value=""<?php selected( empty( $instance['category'] ) ); ?>><?php esc_html_e( 'All', 'wan' ); ?></option>
                <?php               
                $categories = get_categories();
                foreach ($categories as $category) {
                    printf('<option value="%1$s" %4$s>%2$s (%3$s)</option>', esc_attr($category->term_id), esc_attr($category->name), esc_attr($category->count), (($category->term_id == $instance['category'] )) ? 'selected="selected"' : '');
                }               

                ?>
            </select>
        </p>
		 <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'numpost' ) ); ?>"><?php esc_html_e( 'Limit Posts:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'numpost' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'numpost' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['numpost'] ); ?>">
        </p>
		 <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_per_row' ) ); ?>"><?php esc_html_e( 'Post Per Page:', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_per_row' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_per_row' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['post_per_row'] ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'readmore_link' ) ); ?>"><?php esc_html_e( 'More News Link', 'wan' ); ?></label>
            <div><i><?php _e('Add your link to overwrite auto generate More News link','wan');?></i></div>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['readmore_link'] ); ?>">
        </p>
         <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>"><?php esc_html_e( 'More News Text', 'wan' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['readmore_text'] ); ?>">
        </p>
    <?php
    }

}
function wan_register_recent_post() {
    register_widget( 'wan_Recent_Post' );
}
add_action( 'widgets_init', 'wan_register_recent_post' );
