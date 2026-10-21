<?php
	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-my-contribution" >';
	frmaster_get_user_breadcrumb();

	// filter
	$statuses = array(
		'all' => esc_html__('All', 'frmaster'),
		'pending' => esc_html__('Pending', 'frmaster'),
		'approved' => esc_html__('Approved', 'frmaster'),
		'online-paid' => esc_html__('Online Paid', 'frmaster'),
		'rejected' => esc_html__('Rejected', 'frmaster'),
	);
	echo '<div class="frmaster-my-contribution-filter" >';
	foreach( $statuses as $status_slug => $status ){
		echo '<span class="frmaster-sep">|</span>';
		echo '<a ';
		if( $status_slug == 'all' && (empty($_GET['status']) || $_GET['status'] == 'all') ){
			echo ' class="frmaster-active" ';
		}else if( !empty($_GET['status']) && $_GET['status'] == $status_slug ){
			echo ' class="frmaster-active" ';
		}
		echo 'href="' . esc_url(add_query_arg(array('status'=>$status_slug))) . '" >' . $status . '</a>';
	}
	echo '</div>'; // frmaster-my-contribution-filter

	// contribution table block
	frmaster_user_content_block_start();

	echo '<table class="frmaster-my-contribution-table frmaster-table" >';

	frmaster_get_table_head(array(
		esc_html__('Project Name', 'frmaster'),
		esc_html__('Payment Date', 'frmaster'),
		esc_html__('Total', 'frmaster'),
		esc_html__('Payment Status', 'frmaster'),
	));

	// query 
	global $current_user;
	$conditions = array(
		'user_id' => $current_user->data->ID,
	);
	if( !empty($_GET['status']) && $_GET['status'] != 'all' && !empty($statuses[$_GET['status']]) ){
		$conditions['order_status'] = $_GET['status'];
	}else{
		$conditions['order_status'] = array(
			'condition' => '!=',
			'value' => 'cancel'
		);
	}
	$results = frmaster_get_booking_data($conditions);

	foreach( $results as $result ){

		$single_url = add_query_arg(array(
			'page_type' => 'my-contribution',
			'sub_page' => 'single',
			'id' => $result->id,
			'cause_id' => $result->cause_id
		));
		$title  = '<a class="frmaster-my-contribution-title" href="' . esc_url($single_url) . '" >';
		$title .= '<span class="frmaster-head" >#' . $result->id . '</span>';
		$title .= get_the_title($result->cause_id);
		$title .= '</a>';

		$status  = '<span class="frmaster-my-contribution-status frmaster-contribution-status frmaster-status-' . esc_attr($result->order_status) . '" >';
		if( $result->order_status == 'approved' ){
			$status .= '<i class="fa fa-check" ></i>';
		}else if( $result->order_status == 'rejected' ){
			$status .= '<i class="fa fa-remove" ></i>';
		}		
		$status .= $statuses[$result->order_status];
		$status .= '</span>';
		if( in_array($result->order_status, array('pending', 'receipt-submitted', 'rejected')) ){
			$status .= '<a class="chariti-no-preload frmaster-my-contribution-action fa fa-remove" title="' . esc_html__('Remove', 'tourmaster') . '" href="' . add_query_arg(array('action'=>'remove', 'id'=>$result->id)) . '" ';
			$status .= ' data-confirm="' . esc_html__('Just To Confirm', 'tourmaster') . '" ';
			$status .= ' data-confirm-yes="' . esc_html__('Yes', 'tourmaster') . '" ';
			$status .= ' data-confirm-no="' . esc_html__('No', 'tourmaster') . '" ';
			$status .= ' data-confirm-text="' . esc_html__('Are you sure you want to do this ?', 'tourmaster') . '" ';
			$status .= ' data-confirm-sub="' . esc_html__('The transaction you selected will be permanently removed from the system.', 'tourmaster') . '" ';
			$status .= ' ></a>';
		}

		frmaster_get_table_content(array(
			$title,
			($result->payment_date == '0000-00-00 00:00:00')? '-': frmaster_date_format($result->payment_date),
			'<span class="frmaster-my-contribution-price" >' . frmaster_money_format($result->donation_amount) . '</span>',
			$status
		));
	}

	echo '</table>';
	frmaster_user_content_block_end();

	echo '</div>'; // frmaster-user-content-inner