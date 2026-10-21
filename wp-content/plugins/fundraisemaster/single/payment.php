<?php
	$cause_id = empty($_GET['cause_id'])? '': $_GET['cause_id'];

	$payment_complete = false;
	if( !empty($_GET['payment_method']) && $_GET['payment_method'] == 'paypal' ){
		if( !empty($_GET['step']) && $_GET['step'] == 'complete' ){
			if( !empty($_GET['tid']) ){
				
				// query 
				$result = frmaster_get_booking_data(array(
					'id' => $_GET['tid']
				), array('single' => true));

				$cause_id = $result->cause_id;
				$payment_complete = true;
			}
		}
	}

	get_header();

	/*

	$mail_data = array( 
		'tid' => '20',
		'donation-bar' => array( 
			'user-id' => '0',
			'cause-id' => '1409',
			'donation-amount' => '10',
			'donation-method' => 'offline',
			'online-payment-method' => 'credit-card',
			'recurring' => 'one-time',
		),
		'register-form' => array( 
			'first_name' => 'fname',
			'last_name' => 'lname',
			'email' => 'testmail@test.com',
			'phone' => '191',
			'contact_address' => 'blabla',
			'country' => 'Thailand', 
			'create-account' => 'on', 
			'password' => '',
			'confirm-password' => '',
		),
		'donate-anonymously' => false 
	);

	$mail_payment_info = array(
		'payment_method' => 'stripe',
		'amount' => 50,
		'transaction_id' => '111x5d3',
		'payment_status' => 'paid',
		'submission_date' => current_time('mysql')
	);
	
	frmaster_mail_notification('admin-success-donation-mail', '', $mail_data, $mail_payment_info);
	frmaster_mail_notification('success-donation-mail', '', $mail_data, $mail_payment_info);

	*/
	
	echo '<div class="frmaster-page-wrapper" id="frmaster-page-wrapper" >';

	$post_type = get_post_type($cause_id);
	if( !empty($post_type) && $post_type == 'cause' ){
		
		if( !$payment_complete ){

			// payment bar
			echo '<div class="frmaster-payment-bar-wrap" >';
			echo '<div class="frmaster-payment-bar-container frmaster-container" >';
			echo '<div class="frmaster-payment-bar-inner frmaster-item-mglr" >';
			echo '<div class="frmaster-payment-bar" >';
			frmaster_select_donation_amount($cause_id);
			echo '</div>'; // frmaster-payment-bar
			echo '</div>'; // frmaster-payment-bar-inner
			echo '</div>'; // frmaster-payment-bar-container
			echo '</div>'; // frmaster-payment-bar-wrap

			// payment header
			frmaster_get_payment_head($cause_id, array(
				'container-class' => 'frmaster-step-1'
			));

			// payment content
			echo '<div class="frmaster-page-container frmaster-container" >';
			echo '<div class="frmaster-page-content-wrap frmaster-item-pdlr" >';
			echo '<div class="frmaster-page-content" >';

			if( !is_user_logged_in() ){

				$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
				if( $enable_membership == 'enable' ){
					echo '<div class="frmaster-login-form-wrapper" >';
					echo '<h3 class="frmaster-login-form-title">' . esc_html__('Login to Donate', 'frmaster') . '</h3>';
					echo frmaster_get_login_form(true, array(
						'label' => false,
						'placeholder' => true,
						'forget-password' => false,
						'register' => false,
						'login-form-action' => 2
					));
					echo '<div class="frmaster-login-form-description" >' . esc_html__('With an account, you will be able to view your past contributions and follow favourite projects.', 'frmaster') . '</div>';
					echo '</div>'; // frmaster-login-form-wrapper
				}
			
				echo '<div class="frmaster-register-form-wrap" >';
				if( $enable_membership == 'enable' ){
					echo '<h3 class="frmaster-register-form-title" >' . esc_html__('Or donate without an account', 'frmaster') . '</h3>';
				}else{
					echo '<h3 class="frmaster-register-form-title" >' . esc_html__('Donate without an account', 'frmaster') . '</h3>';
				}
				echo '<label class="frmaster-donate-anonymously" ><input name="donate-anonymously" type="checkbox" />' . esc_html__('Donate anonymously', 'frmaster') . '</label>';
				echo frmaster_get_donate_registration_form();
				echo '</div>';
			}else{
				echo frmaster_get_donate_registration_form();
			}

			/* bottom text */
			$payment_bottom_title = frmaster_get_option('general', 'payment-bottom-text-title', '');
			$payment_bottom_text = frmaster_get_option('general', 'payment-bottom-text', '');
			if( !empty($payment_bottom_title) || !empty($payment_bottom_text) ){
				echo '<div class="frmaster-payment-bottom-text-wrap" >';
				echo empty($payment_bottom_title)? '': '<h3 class="frmaster-payment-bottom-text-title" >' . frmaster_text_filter($payment_bottom_title) . '</h3>';
				echo empty($payment_bottom_text)? '': '<div class="frmaster-payment-bottom-text" >' . frmaster_content_filter($payment_bottom_text) . '</div>';
				echo '</div>';
			}

			echo '</div>'; // frmaster-page-content
			echo '</div>'; // frmaster-page-content-wrap
			echo '</div>'; // frmaster-page-container

		}else{

			// payment header
			frmaster_get_payment_head($cause_id, array(
				'container-class' => 'frmaster-step-2'
			));

			// payment content
			$tid = $result->id;
			$data = json_decode($result->booking_detail, true);
			echo '<div class="frmaster-page-container frmaster-container frmaster-step-2" >';
			echo '<div class="frmaster-page-content-wrap frmaster-item-pdlr" >';
			echo '<div class="frmaster-page-content" >';
			frmaster_get_online_donation_message($tid, $data);
			echo '</div>'; // frmaster-page-content
			echo '</div>'; // frmaster-page-content-wrap
			echo '</div>'; // frmaster-page-container

		}

	}else{

		echo '<div class="frmaster-page-container frmaster-container" >';
		echo '<div class="frmaster-page-content" >';
		echo '<div class="frmaster-notification-box frmaster-failure frmaster-item-mglr" >' . esc_html__('The cause you\'re looking for is not available, please try accessing this page again from the cause page.', 'frmaster') . '</div>';
		echo '</div>';
		echo '</div>';

	}

	echo '</div>';

	get_footer();
?>