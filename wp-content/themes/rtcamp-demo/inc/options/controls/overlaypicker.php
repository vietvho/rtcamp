<?php
/**
 * Radio Images control
 */
if (class_exists('WP_Customize_Control')) {

	class ColorOverlay extends WP_Customize_Control {
		public $type = 'color-picker';
		public $choices = array();
		public function render() {
			$id    = 'wan-options-control-' . $this->id;
			$class = 'wan-options-control wan-options-control-' . $this->type;

			if ( $this->value() )
				$this->class = 'active';

			if ( ! empty( $this->class ) )
				$class .= " {$this->class}";

			if ( empty( $this->label ) )
				$class .= ' no-label';

			?><li id="<?php wan_esc_attr( $id ); ?>" class="<?php wan_esc_attr( $class ) ?>">
				<span class="wan-options-control-title wan-title-option"> <?php echo wan_esc_attr ($this->label); ?></span>
				<?php $this->render_content(); ?>
			</li><?php
		}
		public function render_content() { 
			$name = "_options-box-control-$this->id"; ?>
			<label>
			<span class="description customize-control-description"><?php wan_esc_html($this->description);?></span>
                <div class="background-color">

                    <div class="wan-options-control-color-picker">

                        <div class="wan-options-control-inputs">

                            <input type="text" class='wan-color-picker wp-color-picker' <?php $this->input_attrs(); ?> id="<?php wan_esc_attr( $name ) ?>-color" data-alpha="true" name="<?php wan_esc_attr($name);?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>" />

                        </div>

                    </div>

                </div>
            </label>
				
			<?php
		}
	}

}