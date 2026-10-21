<?php
	/*	
	*	Ordering Page
	*/

	add_action('admin_menu', 'frmaster_init_order_page', 99);
	if( !function_exists('frmaster_init_order_page') ){
		function frmaster_init_order_page(){
			add_menu_page(
				esc_html__('Transaction Order', 'frmaster'), 
				esc_html__('Transaction Order', 'frmaster'),
				'manage_cause_order', 
				'frmaster_order', 
				'frmaster_create_order_page',
				FRMASTER_URL . '/framework/images/admin-option-icon.png',
				120
			);
		}
	}

	// add the script when opening the theme option page
	add_action('admin_enqueue_scripts', 'frmaster_order_page_script');
	if( !function_exists('frmaster_order_page_script') ){
		function frmaster_order_page_script($hook){
			if( strpos($hook, 'page_frmaster_order') !== false ){
				frmaster_include_utility_script(array(
					'font-family' => 'Open Sans'
				));

				wp_enqueue_style('frmaster-order', FRMASTER_URL . '/include/css/order.css');
				wp_enqueue_script('frmaster-order', FRMASTER_URL . '/include/js/order.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), false, true);
			}
		}
	}

	/*
	if( !function_exists('frmaster_order_csv_export') ){
		function frmaster_order_csv_export( $results ){

			// define constant
			$current_url = (is_ssl()? "https": "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$statuses = array(
				'all' => __('All', 'frmaster'),
				'pending' => __('Pending', 'frmaster'),
				'approved' => __('Approved', 'frmaster'),
				'receipt-submitted' => __('Receipt Submitted', 'frmaster'),
				'online-paid' => __('Online Paid', 'frmaster'),
				'deposit-paid' => __('Deposit Paid', 'frmaster'),
				'departed' => __('Departed', 'frmaster'),
				'rejected' => __('Rejected', 'frmaster'),
				'cancel' => __('Cancel', 'frmaster'),
				'wait-for-approval' => __('Wait For Approval', 'frmaster'),
			);

			// print it as file
			$fp = fopen(FRMASTER_LOCAL . '/include/js/order.csv', 'w');
			fputcsv($fp, array(
				__('Order ID', 'frmaster'),
				__('Tour Name', 'frmaster'),
				__('Contact Name', 'frmaster'),
				__('Contact Email', 'frmaster'),
				__('Contact Number', 'frmaster'),
				__('Customer\'s Note', 'frmaster'),
				__('Booking Date', 'frmaster'),
				__('Travel Date', 'frmaster'),
				__('Total Price', 'frmaster'),
				__('Traveller Info', 'frmaster'),
				__('Payment Status', 'frmaster'),
				__('Link To Transaction', 'frmaster'),
			));
			foreach( $results as $result ){
				$contact_info = json_decode($result->contact_info, true);

				$traveller_detail = '';
				$traveller_info = json_decode($result->traveller_info, true);

				$tour_option = frmaster_get_post_meta($result->tour_id, 'frmaster-tour-option');
				$booking_detail = empty($result->booking_detail)? array(): json_decode($result->booking_detail, true);
				if( !empty($tour_option['additional-traveller-fields']) ){
					$additional_traveller_fields = $tour_option['additional-traveller-fields'];
				}else{
					$additional_traveller_fields = frmaster_get_option('general', 'additional-traveller-fields', '');
				}
				if( !empty($additional_traveller_fields) ){
					$additional_traveller_fields = frmaster_read_custom_fields($additional_traveller_fields);
				}

				if( !empty($traveller_info['first_name']) ){
					$traveller_num = sizeof($traveller_info['first_name']);

					for( $i = 0; $i < $traveller_num; $i++ ){
						if( !empty($traveller_detail) ){
							$traveller_detail .= ", \n";
						}

						foreach( $traveller_info as $key => $traveller ){
							if( !empty($traveller[$i]) ){
								$traveller_detail .= $traveller[$i] . ' ';
							}
						}

						if( !empty($additional_traveller_fields) ){
							foreach( $additional_traveller_fields as $field ){
								if( !empty($booking_detail['traveller_' . $field['slug']][$i]) ){
									$traveller_detail .= ' | ' . $booking_detail['traveller_' . $field['slug']][$i];
								}
							}
						}
					}
				}

				fputcsv($fp, array(
					'#' . $result->id,
					html_entity_decode(get_the_title($result->tour_id)),
					$contact_info['first_name'] . ' ' . $contact_info['last_name'],
					$contact_info['email'],
					$contact_info['phone'],
					empty($contact_info['additional_notes'])? ' ': $contact_info['additional_notes'],
					frmaster_date_format($result->booking_date),
					frmaster_date_format($result->travel_date),
					frmaster_money_format($result->total_price),
					$traveller_detail,
					$statuses[$result->order_status],
					add_query_arg(
						array('single'=>$result->id), 
						remove_query_arg(array('order_id', 'from_date', 'to_date', 'action', 'id', 'export'), $current_url)
					)
				));
			}
			fclose($fp);

// script for user to download
?><script>
	jQuery(document).ready(function(){
		var element = document.createElement('a');
		element.setAttribute('href', '<?php echo esc_js(FRMASTER_URL . '/include/js/order.csv'); ?>');
		element.setAttribute('download', 'transaction.csv');
		
		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();
		document.body.removeChild(element);
	});
</script><?php

		} // frmaster_order_csv_export
	}
	*/

	if( !function_exists('frmaster_create_order_page') ){
		function frmaster_create_order_page(){

			// print order
			if( !isset($_GET['single']) ){
				$action_url = remove_query_arg(array('order_id'));

				$statuses = array(
					'all' => esc_html__('All', 'frmaster'),
					'pending' => esc_html__('Pending', 'frmaster'),
					'approved' => esc_html__('Approved', 'frmaster'),
					'online-paid' => esc_html__('Online Paid', 'frmaster'),
					'rejected' => esc_html__('Rejected', 'frmaster'),
					'cancel' => esc_html__('Cancel', 'frmaster')
				);
?>
<div class="frmaster-order-filter-wrap" >
	<form class="frmaster-order-search-form" method="get" action="<?php echo esc_url($action_url); ?>" >
		<label><?php esc_html_e('Search by order id :', 'frmaster'); ?></label>
		<input type="text" name="order_id" value="<?php echo empty($_GET['order_id'])? '': esc_attr($_GET['order_id']); ?>" />
		<input type="hidden" name="page" value="frmaster_order" />
		<input type="submit" value="<?php esc_html_e('Search', 'frmaster'); ?>" />
	</form>
	<form class="frmaster-order-search-form" method="get" action="<?php echo esc_url($action_url); ?>" >
		<div style="margin-bottom: 10px;" >
			<label><?php esc_html_e('Select Cause :', 'frmaster'); ?></label>
			<select name="cause_id" ><?php
				$cause_list = frmaster_get_post_list('cause');
				echo '<option value="" >' . esc_html__('All', 'frmaster') . '</option>';
				foreach( $cause_list as $cause_id => $cause_name ){
					echo '<option value="' . esc_attr($cause_id) . '" ' . ((!empty($_GET['cause_id']) && $_GET['cause_id'] == $cause_id)? 'selected': '') . ' >' . esc_html($cause_name) . '</option>';
				}	
			?></select>
			<br>
		</div>
		<label><?php esc_html_e('Payment Date Filter :', 'frmaster'); ?></label>
		<span class="frmaster-separater" ><?php esc_html_e('From', 'frmaster') ?></span>
		<input class="frmaster-datepicker" type="text" name="from_date" value="<?php echo empty($_GET['from_date'])? '': esc_attr($_GET['from_date']); ?>" />
		<span class="frmaster-separater" ><?php esc_html_e('To', 'frmaster') ?></span>
		<input class="frmaster-datepicker" type="text" name="to_date" value="<?php echo empty($_GET['to_date'])? '': esc_attr($_GET['to_date']); ?>" />
		<input type="hidden" name="page" value="frmaster_order" />
		<input type="hidden" name="export" value="0" />
		<input type="submit" value="<?php esc_html_e('Filter', 'frmaster'); ?>" />
		<!-- <input id="frmaster-csv-export" type="button" value="<?php esc_html_e('Export To CSV', 'frmaster'); ?>" /> -->
	</form>
	<div class="frmaster-order-filter" >
	<?php
		$order_status = empty($_GET['order_status'])? 'all': $_GET['order_status'];
		foreach( $statuses as $status_slug => $status ){
			echo '<span class="frmaster-separator" >|</span>';
			echo '<a href="' . esc_url(add_query_arg(array('order_status'=>$status_slug), $action_url)) . '" ';
			echo 'class="frmaster-order-filter-status ' . ($status_slug == $order_status? 'frmaster-active': '') . '" >';
			echo $status;
			echo '</a>';
		}
	?>
	</div>
</div>
<?php				
			}

			echo '<div class="frmaster-order-page-wrap" >';
			echo '<div class="frmaster-order-page-head" >';
			echo '<i class="fa fa-check-circle-o" ></i>';
			echo esc_html__('Transaction Order', 'frmaster');
			echo '</div>'; // frmaster-order-page-head

			echo '<div class="frmaster-order-page-content clearfix" >';
			if( isset($_GET['single']) ){
				frmaster_get_single_order();
			}else{
				frmaster_get_order_list();
			}

			echo '</div>'; // frmaster-order-page-content
			echo '</div>'; // frmaster-order-page-wrap
		}
	}

	if( !function_exists('frmaster_order_payment_action') ){
		function frmaster_order_payment_action($action, $tid){	
			
			if( $action == 'remove' ){

				$result = frmaster_get_booking_data(array('id' => $tid), array('single' => true));
				$data = json_decode($result->booking_detail, true);

				// decrease course donation amount
				if( in_array($result->order_status, array('approved', 'online-paid')) ){
	        		frmaster_increase_donation_amount($result->cause_id, -$result->donation_amount);
	        	}

				frmaster_remove_booking_data($tid);

			}else if( in_array($action, array('rejected', 'pending', 'cancel')) ){

				$result = frmaster_get_booking_data(array('id' => $tid), array('single' => true));
				$data = json_decode($result->booking_detail, true);

				// send reject email
				if( $action == 'rejected' && $result->order_status != 'rejected' ){
					frmaster_mail_notification('booking-reject-mail', '', $data);
				}

				// decrease course donation amount
				if( in_array($result->order_status, array('approved', 'online-paid')) ){
	        		frmaster_increase_donation_amount($result->cause_id, -$result->donation_amount);
	        	}

				// update status
        		frmaster_update_booking_data(array('order_status' => $action), array('id' => $tid));

			}else if( in_array($action, array('approved', 'online-paid')) ){

				$result = frmaster_get_booking_data(array('id' => $tid), array('single' => true));
				$data = json_decode($result->booking_detail, true);
				$data['tid'] = $tid;
				
				// retrieve old payment info (if exists)
				if( empty($result->payment_info) ){
					$payment_info = array(
						'submission_date' => current_time('mysql'),
						'amount' => $result->donation_amount
					);
				}else{
					$payment_info = json_decode($result->payment_info, true);
				}
				
				// send donation success email
				if( $result->order_status != 'approved' ){
					frmaster_mail_notification('success-donation-mail', '', $data, $payment_info);
				}
					
				// increase course donation amount
				if( !in_array($result->order_status, array('approved', 'online-paid')) ){
	        		frmaster_increase_donation_amount($result->cause_id, $result->donation_amount);
	        	}

				// update status
        		frmaster_update_booking_data(array(
	        		'order_status' => $action,
	        		'payment_date' => $payment_info['submission_date'],
	        		'payment_info' => json_encode($payment_info)
	        	), array('id' => $tid));

			}else{

				// update status
        		frmaster_update_booking_data(array(
	        		'order_status' => $action,
	        	), array('id' => $tid));

			}

		} // frmaster_order_payment_action
	}

	if( !function_exists('frmaster_get_order_list') ){
		function frmaster_get_order_list(){

			// order action
			if( !empty($_GET['action']) && !empty($_GET['id']) ){
				frmaster_order_payment_action($_GET['action'], $_GET['id']);
 			}

			// print the order
 			$paged = empty($_GET['paged'])? 1: $_GET['paged'];
 			$num_fetch = 20;
 			$query_args = array();
			if( !empty($_GET['order_status']) && $_GET['order_status'] != 'all' ){
				$query_args['order_status'] = $_GET['order_status'];
			}
			if( !empty($_GET['order_id']) ){
				$query_args['id'] = $_GET['order_id'];
			}
			if( !empty($_GET['cause_id']) ){
				$query_args['cause_id'] = $_GET['cause_id'];
			}
			if( !empty($_GET['from_date']) ){
				$custom_condition = ' >= \'' . esc_sql($_GET['from_date']) . ' 00:00:00\''; 
				if( !empty($_GET['to_date']) ){
					$custom_condition .= ' AND payment_date <= \'' . esc_sql($_GET['to_date']) . ' 23:59:59\' ';
				}
				$query_args['payment_date'] = array( 
					'custom' => $custom_condition
				);
			}

			$results = frmaster_get_booking_data($query_args, array(
				'paged' => $paged,
				'num-fetch' => $num_fetch
			));
			$max_num_page = ceil(frmaster_get_booking_data($query_args, array(), 'COUNT(*)') / $num_fetch);
			if( !empty($_GET['export']) ){
				$export_results = frmaster_get_booking_data($query_args, array(
					'num-fetch' => 9999
				));
				// frmaster_order_csv_export($export_results);
			}

			echo '<table>';
			echo frmaster_get_table_head(array(
				esc_html__('Project Name', 'frmaster'),
				esc_html__('Payment Date', 'frmaster'),
				esc_html__('Total', 'frmaster'),
				esc_html__('Payment Status', 'frmaster'),
				esc_html__('Action', 'frmaster'),
			));
			$statuses = array(
				'all' => esc_html__('All', 'frmaster'),
				'pending' => esc_html__('Pending', 'frmaster'),
				'approved' => esc_html__('Approved', 'frmaster'),
				'online-paid' => esc_html__('Online Paid', 'frmaster'),
				'rejected' => esc_html__('Rejected', 'frmaster'),
				'cancel' => esc_html__('Cancel', 'frmaster')
			);

			foreach( $results as $result ){

				$data = json_decode($result->booking_detail, true);

				$order_title  = '<div class="frmaster-head" >#' . $result->id . ' ';
				$order_title .= '<a href="' . add_query_arg(array('single'=>$result->id), remove_query_arg(array('order_id', 'from_date', 'to_date', 'action', 'id', 'export'))) . '" >';
				$order_title .= get_the_title($result->cause_id);
				$order_title .= '</a>';
				$order_title .= '</div>';

				$payment_date = ($result->payment_date == '0000-00-00 00:00:00')? '-': frmaster_date_format($result->payment_date);

				$total_amount = frmaster_money_format($result->donation_amount);

				$order_status  = '<span class="frmaster-order-status frmaster-status-' . esc_attr($result->order_status) . '" >';
				if( $result->order_status == 'approved' ){
					$order_status .= '<i class="fa fa-check" ></i>';
				}else if( $result->order_status == 'departed' ){
					$order_status .= '<i class="fa fa-check-circle-o" ></i>';
				}else if( $result->order_status == 'rejected' || $result->order_status == 'cancel' ){
					$order_status .= '<i class="fa fa-remove" ></i>';
				}	
				$order_status .= $statuses[$result->order_status];
				if( $result->order_status == 'pending' && empty($result->user_id) ){
					$order_status .= ' <br>' . esc_html__('(Via E-mail)', 'frmaster');
				}
				$order_status .= '</span>';

				$action  = '<a href="' . add_query_arg(array('single'=>$result->id), remove_query_arg(array('id','action'))) . '" class="frmaster-order-action" title="' . esc_html__('View', 'frmaster') . '" >';
				$action .= '<i class="fa fa-eye" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'approved')) . '" class="frmaster-order-action" title="' . esc_html__('Approve', 'frmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('After approving the transaction, invoice and payment receipt will be sent to customer\'s billing email.', 'frmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-check" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'rejected')) . '" class="frmaster-order-action" title="' . esc_html__('Reject', 'frmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('After rejected the transaction, the rejection message will be sent to customer\'s contact email.', 'frmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-remove" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'remove')) . '" class="frmaster-order-action" title="' . esc_html__('Remove', 'frmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('The transaction you selected will be permanently removed from the system.', 'frmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-trash-o" ></i>';
				$action .= '</a>';

				frmaster_get_table_content(array($order_title, $payment_date, $total_amount, $order_status, $action));
			}

			echo '</table>';

			if( !empty($max_num_page) && $max_num_page > 1 ){
				echo '<div class="frmaster-transaction-pagination" >';
				for( $i = 1; $i <= $max_num_page; $i++ ){
					if( $i == $paged ){
						echo '<span class="frmaster-transaction-pagination-item frmaster-active" >' . $i . '</span>';
					}else{
						echo '<a href="' . add_query_arg(array('paged'=>$i), remove_query_arg(array('action'))) . '" class="frmaster-transaction-pagination-item" >' . $i . '</a>';
					}
				}
				echo '</div>';
			}

		}
	}

	if( !function_exists('frmaster_get_single_order') ){
		function frmaster_get_single_order(){

			// order action
			if( !empty($_GET['single']) && !empty($_GET['status']) ){
				frmaster_order_payment_action($_GET['status'], $_GET['single']);
 			}

			$result = frmaster_get_booking_data(array(
				'id' => $_GET['single']
			), array('single' => true));

			$booking_detail = empty($result->booking_detail)? array(): json_decode($result->booking_detail, true);

			// content
			echo '<div class="frmaster-my-contribution-single-content" >';
			echo '<div class="frmaster-item-rvpdlr clearfix" >';
			
			echo '<div class="frmaster-my-contribution-single-order-summary-column frmaster-column-20 frmaster-item-pdlr" >';
			echo '<h3 class="frmaster-my-contribution-single-title">' . esc_html__('Donation Summary', 'frmaster') . '</h3>';
			echo '<div class="frmaster-my-contribution-single-field clearfix" >';
			echo '<span class="frmaster-head">' . esc_html__('Donation Number', 'frmaster') . ' :</span> ';
			echo '<span class="frmaster-tail">#' . $result->id . '</span>';
			echo '</div>';

			echo '<div class="frmaster-my-contribution-single-field clearfix" >';
			echo '<span class="frmaster-head">' . esc_html__('Date of Donation', 'frmaster') . ' :</span> ';
			echo '<span class="frmaster-tail">' . frmaster_date_format($result->booking_date) . '</span>';
			echo '</div>';

			echo '<div class="frmaster-my-contribution-single-field clearfix" >';
			echo '<span class="frmaster-head">' . esc_html__('Cause', 'frmaster') . ' :</span> ';
			echo '<span class="frmaster-tail"><a href="' . get_permalink($result->cause_id) . '" target="_blank" >' . get_the_title($result->cause_id) . '</a></span>';
			echo '</div>';
			echo '</div>'; // frmaster-my-contribution-single-order-summary-column

			echo '<div class="frmaster-my-contribution-single-contact-detail-column frmaster-column-20 frmaster-item-pdlr" >';
			echo '<h3 class="frmaster-my-contribution-single-title">';
			echo esc_html__('Contact Detail', 'frmaster');
			echo frmaster_order_edit_text('contact-details');
			echo frmaster_lightbox_content(array(
				'id' => 'contact-details',
				'title' => esc_html__('Edit Order', 'frmaster'),
				'content' => frmaster_order_edit_form($result, 'contact-details')
			));	
			echo '</h3>';
			$contact_fields = frmaster_get_profile_fields();
			foreach( $contact_fields as $field_slug => $contact_field ){
				if( !empty($booking_detail['register-form'][$field_slug]) ){
					echo '<div class="frmaster-my-contribution-single-field clearfix" >';
					echo '<span class="frmaster-head">' . $contact_field['title'] . ' :</span> ';
					if( $field_slug == 'country' ){
						echo '<span class="frmaster-tail">' . frmaster_get_country_list('', $booking_detail['register-form'][$field_slug]) . '</span>';
					}else{
						echo '<span class="frmaster-tail">' . $booking_detail['register-form'][$field_slug] . '</span>';
					}
					echo '</div>';
				}
			}
			echo '</div>'; // frmaster-my-contribution-single-contact-detail-column

			echo '<div class="frmaster-my-contribution-single-transaction-status-column frmaster-column-20 frmaster-item-pdlr" >';
			echo '<h3 class="frmaster-my-contribution-single-title">' . esc_html__('Transaction Status', 'frmaster') . '</h3>';

			$payment_info = json_decode($result->payment_info, true);
			if( !empty($payment_info) ){
				$payment_replace = array(
					array('payment_method', esc_html__('Payment Method :', 'frmaster')),
					array('submission_date', esc_html__('Payment Date :', 'frmaster')),
					array('transaction_id', esc_html__('Transaction ID :', 'frmaster'))
				);

				foreach($payment_replace as $slug => $options ){
					if( !empty($payment_info[$options[0]]) ){
						echo '<div class="frmaster-my-contribution-single-field clearfix" >';
						echo '<span class="frmaster-head" >' . $options[1] . '</span>';
						echo '<span class="frmaster-tail" >';
						if( $options[0] == 'submission_date' ){
							echo frmaster_date_format($payment_info[$options[0]]);
						}else if( $options[0] == 'payment_method' ){
							echo frmaster_get_payment_type($payment_info[$options[0]]);
						}else{
							echo $payment_info[$options[0]];
						}
						echo '</span>';
						echo '</div>';
					}
				}
			}

			$statuses = array(
				'all' => esc_html__('All', 'frmaster'),
				'pending' => esc_html__('Pending', 'frmaster'),
				'approved' => esc_html__('Approved', 'frmaster'),
				'online-paid' => esc_html__('Online Paid', 'frmaster'),
				'rejected' => esc_html__('Rejected', 'frmaster'),
				'cancel' => esc_html__('Cancel', 'frmaster')
			);
			echo '<form action="' . add_query_arg(array('action' => 'update-status')) . '" method="GET" >';
			echo '<div class="frmaster-custom-combobox" >';
			echo '<select name="status" >';
			foreach( $statuses as $status_slug => $status_title ){
				if( $status_slug == 'all' ) continue;
				echo '<option value="' . esc_attr($status_slug) . '" ' . ($status_slug == $result->order_status? 'selected': '') . '>';
				echo esc_html($status_title);
				echo '</option>';
			}
			echo '</select>';
			echo '</div>'; // frmaster-combobox
			echo '<input class="frmaster-button" id="frmaster-update-booking-status" type="submit" value="' . esc_html__('Update Status', 'frmaster') . '" />';
			if( !empty($_GET['page']) ){
				echo '<input name="page" type="hidden" value="' . esc_attr($_GET['page']) . '" />';
			}
			if( !empty($_GET['single']) ){
				echo '<input name="single" type="hidden" value="' . esc_attr($_GET['single']) . '" />';
			}
			echo '</form>';

			echo '</div>'; // frmaster-my-contribution-single-billing-detail-column
			echo '</div>'; // frmaster-item-rvpdl

			echo '<div class="frmaster-my-contribution-single-donation-info" style="max-width: 800px;" >';
			echo '<h3 class="frmaster-my-contribution-single-title" >';
			echo esc_html__('Description of Donation', 'frmaster');
			// echo frmaster_order_edit_text('edit-order');
			// echo frmaster_lightbox_content(array(
			// 	'id' => 'edit-order',
			// 	'title' => esc_html__('Edit Order', 'frmaster'),
			// 	'content' => frmaster_order_edit_form($result, 'edit_donation_amount')
			// ));	
			echo '<span class="frmaster-right" >' . esc_html__('Total', 'frmaster') . '</span>';
			echo '</h3>';

			echo '<div class="frmaster-my-contribution-single-field clearfix" >';
			echo '<span class="frmaster-head">' . get_the_title($result->cause_id) . '</span> ';
			echo '<span class="frmaster-right">' . frmaster_money_format($booking_detail['donation-bar']['donation-amount']) . '</span>';
			echo '</div>';
			echo '</div>'; // frmaster-my-contribution-single-donation-info

			// echo '<a class="frmaster-button frmaster-resend-invoice" href="' . esc_url(add_query_arg(array('action'=>'send-invoice'))) . '" >' . esc_html__('Resend Invoice', 'frmaster') . '</a>';

			echo '</div>'; // frmaster-my-contribution-single-content

		}
	}
