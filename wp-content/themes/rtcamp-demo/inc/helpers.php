<?php
/**
 * Return the built-in header styles for this theme
 *
 * @return  array
 */
function sanitize_sidebar_widgets( $widget_ids ) {
	$widget_ids           = array_map( 'strval', (array) $widget_ids );
	$sanitized_widget_ids = array();
	foreach ( $widget_ids as $widget_id ) {
		$sanitized_widget_ids[] = preg_replace( '/[^a-z0-9_\-]/', '', $widget_id );
	}
	return $sanitized_widget_ids;
}
function wan_get_stock_html(){
	global $product;
	echo '<div class="stock-container">';
		echo '<label>'.__('Availability: ','wan').'</label>';
		echo wc_get_stock_html($product);
	echo '</div>';
}

if (!function_exists('wan_trim_words')) {
	function wan_trim_words($text,$length=30) {
        if (has_blocks($text)) {
            $blocks = parse_blocks( $text );
            $content = '';
            foreach ($blocks as $block) {
                if ($block['blockName'] == 'core/paragraph') {
                        $content .= $block['innerHTML'];
                }
            }
            $text = $content;
        }
        $text = wp_strip_all_tags($text);
		return wp_trim_words($text,(int)$length);
	}
}
function wan_render_percent($val,$max){
	$max = max(1,$max);
	return ($val/$max*100).'%';
}
function wan_get_style($style) {
	return str_replace('italic', 'i', $style);
}
function wan_get_meta($meta){
	return get_post_meta(get_the_ID(),$meta,true);
}
Class wan_options_helpers {
	public function recognize_control_class( $name ) {
        $segments = explode( '-', $name );
        $segments = array_map( 'ucfirst', $segments );
        
        return implode( '', $segments );
    }
}
add_action('wpcf7_init', 'wan_wpcf7_time_picker');
function wan_wpcf7_time_picker()
{
    wpcf7_add_form_tag('time', 'wan_wpcf7_time_picker_handle', true);
}
if(!function_exists('wan_wpfilesystem')) {

	function wan_wpfilesystem(){
		require_once(ABSPATH . 'wp-admin/includes/file.php');
	}
}
function wan_customizer_image_size_options(){
	$imgsizes = get_image_sizes();
    foreach ($imgsizes as $key => $value) {
		$crop = $value['crop'] == true ? ' - crop' : '';
        $imgdata[$key] = $value['width'].'x'.$value['height'].$crop;
    }
	return $imgdata;
}
if (!function_exists('get_image_sizes')):
function get_image_sizes() {
    global $_wp_additional_image_sizes;
    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }

    return $sizes;
}
endif;

function wan_autoname($str){
	return ucfirst(implode(' ',explode('-',$str)));
}
function wan_htags_list() {
	foreach(['h2','h3','h4','h5','h6'] as $tag) {
		$arr[$tag] = wan_autoname($tag);
	}
	return $arr;
}
function wan_btn_scheme(){
	$colors = apply_filters('wan/btn_scheme',['primary','secondary','success','alert']);
	foreach ($colors as $color){
		$output[$color]=wan_autoname($color);
	}
	return $output;
}
function wan_create_btn_style($style){
	$cls = '';
	switch ($style) {
		case 'square-outline':
			$cls = 'square outline';
			break;
		case 'circle-outline':
			$cls = 'rounded-circle outline';
			break;
		case 'border-0':
			$cls = 'border-0 text';
			break;
		default:
			$cls = $style;
			break;
	}
	return $cls;
}
function wan_arr_responsive_utilities($case='down'){
	$arr = [
		''	=> 'Normal',
		'hidden-xs-'=> 'Portrait phones',
		'hidden-sm-'=> 'Landscape phones',
		'hidden-md-'=> 'Tablets',
		'hidden-lg-'=> 'Desktops (<1200px)',
		// 'hidden-xl-'=> 'Desktops (>=1200px)',
	];
	$output = [];
	foreach($arr as $key=>$screen){
		if ($key !='') {
			$output[$key.$case]=$screen;
		}
		else {
			$output[]=$screen;
		}
	}
	return $output;
}

