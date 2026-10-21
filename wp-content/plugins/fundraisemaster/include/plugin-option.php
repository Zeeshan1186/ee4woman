<?php
	/*	
	*	Fundraise Master Plugin
	*	---------------------------------------------------------------------
	*	creating the plugin option
	*	---------------------------------------------------------------------
	*/

	// return the custom stylesheet path
	if( !function_exists('frmaster_get_style_custom') ){
		function frmaster_get_style_custom($local = false){

			$upload_dir = wp_upload_dir();
			$filename = '/fundraisemaster-style-custom.css';
			$local_file = $upload_dir['basedir'] . $filename;
			
			if( $local ){
				return $local_file;
			}else{
				if( file_exists($local_file) ){
					$filemtime = filemtime($local_file);

					if( is_ssl() ){
						$upload_dir['baseurl'] = str_replace('http://', 'https://', $upload_dir['baseurl']);
					}
					return $upload_dir['baseurl'] . $filename . '?' . $filemtime;
				}else{
					return FRMASTER_URL . '/style-custom.css';
				}
			}
		}
	}

	// add margin at the bottom
	add_filter('frmaster_plugin_option_top_file_write', 'frmaster_plugin_option_top_file_write');
	if( !function_exists('frmaster_plugin_option_top_file_write') ){ 
		function frmaster_plugin_option_top_file_write( $ret ){

			$general = get_option('frmaster_general', array());

			if( !empty($general['item-padding']) ){
				$item_margin_bottom = 2 * intval(str_replace('px', '', $general['item-padding']));
			}else{
				$item_margin_bottom = 30;
			}
			$ret .= '.frmaster-item-mgb{ margin-bottom: ' . $item_margin_bottom . 'px; } ';


			return $ret;
		}
	}

	add_action('after_setup_theme', 'frmaster_init_admin_option');
	if( !function_exists('frmaster_init_admin_option') ){ 
		function frmaster_init_admin_option(){

			if( is_admin() || is_customize_preview() ){
				$frmaster_option = new frmaster_admin_option(array(
					'page-title' => esc_html__('Fundraise Master', 'frmaster'),
					'menu-title' => esc_html__('Fundraise Master', 'frmaster'),
					'slug' => 'frmaster_admin_option', 
					'filewrite' => frmaster_get_style_custom(true),
					'position' => 121
				));

				// general
				$frmaster_option->add_element(array(
					'title' => esc_html__('General', 'frmaster'),
					'slug' => 'frmaster_general',
					'icon' => FRMASTER_URL . '/images/plugin-options/general.png',
					'options' => array(

						'general-settings' => array(
							'title' => esc_html__('General Settings', 'frmaster'),
							'options' => array(
								'container-width' => array(
									'title' => esc_html__('Container Width', 'frmaster'),
									'type' => 'text',
									'data-type' => 'pixel',
									'data-input-type' => 'pixel',
									'default' => '1180px',
									'selector' => '.frmaster-container{ max-width: #gdlr#; margin-left: auto; margin-right: auto; }' 
								),
								'container-padding' => array(
									'title' => esc_html__('Container Padding', 'frmaster'),
									'type' => 'text',
									'data-type' => 'pixel',
									'data-input-type' => 'pixel',
									'default' => '15px',
									'selector' => '.frmaster-container{ padding-left: #gdlr#; padding-right: #gdlr#; }'
								),
								'item-padding' => array(
									'title' => esc_html__('Item Padding', 'frmaster'),
									'type' => 'text',
									'data-type' => 'pixel',
									'data-input-type' => 'pixel',
									'default' => '15px',
									'selector' => '.frmaster-item-pdlr{ padding-left: #gdlr#; padding-right: #gdlr#; }'  . 
										'.frmaster-item-mglr{ margin-left: #gdlr#; margin-right: #gdlr#; }' .
										'.frmaster-item-rvpdlr{ margin-left: -#gdlr#; margin-right: -#gdlr#; }'
								),
								'money-format' => array(
									'title' => esc_html__('Money Format', 'frmaster'),
									'type' => 'text',
									'default' => '$NUMBER',
									'description' => esc_html__('Fill the format of your currency before or after the "NUMBER" string.', 'frmaster')
								),
								'price-decimal-digit' => array(
									'title' => esc_html__('Price Decimal Digit', 'frmaster'),
									'type' => 'text',
									'default' => '2',
									'description' => esc_html__('Fill only number here', 'frmaster')
								),
								'price-thousand-separator' => array(
									'title' => esc_html__('Price Thousand Separator', 'frmaster'),
									'type' => 'text',
									'default' => ',',
								),
								'price-decimal-separator' => array(
									'title' => esc_html__('Price Decimal Separator', 'frmaster'),
									'type' => 'text',
									'default' => '.',
								),
								
							)
						),

						'user-page' => array(
							'title' => esc_html__('User / Template', 'frmaster'),
							'options' => array(
								'enable-recaptcha' => array(
									'title' => esc_html__('Enable Google Recaptcha', 'frmaster'),
									'type' => 'checkbox',
									'default' => 'disable',
									'description' => wp_kses(__('Have to install the <a href="https://wordpress.org/plugins/google-captcha/" target="_blank" >google captcha plugin</a> first.', 'frmaster'), array('a'=>array('href'=>array(), 'target'=>array()))) . 
										'<br><br>' . esc_html__('Enable this option will removes all lightbox login/registration out.', 'frmaster')
								),
								'enable-membership' => array(
									'title' => esc_html__('Enable Membership', 'frmaster'),
									'type' => 'checkbox',
									'default' => 'enable'
								),
								'login-page' => array(
									'title' => esc_html__('Login Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'description' => esc_html__('Choose the page to use header / footer of that page as template. Select "None" to use homepage settings.', 'frmaster'),
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'register-page' => array(
									'title' => esc_html__('Register Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'description' => esc_html__('Choose the page to use header / footer of that page as template. Select "None" to use homepage settings.', 'frmaster'),
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'register-term-of-service-page' => array(
									'title' => esc_html__('Term Of Service ( Registration ) Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'register-privacy-statement-page' => array(
									'title' => esc_html__('Privacy Statement ( Registration ) Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'user-page' => array(
									'title' => esc_html__('User Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'description' => esc_html__('Choose the page to use header / footer of that page as template. Select "None" to use homepage settings.', 'frmaster'),
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'user-navigation-bottom-text' => array(
									'title' => esc_html__('User Navigation Bottom Text', 'frmaster'),
									'type' => 'textarea',
									'condition' => array( 'enable-membership' => 'enable' )
								),
								'user-default-country' => array(
									'title' => esc_html__('User Default Country', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_country_list(true)
								),
								'mobile-login-link' => array(
									'title' => esc_html__('Change Mobile Login/Register (From Lightbox) To Link', 'frmaster'),
									'type' => 'checkbox',
									'default' => 'disable',
									'condition' => array( 'enable-membership' => 'enable' )
								)
							)
						),

						'cause-manager' => array(
							'title' => esc_html__('Cause Manager', 'frmaster'),
							'options' => array(
								
								'cause-author-capability' => array(
									'title' => esc_html__('Cause Author Capability', 'frmaster'),
									'type' => 'multi-combobox',
									'options' => array(
										'edit_cause' => esc_html__('Edit Cause', 'frmaster'),
										'read_cause' => esc_html__('Read Cause', 'frmaster'),
										'delete_cause' => esc_html__('Delete Cause', 'frmaster'),
										'delete_causes' => esc_html__('Delete Causes', 'frmaster'),
										'edit_causes' => esc_html__('Edit Causes', 'frmaster'),
										'edit_others_causes' => esc_html__('Edit Others Causes', 'frmaster'),
										'publish_causes' => esc_html__('Publish Causes', 'frmaster'),
										'read_private_causes' => esc_html__('Read Private Tours', 'frmaster'),
										'manage_cause_category' => esc_html__('Manage Cause Category', 'frmaster'),
										'manage_cause_tag' => esc_html__('Manage Cause Tag', 'frmaster'),
										// 'manage_cause_filter' => esc_html__('Manage Cause Filter', 'frmaster'),
										'manage_cause_order' => esc_html__('Manage Cause Order', 'frmaster'),
										'upload_files' => esc_html__('Upload Files', 'frmaster'),
									),
									'default' => array( 
										'edit_cause', 'read_cause', 'delete_cause', 'delete_causes', 
										'edit_causes', 'edit_others_causes', 'publish_causes', 'read_private_causes',
										'manage_cause_category', 'manage_cause_tag', 'manage_cause_filter',
										'upload_files'
									)
								),
								'cause-info-width' => array(
									'title' => esc_html__('Cause Info Width', 'frmaster'),
									'type' => 'combobox',
									'options' => array(
										'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
									),
									'default' => 20,
								),
								'single-cause-thumbnail-size' => array(
									'title' => esc_html__('Single Cause Thumbnail Size', 'frmaster'),
									'type' => 'combobox',
									'options' => 'thumbnail-size'
								)

							)
						),

						'payment-page' => array(
							'title' => esc_html__('Payment Page', 'frmaster'),
							'options' => array(
								'payment-page' => array(
									'title' => esc_html__('Payment Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
									'description' => esc_html__('Choose the page to use header / footer of that page as template. Select "None" to use homepage settings.', 'frmaster')
								),
								'payment-head-thumbnail-size' => array(
									'title' => esc_html__('Payment Head Thumbnail Size', 'frmaster'),
									'type' => 'combobox',
									'options' => 'thumbnail-size'
								),
								'payment-bottom-text-title' => array(
									'title' => esc_html__('Payment Bottom Text Title', 'frmaster'),
									'type' => 'text'
								),
								'payment-bottom-text' => array(
									'title' => esc_html__('Payment Bottom Text', 'frmaster'),
									'type' => 'textarea',
									'wrapper-class' => 'frmaster-fullsize'
								),
								'payment-button1-amount' => array(
									'title' => esc_html__('Payment Button 1 Amount', 'frmaster'),
									'type' => 'text',
									'default' => '10',
								),
								'payment-button2-amount' => array(
									'title' => esc_html__('Payment Button 2 Amount', 'frmaster'),
									'type' => 'text',
									'default' => '20',
								),
								'payment-button3-amount' => array(
									'title' => esc_html__('Payment Button 3 Amount', 'frmaster'),
									'type' => 'text',
									'default' => '30',
								),
								'payment-button4-amount' => array(
									'title' => esc_html__('Payment Button 4 Amount', 'frmaster'),
									'type' => 'text',
									'default' => '40',
								)
							)
						),

						'offline-payment' => array(
							'title' => esc_html__('Offline Payment', 'frmaster'),
							'options' => array(
								'offline-payment-description' => array(
									'title' => esc_html__('Payment Bar - Offline Payment Description', 'frmaster'),
									'type' => 'textarea',
									'wrapper-class' => 'frmaster-fullsize'
								),

								'offline-payment-bank-name' => array(
									'title' => esc_html__('Offline Payment Bank Name', 'frmaster'),
									'type' => 'text'
								),
								'offline-payment-account-number' => array(
									'title' => esc_html__('Offline Payment Account Number', 'frmaster'),
									'type' => 'text'
								),
								'offline-payment-swift-code' => array(
									'title' => esc_html__('Offline Payment Swift Code', 'frmaster'),
									'type' => 'text'
								),
								'offline-payment-message' => array(
									'title' => esc_html__('Offline Payment Message', 'frmaster'),
									'type' => 'textarea'
								)
							)
						),

						'invoice-settings' => array(
							'title' => esc_html__('Invoice Settings', 'frmaster'),
							'options' => array(
								'invoice-logo' => array(
									'title' => esc_html__('Invoice Logo', 'frmaster'),
									'type' => 'upload'
								),
								'invoice-logo-width' => array(
									'title' => esc_html__('Invoice Logo Width', 'frmaster'),
									'type' => 'text',
									'data-type' => 'pixel',
									'data-input-type' => 'pixel',
									'default' => '250px',
									'selector' => '.frmaster-invoice-logo{ width: #gdlr#; }'
								),
								'invoice-company-name' => array(
									'title' => esc_html__('Invoice Company Name', 'frmaster'),
									'type' => 'text',
									'default' => esc_html__('Company Name', 'frmaster'),
								),
								'invoice-company-info' => array(
									'title' => esc_html__('Invoice Company Info', 'frmaster'),
									'type' => 'textarea',
								),
								'invoice-customer-address' => array(
									'title' => esc_html__('Invoice Customer Address', 'frmaster'),
									'type' => 'textarea',
									'default' => "{first_name} {last_name} \n{contact_address}",
								),
								'invoice-signature-image' => array(
									'title' => esc_html__('Invoice Signature Image', 'frmaster'),
									'type' => 'upload'
								),
								'invoice-signature-name' => array(
									'title' => esc_html__('Invoice Signature Name', 'frmaster'),
									'type' => 'text'
								),
								'invoice-signature-position' => array(
									'title' => esc_html__('Invoice Signature Position', 'frmaster'),
									'type' => 'text'
								),
							)
						),
						'mail-settings' => array(
							'title' => esc_html__('E-Mail Settings', 'frmaster'),
							'options' => array(
								'system-email-name' => array(
									'title' => esc_html__('System Name ( For E-mail Sending )', 'frmaster'),
									'type' => 'text',
									'default' => 'WORDPRESS'
								),
								'system-email-address' => array(
									'title' => esc_html__('System E-Mail Address', 'frmaster'),
									'type' => 'text'
								),
								'admin-email-address' => array(
									'title' => esc_html__('Admin Donation E-Mail Address', 'frmaster'),
									'type' => 'text',
									'description' => esc_html__('Fill the admin email here to submit the notification upon completing booking process.')
								),
								'admin-registration-email-address' => array(
									'title' => esc_html__('Admin Registration E-Mail Address', 'frmaster'),
									'type' => 'text',
									'description' => esc_html__('Fill the admin email here to submit the notification upon completing the user registration process. Leave this field blank to use the same mail as "Booking Email Address"')
								),
								'mail-header-logo' => array(
									'title' => esc_html__('E-Mail Header Logo', 'frmaster'),
									'type' => 'upload',
								),
								'mail-footer-left' => array(
									'title' => esc_html__('E-Mail Footer Left', 'frmaster'),
									'type' => 'textarea',
								),
								'mail-footer-right' => array(
									'title' => esc_html__('E-Mail Footer Right', 'frmaster'),
									'type' => 'textarea',
								),
							)
						),
						
						'admin-mail-content' => array(
							'title' => esc_html__('Admin E-Mail Content', 'frmaster'),
							'options' => array(
								'enable-admin-registration-complete-mail' => array(
									'title' => esc_html__('Enable Admin Registration Complete E-Mail', 'frmaster'),
									'type' => 'checkbox'
								),
								'admin-registration-complete-mail-title' => array(
									'title' => esc_html__('Admin Registration Complete E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => "New user registration",
									'condition' => array('enable-admin-registration-complete-mail' => 'enable')
								),
								'admin-registration-complete-mail' => array(
									'title' => esc_html__('Admin Registration Complete E-Mail', 'frmaster'),
									'type' => 'textarea',
									'default' => "<strong>Dear Admin,</strong> \n New customer has created an account \n\n Donor's name : {first_name} {last_name} \n Donor's email : {email} \n Donor's contact number : {phone}",
									'wrapper-class' => 'frmaster-fullsize', 
									'condition' => array('enable-admin-registration-complete-mail' => 'enable')
								),
								'enable-admin-pending-donation-mail' => array(
									'title' => esc_html__('Enable Admin Pending Donation', 'frmaster'),
									'type' => 'checkbox'
								),
								'admin-pending-donation-mail-title' => array(
									'title' => esc_html__('Admin Pending Donation E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => "There's a new pending donation.",
									'condition' => array('enable-admin-pending-donation-mail' => 'enable')
								),
								'admin-pending-donation-mail' => array(
									'title' => esc_html__('Admin Pending Donation E-Mail', 'frmaster'),
									'type' => 'textarea',
									'default' => "<strong>Dear Admin,</strong> \nThere's a new pending donation \n\n{cause-name} \n{order-id} \n{donation-amount} \n{spaces} \n{donor-type} \n\nYou can <a href=\"{admin-transaction-link}\">view or change status of the transaction here</a>",
									'wrapper-class' => 'frmaster-fullsize', 
									'condition' => array('enable-admin-pending-donation-mail' => 'enable')
								),
								'enable-admin-success-donation-mail' => array(
									'title' => esc_html__('Enable Admin Success Donation', 'frmaster'),
									'type' => 'checkbox'
								),
								'admin-success-donation-mail-title' => array(
									'title' => esc_html__('Admin Success Donation E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => "A new donation has been successfully paid.",
									'condition' => array('enable-admin-success-donation-mail' => 'enable')
								),
								'admin-success-donation-mail' => array(
									'title' => esc_html__('Admin Success Donation E-Mail', 'frmaster'),
									'type' => 'textarea',
									'default' => "<strong>Dear Admin,</strong> \nA new donation has been successfully paid. \n\n{payment-method} \n{payment-date} \n{transaction-id} \n\n{cause-name} \n{order-id} \n{donation-amount} \n{spaces} \n{donor-type} \n\n{name}\n{email} \n{phone} \n\nYou can <a href=\"{admin-transaction-link}\">view or change status of the transaction here</a>", 
									'wrapper-class' => 'frmaster-fullsize', 
									'condition' => array('enable-admin-success-donation-mail' => 'enable')
								),
							)
						),
						'customer-mail-content' => array(
							'title' => esc_html__('Customer E-Mail Content', 'frmaster'),
							'options' => array(
								'enable-registration-complete-mail' => array(
									'title' => esc_html__('Enable Registration Complete E-Mail', 'frmaster'),
									'type' => 'checkbox'
								),
								'registration-complete-mail-title' => array(
									'title' => esc_html__('Registration Complete E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => 'Congratulations! Your account has been created',
									'condition' => array( 'enable-registration-complete-mail' => 'enable' )
								),
								'registration-complete-mail' => array(
									'title' => esc_html__('Registration Complete E-Mail', 'frmaster'),
									'type' => 'textarea',
									'wrapper-class' => 'frmaster-fullsize',
									'default' => "{header}Congratulations <strong>{first_name} {last_name}</strong>!{/header} \n\nYour account has been successfully created. Now you can view your contributions and you can also follow your favorite projects. \n\n<a href=\"{profile-page-link}\" >Click here to login to Chariti</a>",
									'condition' => array( 'enable-registration-complete-mail' => 'enable' )
								),
								'enable-pending-donation-mail' => array(
									'title' => esc_html__('Enable Pending Donation', 'frmaster'),
									'type' => 'checkbox'
								),
								'pending-donation-mail-title' => array(
									'title' => esc_html__('Pending Donation E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => "Your donation is pending for payment.",
									'condition' => array('enable-pending-donation-mail' => 'enable')
								),
								'pending-donation-mail' => array(
									'title' => esc_html__('Pending Donation E-Mail', 'frmaster'),
									'type' => 'textarea',
									'default' => "<strong>Dear {donor_name},</strong> \nPlease transfer funds using information below. \n\n{cause-name} \n{order-id} \n{donation-amount} \n\n{spaces} \n<strong>Bank Name : London Center Bank</strong> \n<strong>Account Number : 1245-23566-23</strong> \n<strong>Swift Code : LDSSCH</strong> \n{spaces} \n\n*After you transfer funds, please send email to Payment@chariti.theme \n Please include donation ID and attach payment receipt in an email. After verification, we will send confirmation email to you.",
									'wrapper-class' => 'frmaster-fullsize', 
									'condition' => array('enable-pending-donation-mail' => 'enable')
								),
								'enable-success-donation-mail' => array(
									'title' => esc_html__('Enable Success Donation', 'frmaster'),
									'type' => 'checkbox'
								),
								'success-donation-mail-title' => array(
									'title' => esc_html__('Success Donation E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => "Your payment has been successfully processed.",
									'condition' => array('enable-success-donation-mail' => 'enable')
								),
								'success-donation-mail' => array(
									'title' => esc_html__('Success Donation E-Mail', 'frmaster'),
									'type' => 'textarea',
									'default' => "<strong>Dear {donor_name},</strong> \nYour payment has been successfully processed. \n\n{cause-name} \n{order-id} \n{donation-amount} \n\n{payment-method} \n{payment-date} \n{transaction-id} \n\n{profile-page-link}",
									'wrapper-class' => 'frmaster-fullsize', 
									'condition' => array('enable-success-donation-mail' => 'enable')
								),
								'enable-booking-cancelled-mail' => array(
									'title' => esc_html__('Enable Booking Cancelled E-Mail', 'frmaster'),
									'type' => 'checkbox',
								),
								'booking-cancelled-mail-title' => array(
									'title' => esc_html__('Booking Cancelled E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => 'Your donation has been cancelled.',
									'condition' => array( 'enable-booking-cancelled-mail' => 'enable' )
								),
								'booking-cancelled-mail' => array(
									'title' => esc_html__('Booking Cancelled E-Mail', 'frmaster'),
									'type' => 'textarea',
									'wrapper-class' => 'frmaster-fullsize',
									'default' => "<strong>Dear {donor_name},</strong> \nYour donation has been cancelled. \n\n{cause-name} \n{order-id} \n{donation-amount}",
									'condition' => array( 'enable-booking-cancelled-mail' => 'enable' )
								),
								'enable-booking-reject-mail' => array(
									'title' => esc_html__('Enable Booking Reject E-Mail', 'frmaster'),
									'type' => 'checkbox'
								),
								'booking-reject-mail-title' => array(
									'title' => esc_html__('Booking Reject E-Mail Title', 'frmaster'),
									'type' => 'text',
									'default' => 'Unfortunately, your payment has been rejected.',
									'condition' => array( 'enable-booking-reject-mail' => 'enable' )
								),
								'booking-reject-mail' => array(
									'title' => esc_html__('Booking Reject E-Mail', 'frmaster'),
									'type' => 'textarea',
									'wrapper-class' => 'frmaster-fullsize',
									'default' => "<strong>Dear {donor_name},</strong> \nUnfortunately, your payment has been rejected. \n\n{cause-name} \n{order-id} \n{donation-amount} \n\nPlease email to us for more detail : help@chariti.theme",
									'condition' => array( 'enable-booking-reject-mail' => 'enable' )
								),
							)
						), // customer mail content
						
					)
				));
				
				// payment
				$frmaster_option->add_element(array(
					'title' => esc_html__('Payment', 'frmaster'),
					'slug' => 'frmaster_payment',
					'icon' => FRMASTER_URL . '/images/plugin-options/general.png',
					'options' => apply_filters('frmaster_plugin_payment_option', array(
						'payment-settings' => array(
							'title' => esc_html__('Payment Settings', 'frmaster'),
							'options' => array(
								'payment-method' => array(
									'title' => esc_html__('Payment Method', 'frmaster'),
									'type' => 'multi-combobox',
									'options' => array(
										'offline' => esc_html__('Offline', 'frmaster'),
										'paypal' => esc_html__('Online - Paypal', 'frmaster'),
										'credit-card' => esc_html__('Online - Credit Card', 'frmaster'),
									),
									'default' => array('offline', 'paypal', 'credit-card'),
									'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item.', 'frmaster'),
								),
								'credit-card-payment-gateway' => array(
									'title' => esc_html__('Credit Card Payment Gateway', 'frmaster'),
									'type' => 'combobox',
									'options' => apply_filters('frmaster_credit_card_payment_gateway_options', array('' => esc_html__('None', 'frmaster'))),
								),
								'accepted-credit-card-type' => array(
									'title' => esc_html__('Accepted Credit Card Type', 'frmaster'),
									'type' => 'multi-combobox',
									'options' => array(
										'visa' => esc_html__('visa', 'frmaster'),
										'master-card' => esc_html__('Master Card', 'frmaster'),
										'american-express' => esc_html__('American Express', 'frmaster'),
										'jcb' => esc_html__('JCB', 'frmaster'),
									),
									'default' => array('visa', 'master-card', 'american-express', 'jcb'),
									'description' => esc_html__('Only display images below credit card option.', 'frmaster')
								),
								'term-of-service-page' => array(
									'title' => esc_html__('Payment Term Of Service Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
								),
								'privacy-statement-page' => array(
									'title' => esc_html__('Payment Privacy Statement Page', 'frmaster'),
									'type' => 'combobox',
									'options' => frmaster_get_post_list('page', true),
								),
							)
						)
					))
				));

				// color
				$frmaster_option->add_element(array(
					'title' => esc_html__('Color', 'frmaster'),
					'slug' => 'frmaster_color',
					'icon' => FRMASTER_URL . '/images/plugin-options/color.png',
					'options' => array(

						'frmaster-general' => array(
							'title' => esc_html__('General', 'frmaster'),
							'options' => array(
								'frmaster-theme-color' => array(
									'title' => esc_html__('User Theme Color', 'frmaster'),
									'type' => 'colorpicker',
									'data-type' => 'rgba',
									'selector' => 
'.frmaster-user-navigation .frmaster-user-navigation-item.frmaster-active a, ' . 
'.frmaster-user-navigation .frmaster-user-navigation-item.frmaster-active a:hover{ color: #gdlr#; }' .
'.frmaster-user-navigation .frmaster-user-navigation-item.frmaster-active:before{ border-color: #gdlr#; }' . 
'.frmaster-user-content-block .frmaster-user-content-title{ color: #gdlr#; }' .
'.frmaster-body .frmaster-user-breadcrumbs span.frmaster-active{ color: #gdlr#; }' .
'.frmaster-notification-box, .frmaster-user-update-notification{ background: #gdlr#; }' . 
'body a.frmaster-button, body a.frmaster-button:hover, body a.frmaster-button:active, body a.frmaster-button:focus, ' .
'body input[type="button"].frmaster-button, body input[type="button"].frmaster-button:hover, body input[type="submit"].frmaster-button, body input[type="submit"].frmaster-button:hover{ background-color: #gdlr#; }' .
'body a.frmaster-button.frmaster-border-style, body a.frmaster-button.frmaster-border-style:hover{ color: #gdlr#; border-color: #gdlr#; }' . 
'.frmaster-payment-form form input.frmaster-payment-button[type="submit"], .frmaster-payment-form form button{ background-color: #gdlr#; }' .
'.frmaster-body .frmaster-pagination a:hover, .frmaster-body .frmaster-pagination a.frmaster-active, .frmaster-body .frmaster-pagination span{ background-color: #gdlr#; }' .
'.frmaster-body .frmaster-filterer-wrap a:hover, .frmaster-body .frmaster-filterer-wrap a.frmaster-active{ color: #gdlr#; }' . 
'.frmaster-login-form .frmaster-login-lost-password a, ' .
'.frmaster-login-form .frmaster-login-lost-password a:hover, ' .
'.frmaster-login-bottom .frmaster-login-bottom-link, .frmaster-login-bottom .frmaster-login-bottom-link:hover, ' .
'.frmaster-register-bottom .frmaster-register-bottom-link, .frmaster-register-bottom .frmaster-register-bottom-link:hover{ color: #gdlr#; }' .
'.frmaster-follow-item .frmaster-follow-item-title, ' .
'.frmaster-follow-item .frmaster-follow-item-title:hover{ color: #gdlr#; }' . 
'.frmaster-template-wrapper-user .frmaster-my-contribution-filter a:hover, ' .
'.frmaster-template-wrapper-user .frmaster-my-contribution-filter a.frmaster-active{ color: #gdlr#; } ' .
'table.frmaster-my-contribution-table .frmaster-my-contribution-title, ' .
'table.frmaster-my-contribution-table .frmaster-my-contribution-title:hover{ color: #gdlr#; } ' .
'table.frmaster-my-contribution-table a.frmaster-my-contribution-action{ background: #gdlr#; } ' .
'.frmaster-user-content-inner-my-contribution-single .frmaster-my-contribution-single-title{ color: #gdlr#; }',
									'default' => '#485da1',
								),
								'frmaster-email-theme-color' => array(
									'title' => esc_html__('Email Theme Color', 'frmaster'),
									'type' => 'colorpicker',
									'default' => '#2123bc'
								),
								'frmaster-remove-color' => array(
									'title' => esc_html__('Remove/Error Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-follow-remove-item{ color: #gdlr#; }' . 
										'.frmaster-notification-box.frmaster-failure, .frmaster-user-update-notification.frmaster-failure{ background: #gdlr#; }' . 
										'.frmaster-tour-booking-submit-error, .frmaster-tour-booking-error-max-people{ background: #gdlr#; }' . 
										'.frmaster-tour-booking-bar-coupon-wrap .frmaster-tour-booking-coupon-message.frmaster-failed{ background-color: #gdlr#; }',
									'default' => '#ba4a4a',
								),
							)
						), // frmaster-general

						'frmaster-user-template' => array(
							'title' => esc_html__('User Template', 'frmaster'),
							'options' => array(
								'user-login-submenu-background' => array(
									'title' => esc_html__('User Login Submenu Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-top-bar-nav-inner{ background-color: #gdlr#; }',
									'default' => '#ffffff',
								),
								'user-login-submenu-border' => array(
									'title' => esc_html__('User Login Submenu Border', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => 'body .frmaster-user-top-bar-nav .frmaster-user-top-bar-nav-item{ border-color: #gdlr#; }',
									'default' => '#e6e6e6',
								),
								'user-login-submenu-text' => array(
									'title' => esc_html__('User Login Submenu Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => 'body .frmaster-user-top-bar-nav .frmaster-user-top-bar-nav-item a, body .frmaster-user-top-bar-nav .frmaster-user-top-bar-nav-item a:hover{ color: #gdlr#; }',
									'default' => '#878787',
								),
								'user-template-background' => array(
									'title' => esc_html__('User Template Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-wrapper-user{ background-color: #gdlr#; }',
									'default' => '#f3f3f3',
								),
								'user-template-navigation-background' => array(
									'title' => esc_html__('User Template Navigation Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-navigation{ background: #gdlr#; }',
									'default' => '#ffffff',
								),
								'user-template-navigation-title' => array(
									'title' => esc_html__('User Template Navigation Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-navigation .frmaster-user-navigation-head{ color: #gdlr#; }',
									'default' => '#3f3f3f',
								),
								'user-template-navigation-text' => array(
									'title' => esc_html__('User Template Navigation Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-navigation .frmaster-user-navigation-item a, .frmaster-user-navigation .frmaster-user-navigation-item a:hover{ color: #gdlr#; }',
									'default' => '#7d7d7d',
								),
								'user-template-navigation-border' => array(
									'title' => esc_html__('User Template Navigation Border', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-navigation .frmaster-user-navigation-item-sign-out{ border-color: #gdlr#; }',
									'default' => '#e5e5e5',
								),
								'user-template-breadcrumbs-text' => array(
									'title' => esc_html__('User Template Bread Crumbs Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-body .frmaster-user-breadcrumbs a, .frmaster-body .frmaster-user-breadcrumbs a:hover, .frmaster-body .frmaster-user-breadcrumbs span{ color: #gdlr#; }',
									'default' => '#a5a5a5',
								),
								'user-template-content-block-background' => array(
									'title' => esc_html__('User Template Content Block Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-content-block{ background-color: #gdlr#; }',
									'default' => '#ffffff',
								),
								'user-template-content-block-title-link' => array(
									'title' => esc_html__('User Template Content Block Title Link', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-content-block .frmaster-user-content-title-link, .frmaster-user-content-block .frmaster-user-content-title-link:hover{ color: #gdlr#; }',
									'default' => '#9e9e9e',
								),
								'user-template-content-block-border' => array(
									'title' => esc_html__('User Template Content Block Border', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-user-content-block .frmaster-user-content-title-wrap, ' . 
										'table.frmaster-table th, .frmaster-template-wrapper table.frmaster-table tr td{ border-color: #gdlr#; }',
									'default' => '#e8e8e8',
								),
								'user-template-content-block-text' => array(
									'title' => esc_html__('User Template Content Block Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-my-profile-info .frmaster-head, .frmaster-my-profile-info .frmaster-tail, ' . 
										'.frmaster-edit-profile-wrap .frmaster-head, table.frmaster-table th, table.frmaster-table td{ color: #gdlr#; }' . 
										'.frmaster-user-content-inner-my-contribution-single .frmaster-my-contribution-single-field{ color: #gdlr#; }',
									'default' => '#545454',
								),
							)
						), // frmaster-user-template
						
						'frmaster-user-template2' => array(
							'title' => esc_html__('User Template 2', 'frmaster'),
							'options' => array(
								'frmaster-contribution-status-text-color' => array(
									'title' => esc_html__('Booking Status Text Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-contribution-status{ color: #gdlr#; }',
									'default' => '#acacac',
								),
								'frmaster-contribution-status-pending-color' => array(
									'title' => esc_html__('Booking Status Pending Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-contribution-status.frmaster-status-pending{ color: #gdlr#; }',
									'default' => '#24a04a',
								),
								'frmaster-contribution-status-online-paid' => array(
									'title' => esc_html__('Booking Status Online Paid', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-contribution-status.frmaster-status-online-paid{ color: #gdlr#; }',
									'default' => '#cd9b45',
								),
								'frmaster-invoice-title-color' => array(
									'title' => esc_html__('Invoice Title Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-invoice-head, .frmaster-invoice-signature{ color: #gdlr#; }',
									'default' => '#121212',
								),
								'frmaster-invoice-price-head-background' => array(
									'title' => esc_html__('Invoice Price Header Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-invoice-price-head, .frmaster-invoice-payment-info{ background-color: #gdlr#; }',
									'default' => '#f3f3f3',
								),
								'frmaster-invoice-price-head-text' => array(
									'title' => esc_html__('Invoice Price Header Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-invoice-price-head, .frmaster-invoice-payment-info{ color: #gdlr#; }',
									'default' => '#454545',
								),
								'frmaster-invoice-price-text' => array(
									'title' => esc_html__('Invoice Price Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-invoice-price .frmaster-head, .frmaster-invoice-total-price{ color: #gdlr#; }',
									'default' => '#7b7b7b',
								),
								'frmaster-invoice-price-amount' => array(
									'title' => esc_html__('Invoice Price Amount', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-invoice-price .frmaster-tail{ color: #gdlr#; }',
									'default' => '#1e1e1e',
								),
							)
						),
						
						'frmaster-input-color' => array(
							'title' => esc_html__('Input', 'frmaster'),
							'options' => array(
								'frmaster-input-form-label' => array(
									'title' => esc_html__('Input Form Label', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-payment-traveller-info-wrap .frmaster-head, .frmaster-payment-contact-wrap .frmaster-head, ' .
										'.frmaster-payment-billing-wrap .frmaster-head, .frmaster-payment-additional-note-wrap .frmaster-head, ' .
										'.frmaster-payment-detail-wrap .frmaster-payment-detail, .frmaster-payment-detail-notes-wrap .frmaster-payment-detail, ' .
										'.frmaster-payment-traveller-detail .frmaster-payment-detail{ color: #gdlr#; }' .
										'.frmaster-payment-form .frmaster-payment-form-field .goodlayers-payment-field-head{ color: #gdlr#; }',
									'default' => '#5c5c5c',
								),
								'frmaster-input-box-text' => array(
									'title' => esc_html__('Input Box Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-body .frmaster-form-field input[type="text"], .frmaster-body .frmaster-form-field input[type="email"], .frmaster-body .frmaster-form-field input[type="password"], ' .
										'.frmaster-body .frmaster-form-field textarea, .frmaster-body .frmaster-form-field select, .frmaster-body .frmaster-form-field input[type="text"]:focus, ' .
										'.frmaster-form-field.frmaster-with-border .frmaster-combobox-list-display, .frmaster-form-field .frmaster-combobox-list-wrap ul, ' .
										'.frmaster-body .frmaster-form-field input[type="email"]:focus, .frmaster-body .frmaster-form-field input[type="password"]:focus, .frmaster-body .frmaster-form-field textarea:focus{ color: #gdlr#; }' . 
										'.frmaster-payment-form .frmaster-payment-form-field input[type="text"]{ color: #gdlr#; }',
									'default' => '#545454',
								),
								'frmaster-input-box-background' => array(
									'title' => esc_html__('Input Box Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-body .frmaster-form-field input[type="text"], .frmaster-body .frmaster-form-field input[type="email"], .frmaster-body .frmaster-form-field input[type="password"], ' .
										'.frmaster-body .frmaster-form-field textarea, .frmaster-body .frmaster-form-field select, .frmaster-body .frmaster-form-field input[type="text"]:focus, ' .
										'.frmaster-body .frmaster-form-field input[type="email"]:focus, .frmaster-body .frmaster-form-field input[type="password"]:focus, .frmaster-body .frmaster-form-field textarea:focus{ background: #gdlr#; }' . 
										'.frmaster-payment-form .frmaster-payment-form-field input[type="text"]{ background-color: #gdlr#; }',
									'default' => '#ffffff',
								),
								'frmaster-input-box-background-validate-error' => array(
									'title' => esc_html__('Input Box Background Validate Error', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="text"], ' .
										'.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="email"], ' .
										'.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="password"], ' .
										'.frmaster-form-field.frmaster-with-border textarea.frmaster-validate-error, ' .
										'.frmaster-form-field.frmaster-with-border select.frmaster-validate-error{ background-color: #gdlr#; }' .
										'.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="text"]:focus, ' .
										'.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="email"]:focus, ' .
										'.frmaster-form-field.frmaster-with-border input.frmaster-validate-error[type="password"]:focus, ' .
										'.frmaster-form-field.frmaster-with-border textarea.frmaster-validate-error:focus, ' .
										'.frmaster-form-field.frmaster-with-border select.frmaster-validate-error:focus{ background-color: #gdlr#; }',
									'default' => '#fff9f9',
								),
								'frmaster-input-box-border' => array(
									'title' => esc_html__('Input Box Border', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-form-field.frmaster-with-border input[type="text"], .frmaster-form-field.frmaster-with-border input[type="email"], ' .
										'.frmaster-form-field.frmaster-with-border input[type="password"], .frmaster-form-field.frmaster-with-border textarea, ' .
										'.frmaster-form-field.frmaster-with-border select{ border-color: #gdlr#; }' . 
										'.frmaster-payment-form .frmaster-payment-form-field input[type="text"]{ border-color: #gdlr#; }',
									'default' => '#e6e6e6',
								),
								'frmaster-checkbox-box-border' => array(
									'title' => esc_html__('Checkbox Box Border', 'frmaster'),
									'type' => 'colorpicker',
									'default' => '#cccccc',
									'selector' => '.frmaster-tour-search-item-style-2 .frmaster-type-filter-term .frmaster-type-filter-display i{ border-color: #gdlr#; }'
								),
								'frmaster-upload-box-background' => array(
									'title' => esc_html__('Upload Box Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-form-field .frmaster-file-label-text{ background-color: #gdlr#; }',
									'default' => '#f3f3f3',
								),
								'frmaster-upload-box-text' => array(
									'title' => esc_html__('Upload Box Text Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-form-field .frmaster-file-label-text{ color: #gdlr#; }',
									'default' => '#a6a6a6',
								),

								'frmaster-lightbox-background' => array(
									'title' => esc_html__('Lightbox Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-lightbox-wrapper .frmaster-lightbox-content-wrap{ background-color: #gdlr#; }',
									'default' => '#ffffff',
								),
								'frmaster-lightbox-title' => array(
									'title' => esc_html__('Lightbox Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-lightbox-wrapper h3, .frmaster-lightbox-wrapper .frmaster-lightbox-title, ' .
										'.frmaster-lightbox-wrapper .frmaster-lightbox-close, .frmaster-payment-receipt-field .frmaster-head, '.
										'.frmaster-login-bottom .frmaster-login-bottom-title{ color: #gdlr#; }',
									'default' => '#0e0e0e',
								),
								'frmaster-lightbox-form-label' => array(
									'title' => esc_html__('Lightbox Form Label', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-login-form label, .frmaster-login-form2 label, ' .
										'.frmaster-lost-password-form label, .frmaster-reset-password-form label, ' .
										'.frmaster-register-form .frmaster-profile-field .frmaster-head{ color: #gdlr#; } ',
									'default' => '#5c5c5c',
								),

							)
						), // frmaster-input-color
						
						'frmaster-cause-color' => array(
							'title' => esc_html__('Cause Color', 'frmaster'),
							'options' => array(

								'cause-item-title-color' => array(
									'title' => esc_html__('Cause Item Title Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-cause-grid .frmaster-cause-title a, .frmaster-cause-grid .frmaster-cause-title a:hover{ color: #gdlr#; }',
									'default' => '#2123bc',
								),

								'cause-info-title-color' => array(
									'title' => esc_html__('Cause Info Title Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.single-cause .frmaster-cause-donated-bar-percent, .single-cause .frmaster-cause-donation-info .frmaster-head, .single-cause .frmaster-cause-social-share-wrap a, ' . 
										'.frmaster-cause-item .frmaster-cause-donated-bar-percent{ color: #gdlr#; }',
									'default' => '#2a2a2a',
								),
								'cause-goal-text-color' => array(
									'title' => esc_html__('Cause Goal Text Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.single-cause .frmaster-cause-goal, ' . 
										'.frmaster-cause-item .frmaster-cause-goal, .frmaster-cause-item .frmaster-cause-donated-amount, .frmaster-cause-widget .frmaster-cause-widget-donation-percent{ color: #gdlr#; }',
									'default' => '#c0c0c0',
								),
								'cause-percent-bar-background' => array(
									'title' => esc_html__('Cause Percent Bar Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-cause-donated-bar, .frmaster-cause-widget .frmaster-cause-widget-donation-bar{ background-color: #gdlr#; }',
									'default' => '#e6e6e6',
								),
								'cause-percent-bar-filled-background' => array(
									'title' => esc_html__('Cause Percent Bar Filled Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-cause-donated-bar span, .frmaster-cause-widget .frmaster-cause-widget-donation-bar-filled{ background-color: #gdlr#; }',
									'default' => '#40d5b7',
								),
								'cause-thumbnail-video-button-background' => array(
									'title' => esc_html__('Cause Thumbnail Video Button Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.single-cause .frmaster-single-cause-video-lb{ background-color: #gdlr#; }',
									'default' => '#2123bc',
								),
								'cause-thumbnail-gallery-button-background' => array(
									'title' => esc_html__('Cause Thumbnail Gallery Button Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.single-cause .frmaster-single-cause-gallery-lb{ background-color: #gdlr#; }',
									'default' => '#4041c7',
								),

							)
						),
						'frmaster-payment' => array(
							'title' => esc_html__('Payment', 'frmaster'),
							'options' => array(
								'frmaster-payment-head-background' => array(
									'title' => esc_html__('Payment Head Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-payment-head{ background-color: #gdlr#; }',
									'default' => '#282bc3',
								),
								'frmaster-payment-head-title' => array(
									'title' => esc_html__('Payment Head Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-cause-title, .frmaster-template-payment .frmaster-cause-donated-bar-percent{ color: #gdlr#; }',
									'default' => '#ffffff',
								),
								'frmaster-payment-head-content' => array(
									'title' => esc_html__('Payment Head Content', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-payment-head{ color: #gdlr#; }',
									'default' => '#a6a7fe',
								),
								'frmaster-payment-title' => array(
									'title' => esc_html__('Payment Section Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-register-form-title{ color: #gdlr#; }',
									'default' => '#2123bc',
								),
								'frmaster-head-title' => array(
									'title' => esc_html__('Payment Head Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-profile-item .frmaster-head{ color: #gdlr#; }',
									'default' => '#393939',
								),
								'frmaster-payment-bar-button-color' => array(
									'title' => esc_html__('Payment Bar Button Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-donation-amount-button, ' .
										'.frmaster-template-payment .frmaster-donation-method-button{ color: #gdlr#; border-color: #gdlr#; } ' .
										'.frmaster-template-payment .frmaster-donation-amount-button.frmaster-active, ' .
										'.frmaster-template-payment .frmaster-donation-method-button.frmaster-active, ' .
										'.frmaster-template-payment .frmaster-donation-submit, ' .
										'.frmaster-template-payment .frmaster-donation-submit:hover{ background: #gdlr#; }',
									'default' => '#2123bc',
								),
								'frmaster-payment-bar-description' => array(
									'title' => esc_html__('Payment Bar Description', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-donation-tab-head, .frmaster-donation-tab-description{ color: #gdlr#; }',
									'default' => '#bcbcbc',
								),
								'frmaster-online-payment-selection' => array(
									'title' => esc_html__('Online Payment Selection Color', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .frmaster-online-payment-method.frmaster-active{ border-color: #gdlr#; }',
									'default' => '#ff6f61',
								),

								'frmaster-payment-complete-title' => array(
									'title' => esc_html__('Payment Complete Title', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .donation-complete-title{ color: #gdlr#; }',
									'default' => '#2123bc',
								),
								'frmaster-payment-complete-title-icon' => array(
									'title' => esc_html__('Payment Complete Title Icon', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .donation-complete-title i, ' . 
										'.frmaster-template-payment .donation-complete-title-wrap i{ color: #gdlr#; }',
									'default' => '#ff6f61',
								),
								'frmaster-payment-complete-message-box-bg' => array(
									'title' => esc_html__('Payment Complete Message Box Background', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .donation-complete-message{ background-color: #gdlr#; }',
									'default' => '#fafafa',
								),
								'frmaster-payment-complete-message-box-border' => array(
									'title' => esc_html__('Payment Complete Message Box Border', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .donation-complete-message{ border-color: #gdlr#; }',
									'default' => '#ededed',
								),
								'frmaster-payment-complete-message-box-text' => array(
									'title' => esc_html__('Payment Complete Message Box Text', 'frmaster'),
									'type' => 'colorpicker',
									'selector' => '.frmaster-template-payment .donation-complete-message{ color: #gdlr#; }',
									'default' => '#39364f',
								),
							)
						),
					)
				));

				// miscalleneous
				$frmaster_option->add_element(array(
					'title' => esc_html__('Miscalleneous', 'frmaster'),
					'slug' => 'frmaster_plugin',
					'icon' => FRMASTER_URL . '/images/plugin-options/plugin.png',
					'options' => array(

						/*
						'plugins' => array(
							'title' => esc_html__('Plugins', 'frmaster'),
							'options' => array(

								'font-awesome' => array(
									'title' => esc_html__('Font Awesome', 'frmaster'),
									'type' => 'checkbox',
									'default' => 'enable',
									'description' => esc_html__('Disable this if the "Font Awesome" is already included on your site.', 'frmaster'),
								),
								'elegant-icon' => array(
									'title' => esc_html__('Elegant Icon', 'frmaster'),
									'type' => 'checkbox',
									'default' => 'enable',
									'description' => esc_html__('Disable this if the "Elegant Icon" is already included on your site.', 'frmaster'),
								)

							)
						),
						*/

						'import-export' => array(
							'title' => esc_html__('Import / Export', 'frmaster'),
							'options' => array(

								'export' => array(
									'title' => esc_html__('Export Option', 'frmaster'),
									'type' => 'export',
									'action' => 'frmaster_plugin_option_export',
									'options' => array(
										'all' => esc_html__('All Options (general/color/miscellaneous)', 'frmaster'),
										'frmaster_general' => esc_html__('General', 'frmaster'),
										'frmaster_color' => esc_html__('Color', 'frmaster'),
										'frmaster_plugin' => esc_html__('Miscellaneous', 'frmaster'),
									),
									'wrapper-class' => 'frmaster-fullsize'
								),
								'import' => array(
									'title' => esc_html__('Import Option', 'frmaster'),
									'type' => 'import',
									'wrapper-class' => 'frmaster-fullsize'
								),

							) // import-options
						), // import-export

					)
				));
			}
		} // frmaster_init_admin_option
	} // function_exists

