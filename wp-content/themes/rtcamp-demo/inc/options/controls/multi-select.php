<?php
/**
 * Multiple select customize control class.
 */
if (class_exists('WP_Customize_Control')) {
class MultipleSelect extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     */
    public $type = 'multiple-select';

    /**
     * Displays the multiple select on the customize screen.
     */
    public function render_content() {
    $values= (explode(",", $this->value()));
    if ( empty( $this->choices ) )
        return;
    ?>
    <div class="multipleSelectContainer">
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <select class="multipleSelectCtrl"  multiple="multiple" style="height: 100%;">
                <?php
                    foreach ( $this->choices as $value => $label ) {
                        $selected = ( in_array( $value, $values ) ) ? selected( 1, 1, false ) : '';
                        echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                    }
                ?>
            </select>
        </label>
        <input type="hidden" <?php $this->link(); ?> value = "<?php echo esc_attr($this->value());?>">
    </div>
    <?php }
}
}