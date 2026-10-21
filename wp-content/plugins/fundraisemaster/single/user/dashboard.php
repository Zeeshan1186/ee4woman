<?php
	/* dashboard page content */
	global $current_user;

	///////////////////////
	// my profile section
	///////////////////////
	frmaster_user_content_block_start(array(
		'title' => esc_html__('My Profile', 'frmaster'),
		'title-link-text' => esc_html__('Edit Profile', 'frmaster'),
		'title-link' => frmaster_get_template_url('user', array('page_type'=>'edit-profile'))
	));

	$profile_list = array(
		'first_name' => esc_html__('First Name', 'frmaster'),
		'last_name' => esc_html__('Last Name', 'frmaster'),
		'email' => esc_html__('Email', 'frmaster'),
		'phone' => esc_html__('Phone', 'frmaster'),
		'contact_address' => esc_html__('Contact Address', 'frmaster'),
		'country' => esc_html__('Country', 'frmaster'),
	);
	echo '<div class="frmaster-my-profile-wrapper" >';
	echo '<div class="frmaster-my-profile-avatar" >';
	$avatar = get_the_author_meta('frmaster-user-avatar', $current_user->data->ID);
	if( !empty($avatar['thumbnail']) ){
		echo '<img src="' . esc_url($avatar['thumbnail']) . '" alt="profile-image" />';
	}else if( !empty($avatar['file_url']) ){
		echo '<img src="' . esc_url($avatar['file_url']) . '" alt="profile-image" />';
	}else{
		echo get_avatar($current_user->data->ID, 85);
	}
	echo '</div>';

	$even_column = true;
	echo '<div class="frmaster-my-profile-info-wrap clearfix" >';
	foreach( $profile_list as $meta_field => $field_title ){
		$extra_class  = 'frmaster-my-profile-info-' . $meta_field;
		$extra_class .= ($even_column)? ' frmaster-even': ' frmaster-odd';
		

		echo '<div class="frmaster-my-profile-info ' . esc_attr($extra_class) . ' clearfix" >';
		echo '<span class="frmaster-head" >' . $field_title . '</span>';
		echo '<span class="frmaster-tail" >';
		if( $meta_field == 'birth_date' ){
			$user_meta = frmaster_get_user_meta($current_user->data->ID, $meta_field, '-');
			if( $user_meta == '-' ){
				echo $user_meta;
			}else{
				echo frmaster_date_format($user_meta);
			}
		}else if( $meta_field == 'gender' ){
			$user_meta = frmaster_get_user_meta($current_user->data->ID, $meta_field, '-');
			if( $user_meta == 'male' ){
				echo esc_html__('Male', 'frmaster');
			}else if( $user_meta == 'female' ){
				echo esc_html__('Female', 'frmaster');
			}
		}else{
			echo frmaster_get_user_meta($current_user->data->ID, $meta_field, '-');
		}

		echo '</span>';
		echo '</div>';

		$even_column = !$even_column;
	}
	echo '</div>'; // frmaster-my-profile-info-wrap

	echo '</div>'; // frmaster-my-profile-wrapper
	frmaster_user_content_block_end();

	///////////////////////
	// my booking section
	///////////////////////

	// query 
	$conditions = array(
		'user_id' => $current_user->data->ID,
		'order_status' => array(
			'condition' => '!=',
			'value' => 'cancel'
		)
	);
	$results = frmaster_get_booking_data($conditions, array('paged'=>1, 'num-fetch'=>5));

	if( !empty($results) ){	
		$statuses = array(
			'all' => esc_html__('All', 'frmaster'),
			'pending' => esc_html__('Pending', 'frmaster'),
			'approved' => esc_html__('Approved', 'frmaster'),
			'online-paid' => esc_html__('Online Paid', 'frmaster'),
			'rejected' => esc_html__('Rejected', 'frmaster')
		);

		frmaster_user_content_block_start(array(
			'title' => esc_html__('Current Donations', 'frmaster'),
			'title-link-text' => esc_html__('View All Donations', 'frmaster'),
			'title-link' => frmaster_get_template_url('user', array('page_type'=>'my-contribution'))
		));

		echo '<table class="frmaster-my-contribution-table frmaster-table" >';
		frmaster_get_table_head(array(
			esc_html__('Project Name', 'frmaster'),
			esc_html__('Payment Date', 'frmaster'),
			esc_html__('Total', 'frmaster'),
			esc_html__('Payment Status', 'frmaster'),
		));
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
			}else if( $result->order_status == 'departed' ){
				$status .= '<i class="fa fa-check-circle-o" ></i>';
			}else if( $result->order_status == 'rejected' ){
				$status .= '<i class="fa fa-remove" ></i>';
			}		
			$status .= $statuses[$result->order_status];
			$status .= '</span>';
			if( in_array($result->order_status, array('pending', 'rejected')) ){
				$status .= '<a class="frmaster-my-contribution-action fa fa-dollar" title="' . esc_html__('Make Payment', 'frmaster') . '" href="' . esc_url($single_url) . '" ></a>';
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
	}

?>