<?php
/*
 * Charitio Theme's Functions
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */




//requireed files
@include_once get_template_directory()."/svg-sanitizer/helpers.php";
//Sets up theme defaults and registers support for various WordPress features
@include_once get_template_directory()."/helpers/config.php";


/**
 * Define - Folder Paths
 */

define( 'CHARITIO_THEMEROOT_URI', get_template_directory_uri() );
define( 'CHARITIO_CSS', CHARITIO_THEMEROOT_URI . '/assets/css' );
define( 'CHARITIO_IMAGES', CHARITIO_THEMEROOT_URI . '/assets/images' );
define( 'CHARITIO_SCRIPTS', CHARITIO_THEMEROOT_URI . '/assets/js' );
define( 'CHARITIO_FRAMEWORK', get_template_directory() . '/includes' );
define( 'CHARITIO_LAYOUT', get_template_directory() . '/theme-layouts' );
define( 'CHARITIO_CS_IMAGES', CHARITIO_THEMEROOT_URI . '/includes/theme-options/framework-extend/images' );
define( 'CHARITIO_CS_FRAMEWORK', get_template_directory() . '/includes/theme-options/framework-extend' ); // Called in Icons field *.json
define( 'CHARITIO_ADMIN_PATH', get_template_directory() . '/includes/theme-options/cs-framework' ); // Called in Icons field *.json

/**
 * Define - Global Theme Info's
 */
if (is_child_theme()) { // If Child Theme Active
	$charitio_theme_child = wp_get_theme();
	$charitio_get_parent = $charitio_theme_child->Template;
	$charitio_theme = wp_get_theme($charitio_get_parent);
} else { // Parent Theme Active
	$charitio_theme = wp_get_theme();
}
define('CHARITIO_NAME', $charitio_theme->get( 'Name' ));
define('CHARITIO_VERSION', $charitio_theme->get( 'Version' ));
define('CHARITIO_BRAND_URL', $charitio_theme->get( 'AuthorURI' ));
define('CHARITIO_BRAND_NAME', $charitio_theme->get( 'Author' ));

/**
 * All Main Files Include
 */
require_once( CHARITIO_FRAMEWORK . '/init.php' );