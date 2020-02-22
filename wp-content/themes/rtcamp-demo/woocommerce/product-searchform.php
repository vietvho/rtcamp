<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$icon = apply_filters('search_icon','<i class="fa fa-search"></i>');
?>
<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'wan' ); ?></label>
	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'wan' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<?php wp_dropdown_categories(['taxonomy'=>'product_cat','hide_empty'=>0,'name'=>'product_cat','value_field'=>'slug','selected'=>isset($_GET['product_cat'])?$_GET['product_cat']:'','show_option_all'=>__('Select Category','wan')])?>
	<?php  
	echo '<button>'.$icon.'<span>'.esc_attr__('Search','wan').'</span></button>';?>
	<input type="hidden" name="post_type" value="product" />
</form>
