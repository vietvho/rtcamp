<?php if(wan_choose_opt('bottom_enabled')==true) {
  $bottom_cls = apply_filters('wan/bottom_cls',wan_choose_opt('btheader_container'));
  ?>
  <div id="bottom-bar" class="header-bottom hidden-md-down <?php echo esc_attr($bottom_cls);?>">
      <div class="row bottom-height align-items-center">
        <?php wan_dynamic_sidebar('header-bottom','px-15',sprintf('<div class="widget"><a href="%1$s">%2$s</a></div>',admin_url('customize.php?autofocus[section]=sidebar-widgets-topbar-right'),__('Add Top Bar Right Elements','wan')),true);?>
      </div><!-- .flex-row -->
  </div><!-- #header-top -->
<?php } ?>
