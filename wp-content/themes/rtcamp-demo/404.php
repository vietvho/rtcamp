<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package akha
 */

get_header();
$page_layout = wan_choose_opt('page_layout');
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
	<div id="primary" class="content-area col">
		<main id="main" class="site-main">
			<section class="error-404 not-found text-center">
				<span class="header-font" style="font-size: 8em; font-weight: bold; opacity: .3">404</span>
				<h1 class="page-title mt-0" style="font-size: 2em;"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wan' ); ?></h1>
				<div class="page-content mb-40">
					<p class="mb-40"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wan' ); ?></p>
					<?php
					get_search_form();	?>				
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();?>
