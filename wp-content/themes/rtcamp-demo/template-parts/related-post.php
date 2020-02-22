<?php
/**
 * The template for displaying archive pages
 *
 *
 * @package akha
 */
$atts = wan_prepare_archive();
$page_layout = $atts['page_layout'];
$blog_id= $atts['blog_id'];
$post_class= $atts['post_class'];
$container= $atts['container'];
$_columns= wan_choose_opt('related_post_columns');
$atts['_columns']=$_columns;
$_id = get_the_ID();
$args = array( 'category__in' => wp_get_post_categories($_id), 'posts_per_page' => wan_choose_opt('number_related_post'), 'post__not_in' => array($_id),) ;
$query = new WP_Query($args);
?>
<?php if ( $query->have_posts() ) : ?>
    <div class="<?php echo esc_attr($container);?>">
        <div class="px-15 pb-40">
            <?php
            printf('<div class="wan-section-title"><h2>%s</h2></div>',__('Related Post','wan'));
            echo '<div class="wan-post clearfix '.implode(' ', $post_class).'" data-items="'.$_columns.'"  >';  // style="'.esc_attr($css).'"
            echo '<div class="post-container d-flex flex-wrap" data-items="'.$_columns.'" >';     
            /* Start the Loop */
            while ( $query->have_posts() ) :
                $query->the_post();

                /*
                    * Include the Post-Type-specific template for the content.
                    * If you want to override this in a child theme, then include a file
                    * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                    */
                echo wan_prepare_post_content($atts);
            endwhile;
            echo '</div>';
            ?>
        </div>
    </div>
</div>
<?php endif;
wp_reset_postdata();
?>
