<?php if(wan_choose_opt('topbar_enabled')==true) {
  $topbar_cls = apply_filters('wan/topbar_cls',wan_choose_opt('topbar_container'));
  ?>
  <div id="top-bar" class="header-top <?php echo esc_attr($topbar_cls);?>">
      <div class="row topbar-height align-items-end">
        <?php wan_dynamic_sidebar('topbar-right','pl-15 ml-auto text-right',sprintf('<div class="widget"><a href="%1$s">%2$s</a></div>',admin_url('customize.php?autofocus[section]=sidebar-widgets-topbar-right'),__('Add Top Bar Right Elements','wan')),true);?>
      </div><!-- .flex-row -->
  </div><!-- #header-top -->
<?php } ?>
