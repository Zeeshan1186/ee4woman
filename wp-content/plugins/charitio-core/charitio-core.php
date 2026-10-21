<?php
/*
Plugin Name: Charitio Core
Plugin URI: http://themeforest.net/user/wpoceans
Description: Plugin to contain shortcodes and custom post types of the charitio theme.
Author: wpoceans
Author URI: http://themeforest.net/user/wpoceans/portfolio
Version: 1.0.1
Text Domain: charitio-core
*/

if( ! function_exists( 'charitio_block_direct_access' ) ) {
	function charitio_block_direct_access() {
		if( ! defined( 'ABSPATH' ) ) {
			exit( 'Forbidden' );
		}
	}
}

// Plugin URL
define( 'CHARITIO_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

// Plugin PATH
define( 'CHARITIO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CHARITIO_PLUGIN_ASTS', CHARITIO_PLUGIN_URL . 'assets' );
define( 'CHARITIO_PLUGIN_IMGS', CHARITIO_PLUGIN_ASTS . '/images' );
define( 'CHARITIO_PLUGIN_INC', CHARITIO_PLUGIN_PATH . 'include' );

// DIRECTORY SEPARATOR
define ( 'DS' , DIRECTORY_SEPARATOR );

// Charitio Elementor Shortcode Path
define( 'CHARITIO_EM_SHORTCODE_BASE_PATH', CHARITIO_PLUGIN_PATH . 'elementor/' );
define( 'CHARITIO_EM_SHORTCODE_PATH', CHARITIO_EM_SHORTCODE_BASE_PATH . 'widgets/' );

/**
 * Check if Codestar Framework is Active or Not!
 */
function charitio_framework_active() {
  return ( defined( 'CS_VERSION' ) ) ? true : false;
}

/* CHARITIO_THEME_NAME_PLUGIN */
define('CHARITIO_THEME_NAME_PLUGIN', 'Charitio' );

// Initial File
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('charitio-core/charitio-core.php')) {

	// Custom Post Type
  require_once( CHARITIO_PLUGIN_INC . '/custom-post-type.php' );

  if ( is_plugin_active('kingcomposer/kingcomposer.php') ) {

    define( 'CHARITIO_KC_SHORTCODE_BASE_PATH', CHARITIO_PLUGIN_PATH . 'kc/' );
    define( 'CHARITIO_KC_SHORTCODE_PATH', CHARITIO_KC_SHORTCODE_BASE_PATH . 'shortcodes/' );
    // Shortcodes
    require_once( CHARITIO_KC_SHORTCODE_BASE_PATH . '/kc-setup.php' );
    require_once( CHARITIO_KC_SHORTCODE_BASE_PATH . '/library.php' );
  }

  // Theme Custom Shortcode
  require_once( CHARITIO_PLUGIN_INC . '/custom-shortcodes/theme-shortcodes.php' );
  require_once( CHARITIO_PLUGIN_INC . '/custom-shortcodes/custom-shortcodes.php' );

  // Importer
  require_once( CHARITIO_PLUGIN_INC . '/demo/importer.php' );


  if (class_exists('WP_Widget') && is_plugin_active('codestar-framework/cs-framework.php') ) {
    // Widgets

    require_once( CHARITIO_PLUGIN_INC . '/widgets/nav-widget.php' );
    require_once( CHARITIO_PLUGIN_INC . '/widgets/recent-posts.php' );
    require_once( CHARITIO_PLUGIN_INC . '/widgets/causes-posts.php' );
    require_once( CHARITIO_PLUGIN_INC . '/widgets/text-widget.php' );
    require_once( CHARITIO_PLUGIN_INC . '/widgets/widget-extra-fields.php' );

    // Elementor
    if(file_exists( CHARITIO_EM_SHORTCODE_BASE_PATH . '/em-setup.php' ) ){
      require_once( CHARITIO_EM_SHORTCODE_BASE_PATH . '/em-setup.php' );
      require_once( CHARITIO_EM_SHORTCODE_BASE_PATH . 'lib/fields/icons.php' );
      require_once( CHARITIO_EM_SHORTCODE_BASE_PATH . 'lib/icons-manager/icons-manager.php' );
    }
  }

  add_action('wp_enqueue_scripts', 'charitio_plugin_enqueue_scripts');
  function charitio_plugin_enqueue_scripts() {
    wp_enqueue_script('plugin-scripts', CHARITIO_PLUGIN_ASTS.'/plugin-scripts.js', array('jquery'), '', true);
  }

}

// Extra functions
require_once( CHARITIO_PLUGIN_INC . '/theme-functions.php' );