<?php
	/*	
	*	Fundraise Master Plugin
	*	---------------------------------------------------------------------
	*	choosing template
	*	---------------------------------------------------------------------
	*/

	add_filter('template_include', 'frmaster_template_registration', 9999);
	if( !function_exists('frmaster_template_registration') ){
		function frmaster_template_registration( $template ){

			global $frmaster_template, $sitepress;
			$frmaster_template = false;
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');

			// archive template
			if( is_tax('cause_category') || is_tax('cause_tag') ){
				// $frmaster_template = 'archive';
				// $template = FRMASTER_LOCAL . '/single/archive.php';

			}else{

				// for user page
				if( $enable_membership == 'enable' ){
					$user_template = frmaster_get_option('general', 'user-page', '');
					if( empty($user_template) ){
						if( is_front_page() && isset($_GET['frmaster-user']) ){
							$frmaster_template = 'user';
							$template = FRMASTER_LOCAL . '/single/user.php';
						}
					}else{
						if( !empty($sitepress) ){
							$trid = $sitepress->get_element_trid($user_template, 'post_page');
							$translations = $sitepress->get_element_translations($trid,'post_page');

							$user_template = array();
							foreach( $translations as $translation ){
								$user_template[] = $translation->element_id;
							}
						}else{
							$user_template = array($user_template);
						}

						if( is_page() && in_array(get_the_ID(), $user_template) ){
							$frmaster_template = 'user';
							$template = FRMASTER_LOCAL . '/single/user.php';
						}
					}
				}

				// for login page
				if( $enable_membership == 'enable' ){
					$login_template = frmaster_get_option('general', 'login-page', '');
					if( empty($login_template) ){
						if( is_front_page() && isset($_GET['frmaster-login']) ){
							$frmaster_template = 'login';
							$template = FRMASTER_LOCAL . '/single/login.php';
						}
					}else{
						if( !empty($sitepress) ){
							$trid = $sitepress->get_element_trid($login_template, 'post_page');
							$translations = $sitepress->get_element_translations($trid,'post_page');

							$login_template = array();
							foreach( $translations as $translation ){
								$login_template[] = $translation->element_id;
							}
						}else{
							$login_template = array($login_template);
						}

						if( is_page() && in_array(get_the_ID(), $login_template) ){
							$frmaster_template = 'login';
							$template = FRMASTER_LOCAL . '/single/login.php';
						}
					}
				}

				// for registration page
				if( $enable_membership == 'enable' ){
					$register_template = frmaster_get_option('general', 'register-page', '');
					if( empty($register_template) ){
						if( is_front_page() && isset($_GET['frmaster-register']) ){
							$frmaster_template = 'register';
							$template = FRMASTER_LOCAL . '/single/register.php';
						}
					}else{
						if( !empty($sitepress) ){
							$trid = $sitepress->get_element_trid($register_template, 'post_page');
							$translations = $sitepress->get_element_translations($trid,'post_page');

							$register_template = array();
							foreach( $translations as $translation ){
								$register_template[] = $translation->element_id;
							}
						}else{
							$register_template = array($register_template);
						}
						
						if( is_page() && in_array(get_the_ID(), $register_template) ){
							$frmaster_template = 'register';
							$template = FRMASTER_LOCAL . '/single/register.php';
						}
					}
				}

				// for payment page
				$payment_template = frmaster_get_option('general', 'payment-page', '');
				if( empty($payment_template) ){
					if( is_front_page() && isset($_GET['frmaster-payment']) ){
						$frmaster_template = 'payment';
						$template = FRMASTER_LOCAL . '/single/payment.php';
					}
				}else{
					if( !empty($sitepress) ){
						$trid = $sitepress->get_element_trid($payment_template, 'post_page');
						$translations = $sitepress->get_element_translations($trid,'post_page');

						$payment_template = array();
						foreach( $translations as $translation ){
							$payment_template[] = $translation->element_id;
						}
					}else{
						$payment_template = array($payment_template);
					}
					
					if( is_page() && in_array(get_the_ID(), $payment_template) ){
						$frmaster_template = 'payment';
						$template = FRMASTER_LOCAL . '/single/payment.php';
					}
				}

			}


			// check if is authorize for that template
			if( $frmaster_template == 'user' && !is_user_logged_in() ){
				wp_redirect(frmaster_get_template_url('login'));
				exit;
			}else if( ($frmaster_template == 'login' || $frmaster_template == 'register') && is_user_logged_in() ){
				wp_redirect(frmaster_get_template_url('user'));
				exit;
			}

			if( $frmaster_template == 'payment' ){
				do_action('frmaster_payment_page_init');
			}
			return $template;
		} // frmaster_template_registration
	} // function_exists

	if( !function_exists('frmaster_get_template_url') ){
		function frmaster_get_template_url( $type, $args = array() ){
			
			$base_url = '';
			if( function_exists('pll_home_url') ){
				$base_url = pll_home_url();
			}else{
				$base_url = home_url('/');
			}
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');

			// login url
			if( $type == 'login' ){

				if( $enable_membership == 'enable' ){
					$login_template = frmaster_get_option('general', 'login-page', '');
					if( empty($login_template) ){
						$args['frmaster-login'] = '';
					}else{
						$base_url = get_permalink($login_template);
						if( !empty($_GET['lang']) ){
							$base_url = apply_filters('wpml_permalink', $base_url , $_GET['lang']);
						}
					}
				}
				
			// register url
			}else if( $type == 'register' ){

				if( $enable_membership == 'enable' ){
					$register_template = frmaster_get_option('general', 'register-page', '');
					if( empty($register_template) ){
						$args['frmaster-register'] = '';
					}else{
						$base_url = get_permalink($register_template);
					}
				}

			// author url
			}else if( $type == 'user' ){

				if( $enable_membership == 'enable' ){
					$user_template = frmaster_get_option('general', 'user-page', '');
					if( empty($user_template) ){
						$args['frmaster-user'] = '';
					}else{
						$base_url = get_permalink($user_template);
					}
				}

			}else if( $type == 'payment' ){

				$payment_template = frmaster_get_option('general', 'payment-page', '');
				if( empty($payment_template) ){
					$args['frmaster-payment'] = '';
				}else{
					$base_url = get_permalink($payment_template);
				}

			}

			if( !empty($base_url) ){
				return add_query_arg($args, $base_url);
			}

			return false;

		} // frmaster_get_template_url
	} // function_exists

	// add class for each plugin's template 
	add_filter('body_class', 'frmaster_template_class');
	if( !function_exists('frmaster_template_class') ){
		function frmaster_template_class( $classes ){

			global $frmaster_template;
			if( !empty($frmaster_template) ){
				$classes[] = 'frmaster-template-' . $frmaster_template;
			}
			return $classes;

		}
	}

	/***********************************
	** 	Login / Lost Password Section
	**  source = tm
	************************************/

	// for redirecting the login incorrect
	add_filter('authenticate', 'frmaster_login_error_redirect', 9999, 3);
	if( !function_exists('frmaster_login_error_redirect') ){
		function frmaster_login_error_redirect( $user, $username, $password ){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return $user;
			}

			if( !empty($_POST['source']) && $_POST['source'] == 'tm' ){
				$query_arg = array();
				if( !empty($_POST['redirect']) ){
					$query_arg['redirect'] = $_POST['redirect'];
				}

				if( empty($username) || empty($password) ){
					$query_arg['status'] = 'login_empty';
					$redirect_template = add_query_arg($query_arg, frmaster_get_template_url('login'));
					wp_redirect($redirect_template);
					exit();
				}else if( $user == null || is_wp_error($user) ){
					$query_arg['status'] = 'login_incorrect';
					$redirect_template = add_query_arg($query_arg, frmaster_get_template_url('login'));
					wp_redirect($redirect_template);
					exit();
				}
			}

			return $user;
		} // frmaster_login_error_redirect
	}

	// for lost password page
	add_action('lost_password', 'frmaster_lost_password_redirect', 1);
	if( !function_exists('frmaster_lost_password_redirect') ){
		function frmaster_lost_password_redirect(){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return;
			}

			if( !empty($_GET['source']) && $_GET['source'] == 'tm' ){
				$redirect_template = add_query_arg(array('action'=>'lostpassword'), frmaster_get_template_url('login'));
				wp_redirect($redirect_template);
				exit();
			}
		} // frmaster_lost_password_redirect
	}

	// lost password info incorrect
	add_action('login_form_lostpassword', 'frmaster_lost_password_error_redirect', 1);
	if( !function_exists('frmaster_lost_password_error_redirect') ){
		function frmaster_lost_password_error_redirect( $errors ){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return;
			}

			if( !empty($_POST['source']) && $_POST['source'] == 'tm' ){
				$user_data = null;
				if( !empty($_POST['user_login']) ){
					// check if it's email
					if( strpos($_POST['user_login'], '@') ){
						$user_data = get_user_by('email', trim(wp_unslash($_POST['user_login'])));
					// check if it's user	
					}else{
						$user_data = get_user_by('login', trim($_POST['user_login']));
					}
				}

				if( empty($user_data) ){
					$redirect_template = add_query_arg(array('action'=>'lostpassword', 'status'=>'login_incorrect'), frmaster_get_template_url('login'));
					wp_redirect($redirect_template);
					exit();
				}
			}
		} // frmaster_lost_password_error_redirect
	}

	// modify lost password email
	add_filter('retrieve_password_message', 'frmaster_retrieve_password_message', 9999, 4);
	if( !function_exists('frmaster_retrieve_password_message') ){
		function frmaster_retrieve_password_message( $message, $key, $user_login, $user_data ){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return $message;
			}

			if( !empty($_POST['source']) && $_POST['source'] == 'tm' ){
				$variable_location = strpos($message, 'action=rp&');
				$new_message = substr($message, 0, $variable_location) . 'source=tm&' . substr($message, $variable_location);
				$message = $new_message;
			}
			return $message;
		} // frmaster_retrieve_password_message
	}

	// redirect to reset password page
	add_action('login_form_rp', 'frmaster_login_form_rp_redirect', 9999);
	add_action('login_form_resetpass', 'frmaster_login_form_rp_redirect');
	if( !function_exists('frmaster_login_form_rp_redirect') ){
		function frmaster_login_form_rp_redirect(){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return;
			}

			if( !empty($_GET['source']) && $_GET['source'] == 'tm' ){
				$redirect_template = add_query_arg($_GET, frmaster_get_template_url('login'));
				wp_redirect($redirect_template);
				exit();
			} // frmaster_login_form_rp_redirect
		}
	}