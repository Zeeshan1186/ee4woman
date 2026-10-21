<?php
	/*	
	*	Payment Plugin
	*	---------------------------------------------------------------------
	*	creating the authorize payment option
	*	---------------------------------------------------------------------
	*/

	add_filter('frmaster_credit_card_payment_gateway_options', 'frmaster_authorize_payment_gateway_options');
	if( !function_exists('frmaster_authorize_payment_gateway_options') ){
		function frmaster_authorize_payment_gateway_options( $options ){
			$options['authorize'] = esc_html__('Authorize', 'frmaster'); 

			return $options;
		}
	}		

	// init the script on payment page head
	add_filter('frmaster_plugin_payment_option', 'frmaster_authorize_payment_option');
	if( !function_exists('frmaster_authorize_payment_option') ){
		function frmaster_authorize_payment_option( $options ){

			$options['authorize'] = array(
				'title' => esc_html__('Authorize', 'frmaster'),
				'options' => array(
					'authorize-live-mode' => array(
						'title' => __('Live Mode ', 'frmaster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => __('Please turn this option off when you\'re on test mode.','frmaster')
					),
					'authorize-api-id' => array(
						'title' => __('Authorize API Login ID', 'frmaster'),
						'type' => 'text'
					),
					'authorize-transaction-key' => array(
						'title' => __('Authorize Transaction Key', 'frmaster'),
						'type' => 'text'
					),
				)
			);

			return $options;
		} // frmaster_authorize_payment_option
	}
	
	add_filter('frmaster_cause_options', 'frmaster_authorize_payment_cause_option');
	if( !function_exists('frmaster_authorize_payment_cause_option') ){
		function frmaster_authorize_payment_cause_option( $options ){

			$options['authorize'] = array(
				'title' => esc_html__('Authorize', 'frmaster'),
				'options' => array(
					'authorize-live-mode' => array(
						'title' => __('Live Mode ', 'frmaster'),
						'type' => 'combobox',
						'options' => array(
							'' => esc_html__('Default', 'frmaster'),
							'disable' => esc_html__('Disable', 'frmaster'),
							'enable' => esc_html__('Enable', 'frmaster'),
						),
					),
					'authorize-api-id' => array(
						'title' => __('Authorize API Login ID', 'frmaster'),
						'type' => 'text'
					),
					'authorize-transaction-key' => array(
						'title' => __('Authorize Transaction Key', 'frmaster'),
						'type' => 'text'
					),
				)
			);

			return $options;
		} // frmaster_authorize_payment_option
	}

	$current_payment_gateway = '';
	if( !empty($_POST['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}else if( !empty($_POST['data']['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['data']['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}
	if( $current_payment_gateway == 'authorize' ){
		include_once(FRMASTER_LOCAL . '/include/authorize/autoload.php');

		add_filter('frmaster_authorize_payment_form', 'frmaster_authorize_payment_form', 10, 2);

		add_action('wp_ajax_authorize_payment_charge', 'frmaster_authorize_payment_charge');
		add_action('wp_ajax_nopriv_authorize_payment_charge', 'frmaster_authorize_payment_charge');
	}


	// payment form
	if( !function_exists('frmaster_authorize_payment_form') ){
		function frmaster_authorize_payment_form( $ret = '', $data = array()){
			ob_start();
?>
<div class="frmaster-payment-form frmaster-with-border" >
	<form action="" method="POST" id="frmaster-authorize-payment-form" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" >
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Card Number', 'frmaster'); ?></span>
				<input type="text" data-authorize="number">
			</label>
		</div>
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Expiration (MM/YY)', 'frmaster'); ?></span>
				<input class="frmaster-size-small" type="text" size="2" data-authorize="exp_month" />
			</label>
			<span class="frmaster-separator" >/</span>
			<input class="frmaster-size-small" type="text" size="2" data-authorize="exp_year" />
		</div>
		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('CVC', 'frmaster'); ?></span>
				<input class="frmaster-size-small" type="text" size="4" data-authorize="cvc" />
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
	(function($){
		var form = $('#frmaster-authorize-payment-form');

		function frmasterAuthorizeCharge(){

			var donator_data = JSON.parse(form.find('input[name="donator-data"]').val());
			var form_value = {};
			form.find('[data-authorize]').each(function(){
				form_value[$(this).attr('data-authorize')] = $(this).val(); 
			});

			$.ajax({
				type: 'POST',
				url: form.attr('data-ajax-url'),
				data: { 'action':'authorize_payment_charge', 'data': donator_data, 'form': form_value },
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
				frmasterAuthorizeCharge();
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
	if( !function_exists('frmaster_authorize_payment_charge') ){
		function frmaster_authorize_payment_charge(){

			$ret = array();

			if( !empty($_POST['data']) && !empty($_POST['form']) ){

				// prepare data
				$form = stripslashes_deep($_POST['form']);
				$data = frmaster_process_post_data($_POST['data']);

				$api_id = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'authorize-api-id');
				$transaction_key = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'authorize-transaction-key'));
				
				$live_mode = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'authorize-live-mode');
				if( empty($live_mode) || $live_mode == 'enable' ){
					$environment = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
				}else{
					$environment = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
				}

				$price = $data['donation-bar']['donation-amount'];
				$price = round(floatval($price) * 100) / 100;

				try{
					// Common setup for API credentials
					$merchantAuthentication = new net\authorize\api\contract\v1\MerchantAuthenticationType();
					$merchantAuthentication->setName(trim($api_id));
					$merchantAuthentication->setTransactionKey(trim($transaction_key));

					// Create the payment data for a credit card
					$creditCard = new net\authorize\api\contract\v1\CreditCardType();
					$creditCard->setCardNumber($form['number']);
					$creditCard->setExpirationDate($form['exp_year'] . '-' . $form['exp_month']);
					$creditCard->setCardCode($form['cvc']);
					$paymentOne = new net\authorize\api\contract\v1\PaymentType();
					$paymentOne->setCreditCard($creditCard);

					// Create transaction
					$transactionRequestType = new net\authorize\api\contract\v1\TransactionRequestType();
					$transactionRequestType->setTransactionType("authCaptureTransaction"); 
					$transactionRequestType->setAmount($price);
					$transactionRequestType->setPayment($paymentOne);

					// Send request
					$request = new net\authorize\api\contract\v1\CreateTransactionRequest();
					$request->setMerchantAuthentication($merchantAuthentication);
					$request->setTransactionRequest($transactionRequestType);
					$controller = new net\authorize\api\controller\CreateTransactionController($request);
					$response = $controller->executeWithApiResponse($environment);
					
					if( $response != null ){
					    $tresponse = $response->getTransactionResponse();

					    if( ($tresponse != null) && ($tresponse->getResponseCode() == '1') ){
					      	
					      	$payment_info = array(
								'payment_method' => 'authorize',
								'amount' => $price,
								'transaction_id' => $tresponse->getTransId(),
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

					    }else{
					        $ret['status'] = 'failed';
					    	$ret['message'] = esc_html__('Cannot charge credit card, please check your card credentials again.', 'frmaster');
					    	
					    	$error = $tresponse->getErrors();
					    	if( !empty($error[0]) ){
						    	$ret['message'] = $error[0]->getErrorText();
					    	}
					    }
					}else{
					    $ret['status'] = 'failed';
					    $ret['message'] = esc_html__('No response returned, please try again.', 'frmaster');
					}
					$ret['data'] = $_POST;

				}catch( Exception $e ){
					$ret['status'] = 'failed';
					$ret['message'] = $e->getMessage();
				}
			}

			die(json_encode($ret));

		} // frmaster_authorize_payment_charge
	}
