<?php

/**
 * Register options for the post
 * 
 * @return  void
 */

Class wan_meta_boxes {
    public $meta_boxes;
    public $options;
    public $controls;
    public $label;
    public $id;
    public $context;
    public $priority;
    public $sections;
    public $post_types;
    public $type;
    public function __construct($args) {
      
       foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
          if ( isset( $args[ $key ] ) )
              $this->$key = $args[ $key ];
         }

         foreach ($this->options as $key => $_options) {
            $_options['id'] = $key;
            $this->controls[$_options['section']][] = $_options;
         }
            $this->hook();
            $this->setup();
    }
 
    public function hook() {
        wp_enqueue_script( 'wp-plupload' );
        wp_enqueue_style( 'wp-color-picker' );
        add_action( 'save_post', array($this,'save')) ;
    }

    public function setup(){
        $callback = array( $this, 'render' );
        $context = ( isset($this->context) ? $this->context : 'normal');
        $priority = ( isset($this->priority) ? $this->priority : 'default');
        add_meta_box(
            $this->id,
            $this->label,
            $callback,
            $this->post_types,
            $context,
            $priority
           ); 
    }

    function render_content($key,$controls,$post) { ?>

        <div id="wan-options-section-<?php wan_esc_attr( $key ) ?>">
            <ul class="wan-options-section-controls">
                <?php
                    foreach ( $controls as  $control ):
                        $this->control_render($control);
                    endforeach;
                ?>
            </ul>
        </div>

        <?php } 
        function arraymap_create_control($value) {
        	 return '#wan-options-control-'.$value; 
        }
    public function control_render( $control ) {
        global $post;
        global $wp_registered_sidebars;
        $post_update = get_post_meta( $post->ID,'wan_post_updated',true);
        if (!(get_post_meta( $post->ID, $control['id'], true )) && $post_update != 1 ) {
            $value = (isset($control['default'])?$control['default']:'');
        }
        else {
            $value = get_post_meta( $post->ID, $control['id'], true );
        }

        $class = '';
        if ( $value == 1 ) {
            $class = 'active';
        }

        $name = "_wan_options[{$control['id']}]";
        $title = (isset($control['title']) ? $control['title'] : '');
        $choices = (isset($control['choices']) ? $control['choices'] : '');
        $show_on_post_format = (isset($control['show_on_post_format']) ? $control['show_on_post_format'] : '');
        $children = (isset($control['children']) ? $control['children'] : array());
        $children = array_map(array($this,'arraymap_create_control'), $children);
        $children = implode( ",",$children);
        $description = (isset($control['description']) ? '<p>'.$control['description'].'</p>' : '');
        $hide ='';
        if ( $show_on_post_format != '') {
            $hide = ' ctrl_hide show-on-'.$show_on_post_format;
        }
        printf('<li class = "wan-options-control wan-options-control-%2$s %3$s" id="wan-options-control-%1$s">',$control['id'], $control['type'],$class.$hide);
        switch ($control['type']) {
            case 'switcher':
                printf('<label class="options-%6$s-%7$s"><span class="wan-options-control-title">%4$s</span> %5$s <input value="0" name="%3$s" type="hidden"><input children = "%8$s" type="checkbox" value="1" %2$s name="%1$s">
                <span class="wan-options-control-indicator">
                    <span></span>
                </span></label>',$name, checked(TRUE,$value,FALSE),$name,$title,$description,$control['type'],$control['id'],$children);
                break;
            case 'power':
                printf('<h6 class="wan-options-control-title">%4$s</h6>%5$s
                    <label class="wan-power options-%6$s-%7$s">
                      <input value="0" name="%3$s" type="hidden"><input children = "%8$s" type="checkbox" value="1" %2$s name="%1$s">
                      <div class="slider"></div>
                    </label>',$name, checked(TRUE,$value,FALSE),$name,$title,$description,$control['type'],$control['id'],$children);
            break;
            case 'heading':
                printf('<label class="options-%3$s-%4$s"><h3>%1$s</h3></label>%2$s',$title,$description,$control['type'],$control['id']);
                break;
            case 'editor':
            printf('<label class="options-%3$s-%4$s"><span class="wan-options-control-title">%1$s</span></label> %2$s<div class="wan-options-control-inputs">',$title,$description,$control['type'],$control['id']);
            wp_editor( $value,$control['id'], array( 'textarea_name' => $name, 'drag_drop_upload' => true ) );
            echo '</div>';
            break;
            case 'radio-images': ?>
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                <div class="wan-options-control-field">
                    <?php foreach ( $choices as $_value => $params ): ?>
                        <label> 
                            <input type="radio" value="<?php wan_esc_attr( $_value ) ?>" name="<?php wan_esc_attr($name);?>" <?php checked( $value, $_value ) ?> />
                            <span data-tooltip="<?php wan_esc_attr( $params['tooltip'] ) ?>">
                                <img src="<?php wan_esc_attr( $params['src'] ) ?>" alt="<?php wan_esc_attr( $_value ) ?>" />
                            </span>
                        </label>

                    <?php endforeach ;?>
                </div>

                <?php break;
            case 'radio': ?>
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                <div class="wan-options-control-field">
                    <?php foreach ( $choices as $_value => $params ): ?>
                        <label> 
                            <input type="radio" value="<?php wan_esc_attr( $_value ) ?>" name="<?php wan_esc_attr($name);?>" <?php checked( $value, $_value ) ?> />
                            <span><?php wan_esc_attr( $params['tooltip'] ) ?>
                                
                            </span>
                        </label>

                    <?php endforeach ;?>
                </div>

                <?php break;
             case 'select': ?>
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                <div class="wan-options-control-field">
                    <select name="<?php wan_esc_attr( $name ) ?>">
                    <?php foreach ( $choices as $_value => $params ): 
                                printf('<option value="%1$s" %2$s>%3$s</option>', $_value,  selected( $value, $_value ), $params); ?>
                    <?php endforeach ;?>
                    </select>
                </div>

                <?php break;
            case 'dropdown-sidebar': ?>
                 <label>
                    <span class="customize-category-select-control"><?php wan_esc_html($title); ?></span>
                    <select name="<?php wan_esc_attr( $name ) ?>">
                        <?php
                            foreach ( $wp_registered_sidebars as $sidebar ) {
                                $selected = ( strcmp($value,$sidebar['id'])==0 ? 1 : 0 );
                                printf('<option value="%1$s" %2$s>%3$s</option>', $sidebar['id'], selected($selected), $sidebar['name']);
                            }
                        ?>
                    </select>
                </label>
            <?php break;
             case 'textarea': ?>
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                <div class="wan-options-control-inputs">
                    <textarea name="<?php wan_esc_attr($name);?>" id="<?php wan_esc_attr( $control['id'] ) ?>"><?php wan_esc_html( $value ) ?></textarea>
                </div>
            <?php break;
            case 'datetime': 
             printf('<span class="wan-options-control-title">%3$s</span></label> %4$s<div class="wan-options-control-inputs">
                    <input name="_wan_options[%1$s]" id="wan-date-time" type="text" value="%2$s"/></div>',$control['id'],$value,$title,$description);
             break;
            case 'box-controls' :
                $id = $control['id'];
                $name = "_wan_options[{$id}]";
                wan_render_box_control($name,$value,$id);
            break;
            case 'reset_data' :
                echo '<a class="reset_meta" data_scheme="'.wan_choose_opt('wan_skin').'" href="#" data-id="'.get_the_ID().'" data-mode="meta">'.esc_html__('Clear Your Custom And Apply To This Style','wan').'</a>';
                break;
            case 'color-picker': ?>
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                <div class="background-color">
                    <div class="wan-options-control-color-picker">
                        <div class="wan-options-control-inputs">
                            <input type="text" class='wan-color-picker wp-color-picker' id="<?php wan_esc_attr( $name ) ?>-color" name="<?php wan_esc_attr($name);?>" data-alpha="true"  data-default-color value="<?php wan_esc_attr( $value ) ?>" />
                        </div>
                    </div>
                </div>
            <?php break;
            case 'single-image-control':?>

                <?php 

                $showupload = '_show';

                $showremove = '_hide';

                if ( $value != '' ) {

                    $showupload = '_hide';

                    $showremove = '_show';

                }

                ?>

                <div class="options-control-media-picker background-image" data-customizer-link="<?php wan_esc_attr($control['id']);?>">

                <span class="options-control-title"><?php wan_esc_html($title);?></span>

                    <div class="options-control-inputs">

                        <div class="upload-dropzone">                            

                            <input type="hidden" data-property="id"/>

                            <input type="hidden" data-property="thumbnail"/>

                            <ul class="upload-preview">

                            <?php

                                printf('

                                    <li>

                                        <img src="%s"/>

                                        <a href="#" id="%s" class="wan-remove-media" title="Remove">

                                            <span class="dashicons dashicons-no-alt"></span>

                                        </a>

                                    </li>

                                    ',$value,$value);

                            ?>

                            </ul>

                            <span class="upload-message <?php echo esc_attr($showupload);?> ">

                                <a href="#" class="browse-media"><?php esc_html_e( 'Add file', 'wan' ) ?></a>

                                <a href="#" class="upload"></a>

                            </span>

                        </div>

                        <a href="#" class="button remove <?php echo esc_attr($showremove);?>"><?php esc_html_e( 'Remove', 'wan' ) ?></a>

                    </div>

                    <input class="image-value" type="hidden" name="<?php wan_esc_attr($name);?>" value="<?php  wan_esc_attr( $value ) ?>" />

                </div>

            <?php 

            break;
            case 'image-control':?>
                <?php 
                $showupload = '_show';
                $showremove = '_hide';
                if ( $value != '' ) {
                    $showupload = '_hide';
                    $showremove = '_show';
                }
                $decoded_value = wan_decode($value);
                ?>
                <div class="wan-options-control-media-picker background-image" data-customizer-link="<?php wan_esc_attr($control['id']);?>">
                <span class="wan-options-control-title"><?php wan_esc_html($title);?></span>
                    <div class="wan-options-control-inputs">
                        <div class="upload-dropzone">
                            
                            <input type="hidden" data-property="id"/>
                            <input type="hidden" data-property="thumbnail"/>
                            <ul class="upload-preview">
                            <?php
                                if (is_array($decoded_value)) { 
                                    foreach ($decoded_value as $val) :
                                        printf('
                                            <li>
                                                %s
                                                <a href="#" id="%d" class="wan-remove-media" title="Remove">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </a>
                                            </li>
                                            ',wp_get_attachment_image($val),$val);
                                    endforeach;
                                }
                            ?>
                            </ul>
                            <span class="upload-message <?php echo esc_attr($showupload);?> ">
                                <a href="#" class="browse-media"><?php esc_html_e( 'Add files', 'wan' ) ?></a>
                                <a href="#" class="upload"></a>
                            </span>
                        </div>
                        <a href="#" class="button remove <?php echo esc_attr($showremove);?>"><?php esc_html_e( 'Remove', 'wan' ) ?></a>
                    </div>
                    <input class="image-value" type="hidden" name="<?php wan_esc_attr($name);?>" value="<?php  wan_esc_attr( $value ) ?>" />
                </div>
            <?php 
            break;
            default:
                printf('<span class="wan-options-control-title">%3$s</span></label> %4$s<div class="wan-options-control-inputs">
                    <input name="_wan_options[%1$s]" type="text" value="%2$s"/></div>',$control['id'],esc_html($value),$title,$description);
                break;
        }
        echo '</li>';
    }

    public function render($post) {

        $section  = $this->sections;
        $controls = $this->controls;
        $first = true;
        ?>
        <div class="wan-options-container wan-options-container-tabs">
                    <?php foreach( $this->sections as $id => $section ): ?>
                        <?php if ($first == true) {
                            $class ='ui-tabs-active';
                            $first = false;
                            }
                            else {
                                $class = '';
                            }
                            $wan_setcion[$id] = $section['title'];
                    endforeach ?>

            <div class="wan-options-container-content wan-accordion">
                   
                <?php
                    foreach( $controls as $key => $_controls ){?>
                        <?php if ($this->context !='side'):?>
                        <div class="wan-toggle">
                            <h6 class="toggle-title"><?php echo esc_attr($wan_setcion[$key]);?></h6>
                            <div class="toggle-content" style="display: none;">
                        <?php else:
                        echo '<div class="hide-label">';
                        endif;?>
                                  <?php    $this->render_content($key,$_controls,$post);?>
                        <?php if ($this->context !='side'):?>
                            </div>
                        </div>
                        <?php else :
                        echo '</div>';
                        endif;?>

                <?php    }
                ?>
            </div>
        </div>

        <?php 
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
        
    }

    function save( $post_id ) {
 
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';
 
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
 
        /* OK, it's safe for us to save the data now. */

        if ( isset( $_REQUEST ) && isset( $_REQUEST['_wan_options'] ) ) {
            $datas = stripslashes_deep( $_REQUEST['_wan_options'] );
            foreach ($datas as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }
            update_post_meta($post_id,'wan_post_updated',1);
        }

    }

    public function page_meta_box() {
        $this -> setup($this->meta_boxes);
    }  
}
?>