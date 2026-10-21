<?php

	add_filter('frmaster_plugin_payment_option', 'frmaster_paypal_payment_option');
	if( !function_exists('frmaster_paypal_payment_option') ){
		function frmaster_paypal_payment_option( $options ){

			$options['paypal'] = array(
				'title' => esc_html__('Paypal', 'frmaster'),
				'options' => array(
					'paypal-live-mode' => array(
						'title' => __('Paypal Live Mode', 'frmaster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('Disable this option to test on sandbox mode.', 'frmaster')
					),
					'enable-paypal-recurring' => array(
						'title' => __('Enable Paypal Recurring Payment', 'frmaster'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'paypal-business-email' => array(
						'title' => esc_html__('Paypal Business Email', 'frmaster'),
						'type' => 'text'
					),
					'paypal-currency-code' => array(
						'title' => esc_html__('Paypal Currency Code', 'frmaster'),
						'type' => 'text',	
						'default' => 'USD'
					)
				)
			);

			return $options;
		} // frmaster_paypal_payment_option
	}

	add_filter('frmaster_cause_options', 'frmaster_paypal_payment_cause_option');
	if( !function_exists('frmaster_paypal_payment_cause_option') ){
		function frmaster_paypal_payment_cause_option( $options ){

			$options['paypal'] = array(
				'title' => esc_html__('Paypal', 'frmaster'),
				'options' => array(
					'paypal-live-mode' => array(
						'title' => __('Paypal Live Mode', 'frmaster'),
						'type' => 'combobox',
						'options' => array(
							'' => esc_html__('Default', 'frmaster'),
							'disable' => esc_html__('Disable', 'frmaster'),
							'enable' => esc_html__('Enable', 'frmaster'),
						)
					),
					'enable-paypal-recurring' => array(
						'title' => __('Enable Paypal Recurring Payment', 'frmaster'),
						'type' => 'combobox',
						'options' => array(
							'' => esc_html__('Default', 'frmaster'),
							'disable' => esc_html__('Disable', 'frmaster'),
							'enable' => esc_html__('Enable', 'frmaster'),
						),
						'single' => 'frmaster-enable-paypal-recurring'
					),
					'paypal-business-email' => array(
						'title' => esc_html__('Paypal Business Email', 'frmaster'),
						'type' => 'text'
					),
					'paypal-currency-code' => array(
						'title' => esc_html__('Paypal Currency Code', 'frmaster'),
						'type' => 'text'
					)
				)
			);

			return $options;
		} // frmaster_paypal_payment_cause_option
	}

	add_filter('frmaster_paypal_payment_form', 'frmaster_paypal_payment_form', 10, 3);
	if( !function_exists('frmaster_paypal_payment_form') ){
		function frmaster_paypal_payment_form( $ret = '', $data = array(), $tid = '' ){
			
			$live_mode = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paypal-live-mode', 'disable');
			$business_email = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paypal-business-email', '');
			$currency_code = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paypal-currency-code', '');
		
			$price = $data['donation-bar']['donation-amount'];

			ob_start();
?>
<div class="frmaster-paypal-redirecting-message" ><?php esc_html_e('Please wait while we redirect you to paypal.', 'frmaster') ?></div>
<form id="frmaster-paypal-redirection-form" method="post" action="<?php
		if( empty($live_mode) || $live_mode == 'disable' ){
			echo 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}else{
			echo 'https://www.paypal.com/cgi-bin/webscr';
		}
	?>" >
	<?php
		if( empty($data['donation-bar']['recurring']) || $data['donation-bar']['recurring'] == 'one-time' ){
			echo '<input type="hidden" name="cmd" value="_xclick" />';
		}else{
			if( $data['donation-bar']['recurring'] == 'weekly' ){
				echo '<input type="hidden" name="t3" value="W" />';
			}else if( $data['donation-bar']['recurring'] == 'monthly' ){
				echo '<input type="hidden" name="t3" value="M" />';
			}else if( $data['donation-bar']['recurring'] == 'yearly' ){
				echo '<input type="hidden" name="t3" value="Y" />';
			}
			echo '<input type="hidden" name="p3" value="1" />'; // period between each recurrence
			// echo '<input type="hidden" name="srt" value="52" />'; // recurring times

			echo '<input type="hidden" name="a3" value="' . esc_attr($price) . '" />';
			echo '<input type="hidden" name="cmd" value="_xclick-subscriptions" />';
			echo '<input type="hidden" name="src" value="1" />'; // recurring payment
			echo '<input type="hidden" name="sra" value="1" />'; // reattemp on failure
			
		}
	?>
	
	<input type="hidden" name="business" value="<?php echo esc_attr(trim($business_email)); ?>" />
	<input type="hidden" name="currency_code" value="<?php echo esc_attr(trim($currency_code)); ?>" />
	<input type="hidden" name="item_name" value="<?php echo get_the_title($data['donation-bar']['cause-id']); ?>" />
	<input type="hidden" name="invoice" value="<?php
		// 02 for frmaster
		echo '02' . date('dmYHis') . $tid;
	?>" />
	<input type="hidden" name="amount" value="<?php echo esc_attr($price); ?>" />
	<input type="hidden" name="notify_url" value="<?php 
		if( function_exists('pll_home_url') ){
			$home_url = pll_home_url();
		}else{
			$home_url = apply_filters('wpml_home_url', home_url('/'));
		}
		echo add_query_arg(array('paypal'=>''), $home_url); 

	?>" />
	<input type="hidden" name="return" value="<?php
		echo add_query_arg(array('tid' => $tid, 'payment_method' => 'paypal', 'step' => 'complete'), frmaster_get_template_url('payment'));
	?>" />
</form>
<script type="text/javascript">
	(function($){
		$('#frmaster-paypal-redirection-form').submit();
	})(jQuery);
</script>
<?php
			$ret = ob_get_contents();
			ob_end_clean();

			return $ret;

		} // frmaster_paypal_payment_form
	}

	add_action('init', 'frmaster_paypal_process_ipn');
	if( !function_exists('frmaster_paypal_process_ipn') ){
		function frmaster_paypal_process_ipn(){

			if( isset($_GET['paypal']) ){

				$payment_info = array(
					'payment_method' => 'paypal',
					'submission_date' => current_time('mysql')
				);

				$live_mode = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paypal-live-mode', '');
				if( empty($live_mode) || $live_mode == 'disable' ){
					$paypal_action_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
				}else{
					$paypal_action_url = 'https://ipnpb.paypal.com/cgi-bin/webscr';
				}

				// read the post data
				$raw_post_data = file_get_contents('php://input');
				$raw_post_array = explode('&', $raw_post_data);
				$myPost = array();
				foreach ($raw_post_array as $keyval) {
				    $keyval = explode('=', $keyval);
				    if (count($keyval) == 2) {
				        // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
				        if ($keyval[0] === 'payment_date') {
				            if (substr_count($keyval[1], '+') === 1) {
				                $keyval[1] = str_replace('+', '%2B', $keyval[1]);
				            }
				        }
				        $myPost[$keyval[0]] = urldecode($keyval[1]);
				    }
				}

				// prepare post request
				$req = 'cmd=_notify-validate';
		        $get_magic_quotes_exists = false;
		        if (function_exists('get_magic_quotes_gpc')) {
		            $get_magic_quotes_exists = true;
		        }
		        foreach ($myPost as $key => $value) {
		            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		                $value = urlencode(stripslashes($value));
		            } else {
		                $value = urlencode($value);
		            }
		            $req .= "&$key=$value";
		        }

		        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
		        $ch = curl_init($paypal_action_url);
		        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		        curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: frmaster'));
				
				$res = curl_exec($ch);
		        if ( !$res ){ 

		            $payment_info['error'] = curl_error($ch);
		            update_option('frmaster_paypal_error', array($payment_info, $_POST));

		        }else if( strcmp ($res, "VERIFIED") == 0 && !empty($_POST['txn_id']) ){

		        	$tid = substr($_POST['invoice'], 16);
		        	$payment_info['transaction_id'] = $_POST['txn_id'];
		        	$payment_info['amount'] = $_POST['mc_gross'];
		        	$payment_info['payment_status'] = 'paid';

		        	// retrieve data
		        	$result = frmaster_get_booking_data(array('id' => $tid), array('single' => true));
		        	$data = json_decode($result->booking_detail, true);

		        	// if not recurring payment
		        	$old_payment_info = json_decode($result->payment_info, true);
		        	if( empty($old_payment_info) ){

		        		// update payment info
			        	frmaster_update_booking_data(array(
			        		'payment_info' => json_encode($payment_info),
			        		'payment_date' => $payment_info['submission_date'],
			        		'order_status' => 'online-paid'
			        	), array( 
			        		'id' => $tid 
			        	));

			        	$data['tid'] = $tid;

		        	// check if it's recurring payment
		        	}else{

		        		// insert new record
		        		$new_tid = frmaster_insert_booking_data($data, 'online-paid', $payment_info, $tid);
		        		$data['tid'] = $new_tid;
		        	}

		        	// send an email
					frmaster_mail_notification('admin-success-donation-mail', '', $data, $payment_info);
					frmaster_mail_notification('success-donation-mail', '', $data, $payment_info);

					// increase course donation amount
					frmaster_increase_donation_amount($data['donation-bar']['cause-id'], $payment_info['amount']);
		        	
				}
				curl_close($ch);

		        exit;
			}else if( isset($_GET['paypal_error']) ){

				$error = get_option('frmaster_paypal_error', 'none');
				print_r($error);
			}

		} // frmaster_paypal_process_ipn
	}