add_action('in_widget_form','wan_in_widget_form',20,3);
function wan_in_widget_form($widget,$return,$instance){
	$id    = $widget->get_field_id( 'class' );
	$name  = $widget->get_field_name( 'class' );
	$class = isset($instance['class']) ? $instance['class'] : (isset($widget->widget_options['class'])?$widget->widget_options['class']:'');
	$divider = ['none','border','border-vertical','border-horizontal','divider-small-vertical','divider-normal-vertical','divider-horizontal'];
	$divcolor = ['dark','light'];
	$sborder = isset($instance['sborder'])?$instance['sborder']:['none'];
	$objEnable=['widget_archives','widget_categories','widget_meta','widget_widget_wan_login','widget_widget_wan_minicart','widget_nav_menu','widget_pages','widget_recent_entries','widget_tag_cloud'];
	echo '<h3>Border/Divider:</h3>';
	echo '<select name="divider_style" class="mb-1">';
		foreach ($divider as $_item){
			$divstyle = isset($instance['divider_style']) ? $instance['divider_style'] : 'none';
			$selected = $_item == $divstyle ? 'selected="selected"' :'';
			printf('<option value="%1$s" %3$s>%2$s</option>',esc_attr($_item),wan_autoname($_item),$selected);
		}
	echo '</select>';
	if(in_array($widget->option_name,$objEnable)):
		$selected = (isset($instance['inlist'])&&$instance['inlist']!='')?'checked="checked"':'';
		printf('<div class="mr-1 mb-1"><input type="checkbox" name="inlist" value="list-divider" %1$s/>%2$s</div>',$selected,__('List item small divider','wan'));
	endif;
	echo '<h4>Border/Divider Color:</h4>';
	$_divcolor = isset($instance['divcolor'])?$instance['divcolor']:'dark';
	foreach ($divcolor as $_item){
		$selected = $_item == $_divcolor ? 'checked="checked"' :'';
		printf('<div class="d-inline-block mr-1 mb-1"><input type="radio" name="divcolor" value="%1$s" %2$s/>%3$s</div>',esc_attr($_item),$selected,wan_autoname($_item));
	}
	$objDropdown = ['widget_nav_menu','widget_widget_wan_login','widget_widget_wan_minicart'];
	if (in_array($widget->option_name, $objDropdown)) {
		echo "<h3>".__('Dropdown Position','wan').":</h3>";
		$dropdown_position = (!isset($instance['dropdown_position']) || $instance['dropdown_position'] == '') ? 'dropdown-center':$instance['dropdown_position'];
		echo '<select name="dropdown_position" class="mb-1">';
			foreach(['dropdown-left','dropdown-center','dropdown-right'] as $key) {
				$selected = $key == $dropdown_position ? 'selected="selected"' :'';
				printf('<option value="%1$s" %3$s>%2$s</option>',esc_attr($key),wan_autoname($key),$selected);
			}
		echo '</select>';
	}
	if(in_array($widget->option_name,$objEnable)):
		echo "<h3>".__('Links Effect','wan').":</h3>";
		$links = wan_demo_links();	
		$wg_link_style = (!isset($instance['wg_link_style']) || $instance['wg_link_style'] == '') ? 'wan-ef-1':$instance['wg_link_style'];
		foreach($links as $opt=> $link) {
			$selected = $opt == $wg_link_style ? 'checked="checked"' :'';
			printf('<div><label><input type="radio" name="wg_link_style" value="%1$s" %3$s></label>%2$s</div>',$opt,$link,$selected);
		}
		echo '<div class="mt-1"<strong><a  href="#" title="'.__('lp-x, lpl-x, lpt-x, lpr-x, lpb-x:padding(left,top,right,bottom)-x.','wan').' &#013; '.__('Example: lpl-15: Link padding-left 15px. ','wan').' &#013; '.__('Support Numbers: ','wan').'0 10 12 15 18 20 25 30 40 50">'.__('Link Class Tips','wan').'</a></strong></div>';
	endif;
	$objSearch = ['widget_search','widget_woocommerce_product_search'];
	if (in_array($widget->option_name, $objSearch)) {
		echo "<h3>".__('Button Style','wan').":</h3>";
		$wsbtn_style = (!isset($instance['wsbtn-style']) || $instance['wsbtn-style'] == '') ? 'sbtn-bg':$instance['wsbtn-style'];
		foreach(['sbtn-bg','sbtn-outline','sbtn-transpaprent'] as $opt) {
			$selected = $opt == $wsbtn_style ? 'checked="checked"' :'';
			$link = '<button><i class="fa fa-search"></i></button>';
			printf('<div class="%1$s d-inline-block pb-1 mr-1"><input type="radio" name="wsbtn-style" value="%1$s" %3$s>%2$s</div>',$opt,$link,$selected);
		}
		echo "<h3>".__('Button Element','wan').":</h3>";
		$wsbtn_el = (!isset($instance['wsbtn-el']) || $instance['wsbtn-el'] == '') ? 'just-icon':$instance['wsbtn-el'];
		echo '<select name="wsbtn-el" class="mb-1">';
			foreach(['just-icon','just-text','both']  as $key) {
				$selected = $key == $wsbtn_el ? 'selected="selected"' :'';
				printf('<option value="%1$s" %3$s>%2$s</option>',esc_attr($key),wan_autoname($key),$selected);
			}
		echo '</select>';
	}
	echo "<h3>".__('Responsive utilities','wan').":</h3>";
	echo "<h4>".__('Hide on screen Less than or Equal','wan').":</h4>";
	$res_utilities = (!isset($instance['res_utilities']) || $instance['res_utilities'] == '') ? '':$instance['res_utilities'];
	echo '<select name="res_utilities" class="mb-1">';
		foreach(wan_arr_responsive_utilities() as $key => $value) {
			$selected = $key == $res_utilities ? 'selected="selected"' :'';
			printf('<option value="%1$s" %3$s>%2$s</option>',esc_attr($key),$value,$selected);
		}
	echo '</select>';
	echo '<p><label>'.esc_html__('Custom Class','wan').'</label><input id="'.$id.'" type="text" name="'.$name.'" class="widefat" value = "'.$class.'"></input></p>';
	return $return;
}

add_filter('widget_update_callback','wan_update_callback',20,4);
function wan_update_callback($instance,$new_instance,$old_instance){
	$options = ['dropdown_position','res_utilities'];
	$instance['class'] = $new_instance['class'];
	$instance['wg_link_style'] = isset($_POST['wg_link_style']) ? $_POST['wg_link_style']: '';
	$instance['wsbtn-style'] = isset($_POST['wsbtn-style']) ? $_POST['wsbtn-style']: 'just-icon';
	$instance['wsbtn-el'] = isset($_POST['wsbtn-el']) ? $_POST['wsbtn-el']: '';
	$instance['sborder'] = isset($_POST['sborder']) ? $_POST['sborder']: [];
	$instance['divider_style'] = isset($_POST['divider_style']) ? $_POST['divider_style']: 'none';
	$instance['divcolor'] = isset($_POST['divcolor']) ? $_POST['divcolor']: 'dark';
	$instance['inlist'] = isset($_POST['inlist']) ? $_POST['inlist']: '';
	foreach ($options as $option){
		$instance[$option] = isset($_POST[$option]) ? $_POST[$option]: '';
	}
	$cls_options = ['class','wg_link_style','res_utilities'];
	$tmp = explode(' ', $instance['classname']);
	$cls[]= $tmp[0];
	foreach ($cls_options as $option){
		$cls[]=$instance[$option];
	}
	$instance['classname'] =implode(' ',$cls);
	
	return $instance;
}

add_filter('widget_display_callback','wan_widget_display_callback',10,3);
function wan_prepare_archive($ex_args=[]) {
	$tiles = array('post-masonry-tiles','post-grid-tiles');
	$layout_cls = [
		'wan-grid-tile' => 'wan-grid tiles',
		'wan-masonry-tile' => 'wan-grid masonry tiles'
	];
	$post_style = wan_choose_opt('blog_style');
	$columns_spaces = wan_choose_opt('blog_columns_spaces');
	$_columns = wan_choose_opt('blog_grid_columns');
	$item_class = [$post_style];
	$tiles = false;
	$post_class =[$post_style,"grid-$columns_spaces"];
	if (isset($layout_cls[$post_style])) {
		$post_class[] = $layout_cls[$post_style] ;
		$tiles = true;
	}
	if (wan_choose_opt('blog_archive_show_zoom_btn') === true){
		$post_class[] = 'show_zoom_btn';
	}
	$colCls = [1 => ' col-12', 2 => ' col-xs-12 col-sm-6', 3 => ' col-xs-12 col-sm-4', 4 => ' col-xs-12 col-md-6 col-lg-3'];
	if (isset($columns_spaces) && $columns_spaces != '' && $columns_spaces != '30px') {
		$item_class[] = "wan-$columns_spaces";
	}
	$atts=['colCls'=>$colCls,'tiles'=>$tiles,'post_type'=>get_post_type(),'_columns'=>$_columns,'post_style'=>wan_choose_opt('blog_style'),'text_scale'=>wan_choose_opt('blog_text_scales'),'title_tag'=>wan_choose_opt('blog_archive_htag'),'show_dates'=>wan_choose_opt('blog_archive_show_date'),'show_zoom_btn'=>wan_choose_opt('blog_archive_show_zoom_btn'),'thumb_size'=>wan_choose_opt('blog_thumbnail_size'),'show_title'=>wan_choose_opt('blog_archive_show_title'),'show_cat'=>wan_choose_opt('blog_archive_show_category'),'show_content'=>wan_choose_opt('blog_archive_show_content'),'readmore_text'=>wan_choose_opt('blog_archive_readmore_text'),'show_metas'=>wan_choose_opt('blog_archive_show_metas'),'content_length'=>wan_choose_opt('blog_archive_post_excepts_length'),'metas'=>wan_choose_opt('blog_archive_metas')];
	$blog_id =  get_option( 'page_for_posts' );

	if (is_home()){
		$page_layout = wan_choose_opt('page_layout',$blog_id);
		$container = wan_choose_opt('layout_version',$blog_id);	
	}
	else {
		$page_layout = wan_choose_opt('blog_layout');
		$container = wan_choose_opt('layout_version');
	}
	$atts['page_layout']= $page_layout;
	$atts['container']=$container;
	$atts['blog_id'] = $blog_id;
	$atts['post_class'] = $post_class;
	return array_merge($atts,$ex_args);
}
function wan_widget_display_callback($instance,$widget,$args){
  if (!isset($instance['class'])) {
        return $instance;
	}
    $class = [];
    $widget_classname = $widget->widget_options['classname'];
    $enable = ['class','wg_link_style','dropdown_position','wsbtn-style','divider_style','divcolor','inlist','wsbtn-el','res_utilities'];
	foreach ($enable as $value) {
	    if (isset($instance[$value])){
	    	$class[]=$instance[$value];
		}
	}
	if (isset($instance['sborder'])) {
		$class[] = implode(' ',$instance['sborder']);
	}
	$class = implode(' ', $class);
    $args['before_widget'] = str_replace($widget_classname, "{$widget_classname} {$class}", $args['before_widget']);
    $widget->widget($args, $instance);

    return false;
}

