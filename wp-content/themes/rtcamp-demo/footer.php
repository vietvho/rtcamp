<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package akha
 */

?>

	</div><!-- #content -->
</div><!-- #page -->
<footer id="footer" class="<?php echo esc_attr(wan_get_opt('footer_container'));?>">
	<div class="row footer-top">
	    <?php 
		    $top_footers = wan_get_opt('top_footers_widgets');
		    $top_footers = explode("\n", $top_footers);
		    foreach ($top_footers as $id=>$name):
				wan_dynamic_sidebar(sprintf( 'top-footer-%s', ($id+1)),$name,sprintf('<div class="widget"><a href="%1$s">%2$s</a></div>',admin_url('customize.php?autofocus[section]=sidebar-widgets-top-footer-'.($id+1)),sprintf(__('Add Top Footer %s Elements','wan'),$id+1)),true);
		    
	    	endforeach;
		?>
	</div>
	<div class="row footer-middle">
	    <?php 
		    $center_footers = wan_get_opt('center_footers_widgets');
		    $center_footers = explode("\n", $center_footers);
		    foreach ($center_footers as $id=>$name):
		    	echo '<div class="'.$name.'">';
			       dynamic_sidebar(sprintf( 'center-footer-%s', ($id+1)));
			    echo '</div>';
	    	endforeach;
		?>
	</div>
	
</footer>
<div id="bottom" class="row footer-bottom <?php echo esc_attr(wan_get_opt('footer_container'));?>">
    <?php 
	    $bottom_footers = wan_get_opt('bottom_footers_widgets');
	    $bottom_footers = explode("\n", $bottom_footers);
	    foreach ($bottom_footers as $id=>$name):
			$info = $id==1 ? '<span class="xsmall">© '.date('Y').' Web Monarchy. All right reserved</span>' : sprintf(__('Add Bottom Footer %s Elements','wan'),$id+1);
			wan_dynamic_sidebar(sprintf( 'bottom-footer-%s', ($id+1)),$name,sprintf('<div class="widget"><a href="%1$s">%2$s</a></div>',admin_url('customize.php?autofocus[section]=sidebar-widgets-bottom-footer-'.($id+1)),$info),true);	    
    	endforeach;
	?>
</div>
<?php wp_footer(); ?>

</body>
</html>
