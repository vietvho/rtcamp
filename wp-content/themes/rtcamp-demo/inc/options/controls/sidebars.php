<?php

if ( ! function_exists( 'wan_sidebars_enqueue_assets' ) ) {
	add_action( 'admin_enqueue_scripts', 'wan_sidebars_enqueue_assets' );

	/**
	 * Enqueue needed assets for sidebars manager
	 * 
	 * @param   string  $hook  Which file are called hook
	 * @return  void
	 */
	function wan_sidebars_enqueue_assets( $hook = null ) {
		if ( $hook != 'widgets.php' )
			return;

		wp_enqueue_script( 'wan-sidebars', WAN_LINK . 'js/sidebars.js', array(),'3.0', true ); 

		$custom_widget_area     = get_option( wp_get_theme()->Template . '_widget_area' );
		$custom_widget_area_ids = is_array( $custom_widget_area ) ? array_keys( $custom_widget_area ) : array();

		wp_localize_script( 'wan-sidebars', '_wan_objects', array(
			'button_title'    => esc_html__( 'remove this widget area', 'wan' ),
			'confirm_message' => esc_html__( 'This Widget Area will be removed! Are you sure?', 'wan' ),
			'ids'           => $custom_widget_area_ids
		) );
	}
}



if ( ! function_exists( 'wan_sidebars_admin_form' ) ) {
	add_action( 'widgets_admin_page', 'wan_widget_area_admin_form' );

	/**
	 * Display the form that will be used to create
	 * the custom sidebars
	 * 
	 * @return  void
	 */
	function wan_widget_area_admin_form() {
		if ( ! ( $custom_widget_area = get_option( wp_get_theme()->Template . '_widget_area' ) ) )
			$custom_widget_area = array();

		$messages = array();
		$messages[1] = esc_html__( 'New custom widget area has been created', 'wan' );
		$messages[2] = esc_html__( 'Custom widget area has been removed', 'wan' );

		$errors = array();
		$errors[2] = esc_html__( 'Cannot create custom widget area, please try again', 'wan' );
		$errors[3] = esc_html__( 'Invalid the ID of widget area', 'wan' );
		?>

			<?php if ( isset( $_GET['message'] ) && isset( $messages[$_GET['message']] ) ): ?>
				<div id="message" class="updated"><p><?php echo esc_html( $messages[$_GET['message']] ); ?></p></div>
			<?php endif; ?>

			<?php if ( isset( $_GET['error'] ) && isset( $errors[$_GET['error']] ) ): ?>
				<div id="message" class="error"><p><?php echo esc_html( $errors[$_GET['error']] ); ?></p></div>
			<?php endif ?>

			<div id="sidebars-form" class="widget-liquid-right">
				<form action="<?php echo esc_url( admin_url() ) ?>admin-ajax.php?action=save_custom_widget_area" method="POST" class="widgets-holder-wrap widgets-sortables">
					<?php wp_nonce_field( 'save_custom_widget_area', 'custom-widget-area' ) ?>
					<h3><?php esc_html_e('Create Widget Area', 'wan' ) ?></h3>
					<div class="widget-area-inputs">
						<label for="widget-area-name"><?php esc_html_e('Enter name of the widget area:', 'wan' ) ?></label>
						<input type="text" name="widget-area-name" id="widget-area-name" />
						<input type="submit" class="button button-primary" value="<?php esc_html_e('Create', 'wan' ) ?>" />
					</div>
				</form>

				<?php if ( ! empty( $custom_widget_area ) ): ?>
					<form id="remove-sidebar-form" action="<?php echo esc_url( admin_url() ) ?>admin-ajax.php" method="GET" class="widgets-holder-wrap widgets-sortables" >
						<input type="hidden" name="action" value="remove_custom_widget_area" />
						<h3><?php esc_html_e('Remove Custom Widget Area', 'wan' ) ?></h3>
						<div class="widget-area-inputs">
							<label for="widget-area-id"><?php esc_html_e('Select custom widget area to be removed:', 'wan' ) ?></label>
							<select name="id" id="widget-area-id">
								<?php foreach ( $custom_widget_area as $id => $data ): ?>
								<option value="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $data['name'] ) ?></option>
								<?php endforeach ?>
							</select>
							<input type="submit" class="button" value="<?php esc_html_e('Remove', 'wan' ) ?>" />
						</div>
					</form>
				<?php endif ?>
			</div>

		<?php
	}
}



if ( ! function_exists( 'wan_sidebars_save_custom' ) ) {
	add_action( 'wp_ajax_save_custom_widget_area', 'wan_widget_area_save_custom' );

	/**
	 * Handle ajax request to save custom sidebar
	 * information
	 * 
	 * @return  void
	 */
	function wan_widget_area_save_custom() {
		if ( isset( $_POST['custom-widget-area'] ) &&
			 isset( $_POST['widget-area-name'] ) &&
			 wp_verify_nonce( $_POST['custom-widget-area'], 'save_custom_widget_area' ) ) {

			$name = $_POST['widget-area-name'];
			$custom_widget_area = get_option( wp_get_theme()->Template . '_widget_area' );

			if ( empty( $custom_widget_area ) )
				$custom_widget_area = array();

			$next_index = count( array_keys( $custom_widget_area ) );
			$custom_widget_area['widget-area-' . $next_index] = array(
				'name' => $name,
				'description' => sprintf( esc_html__( 'There are widgets for %s', 'wan' ), $name )
			);

			update_option( wp_get_theme()->Template . '_widget_area', $custom_widget_area );
			header( 'location: widgets.php?message=1' );
		}
		else {
			header( 'location: widgets.php?error=2' );
		}

		exit;
	}
}



if ( ! function_exists( 'wan_remove_custom_widget_area' ) ) {
	add_action( 'wp_ajax_remove_custom_widget_area', 'wan_remove_custom_widget_area' );

	/**
	 * Handle ajax action to remove the specific sidebar
	 * 
	 * @return  void
	 */
	function wan_remove_custom_widget_area() {
		if ( isset($_GET['id'] ) ) {
			$id = $_GET['id'];
			$custom_widget_area = get_option( wp_get_theme()->Template . '_widget_area' );

			if ( $custom_widget_area && is_array( $custom_widget_area ) && isset( $custom_widget_area[$id] ) ) {
				unset( $custom_widget_area[$id] );
				update_option( wp_get_theme()->Template . '_widget_area', $custom_widget_area );
				header( 'location: widgets.php?message=2' );

				exit;
			}

			header( 'location: widgets.php?error=3' );
		}

		exit;
	}
}



if ( ! function_exists( 'wan_register_custom_widget_area' ) ) {
	add_action( 'widgets_init', 'wan_register_custom_widget_area' );

	/**
	 * This is helper function to register all custom
	 * sidebars that created by the user
	 * 
	 * @return  void
	 */
	function wan_register_custom_widget_area() {
		$custom_widget_area = get_option( wp_get_theme()->Template . '_widget_area' );
		if ( empty( $custom_widget_area ) )
			$custom_widget_area = array();

		$general_option = apply_filters( 'wan/custom_widget_area_params', array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		) );

		foreach ($custom_widget_area as $id => $options) {
			$options = array_merge($options, $general_option);
			$options['id'] = $id;

			register_sidebar($options);
		}
	}
}
