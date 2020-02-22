<?php 
Class wan_megamenu {
    function wan_megamenu_atr() {
        $post_data = [
            ['label'=> 'Products', 'value' => 'product'],
        ];
        $attributes = [	
                        'product_cat' => ['type'=>'text','default'=>'','data'=>wan_get_terms($post_data,'slug')]];
        return $attributes;
    }

    function wan_megamenu_render($atts) {
        $output = '<div class="wan-vertical-menu-block">';
        $output .= '[maxmegamenu location=vertical_menu_location]';
        $output .= '</div>';
       return $output;
    }
    function wan_register_megamenu() {
        wp_register_script(
            'wan-gutenberg-megamenu',
            WAN_KIT_URL.'blocks/wan-megamenu/block.build.js',
            array(  ),
            filemtime( WAN_KIT_PATH.'blocks/wan-megamenu/block.build.js' )
        );
        wp_localize_script('wan-gutenberg-megamenu','wan_megamenu_atr',$this->wan_megamenu_atr());
        register_block_type(
                'wan-gutenberg/megamenu',
                [
                'style' => 'wan-inline',
                'attributes'      => $this->wan_megamenu_atr(),
                'editor_style' => 'wan-inline',
                'editor_script' => 'wan-gutenberg-megamenu',
                'render_callback' => [$this,'wan_megamenu_render'],
                ]
            );
    }
    function __construct() {
        add_action( 'enqueue_block_editor_assets', [$this,'wan_register_megamenu']);
    }
}
new wan_megamenu;
?>