<?php
/**
 * This class will be present an colorpicker control
 */
if (class_exists('WP_Customize_Control')) {
	class LocalFont extends WP_Customize_Control{
		public $type = 'localfont'; 
		public function render_content() {
			$values = $this->value();
			$font_types = array(
				'100'        => esc_html__( 'Thin 100', 'wan' ),
				'100italic'  => esc_html__( 'Thin 100 italic', 'wan' ),
				'200'        => esc_html__( 'Extra-light 200', 'wan' ),
				'200italic'  => esc_html__( 'Extra-light 200 italic', 'wan' ),
				'300'        => esc_html__( 'Light 300', 'wan' ),
				'300italic'  => esc_html__( 'Light 300 italic', 'wan' ),
				'400'        => esc_html__( 'Normal 400', 'wan' ),
				'400italic'  => esc_html__( 'Normal 400 italic', 'wan' ),
				'500'        => esc_html__( 'Medium 500', 'wan' ),
				'500italic'  => esc_html__( 'Medium 500 italic', 'wan' ),
				'600'        => esc_html__( 'Semi-bold 600', 'wan' ),
				'600italic'  => esc_html__( 'Semi-bold 600 italic', 'wan' ),
				'700'        => esc_html__( 'Bold 700', 'wan' ),
				'700italic'  => esc_html__( 'Bold 700 italic', 'wan' ),
				'800'        => esc_html__( 'Extra-bold 800', 'wan' ),
				'800italic'  => esc_html__( 'Extra-bold 800 italic', 'wan' ),
				'900'        => esc_html__( 'Ultra-bold 900', 'wan' ),
				'900itallic' => esc_html__( 'Ultra-bold 900 italic', 'wan' )
			);
			$name = '_wan-options-control-localfont-' . $this->id;
			if ( ! is_array( $values ) ) {
				$decoded_value = json_decode(str_replace('&quot;', '"', $values), true );
				$values = is_array( $decoded_value ) ? $decoded_value : array();
			} 
		?>
		<span class="customize-control-title"><?php echo $this->label;?></span>
		<span class="description customize-control-description"><?php echo $this->description;?></span>
		<div class="form_local_font" id="loal_font_upload_<?php echo $this->id;?>" method="post" action="#" enctype="multipart/form-data">
			<div class="font_file_upload">
				<div class="font_preview"></div>
				<input type="hidden" class="font_file_url"/>
				<a href="#" class="browse-media"><?php esc_html_e( 'Add file', 'wan' ) ?></a>
				
			</div>
			<input type="text" class="font_name" placeholder="<?php _e('Font Name','wan');?>" id="font_name_<?php echo $this->id;?>" name="font_name"/>
			<select class="font_weight">
				<?php 
				foreach ($font_types as $key => $value) {
					$selected = '';
					if ($key == '400') {
						$selected = 'selected';
					}
					printf('<option value="%1$s" %3$s >%2$s</option>',$key,$value,$selected);
				}
				?>
			</select>
			<input class="font_local_submit" name="font_local_submit" type="submit" value="<?php echo esc_html__('Add Font','wan');?>" />
			<input type="hidden" class="font_local_value" id="font_local_value_<?php echo $this->id;?>"  name="font_local_value" <?php $this->link();?>  value="<?php wan_esc_attr (  $values ) ;?>" />
			<div class="font_list">
				<table>
					<thead>
						<tr>
							<th>Font Name</th>
							<th>Font Weight and Style</th>
							<th>Remove</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($values as $key => $value) {
							$td = '';
							$td .= sprintf('<td>%s</td>',$value['font_name']);
							$td .= sprintf('<td>%s</td>',$font_types[$value['font_weight']]);
							$td .= sprintf('<td><a class="remove_item" href="#" data-fontid="%s">x</a></td>',$key);
							printf('<tr>%s</tr>',$td);
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

	<?php }
	}
	class Typekit extends WP_Customize_Control{
		public $type = 'typekit';
		public function render_content() { 
			$value = $this->value();
			$basevariants = array("n1"=>'100',"i1"=>'100italic',"n2"=>'200',"i2"=>'200italic',"n3"=>'300',"i3"=>'300italic',"n4"=>'400',"i4"=>'400italic',"n5"=>'500',"i5"=>'500italic',"n6"=>'600',"i6"=>'600italic',"n7"=>'700',"i7"=>'700italic',"n8"=>'800',"i8"=>'800italic',"n9"=>'900',"i9"=>'900itallic');
			if ($value != '') {
				$data = wp_remote_get( "https://typekit.com/api/v1/json/kits/$value/published" );
				if( is_wp_error( $data ) ){
					echo 'error';
				}
				else {
					$fonts = $data['body'];
					$fonts = json_decode($fonts,true);
					$fonts = $fonts['kit'];
					$fonts = $fonts['families'];
					foreach ($fonts as $key=>$font) {
						foreach ($font['variations'] as $_key => $_style){
							$font['variations'][$_key]=$basevariants[$_style];
						}
						$fonts[$key]['variations']=$font['variations'];
					}
					update_option('typekit_font',$fonts) ;
				}
			}
			else {
				update_option('typekit_font','');
			}
			?>
			<div class="wan-options-control-inputs">
			 	<?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description ; ?></span>
                <?php endif; ?>
				<input type="text" <?php $this->link();?> value ="<?php esc_attr($value);?>">
			</div>
		<?php }
	}
	class Typography extends WP_Customize_Control {
		/**
		 * The control type
		 * 
		 * @var  string
		 */
		public $type = 'typography';
		public $fields = array(
			'family', 'size', 'style', 'subsets','color','line_height','letter_spacing'
		);
		private $fonts = false;
		private $titles, $titles_subsets;
		private static $localize_enqueued = false;

		/**
		 * Enqueue assets for this control
		 * 
		 * @return  void
		 */
		public function enqueue() {
			wp_enqueue_style( 'wp-color-picker' );
		}
		
		/**
		 * Render the control markup
		 * 
		 * @return  void
		 */
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
			//fortest
			$font_typekit = get_option('typekit_font');
			$font_local_get = get_theme_mod('add_local_font',array());
			if (!is_array($font_local_get)) {
				$font_local_decode = wan_decode($font_local_get,true);
			}
			$font_local_decode = is_null($font_local_decode)?array():$font_local_decode;
			$font_local = array();
			foreach ($font_local_decode as $value){
				if (isset($font_local[$value['font_name']])){
					$font_local[$value['font_name']]['variants'][]=$value['font_weight'];
				}
				else {
					$tmp = array('family'=>$value['font_name'],'variants'=>array($value['font_weight']));
					$font_local[$value['font_name']]=$tmp;
				}
			}
			$font_local1 = array(
				array('family' => 'Local1','variants'=>array('100italic','200','200italic')),
				array('family' => 'Local2','variants'=>array('100italic','200','200italic','300italic')),
				array('family' => 'Local3','variants'=>array('100italic','200','200italic','500italic')),
				);
			$this->titles = array(
				'100'        => esc_html__( 'Thin 100', 'wan' ),
				'100italic'  => esc_html__( 'Thin 100 italic', 'wan' ),
				'200'        => esc_html__( 'Extra-light 200', 'wan' ),
				'200italic'  => esc_html__( 'Extra-light 200 italic', 'wan' ),
				'300'        => esc_html__( 'Light 300', 'wan' ),
				'300italic'  => esc_html__( 'Light 300 italic', 'wan' ),
				'400'        => esc_html__( 'Normal 400', 'wan' ),
				'400italic'  => esc_html__( 'Normal 400 italic', 'wan' ),
				'regular'    => esc_html__( 'Normal 400', 'wan' ),
				'italic'     => esc_html__( 'Normal 400 italic', 'wan' ),
				'500'        => esc_html__( 'Medium 500', 'wan' ),
				'500italic'  => esc_html__( 'Medium 500 italic', 'wan' ),
				'600'        => esc_html__( 'Semi-bold 600', 'wan' ),
				'600italic'  => esc_html__( 'Semi-bold 600 italic', 'wan' ),
				'700'        => esc_html__( 'Bold 700', 'wan' ),
				'700italic'  => esc_html__( 'Bold 700 italic', 'wan' ),
				'800'        => esc_html__( 'Extra-bold 800', 'wan' ),
				'800italic'  => esc_html__( 'Extra-bold 800 italic', 'wan' ),
				'900'        => esc_html__( 'Ultra-bold 900', 'wan' ),
				'900itallic' => esc_html__( 'Ultra-bold 900 italic', 'wan' )
			);

			$this->titles_subsets = array(
				"cyrillic-ext"  => esc_html__("Cyrillic Extended",'wan'),
			    "greek" 		=> esc_html__("Greek",'wan'),
			    "greek-ext"		=>	esc_html__("Greek Extended",'wan'),
			    "latin-ext"		=>	esc_html__("Latin Extended",'wan'),
			    "cyrillic"		=>	esc_html__("Cyrillic",'wan'),
			    "vietnamese"	=>	esc_html__("Vietnamese",'wan'),
			    "latin" 		=> esc_html__("Latin",'wan')
				);

			$name = '_wan-options-control-typography-' . $this->id;
			$values = $this->value();
			$fonts = $this->get_fonts();
			if ( ! is_array( $values ) ) {
				$decoded_value = json_decode(str_replace('&quot;', '"', $values), true );
				$values = is_array( $decoded_value ) ? $decoded_value : array();
			}

			?>

				<div class="wan-options-control-inputs">
					<?php if ( in_array( 'family', $this->fields ) ): ?>
					<div class="wan-options-control-chosen typography-font">
						<div class="wan-options-control-title">
							<label for="<?php wan_esc_attr( $name ) ?>-family"><?php esc_html_e( 'Font Family', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
							<select name="<?php wan_esc_attr( $name ) ?>[family]" id="<?php wan_esc_attr( $name ) ?>-family" class="select-choosen" >
							<?php if (is_array($font_typekit)){?>
								<optgroup label="<?php wan_esc_attr( 'Typekit Fonts', 'wan' ) ?>">
									<?php foreach ($font_typekit as $id => $font) { 
										if( strcmp($font['slug'],$values['family']) == 0 ){
											$index = $id;
											$fonttype="typekit";
										}
										?>
										<option value="<?php wan_esc_attr( $font['slug'] ) ?>" data_variants="<?php wan_esc_attr(json_encode($font['variations']));?>" <?php selected($font['slug'], $values['family']) ?> ><?php wan_esc_html( $font['name'] ) ?></option>
									<?php }?>
								</optgroup>
								<?php } 
								if (is_array($font_local)){
								?>
								<optgroup label="<?php wan_esc_attr( 'Local Fonts', 'wan' ) ?>">
									<?php 
									foreach ($font_local as $id => $font) {
										if( strcmp($font['family'],$values['family']) == 0 ){
											$index = $id;
											$fonttype="local";
										}
									 ?>
										<option value="<?php wan_esc_attr( $font['family'] ) ?>" data_variants="<?php wan_esc_attr(json_encode($font['variants']));?>" <?php selected($font['family'], $values['family']) ?> ><?php wan_esc_html( $font['family'] ) ?></option>
									<?php }?>
								</optgroup>
								<?php }?>
								<optgroup label="<?php wan_esc_attr( 'Google Fonts', 'wan' ) ?>">
									<?php foreach ($fonts as $id => $font ): ?>
									<?php if( strcmp($font->family,$values['family']) == 0 ){
										$index = $id;
										$fonttype = 'google';
									}
									?>

									<option value="<?php wan_esc_attr( $font->family ) ?>" data_variants='<?php echo json_encode($font->variants);?>' data_subsets='<?php echo json_encode($font->subsets);?>' <?php selected($font->family, $values['family']) ?> ><?php wan_esc_html( $font->family ) ?></option>
									<?php endforeach ?>
								</optgroup>
								
							</select>
						</div>
					</div>
					<!-- /family -->
					<?php endif;?>

					<?php if ( in_array( 'size', $this->fields ) ): ?>
					<div class="typography-size">
						<div class="wan-options-control-title">
							<label for="<?php wan_esc_attr( $name ) ?>-size"><?php esc_html_e( 'Font Size (px)', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
							<input type="text" name="<?php wan_esc_attr( $name ) ?>[size]" value="<?php wan_esc_attr( $values['size'] ) ?>" id="<?php wan_esc_attr( $name ) ?>-size" />
						</div>
					</div>
					<!-- /size -->
					<?php endif ?>

					<?php 
					if ( in_array( 'line_height', $this->fields ) ): ?>
					<div class="typography-line_height">
						<div class="wan-options-control-title">
							<label for="<?php wan_esc_attr( $name ) ?>-line_height"><?php esc_html_e( 'Line_height ', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
							<input type="text" name="<?php wan_esc_attr( $name ) ?>[line_height]" value="<?php wan_esc_attr( $values['line_height'] ) ?>" id="<?php wan_esc_attr( $name ) ?>-line_height" />
						</div>
					</div>
					<!-- /size -->
					<?php endif ?>
					<?php if ( in_array( 'letter_spacing', $this->fields ) ): ?>
					<div class="typography-letter_spacing">
						<div class="wan-options-control-title">
							<label for="<?php wan_esc_attr( $name ) ?>-letter_spacing"><?php esc_html_e( 'letter_spacing', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
							<input type="text" name="<?php wan_esc_attr( $name ) ?>[letter_spacing]" value="<?php wan_esc_attr( $values['letter_spacing'] ) ?>" id="<?php wan_esc_attr( $name ) ?>-letter_spacing" />
						</div>
					</div>
					<!-- /size -->
					<?php endif ?>
					<div class="wan-options-control-chosen typography-style">
						<div class="wan-options-control-title">
							<label><?php esc_html_e( 'Font Weight & Style', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
							<label>
								<select name="<?php wan_esc_attr($name);?>[style]" id="<?php wan_esc_attr( $name ) ?>-style" class="selectpicker" data-live-search="true">
								    <?php 
								    if ($fonttype == 'google'):
								    foreach ($fonts[$index]->variants as $id => $font_weight):
								    ?>
									<option value="<?php wan_esc_attr( $font_weight ) ?>" <?php selected( $font_weight, $values['style'] ) ?> >
										<?php
											if ( isset( $this->titles[$font_weight] ) )
												wan_esc_html( $this->titles[$font_weight] );
											else
												wan_esc_html( $font_weight );
										?>
									</option>
									<?php endforeach;
									endif;
								    if ($fonttype == 'typekit'):
									    foreach ($font_typekit[$index]['variations'] as $id => $font_weight):?>
									    	<option value="<?php wan_esc_attr( $font_weight ) ?>" <?php selected( $font_weight, $values['style'] ) ?> >
									    	<?php
											if ( isset( $this->titles[$font_weight] ) )
												wan_esc_html( $this->titles[$font_weight] );
											else
												wan_esc_html( $font_weight );
												?>
											</option>
								    	<?php endforeach;

							    	endif;
							    	if ($fonttype == 'local'):
									    foreach ($font_local[$index]['variants'] as $id => $font_weight):?>
									    	<option value="<?php wan_esc_attr( $font_weight ) ?>" <?php selected( $font_weight, $values['style'] ) ?> >
									    	<?php
											if ( isset( $this->titles[$font_weight] ) )
												wan_esc_html( $this->titles[$font_weight] );
											else
												wan_esc_html( $font_weight );
												?>
											</option>
								    	<?php endforeach;

							    	endif;
									 ?>
								</select>
							</label>
						</div>
					</div>
					<!-- /font-weight -->

				<?php if ( in_array( 'subsets', $this->fields ) ): ?>
					<div class="wan-options-control typography-subsets wan-options-control-switcher active">
						<div class="wan-options-control-title">
							<label><?php esc_html_e( 'Font subsets', 'wan' ) ?></label>
						</div>
						<div class="wan-options-control-inputs">
						    <?php foreach ($fonts[$index]->subsets as $id => $subset):?>

								<label class="_options-switcher-subsets">
									<span class="wan-options-control-title"><?php
												if ( isset( $this->titles_subsets[$subset] ) )
													wan_esc_html( $this->titles_subsets[$subset] );
												else
													wan_esc_html( $subset );
											?></span>
									<input type="checkbox" <?php if(isset($values['subsets'])){checked(in_array($subset,$values['subsets']));}?> value="<?php wan_esc_attr($subset);?>" name="<?php wan_esc_attr($name);?>[subsets]">
									<span class="wan-options-control-indicator">
										<span></span>
									</span>
								</label>
							<?php endforeach;?>
						</div>
					</div>
				<?php endif;?>
					<!-- /font-subsets -->

				<?php if ( in_array( 'color', $this->fields ) ): ?>
				<div class="wan-options-control-color-picker typography-color">
					<div class="wan-options-control-title">
						<label><?php esc_html_e( 'Font Color', 'wan' ) ?></label>
					</div>
					<div class="wan-options-control-inputs">
						<div class="wan-options-control-color-picker">
							<div class="wan-options-control-inputs">
							<input type="hidden" class="choose-color"></input>
								<input type="text" class='wan-color-picker wp-color-picker' id="<?php wan_esc_attr( $name ) ?>-color" data-default-color="<?php wan_esc_attr( $values['default_color'] ) ;?>" value="<?php wan_esc_attr( $values['color'] ) ;?>" name="<?php wan_esc_attr($name);?>[color]" />
								
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>

				<input type="hidden" id="typography-value"  name="<?php wan_esc_attr($name);?>" <?php $this->link();?>  value="<?php wan_esc_attr (  $values ) ;?>" />
				<input type="hidden" id="datas" data_subsets='<?php echo json_encode($this->titles_subsets);?>' data_variants = '<?php echo json_encode($this->titles);?>'/>
			</div>
		
		<?php
	}
		public function get_contents($fontFile) {
			ob_start();
			include  $fontFile;
			$file = ob_get_contents();
			ob_end_clean();
			return $file;
		}

		public function get_fonts( $amount = 300 )
		    {   global $wp_filesystem;
		        $fontFile = get_option('googleFonts');
		        $fonttime = get_option('font_time');
		        //Total time the file will be cached in seconds, set to a week
		        $cachetime = 86400 * 7;

		        if( $fontFile != false && current_time('timestamp') < $fonttime)
		        {	
		            $content = json_decode($fontFile);
		        } else {
		        	update_option('font_time',current_time('timestamp')+$cachetime);
		            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyCOYt9j4gB6udRh420WRKttoGoN38pzI7w';
		            $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
		            update_option('googleFonts',$fontContent['body']);
		            $content = json_decode($fontContent['body']);
		        }

		        if($amount == 'all')
		        {
		            return $content->items;
		        } else {
		            return array_slice($content->items, 0, $amount);
		        }
		    }
	}
}
