<?php
/**
 * The template for displaying archive pages
 *
 *
 * @package akha
 */
get_header();
$atts = wan_prepare_archive();
$container = $atts['container'];
$page_layout = $atts['page_layout'];
$blog_id= $atts['blog_id'];
$post_class= $atts['post_class'];
$_columns= $atts['_columns'];
$title_pos = wan_choose_opt('title_position');
?>
<?php wan_breadcrumb();?>
	<div class="page-header <?php echo esc_attr($container);?>">
		<?php
		if ($title_pos != 'none'):
			if (is_home()) {
				if (is_front_page()){
					printf('<h1 class="page-title px-15 %1$s">%2$s</h1>',wan_choose_opt('title_position'),__('POSTS','wan'));
				}
				else {
					printf('<h1 class="page-title px-15 %1$s">%2$s</h1>',wan_choose_opt('title_position'),get_the_title($blog_id));
				}
			}
			else {
				the_archive_title( '<h1 class="page-title px-15 '.wan_choose_opt('title_position').'">', '</h1>' );
				the_archive_description( '<div class="archive-description px-15">', '</div>' );
			}
		endif;
		?>
	</div><!-- .page-header -->

<div class="pb-50 <?php echo esc_attr($page_layout)." ".esc_attr($container);?> row ">
	<?php if ($page_layout != 'no-sidebar') { ?>
		<?php
			$sidebar_cls = "wan-sidebar blog-sidebar ";
			if ($page_layout == 'sidebar-right')  {
				$sidebar_cls .= 'px-15 order-1 ';
			}
			wan_dynamic_sidebar(wan_choose_opt('blog_sidebar_list'),$sidebar_cls.wan_get_sidebar_cls('gsidebar_cls'));?>
	<?php } ?>
	<div id="primary" class="content-area col">
		<main id="main" class="site-main">
		<?php if ( have_posts() ) : ?>
			<?php
			echo '<div class="wan-post clearfix '.implode(' ', $post_class).'" data-items="'.$_columns.'"  >';  // style="'.esc_attr($css).'"
			echo '<div class="post-container d-flex flex-wrap" data-items="'.$_columns.'" >';     
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				echo wan_prepare_post_content($atts);
			endwhile;
			echo '</div>';
			wan_paginations();
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div>
<?php
get_footer();