function wan_wpcf7_time_picker_handle($tag)
{
    $tag = new WPCF7_FormTag($tag);
    if (empty($tag->name)) {
        return '';
    }
    $atts = array();
    $class = wpcf7_form_controls_class($tag->type);
    $atts['class'] = $tag->get_class_option($class);
    $atts['id'] = $tag->get_id_option();
    $value = (string) reset($tag->values);
    $value = $tag->get_default_option($value);
    $atts['value'] = $value;
    $atts['type'] = 'text';
    $atts['name'] = $tag->name;
    $atts = wpcf7_format_atts($atts);
    wp_enqueue_script('bootstrap-timepicker');
    $html = sprintf('<input %s />', $atts);
    return $html;
}
function wan_add_icons($icon_name='fa',$url='') {
    $icons = '';
    if ($url != '') {
       $fontContent = wp_remote_get( $url, array('sslverify'   => false) );
       if (!is_wp_error($fontContent)){
           $pattern = sprintf('/\.([\A%s].*?)\:/',$icon_name);
           preg_match_all($pattern, $fontContent['body'],$tmp_icons);
           $icons = $tmp_icons[1];
       }
    }

    return $icons;
}

function wan_choose_single_thumb() {
	global $scheme;
	switch ($scheme) {
		case 'default':
			$wan_thumbnail = 'wan-blog-single';
			break;
		
		default:
			$wan_thumbnail = 'wan-blog-single';
			break;
	}
	return $wan_thumbnail;
}

function wan_entity_decode($text) {
	return html_entity_decode($text,ENT_QUOTES,'UTF-8');
}

function wan_image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){
    if(!$crop)
			return null; // let the wordpress default function handle this

		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
	
		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);
	
		$s_x = floor( ($orig_w - $crop_w) / 2 );
		$s_y = floor( ($orig_h - $crop_h) / 2 );

		if(is_array($crop)) {

			//Handles left, right and center (no change)
			if($crop[ 0 ] === 'left') {
				$s_x = 0;
			} else if($crop[ 0 ] === 'right') {
				$s_x = $orig_w - $crop_w;
			}

			//Handles top, bottom and center (no change)
			if($crop[ 1 ] === 'top') {
				$s_y = 0;
			} else if($crop[ 1 ] === 'bottom') {
				$s_y = $orig_h - $crop_h;
		}
	
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

add_filter('image_resize_dimensions', 'wan_image_crop_dimensions', 10, 6);

function wan_custom_enqueue() {
	$blog_style = wan_choose_opt('blog_style');
	$portfolio_style = wan_choose_opt('portfolio_archive_style');
	$masonry = array('blog-masonry','blog-masonry-tile','portfolio-masonry','portfolio-masonry-tiles');
	if (in_array($blog_style,$masonry) == 1 || in_array($portfolio_style,$masonry) == 1) {
		wp_enqueue_script('wan-masonry');
		wp_enqueue_script('wan-isotope-packery');
	}
}

function wan_content() {
	if (function_exists('mw_register')) {
		add_filter('the_content','wan_page_content');
	}
	else {
		the_content();
	}
}
function wan_page_content($content) {
	return $content;
}
function wan_enable_gutenberg_post_ids($can_edit, $post) {
    if ($post->post_type != 'page') return false;
	if (in_array(get_page_template_slug($post->ID), ['collection.php','tpl/front-page.php'])) {
		return $can_edit;
	}
	return false;
	
}
// add_filter('use_block_editor_for_post', 'wan_enable_gutenberg_post_ids', 10, 2);
function wan_admin_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' );   
    wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
 
}

if (!function_exists('wan_render_dimensions')) {
	function wan_render_dimensions($val,$scale=1,$unit=array('px','%','em')) {
		$_unit = str_replace(floatval($val), '', $val);
    return in_array($_unit, $unit) ? $val : $val.'px';
}
}
if (!function_exists('wan_scale_dimensions')) {
	function wan_scale_dimensions($val,$scale=1) {
		$fval = floatval($val);
		$unit = str_replace($fval, '', $val);
		$fval = $fval*$scale;
		$val  = $fval.$unit;
		return wan_render_dimensions($val);
   	}
}
function wan_custom_mime_types( $mimes ) {
 
	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
	}
