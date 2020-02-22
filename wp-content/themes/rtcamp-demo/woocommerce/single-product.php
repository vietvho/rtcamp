<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 
$page_layout = wan_choose_opt('woosingle_layout');
?>
<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 */
			do_action( 'woocommerce_before_main_content' );
		?>
<div class="row wan-product-single pt-30 <?php echo esc_attr(wan_choose_opt('layout_version'));?>">
	<?php if ($page_layout != 'no-sidebar') { ?>
		<?php
			$sidebar_cls = "woocommerce-sidebar ";
			if ($page_layout == 'sidebar-right')  {
				$sidebar_cls .= 'order-1 ';
			} ?>
	<div class="<?php echo esc_attr($sidebar_cls.wan_get_sidebar_cls('woocommerce_sidebar_cls'));?>">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; 
	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
		do_action( 'woocommerce_sidebar' );
	echo '</div>'; 
	} 
	?>
	<div class="product-container col">
		

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
		
	</div>
</div>
<div class="extra-product-details <?php echo esc_attr(wan_choose_opt('layout_version'));?>">
	<div class="px-15">
		<?php do_action('woocommerce_extra_product_details');?>
	</div>
</div>
	<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>
		<?php echo do_blocks(get_the_content(null,false,get_option( 'woocommerce_shop_page_id' )));?>
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
