<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package akha
 */

get_header();
$page_layout = wan_choose_opt('blog_layout');
wan_breadcrumb();

?>
<div class="pt-40 <?php echo esc_attr(wan_choose_opt('layout_version')).' '.$page_layout;?> row ">
	<?php if ($page_layout != 'no-sidebar') { ?>
		<?php
			$sidebar_cls = "sidebar blog-sidebar ";
			if ($page_layout == 'sidebar-right')  {
				$sidebar_cls .= 'px-15  order-1 ';
			}
			wan_dynamic_sidebar(wan_choose_opt('page_sidebar_list'),$sidebar_cls.wan_get_sidebar_cls('gsidebar_cls'));?>
	<?php } ?>
	<div id="primary" class="content-area py-20 col">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content-single' );
			get_template_part( 'template-parts/author-bio' );
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			if (wan_choose_opt('show_post_navigator') == true) {
				the_post_navigation(['prev_text'=>'<i class="fa fa-caret-left" aria-hidden="true"></i><span>'.__('%title','wan').'</span>','next_text'=>'<span>'.__('%title','wan').'</span><i class="fa fa-caret-right" aria-hidden="true"></i>']);
			}

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	
</div>
<?php if (wan_choose_opt('show_related_post') == true) {
	get_template_part('template-parts/related-post');
}
get_footer();