add_filter( 'upload_mimes', 'wan_custom_mime_types' );
function wan_render_box_control($name,$control=array(),$id) {
    add_action('admin_enqueue_scripts','wan_admin_color_picker');
    $default = array(
        'margin-top' => '',
        'margin-bottom' => '',
        'margin-left' => '',
        'margin-right' => '',
        'padding-top' => '',
        'padding-bottom' => '',
        'padding-left' => '',
        'padding-right' => '',
        'border-top-width' => '',
        'border-bottom-width' => '',
        'border-left-width' => '',
        'border-right-width' => '',
        );
    $controls = wan_decode($control);
    if (!is_array($controls)){ $controls = array();};
    $controls = array_merge($default,$controls);
    ?>
<div class="wan_box_control">
    <div class="wan_box_position">
        <div class="wan_box_margin">
            <label class="wan_box_label"><?php echo esc_html('Margin');?></label>
            <input placeholder="-" data-position='margin-top' value ="<?php wan_esc_attr($controls['margin-top']);?>" class="top" type="text"/>
            <input placeholder="-" data-position='margin-bottom' value ="<?php wan_esc_attr($controls['margin-bottom']);?>" class="bottom" type="text"/>
            <input placeholder="-" data-position='margin-left' value ="<?php wan_esc_attr($controls['margin-left']);?>" class="left" type="text"/>
            <input placeholder="-" data-position='margin-right' value ="<?php wan_esc_attr($controls['margin-right']);?>" class="right" type="text"/>
        </div>

        <div class="wan_box_padding">
            <label class="wan_box_label"><?php echo esc_html('Padding');?></label>
            <input placeholder="-" data-position='padding-top' value ="<?php wan_esc_attr($controls['padding-top']);?>" class="top" type="text"/>
            <input placeholder="-" data-position='padding-bottom' value ="<?php wan_esc_attr($controls['padding-bottom']);?>" class="bottom" type="text"/>
            <input placeholder="-" data-position='padding-left' value ="<?php wan_esc_attr($controls['padding-left']);?>" class="left" type="text"/>
            <input placeholder="-" data-position='padding-right' value ="<?php wan_esc_attr($controls['padding-right']);?>" class="right" type="text"/>
        </div>

    <div class="wan_box_border">
            <label class="wan_box_label"><?php echo esc_html('Border');?></label>
        <input placeholder="-" data-position='border-top-width' value ="<?php wan_esc_attr($controls['border-top-width']);?>" class="top" type="text"/>
        <input placeholder="-" data-position='border-bottom-width' value ="<?php wan_esc_attr($controls['border-bottom-width']);?>" class="bottom" type="text"/>
        <input placeholder="-" data-position='border-left-width' value ="<?php wan_esc_attr($controls['border-left-width']);?>" class="left" type="text"/>
        <input placeholder="-" data-position='border-right-width' value ="<?php wan_esc_attr($controls['border-right-width'])?>" class="right" type="text"/>
    </div>
    <div class="wan_control_logo"></div>
    </div>
</div>
<input name="<?php echo esc_attr($name);?>" data-customize-setting-link="<?php echo  esc_attr($id);?>" value="<?php esc_attr(json_encode($controls));?>" type="hidden"/>
<?php }

function wan_color_picker_control($title,$control) { 
    $output = '<span class="wan-options-control-title">'. esc_html($title).'</span>
                <div class="background-color">
                    <div class="wan-options-control-color-picker">
                        <div class="wan-options-control-inputs">
                            <input type="text" class="wan-color-picker" id="'. esc_attr( $control['name'] ) .'-color" name="'. esc_attr($control['name']).'" data-default-color value="'. esc_attr( $control['color'] ) .'" />
                        </div>
                    </div>
                </div>';
    return $output;
   
}

function wan_render_border_style() {
    $border_style = array(
        'none' => esc_html__('None','wan'),
        'hidden' => esc_html__('Hidden','wan'),
        'dotted' => esc_html__('Dotted','wan'),
        'dashed' => esc_html__('Dashed','wan'),
        'solid' => esc_html__('Solid','wan'),
        'double' => esc_html__('Double','wan'),
        'groove' => esc_html__('Groove','wan'),
        'ridge' => esc_html__('Ridge','wan'),
        'inset' => esc_html__('Inset','wan'),
        'outset' => esc_html__('Outset','wan')
        );
    $output = '<label class="wan_control_title">Border Style</label>
                <select class="themes_wan_border-style">';
            foreach ($border_style as $key => $value ) {
                $output .= '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
            }
     $output       .= '</slect>';
     return $output;
}

function wan_shortcode_icon_name($prefix,$icon_type,$atts=array()) {
    $icon_name = '';
    if (function_exists('visual_composer')){
	    if ($icon_type != 'none') {
	        $icon_name  = "{$prefix}_{$icon_type}";
	        wp_enqueue_style('vc_'.$icon_type);
	    }
		$icon_value = $icon_name != '' ? $atts[$icon_name] : ''; 
	}
	else {
        $icon_name  = "{$prefix}_icon_type";
        if (isset($atts[$icon_name])) {
			$icon_type = $atts[$icon_name];
			if ($icon_type!='none') {
		        wp_enqueue_style("mw_font_$icon_type",saviKIT_URL."assets/css/cssfonts/{$icon_type}.css");
		    }
	    }
		$icon_value = $icon_name != '' ? $atts[$prefix] : ''; 
    }
    return $icon_value;
}

/**
 * Register Backend and Frontend CSS Styles
 */
