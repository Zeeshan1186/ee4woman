<?php
	/*	
	*	Utility function for uses
	*/

	// price comparing function
	if( !function_exists('frmaster_compare_price') ){
		function frmaster_compare_price( $price1, $price2 ){

			if( abs(floatval($price1) - floatval($price2)) <= 0.01 ){
				return true;
			}else{
				return false;
			}

		}
	}

	if( !function_exists('frmaster_money_format') ){
		function frmaster_money_format( $amount, $digit = -1 ){
			if( $digit == -1 ){
				$digit = frmaster_get_option('general', 'price-decimal-digit', '2');
			
			// custom
			}else if( $digit == -2 ){
				if( $amount == intval($amount) ){
					$digit = 0;
				}else{
					$digit = frmaster_get_option('general', 'price-decimal-digit', '2');
				}
			
			}

			// round every number down
			$amount = round($amount, $digit);

			// format number
			$thousand = frmaster_get_option('general', 'price-thousand-separator', ',');
			$decimal_sign = frmaster_get_option('general', 'price-decimal-separator', '.');

			$format = frmaster_get_option('general', 'money-format', '$NUMBER');
			$amount = number_format($amount, $digit, $decimal_sign, $thousand);
			return str_replace('NUMBER', $amount, $format);
		}
	}
	if( !function_exists('frmaster_date_format') ){
		function frmaster_date_format( $date, $format = '' ){
			$format = empty($format)? get_option('date_format'): $format;
			$date = is_numeric($date)? $date: strtotime($date);
			return date_i18n($format, $date);
		}
	}

	add_action('wp_enqueue_scripts', 'frmaster_include_lightbox');
	if( !function_exists('frmaster_include_lightbox') ){
		function frmaster_include_lightbox($atts){	
			if( !function_exists('gdlr_core_get_lightbox_atts') ){
				wp_enqueue_style('lightgallery', FRMASTER_URL . '/plugins/lightgallery/lightgallery.css');
				wp_enqueue_script('lightgallery', FRMASTER_URL . '/plugins/lightgallery/lightgallery.js', array('jquery'), false, true);
			}
		}
	}

	// lightbox 
	if( !function_exists('frmaster_get_lightbox_atts') ){
		function frmaster_get_lightbox_atts($atts){
			if( function_exists('gdlr_core_get_lightbox_atts') ){
				return gdlr_core_get_lightbox_atts($atts);
			}else{
				$ret  = ' class="frmaster-lightgallery ' . (empty($atts['class'])? '': $atts['class']) . '" ';
				$ret .= empty($atts['url'])? '': ' href="' . esc_url($atts['url']) . '"';
				$ret .= empty($atts['caption'])? '': ' data-sub-html="' . esc_attr($atts['caption']) . '"';
				$ret .= empty($atts['group'])? '': ' data-lightbox-group="' . esc_attr($atts['group']) . '"';

				return $ret;
			}
		}
	}

	if( !function_exists('frmaster_lightbox_content') ){
		function frmaster_lightbox_content( $settings = array() ){

			$ret  = '<div class="frmaster-lightbox-content-wrap" data-frmlb-id="' . $settings['id'] . '" >';
			if( !empty($settings['title']) ){
				$ret .= '<div class="frmaster-lightbox-head" >';
				$ret .= '<h3 class="frmaster-lightbox-title" >' . $settings['title'] . '</h3>';
				$ret .= '<i class="frmaster-lightbox-close icon_close" ></i>';
				$ret .= '</div>';
			}

			if( !empty($settings['content']) ){
				$ret .= '<div class="frmaster-lightbox-content" >' . $settings['content'] . '</div>';
			}
			$ret .= '</div>';

			return $ret;
		} // frmaster_lightbox_content
	}

	if( !function_exists('frmaster_match_curly_braces') ){
		function frmaster_match_curly_braces( $string ){
			$ret = array();

			$start = strpos($string, '{');
			$end = 0;
			while( $start !== false && $end !== false ){
				$string = substr($string, $start);
				$start = 0;
				$end = strpos($string, '}');

				$ret[] = substr($string, $start, $end + 1);
				$start = strpos($string, '{', $end);
			}

			return $ret;
		}
	}
	if( !function_exists('frmaster_read_custom_fields') ){
		function frmaster_read_custom_fields( $string ){

			$custom_fields = array();

			// match every { }
			$matches = frmaster_match_curly_braces($string);
			if( !empty($matches) ){
				foreach( $matches as $match ){

					$field = array();

					// remove unnecessary string out and separate each attribute
					$match = str_replace(array("{", "}", "\r\n", "\n"), "", $match);
					$match = explode(',', $match);
					if( !empty($match) ){
						foreach( $match as $att ){
							$att = explode('=', $att);
							if( !empty($att) && sizeof($att) == 2 ){
								if( $att[0] == 'options' ){
									$field[$att[0]] = array();
									$options = explode('/', $att[1]);
									if( !empty($field['title']) ){
										$field[$att[0]][''] = $field['title'];
									}

									foreach($options as $option){
										$field[$att[0]][$option] = $option;
									}
								}else if( $att[0] == 'type' && $att[1] == 'country' ){
									$field['type'] = 'combobox';
									$field['options'] = frmaster_get_country_list();
									$field['default'] = frmaster_get_option('general', 'user-default-country', '');
								}else{
									$field[$att[0]] = $att[1];
								}
								
							}  
						}
					}

					$custom_fields[$field['slug']] = $field;	
				}
			}

			return $custom_fields;
		}
	}

	// display form
	if( !function_exists('frmaster_get_form_field') ){
		function frmaster_get_form_field( $settings, $slug, $value = '' ){

			if( isset($settings['echo']) && $settings['echo'] === false ){
				ob_start();
			}

			$user_id = get_current_user_id();
			$extra_class = 'frmaster-' . $slug . '-field-' . $settings['slug'];
			$field_value = '';
			if( !empty($value) ){
				$field_value = $value;
			}else if( !empty($_POST[$settings['slug']]) ){
				$field_value = $_POST[$settings['slug']];
			}else if( !empty($user_id) ){
				$field_value = frmaster_get_user_meta($user_id, $settings['slug']);
			}

			if( empty($field_value) && !empty($settings['default']) ){
				$field_value = $settings['default'];
			}

			$data = '';
			if( !empty($settings['data']) && !empty($settings['data']['slug']) && !empty($settings['data']['value']) ){
				$data = ' data-' . esc_attr($settings['data']['slug']) . '="' . esc_attr($settings['data']['value']) . '" ';
			}
			if( !empty($settings['type']) ){
				$extra_class .= ' frmaster-type-' . $settings['type'];
			}

			echo '<div class="frmaster-' . esc_attr($slug) . '-field ' . esc_attr($extra_class) . ' clearfix" >';
			if( !isset($settings['label']) || $settings['label'] ){
				echo '<div class="frmaster-head" >';
				if( !empty($settings['title']) ){
					echo $settings['title'];
				}
				if( !empty($settings['required']) && ($settings['required'] === true || $settings['required'] == "true") ){
					echo '<span class="frmaster-req" >*</span>';
					$data .= ' data-required ';
				}
				echo '</div>';
			}

			if( !empty($settings['placeholder']) ){
				$data  = ' placeholder="' . $settings['title'];
				if( !empty($settings['required']) && ($settings['required'] === true || $settings['required'] == "true") ){
					$data .= '*';
				}
				$data .= '" ';
			}

			echo '<div class="frmaster-tail clearfix" >';
			if( !empty($settings['pre-input']) ){
				echo $settings['pre-input'];
			}
			
			switch($settings['type']){
				case 'textarea':
					echo '<textarea name="' . esc_attr($settings['slug']) . '" ' . $data . ' >' . esc_textarea($field_value) . '</textarea>';
					break;
				case 'email':
					echo '<input type="email" name="' . esc_attr($settings['slug']) . '" value="' . esc_attr($field_value) . '" ' . $data . ' />';
					break;
				case 'text':
					echo '<input type="text" name="' . esc_attr($settings['slug']) . '" value="' . esc_attr($field_value) . '" ' . $data . ' />';
					break;
				case 'price-edit':
					echo '<div class="frmaster-price-edit-head" >';
					echo '<input type="text" name="' . esc_attr($settings['slug']) . ((!empty($settings['data-type']) && $settings['data-type'] == 'array')? '[]': '') . '" value="' . esc_attr($field_value) . '" ' . $data . ' />';
					echo '</div>';
					if( !empty($settings['description']) ){
						echo '<div class="frmaster-price-edit-tail">' . $settings['description'] . '</div>';
					}
					break;
				case 'file':
					echo '<label class="frmaster-file-label" >';
					echo '<span class="frmaster-file-label-text" data-default="' . esc_attr__('Click to select a file', 'frmaster') . '" >' . esc_html__('Click to select a file', 'frmaster') . '</span>';
					echo '<input type="file" name="' . esc_attr($settings['slug']) . '" ' . $data . ' />';
					echo '</label>';
					break;
				case 'password':
					echo '<input type="password" name="' . esc_attr($settings['slug']) . '" value="' . esc_attr($field_value) . '" ' . $data . ' />';
					break;
				case 'combobox':
					echo '<div class="frmaster-combobox-wrap" >';
					echo '<select name="' . esc_attr($settings['slug']) . '" ' . $data . ' >';
					foreach( $settings['options'] as $option_val => $option_title ){
						echo '<option value="' . esc_attr($option_val) . '" ' . ($field_value == $option_val? 'selected': '') . ' >' . $option_title . '</option>';
					}
					echo '</select>';
					echo '</div>';
					break;

				case 'datepicker':
						echo '<input type="text" class="frmaster-datepicker" name="' . esc_attr($settings['slug']) . '" value="' . esc_attr($field_value) . '" />';
						echo '<i class="fa fa-calendar" ></i>';
					break;

				case 'date':
					echo '<div class="frmaster-date-select" >';
					$selected_date = explode('-', $field_value);

					$date = empty($selected_date[2])? '': intval($selected_date[2]);
					echo '<div class="frmaster-combobox-wrap frmaster-form-field-alt-date" >';
					echo '<select type="text" data-type="date" >';
					echo '<option value="" ' . (empty($date)? 'selected': '' ) . ' >' . esc_html__('Date', 'frmaster') . '</option>';
					for( $i = 1; $i <= 31; $i++ ){
						echo '<option value="' . esc_attr($i) . '" ' . (($i == $date)? 'selected': '' ) . ' >' . $i . '</option>';
					}
					echo '</select>';
					echo '</div>'; // frmaster-combobox-wrap

					$month = empty($selected_date[1])? '': intval($selected_date[1]);
					echo '<div class="frmaster-combobox-wrap frmaster-form-field-alt-month" >';
					echo '<select type="text" data-type="month" >';
					echo '<option value="" ' . (empty($month)? 'selected': '' ) . ' >' . esc_html__('Month', 'frmaster') . '</option>';
					for( $i = 1; $i <= 12; $i++ ){
						echo '<option value="' . esc_attr($i) . '" ' . (($i == $month)? 'selected': '' ) . ' >' . date_i18n('F', strtotime('2016-' . $i . '-1')) . '</option>';
					}
					echo '</select>';
					echo '</div>'; // frmaster-combobox-wrap

					$current_year = date('Y');
					$start_year = $current_year - 120;
					$year = empty($selected_date[0])? '': intval($selected_date[0]);
					echo '<div class="frmaster-combobox-wrap frmaster-form-field-alt-year" >';
					echo '<select type="text" data-type="year" >';
					echo '<option value="" ' . (empty($year)? 'selected': '' ) . ' >' . esc_html__('Year', 'frmaster') . '</option>';
					for( $i = $current_year; $i >= $start_year; $i-- ){
						echo '<option value="' . esc_attr($i) . '" ' . (($i == $year)? 'selected': '' ) . ' >' . $i . '</option>';
					}
					echo '</select>';
					echo '</div>'; // frmaster-combobox-wrap

					echo '</div>'; // frmaster date select
					echo '<input type="hidden" name="' . esc_attr($settings['slug']) . '" value="' . esc_attr($field_value) . '" />';
					break;
			}
			echo '</div>';
			echo '</div>'; // frmaster-edit-profile-field	

			if( isset($settings['echo']) && $settings['echo'] === false ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // frmaster_get_form_field
	}	