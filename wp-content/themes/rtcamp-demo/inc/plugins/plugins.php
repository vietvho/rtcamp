<?php
require_once get_template_directory() .'/inc/plugins/class-tgm-plugin-activation.php';
// Register action to declare required plugins
add_action( 'tgmpa_register', 'wan_recommend_plugin' );
function wan_recommend_plugin() {
 
    $plugins = array(
        array(
           'name'               => 'demo4RTCAMP Kit',
		   'slug'               => 'wan-kit',
           'source'             => WAN_DIR .'inc/plugins/wan-kit.zip',
           'required'           => true,
           'version'           => '1.0'
        ),  
            
	
    );  
 
    tgmpa( $plugins);
 }