add_action( 'vc_base_register_front_css', 'wan_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'wan_vc_iconpicker_base_register_css' );
function wan_vc_iconpicker_base_register_css(){
    wp_register_style('vc_iconsfo', WAN_LINK. 'css/fo.css');
    wp_register_style('vc_simpleline', WAN_LINK. 'css/simple-line-icons.css');
}

/**
 * Enqueue Backend and Frontend CSS Styles
 */
add_action( 'vc_backend_editor_enqueue_js_css', 'wan_vc_iconpicker_editor_jscss' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'wan_vc_iconpicker_editor_jscss' );
function wan_vc_iconpicker_editor_jscss(){
    wp_enqueue_style( 'vc_iconsfo' );
    wp_enqueue_style( 'vc_simpleline' );
}
function wan_comment_title(){
	$title =  get_comments_number() . esc_html__( ' thoughts on ', 'wan' ).get_the_title();
	global $scheme;
	switch ($scheme) {
		case 'default':
			$title = get_comments_number() . esc_html__( ' Comments', 'wan' );
			break;
		
		default:
			$title = get_comments_number() . esc_html__( ' Comments', 'wan' );
			break;
	}
	return $title;
}
function WAN_ICONpicker_type_simpleline($icons) {
    $tmp_icon = wan_add_icons('icon',WAN_LINK.'css/simple-line-icons.css');
    foreach ($tmp_icon as $icon) {
        $iconname = str_replace('icon-', '', $icon);
        $iconname = ucwords(str_replace("-", " ", $iconname));
        $_icons[] = array($icon => $iconname);
    }

    return array_merge( $icons, $_icons );

}

add_filter( 'vc_iconpicker-type-simpleline', 'WAN_ICONpicker_type_simpleline' );

add_action( 'wp_ajax_reset_meta', 'wan_ajax_reset_meta' );

function wan_ajax_reset_meta() {
	$mode = isset($_POST['mode']) ? $_POST['mode'] : 'meta' ;
	$id = isset($_POST['id']) ? $_POST['id'] : get_the_ID();
	$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : wan_choose_opt('wan_skin',$id);
	echo (wan_customize_default_options2('',$scheme,true,$mode,$id));
    wp_die();
}

function wan_available_icons($name = 'icon' ) {
	$icon_types = array ($name.'_type'=>'fontawesome',$name.'_fontawesome' => '',$name.'_openiconic' => '',$name.'_typicons' => '',$name.'_entypo' => '',$name.'_linecons' => '',$name.'_monosocial' => '',$name.'_material' => '',$name.'_iconsfo' => '',$name.'_simpleline' => '');
	return  $icon_types;
}

function wan_advance_meta($attr) {
	if (wan_meta($attr) == '') {
		return wan_customize_default_options2($attr);
	}
	else {		
		return 	wan_meta($attr);
	}
}

function wan_map_icons($name='icon',$heading_name = 'Icon') {
	return array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html( $heading_name.' library'),
				'value' => array(
                    esc_html__( 'None', 'wan' ) => 'none',
					esc_html__( 'Font Awesome', 'wan' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'wan' ) => 'openiconic',
					esc_html__( 'Typicons', 'wan' ) => 'typicons',
					esc_html__( 'Entypo', 'wan' ) => 'entypo',
					esc_html__( 'Linecons', 'wan' ) => 'linecons',
					esc_html__( 'Mono Social', 'wan' ) => 'monosocial',
                    esc_html__( 'Material', 'wan' ) => 'material',
					esc_html__( 'Simple Line', 'wan' ) => 'simpleline',
				),
                'std' => 'none',
				'admin_label' => true,
				'param_name' => $name.'_type',
				'description' => esc_html__( 'Select icon library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html( $heading_name),
				'param_name' => $name.'_fontawesome',
				'value' => 'fa fa-adjust',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
                    'type' => 'fontawesome',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'fontawesome',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html( $heading_name),
                'param_name' => $name.'_simpleline',
                'value' => 'icon-user',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'simpleline',

                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => $name.'_type',
                    'value' => 'simpleline',
                ),
                'description' => esc_html__( 'Select icon from library.', 'wan' ),
                'integrated_shortcode_field' => $name.'_'
            ),
            
			array(
				'type' => 'iconpicker',
				'heading' => esc_html( $heading_name),
				'param_name' => $name.'_iconsfo',
				'value' => 'ifco ifco-bank',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'iconsfo',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'iconsfo',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_openiconic',
				'value' => 'vc-oi vc-oi-dial',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'openiconic',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_typicons',
				'value' => 'typcn typcn-adjust-brightness',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'typicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_entypo',
				'value' => 'entypo-icon entypo-icon-note',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'entypo',
				),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_linecons',
				'value' => 'vc_li vc_li-heart',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'linecons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'monosocial',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wan' ),
				'param_name' => $name.'_material',
				'value' => 'vc-material vc-material-cake',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'material',
				),
				'description' => esc_html__( 'Select icon from library.', 'wan' ),
				'integrated_shortcode_field' => $name.'_'
			),
		);
}

function wan_custom_button_color($color = '') {
    $color = $color == '' ? wan_get_opt( 'primary_color' ) : $color;
    return $color;
}
if (!function_exists('is_checked')) {
	function is_checked($key){
	    if ($key === 'yes' || $key ==1) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}

}
function wan_render_post($blog_layout,$length=50,$readmore = '') {
	
	if( strpos( get_the_content(), 'more-link' ) === false ) {
		echo '<div class="content">';
       	echo do_shortcode(wp_trim_words(get_the_content(),$length));
       	echo '</div>';

      
    }
    else {
    	if ($readmore != '') {
	        echo '<div class="content">';the_content('');echo '</div>';
	    }
	    else {
	        the_content();
	    }
    }
}

function wan_excerpt_more( $more ) {
    return '';
}

function wan_special_excerpt($length) {
	global $_length;
	return $_length;
}

function wan_predefined_header_styles() {
	static $styles;

	if ( empty( $styles ) ) {
		$styles = apply_filters( 'savi/header_styles', array(
			'header-v1' => esc_html__( 'Classic', 'wan' ),
			'header-v2' => esc_html__( 'Header style 02', 'wan' ),
			'header-v4' => esc_html__( 'Modern', 'wan' ),
		) );
	}

	return $styles;
}

/**
 * Render header style this theme
 *
 * @return  array
 */
function wan_render_header_styles() {
	static $header_style;
	
	if ( wan_meta( 'custom_header' ) == 1 ) {
		$header_style = wan_meta( 'header_style' );
	} else {
		$header_style = get_theme_mod( 'header_style', 'Header-v1' );
	}

	return $header_style;
}

