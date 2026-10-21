<?php
	/**
	 * The template for displaying single tour posttype
	 */

include(FRMASTER_LOCAL . '/single/user/user-update.php');

get_header();

	echo '<div class="frmaster-template-wrapper frmaster-template-wrapper-user" >';

	// user navigation
	echo '<div class="frmaster-user-navigation" >';
	include('user/user-navigation.php');

	$navigation_bottom_text = frmaster_get_option('general', 'user-navigation-bottom-text', '');
	if( !empty($navigation_bottom_text) ){
		echo '<div class="frmaster-user-navigation-bottom-text" >';
		echo frmaster_content_filter($navigation_bottom_text);
		echo '</div>';
	}
	echo '</div>';

	// tab content
	echo '<div class="frmaster-user-content" >';
	echo '<div class="frmaster-user-mobile-navigation frmaster-form-field" >';
	include('user/user-mobile-navigation.php');
	echo '</div>';
	
	$page_type = empty($_GET['page_type'])? 'dashboard': $_GET['page_type'];
	if( !empty($_GET['sub_page']) ){
		$page_type .= '-' . $_GET['sub_page'];
	}

	$template = FRMASTER_LOCAL . '/single/user/' . $page_type . '.php';
	$template = apply_filters('frmaster_user_content_template', $template, $page_type);
	if( file_exists($template) ){
		include($template);
	}else{
		frmaster_user_content_block_start();
		echo esc_html__('Sorry, we couldn\'t find the page you\'re looking for.', 'frmaster');
		frmaster_user_content_block_end();
	}
	echo '</div>';

	echo '</div>'; // tourmaster-template-wrapper

get_footer(); 

?>