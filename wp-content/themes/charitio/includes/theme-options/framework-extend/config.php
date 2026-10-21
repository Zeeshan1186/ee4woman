<?php
/*
 * Codestar Framework Config
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

/**
 * Integrate - Codestar Framework
 */
if (function_exists('cs_framework_init')) {

  require_once( CHARITIO_CS_FRAMEWORK . '/custom-style.php' );
  require_once( CHARITIO_CS_FRAMEWORK . '/theme-options.php' );
  require_once( CHARITIO_CS_FRAMEWORK . '/theme-customizer.php' );
  require_once( CHARITIO_CS_FRAMEWORK . '/theme-metabox.php' );

  /**
   * Codestar Support
   */
  define( 'CS_ACTIVE_FRAMEWORK',  true  );
  define( 'CS_ACTIVE_METABOX',    true );
  define( 'CS_ACTIVE_SHORTCODE',  true );
  define( 'CS_ACTIVE_CUSTOMIZE',  true );

  /**
   * Custom New Font Family
   */
  if( ! function_exists( 'charitio_custom_font_upload' ) ) {
    function charitio_custom_font_upload( $db_value ) {

      $fonts = cs_get_option( 'font_family' );

      if ( ! empty( $fonts ) ) {

        echo '<optgroup label="Your Custom Fonts">';
        foreach ( $fonts as $key => $value ) {
          echo '<option value="'. $value['name'] .'" data-type="customfonts"'. selected( $value['name'], $db_value, true ) .'>'. $value['name'] .'</option>';
        }
        echo '</optgroup>';

      }

    }
    add_action( 'cs_typography_family', 'charitio_custom_font_upload' );
  }

} else {
   function cs_get_option( $option_name = '', $default = '' ) {
    return false;
  }
  function cs_get_customize_option( $option_name = '', $default = '' ) {
    return false;
  }
}
/**
 * Check Custom Font
 */
if ( ! function_exists( 'charitio_custom_upload_font' ) ) {
  function charitio_custom_upload_font( $font ) {

    $fonts  = cs_get_option( 'font_family' );
    $custom = array();

    if( ! empty( $fonts ) ) {
      foreach ( $fonts as $custom_font ) {
        $custom[] = $custom_font['name'];
      }
    }

    return ( ! empty( $font ) && ! empty( $custom ) && in_array( $font, $custom ) ) ? true : false;

  }
}

/**
 * Get Registered Sidebars
 */
if ( ! function_exists( 'charitio_registered_sidebars' ) ) {
  function charitio_registered_sidebars() {

    global $wp_registered_sidebars;
    $widgets = array();

    if( ! empty( $wp_registered_sidebars ) ) {
      foreach ( $wp_registered_sidebars as $key => $value ) {
        $widgets[$key] = $value['name'];
      }
    }

    return array_reverse( $widgets );

  }
}

/**
 * Enqueue Google Fonts
 */
if ( ! function_exists( 'charitio_typography_fonts' ) ) {
  function charitio_typography_fonts() {

    $embed_fonts  = array();
    $query_args   = array();
    $subsets      = cs_get_option( 'subsets' );
    $subsets      = ( ! empty( $subsets ) ) ? '&subset=' . implode( ',', $subsets ) : '';
    $font_weight  = cs_get_option( 'font_weight' );
    $font_weight  = ( ! empty( $font_weight ) ) ? ':' . implode( ',', $font_weight ) : '';
    $typography   = cs_get_option( 'typography' );

    if ( empty( $typography ) ) { return; }

    foreach ( $typography as $font ) {
      if ( ! empty( $font['selector'] ) ) {
        if( $font['font']['family'] ) {
          $family  = $font['font']['family'];
          $variant = ( $font['font']['variant'] != 'regular' ) ? $font['font']['variant'] : 400;
          $embed_fonts[$family]['variant'][$variant] = $variant;
        }
      }
    }

    if ( ! empty( $embed_fonts ) ) {
      foreach ( $embed_fonts as $name => $font ) {
        $query_args[] = $name . $font_weight;
      }
      wp_enqueue_style( 'charitio-typography-fonts', esc_url( add_query_arg( 'family', urlencode( implode( '|', $query_args ) ) . $subsets, '//fonts.googleapis.com/css2' ) ), array(), null );
    }

  }
}

/* Typography */
if ( ! function_exists( 'charitio_get_typography' ) ) {
  function charitio_get_typography() {

    $typography = cs_get_option( 'typography' );
    $output     = '';

    if ( ! empty( $typography ) ) {
      foreach ( $typography as $font ) {
        if ( ! empty( $font['selector'] ) ) {

          $weight  = ( $font['font']['variant'] != 'regular' ) ? charitio_esc_string( $font['font']['variant'] ) : 400;
          $style   = charitio_esc_number( $font['font']['variant'] );
          $style   = ( $style && $style != 'regular' ) ? $style : 'normal';
          $family  = ( $font['font']['family'] ) ? '"'. $font['font']['family'] .'", Arial, sans-serif' : $font['font']['family'];

          $output .= $font['selector'] . '{';
          $output .= 'font-family: '. $family .';';
          $output .= ( ! empty( $font['size'] ) ) ? 'font-size: '. charitio_check_px( $font['size'] ) .';' : '';
          $output .= ( ! empty( $font['line_height'] ) ) ? 'line-height: '. $font['line_height'] .';' : '';
          $output .= 'font-style: '. $style .';';
          // $output .= 'font-weight: '. $weight .';';
          $output .= ( ! empty( $font['css'] ) ) ? $font['css'] : '';
          $output .= '}';

        }
      }
    }

    return $output;

  }
}
