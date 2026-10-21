<?php
	/*	
	*	Payment Plugin
	*	---------------------------------------------------------------------
	*	creating the stripe payment option
	*	---------------------------------------------------------------------
	*/

	add_filter('frmaster_credit_card_payment_gateway_options', 'frmaster_stripe_payment_gateway_options');
	if( !function_exists('frmaster_stripe_payment_gateway_options') ){
		function frmaster_stripe_payment_gateway_options( $options ){
			$options['stripe'] = esc_html__('Stripe', 'frmaster'); 

			return $options;
		}
	}

	add_filter('frmaster_plugin_payment_option', 'frmaster_stripe_payment_option');
	if( !function_exists('frmaster_stripe_payment_option') ){
		function frmaster_stripe_payment_option( $options ){

			$options['stripe'] = array(
				'title' => esc_html__('Stripe', 'frmaster'),
				'options' => array(
					'stripe-publishable-key' => array(
						'title' => __('Stripe Publishable Key', 'frmaster'),
						'type' => 'text'
					),	
					'stripe-secret-key' => array(
						'title' => __('Stripe Secret Key', 'frmaster'),
						'type' => 'text'
					),
					'stripe-currency-code' => array(
						'title' => __('Stripe Currency Code', 'frmaster'),
						'type' => 'text',	
						'default' => 'usd'
					),	
				)
			);

			return $options;
		} // frmaster_stripe_payment_option
	}

	add_filter('frmaster_cause_options', 'frmaster_stripe_payment_cause_option');
	if( !function_exists('frmaster_stripe_payment_cause_option') ){
		function frmaster_stripe_payment_cause_option( $options ){

			$options['stripe'] = array(
				'title' => esc_html__('Stripe', 'frmaster'),
				'options' => array(
					'stripe-publishable-key' => array(
						'title' => __('Stripe Publishable Key', 'frmaster'),
						'type' => 'text'
					),	
					'stripe-secret-key' => array(
						'title' => __('Stripe Secret Key', 'frmaster'),
						'type' => 'text'
					),
					'stripe-currency-code' => array(
						'title' => __('Stripe Currency Code', 'frmaster'),
						'type' => 'text',	
						'default' => ''
					),	
				)
			);

			return $options;
		} // frmaster_stripe_payment_option
	}

	$current_payment_gateway = '';
	if( !empty($_POST['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}else if( !empty($_POST['data']['donation-bar']['cause-id']) ){
		$current_payment_gateway = frmaster_get_payment_option($_POST['data']['donation-bar']['cause-id'], 'payment', 'credit-card-payment-gateway');
	}
	if( $current_payment_gateway == 'stripe' ){
		if( !class_exists('Stripe\Stripe') ){
			include_once(FRMASTER_LOCAL . '/include/stripe/init.php');
		}

		add_action('frmaster_payment_page_init', 'frmaster_stripe_payment_page_init');
		add_filter('frmaster_stripe_payment_form', 'frmaster_stripe_payment_form', 10, 2);

		add_action('wp_ajax_stripe_payment_charge', 'frmaster_stripe_payment_charge');
		add_action('wp_ajax_nopriv_stripe_payment_charge', 'frmaster_stripe_payment_charge');
	}

	// init the script on payment page head
	if( !function_exists('frmaster_stripe_payment_page_init') ){
		function frmaster_stripe_payment_page_init( $options ){
			add_action('wp_head', 'frmaster_stripe_payment_script_include');
		}
	}
	if( !function_exists('frmaster_stripe_payment_script_include') ){
		function frmaster_stripe_payment_script_include( $options ){
			echo '<script src="https://js.stripe.com/v3/"></script>';
		}
	}	

	// payment form
	if( !function_exists('frmaster_stripe_payment_form') ){
		function frmaster_stripe_payment_form( $ret = '', $data = array()){

			// get the price
			$api_key = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'stripe-secret-key', ''));
			$currency = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'stripe-currency-code', 'usd'));
			
			$price = $data['donation-bar']['donation-amount'];
			$price = round(floatval($price) * 100);
			
			// set payment intent
			\Stripe\Stripe::setAppInfo(
			  "WordPress Fundraise Master Plugin",
			  "4.1.6",
			  "https://goodlayers.com/"
			);
			\Stripe\Stripe::setApiKey($api_key);
			$intent = \Stripe\PaymentIntent::create([
			    'amount' => $price,
			    'currency' => $currency,
			    'metadata' => array(
			    	'email' => $data['register-form']['email']
			    )
			]);

			$publishable_key = frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'stripe-publishable-key', '');

			ob_start();
?>
<div class="frmaster-payment-form frmaster-with-border" >
	<form action="" method="POST" id="frmaster-stripe-payment-form" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" >


		<div class="frmaster-payment-form-field">
			<label>
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Card Holder Name', 'frmaster'); ?></span>
				<input id="cardholder-name" type="text">
			</label>
		</div>

		<div class="frmaster-payment-form-field">
			<label> 
				<span class="frmaster-payment-field-head" ><?php esc_html_e('Card Information', 'frmaster'); ?></span>
			</label>
			<div id="card-element"></div>
		</div>

		<input type="hidden" name="donator-data" value="<?php echo esc_attr(json_encode($data)); ?>" />

		<!-- error message -->
		<div class="payment-errors"></div>
		<div class="frmaster-payment-req-field" ><?php esc_html_e('Please fill all required fields', 'frmaster'); ?></div>

		<!-- submit button -->
		<button id="card-button" data-secret="<?= $intent->client_secret ?>"><?php esc_html_e('Submit Payment', 'frmaster'); ?></button>
	</form>
