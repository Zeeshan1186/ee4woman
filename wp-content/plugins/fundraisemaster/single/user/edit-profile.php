<?php
	$profile_fields = frmaster_get_profile_fields();

	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-edit-profile" >';
	frmaster_get_user_breadcrumb();

	// update data
	if( isset($_POST['frmaster-edit-profile']) ){
		$verify = frmaster_validate_profile_field($profile_fields);

		if( !empty($_FILES['profile-image']['size']) && $_FILES['profile-image']['size'] > 150000 ){
		    $verify = new WP_Error('file-size-limit', __("Please upload smaller file size", "frmaster" ));
		}

		if( is_wp_error($verify) ){
			$error_messages = '';
			foreach( $verify->get_error_messages() as $messages ){
				$error_messages .= empty($error_messages)? '': '<br />';
				$error_messages .= $messages;
			}
			frmaster_user_update_notification($error_messages, false);
		}else{
			frmaster_update_profile_avatar();			
			frmaster_update_profile_field($profile_fields);
			frmaster_user_update_notification(esc_html__('Your profile has been successfully changed.', 'frmaster'));
		}
	}

	// edit profile page content
	$avatar = get_the_author_meta('frmaster-user-avatar', $current_user->data->ID);
	echo '<form class="frmaster-edit-profile-wrap frmaster-form-field" method="POST" enctype="multipart/form-data" >';
	echo '<div class="frmaster-edit-profile-avatar" >';
	if( !empty($avatar['thumbnail']) ){
		echo '<img src="' . esc_url($avatar['thumbnail']) . '" alt="profile-image" />';
	}else if( !empty($avatar['file_url']) ){
		echo '<img src="' . esc_url($avatar['file_url']) . '" alt="profile-image" />';
	}else{
		echo get_avatar($current_user->data->ID, 85);
	}
	echo '<label>';
	echo '<a class="frmaster-button" >' . esc_html__('Change Profile Picture', 'frmaster') . '</a>';
	echo '<input type="file" name="profile-image" />';
	echo '</label>';
	// echo '<a class="frmaster-button" href="https://gravatar.com" target="_blank" >' . esc_html__('Change Profile Picture', 'frmaster') . '</a>';
	echo '</div>';

	foreach( $profile_fields as $slug => $profile_field ){
		$profile_field['slug'] = $slug;
		frmaster_get_form_field($profile_field, 'profile');
	}

	echo '<input type="submit" class="frmaster-edit-profile-submit frmaster-button" value="' . esc_html__('Update Profile', 'frmaster') . '" />';
	echo '<input type="hidden" name="frmaster-edit-profile" value="1" />';
	echo '</form>'; // frmaster-edit-profile-wrap

	echo '</div>'; // frmaster-user-content-inner
?>