function wan_available_social_icons() {
	$icons = apply_filters( 'wan_available_icons', array(
		'twitter'        => array( 'iclass' => 'fa-twitter', 'title' => 'Twitter','share_link' => 'https://twitter.com/intent/tweet?url=' ),
		'facebook'       => array( 'iclass' => 'fa-facebook', 'title' => 'Facebook','share_link'=>'https://www.facebook.com/sharer.php?u=' ),
		/*'google-plus'    => array( 'iclass' => 'fa-google-plus', 'title' => 'Google Plus','share_link'=>'https://plus.google.com/share?url=' ),*/
		'pinterest'      => array( 'iclass' => 'fa-pinterest', 'title' => 'Pinterest','share_link' =>'https://pinterest.com/pin/create/bookmarklet/?url=' ),
		'instagram'      => array( 'iclass' => 'fa-instagram', 'title' => 'Instagram','share_link' => '' ),
		'youtube'        => array( 'iclass' => 'fa-youtube-play', 'title' => 'Youtube','share_link' =>'' ),
		'vimeo'          => array( 'iclass' => 'fa-vimeo-square', 'title' => 'Vimeo','share_link' =>'' ),
		'linkedin'       => array( 'iclass' => 'fa-linkedin', 'title' => 'LinkedIn','share_link' => 'https://www.linkedin.com/shareArticle?url=' ),
		'behance'        => array( 'iclass' => 'fa-behance', 'title' => 'Behance','share_link' =>'' ),
		'bitcoin'        => array( 'iclass' => 'fa-bitcoin', 'title' => 'Bitcoin','share_link' =>'' ),
		'bitbucket'      => array( 'iclass' => 'fa-bitbucket', 'title' => 'BitBucket','share_link' => '' ),
		'codepen'        => array( 'iclass' => 'fa-codepen', 'title' => 'Codepen','share_link' =>'' ),
		'delicious'      => array( 'iclass' => 'fa-delicious', 'title' => 'Delicious','share_link' =>'https://delicious.com/save?url='),
		'deviantart'     => array( 'iclass' => 'fa-deviantart', 'title' => 'DeviantArt','share_link' =>'' ),
		'digg'           => array( 'iclass' => 'fa-digg', 'title' => 'Digg','share_link' =>'http://digg.com/submit?url=' ),
		'dribbble'       => array( 'iclass' => 'fa-dribbble', 'title' => 'Dribbble','share_link' =>'' ),
		'flickr'         => array( 'iclass' => 'fa-flickr', 'title' => 'Flickr','share_link' => ''),
		'foursquare'     => array( 'iclass' => 'fa-foursquare', 'title' => 'Foursquare','share_link' => ''),
		'github'         => array( 'iclass' => 'fa-github-alt', 'title' => 'Github','share_link' => ''),
		'jsfiddle'       => array( 'iclass' => 'fa-jsfiddle', 'title' => 'JSFiddle','share_link' => ''),
		'reddit'         => array( 'iclass' => 'fa-reddit', 'title' => 'Reddit','share_link' => 'https://reddit.com/submit?url='),
		'skype'          => array( 'iclass' => 'fa-skype', 'title' => 'Skype','share_link' => 'https://web.skype.com/share?url='),
		'slack'          => array( 'iclass' => 'fa-slack', 'title' => 'Slack','share_link' => ''),
		'soundcloud'     => array( 'iclass' => 'fa-soundcloud', 'title' => 'SoundCloud','share_link' => ''),
		'spotify'        => array( 'iclass' => 'fa-spotify', 'title' => 'Spotify','share_link' => ''),
		'stack-exchange' => array( 'iclass' => 'fa-stack-exchange', 'title' => 'Stack Exchange','share_link' => ''),
		'stack-overflow' => array( 'iclass' => 'fa-stack-overflow', 'title' => 'Stach Overflow','share_link' => ''),
		'steam'          => array( 'iclass' => 'fa-steam', 'title' => 'Steam','share_link' => ''),
		'stumbleupon'    => array( 'iclass' => 'fa-stumbleupon', 'title' => 'Stumbleupon','share_link' => 'http://www.stumbleupon.com/submit?url='),
		'tumblr'         => array( 'iclass' => 'fa-tumblr', 'title' => 'Tumblr','share_link' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl='),
		'rss'            => array( 'iclass' => 'fa-rss', 'title' => 'RSS','share_link' => '' )
	) );

	$icons['__ordering__'] = array_keys( $icons );

	return $icons;
}
add_shortcode('inline_space','wan_inline_space');
function wan_inline_space($atts){
	$atts = shortcode_atts(
        array(
            'length' => '10px',
        ), $atts, 'inline_space' );
	return sprintf('<span width="%s"></span>',wan_render_dimensions($atts['length']));
}
add_shortcode('rt-link','wan_link');
function wan_link($atts) {
	$atts = shortcode_atts(
        array(
            'url' => '#url="url"',
            'title' => 'title="yourtitle"'
        ), $atts, 'rt-link' );
	return sprintf('<a href="%s">%s</a>',$atts['url'],$atts['title']);
}
add_shortcode('copyright_year','wan_copyright_year');
function wan_copyright_year() {
	return "&copy;".date("Y"); 
}

function themes_predefined_background_patterns() {
	static $patterns;

	if ( empty( $patterns ) || ! is_array( $patterns ) ) {
		$patterns = array();
		$template_directory = get_template_directory();
		$stylesheet_directory = get_stylesheet_directory();

		// Find background pattern from template's assets
		foreach( glob( WAN_LINK . '/images/controls/patterns/*' ) as $file ) {
			if ( is_dir( $file ) )
				continue;

			$patterns['parent_' . basename($file)] = THEME_URL . '/images/controls/patterns/' . basename($file);
		}

		if ( $template_directory != $stylesheet_directory ) {
			if ( is_dir( WAN_LINK . '/images/controls/patterns' ) ) {
				// Find background patterns from child theme's assets
				foreach( glob( WAN_LINK . '/images/controls/patterns/*' ) as $file ) {
					if ( is_dir( $file ) )
						continue;

					$patterns['child_' . basename($file)] = THEME_URL . '/images/controls/patterns/' . basename($file);
				}
			}
		}

		$patterns = apply_filters( 'savi/themes_predefined_background_patterns', $patterns );
	}

	return $patterns;
}

/**
 * Menu fallback
 */
function wan_menu_fallback() {
	echo '<ul id="menu-main" class="menu">
	<li>
	<a class="menu-fallback" href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__( 'Create a Menu', 'wan' ) . '</a></li></ul>';
}

function wan_esc_attr($attr) {
	echo esc_attr($attr);
}

function wan_esc_html($attr) {
	echo esc_html($attr);
}

/**
 * Change the excerpt length
 */
function wan_excerpt_length( $length ) {  
  	$excerpt = wan_choose_opt('blog_archive_post_excepts_length');
  	return $excerpt;
}

add_filter( 'excerpt_length', 'wan_excerpt_length', 999 );

/**
 * Blog layout
 */
function wan_blog_layout() {
	switch (get_post_type()) {
		case 'page':
			$layout = wan_choose_opt('page_layout');
			break;
		case 'post':
			$layout = wan_choose_opt('blog_layout');
			break;
		case 'portfolios':
			$layout = wan_choose_opt('portfolios_sidebar');
			break;
		
		default:
			$layout = wan_choose_opt('blog_layout');
			break;
	}

	return $layout ;
}

function wan_font_style($style) {
	if (strlen($style) > 4) {
	  	switch (substr($style, 0,3)) {
			case 'reg':
			    $a[0] = '400';
			    $a[1] = 'normal';
			break;
			case 'ita':
			    $a[0] = '400';
			    $a[1] = 'italic';			    
			break;
			default:
			    $a[0] = substr($style, 0,3);
			    $a[1] = substr($style, 3);
			break;
		}
		  
	}
	else {
	  	$a[0] = $style;
	  	$a[1] = 'normal';
	}
	return $a;
}


function wan_get_class_for_custom($vc_class = '',$wan_class='') {
    if (!empty($vc_class)) {
        if (function_exists('vc_shortcode_custom_css_class')) {
            $vcclass = vc_shortcode_custom_css_class( $vc_class, '' );
        }
    }
    else {
        $vcclass = $wan_class; 
    }
    return $vcclass;
}

function wan_shortcode_default_id(){
    return array(
                'type'       => 'textfield',
                'param_name' => 'default_id',
                'group' => esc_html__( 'Design Options', 'wan' ),
                'value' => 'wan_'.current_time('timestamp'),
                'std' => 'wan_'.current_time('timestamp')
                );
}

function wan_render_box_position($class,$box_control,$custom_string='') {
    $css = $class .'{';
    if (is_array($box_control)) {
        foreach ($box_control as $key => $value) {
            if ( $value !=='') {
				$css .= esc_attr($key) .':'.wan_render_dimensions($value).';';
            }
        }
    }
    $css .= esc_attr($custom_string);
    $css .= '}';
    wp_add_inline_style( 'wan-theme', $css );
}


/**
 * Get post meta, using rwmb_meta() function from Meta Box class
 */
function wan_meta( $key,$ID='') {
	global $post;
	if ( $ID =='' && !is_null($post)) :
	    return get_post_meta( $post->ID,$key, true );
    else:
        return get_post_meta($ID,$key,true);
	endif;
}

if ( ! function_exists( 'wan_favicon' ) ) {
	add_action( 'wp_head', 'wan_favicon' );

	/**
	 * Display the custom favicon setup for the theme
	 *	 
	 * @return  void
	 */
	 
	function wan_favicon() {

		if (get_option('site_icon') == 0 ) {	
			printf ('<link rel="shortcut icon" href="'.esc_url( WAN_LINK . 'icon/favicon.png').'" />');		
		}
	}
}

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function wan_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'wan' ), max( $paged, $page ) );
		}

		return $title;
	}

	add_filter( 'wp_title', 'wan_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function wan_render_title() {
			?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'wan_render_title' );
	}
	