</div>
<script type="text/javascript">
	(function($){
		var form = $('#frmaster-stripe-payment-form');
		var donator_data = JSON.parse(form.find('input[name="donator-data"]').val());

		var stripe = Stripe('<?php echo esc_js(trim($publishable_key)); ?>', {locale: '<?php echo get_locale(); ?>'.slice(0, 2) });
		var elements = stripe.elements();
		var cardElement = elements.create('card');
		cardElement.mount('#card-element');

		var cardholderName = document.getElementById('cardholder-name');
		var cardButton = document.getElementById('card-button');
		var clientSecret = cardButton.dataset.secret;
		cardButton.addEventListener('click', function(ev){
			form.find('.payment-errors, .frmaster-payment-req-field').slideUp(200);

			// validate empty input field
			if( !form.find('#cardholder-name').val() ){
				var req = true;
			}else{
				var req = false;
			}

			// make the payment
			if( req ){
				form.find('.frmaster-payment-req-field').slideDown(200);
			}else{

				// prevent multiple submission
				if( $(cardButton).hasClass('now-loading') ){
					return;
				}else{
					$(cardButton).prop('disabled', true).addClass('now-loading');
				}
				
				// made a payment
				stripe.handleCardPayment(
					clientSecret, cardElement, {
						payment_method_data: {
							billing_details: {name: cardholderName.value}
						}
					}
				).then(function(result){
					if( result.error ){

						$(cardButton).prop('disabled', false).removeClass('now-loading'); 

						// Display error.message in your UI.
						var error_message = '';
						switch(result.error.code){
							case 'incomplete_number': error_message = '<?php esc_html_e('Your card number is incomplete.', 'frmaster'); ?>'; break;
							case 'invalid_number': error_message = '<?php esc_html_e('Your card number is invalid.', 'frmaster'); ?>'; break;
							case 'card_declined': error_message = '<?php esc_html_e('Your card was declined.', 'frmaster'); ?>'; break;
							case 'expired_card': error_message = '<?php esc_html_e('Your card has expired.', 'frmaster'); ?>'; break;
							case 'incomplete_expiry': error_message = '<?php esc_html_e('Your card\'s expiration date is incomplete.', 'frmaster'); ?>'; break;
							case 'invalid_expiry_year': error_message = '<?php esc_html_e('Your card\'s expiration year is invalid.', 'frmaster'); ?>'; break;
							case 'invalid_expiry_month_past': error_message = '<?php esc_html_e('Your card\'s expiration date is in the past.', 'frmaster'); ?>'; break;
							case 'incomplete_cvc': error_message = '<?php esc_html_e('Your card\'s security code is incomplete.', 'frmaster'); ?>'; break;
							case 'incorrect_cvc': error_message = '<?php esc_html_e('Your card\'s security code is incorrect.', 'frmaster'); ?>'; break;
							case 'incomplete_zip': error_message = '<?php esc_html_e('Your postal code is incomplete.', 'frmaster'); ?>'; break;
							case 'processing_error': error_message = '<?php esc_html_e('An error occurred while processing your card. Try again in a little bit.', 'frmaster'); ?>'; break;
						}
						if( error_message == '' ){
							error_message = result.error.message + ' ' + result.error.code;
						}
						form.find('.payment-errors').text(error_message).slideDown(200);

					}else{

						// The payment has succeeded. Display a success message.
						$.ajax({
							type: 'POST',
							url: form.attr('data-ajax-url'),
							data: { 'action':'stripe_payment_charge', 'data': donator_data, 'paymentIntent': result.paymentIntent },
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
				});
			}
		});
		$(cardButton).on('click', function(){
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
	if( !function_exists('frmaster_stripe_payment_charge') ){
		function frmaster_stripe_payment_charge(){

			$ret = array();

			if( !empty($_POST['paymentIntent']) && !empty($_POST['data']) ){

				$data = frmaster_process_post_data($_POST['data']);
				$payment_intent = frmaster_process_post_data($_POST['paymentIntent']);

				if( !empty($payment_intent['id']) ){
					$api_key = trim(frmaster_get_payment_option($data['donation-bar']['cause-id'], 'payment', 'stripe-secret-key'));
					
					\Stripe\Stripe::setApiKey($api_key);
					$pi = \Stripe\PaymentIntent::retrieve($payment_intent['id']);

					if( $pi['status'] == 'succeeded' && $pi['metadata']->email == $data['register-form']['email'] ){

						// collect payment information
						$payment_info = array(
							'payment_method' => 'stripe',
							'amount' => ($pi['amount'] / 100),
							'transaction_id' => $pi['id'],
							'payment_status' => 'paid',
							'submission_date' => current_time('mysql')
						);

						// update data
						$tid = frmaster_insert_booking_data($data, 'online-paid', $payment_info);
						
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
					}
				}
			}

			die(json_encode($ret));

		} // frmaster_stripe_payment_charge
	}
