<?php
	/*	
	*	Utility function for uses
	*/

	// array('title', 'sender', 'recipient', 'message')
	if( !function_exists('frmaster_mail') ){
		function frmaster_mail( $settings = array() ){
			$sender_name = frmaster_get_option('general', 'system-email-name', 'WORDPRESS');
			$sender = frmaster_get_option('general', 'system-email-address');

			if( !empty($sender) ){ 
				$headers  = "From: {$sender_name} <{$sender}>\r\n";
				if( !empty($settings['reply-to']) ){
					$headers .= "Reply-To: {$settings['reply-to']}\r\n";
				}
				if( !empty($settings['cc']) ){
					$headers .= "CC: {$settings['cc']}\r\n"; 
				}
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				wp_mail($settings['recipient'], $settings['title'], $settings['message'], $headers);
			}

		} // frmaster_mail
	}

	if( !function_exists('frmaster_mail_content') ){
		function frmaster_mail_content( $content = '', $header = true, $footer = true, $settings = array() ){

			$theme_color = frmaster_get_option('color', 'frmaster-email-theme-color', '#2123bc');

			$settings['width'] = empty($settings['width'])? '600': $settings['width'];
			$settings['padding'] = empty($settings['padding'])? '60px 60px 40px': $settings['padding'];

			ob_start();

			echo '<html><body>';
			echo '<div class="frmaster-mail-template" style="line-height: 1.7; background: #f5f5f5; margin: 40px auto 40px; width: ' . $settings['width'] . 'px; font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #838383;" >';
			if( !empty($header) ){
				$header_logo = frmaster_get_option('general', 'mail-header-logo', FRMASTER_URL . '/images/logo.png');

				echo '<div class="frmaster-mail-header" style="line-height: 0; background: ' . esc_attr($theme_color) . '; padding: 25px 35px;" >';
				echo frmaster_get_image($header_logo);
				echo '<div style="display: block; clear: both; visibility: hidden; line-height: 0; height: 0; zoom: 1;" ></div>'; // clear
				echo '</div>';
			}

			if( empty($settings['no-filter']) ){
				$content = frmaster_content_filter($content);
			}

			//apply css to link and p tag
			$pointer = 0;
			while( ($new_pointer = strpos($content, '<a', $pointer)) !== false ){
				$pointer = $new_pointer + 2;

				$style_tag = strpos($content, 'style=', $pointer);
				$close_tag = strpos($content, '>', $pointer);

				if( $style_tag === false || $close_tag < $style_tag ){
					$first_section = substr($content, 0, $pointer);
					$last_section = substr($content, $pointer);
					$content  = $first_section . ' style="color: ' . esc_attr($theme_color) . '; text-decoration: none;" ' . $last_section;
				}
			}
			echo '<div class="frmaster-mail-content" style="padding: ' . $settings['padding'] . ';" >' . $content . '</div>';

			if( !empty($footer) ){
				$footer_left = frmaster_get_option('general', 'mail-footer-left', '');
				$footer_right = frmaster_get_option('general', 'mail-footer-right', '');

				echo '<div class="frmaster-mail-footer" style="background: #ebedef; font-size: 13px; padding: 25px 30px 20px;" >';
				if( !empty($footer_left) ){
					echo '<div class="frmaster-mail-footer-left" style="float: left; text-align: left;" >' . frmaster_content_filter($footer_left) . '</div>';
				}
				if( !empty($footer_right) ){
					echo '<div class="frmaster-mail-footer-right" style="float: right; text-align: right;" >' . frmaster_content_filter($footer_right) . '</div>';
				}
				echo '<div style="display: block; clear: both; visibility: hidden; line-height: 0; height: 0; zoom: 1;" ></div>'; // clear
				echo '</div>';
			}
			echo '</div>';
			echo '</body></html>';

			$message = ob_get_contents();
			ob_end_clean();

			return $message;

		} // frmaster_mail_content
	}

	if( !function_exists('frmaster_mail_notification') ){
		function frmaster_mail_notification( $type, $user_id = '', $data = array(), $payment_info = array() ){

			$option_enable = frmaster_get_option('general', 'enable-' . $type, 'enable');
			$mail_title = frmaster_get_option('general', $type . '-title');
			$raw_message = frmaster_get_option('general', $type);
			
			if( $option_enable == 'enable' ){

				if( empty($data) && !empty($user_id) ){

					$profile_fields = frmaster_get_profile_fields();
					foreach( $profile_fields as $slug => $option ){
						$value = frmaster_get_user_meta($user_id, $slug);
						$value = empty($value)? '-': $value;
						$raw_message = str_replace('{' . $slug . '}', $value, $raw_message);

						if( $slug == 'email' ){ 
							$user_email = $value;
						}
					}
				
				}else if( !empty($data) ){

					// order id
					if( !empty($data['tid']) ){
						$donation_id = sprintf(esc_html__('Donation ID : #%s', 'frmaster'), $data['tid']);
					}else{
						$donation_id = '';
					}
					$raw_message = str_replace('{order-id}', $donation_id, $raw_message);

					// admin transaction page
					if( !empty($data['tid']) ){
						$raw_message = str_replace('{admin-transaction-link}', admin_url('admin.php?page=frmaster_order&single=' . $data['tid']), $raw_message);
					}else{
						$raw_message = str_replace('{admin-transaction-link}', '', $raw_message);
					}

					// customer info
					$profile_fields = frmaster_get_profile_fields();
					foreach( $profile_fields as $slug => $option ){
						if( !empty($data['register-form'][$slug]) ){
							$value = sprintf(esc_html__('Donor\'s %s : %s', 'frmaster'), $option['title'], $data['register-form'][$slug]);
						}else{
							$value = '';
						}
						$raw_message = str_replace('{' . $slug . '}', $value, $raw_message);

						if( $slug == 'email' ){ 
							$user_email = $data['register-form'][$slug];
						}
					}
					if( !empty($data['register-form']['first_name']) && $data['register-form']['last_name'] ){
						$full_name = sprintf(esc_html__('Donor\'s Name : %s', 'frmaster'), $data['register-form']['first_name'] . ' ' . $data['register-form']['last_name']);
					}else{
						$full_name = '';
					}
					$raw_message = str_replace('{name}', $full_name, $raw_message);
					
					// donor name
					$donate_anonymously = (isset($data['donate-anonymously']) && ($data['donate-anonymously'] == 'true' || $data['donate-anonymously'] === true));
					if( $donate_anonymously ){
						$donor_name = esc_html__('Donor', 'frmaster');
					}else{
						$donor_name = $data['register-form']['first_name'] . ' ' . $data['register-form']['last_name'];
					}
					$raw_message = str_replace('{donor_name}', $donor_name, $raw_message);

					// profile page url
					$user_link = '';
					if( !$donate_anonymously ){
						$user_link = '<a href="' . esc_attr(frmaster_get_template_url('user')) . '" >' . esc_html__('Go to dashboard', 'frmaster') . '</a>';
					}
					$raw_message = str_replace('{profile-page-link}', $user_link, $raw_message);

					// cause name
					$cause_name  = '<h4 class="frmaster-mail-tour-title" style="font-size: 16px; margin-bottom: 25px; font-weight: 700;" >';
					$cause_name .= '<a href="' . get_permalink($data['donation-bar']['cause-id']) . '" >';
					$cause_name .= get_the_title($data['donation-bar']['cause-id']);
					$cause_name .= '</a>';
					$cause_name .= '</h4>';
					
					$mail_title = str_replace('{cause-name}', $cause_name, $mail_title);
					$raw_message = str_replace('{cause-name}', $cause_name, $raw_message);
		
					// donation amount
					if( !empty($data['donation-bar']['donation-amount']) ){
						$donation_amount  = '<span style="font-size: 16px; font-weight: 700;" >';
						$donation_amount .= sprintf(esc_html__('Donation Amount : %s', 'frmaster'), frmaster_money_format($data['donation-bar']['donation-amount']));
						$donation_amount .= '</span>';
					}else{
						$donation_amount = '';
					}
					$raw_message = str_replace('{donation-amount}', $donation_amount, $raw_message);

					// donor type
					if( !empty($data['donate-anonymously']) && $data['donate-anonymously'] !== 'false' ){
						$donor_type = esc_html__('Donor\'s type : Anonymous', 'frmaster');
					}else if( !empty($user_id) || !empty($data['donation-bar']['user-id']) ){
						$donor_type = esc_html__('Donor\'s type : User', 'frmaster');
					}else{
						$donor_type = esc_html__('Donor\'s type : Guest', 'frmaster');
					}
					$raw_message = str_replace('{donor-type}', $donor_type, $raw_message);

					// cc mail
					if( strpos($type, 'admin') === 0 ){
						$cc_mail = get_post_meta($data['donation-bar']['cause-id'], 'frmaster-cc-mail', true);
					}

				}

				if( !empty($payment_info) ){

					$payment_replace = array(
						'payment-method' => array('payment_method', esc_html__('Payment Method :', 'frmaster')),
						'payment-date' => array('submission_date', esc_html__('Payment Date :', 'frmaster')),
						'transaction-id' => array('transaction_id', esc_html__('Transaction ID :', 'frmaster'))
					);

					foreach($payment_replace as $slug => $options ){
						if( !empty($payment_info[$options[0]]) ){
							$payment_text  = '<span style="font-size: 14px; font-weight: 700; margin-bottom: 5px; display: inline-block;" >';
							$payment_text .= $options[1] . ' ';
							if( $slug == 'payment-date' ){
								$payment_text .= frmaster_date_format($payment_info[$options[0]]);
							}else if( $slug == 'payment-method' ){
								$payment_text .= frmaster_get_payment_type($payment_info['payment_method']);
							}else{
								$payment_text .= $payment_info[$options[0]];
							}
							$payment_text .= '</span>';
						}else{
							$payment_text = '';
						}

						if( $slug == 'payment-method' && $payment_info[$options[0]] == 'paypal' ){
							if( !empty($data['donation-bar']['recurring']) && $data['donation-bar']['recurring'] != 'one-time' ){
								$payment_text .= '<br><span style="font-size: 14px; font-weight: 700; margin-bottom: 5px; display: inline-block;" >';
								$payment_text .= esc_html__('Recurring Method :', 'frmaster') . ' ';
								switch($data['donation-bar']['recurring']){
									case 'weekly': $payment_text .= esc_html__('Weekly', 'frmaster'); break;
									case 'monthly': $payment_text .= esc_html__('Monthly', 'frmaster'); break;
									case 'yearly': $payment_text .= esc_html__('Yearly', 'frmaster'); break;
								}
								$payment_text .= '</span>';
							}
						}
						$raw_message = str_replace('{' . $slug . '}', $payment_text, $raw_message);
					}
					
				}

				// html
				$raw_message = str_replace('{header}', '<h3 style="font-size: 17px; margin-bottom: 25px; font-weight: 600; margin-top: 0px; color: #515355" >', $raw_message);
				$raw_message = str_replace('{/header}', '</h3>', $raw_message);
				$raw_message = str_replace('{spaces}', '<div class="frmaster-mail-spaces" style="margin-bottom: 25px;" ></div>', $raw_message);
				$raw_message = str_replace('{divider}', '<div class="frmaster-mail-divider" style="border-bottom-width: 1px; border-bottom-style: solid; margin-bottom: 30px; margin-top: 30px; border-color: #d7d7d7;" ></div>', $raw_message);

				$message = frmaster_mail_content($raw_message);

				// send the mail
				$mail_settings = array(
					'title' => $mail_title,
					'message' => $message
				);
				
				if( $type == 'admin-registration-complete-mail' ){
					$mail_settings['recipient'] = frmaster_get_option('general', 'admin-registration-email-address');
					$mail_settings['reply-to'] = $user_email;
				}else if( strpos($type, 'admin') === 0 ){
					$mail_settings['recipient'] = frmaster_get_option('general', 'admin-email-address');
					$mail_settings['reply-to'] = $user_email;
				}else if( !empty($user_email) ){
					$mail_settings['recipient'] = $user_email;
				}

				if( !empty($cc_mail) ){
					$mail_settings['cc'] = $cc_mail;
				}
				if( !empty($mail_settings['recipient']) ){
					frmaster_mail($mail_settings);
				}
			}

		} // frmaster_mail_notification
	}

	if( !function_exists('frmaster_send_email_invoice') ){
		function frmaster_send_email_invoice( $tid ){

			$enable_email_invoice = frmaster_get_option('general', 'enable-customer-invoice', 'enable');
			if( $enable_email_invoice == 'disable' ) return;

			ob_start();
			$result = frmaster_get_booking_data(array(
				'id' => $tid,
			), array('single' => true));

			$booking_detail = empty($result->booking_detail)? array(): json_decode($result->booking_detail, true);

			echo '<div style="background: #fff; padding: 50px 50px; font-size: 14px; " >'; // frmaster-invoice-wrap
			echo '<div style="margin-bottom: 60px; color: #121212;" >'; // frmaster-invoice-head
			echo '<div style="float: left;" >'; // frmaster-invoice-head-left
			echo '<div style="margin-bottom: 35px;" >'; // frmaster-invoice-logo
			$invoice_logo = frmaster_get_option('general', 'invoice-logo');
			if( empty($invoice_logo) ){
				echo frmaster_get_image(FRMASTER_URL . '/images/invoice-logo.png');
			}else{
				echo frmaster_get_image($invoice_logo);
			}
			echo '</div>'; // frmaster-invoice-logo
			echo '<div style="font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase;" >' . esc_html__('Receipt No.', 'frmaster') . ' <span>#' . $result->id . '</span></div>'; // frmaster-invoice-id
			echo '<div>' . esc_html__('Date of receipt :', 'frmaster') . ' ' . frmaster_date_format($result->booking_date) . '</div>'; // frmaster-invoice-date
			echo '<div style="margin-top: 34px;" >'; // frmaster-invoice-receiver
			echo '<div style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px;" >' . esc_html__('Donated By', 'frmaster') . '</div>'; // frmaster-invoice-receiver-head
			echo '<div>'; // frmaster-invoice-receiver-info
			$address = frmaster_get_option('general', 'invoice-customer-address', '{first_name} {last_name} \n{contact_address}');
			if( !empty($booking_detail['register-form']) ){
				foreach( $booking_detail['register-form'] as $slug => $value ){
					if( !empty($value) ){
						$address = str_replace('{' . $slug . '}', $value, $address);
					}
				}
			}
			echo frmaster_content_filter($address);
			echo '</div>';
			echo '</div>';
			echo '</div>'; // frmaster-invoice-head-left
			
			$company_name = frmaster_get_option('general', 'invoice-company-name', '');
			$company_info = frmaster_get_option('general', 'invoice-company-info', '');
			echo '<div style="float: right; padding-top: 10px; width: 180px;" >'; // frmaster-invoice-head-right
			echo '<div>'; // frmaster-invoice-company-info
			echo '<div style="font-size: 16px; font-weight: bold; margin-bottom: 20px;" >' . $company_name . '</div>'; // frmaster-invoice-company-name
			echo '<div>' . frmaster_content_filter($company_info) . '</div>'; // frmaster-invoice-company-info
			echo '</div>';
			echo '</div>'; // frmaster-invoice-head-right

			echo '<div style="clear: both" ></div>';
			echo '</div>'; // frmaster-invoice-head

			// amount
			$pricing_info = json_decode($result->pricing_info, true);
			echo '<div>'; // frmaster-invoice-price-breakdown
			echo '<div style="padding: 18px 25px; font-size: 14px; font-weight: 700; text-transform: uppercase; color: #454545; background-color: #f3f3f3" >'; // frmaster-invoice-price-head
			echo '<span style="width: 80%; float: left;" >' . esc_html__('Description of Donation', 'frmaster') . '</span>'; // frmaster-head
			echo '<span style="overflow: hidden;" >' . esc_html__('Total', 'frmaster') . '</span>'; // frmaster-tail
			echo '</div>'; // frmaster-invoice-price-head

			echo '<div style="padding: 18px 25px; border-bottom-width: 1px; border-bottom-style: solid; border-color: #e1e1e1;" >'; // tourmaster-invoice-price-item
			echo '<span style="width: 80%; float: left; color: #7b7b7b;" >' . get_the_title($result->cause_id) . '</span>'; // tourmaster-head
			echo '<span style="color: #1e1e1e; font-size: 16px;" >' . frmaster_money_format($booking_detail['donation-bar']['donation-amount']) . '</span>'; // tourmaster-tail
			echo '</div>'; // tourmaster-invoice-price-item
			echo '</div>'; // frmaster-invoice-price-breakdown

			// payment info
			if( !empty($result->payment_info) ){
				$payment_info = json_decode($result->payment_info, true);

				echo '<div style="padding: 22px 35px; margin-top: 40px; background: #f3f3f3; color: #454545" >'; // frmaster-invoice-payment-info
				if( !empty($payment_info['payment_method']) ){
					$payment_method = frmaster_get_payment_type($payment_info['payment_method']);

					echo '<div style="float: left; margin-right: 60px; text-transform: uppercase;" >'; // frmaster-invoice-payment-info-item
					echo '<div style="font-weight: 800; margin-bottom: 5px;" >' . esc_html__('Payment Method', 'frmaster') . '</div>'; // frmaster-head
					echo '<div>' . $payment_method . '</div>'; // frmaster-tail
					echo '</div>'; // frmaster-invoice-payment-info-item
				}

				if( !empty($payment_info['amount']) || !empty($payment_info['deposit_price']) ){
					echo '<div style="float: left; margin-right: 60px; text-transform: uppercase;" >'; // frmaster-invoice-payment-info-item
					echo '<div style="font-weight: 800; margin-bottom: 5px;" >' . esc_html__('Paid Amount', 'frmaster') . '</div>'; // frmaster-head
					echo '<div>' . frmaster_money_format($payment_info['amount']) . '</div>'; // frmaster-tail
					echo '</div>'; // frmaster-invoice-payment-info-item
				}

				if( !empty($payment_info['submission_date']) ){
					echo '<div style="float: left; margin-right: 60px; text-transform: uppercase;" >'; // frmaster-invoice-payment-info-item
					echo '<div style="font-weight: 800; margin-bottom: 5px;" >' . esc_html__('Date', 'frmaster') . '</div>'; // frmaster-head
					echo '<div>' . frmaster_date_format($payment_info['submission_date']) . '</div>'; // frmaster-tail
					echo '</div>'; // frmaster-invoice-payment-info-item
				}
				
				if( !empty($payment_info['transaction_id']) ){
					echo '<div style="float: left; margin-right: 60px; text-transform: uppercase;" >'; // frmaster-invoice-payment-info-item
					echo '<div style="font-weight: 800; margin-bottom: 5px;" >' . esc_html__('Transaction ID', 'frmaster') . '</div>'; // frmaster-head
					echo '<div>' . $payment_info['transaction_id'] . '</div>'; // frmaster-tail
					echo '</div>'; // frmaster-invoice-payment-info-item
				}
				echo '</div>'; // frmaster-invoice-payment-info

				// invoice signature
				$signature_image = frmaster_get_option('general', 'invoice-signature-image', '');
				$signature_name = frmaster_get_option('general', 'invoice-signature-name', '');
				$signature_position = frmaster_get_option('general', 'invoice-signature-position', '');
				echo '<div style="text-align: right; margin-top: 45px;" >'; // frmaster-invoice-signature
				if( !empty($signature_image) ){
					echo '<div style="margin-bottom: 13px;" >' . frmaster_get_image($signature_image) . '</div>'; // frmaster-invoice-signature-image
				}
				if( !empty($signature_name) ){
					echo '<div style="font-weight: 800; font-size: 18px; color: #212121;" >' . frmaster_text_filter($signature_name) . '</div>'; // frmaster-invoice-signature-name
				}
				if( !empty($signature_position) ){
					echo '<div style="font-size: 15px; color: #212121;" >' . frmaster_text_filter($signature_position) . '</div>'; // frmaster-invoice-signature-position
				}
				echo '</div>';
			}

			echo '</div>'; // frmaster-invoice-wrap

			$content = ob_get_contents();
			ob_end_clean();
			
			// send the mail
			$mail_settings = array(
				'title' => sprintf(esc_html__('Invoice From %s', 'frmaster'), frmaster_get_option('general', 'system-email-name', 'WORDPRESS')), 
				'message' => frmaster_mail_content($content, true, true, array('width' => '1210', 'padding' => '0px 1px', 'no-filter' => true)),
				'recipient' => $booking_detail['register-form']['email']
			);
			
			if( !empty($mail_settings['recipient']) ){
				frmaster_mail($mail_settings);
			}

		} // frmaster_send_email_invoice
	}