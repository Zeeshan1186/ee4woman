<?php

	if( !function_exists('frmaster_get_payment_option') ){
		function frmaster_get_payment_option($cause_id, $tab, $name, $default = ''){

			$cause_option = get_post_meta($cause_id, 'gdlr-core-page-option', true);

			if( $name == 'payment-method' ){
				if( empty($cause_option['custom-payment-method']) || $cause_option['custom-payment-method'] == 'disable' ){
					unset($cause_option[$name]);
				}
			}

			if( !empty($cause_option[$name]) ){
				$value = $cause_option[$name];
			}else{
				$value = frmaster_get_option($tab, $name, $default);
			}

			return $value;
		}
	}

	if( !function_exists('frmaster_get_payment_head') ){
		function frmaster_get_payment_head($cause_id, $settings = array()){
			if( empty($cause_id) ) return '';

			echo '<div class="frmaster-payment-head" >';
			
			$thumbnail_id = get_post_thumbnail_id($cause_id);
			$thumbnail_size = frmaster_get_option('general', 'payment-head-thumbnail-size', 'full');
			echo '<div class="frmaster-payment-head-container frmaster-container ' . (empty($settings['container-class'])? '': esc_attr($settings['container-class'])) . '" >';
			echo '<div class="frmaster-payment-head-content frmaster-item-pdlr clearfix" >';
			echo '<div class="frmaster-payment-head-thumbnail frmaster-media-image" >';
			echo frmaster_get_image($thumbnail_id, $thumbnail_size);
			echo '</div>'; // frmaster-payment-head-thumbnail

			$funding_goal = get_post_meta($cause_id, 'frmaster-funding-goal', true);
			$donor_amount = get_post_meta($cause_id, 'frmaster-donor-amount', true);
			$donated_amount = get_post_meta($cause_id, 'frmaster-donated-amount', true);
			$donated_percent = ($funding_goal == 0)? 0: intval(($donated_amount*100) / $funding_goal);
			
			
			echo '<div class="frmaster-cause-info-wrap" >';
			echo '<div class="frmaster-cause-caption" >' . esc_html__('You are donating to :', 'frmaster') . '</div>';
			echo '<h3 class="frmaster-cause-title" >' . get_the_title($cause_id) . '</h3>';
			if( !empty($funding_goal) ){
				echo '<div class="frmaster-cause-donated-bar-wrap clearfix" >';
				echo '<div class="frmaster-cause-donated-amount" >' . frmaster_money_format($donated_amount) . '</div>'; // frmaster-cause-donated-amount
				echo '<div class="frmaster-cause-donated-bar" ><span ' . gdlr_core_esc_style(array(
					'width' => $donated_percent . '%'
				)) . ' ></span></div>';
				echo '<div class="frmaster-cause-donated-bar-percent" >' . sprintf(esc_html__('%d%% Donated', 'frmaster'), $donated_percent) . '</div>';
				echo '<div class="frmaster-cause-goal" >' . sprintf(esc_html__('Goal : %s', 'frmaster'), frmaster_money_format($funding_goal)) . '</div>';
				echo '</div>'; // frmaster-cause-donated-bar-wrap
			}
			echo '</div>'; // frmaster-cause-info-wrap
			
			
			echo '</div>'; // frmaster-payment-head-content
			echo '</div>'; // frmaster-payment-head-container

			echo '</div>'; // frmaster-payment-head
		}
	}

	if( !function_exists('frmaster_get_donate_button') ){
		function frmaster_get_donate_button(){
			
			/*
			$funding_goal = get_post_meta(get_the_ID(), 'frmaster-funding-goal', true);
			$funding_goal = empty($funding_goal)? 0: intval($funding_goal);
			$donated_amount = get_post_meta(get_the_ID(), 'frmaster-donated-amount', true);
			$donated_amount = empty($donated_amount)? 0: intval($donated_amount);

			if( $donated_amount > $funding_goal ){ return; }
			*/

			$payment_url = frmaster_get_template_url('payment', array('cause_id' => get_the_ID()));
			
			$button  = '<a class="frmaster-button frmaster-donate-button gdlr-core-button-color" ';
			$button .= 'href="' . esc_url($payment_url) . '" ';
			$button .= '>' . esc_html__('Donate Now', 'frmaster') . '</a>';

			return $button;
		}
	}

	if( !function_exists('frmaster_select_donation_amount') ){
		function frmaster_select_donation_amount($cause_id){

			global $current_user;

			$donation_amount = array(
				frmaster_get_option('general', 'payment-button1-amount', 10),
				frmaster_get_option('general', 'payment-button2-amount', 20),
				frmaster_get_option('general', 'payment-button3-amount', 30),
				frmaster_get_option('general', 'payment-button4-amount', 40),
			);

			echo '<form class="frmaster-donation-amount-form frmaster-form-field frmaster-with-border" data-slug="donation-bar" >';
			echo '<h3 class="frmaster-donation-bar-head" >' . esc_html__('Select Donation Amount', 'frmaster') . '</h3>';
			if( !empty($current_user->ID) ){
				echo '<input type="hidden" name="user-id" value="' . esc_attr($current_user->ID) . '" />';
			}
			echo '<input type="hidden" name="cause-id" value="' . esc_attr($cause_id) . '" />';

			// donation amount
			echo '<div class="frmaster-donation-amount" >';

			$custom = true;
			$init_amount = empty($_GET['donation-amount'])? $donation_amount[0]: $_GET['donation-amount'];
			foreach( $donation_amount as $amount ){
				echo '<div class="frmaster-donation-amount-button ';
				if( $init_amount == $amount ){
					$custom = false;
					echo 'frmaster-active';
				}
				echo '" data-value="' . esc_attr($amount) . '" >';
				echo frmaster_money_format($amount, -2);
				echo '</div>';

				$first = false;
			}
			echo '<div class="clear" ></div>';
			echo '<input class="frmaster-custom-donation-amount" ' . ($custom? 'value="' . esc_attr($init_amount) . '"': '') . ' type="text" placeholder="' . esc_html__('Other Amount (USD)', 'frmaster') . '" />';
			echo '<input name="donation-amount" type="hidden" value="' . esc_attr($init_amount) . '" />';
			echo '</div>';

			// donation method
			$payment_method = frmaster_get_payment_option($cause_id, 'payment', 'payment-method', array('offline', 'paypal', 'credit-card'));
			$online_tab = (in_array('paypal', $payment_method) || in_array('credit-card', $payment_method));
			$offline_tab = (in_array('offline', $payment_method));

			echo '<div class="frmaster-donation-method-wrap" >';
			echo '<div class="frmaster-donation-method clearfix" >';
			echo $online_tab? '<div class="frmaster-donation-method-button frmaster-active" data-value="online" >' . esc_html__('Donate Online', 'frmaster') . '</div>': '';
			echo $offline_tab? '<div class="frmaster-donation-method-button ' . ($online_tab? '': 'frmaster-active') . '" data-value="offline" >' . esc_html__('Donate Offline', 'frmaster') . '</div>': '';
			echo '<input type="hidden" name="donation-method" value="online" />';
			echo '</div>'; // frmaster-donation-method

			// online donation
			if( $online_tab ){
				echo '<div class="frmaster-donation-tab frmaster-active clearfix" data-method="online" >';
				frmaster_get_online_donation($payment_method, $cause_id);
				echo '</div>';
			}
			
			// offline donation
			if( $offline_tab ){
				echo '<div class="frmaster-donation-tab ' . ($online_tab? '': 'frmaster-active') . ' clearfix" data-method="offline" >';
				frmaster_get_offline_donation($cause_id);
				echo '</div>'; // frmaster-donation-tab
			}

			echo '</div>'; // frmaster-donation-method-wrap
			echo '</form>';

		}
	}

	if( !function_exists('frmaster_get_offline_donation') ){
		function frmaster_get_offline_donation($cause_id){

			echo '<h4 class="frmaster-donation-tab-head" >' . esc_html__('Payment Method', 'frmaster') . '</h4>';

			$offline_content = frmaster_get_payment_option($cause_id, 'general', 'offline-payment-description', '');
			if( !empty($offline_content) ){
				echo '<div class="frmaster-donation-tab-content" >';
				echo frmaster_content_filter($offline_content);
				echo '</div>'; // frmaster-donation-tab-content
			}

			echo '<div class="frmaster-donation-tab-description" >' . esc_html__('* By clicking the donate button, your record will be stored in our database as pending transaction. After your payment verifed, we will send receipt to your email,', 'frmaster') . '</div>';
			echo '<a class="frmaster-donation-submit" ';
			echo ' data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
			echo ' data-action="get_payment_content" '; 
			echo ' >' . esc_html__('Donate Now', 'frmaster') . '</a>';
			

		} // frmaster_get_online_donation
	}

	if( !function_exists('frmaster_get_online_donation') ){
		function frmaster_get_online_donation($payment_method = array(), $cause_id = ''){

			$paypal_payment = in_array('paypal', $payment_method);
			$credit_card_payment = in_array('credit-card', $payment_method);
			$current_method = $paypal_payment? 'paypal': 'credit-card';

			echo '<h4 class="frmaster-donation-tab-head" >' . esc_html__('Payment Method', 'frmaster') . '</h4>';

			echo '<div class="frmaster-donation-tab-content" >';
			echo '<div class="frmaster-payment-gateway clearfix" >';
			if( $paypal_payment ){
				echo '<div class="frmaster-online-payment-method frmaster-media-image frmaster-active" data-value="paypal"  >';
				echo '<img src="' . esc_attr(FRMASTER_URL) . '/images/payment/paypal.png" alt="paypal" width="170" height="76" />';
				echo '</div>';
			}

			if( $credit_card_payment ){
				$payment_attr = apply_filters('frmaster_plugin_payment_attribute', array());
				echo '<div class="frmaster-online-payment-method frmaster-media-image ' . ($current_method == 'credit-card'? 'frmaster-active': '') . '" data-value="credit-card" >';
				echo '<img src="' . esc_attr(FRMASTER_URL) . '/images/payment/credit-card.png" alt="credit-card" width="170" height="76" />';
				echo '</div>';
			}

			echo '<input type="hidden" name="online-payment-method" value="' . esc_attr($current_method) . '" />';
			echo '</div>'; // frmater-payment-gateway

			// credit card type
			$credit_card_types = frmaster_get_option('payment', 'accepted-credit-card-type', array());
			if( !empty($credit_card_types) ){
				echo '<div class="frmaster-payment-credit-card-type">';
				foreach( $credit_card_types as $type ){
					echo '<img src="' . esc_attr(FRMASTER_URL) . '/images/payment/' . esc_attr($type) . '.png" alt="' . esc_attr($type) . '" />';			
				}
				echo '</div>';	
			}

			// recurring payment
			if( $paypal_payment ){
				$paypal_recurring_payment = get_post_meta($cause_id, 'frmaster-enable-paypal-recurring', true);
				if( empty($paypal_recurring_payment) ){
					$paypal_recurring_payment = frmaster_get_option('payment', 'enable-paypal-recurring', 'disable');
				}

				if( $paypal_recurring_payment == 'enable' ){
					echo '<div class="frmaster-combobox-wrap frmaster-payment-recurring-option" >';
					echo '<select name="recurring" >';
					echo '<option value="one-time" >' . esc_html__('A One Time', 'frmaster') . '</option>';
					echo '<option value="weekly" >' . esc_html__('Weekly', 'frmaster') . '</option>';
					echo '<option value="monthly" >' . esc_html__('Monthly', 'frmaster') . '</option>';
					echo '<option value="yearly" >' . esc_html__('Yearly', 'frmaster') . '</option>';
					echo '</select>';
					echo '</div>';
				}
			}

			echo '<a class="frmaster-donation-submit" ';
			echo ' data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
			echo ' data-action="get_payment_content" '; 
			echo ' >' . esc_html__('Donate Now', 'frmaster') . '</a>';
			echo '</div>'; // frmaster-donation-tab-content
			
		} // frmaster_get_online_donation
	}

	if( !function_exists('frmaster_get_offline_donation_message') ){
		function frmaster_get_offline_donation_message( $tid = '', $amount = '', $cause_id ){

			echo '<h3 class="donation-complete-title" >';
			echo '<i class="icon_info_alt" ></i>';
			echo esc_html__('Please transfer funds using information below', 'frmaster');
			echo '</h3>';

			$bank_name = frmaster_get_payment_option($cause_id, 'general', 'offline-payment-bank-name', '');
			$account_number = frmaster_get_payment_option($cause_id, 'general', 'offline-payment-account-number', '');
			$swift_code = frmaster_get_payment_option($cause_id, 'general', 'offline-payment-swift-code', '');

			$donation_infos = array(
				esc_html__('Donation ID :', 'frmaster') => $tid,
				esc_html__('Payment Amount :', 'frmaster') => frmaster_money_format($amount),
				esc_html__('Bank Name :', 'frmaster') => $bank_name,
				esc_html__('Swift Code :', 'frmaster') => $swift_code,
				esc_html__('Account Number :', 'frmaster') => $account_number,
			);
			echo '<div class="donation-complete-message" >';
			echo '<div class="donation-complete-message-item-wrap clearfix" >';
			foreach( $donation_infos as $title => $value ){
				if( !empty($value) ){
					echo '<div class="donation-complete-message-item" >';
					echo '<span class="frmaster-head" >' . frmaster_text_filter($title) . '</span>';
					echo '<span class="frmaster-tail" >' . frmaster_text_filter($value) . '</span>';
					echo '</div>';
				}
			}
			echo '</div>';

			$message = frmaster_get_payment_option($cause_id, 'general', 'offline-payment-message', '');
			echo '<div class="donation-complete-message-content" >';
			echo frmaster_content_filter($message);
			echo '</div>'; // donation-complete-message-content
			echo '</div>'; // donation-complete-message

		}
	}

	if( !function_exists('frmaster_get_payment_type') ){
		function frmaster_get_payment_type( $type ){

			$credit_card_method = apply_filters('frmaster_credit_card_payment_gateway_options', array());
			if( !empty($credit_card_method[$type]) ){
				$payment_method = esc_html__('Credit Card', 'frmaster');
			}else if( $type == 'paypal' ){
				$payment_method = esc_html__('Paypal', 'frmaster');
			}else{
				$payment_method = $type;
			}

			return $payment_method;
		}
	}

	if( !function_exists('frmaster_get_online_donation_message') ){
		function frmaster_get_online_donation_message( $tid = '', $data = array(), $payment_info = array() ){

			echo '<div class="donation-complete-wrap" >';
			echo '<div class="donation-complete-title-wrap clearfix" >';
			echo '<i class="icon_currency" ></i>';
			echo '<div class="donation-complete-title-content" >';
			echo '<h3 class="donation-complete-title" >' .  esc_html__('Your payment has been processed successfully', 'frmaster') . '</h3>';
			echo '<div class="donation-complete-caption" >' . esc_html__('Thank you for your donation', 'frmaster') . '</div>';
			echo '</div>'; // donation-complete-title-content
			echo '</div>'; // donation-complete-title-wrap

			$donate_anonymously = (isset($data['donate-anonymously']) && ($data['donate-anonymously'] == 'true' || $data['donate-anonymously'] === true));
			if( !$donate_anonymously ){
				echo '<div class="donation-complete-title-bottom" >' . esc_html__('A confirmation will be sent to your email.', 'frmaster') . '</div>';
			
				frmaster_get_donation_personal_detail($data['register-form']);
			}

			if( !empty($payment_info) ){

				$payment_method = frmaster_get_payment_type($payment_info['payment_method']);
				
				$donation_infos = array(
					esc_html__('Donation ID :', 'frmaster') => $tid,
					esc_html__('Payment Method :', 'frmaster') => $payment_method,
					esc_html__('Payment Date :', 'frmaster') => frmaster_date_format($payment_info['submission_date']),
					esc_html__('Donation Amount :', 'frmaster') => frmaster_money_format($data['donation-bar']['donation-amount']),
					esc_html__('Transaction ID :', 'frmaster') => $payment_info['transaction_id'],
					
				);
				echo '<div class="donation-complete-message" >';
				echo '<div class="donation-complete-message-item-wrap clearfix" >';
				foreach( $donation_infos as $title => $value ){
					if( !empty($value) ){
						echo '<div class="donation-complete-message-item" >';
						echo '<span class="frmaster-head" >' . frmaster_text_filter($title) . '</span>';
						echo '<span class="frmaster-tail" >' . frmaster_text_filter($value) . '</span>';
						echo '</div>';
					}
				}
				echo '</div>';
				echo '</div>'; // donation-complete-message
				
			}

			if( is_user_logged_in() ){
				$user_page = frmaster_get_template_url('user');
				$nav_link = add_query_arg(array('page_type'=>'my-contribution'), $user_page);

				echo '<a class="frmaster-button" href="' . esc_url($nav_link) . '" style="margin-bottom: 40px;" >' . esc_html__('Go to my Dashboard', 'frmaster') . '</a>';
			}else if( !empty($data['donation-bar']['user-id']) ){
				$user_page = frmaster_get_template_url('user');
				$nav_link = add_query_arg(array('page_type'=>'my-contribution'), $user_page);

				echo '<a class="frmaster-button" href="' . esc_url($nav_link) . '" style="margin-bottom: 40px;" >' . esc_html__('Login to access Dashboard', 'frmaster') . '</a>';
			}

			echo '</div>'; // donation-complete-wrap
		}
	}

	if( !function_exists('frmaster_get_donation_personal_detail') ){
		function frmaster_get_donation_personal_detail( $form ){

			$count = 0;
			$current_user = wp_get_current_user();
			$profile_fields = frmaster_get_profile_fields();

			echo '<div class="frmaster-profile-wrap" >';
			echo '<h3 class="frmaster-profile-title" >' . esc_html__('Personal Details', 'frmaster') . '</h3>';
			echo '<div class="frmaster-profile-item-wrap" >';
			foreach( $profile_fields as $slug => $field ){ 
				if( !empty($form[$slug]) ){ $count++;
					echo '<div class="frmaster-profile-item" >';
					echo '<span class="frmaster-head" >' . frmaster_text_filter($field['title']) . ' :</span>';
					echo '<span class="frmaster-tail" >' . frmaster_text_filter($form[$slug]) . '</span>';
					echo '</div>';

					echo ($count % 2 == 0)? '<div class="frmaster-profile-item-divider" ></div>': '';
				}
			}
			echo ($count % 2 == 1)? '<div class="frmaster-profile-item-divider" ></div>': '';
			echo '</div>'; // frmaster-profile-item-wrap
			echo '</div>'; // frmaster-profile-wrap

		}
	}

	add_action('wp_ajax_get_payment_content', 'frmaster_get_payment_content');
	add_action('wp_ajax_nopriv_get_payment_content', 'frmaster_get_payment_content');
	if( !function_exists('frmaster_get_payment_content') ){
		function frmaster_get_payment_content(){

			$data = frmaster_process_post_data($_POST);
			unset($data['action']);

			$error = new WP_Error();

			if( empty($data['donation-bar']['cause-id']) ){
				$error->add('01', esc_html__('Invalid cause id, please refresh the page to try again.', 'frmaster'));
			
				die(json_encode(array(
					'status' => 'failed',
					'error' => 	implode('<br>', $error->get_error_messages())
				)));

			}else{
				if( empty($data['donation-bar']['donation-amount']) ){
					$error->add('02', esc_html__('Please fill/select the amount you want to donate.', 'frmaster'));
					
					die(json_encode(array(
						'status' => 'failed',
						'error' => 	implode('<br>', $error->get_error_messages())
					)));
				}

				$donate_anonymously = (isset($data['donate-anonymously']) && ($data['donate-anonymously'] == 'true' || $data['donate-anonymously'] === true));

				if( !$donate_anonymously ){

					// validate register form
					$profile_fields = frmaster_get_profile_fields();
					foreach($profile_fields as $slug => $options){
						if( !empty($options['required']) ){
							if( empty($data['register-form'][$slug]) ){
								$error->add('03', esc_html__('Please fill all required fields.', 'frmaster'));
								break;
							}else{
								if( $slug == 'email' ){
									if( !is_email($data['register-form'][$slug]) ){
										$error->add('04', esc_html__('Email is invalid.', 'frmaster'));
									}
								}
							}
						}
					}

					// if user want to create an account
					$create_account = (isset($data['register-form']['create-account']) && ($data['register-form']['create-account'] == 'true' || $data['register-form']['create-account'] === true));
					if( $create_account ){
						if( empty($data['register-form']['password']) || empty($data['register-form']['confirm-password'])  ){
							$error->add('05', esc_html__('Please fill password to create an account.', 'frmaster'));
						}else if( $data['register-form']['password'] != $data['register-form']['confirm-password'] ){
							$error->add('06', esc_html__('Password and confirmation password does not match.', 'frmaster'));
						}

						// create an account
						if( !$error->has_errors() ){
							$user_id = wp_insert_user(array(
								'user_login' => $data['register-form']['email'], 
								'user_pass' => $data['register-form']['password'],
								'user_email' => $data['register-form']['email'],
								'role' => 'subscriber'
							));

							// set user data
							if( is_wp_error($user_id) ){
								$error = $user_id;
							}else{
								foreach($profile_fields as $slug => $options){
									if( $slug != 'email' && !empty($data['register-form'][$slug]) ){
										update_user_meta($user_id, $slug, $data['register-form'][$slug]);
									}
								}
								do_action('user_register', $user_id);
								$data['donation-bar']['user-id'] = $user_id;
							}
							
						}
					}

					if( $error->has_errors() ){
						die(json_encode(array(
							'status' => 'failed',
							'error_target' => 'register-form',
							'error' => 	implode('<br>', $error->get_error_messages())
						)));
					}
				}

				ob_start();

				// payment head
				frmaster_get_payment_head($data['donation-bar']['cause-id'], array('container-class' => 'frmaster-step-2'));

				echo '<div class="frmaster-page-container frmaster-container frmaster-step-2" >';
				echo '<div class="frmaster-page-content-wrap frmaster-item-pdlr" >';
				echo '<div class="frmaster-page-content" >';
				if( $data['donation-bar']['donation-method'] == 'offline' ){

					// add record to database
					$tid = frmaster_insert_booking_data($data);

					// return content
					if( $donate_anonymously ){
						frmaster_get_offline_donation_message($tid, $data['donation-bar']['donation-amount'], $data['donation-bar']['cause-id']);
					}else{
						// send an email to admin/donator
						$mail_data = $data;
						$mail_data['tid'] = $tid;
						frmaster_mail_notification('pending-donation-mail', '', $mail_data);
						frmaster_mail_notification('admin-pending-donation-mail', '', $mail_data);

						// print content
						frmaster_get_offline_donation_message($tid, $data['donation-bar']['donation-amount'], $data['donation-bar']['cause-id']);
						frmaster_get_donation_personal_detail($data['register-form']);

						if( is_user_logged_in() ){
							$user_page = frmaster_get_template_url('user');
							$nav_link = add_query_arg(array('page_type'=>'my-contribution'), $user_page);

							echo '<a class="frmaster-button" href="' . esc_url($nav_link) . '" style="margin-bottom: 40px;" >' . esc_html__('Go to my Dashboard', 'frmaster') . '</a>';
						}else if( !empty($data['donation-bar']['user-id']) ){
							$user_page = frmaster_get_template_url('user');
							$nav_link = add_query_arg(array('page_type'=>'my-contribution'), $user_page);

							echo '<a class="frmaster-button" href="' . esc_url($nav_link) . '" style="margin-bottom: 40px;" >' . esc_html__('Login to access Dashboard', 'frmaster') . '</a>';
						}
					}

				}else if( $data['donation-bar']['donation-method'] == 'online' && !empty($data['donation-bar']['online-payment-method']) ){
					if( $data['donation-bar']['online-payment-method'] == 'paypal' ){
						
						// add record to database
						$tid = frmaster_insert_booking_data($data);
						echo apply_filters('frmaster_paypal_payment_form', '', $data, $tid);

					}else if( $data['donation-bar']['online-payment-method'] == 'credit-card' ){

						$payment_gateway = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway', '');
						echo apply_filters('frmaster_' . trim($payment_gateway) . '_payment_form', '', $data);
					
					} 
				}
				echo '</div>'; // frmaster-page-content
				echo '</div>'; // frmaster-page-content-wrap
				echo '</div>'; // frmaster-page-container

				$content = ob_get_contents();
				ob_end_clean();

				die(json_encode(array(
					'status' => 'success',
					'content' => $content
				)));
			}

		}
	}