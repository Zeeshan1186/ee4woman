<?php
	/*	
	*	Goodlayers Html Option File
	*	---------------------------------------------------------------------
	*	This file create the class that help you create the input form element
	*	---------------------------------------------------------------------
	*/	
	
	if( !class_exists('frmaster_html_option') ){
		
		class frmaster_html_option{

			// call this function on wp_enqueue_script hook
			static function include_script($elements = array()){
				
				$elements = wp_parse_args($elements, array(
					'style' => 'html-option-meta'
				));				

				frmaster_include_utility_script();

				wp_enqueue_media();
				wp_enqueue_style('wp-color-picker');
				wp_enqueue_style('frmaster-html-option', FRMASTER_URL . '/framework/css/' . $elements['style'] . '.css');
				
				// enqueue the script
				wp_enqueue_script('frmaster-html-option', FRMASTER_URL . '/framework/js/html-option.js', array(
					'jquery', 'jquery-effects-core', 'wp-color-picker', 'jquery-ui-datepicker', 'jquery-ui-slider'
				), false, true);	
				
				// localize the script
				$html_option_val =  array();
				$html_option_val['text'] = array(
					'ajaxurl' => FRMASTER_AJAX_URL,
					'error_head' => esc_html__('An error occurs', 'frmaster'),
					'error_message' => esc_html__('Please refresh the page to try again. If the problem still persists, please contact administrator for this.', 'frmaster'),
					'nonce' => wp_create_nonce('frmaster_html_option'),
					'upload_media' => esc_html__('Select or Upload Media', 'frmaster'),
					'choose_media' => esc_html__('Use this media', 'frmaster'),
				);
				$html_option_val['tabs'] = array(
					'title_text' => esc_html__('Item\'s Title', 'frmaster'),
					'tab_checkbox_on' => esc_html__('On', 'frmaster'),
					'tab_checkbox_off' => esc_html__('Off', 'frmaster')
				);
				wp_localize_script('frmaster-html-option', 'html_option_val', $html_option_val);

			}
			
			// use to obtain input elements based on the settings variable
			static function get_element($settings){
				
				if( empty($settings['type']) || $settings['type'] == 'customizer-description' ) return;

				// column opening
				if( $settings['type'] == 'column' ){

					$column_class  = 'frmaster-column-' . (empty($settings['column-size'])? 6: $settings['column-size']) . ' ';
					$column_class .= empty($settings['bottom-divider'])? '': 'frmaster-column-bottom-divider';

					$ret  = '<div class="' . esc_attr($column_class) . '">';
					if( !empty($settings['right-divider']) ){
						$ret .= '<div class="frmaster-column-right-divider" ></div>';

						if( $settings['right-divider'] !== true ){
							$ret .= '<i class="frmaster-column-right-divider-icon ' . esc_attr($settings['right-divider']) . '" ></i>';
						}
					}

					return $ret;

				// closing column
				}else if( $settings['type'] == 'column-close' ){
					$ret  = '</div>';
					$ret .= empty($settings['clear'])? '': '<div class="clear"></div>';

					return $ret;

				// normal elements	
				}else{

					$wrapper_class  = empty($settings['wrapper-class'])? '': $settings['wrapper-class'];
					$wrapper_class .= ' frmaster-html-option-' . trim($settings['type']);
					if( $settings['type'] == 'custom' && !empty($settings['item-type']) ){
						$wrapper_class .= ' frmaster-html-option-custom-' . $settings['item-type'];
					}

					$condition = '';
					if( !empty($settings['condition']) ){
						$condition  = 'data-condition="' . esc_attr(json_encode($settings['condition'])) . '" ';
						$condition .= (empty($settings['condition-wrapper']))? '': 'data-condition-wrapper="' . esc_attr($settings['condition-wrapper']) . '" ';
					}
					
					
					$ret  = '<div class="frmaster-html-option-item ' . esc_attr($wrapper_class) . '-item" ' . $condition . ' >';
					
					if( !empty($settings['title']) ){
						$ret .= '<div class="frmaster-html-option-item-title" >' . $settings['title'] . '</div>';
					}
					
					if( !empty($settings['description']) && ($settings['type'] == 'custom' && $settings['item-type'] == 'group-discount') ){
						$ret .= '<div class="frmaster-html-option-item-description" >' . $settings['description'] . '</div>';
					}

					$ret .= '<div class="frmaster-html-option-item-input">';
					switch($settings['type']){
						case 'text': 
							$ret .= self::text($settings);
							break;
						case 'button': 
							$ret .= self::button($settings);
							break;
						case 'time': 
							$ret .= self::time($settings);
							break;
						case 'datepicker': 
							$ret .= self::datepicker($settings);
							break;
						case 'textarea': 
							$ret .= self::textarea($settings);
							break;
						case 'combobox':
							$ret .= self::combobox($settings);
							break;
						case 'multi-combobox':
							$ret .= self::multi_combobox($settings);
							break;
						case 'checkbox': 
							$ret .= self::checkbox($settings);
							break;
						case 'radioimage': 
							$ret .= self::radioimage($settings);
							break;
						case 'upload': 
							$ret .= self::upload($settings);
							break;
						case 'colorpicker': 
							$ret .= self::colorpicker($settings);
							break;
						case 'fontslider': 
							$ret .= self::fontslider($settings);
							break;
						case 'custom': 
							$ret .= self::custom($settings);
						 	break;
						case 'import': 
							$ret .= self::import($settings);
							break;
						case 'export': 
							$ret .= self::export($settings);
							break;
						default: break;
					}
					$ret .= '</div>';
					
					if( !empty($settings['description']) && !($settings['type'] == 'custom' && $settings['item-type'] == 'group-discount') ){
						$ret .= '<div class="frmaster-html-option-item-description" >' . $settings['description'] . '</div>';
					}
					
					if( !empty($settings['options']) && $settings['options'] == 'skin' ){
						$ret .= '<div class="frmaster-html-option-skin-edit" >' . esc_html__('Create Skin', 'frmaster') . '<i class="fa fa-plus-circle" ></i></div>';
					}

					$ret .= '<div class="clear"></div>';
					$ret .= '</div>'; // frmaster-html-option-item
					
					return $ret;
				}
			}
			
			//////////////////////////
			// element started here
			//////////////////////////			
			
			// input text
			static function text($settings){
				$value = '';
				
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( isset($settings['default']) ){
					$value = $settings['default'];
				}

				$ret  = '<input type="text" class="frmaster-html-option-text" data-type="text" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($value) . '" ';
				$ret .= empty($settings['data-input-type'])? '': ' data-input-type="' . esc_attr($settings['data-input-type']) . '"';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
	
				return $ret;
			}		
			
			// input text
			static function button($settings){
				$value = '';

				$ret  = '<div class="frmaster-html-option-button" ';
				$ret .= empty($settings['data-type'])? '': ' data-type="' . esc_attr($settings['data-type']) . '" '; 
				if( !empty($settings['data-type']) && $settings['data-type'] == 'ajax' ){
					$ret .= ' data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
					$ret .= ' data-post-id="' . esc_attr(get_the_ID()) . '" '; 
				}
				$ret .= empty($settings['data-action'])? '': ' data-action="' . esc_attr($settings['data-action']) . '" '; 
				$ret .= empty($settings['data-fields'])? '': ' data-fields="' . esc_attr(json_encode($settings['data-fields'])) . '" '; 
				$ret .= ' >' . $settings['button-title'] . '</div>';
	
				return $ret;
			}				

			// input time
			static function time($settings){
				$value = '';
				
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( isset($settings['default']) ){
					$value = $settings['default'];
				}

				$time_val = explode(':', $value);
				$hh = empty($time_val[0])? '': $time_val[0];
				$mm = empty($time_val[1])? '': $time_val[1];

				$ret  = '<input type="text" class="frmaster-html-option-time frmaster-input-hh" ';
				$ret .= 'placeholder="' . esc_html__('HH', 'frmaster') . '" ';
				$ret .= 'value="' . esc_attr($hh) . '" ';
				$ret .= empty($settings['data-input-type'])? '': ' data-input-type="' . esc_attr($settings['data-input-type']) . '"';
				$ret .= ' />';
				$ret .= '<span class="frmaster-html-option-time-sep" >:</span>';
				$ret .= '<input type="text" class="frmaster-html-option-time frmaster-input-mm" ';
				$ret .= 'placeholder="' . esc_html__('MM', 'frmaster') . '" ';
				$ret .= 'value="' . esc_attr($mm) . '" ';
				$ret .= empty($settings['data-input-type'])? '': ' data-input-type="' . esc_attr($settings['data-input-type']) . '"';
				$ret .= ' />';
				$ret .= '<input type="hidden" data-slug="' . esc_attr($settings['slug']) . '" data-type="text"  value="' . esc_attr($value) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
				
				return $ret;
			}	

			// input datepicker
			static function datepicker($settings){
				$value = '';
				
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( isset($settings['default']) ){
					$value = $settings['default'];
				}

				$ret  = '<input type="text" class="frmaster-html-option-text frmaster-html-option-datepicker" data-type="text" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($value) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
				$ret .= '<i class="frmaster-html-option-datepicker-icon fa fa-calendar" ></i>';
				return $ret;
			}			
			
			// textarea
			static function textarea($settings){
				$value = '';
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}

				$ret  = '<textarea class="frmaster-html-option-textarea" data-type="textarea" data-slug="' . esc_attr($settings['slug']) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' >' . esc_textarea($value) . '</textarea>';
	
				return $ret;
			}
			
			// combobox
			static function combobox($settings){
				$value = '';
				$extra_html = '';
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}

				if( $settings['options'] == 'sidebar' ){
					$settings['options'] = frmaster_get_sidebar_list(array('with-none'=>true));
				}else if( $settings['options'] == 'sidebar-default' ){
					$settings['options'] = frmaster_get_sidebar_list(array('with-none'=>true, 'with-default'=>true));
				}else if( $settings['options'] == 'thumbnail-size' ){
					$settings['options'] = frmaster_get_thumbnail_list();
				}
				
				$ret  = '<div class="frmaster-custom-combobox" >';
				$ret .= '<select class="frmaster-html-option-combobox" data-type="combobox" data-slug="' . esc_attr($settings['slug']) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' >';
				if( !empty($settings['options']) ){
					foreach($settings['options'] as $option_key => $option_value ){
						$ret .= '<option value="' . esc_attr($option_key) . '" ' . selected($value, $option_key, false) . ' >' . $option_value . '</option>';
					}
				}
				$ret .= '</select>';
				$ret .= '</div>';
				
				return $ret;
			}
			
			// multi_combobox
			static function multi_combobox($settings){
				$value = array();
				if( isset($settings['value']) ){
					$value = empty($settings['value'])? array(): $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				if( !empty($settings['options']) ){
					if( $settings['options'] == 'post_type' ){
						$settings['options'] = frmaster_get_post_list($settings['options-data']);
					}
				}

				$ret  = '<select class="frmaster-html-option-multi-combobox" data-type="multi-combobox" data-slug="' . esc_attr($settings['slug']) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' multiple >';
				if( !empty($settings['options']) ){
					foreach($settings['options'] as $option_key => $option_value ){
						$ret .= '<option value="' . esc_attr($option_key) . '" ' . (in_array($option_key, $value)? 'selected': '') . ' >' . $option_value . '</option>';
					}
				}
				$ret .= '</select>';
				
				return $ret;
			}			
			
			// checkbox
			static function checkbox($settings){
				$value = '';
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}else{
					$value = 'enable';
				}
				
				$ret  = '<label>';
				$ret .= '<input type="checkbox" class="frmaster-html-option-checkbox" data-type="checkbox" data-slug="' . esc_attr($settings['slug']) . '" ' . checked($value, 'enable', false) . ' ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
				$ret .= '<div class="frmaster-html-option-checkbox-appearance frmaster-noselect">';
				$ret .= '<span class="frmaster-checkbox-button frmaster-on">' . esc_html__('On', 'frmaster') . '</span>';
				$ret .= '<span class="frmaster-checkbox-separator"></span>';
				$ret .= '<span class="frmaster-checkbox-button frmaster-off">' . esc_html__('Off', 'frmaster') . '</span>';
				$ret .= '</div>';
				$ret .= '</label>';
				
				return $ret;
			}		
			
			// radioimage
			static function radioimage($settings){

				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}else{
					reset($settings['options']);
					$value = key($settings['options']);
				}

				$max_width = empty($settings['max-width'])? '': $settings['max-width'];

				if( $settings['options'] == 'sidebar' ){
					$settings['options'] = array(
						'none' => FRMASTER_URL . '/framework/images/sidebar/none.jpg',
						'left' => FRMASTER_URL . '/framework/images/sidebar/left.jpg',
						'right' => FRMASTER_URL . '/framework/images/sidebar/right.jpg',
						'both' => FRMASTER_URL . '/framework/images/sidebar/both.jpg',
					);

					if( !empty($settings['with-default']) ){
						$settings['options'] = array_merge(array(
							'default' => FRMASTER_URL . '/framework/images/sidebar/default.jpg',
						), $settings['options']);
					}
					if( !empty($settings['without-none']) ){
						unset($settings['options']['none']);
					}
				}

				$ret = '';
				foreach( $settings['options'] as $option_key => $option_url ){
					$ret .= '<label ' . frmaster_esc_style(array('max-width'=> $max_width)) . ' >';
					$ret .= '<input class="frmaster-html-option-radioimage" type="radio" name="' . esc_attr($settings['slug']) . '" data-type="radioimage" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($option_key) . '" ' . checked($value, $option_key, false) . '/>';
					$ret .= '<div class="frmaster-radioimage-checked" ></div>';
					$ret .= '<img src="' . esc_url($option_url) . '" alt="' . esc_attr($option_key) . '" />';
					$ret .= '</label>';
				}
				
				return $ret;
			}
			
			// upload
			static function upload($settings){
				$value = '';
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}
				
				$ret  = '<div class="frmaster-html-option-upload-appearance ' . (empty($value)? '': 'frmaster-active') . '" >';
				$ret .= '<input type="hidden" class="frmaster-html-option-upload" data-type="upload" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($value) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
				
				$ret .= '<div class="frmaster-upload-image-container" style="' . (empty($value)? '': 'background-image: url(\'' . esc_url(wp_get_attachment_url($value)) . '\');') . '" ></div>';
				
				$ret .= '<div class="frmaster-upload-image-overlay" >';
				$ret .= '<div class="frmaster-upload-image-button-hover">';
				$ret .= '<span class="frmaster-upload-image-button frmaster-upload-image-add"><i class="fa fa-plus" ></i></span>';
				$ret .= '<span class="frmaster-upload-image-button frmaster-upload-image-remove"><i class="fa fa-minus" ></i></span>';
				$ret .= '</div>'; // frmaster-upload-image-hover
				$ret .= '</div>'; // frmaster-upload-image-overlay
				$ret .= '</div>'; // frmaster-html-option-upload-appearance
				
				return $ret;
			}
			
			// colorpicker
			static function colorpicker($settings){
				$value = ''; $default = '';
				if( !empty($settings['default']) ){
					$default = $settings['default'];
				}
				
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($default) ){
					$value = $default;
				}
				
				$ret = '<input type="text" class="frmaster-html-option-colorpicker" data-type="colorpicker" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($value) . '" data-default-color="' . esc_attr($default) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= ' />';
	
				return $ret;
			}

			// fontslider
			static function fontslider($settings){
				$value = '';
				if( !empty($settings['value']) || (isset($settings['value']) && $settings['value'] === '0') ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}else{
					$value = 0;
				}

				if( !empty($settings['data-type']) && $settings['data-type'] == 'opacity' ){
					$settings['data-min'] = 0;
					$settings['data-max'] = 100;
					$settings['data-suffix'] = 'none';
				}
				
				$ret  = '<input type="text" class="frmaster-html-option-fontslider" data-type="text" value="' . esc_attr($value) . '" ';
				$ret .= 'data-slug="' . esc_attr($settings['slug']) . '" ';
				$ret .= isset($settings['data-min'])? 'data-min-value="' . esc_attr($settings['data-min']) . '" ': '';
				$ret .= isset($settings['data-max'])? 'data-max-value="' . esc_attr($settings['data-max']) . '" ': '';
				$ret .= isset($settings['data-suffix'])? ' data-suffix="' . esc_attr($settings['data-suffix']) . '" ': '';
				$ret .= ' />';
				
				return $ret;
			}			
			
			// custom
			static function custom($settings){
				$value = '';
				if( isset($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}

				$ret  = '<div class="frmaster-html-option-custom" data-type="custom" data-item-type="' . esc_attr($settings['item-type']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				$ret .= empty($settings['data-input-type'])? '': ' data-input-type="' . esc_attr($settings['data-input-type']) . '" ';
				$ret .= empty($settings['with-name'])? '': ' name="' . esc_attr($settings['slug']) . '"';
				$ret .= '>';
				if( !empty($settings['settings']) ){
					$ret .= '<span class="frmaster-html-option-custom-settings" data-value="' . esc_attr(json_encode($settings['settings'])) . '" ></span>';
				}
				if( !empty($settings['options']) ){
					$ret .= '<span class="frmaster-html-option-custom-options" data-value="' . esc_attr(json_encode($settings['options'])) . '" ></span>';
				}
				if( !empty($value) ){
					$ret .= '<span class="frmaster-html-option-custom-value" data-value="' . esc_attr(json_encode($value)) . '" ></span>';
				}
				$ret .= '</div>';
	
				return $ret;
			}

			// import
			static function import($settings){

				$ret  = '<div class="frmaster-html-option-import" >';
				$ret .= '<form method="post" enctype="multipart/form-data" >';
				$ret .= '<input class="frmaster-html-option-import-file" type="file" name="frmaster-import" >';
				$ret .= '<div class="frmaster-html-option-import-button" >' . esc_html__('Import', 'frmaster') . '</div>';
				$ret .= '</form>';
				$ret .= '</div>';
	
				return $ret;
			}

			// export
			static function export($settings){

				$ret  = '<div class="frmaster-html-option-export" data-action="' . esc_attr($settings['action']) . '" >';
				if( !empty($settings['options']) ){
					$ret .= '<div class="frmaster-custom-combobox" >';
					$ret .= '<select class="frmaster-html-option-export-option frmaster-html-option-combobox" data-type="combobox" >';
					if( !empty($settings['options']) ){
						foreach($settings['options'] as $option_key => $option_value ){
							$ret .= '<option value="' . esc_attr($option_key) . '" >' . $option_value . '</option>';
						}
					}
					$ret .= '</select>';
					$ret .= '</div>';
				}
				$ret .= '<div class="frmaster-html-option-export-button" >' . esc_html__('Export', 'frmaster') . '</div>';
				$ret .= '</div>';
	
				return $ret;
			}			
			
		} // frmaster_html_option
	
	} // class_exists