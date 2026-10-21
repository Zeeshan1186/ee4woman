<?php
	/*	
	*	Payment Plugin
	*	---------------------------------------------------------------------
	*	creating the paymill payment option
	*	---------------------------------------------------------------------
	*/

	add_filter('frmaster_credit_card_payment_gateway_options', 'frmaster_paymill_payment_gateway_options');
	if( !function_exists('frmaster_paymill_payment_gateway_options') ){
		function frmaster_paymill_payment_gateway_options( $options ){
			$options['paymill'] = esc_html__('Paymill', 'frmaster'); 

			return $options;
		}
	}	

	add_filter('frmaster_plugin_payment_option', 'frmaster_paymill_payment_option');
	if( !function_exists('frmaster_paymill_payment_option') ){
		function frmaster_paymill_payment_option( $options ){

			$options['paymill'] = array(
				'title' => esc_html__('Paymill', 'frmaster'),
				'options' => array(
					'paymill-private-key' => array(
						'title' => __('Paymill Private Key', 'frmaster'),
						'type' => 'text'
					),
					'paymill-public-key' => array(
						'title' => __('Paymill Public Key', 'frmaster'),
						'type' => 'text'
					),	
					'paymill-currency-code' => array(
						'title' => __('Paymill Currency Code', 'frmaster'),
						'type' => 'text',	
						'default' => 'usd'
					),	
				)
			);

			return $options;
		} // frmaster_paymill_payment_option
	}

	add_filter('frmaster_cause_options', 'frmaster_paymill_payment_cause_option');
	if( !function_exists('frmaster_paymill_payment_cause_option') ){
		function frmaster_paymill_payment_cause_option( $options ){

			$options['paymill'] = array(
				'title' => esc_html__('Paymill', 'frmaster'),
				'options' => array(
					'paymill-private-key' => array(
						'title' => __('Paymill Private Key', 'frmaster'),
						'type' => 'text'
					),
					'paymill-public-key' => array(
						'title' => __('Paymill Public Key', 'frmaster'),
						'type' => 'text'
					),	
					'paymill-currency-code' => array(
						'title' => __('Paymill Currency Code', 'frmaster'),
						'type' => 'text'
					),	
				)
			);

			return $options;
		} // frmaster_paymill_payment_option
	}

	if( !empty($_POST['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}else if( !empty($_POST['data']['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['data']['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}
	if( $current_payment_gateway == 'paymill' ){
		include_once(FRMASTER_LOCAL . '/include/paymill/autoload.php');

		add_action('frmaster_payment_page_init', 'frmaster_paymill_payment_page_init');
		add_filter('frmaster_paymill_payment_form', 'frmaster_paymill_payment_form', 10, 2);

		add_action('wp_ajax_paymill_payment_charge', 'frmaster_paymill_payment_charge');
		add_action('wp_ajax_nopriv_paymill_payment_charge', 'frmaster_paymill_payment_charge');
	}	

	// init the script on payment page head
	if( !function_exists('frmaster_paymill_payment_page_init') ){
		function frmaster_paymill_payment_page_init( $options ){
			add_action('wp_head', 'frmaster_paymill_payment_script_include');
		}
	}
	if( !function_exists('frmaster_paymill_payment_script_include') ){
		function frmaster_paymill_payment_script_include( $options ){
			echo '<script type="text/javascript" src="https://bridge.paymill.com/"></script>';
		}
	}	

	// payment form
	if( !function_exists('frmaster_paymill_payment_form') ){
		function frmaster_paymill_payment_form( $ret = '', $data = array()){
			$public_key = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paymill-public-key', '');
			$currency = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paymill-currency-code', 'usd');

			// get the price
			$price = $data['donation-bar']['donation-amount'];
			$price = round(floatval($price) * 100);

			ob_start();
?>
<div class="frmaster-payment-form frmaster-with-border" >
	<form action="" method="POST" id="frmaster-paymill-payment-form" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" >
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Card Holder Name', 'frmaster'); ?></span>
				<input type="text" data-paymill="name">
			</label>
		</div>
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Card Number', 'frmaster'); ?></span>
				<input type="text" data-paymill="number">
			</label>
		</div>
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Expiration (MM/YYYY)', 'frmaster'); ?></span>
				<input class="frmaster-size-small" type="text" size="2" data-paymill="exp_month" />
			</label>
			<span class="frmaster-separator" >/</span>
			<input class="frmaster-size-small" type="text" size="2" data-paymill="exp_year" />
		</div>
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('CVC', 'frmaster'); ?></span>
				<input class="frmaster-size-small" type="text" size="4" data-paymill="cvc" />
			</label>
		</div>
		<div class="now-loading"></div>
		<div class="payment-errors"></div>
		<div class="frmaster-payment-req-field" ><?php esc_html_e('Please fill all required fields', 'frmaster'); ?></div>
		<input type="hidden" name="donator-data" value="<?php echo esc_attr(json_encode($data)); ?>" />
		<input class="frmaster-payment-button submit" type="submit" value="<?php esc_html_e('Submit Payment', 'frmaster'); ?>" />
	</form>
</div>
<script type="text/javascript">
	var PAYMILL_PUBLIC_KEY = '<?php echo esc_js(trim($public_key)); ?>';

	(function($){
		var form = $('#frmaster-paymill-payment-form');

		function paymillResponseHandler(error, result){
			if( error ){
				console.log(error);
				form.find('.payment-errors').text(error.apierror).slideDown(200);
				form.find('.submit').prop('disabled', false).removeClass('now-loading'); 
			}else{
				var token = result.token;
				var donator_data = JSON.parse(form.find('input[name="donator-data"]').val());

				$.ajax({
					type: 'POST',
					url: form.attr('data-ajax-url'),
					data: { 'action':'paymill_payment_charge','token': token, 'data': donator_data },
					dataType: 'json',
					error: function(a, b, c){ 
						console.log(a, b, c); 

						// display error messages
						form.find('.payment-errors').text('<?php echo esc_html__('An error occurs, please refresh the page to try again.', 'frmaster'); ?>').slideDown(200);
						form.find('.submit').prop('disabled', false).removeClass('now-loading'); 
					},
					success: function(data){

						if( data.status == 'success' ){
							var content = $(data.content);
							content.css({'opacity': 0});
							form.parent('.frmaster-payment-form').replaceWith(content);
							content.animate({'opacity': 1}, 150);
						}else if( typeof(data.message) != 'undefined' ){
							form.find('.payment-errors').text(data.message).slideDown(200);
						}

					}
				});	
			}
		};
		
		form.submit(function(event){
			var req = false;
			form.find('input').each(function(){
				if( !$(this).val() ){
					req = true;
				}
			});

			if( req ){
				form.find('.frmaster-payment-req-field').slideDown(200)
			}else{
				form.find('.submit').prop('disabled', true).addClass('now-loading');
				form.find('.payment-errors, .frmaster-payment-req-field').slideUp(200);

				paymill.createToken({
					cardholder: form.find('[data-paymill="name"]').val(), 
					number: form.find('[data-paymill="number"]').val(), 
					exp_month: form.find('[data-paymill="exp_month"]').val(),   
					exp_year: form.find('[data-paymill="exp_year"]').val(),     
					cvc: form.find('[data-paymill="cvc"]').val(),
					amount_int: '<?php echo esc_js(trim($price)); ?>',
					currency: '<?php echo esc_js(trim($currency)); ?>',
				}, paymillResponseHandler); 
			}

			return false;
		});
	})(jQuery);
</script>
<?php
			$ret = ob_get_contents();
			ob_end_clean();
			return $ret;
		}
	}

	// ajax for payment submission
	if( !function_exists('frmaster_paymill_payment_charge') ){
		function frmaster_paymill_payment_charge(){

			$ret = array();

			if( !empty($_POST['token']) && !empty($_POST['data']) ){
				$api_key = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paymill-private-key'));
				$currency = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'paymill-currency-code', 'usd'));

				$data = frmaster_process_post_data($_POST['data']);
				$price = $data['donation-bar']['donation-amount'];
				$price = round(floatval($price) * 100);

				try{
					$request = new Paymill\Request($api_key);

					$payment = new Paymill\Models\Request\Payment();
					$payment->setToken($_POST['token']);
					$response_request  = $request->create($payment);

					$transaction = new Paymill\Models\Request\Transaction();
					$transaction->setAmount($price)
							->setCurrency($currency)
							->setPayment($response_request->getId())
							->setDescription($t_data['email']);
					
					$request->create($transaction);
					$response = $request->getLastResponse();

					$payment_info = array(
						'payment_method' => 'paymill',
						'amount' => intval($response['body']['data']['amount']) / 100,
						'transaction_id' => $response['body']['data']['id'],
						'payment_status' => 'paid',
						'submission_date' => current_time('mysql')
					);

					// update data
					frmaster_insert_booking_data($data, 'online-paid', $payment_info);

					// send an email
					$data['tid'] = $tid;
					frmaster_mail_notification('admin-success-donation-mail', '', $data, $payment_info);
					frmaster_mail_notification('success-donation-mail', '', $data, $payment_info);

					// increase course donation amount
					frmaster_increase_donation_amount($data['donation-bar']['cause-id'], $payment_info['amount']);

					// return content
					ob_start();
					frmaster_get_online_donation_message($tid, $data, $payment_info);
					$ret['content'] = ob_get_contents();
					ob_end_clean();

					$ret['status'] = 'success';
					
				}catch( Exception $e ){
					$ret['status'] = 'failed';
					$ret['message'] = $e->getMessage();
				}
			}

			die(json_encode($ret));

		} // frmaster_paymill_payment_charge
	}
