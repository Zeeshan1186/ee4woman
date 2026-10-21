<?php
	/*	
	*	Fundraising Master Plugin
	*	---------------------------------------------------------------------
	*	for table query
	*	---------------------------------------------------------------------
	*/

	if( !function_exists('frmaster_insert_booking_data') ){
		function frmaster_insert_booking_data( $booking_detail, $order_status = 'pending', $payment_info = array(), $recurring_order_id = '' ){

			global $wpdb;

			$data = array(
				'user_id' => empty($booking_detail['donation-bar']['user-id'])? '': $booking_detail['donation-bar']['user-id'],
				'cause_id' => $booking_detail['donation-bar']['cause-id'],
				'booking_date' => current_time('mysql'),
				'booking_detail' => json_encode($booking_detail),
				'donation_amount' => $booking_detail['donation-bar']['donation-amount'],
				'order_status' => $order_status,
			);
			$format = array('%d', '%d', '%s', '%s', '%s', '%s');

			if( !empty($payment_info) ){
				$data['payment_info'] = json_encode($payment_info);
				$format[] = '%s';

				$data['payment_date'] = $payment_info['submission_date'];
				$format[] = '%s';
			}

			if( !empty($recurring_order_id) ){
				$data['recurring_order_id'] = $recurring_order_id;
				$format[] = '%d';
			}


			if( $wpdb->insert("{$wpdb->prefix}frmaster_order", $data, $format) ){
				return $wpdb->insert_id;
			}else{
				return false;
			}

		} // frmaster_insert_booking_data
	}

	if( !function_exists('frmaster_update_booking_data') ){
		function frmaster_update_booking_data( $data, $condition ){

			global $wpdb;

			$format = array();
			foreach( $data as $slug => $value ){
				if( in_array($slug, array('id', 'user_id', 'cause_id')) ){
					$format[] = '%d';
				}else{
					$format[] = '%s';
				}
			}

			$condition_format = array();
			foreach( $condition as $slug => $value ){
				if( in_array($slug, array('id', 'user_id', 'cause_id')) ){
					$condition_format[] = '%d';
				}else{
					$condition_format[] = '%s';
				}
			}

			return $wpdb->update("{$wpdb->prefix}frmaster_order", $data, $condition, $format, $condition_format);

		} // frmaster_update_booking_data
	}

	if( !function_exists('frmaster_get_booking_data') ){
		function frmaster_get_booking_data( $conditions = array(), $settings = null, $column = '*' ){
			global $wpdb;
			$first_condition = true;

			$sql  = 'SELECT ' . $column . ' FROM ' . $wpdb->prefix . 'frmaster_order ';

			// where clause
			foreach($conditions as $condition_slug => $condition){
				if( $first_condition ){
					$first_condition = false;

					$sql .= 'WHERE ';
				}else{
					$sql .= 'AND ';
				}

				
				if( !empty($condition) && ($condition == 'IS NOT NULL' || $condition == 'IS NULL') ){
					$sql .= esc_sql($condition_slug);
					$sql .= ' ' . $condition . ' ';
				}else if( is_array($condition) ){
					if( empty($condition['hide-prefix']) ){
						$sql .= esc_sql($condition_slug);
					}

					if( !empty($condition['condition']) && !empty($condition['value']) ){
						$sql .= $condition['condition'] . '\'' . esc_sql($condition['value']) . '\' ';
					}else if( !empty($condition['custom']) ){
						$sql .= $condition['custom'];
					}
				}else{
					$sql .= esc_sql($condition_slug);
					$sql .= '=\'' . esc_sql($condition) . '\' ';
				}
			}

			// order 
			$settings['orderby'] = empty($settings['orderby'])? 'id': $settings['orderby'];
			$settings['order'] = empty($settings['order'])? 'desc': $settings['order'];
			$sql .= 'ORDER BY ' . esc_sql($settings['orderby']) . ' ' . esc_sql($settings['order']) . ' ';

			if( !empty($settings['paged']) && !empty($settings['num-fetch']) ){
				$paged = intval($settings['paged']);
				$num_fetch = intval($settings['num-fetch']);

				if( $settings['paged'] <= 1 ){
					$sql .= 'LIMIT ' . esc_sql($num_fetch);
				}else{
					$sql .= 'LIMIT ' . esc_sql(($paged - 1) * $num_fetch) . ',' . $num_fetch;
				}
			}

			// pagination	
			if( !empty($settings['single']) ){
				return $wpdb->get_row($sql);	
			}else if( $column == 'COUNT(*)' || $column == 'count(*)' || strpos($column, 'SUM') !== false ){
				return $wpdb->get_var($sql);
			}else{
				return $wpdb->get_results($sql);	
			}
			
		} // frmaster_get_booking_data
	}

	if( !function_exists('frmaster_remove_booking_data') ){
		function frmaster_remove_booking_data( $id, $user_id = '' ){
			global $wpdb;

			$args = array( 'id' => $id ); 
			if( !empty($user_id) ){
				$args['user_id'] = $user_id;
			}

			return $wpdb->delete("{$wpdb->prefix}frmaster_order", $args);
		}
	}