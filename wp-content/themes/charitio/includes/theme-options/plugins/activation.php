<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 */
require_once CHARITIO_FRAMEWORK . '/theme-options/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'charitio_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function charitio_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

    // Charitio Core
    array(
	    'name'					=> esc_html__( 'Charitio Core', 'charitio'),
	    'slug'     			=> 'charitio-core',
	    'source'				=> get_template_directory_uri().'/includes/theme-options/plugins/charitio-core.zip',
	    'required'			=> true,
	    'external_url'	=> 'http://themeforest.net/user/wpoceans/portfolio/',
    ),
    // Elementor
    array(
	    'name'					=> esc_html__( 'Elementor', 'charitio' ),
	    'slug'     			=> 'elementor',
	    'required'			=> true,
	    'external_url'	=> 'https://wordpress.org/plugins/elementor/',
    ),
     // GiveWP – Donation Plugin
    array(
	    'name'					=> esc_html__( 'GiveWP', 'charitio' ),
	    'slug'     			=> 'give',
	    'required'			=> true,
	    'external_url'	=> 'https://wordpress.org/plugins/give/',
    ),
     // Codestar Framework
    array(
	    'name'					=> esc_html__( 'Codestar Framework', 'charitio'),
	    'slug'     			=> 'codestar-framework',
	    'source'				=> get_template_directory_uri().'/includes/theme-options/plugins/codestar-framework.zip',
	    'required'			=> true,
	    'external_url'	=> 'http://themeforest.net/user/wpoceans/portfolio/',
    ),
    // Contact Form 7
    array(
	    'name'					=> esc_html__( 'Contact Form 7', 'charitio' ),
	    'slug'					=> 'contact-form-7',
	    'required'			=> true,
	    'external_url'	=> 'http://wordpress.org/plugins/contact-form-7',
    ),
    // WooCommerce
    array(
	    'name'					=> esc_html__( 'WooCommerce', 'charitio' ),
	    'slug'					=> 'woocommerce',
	    'required'			=> true,
	    'external_url'	=> 'https://wordpress.org/plugins/woocommerce/',
    ),
    // MailChimp for WordPress
    array(
	    'name'					=> esc_html__( 'MailChimp for WordPress', 'charitio' ),
	    'slug'					=> 'mailchimp-for-wp',
	    'required'			=> true,
	    'external_url'	=> 'https://wordpress.org/plugins/mailchimp-for-wp/',
    ),
   array(
	    'name'					=> esc_html__('One Click Demo Import','charitio'),
	    'slug'					=> 'one-click-demo-import',
	    'required'			=> true,
	    'external_url'	=> 'https://wordpress.org/plugins/one-click-demo-import/',
    ),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
