<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 *
 * @package akha
 */

get_header();
$page_layout = wan_choose_opt('page_layout');
wan_breadcrumb();
?>
<div class="page-container row <?php echo esc_attr($page_layout)." ".esc_attr(wan_choose_opt('layout_version'));?>">
	<?php if ($page_layout != 'no-sidebar') { ?>
		<?php
			$sidebar_cls = "sidebar blog-sidebar ";
			if ($page_layout == 'sidebar-right')  {
				$sidebar_cls .= 'px-15  order-1 ';
			}
			wan_dynamic_sidebar(wan_choose_opt('page_sidebar_list'),$sidebar_cls.wan_get_sidebar_cls('gsidebar_cls'));?>
	<?php } ?>
	<?php $cls = $page_layout != 'no-sidebar' ? wan_get_sidebar_cls('gcontent_cls','col-md-8') : 'col px-0'; ?>
	<div id="primary" class="content-area <?php echo esc_attr($cls);?>">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
