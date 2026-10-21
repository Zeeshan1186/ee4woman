<?php
/*
 * All CSS and JS files are enqueued from this file
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

/**
 * Enqueue Files for FrontEnd
 */
function charitio_google_font_url() {
    $font_url = '';
    if ( 'off' !== esc_html__( 'on', 'charitio' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Roboto Slab:wght@300;400;500;600;700&display=swap' ), "//fonts.googleapis.com/css2" );
    }
    return str_replace( array("%3A","%40", "%3B", "%26", "%3D"), array(":", "@", ";", "&", "="), $font_url );
}

if ( ! function_exists( 'charitio_scripts_styles' ) ) {
  function charitio_scripts_styles() {

    // Styles
    wp_enqueue_style( 'themify-icons', CHARITIO_CSS .'/themify-icons.css', array(), '4.6.3', 'all' );
    wp_enqueue_style( 'flaticon', CHARITIO_CSS .'/flaticon.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'font-awesome', CHARITIO_CSS .'/font-awesome.min.css', array(), '4.6.3', 'all' );
    wp_enqueue_style( 'bootstrap', CHARITIO_CSS .'/bootstrap.min.css', array(), '5.0.1', 'all' );
    wp_enqueue_style( 'animate', CHARITIO_CSS .'/animate.css', array(), '3.5.1', 'all' );
    wp_enqueue_style( 'odometer', CHARITIO_CSS .'/odometer.css', array(), '0.4.8', 'all' );
    wp_enqueue_style( 'owl-carousel', CHARITIO_CSS .'/owl.carousel.css', array(), '2.3.4', 'all' );
    wp_enqueue_style( 'owl-theme', CHARITIO_CSS .'/owl.theme.css', array(), '2.0.0', 'all' );
    wp_enqueue_style( 'slick', CHARITIO_CSS .'/slick.css', array(), '1.6.0', 'all' );
    wp_enqueue_style( 'swiper', CHARITIO_CSS .'/swiper.min.css', array(), '4.0.7', 'all' );
    wp_enqueue_style( 'slick-theme', CHARITIO_CSS .'/slick-theme.css', array(), '1.6.0', 'all' );
    wp_enqueue_style( 'owl-transitions', CHARITIO_CSS .'/owl.transitions.css', array(), '2.0.0', 'all' );
    wp_enqueue_style( 'fancybox', CHARITIO_CSS .'/fancybox.css', array(), '2.0.0', 'all' );
    wp_enqueue_style( 'charitio-style', CHARITIO_CSS .'/styles.css', array(), CHARITIO_VERSION, 'all' );
    wp_enqueue_style( 'element', CHARITIO_CSS .'/elements.css', array(), CHARITIO_VERSION, 'all' );
    if ( !function_exists('cs_framework_init') ) {
      wp_enqueue_style('charitio-default-style', get_template_directory_uri() . '/style.css', array(),  CHARITIO_VERSION, 'all' );
    }
    wp_enqueue_style( 'charitio-default-google-fonts', esc_url( charitio_google_font_url() ), array(), CHARITIO_VERSION, 'all' );
    // Scripts
    wp_enqueue_script( 'bootstrap', CHARITIO_SCRIPTS . '/bootstrap.min.js', array( 'jquery' ), '5.0.1', true );
    wp_enqueue_script( 'imagesloaded');
    wp_enqueue_script( 'isotope', CHARITIO_SCRIPTS . '/isotope.min.js', array( 'jquery' ), '2.2.2', true );
    wp_enqueue_script( 'fancybox', CHARITIO_SCRIPTS . '/fancybox.min.js', array( 'jquery' ), '2.1.5', true );
    wp_enqueue_script( 'instafeed', CHARITIO_SCRIPTS . '/instafeed.min.js', array( 'jquery' ), '2.1.5', true );
    wp_enqueue_script( 'circle-progress', CHARITIO_SCRIPTS . '/circle-progress.min.js', array( 'jquery' ), '2.1.5', true );
    wp_enqueue_script( 'masonry');
    wp_enqueue_script( 'owl-carousel', CHARITIO_SCRIPTS . '/owl-carousel.js', array( 'jquery' ), '2.3.4', true );
    wp_enqueue_script( 'jquery-easing', CHARITIO_SCRIPTS . '/jquery-easing.js', array( 'jquery' ), '1.4.0', true );
    wp_enqueue_script( 'wow', CHARITIO_SCRIPTS . '/wow.min.js', array( 'jquery' ), '1.4.0', true );
    wp_enqueue_script( 'odometer', CHARITIO_SCRIPTS . '/odometer.min.js', array( 'jquery' ), '0.4.8', true );
    wp_enqueue_script( 'magnific-popup', CHARITIO_SCRIPTS . '/magnific-popup.js', array( 'jquery' ), '1.1.0', true );
    wp_enqueue_script( 'slick-slider', CHARITIO_SCRIPTS . '/slick-slider.js', array( 'jquery' ), '1.6.0', true );
    wp_enqueue_script( 'swiper', CHARITIO_SCRIPTS . '/swiper.min.js', array( 'jquery' ), '4.0.7', true );
    wp_enqueue_script( 'wc-quantity-increment', CHARITIO_SCRIPTS . '/wc-quantity-increment.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'charitio-scripts', CHARITIO_SCRIPTS . '/scripts.js', array( 'jquery' ), CHARITIO_VERSION, true );
    // Comments
    wp_enqueue_script( 'charitio-inline-validate', CHARITIO_SCRIPTS . '/jquery.validate.min.js', array( 'jquery' ), '1.9.0', true );
    wp_add_inline_script( 'charitio-validate', 'jQuery(document).ready(function($) {$("#commentform").validate({rules: {author: {required: true,minlength: 2},email: {required: true,email: true},comment: {required: true,minlength: 10}}});});' );

    // Responsive Active
    $charitio_viewport = cs_get_option('theme_responsive');
    if( !$charitio_viewport ) {
      wp_enqueue_style( 'charitio-responsive', CHARITIO_CSS .'/responsive.css', array(), CHARITIO_VERSION, 'all' );
    }

    // Adds support for pages with threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }

  }
  add_action( 'wp_enqueue_scripts', 'charitio_scripts_styles' );
}

/**
 * Enqueue Files for BackEnd
 */
if ( ! function_exists( 'charitio_admin_scripts_styles' ) ) {
  function charitio_admin_scripts_styles() {

    wp_enqueue_style( 'charitio-admin-main', CHARITIO_CSS . '/admin-styles.css', true );
    wp_enqueue_style( 'flaticon', CHARITIO_CSS . '/flaticon.css', true );
    wp_enqueue_style( 'themify-icons', CHARITIO_CSS . '/themify-icons.css', true );
    wp_enqueue_script( 'charitio-admin-scripts', CHARITIO_SCRIPTS . '/admin-scripts.js', true );

  }
  add_action( 'admin_enqueue_scripts', 'charitio_admin_scripts_styles' );
}
