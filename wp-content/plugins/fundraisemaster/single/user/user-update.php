<?php
	
	// update the user data for change password page
	if( !empty($_GET['page_type']) && $_GET['page_type'] == 'change-password' ){

		if( isset($_POST['security']) ){
			global $current_user, $frmaster_updated_status;

			if( wp_verify_nonce($_POST['security'], 'frmaster-change-password') ){
				
				// check if every field is filled
				if( empty($_POST['old-password']) || empty($_POST['new-password']) || empty($_POST['confirm-password']) ){
					$frmaster_updated_status = new WP_ERROR('1', esc_html__('Please fill all required fields.', 'frmaster'));

				// check if new password is matched
				}else if( $_POST['new-password'] != $_POST['confirm-password'] ){
					$frmaster_updated_status = new WP_ERROR('3', esc_html__('Password does not match the confirm password.', 'frmaster'));
				
				// check if old password is correct
				}else if( !wp_check_password($_POST['old-password'], $current_user->data->user_pass, $current_user->data->ID) ){
					$frmaster_updated_status = new WP_ERROR('4', esc_html__('Old password incorrect.', 'frmaster'));
				
				// update the data
				}else{
					wp_update_user(array( 
						'ID' => $current_user->ID, 
						'user_pass' => $_POST['new-password']
					));
					$frmaster_updated_status = true;
				}
			}else{
				$frmaster_updated_status = new WP_ERROR('5', esc_html__('The session is expired. Please refesh the page to try again.', 'frmaster'));
			}

			unset($_POST['security']);
			unset($_POST['old-password']);
			unset($_POST['new-password']);
			unset($_POST['confirm-password']);
		}
		
	}
	
	// remove booking data
	if( !empty($_GET['action']) && $_GET['action'] == 'remove' && !empty($_GET['id'])){
		global $current_user;

		if( is_numeric($_GET['id']) ){
			$updated = frmaster_update_booking_data(
				array('order_status' => 'cancel'),
				array('id' => $_GET['id'], 'user_id' => $current_user->data->ID)
			);

			if( $updated ){
				frmaster_mail_notification('booking-cancelled-mail', $_GET['id']);
			}
		}

		wp_redirect(remove_query_arg(array('action', 'id')));
	}
	
?>