<?php
	/*	
	*	Ordering Page
	*/

	if( !function_exists('frmaster_order_edit_text') ){
		function frmaster_order_edit_text($frmlb = ''){
			return '<a class="frmaster-order-edit-text" href="#" data-frmlb="' . esc_attr($frmlb) . '" >' . esc_html__('Edit', 'frmaster') . '<i class="fa fa-edit" ></i></a>';
		}
	}

	if( !function_exists('frmaster_order_edit_form') ){
		function frmaster_order_edit_form( $result, $type = '' ){
			$ret  = '<form class="frmaster-order-edit-form frmaster-type-' . esc_attr($type) . '" action="" method="post" data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" >';

			if( $type == 'contact-details' ){

				$data = json_decode($result->booking_detail, true);
				$profile_fields = frmaster_get_profile_fields();

				foreach( $profile_fields as $field_slug => $field ){
					$value = empty($data['register-form'][$field_slug])? '': $data['register-form'][$field_slug];

					$field['slug'] = $field_slug;
					$field['echo'] = false;

					$ret .= frmaster_get_form_field($field, 'order-edit', $value);
				}

			}

			$ret .= '<div class="frmaster-order-edit-form-load" >' . esc_html__('Now loading', 'frmaster') . '</div>';
			$ret .= '<div class="frmaster-order-edit-form-error" >' . esc_html__('An error occurs, please check console for more information', 'frmaster') . '</div>';
			$ret .= '<input type="hidden" name="tid" value="' . esc_attr($result->id) . '" />';
			$ret .= '<input type="hidden" name="type" value="' . esc_attr($type) . '" />';
			$ret .= '<input type="hidden" name="action" value="frmaster_order_edit" />';
			
			if( $type != 'new_order' ){
				$ret .= '<input type="submit" class="frmaster-order-edit-submit" value="' . esc_attr__('Submit', 'frmaster') . '" />';
			}

			$ret .= '</form>';

			return $ret;
		}
	}

	add_action('wp_ajax_frmaster_order_edit', 'frmaster_order_edit');
	if( !function_exists('frmaster_order_edit') ){
		function frmaster_order_edit(){

			$data = frmaster_process_post_data($_POST);

			// contact & billing details
			if( $data['type'] == 'contact-details' ){

				$result = frmaster_get_booking_data(array('id' => $data['tid']), array('single' => true));
				$data_orig = json_decode($result->booking_detail, true);
				$profile_fields = frmaster_get_profile_fields();

				foreach( $profile_fields as $field_slug => $field ){
					if( !empty($data[$field_slug]) ){
						$data_orig['register-form'][$field_slug] = $data[$field_slug];
					}
				}

				frmaster_update_booking_data(
					array(
						'booking_detail' => json_encode($data_orig)
					), 
					array('id' => $data['tid'])
				);
				
				die(json_encode(array('status' => 'success')));

			}
			
		}
	}