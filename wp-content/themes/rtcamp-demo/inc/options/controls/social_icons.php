<?php
/**
 * This class will be present an social icons control
 */
if (class_exists('WP_Customize_Control')) {

	class SocialIcons extends WP_Customize_Control {
		/**
		 * The control type
		 * 
		 * @var  string
		 */
		public $type = 'social-icons';
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
				<?php $this->render_content(); ?>
			</li><?php
		}

		public function render_content() {
			$name = '_options-social-icons-' . $this->id;
			$icons = wan_available_social_icons();

			$value = $this->value();
			$order = $icons['__ordering__'];

			if ( ! is_array( $value ) ) {
				$decoded_value = json_decode(str_replace('&quot;', '"', $value), true );
				$value = is_array( $decoded_value ) ? $decoded_value : array();
			}

			if ( isset( $value['__ordering__'] ) && is_array( $value['__ordering__'] ) ) {
				$order = $value['__ordering__'];
			}

			?>

			<ul class="WAN_ICONs">
				<li class="item-properties">
					<label>
						<span class="input-title"></span>
						<input type="text" class="input-field" />
					</label>
					<button type="button" class="button button-primary confirm"><i class="fa fa-check"></i></button>
				</li>

				<?php foreach ( $order as $id ):
					$params = $icons[$id];
					$link = isset( $value[$id] ) ? sprintf( 'data-link="%s"', esc_attr( $value[$id] ) ) : '';
					?>
					<li class="item wan-<?php wan_esc_attr( $id ) ?>" data-id="<?php wan_esc_attr( $id ) ?>" <?php wan_esc_attr($link) ?> data-title="<?php wan_esc_attr( $params['title'] ) ?>">
						<i class="fa <?php wan_esc_attr( $params['iclass'] ) ?>"></i>
					</li>
				<?php endforeach ?>
			</ul>
			<input type="hidden" id="typography-value"  name="<?php wan_esc_attr($name);?>" <?php $this->link();?>  value="<?php wan_esc_attr( json_encode( $this->value() ) ) ?>" />
			<?php
		}
	}
}