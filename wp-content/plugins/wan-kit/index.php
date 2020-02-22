<?php

/**
 * Plugin Name: Demo4RTCAMP Kit
 * Plugin URI: 
 * Description: Demo4RTCAMP Kit
 * Version: 1.0.2
 * Author: Warren Nguyen - Nguyen Huu Quoc Viet
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
$theme = wp_get_theme(); // gets the current theme
if ( !('Demo4RTCAMP' == trim($theme->name) || 'Demo4RTCAMP' == trim($theme->parent_theme) )) {
    
    return ;
}

define('WAN_KIT_PATH', plugin_dir_path(__FILE__));
define('WAN_KIT_URL', plugin_dir_url(__FILE__));
include(WAN_KIT_PATH.'inc/func-setup.php');
include(WAN_KIT_PATH.'inc/helpers.php');
include(WAN_KIT_PATH.'blocks/wan-rp/block.php');
include(WAN_KIT_PATH.'blocks/wan-rtcamp/block.php');
include(WAN_KIT_PATH.'blocks/wan-maps/maps.php');
