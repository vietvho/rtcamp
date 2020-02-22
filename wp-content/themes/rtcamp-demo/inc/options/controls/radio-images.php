<?php
/**
 * Radio Images control
 */
if (class_exists('WP_Customize_Control')) {

	class RadioImages extends WP_Customize_Control {
		public $type = 'radio-images';
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
			$name = '_options-radio-images-' . $this->id;
	        $choices = $this->choices;
			if ( empty( $choices ) )
				return;
			?>
			<div class="wan-options-control-field">
				<?php foreach ( $choices as $_value => $params ):  ?>

					<label>
						<input type="radio" value="<?php wan_esc_attr( $_value ) ?>" name="<?php wan_esc_attr( $name ) ?>" <?php $this->link();  checked( $this->value(), $_value ) ?> />
						<span data-tooltip="<?php wan_esc_attr( $params['tooltip'] ) ?>">
							<img src="<?php echo esc_url( $params['src'] ) ?>" alt="<?php wan_esc_attr( $_value ) ?>" />
						</span> 
					</label>
					

				<?php  endforeach ?>

			</div>
				
			<?php
		}
	}

}