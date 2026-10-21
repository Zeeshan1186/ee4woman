<?php
	/**
	 * The template for displaying login page
	 */
nocache_headers();

// reset password action
if( !empty($_GET['action']) && $_GET['action'] == 'rp' ){
	list($rp_path) = explode('?', wp_unslash( $_SERVER['REQUEST_URI']));
	$rp_cookie = 'wp-resetpass-' . COOKIEHASH;

	if( isset($_GET['key']) ){
		$value = sprintf('%s:%s', wp_unslash($_GET['login']), wp_unslash($_GET['key']));
		setcookie($rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
		wp_safe_redirect(remove_query_arg(array('key')));
		exit;
	}

	if( isset($_COOKIE[$rp_cookie]) && 0 < strpos($_COOKIE[$rp_cookie], ':') ){
		list($rp_login, $rp_key) = explode(':', wp_unslash($_COOKIE[ $rp_cookie ]), 2);
		$user = check_password_reset_key($rp_key, $rp_login);
		if( isset($_POST['pass1']) && !hash_equals($rp_key, $_POST['rp_key']) ){
			$user = false;
		}
	}else{
		$user = false;
	}

	if( !$user || is_wp_error($user) ){
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		
		if( $user && $user->get_error_code() === 'expired_key' ){
			$rp_key_error = 'expired_key';
		}else{
			$rp_key_error = 'invalid_key';
		}
	}else{

		$errors = new WP_Error();

		do_action('validate_password_reset', $errors, $user);

		if( (!$errors->get_error_code()) && isset($_POST['pass1']) && !empty($_POST['pass1']) ){
			reset_password($user, $_POST['pass1']);
			setcookie($rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
			$rp_success = true;
		}else{
			$rp_error = $errors->get_error_message();
		}
	}
} // // reset password action

get_header();

	echo '<div class="frmaster-template-wrapper" >';
	echo '<div class="frmaster-container" >';
	echo '<div class="frmaster-page-content frmaster-' . (empty($_GET['action'])? 'login': $_GET['action']) . '-template-content  frmaster-item-pdlr" >';

	///////////////////////////
	// login page
	///////////////////////////
	if( empty($_GET['action']) ){
		if( !empty($_GET['status']) && $_GET['status'] == 'login_incorrect' ){
			echo '<div class="frmaster-notification-box frmaster-failure" >';
			echo esc_html__('Invalid username, email address or incorrect password.', 'frmaster');
			echo '</div>';
		}

		frmaster_get_login_form();

	///////////////////////////
	// lost password page
	///////////////////////////
	}else if( $_GET['action'] == 'lostpassword' ){
		if( !empty($_GET['status']) && $_GET['status'] == 'login_incorrect' ){
			echo '<div class="frmaster-notification-box frmaster-failure" >';
			echo esc_html__('Invalid username or email.', 'frmaster');
			echo '</div>';
		}
?>
<form class="frmaster-lost-password-form frmaster-form-field frmaster-with-border" method="post" action="<?php echo esc_url(network_site_url('wp-login.php?action=lostpassword', 'login_post')); ?>" >
	<p class="frmaster-lost-password-user">
		<label><?php echo esc_html__('Username or E-mail:', 'frmaster'); ?></label>
		<input type="text" name="user_login" />
	</p>
	<div class="clear"></div>
	<?php do_action('lostpassword_form'); ?>
	<p class="frmaster-lost-password-submit" >
		<input type="submit" class="frmaster-button" value="<?php echo esc_html__('Get New Password', 'frmaster'); ?>" />
	</p>
	<input type="hidden" name="source"  value="tm" />
</form>
<?php

	///////////////////////////
	// reset password page
	///////////////////////////
	}else if( $_GET['action'] == 'rp' ){

		if( !empty($rp_key_error) ){
			echo '<div class="frmaster-notification-box frmaster-failure" >';
			if( $rp_key_error == 'invalid_key' ){
				esc_html_e('Your password reset link appears to be invalid. Please request a new link below.', 'frmaster');
			}else if( $rp_key_error == 'expired_key' ){
				esc_html_e('Your password reset link has expired. Please request a new link below.', 'frmaster');
			}
			echo '</div>';

			echo '<p><a href="' . add_query_arg(array('source'=>'tm'), wp_lostpassword_url()) . '" >';
			echo esc_html__('Forget Password?','frmaster');
			echo '</a></p>';
		}else{

			if( !empty($rp_success) ){
				echo '<div class="frmaster-notification-box" >';
				echo esc_html__('Your password has been reset.', 'frmaster');
				echo '</div>';

				echo '<p><a href="' . frmaster_get_template_url('login') . '" >';
				echo esc_html__('Sign in to your account.','frmaster');
				echo '</a></p>';
			}else{
				//wp_enqueue_script('utils');
				wp_enqueue_script('user-profile');

				if( !empty($rp_error) ){
					echo '<div class="frmaster-notification-box frmaster-failure" >' . $rp_error . '</div>';
				}

				$pre_generate_pass = wp_generate_password(16);
?>
<form class="frmaster-reset-password-form frmaster-form-field frmaster-with-border" method="post" autocomplete="off" >
	<div class="frmaster-reset-password-new" >
		<label><?php esc_html_e('New password', 'frmaster') ?></label>
		<div class="wp-pwd">
			<input type="password" data-reveal="1" data-pw="<?php echo esc_attr( wp_generate_password( 16 ) ); ?>" name="pass1" id="pass1" class="input password-input" size="24" value="" autocomplete="off" aria-describedby="pass-strength-result" />

			<div id="pass-strength-result" class="hide-if-no-js" aria-live="polite"><?php _e( 'Strength indicator' ); ?></div>
		</div>
	</div>

	<p class="frmaster-reset-password-hint"><?php echo wp_get_password_hint(); ?></p>

	<?php do_action( 'resetpass_form', $user ); ?>

	<p class="frmaster-reset-password-submit">
		<input type="submit" name="wp-submit" class="frmaster-button" value="<?php esc_attr_e('Reset Password'); ?>" />
	</p>

	<input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
	<input type="hidden" id="user_login" value="<?php echo esc_attr($rp_login); ?>" autocomplete="off" />
</form>
<?php
			}
		}

	}

	echo '</div>'; // frmaster-page-content
	echo '</div>'; // frmaster-container
	echo '</div>'; // frmaster-template-wrapper

get_footer(); 

?>