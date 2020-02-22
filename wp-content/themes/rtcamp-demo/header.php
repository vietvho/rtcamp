<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package akha
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Preloader -->
<div class="preloader">
	<div class="clear-loading loading-effect-2">
		<span></span>
	</div>
</div>
<header class="header <?php echo apply_filters('wan_header_cls','');?>">
	<?php  
		do_action('wan_before_header');
		get_template_part('template-parts/header/header','top');
		get_template_part('template-parts/header/header','main');
		get_template_part('template-parts/header/header','bottom');
		do_action('wan_after_header');
	?>
	<div class="overlay main-overlay hide-mobile-menu"></div>
</header>
<?php do_action('wan/after_header');
?>

<div id="content" class="page-wrap">
