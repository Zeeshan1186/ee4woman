<?php
/*
 * The header for our theme.
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */
?><!DOCTYPE html>
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F7445PW19X ">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F7445PW19X ');
</script>
	
	
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php
$charitio_viewport = cs_get_option( 'theme_responsive' );
if( !$charitio_viewport ) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php } $charitio_all_element_color  = cs_get_customize_option( 'all_element_colors' ); ?>
<meta name="msapplication-TileColor" content="<?php echo esc_attr( $charitio_all_element_color ); ?>">
<meta name="theme-color" content="<?php echo esc_attr( $charitio_all_element_color ); ?>">
<link rel="profile" href="//gmpg.org/xfn/11">
		
<?php
// Metabox
global $post;
$charitio_id    = ( isset( $post ) ) ? $post->ID : false;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_id    = ( ! is_tag() && ! is_archive() && ! is_search() && ! is_404() && ! is_singular('testimonial') ) ? $charitio_id : false;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
// Theme Layout Width
$charitio_layout_width  = cs_get_option( 'theme_layout_width' );
$theme_preloder  = cs_get_option( 'theme_preloder' );
$charitio_layout_width_class = ( $charitio_layout_width === 'container' ) ? 'layout-boxed' : 'layout-full';
// Header Style
if ( $charitio_meta ) {
  $charitio_header_design  = $charitio_meta['select_header_design'];
  $charitio_sticky_header = isset( $charitio_meta['sticky_header'] ) ? $charitio_meta['sticky_header'] : '' ;
} else {
  $charitio_header_design  = cs_get_option( 'select_header_design' );
  $charitio_sticky_header  = cs_get_option( 'sticky_header' );
}

if ( $charitio_header_design === 'default' ) {
  $charitio_header_design_actual  = cs_get_option( 'select_header_design' );
} else {
  $charitio_header_design_actual = ( $charitio_header_design ) ? $charitio_header_design : cs_get_option('select_header_design');
}

$charitio_header_design_actual = $charitio_header_design_actual ? $charitio_header_design_actual : 'style_one';

if ( $charitio_header_design_actual == 'style_three' ) {
  $header_class = 'wpo-header-style-3';
} elseif ( $charitio_header_design_actual == 'style_two' ) {
  $header_class = 'wpo-header-style-2';
}  else {
  $header_class = 'wpo-header-style-1';
}

if ( has_nav_menu( 'primary' ) ) {
   $has_menu = ' has-menu ';
} else {
   $has_menu = ' dont-has-menu ';
}

if ( $charitio_sticky_header ) {
  $charitio_sticky_header = $charitio_sticky_header ? ' sticky-menu-on ' : '';
} else {
  $charitio_sticky_header = '';
}
// Header Transparent
if ( $charitio_meta ) {
  $charitio_transparent_header = $charitio_meta['transparency_header'];
  $charitio_transparent_header = $charitio_transparent_header ? ' header-transparent' : ' dont-transparent';
  // Shortcode Banner Type
  $charitio_banner_type = ' '. $charitio_meta['banner_type'];
} else { $charitio_transparent_header = ' dont-transparent'; $charitio_banner_type = ''; }
wp_head();
?>
	
</head>
			
<body <?php body_class(); ?>>]
   <?php wp_body_open(); ?>
<div class="page-wrapper <?php echo esc_attr( $charitio_layout_width_class ); ?>">
<!-- #charitio-theme-wrapper -->
<?php if( $theme_preloder ) {
 get_template_part( 'theme-layouts/header/preloder' );
 } ?>
  <header id="header" class="wpo-site-header <?php echo esc_attr( $header_class ); ?>">
      <?php  get_template_part( 'theme-layouts/header/top','bar' ); ?>
    <nav id="site-navigation" class="navigation navbar navbar-expand-lg navbar-light <?php echo esc_attr( $charitio_sticky_header.$has_menu ); ?>">
      <?php get_template_part( 'theme-layouts/header/menu','bar' ); ?>
    </nav>
  </header>
		
  <?php
  // Title Area
  $charitio_need_title_bar = cs_get_option('need_title_bar');
  if ( !$charitio_need_title_bar ) {
    get_template_part( 'theme-layouts/header/title', 'bar' );
  }