<?php
// Metabox
global $post;
$charitio_id    = ( isset( $post ) ) ? $post->ID : false;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_id    = ( ! is_tag() && ! is_archive() && ! is_search() && ! is_404() && ! is_singular('service') ) ? $charitio_id : false;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
// Header Style
if ( $charitio_meta ) {
  $charitio_header_design  = $charitio_meta['select_header_design'];
} else {
  $charitio_header_design  = cs_get_option( 'select_header_design' );
}

if ( $charitio_header_design === 'default' ) {
  $charitio_header_design_actual  = cs_get_option( 'select_header_design' );
} else {
  $charitio_header_design_actual = ( $charitio_header_design ) ? $charitio_header_design : cs_get_option('select_header_design');
}
$charitio_header_design_actual = $charitio_header_design_actual ? $charitio_header_design_actual : 'style_one';

$charitio_logo = cs_get_option( 'charitio_logo' );
$charitio_trlogo = cs_get_option( 'charitio_trlogo' );

$logo_url = wp_get_attachment_url( $charitio_logo );
$logo_alt = get_post_meta( $charitio_logo, '_wp_attachment_image_alt', true );

$trlogo_url = wp_get_attachment_url( $charitio_trlogo );
$trlogo_alt = get_post_meta( $charitio_trlogo, '_wp_attachment_image_alt', true );

if ( $logo_url ) {
  $logo_url = $logo_url;
} else {
 $logo_url = CHARITIO_IMAGES.'/logo.svg';
}

if ( $trlogo_url ) {
  $trlogo_url = $trlogo_url;
} else {
 $trlogo_url = CHARITIO_IMAGES.'/tr-logo.svg';
}


if ( $charitio_header_design_actual == 'style_three' ) {
  $charitio_logo_url = $trlogo_url;
  $charitio_logo_alt = $trlogo_alt;
} else {
  $charitio_logo_url = $logo_url;
  $charitio_logo_alt = $logo_alt;
}

if ( has_nav_menu( 'primary' ) ) {
  $logo_padding = ' has_menu ';
}
else {
   $logo_padding = ' dont_has_menu ';
}


// Logo Spacings
$charitio_brand_logo_top = cs_get_option( 'charitio_logo_top' );
$charitio_brand_logo_bottom = cs_get_option( 'charitio_logo_bottom' );
if ( $charitio_brand_logo_top ) {
  $charitio_brand_logo_top = 'padding-top:'. charitio_check_px( $charitio_brand_logo_top ) .';';
} else { $charitio_brand_logo_top = ''; }
if ( $charitio_brand_logo_bottom ) {
  $charitio_brand_logo_bottom = 'padding-bottom:'. charitio_check_px( $charitio_brand_logo_bottom ) .';';
} else { $charitio_brand_logo_bottom = ''; }
?>
<div class="site-logo <?php echo esc_attr( $logo_padding ); ?>"  style="<?php echo esc_attr( $charitio_brand_logo_top ); echo esc_attr( $charitio_brand_logo_bottom ); ?>">
   <?php if ( $charitio_logo ) {
    ?>
      <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
       <img src="<?php echo esc_url( $charitio_logo_url ); ?>" alt=" <?php echo esc_attr( $charitio_logo_alt ); ?>">
     </a>
   <?php } elseif( has_custom_logo() ) {
      the_custom_logo();
    } else {
    ?>
    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
       <img src="<?php echo esc_url( $charitio_logo_url ); ?>" alt="<?php echo get_bloginfo('name'); ?>">
     </a>
   <?php
  } ?>
</div>