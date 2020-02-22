<?php $hmcls = apply_filters('wan_filter_hmcls',['pr-15','px-15 d-inline-block flex-grow-1','pl-15 d-inlineblock ml-auto text-right']);?>
<div id="header-main" class="header-main <?php do_action('wan_header_main_cls');?>">
    <div class="row justify-content-between align-items-center align-items-lg-end py-5 pb-lg-20 middle_height">
      <div class="d-inline-block logo <?php echo esc_attr($hmcls[0]);?>">
          <?php wan_render_logo();?>
      </div><!-- flex-col left -->
      <?php if (wan_choose_opt('show_tagline') == true) {
        echo '<div class="site-desc">'.get_bloginfo('description').'</div>';
      } ?>
      <?php 
      $btn_cls[]= wan_choose_opt('menu_hide_on');
      $btn_cls[] = wan_choose_opt('mobile_btn_scheme');
      $btn_cls[] = wan_create_btn_style(wan_choose_opt('mobile_btn_style'));
      $btn_cls = implode(' ',$btn_cls);
      $btn = sprintf('<div class="button-menu button %1$s" href="javascript:void(0)"><i class="fa fa-bars"></i></div>',$btn_cls);?>
      <?php wan_dynamic_sidebar('header-right',esc_attr($hmcls[2]),sprintf('<div class="widget hidden-sm-down"><a href="%1$s">%2$s</a></div>',admin_url('customize.php?autofocus[section]=sidebar-widgets-header-right'),__('Add Header Right Elements','wan')),true,$btn);?>
    </div><!-- .flex-row -->
    <?php 
    $_btn='<a class="fa fa-close close" href="javascript:void(0)"></a>';
    wan_dynamic_sidebar('hamburger-menu','hamburger-menu',sprintf('<div class="widget pl-10 just-icon widget_search">%1$s</div><div class="widget px-10"><a href="%2$s">%3$s</a></div>',get_search_form(false),admin_url('customize.php?autofocus[section]=sidebar-widgets-hamburger-menu'),__('Add Header Mobile Elements','wan')),true,$_btn);?>
</div><!-- #header-top -->
