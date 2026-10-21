<?php
	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-change-password" >';
	frmaster_get_user_breadcrumb();

	// updated data
	global $frmaster_updated_status;
	if( !empty($frmaster_updated_status) ){
		
		// print error message
		if( is_wp_error($frmaster_updated_status) ){
			$error_messages = '';
			foreach( $frmaster_updated_status->get_error_messages() as $messages ){
				$error_messages .= empty($error_messages)? '': '<br />';
				$error_messages .= $messages;
			}
			frmaster_user_update_notification($error_messages, false);

		// print success status
		}else{
			frmaster_user_update_notification(esc_html__('Your password has been successfully changed.', 'frmaster'));
		}
	}

	// edit profile page content
	$password_fields = array(
		'old-password' => array(
			'title' => esc_html__('Old Password', 'frmaster'),
			'type' => 'password',
			'required' => true
		),
		'new-password' => array(
			'title' => esc_html__('New Password', 'frmaster'),
			'type' => 'password',
			'required' => true
		),
		'confirm-password' => array(
			'title' => esc_html__('Confirm Password', 'frmaster'),
			'type' => 'password',
			'required' => true
		),
	);

	echo '<form class="frmaster-edit-profile-wrap frmaster-form-field" method="POST" >';

	foreach( $password_fields as $slug => $password_field ){
		$password_field['slug'] = $slug;
		frmaster_get_form_field($password_field, 'profile');
	}

	echo '<input type="submit" class="frmaster-edit-profile-submit frmaster-button" value="' . esc_html__('Update Password', 'frmaster') . '" />';

	wp_nonce_field('frmaster-change-password', 'security');
	echo '</form>'; // frmaster-edit-profile-wrap

	echo '</div>'; // frmaster-user-content-inner

?>