endif;


	function wan_get_json($key) {
		if ( get_theme_mod($key) == '' ) return wan_customize_default_options2($key);
		if (!is_array(get_theme_mod($key))) {
        $decoded_value = json_decode(str_replace('&quot;', '"',  get_theme_mod( $key )), true );
	    }
	    else {
	    	$decoded_value = get_theme_mod($key);
	    }
        return $decoded_value;
	}

	function wan_decode($value) {
		if (!is_array($value)) {
            $decoded_value = json_decode(str_replace('&quot;', '"',  $value) , true );
        }
        else {
            $decoded_value = $value;
        }
        return $decoded_value;
	}

	function wan_load_scheme($key,$ID='') {
		global $scheme;
		$savioptions = ( get_option('savioptions') );
		if ( isset( $savioptions[$key] ) && wan_meta( $savioptions[$key],$ID) == 1 ) {
			return wan_meta( $key,$ID );			
		}
		elseif (wan_meta('enable_scheme_load') == 1) {
			return wan_customize_default_options2($key,$scheme);
		}
		else {

			return wan_get_opt($key);
		}
	}

	function wan_load_header($key,$ID='') {
		$savioptions = ( get_option('savioptions') );
		if ( isset( $savioptions[$key] ) && wan_meta( $savioptions[$key],$ID) == 1 ) {
			return wan_meta( $key,$ID );			
		}
		elseif (wan_meta('enable_custom_header_style') == 1) {
			$wan_header = wan_choose_opt('header_style');
			return wan_customize_default_options2($key,$wan_header);
		}
		else {

			return wan_get_opt($key);
		}
	}

	function wan_get_opt( $key ) {
		global $scheme;
		return get_theme_mod( $key, wan_customize_default_options2( $key,$scheme ) );
	}

	function wan_dynamic_sidebar($sidebar,$ex_class="",$name='',$echo = false,$ex_html='') {
		if ( is_active_sidebar ( $sidebar ) ) {
				printf('<div class="%1$s">',$ex_class);
					printf('%s',$ex_html);
					dynamic_sidebar( $sidebar );        
				echo '</div>';
            } else {         
                    
                    if ($name == '') {
						$output = sprintf('<a href="%s">%s</a>',esc_url( admin_url( 'widgets.php' )),wan_autoname($sidebar));
	                }
	                else {
	                	$output =  $name;
	                }
				
					if ($echo === true){
						printf('<div class="%1$s">',$ex_class);
							printf('%s',$ex_html);
							echo $output;
						echo '</div>';
					}
                 
                }
	}

	function wan_outsite_meta($echo = true,$readmore_text = null,$hide_readmore = false) {
		$base = wan_get_opt('postmeta_items');
		$base = explode(',',$base);
		$outsite = wan_choose_opt('outsite_postmeta');
		$readmore_text = $readmore_text == null ? wan_choose_opt( 'blog_archive_readmore_text') : $readmore_text;
		$outsite = explode(",", $outsite);
		if ($echo == true) {
			foreach ($outsite as $value){
				printf('<div class="entry-%s">',$value);
				switch ($value) {
					case 'date':
						echo get_the_date();
						break;
					case 'category':
						the_category( ', ' );
						break;
					case 'author':
						printf(
						'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author"> %3$s %2$s</a></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )),
						get_the_author(),
						get_avatar(get_the_author_meta('user_email'),$size='40',$default='http://1.gravatar.com/avatar/160b3a089fd486dcab9e882e8336b6ff?s=40&d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D100&r=G?s=40' )
						
					);
						break;
					case 'comment':
						comments_popup_link( '<span class="zero">0 </span><span class="comment-label">'.esc_html__( 'No Comments', 'wan' ).'</span>', '1 <span class="comment-label">'.esc_html__(  'Comment', 'wan' ).'</span>','% <span class="comment-label">'. esc_html__( 'Comments', 'wan' ) .'</span>');
						break;
					case 'readmore':
						if (!is_single() && $hide_readmore != 1) {
							echo '<a class="readmore-link" href="'.get_the_permalink().'" rel="nofollow">'.wan_entity_decode($readmore_text).'</a>';
						}
						break;
				}
				echo '</div>';
			}
		}
		return array_diff($base,$outsite);
	}

	function wan_render_meta($readmore_text=null,$hide_readmore = false){
		$echo = wan_choose_opt('show_osmt_in_featured') == 1 ? false : true;
		$metas = wan_outsite_meta($echo,$readmore_text,$hide_readmore);
		if ( 'post' == get_post_type() && wan_choose_opt('blog_archive_show_post_meta') != 0 ) : ?>
			<div class="entry-meta clearfix">
				<?php wan_posted_on($metas); ?>		
			</div><!-- /.entry-meta -->
		<?php endif; 
	}

	function wan_choose_opt_belong ($key,$ID='') {
		$savioptions = ( get_option('savioptions') );
		if ( isset( $savioptions[$key] ) && wan_meta( $savioptions[$key],$ID) == 1 ) {
			return wan_meta( $key,$ID );			
		}
		else 
			return wan_get_opt( $key );
	}

	function wan_choose_opt ($key,$ID=null) {
		$meta = wan_meta($key,$ID);
		if ( $meta != '') {
			return $meta;		
		}
		else {
			return wan_get_opt( $key );
		}
	}


	function wan_load_page_menu($params) {
		if ( wan_meta( 'enable_custom_navigator' ) == 1 && wan_meta('menu_location_primary') != false ) {
			if ($params['theme_location'] == 'primary') {
				$params['menu'] = (int)wan_meta('menu_location_primary');
			}
		}
		return ($params);
	}

	add_filter( 'wp_nav_menu_args', 'wan_load_page_menu' );

 	
	add_filter('widget_text','do_shortcode');


	function wan_render_social($prefix = '',$value='',$show_title=false) {
        if ($value == '') {
     		$value = wan_get_json('social_links');
        }

        $class[] = ($show_title == false ? 'wan-socials' : 'wan-shortcode-socials');

        if ( ! is_array( $value ) ) {
                $decoded_value = json_decode(str_replace('&quot;', '"', $value), true );
                $value = is_array( $decoded_value ) ? $decoded_value : array();
            }

        $icons = wan_available_social_icons();

		?>
        <ul class="<?php echo esc_attr(implode(" ", $class));?>">
            <?php
            foreach ( $value as $key => $val ) {
                if ($key != '__ordering__') {
                    $title = ($show_title == false ? '' : $icons[$key]['title']);
                    printf(
                        '<li class="%s">
                            <a href="%s" target="_blank" rel="alternate" title="%s">
                                <i class="fa fa-%s"></i>
                                %s
                            </a>
                        </li>',
                        esc_attr( $key ),
                        esc_url( $val ),
                        esc_attr( $val ),
                        esc_attr( $key ),
                        esc_html($title)
                    );
                }
        }
            ?>
        </ul><!-- /.social -->       
 	<?php 
	 }


