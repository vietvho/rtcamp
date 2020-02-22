<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package akha
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (!is_front_page() && wan_choose_opt('title_position') != 'none'):?>
		<?php the_title( '<h1 class="entry-title '.wan_choose_opt('title_position').'">', '</h1>' ); ?>
	<?php endif;?>
	<?php wan_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wan' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
