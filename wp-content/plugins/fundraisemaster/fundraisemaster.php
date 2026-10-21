<?php
	/*
	Plugin Name: Fundraise Master
	Plugin URI: 
	Description: Fundraising management system plugin
	Version: 1.0.8
	Author: Goodlayers
	Author URI: http://www.goodlayers.com
	License: 
	*/
	
	// define necessary variable for the site.
	define('FRMASTER_URL', plugins_url('', __FILE__));
	define('FRMASTER_LOCAL', dirname(__FILE__));

	include_once(FRMASTER_LOCAL . '/framework/framework.php');

	include_once(FRMASTER_LOCAL . '/include/order.php');
	include_once(FRMASTER_LOCAL . '/include/order-util.php');
	
	include_once(FRMASTER_LOCAL . '/include/plugin-init.php');
	include_once(FRMASTER_LOCAL . '/include/table-util.php');
	include_once(FRMASTER_LOCAL . '/include/plugin-option.php');
	include_once(FRMASTER_LOCAL . '/include/template-settings.php');
	include_once(FRMASTER_LOCAL . '/include/cause-option.php');
	include_once(FRMASTER_LOCAL . '/include/user-util.php');
	include_once(FRMASTER_LOCAL . '/include/mail-util.php');
	include_once(FRMASTER_LOCAL . '/include/payment-util.php');
	include_once(FRMASTER_LOCAL . '/include/utility.php');

	include_once(FRMASTER_LOCAL . '/include/pb/pb-element-content-navigation.php');
	include_once(FRMASTER_LOCAL . '/include/pb/pb-element-cause.php');
	include_once(FRMASTER_LOCAL . '/include/pb/pb-element-cause-donation.php');
	include_once(FRMASTER_LOCAL . '/include/pb/cause-item.php');
	include_once(FRMASTER_LOCAL . '/include/pb/cause-style.php');

	include_once(FRMASTER_LOCAL . '/include/paypal.php');
	include_once(FRMASTER_LOCAL . '/include/stripe/stripe.php');
	// include_once(FRMASTER_LOCAL . '/include/paymill/paymill.php');
	include_once(FRMASTER_LOCAL . '/include/authorize/authorize.php');

	include_once(FRMASTER_LOCAL . '/include/widget/cause-widget.php');

	// add activation hook
	register_activation_hook(__FILE__, 'frmaster_plugin_activation');

	// init the ajax variable for wpml compatibility
	add_action('plugins_loaded', 'frmaster_ajax_url', 1);
	if( !function_exists('frmaster_ajax_url') ){
		function frmaster_ajax_url(){
			global $sitepress;
			if( !empty($sitepress) ){
				define('FRMASTER_AJAX_URL', admin_url('admin-ajax.php?lang=' . $sitepress->get_current_language()));
			}else{
				define('FRMASTER_AJAX_URL', admin_url('admin-ajax.php'));
			}
		}
	}

	// load text domain for localization
	add_action('init', 'frmaster_load_textdomain');
	if( !function_exists('frmaster_load_textdomain') ){
		function frmaster_load_textdomain() {
		  	load_plugin_textdomain('frmaster', false, plugin_basename(dirname(__FILE__)) . '/languages'); 
		}
	}	
	
	// enqueue necessay style/script
	if( !is_admin() ){ 
		add_action('wp_enqueue_scripts', 'frmaster_enqueue_script'); 
	}else{
		// for front end
		add_action('gdlr_core_front_script', 'frmaster_enqueue_script');
	}
	if( !function_exists('frmaster_enqueue_script') ){
		function frmaster_enqueue_script(){
			frmaster_enqueue_icon();

			wp_enqueue_style('frmaster-style', FRMASTER_URL . '/fundraisemaster.css', null, '1.0.0');
			if( is_rtl() ){
				wp_enqueue_style('frmaster-style-rtl', FRMASTER_URL . '/fundraisemaster-rtl.css', null, '1.0.0');
			}
			wp_enqueue_style('frmaster-custom-style', frmaster_get_style_custom());
			
			wp_enqueue_script('frmaster-script', FRMASTER_URL . '/fundraisemaster.js', array('jquery'), false, true);
		}
	}

	// add body class
	add_filter('body_class', 'frmaster_body_class');
	if( !function_exists('frmaster_body_class') ){
		function frmaster_body_class( $classes ){
			$classes[] = 'frmaster-body';

			return $classes;
		}
	}