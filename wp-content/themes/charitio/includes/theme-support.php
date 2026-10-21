<?php
/*
 * All theme related setups here.
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

/* Set content width */
if ( ! isset( $content_width ) ) $content_width = 1170;

/* Register menu */
register_nav_menus( array(
	'primary' => esc_html__( 'Main Navigation', 'charitio' )
) );

/* Logo */
add_theme_support( 'custom-logo' );

/* Background */
add_theme_support( 'custom-background' );

/* Header */
add_theme_support( 'custom-header' );

/* Thumbnails */
add_theme_support( 'post-thumbnails' );

/* Event Thumbnails */
add_image_size( 'charitio-event-large', 378, 270 );

/* Post formats */
add_theme_support( 'post-formats', array( 'gallery', 'video', 'quote' ) );

/* Feeds */
add_theme_support( 'automatic-feed-links' );

/* Add support for Title Tag. */
add_theme_support( 'title-tag' );

/* HTML5 */
add_theme_support( 'html5', array( 'gallery', 'caption' ) );

/* Breadcrumb Trail Support */
add_theme_support( 'breadcrumb-trail' );

/* WooCommerce Support */
add_theme_support( 'woocommerce' );

add_editor_style();

/* Languages */
if( ! function_exists( 'charitio_theme_language_setup' ) ) {
	function charitio_theme_language_setup(){
	  load_theme_textdomain( 'charitio', get_template_directory() . '/languages' );
	}
	add_action('after_setup_theme', 'charitio_theme_language_setup');
}

/* Slider Revolution Theme Mode */
if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'charitio_theme_revslider' );
	function charitio_theme_revslider() {
		set_revslider_as_theme();
	}
}

/* Visual Composer Theme Mode */
if(function_exists('vc_set_as_theme')) vc_set_as_theme();

add_filter('wp_list_categories', 'charitio_cat_count_span');
function charitio_cat_count_span($links) {
 $links = str_replace('</a> (', '</a> <span>(', $links);
 $links = str_replace(')', ')</span>', $links);
 return $links;
}

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