class all_terms
{
public function __construct()
{
	$version = '2';
	$namespace = 'wp/v' . $version;
	$base = 'all-terms';
	register_rest_route($namespace, '/' . $base, array(
		'methods' => 'GET',
		'callback' => array($this, 'get_all_terms'),
	));
}

public function get_all_terms($object)
{
	$return = array();
	$args = array(
		'public' => true,
		'_builtin' => false
	);
	$output = 'names'; // or objects
	$operator = 'and'; // 'and' or 'or'
	$return = [];
	if (isset($_GET['wan_cats'])) {
		$cats = explode(',',$_GET['wan_cats']);
		$taxonomies = get_terms($cats,[ 'hide_empty' => false]);
		foreach ($cats as $cat) {
			$return[$cat][] = ['label'=>'All','value'=> 'All'];
		}
	}
	if (is_array($taxonomies)):
		foreach ($taxonomies as $tx) {
			$return[$tx->taxonomy][] = ['label'=>$tx->name,'value'=>$tx->slug];
		}
	endif;
	
	return new WP_REST_Response($return, 200);
}
}

add_action('rest_api_init', function () {
$all_terms = new all_terms;
});

function wan_private_class($base ="row") {
	$ex = rand()."-".timestamp();
	return "{$base}-{$ex}";
}

function darken_color($rgb, $darker=2) {

    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
    if(strlen($rgb) != 6) return $hash.'000000';
    $darker = ($darker > 1) ? $darker : 1;

    list($R16,$G16,$B16) = str_split($rgb,2);

    $R = sprintf("%02X", floor(hexdec($R16)/$darker));
    $G = sprintf("%02X", floor(hexdec($G16)/$darker));
    $B = sprintf("%02X", floor(hexdec($B16)/$darker));

    return $hash.$R.$G.$B;
}

add_action( 'wp_ajax_wan_login', 'wan_ajax_login' );
add_action( 'wp_ajax_nopriv_wan_login', 'wan_ajax_login' );
function wan_ajax_login() {
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = $_POST['rememberme'];
    $output =['success' => [],'errors' => [],'redirect' => false];
    if (is_email($info['user_login'])) {
      $user_id = email_exists($info['user_login']);
    }
    else {
      $user_id = username_exists($info['user_login']);
    }
    if ($user_id > 0) {
      $output['success'] = '#user_login';
    }
    else {
      $output['errors']['user_login'] = '<strong>'.$info['user_login'].'</strong> does not exist';
    }
    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
    $output['errors']['user_pass'] = 'The password you entered for the <strong>'.$info['user_login'].'</strong> is incorrect.';
      
    } else {
      $output['redirect'] = true;
        // echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }
    echo '<div id="output">';
      echo json_encode($output,JSON_HEX_QUOT | JSON_HEX_TAG);
    echo '</div>';

    die();
}
function wan_widget_controls($customizer,$section_id,$sidebar_id) {
	global $wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_sidebars;
	$sidebars_widgets = array_merge(
		array( 'wp_inactive_widgets' => array() ),
		array_fill_keys( array_keys( $wp_registered_sidebars ), array() ),
		wp_get_sidebars_widgets()
	);
	if (isset($sidebars_widgets[$sidebar_id])) {
		$sidebar_widget_ids = $sidebars_widgets[$sidebar_id];
		foreach ( $sidebar_widget_ids as $i => $widget_id ):
			// Skip widgets that may have gone away due to a plugin being deactivated.
			echo $widget_id;
			$registered_widget = $wp_registered_widgets[ $widget_id ];
			$id_base           = $wp_registered_widget_controls[ $widget_id ]['id_base'];
			$control = new WP_Widget_Form_Customize_Control(
				$customizer,
				$section_id,
				array(
					'label'          => $registered_widget['name'],
					'section'        => $section_id,
					'sidebar_id'     => $sidebar_id,
					'widget_id'      => $widget_id,
					'widget_id_base' => $id_base,
					'priority'       => $i,
					'width'          => $wp_registered_widget_controls[ $widget_id ]['width'],
					'height'         => $wp_registered_widget_controls[ $widget_id ]['height'],
				)
			);
		endforeach;
	}
	
}


/**
 * Adding Image Field
 * @return void 
 */
function wan_color_attribute( $term ) {
	
	?>
	<div class="form-field">
		<label for="taxImage"><?php _e( 'Color', 'wan' ); ?></label>
        <input type="text" class="wp-color-picker" id="color_picker" name="color_value" value="" />
	</div>
<?php
}
add_action( 'pa_color_add_form_fields', 'wan_color_attribute', 10, 2 );

/**
 * Edit Image Field
 * @return void 
 */
function wan_edit_attribute( $term ) {
	
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	$term_color = get_term_meta( $t_id, 'color_value', true ); 
	?>
	<tr class="form-field">
		<th><label for="color"><?php _e( 'Color', 'wan' ); ?></label></th>
		 
		<td>	 
        	<input type="text" class="wp-color-picker wan-color-picker" id="color_picker" name="color_value"  value="<?php echo esc_attr( $term_color ) ? esc_attr( $term_color ) : '#1e73be'; ?>"/>
		</td>
	</tr>
<?php
}
add_action( 'pa_color_edit_form_fields', 'wan_edit_attribute', 10 );

/**
 * Saving Image
 */
function category_save_image( $term_id ) {
	
	if ( isset( $_POST['color_value'] ) ) {
		$term_image = $_POST['color_value'];
		if( $term_image ) {
			 update_term_meta( $term_id, 'color_value', $term_image );
		}

	} 
		
}  
add_action( 'edited_pa_color', 'category_save_image' );  
add_action( 'create_pa_color', 'category_save_image' );
