<?php
	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-invoices-single" >';
	frmaster_get_user_breadcrumb();

	// booking table block
	frmaster_user_content_block_start();

	global $current_user;
	$result = frmaster_get_booking_data(array(
		'id' => $_GET['id'],
		'user_id' => $current_user->data->ID,
		'order_status' => array(
			'custom' => " IN('approved','online-paid')"
		)
	), array('single' => true));

	if( !empty($result) ){

		$booking_detail = empty($result->booking_detail)? array(): json_decode($result->booking_detail, true);

		echo '<div class="frmaster-invoice-wrap clearfix" id="frmaster-invoice-wrap" >';
		echo '<div class="frmaster-invoice-head clearfix" >';
		echo '<div class="frmaster-invoice-head-left" >';
		echo '<div class="frmaster-invoice-logo" >';
		$invoice_logo = frmaster_get_option('general', 'invoice-logo');
		if( empty($invoice_logo) ){
			echo frmaster_get_image(FRMASTER_URL . '/images/invoice-logo.png');
		}else{
			echo frmaster_get_image($invoice_logo);
		}
		echo '</div>'; // frmaster-invoice-logo
		echo '<div class="frmaster-invoice-id" >' . esc_html__('Receipt No.', 'frmaster') . ' <span>#' . $result->id . '</span></div>';
		echo '<div class="frmaster-invoice-date" >' . esc_html__('Date of receipt :', 'frmaster') . ' ' . frmaster_date_format($result->booking_date) . '</div>';
		echo '<div class="frmaster-invoice-receiver" >';
		echo '<div class="frmaster-invoice-receiver-head" >' . esc_html__('Donated By', 'frmaster') . '</div>';
		echo '<div class="frmaster-invoice-receiver-info" >';
		$address = frmaster_get_option('general', 'invoice-customer-address', '{first_name} {last_name} \n{contact_address}');
		if( !empty($booking_detail['register-form']) ){
			foreach( $booking_detail['register-form'] as $slug => $value ){
				if( !empty($value) ){
					$address = str_replace('{' . $slug . '}', $value, $address);
				}else{
					$address = str_replace('{' . $slug . '}', '', $address);
				}
			}
		}
		echo frmaster_content_filter($address);
		echo '</div>';
		echo '</div>';
		echo '</div>'; // frmaster-invoice-head-left
		
		$company_name = frmaster_get_option('general', 'invoice-company-name', '');
		$company_info = frmaster_get_option('general', 'invoice-company-info', '');
		echo '<div class="frmaster-invoice-head-right" >';
		echo '<div class="frmaster-invoice-company-info" >';
		echo '<div class="frmaster-invoice-company-name" >' . $company_name . '</div>';
		echo '<div class="frmaster-invoice-company-info" >' . frmaster_content_filter($company_info) . '</div>';
		echo '</div>';
		echo '</div>'; // frmaster-invoice-head-right
		echo '</div>'; // frmaster-invoice-head

		// price
		echo '<div class="frmaster-invoice-price-breakdown" >';
		echo '<div class="frmaster-invoice-price-head" >';
		echo '<span class="frmaster-head" >' . esc_html__('Description of Donation', 'frmaster') . '</span>';
		echo '<span class="frmaster-tail" >' . esc_html__('Total', 'frmaster') . '</span>';
		echo '</div>'; // frmaster-invoice-price-head

		echo '<div class="frmaster-invoice-price-item clearfix" >';
		echo '<span class="frmaster-head" >' . get_the_title($result->cause_id) . '</span>';
		echo '<span class="frmaster-tail tourmaster-right" >' . frmaster_money_format($booking_detail['donation-bar']['donation-amount']) . '</span>';
		echo '</div>';
		echo '</div>'; // frmaster-invoice-price-breakdown

		// payment info
		if( !empty($result->payment_info) ){
			$payment_info = json_decode($result->payment_info, true);

			echo '<div class="frmaster-invoice-payment-info clearfix" >';
			if( !empty($payment_info['payment_method']) ){
				$payment_method = frmaster_get_payment_type($payment_info['payment_method']);

				echo '<div class="frmaster-invoice-payment-info-item" >';
				echo '<div class="frmaster-head" >' . esc_html__('Payment Method', 'frmaster') . '</div>';
				echo '<div class="frmaster-tail" >' . $payment_method . '</div>';
				echo '</div>'; // frmaster-invoice-payment-info-item
			}

			if( !empty($payment_info['amount']) || !empty($payment_info['deposit_price']) ){
				echo '<div class="frmaster-invoice-payment-info-item" >';
				echo '<div class="frmaster-head" >' . esc_html__('Paid Amount', 'frmaster') . '</div>';
				echo '<div class="frmaster-tail" >' . frmaster_money_format($payment_info['amount']) . '</div>';	
				echo '</div>'; // frmaster-invoice-payment-info-item
			}

			if( !empty($payment_info['submission_date']) ){
				echo '<div class="frmaster-invoice-payment-info-item" >';
				echo '<div class="frmaster-head" >' . esc_html__('Date', 'frmaster') . '</div>';
				echo '<div class="frmaster-tail" >' . frmaster_date_format($payment_info['submission_date']) . '</div>';
				echo '</div>'; // frmaster-invoice-payment-info-item
			}
			
			if( !empty($payment_info['transaction_id']) ){
				echo '<div class="frmaster-invoice-payment-info-item" >';
				echo '<div class="frmaster-head" >' . esc_html__('Transaction ID', 'frmaster') . '</div>';
				echo '<div class="frmaster-tail" >' . $payment_info['transaction_id'] . '</div>';
				echo '</div>'; // frmaster-invoice-payment-info-item
			}
			echo '</div>'; // frmaster-invoice-payment-info

			// invoice signature
			$signature_image = frmaster_get_option('general', 'invoice-signature-image', '');
			$signature_name = frmaster_get_option('general', 'invoice-signature-name', '');
			$signature_position = frmaster_get_option('general', 'invoice-signature-position', '');
			echo '<div class="frmaster-invoice-signature" >';
			if( !empty($signature_image) ){
				echo '<div class="frmaster-invoice-signature-image frmaster-media-image" >' . frmaster_get_image($signature_image) . '</div>';
			}
			if( !empty($signature_name) ){
				echo '<div class="frmaster-invoice-signature-name" >' . frmaster_text_filter($signature_name) . '</div>';
			}
			if( !empty($signature_position) ){
				echo '<div class="frmaster-invoice-signature-position" >' . frmaster_text_filter($signature_position) . '</div>';
			}
			echo '</div>';
		}

		echo '</div>'; // frmaster-invoice-wrap

		echo '<div class="frmaster-invoice-button" >';
		// if( empty($result->order_status) || !in_array($result->order_status, array('approve', 'online-paid', 'departed', 'deposit-paid')) ){
		// 	echo '<a href="' . esc_url(add_query_arg(array('page_type'=>'my-booking'))) . '" class="frmaster-button" >' . esc_html__('Make a Payment', 'frmaster') . '</a>';
		// }
		echo '<a href="#" class="frmaster-button frmaster-print" data-id="frmaster-invoice-wrap" ><i class="fa fa-print" ></i>' . esc_html__('Print', 'frmaster') . '</a>';
		echo '</div>'; // frmaster-invoice-button

	}

	frmaster_user_content_block_end();
	echo '</div>'; // frmaster-user-content-inner