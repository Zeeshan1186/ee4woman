<?php
	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-my-contribution-single" >';
	frmaster_get_user_breadcrumb();

	// booking table block
	frmaster_user_content_block_start();

	global $current_user;
	$result = frmaster_get_booking_data(array(
		'id' => $_GET['id'],
		'user_id' => $current_user->data->ID,
		'order_status' => array(
			'condition' => '!=',
			'value' => 'cancel'
		)
	), array('single' => true));

	$booking_detail = json_decode($result->booking_detail, true);

	// content
	echo '<div class="frmaster-my-contribution-single-content-wrap" >';
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
	echo '<h3 class="frmaster-my-contribution-single-title">' . esc_html__('Contact Detail', 'frmaster') . '</h3>';
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
	$statuses = array(
		'all' => esc_html__('All', 'frmaster'),
		'pending' => esc_html__('Pending', 'frmaster'),
		'approved' => esc_html__('Approved', 'frmaster'),
		'online-paid' => esc_html__('Online Paid', 'frmaster'),
		'rejected' => esc_html__('Rejected', 'frmaster'),
	);
	echo '<div class="frmaster-contribution-status frmaster-status-' . esc_attr($result->order_status) . '" >' . $statuses[$result->order_status] . '</div>';
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
	echo '</div>'; // frmaster-my-contribution-single-billing-detail-column
	echo '</div>'; // frmaster-item-rvpdl

	echo '<div class="frmaster-my-contribution-single-donation-info" style="max-width: 800px;" >';
	echo '<h3 class="frmaster-my-contribution-single-title" >';
	echo esc_html__('Description of Donation', 'frmaster');
	echo '<span class="frmaster-right" >' . esc_html__('Total', 'frmaster') . '</span>';
	echo '</h3>';

	echo '<div class="frmaster-my-contribution-single-field clearfix" >';
	echo '<span class="frmaster-head">' . get_the_title($result->cause_id) . '</span> ';
	echo '<span class="frmaster-right">' . frmaster_money_format($booking_detail['donation-bar']['donation-amount']) . '</span>';
	echo '</div>';
	echo '</div>'; // frmaster-my-contribution-single-donation-info

	echo '</div>'; // frmaster-my-contribution-single-content
	echo '</div>'; // frmaster-my-contribution-single-content-wrap

	frmaster_user_content_block_end();

	echo '</div>'; // frmaster-user-content-inner