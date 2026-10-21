<?php
add_action( 'wp_enqueue_scripts', 'charitio_enqueue_styles' );
function charitio_enqueue_styles() {
  $parent_style = 'charitio-style';
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/styles.css', array('themify-icons', 'flaticon', 'bootstrap', 'animate','owl-carousel','owl-theme', 'slick', 'slick-theme','owl-transitions','fancybox','fancybox') );
  wp_enqueue_style( 'charitio-child',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
    );
}
if( ! function_exists( 'charitio_child_theme_language_setup' ) ) {
  function charitio_child_theme_language_setup(){
    load_theme_textdomain( 'charitio-child', get_template_directory() . '/languages' );
  }
  add_action('after_setup_theme', 'charitio_child_theme_language_setup');
}