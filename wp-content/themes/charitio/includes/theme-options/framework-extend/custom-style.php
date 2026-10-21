<?php
/*
 * Codestar Framework - Custom Style
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

/* All Dynamic CSS Styles */
if ( ! function_exists( 'charitio_dynamic_styles' ) ) {
  function charitio_dynamic_styles() {

    // Typography
    $charitio_get_typography  = charitio_get_typography();

    $all_element_color  = cs_get_customize_option( 'all_element_colors' );
    $all_element_hover_colors  = cs_get_customize_option( 'all_element_hover_colors' );

    // Logo
    $charitio_logo_top     = cs_get_option( 'charitio_logo_top' );
    $charitio_logo_bottom  = cs_get_option( 'charitio_logo_bottom' );

    // Layout
    $bg_type = cs_get_option('theme_layout_bg_type');
    $bg_pattern = cs_get_option('theme_layout_bg_pattern');
    $bg_image = cs_get_option('theme_layout_bg');

    // Footer
    $footer_bg_color  = cs_get_customize_option( 'footer_bg_color' );
    $footer_heading_color  = cs_get_customize_option( 'footer_heading_color' );
    $footer_text_color  = cs_get_customize_option( 'footer_text_color' );
    $footer_link_color  = cs_get_customize_option( 'footer_link_color' );
    $footer_link_hover_color  = cs_get_customize_option( 'footer_link_hover_color' );

  ob_start();

global $post;
$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );

/* Layout - Theme Options - Background */
if ( $bg_type === 'bg-image' ) {

  $layout_boxed = ( ! empty( $bg_image['image'] ) ) ? 'background-image: url('. esc_url( $bg_image['image'] ) .');' : '';
  $layout_boxed .= ( ! empty( $bg_image['repeat'] ) ) ? 'background-repeat: '. esc_attr( $bg_image['repeat'] ) .';' : '';
  $layout_boxed .= ( ! empty( $bg_image['position'] ) ) ? 'background-position: '. esc_attr( $bg_image['position'] ) .';' : '';
  $layout_boxed .= ( ! empty( $bg_image['attachment'] ) ) ? 'background-attachment: '. esc_attr( $bg_image['attachment'] ) .';' : '';
  $layout_boxed .= ( ! empty( $bg_image['size'] ) ) ? 'background-size: '. esc_attr( $bg_image['size'] ) .';' : '';
  $layout_boxed .= ( ! empty( $bg_image['color'] ) ) ? 'background-color: '. esc_attr( $bg_image['color']  ).';' : '';
?>
  .layout-boxed {
    <?php echo wp_kses_data(  $layout_boxed ); ?>
  }
<?php
}
if ($bg_type === 'bg-pattern') {
$custom_bg_pattern = cs_get_option('custom_bg_pattern');
$layout_boxed = ( $bg_pattern === 'custom-pattern' ) ? 'background-image: url('. esc_url($custom_bg_pattern) .');' : 'background-image: url('. esc_url(CHARITIO_IMAGES) . '/patterns/'. $bg_pattern .'.png);';
?>
  .layout-boxed {
    <?php echo   wp_kses_data( $layout_boxed ); ?>
  }
<?php
}

/* Top Bar - Customizer - Background */
$topbar_bg_color  = cs_get_customize_option( 'topbar_bg_color' );
if ($topbar_bg_color) {?>
  .header-style-1 .topbar,
  .header-style-2 .topbar,
  .header-style-3 .topbar {
    background-color: <?php echo esc_attr( $topbar_bg_color ); ?>;
  }
<?php
}

$topbar_text_color  = cs_get_customize_option( 'topbar_text_color' );
if ($topbar_text_color) {?>
  .wpo-site-header .topbar ul li,
  .wpo-site-header .topbar ul li a,
  .wpo-site-header .topbar p {
    color: <?php echo esc_attr($topbar_text_color); ?>
  }
<?php
}
$topbar_icon_color  = cs_get_customize_option( 'topbar_icon_color' );
if ( $topbar_icon_color ) { ?>
 .wpo-site-header .topbar .contact-intro ul li i:before ,
 .wpo-site-header .topbar .social ul li a i:before {
    color: <?php echo  esc_attr($topbar_icon_color); ?>;
  }
<?php
}

/* Header - Customizer */
$menu_bg_color  = cs_get_customize_option( 'menu_bg_color' );
if ( $menu_bg_color ) {?>
  .header-style-1 .navigation-holder,
  .wpo-site-header .navigation {
    background-color: <?php echo  esc_attr( $menu_bg_color ); ?>;
  }
<?php
}
$menu_link_color  = cs_get_customize_option( 'menu_link_color' );
$menu_link_hover_color  = cs_get_customize_option( 'menu_link_hover_color' );
if($menu_link_color ) {?>
.header-style-1 #navbar > ul > li a,
.header-style-2 #navbar > ul > li a,
.header-style-3 #navbar > ul > li a {
    color: <?php echo  esc_attr( $menu_link_color ); ?>;
  }
  <?php
}
  if ($menu_link_hover_color) {
?>
  .wpo-site-header #navbar > ul li a:hover,
  .wpo-site-header #navbar > ul li a:focus {
    color: <?php echo  esc_attr( $menu_link_hover_color ); ?> ;
  }

  .wpo-site-header #navbar>ul>li.current-menu-item>a:before,
  .wpo-site-header #navbar>ul>li>a:before {
    background-color: <?php echo  esc_attr( $menu_link_hover_color ); ?> ;
  }
<?php
}
// Metabox - Header Transparent
if ($charitio_meta) {
  $transparent_header = $charitio_meta['transparency_header'];
  $transparent_menu_color = $charitio_meta['transparent_menu_color'];
  $transparent_menu_hover = $charitio_meta['transparent_menu_hover_color'];
} else {
  $transparent_header = '';
  $transparent_menu_color = '';
  $transparent_menu_hover = '';
}
if ($transparent_header) {?>

  .header-two .navigation .navbar-nav > li > a,
  .navigation .navbar-nav > li > a,
  .header-two #search-trigger-two i,
  .header-two #cart-trigger i{
    color: <?php echo  esc_attr( $transparent_menu_color ); ?>;
  }

  .header-two .navigation .navbar-nav > li > a:hover,
  .navigation .navbar-nav > li > a:hover,
  .navigation .navbar-nav > li.current_page_item > a,
  .navigation .navbar-nav > li.current-menu-parent > a{
    color: <?php echo  esc_attr( $transparent_menu_hover ); ?>;
  }
<?php
}

$submenu_bg_color  = cs_get_customize_option( 'submenu_bg_color' );
$submenu_bg_hover_color  = cs_get_customize_option( 'submenu_bg_hover_color' );
$submenu_link_color  = cs_get_customize_option( 'submenu_link_color' );
$submenu_link_hover_color  = cs_get_customize_option( 'submenu_link_hover_color' );
if ( $submenu_bg_color || $submenu_bg_hover_color ||  $submenu_link_color || $submenu_link_hover_color ) {?>
  .wpo-site-header #navbar > ul > li .sub-menu a {
    color: <?php echo  esc_attr( $submenu_link_color ); ?>;
  }
  .wpo-site-header #navbar>ul>li .sub-menu a:hover {
    color: <?php echo  esc_attr( $submenu_link_hover_color ); ?>;
  }
  .wpo-site-header #navbar > ul .sub-menu {
    background-color: <?php echo  esc_attr( $submenu_bg_color ); ?>;
  }
  .wpo-site-header #navbar > ul .sub-menu:hover {
    background-color: <?php echo  esc_attr( $submenu_bg_hover_color ); ?>;
  }
<?php
}

/* Header Menu Button- Customizer */
$menu_button_color  = cs_get_customize_option( 'menu_button_color' );
$menu_button_bg_color  = cs_get_customize_option( 'menu_button_bg_color' );
if ( $menu_button_color || $menu_button_bg_color ) {?>
  .wpo-site-header .header-search-form-wrapper .theme-btn {
    color: <?php echo  esc_attr( $menu_button_color ); ?>;
  }
  .wpo-site-header .header-search-form-wrapper .theme-btn {
    background: linear-gradient(to left, <?php echo  esc_attr( $menu_button_bg_color ); ?>, <?php echo  esc_attr( $menu_button_bg_color ); ?>);
  }
<?php
} 

/* Header - Responsive Customizer */
$menu_responsive_menu_bg_color  = cs_get_customize_option( 'menu_responsive_menu_bg_color' );
$menu_responsive_menu_color  = cs_get_customize_option( 'menu_responsive_menu_color' );
if ( $menu_responsive_menu_color || $menu_responsive_menu_bg_color ) {?>
  @media (max-width: 991px) {
    .wpo-site-header #navbar {
      background: <?php echo  esc_attr( $menu_responsive_menu_bg_color ); ?>;
    }
    .wpo-site-header #navbar>ul>li>a {
       color: <?php echo  esc_attr( $menu_responsive_menu_color ); ?>;
    }
  }
  
<?php
} 

/* Title Area - Theme Options - Background */
$title_heading_color  = cs_get_customize_option( 'titlebar_title_color' );
if ($title_heading_color) {?>
  .wpo-page-title-section .wpo-page-title-wrapper h2 {
    color: <?php echo  esc_attr( $title_heading_color ); ?>;
  }
<?php
}

/* Title Area - Theme Options - Background */
$titlebar_bg_color  = cs_get_customize_option( 'titlebar_bg_color' );
if ( $titlebar_bg_color ) {?>
  .wpo-page-title-section:before {
    background: <?php echo  esc_attr( $titlebar_bg_color ); ?>;
  }
<?php
}

// Breadcrubms
$breadcrumbs_text_color  = cs_get_customize_option( 'breadcrumbs_text_color' );
$breadcrumbs_link_color  = cs_get_customize_option( 'breadcrumbs_link_color' );
$breadcrumbs_link_hover_color  = cs_get_customize_option( 'breadcrumbs_link_hover_color' );
if ($breadcrumbs_text_color) {?>

  .wpo-page-title-section .breadcrumb li {
    color: <?php echo  esc_attr( $breadcrumbs_text_color ); ?>;
  }
<?php
}
if ($breadcrumbs_link_color) { ?>

  .page-title .breadcrumb li a {
    color: <?php echo  esc_attr( $breadcrumbs_link_color ); ?>;
  }
<?php
}
if ($breadcrumbs_link_hover_color) {?>

  .page-title .breadcrumb li a:hover {
    color: <?php echo  esc_attr( $breadcrumbs_link_hover_color ); ?>;
  }
<?php
}

/* Footer */
if ( $footer_bg_color ) {?>
  .wpo-site-footer ,
  .wpo-site-footer:before {background: <?php echo  esc_attr( $footer_bg_color ); ?>;}
<?php
}
if ( $footer_heading_color ) {?>
  .wpo-site-footer .widget-title h3,
  .wpo-site-footer .contact-widget .newsletter h4,
  .wpo-upper-footer .widget.recent-post-widget .widget-title {color: <?php echo  esc_attr( $footer_heading_color ); ?>;}
<?php
}
if ( $footer_text_color ) {?>
  .wpo-site-footer .about-widget p,
  .wpo-site-footer .address-widget p,
  .wpo-site-footer .contact-widget ul li {color: <?php echo  esc_attr( $footer_text_color ); ?>;}
<?php
}
if ( $footer_link_color ) {?>
  footer a,
  .wpo-site-footer .contact-widget ul li,
  .wpo-site-footer .widget a,
  .wpo-site-footer ul li a,
  .wpo-site-footer .contact-ft ul li,
  .wpo-site-footer .link-widget ul li a,
  .wpo-site-footer .contact-widget li span,
  .wpo-site-footer .link-widget ul a,
  .wpo-site-footer .social-icons ul li a,
  .wpo-site-footer .recent-post-widget .post h4 a {color: <?php echo  esc_attr( $footer_link_color ); ?>;}
<?php
}
if ( $footer_link_hover_color ) {?>

  footer a:hover,
  footer a:hover,
  .wpo-site-footer .link-widget ul a:hover,
  .wpo-site-footer .widget a:hover,
  .wpo-site-footer .link-widget ul a:hover,
  .wpo-site-footer .recent-post-widget .post h4 a:hover {color: <?php echo  esc_attr( $footer_link_hover_color ); ?>;}
<?php
}

/* Copyright */
$copyright_text_color  = cs_get_customize_option( 'copyright_text_color' );
$copyright_link_color  = cs_get_customize_option( 'copyright_link_color' );
$copyright_link_hover_color  = cs_get_customize_option( 'copyright_link_hover_color' );
$copyright_bg_color  = cs_get_customize_option( 'copyright_bg_color' );
$copyright_border_color  = cs_get_customize_option( 'copyright_border_color' );
if ( $copyright_bg_color  ) { ?>
  .wpo-site-footer .wpo-lower-footer {
    background: <?php echo  esc_attr( $copyright_bg_color ); ?>;
  }
<?php
}
if ( $copyright_border_color ) {?>
  .wpo-site-footer .wpo-lower-footer {border-top: <?php echo  esc_attr( $copyright_border_color ); ?> 1px solid ;}
<?php
}
if ( $copyright_text_color ) {?>
  .page-wrapper .wpo-site-footer .wpo-lower-footer p {color: <?php echo  esc_attr( $copyright_text_color ); ?>;}
<?php
}
if ( $copyright_link_color ) {?>
  .wpo-site-footer .wpo-lower-footer p a {color: <?php echo  esc_attr( $copyright_link_color ); ?>;}
<?php
}
if ( $copyright_link_hover_color ) {?>
  .wpo-site-footer .wpo-lower-footer p a:hover {color: <?php echo  esc_attr( $copyright_link_hover_color ); ?>;}
<?php
}

/* Primary Colors */
if ( $all_element_color ) {?>
  .theme-btn,
  .theme-btn-s2,
  .theme-btn-s3,
  .theme-btn-s4,
  .header-style-1 .menu-open-btn-holder,
  .cart-search-contact .mini-cart .cart-count,
  .about-section .img-holder:before,
  .about-section .theme-btn-s2,
  .cta-section .info-box,
  .recent-blog-section .blog-grids .date,
  .header-style-1 .cart-search-contact .mini-cart .cart-count,
  .back-to-top,
  .wpo-blog-pg-section .post-slider .owl-controls .owl-nav [class*=owl-],
  .blog-single-section .entry-details blockquote,
  .blog-single-section .comment-respond .form-submit input,
  .woocommerce div.product form.cart .button,
  .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
  .woocommerce #review_form #respond .form-submit input,
  .blog-sidebar .widget > h3:before,
  .blog-single-section .comments-area .comment-reply-link,
  .header-style-1 .close-navbar-2,
  .wpo-site-header .navbar-header button,
  .cta-fullwidth {background-color: <?php echo  esc_attr( $all_element_color ); ?>;}

  .section-title > span,
  .section-title-s2 > span,
  .services-section .grid .fi:before,
  .services-section-s2 .grid .fi:before,
  .services-section-s3 .grid .fi:before,
  .about-section .title-text h2:first-letter,
  .about-section .title-text p,
  .contact-section .contact-content h2:first-letter,
  .contact-section-s2 .contact-content h2:first-letter,
  .contact-section .contact-content p,
  .case-studies-section .recent-cases-content-outer .date h5,
  .cta-section p,
  .social-newsletter-section .newsletter button i,
  .wpo-site-footer .contact-widget li span,
  .newsletter-section .newsletter button i,
  .woocommerce ul.products li.product .price,
  .woocommerce .woocommerce-product-search button,
  .wpo-blog-pg-section .entry-details .read-more,
  .blog-sidebar .search-widget button,
  .wpo-blog-pg-section .format-quote h3:after,
  .wpo-blog-pg-section .video-post .video-holder .fi:before,
  .comments-area p.logged-in-as a,
  .product_meta .posted_in a,
  .product_meta .tagged_as a,
  .woocommerce.single-product .woocommerce-Price-amount,
  .woocommerce p.stars a::before,
  .wpo-site-header .topbar ul li i:before,
  .blog-sidebar .widget > h3:before,
  .blog-sidebar .popular-post-widget .date,
  .header-style-1 .close-navbar-2 i:before,
  .header-style-1 .menu-open-btn-holder button span,
  .primary-color {color: <?php echo  esc_attr( $all_element_color ); ?>;}

  .case-studies-section .recent-cases-content-outer,
  .wp-pagenavi span.current,
  .wp-pagenavi a:hover,
  .wp-link-pages span:hover,
  .blog-sidebar .search-widget input,
  .services-section .owl-controls .owl-nav .owl-prev,
  .services-section .owl-controls .owl-nav .owl-next,
  .header-style-1 .cart-search-contact .mini-cart-content,
  .back-to-top,
  .wp-link-pages > span {border-color: <?php echo  esc_attr( $all_element_color ); ?>;}

  .panel-one .panel-default > .panel-heading.accordion-active a:after,
  .woocommerce .woocommerce-message {border-top-color: <?php echo  esc_attr( $all_element_color ); ?>;}
<?php
}


if ( $all_element_hover_colors ) {?>
 .theme-btn:hover,
 .theme-btn-s2:hover,
 .theme-btn-s3:hover,
 .theme-btn-s4:hover,
 .back-to-top:hover,
 .blog-single-section .comments-area .comment-reply-link:hover,
 .blog-single-section .comment-respond .form-submit input.submit:hover
 .woocommerce div.product form.cart .button:hover,
  {background-color: <?php echo  esc_attr( $all_element_hover_colors ); ?>;}
<?php
}
// Content Colors
$body_color  = cs_get_customize_option( 'body_color' );
if ( $body_color ) {?>
  .page-wrapper p,
  .wpo-blog-pg-section .entry-details p,
  .blog-single-section .entry-details p,
   body p {color: <?php echo  esc_attr( $body_color ); ?>;}
<?php
}
$body_links_color  = cs_get_customize_option( 'body_links_color' );
if ( $body_links_color ) {?>
   body a,
  .page-wraper a,
  .blog-single-section .post .meta a,
  .blog-single-section .tag-share .share a,
  .blog-single-section .tag-share .tag a,
  .blog-single-section .author-box .social-lnk a,
  .widget ul li a { color: <?php echo  esc_attr( $body_links_color ); ?>; }
<?php
}
$body_link_hover_color  = cs_get_customize_option( 'body_link_hover_color' );
if ($body_link_hover_color) {?>
   body a:hover,
  .page-wraper a:hover,
  .blog-single-section .post .meta a:hover,
  .blog-single-section .tag-share .share a:hover,
  .blog-single-section .tag-share .tag a:hover,
  .blog-single-section .author-box .social-lnk a:hover,
  .widget ul li a:hover  {color: <?php echo  esc_attr( $body_link_hover_color ); ?>;}
<?php
}
$sidebar_content_color  = cs_get_customize_option( 'sidebar_content_color' );
if ($sidebar_content_color) {?>
  .widget p,
  .widget_rss .rssSummary,
 .woocommerce .product-categories li a,
 .tagcloud a,
 .blog-sidebar ul li,
 .blog-sidebar ul li a,
 .blog-sidebar .popular-post-widget .post-title,
 .blog-sidebar .widget_archive ul a,
  blog-sidebar {color: <?php echo  esc_attr( $sidebar_content_color ); ?>;}
<?php
}

$sidebar_heading_color  = cs_get_customize_option( 'sidebar_heading_color' );
if ($sidebar_heading_color) { ?>
  .blog-sidebar .widget>h3 {
    color: <?php echo  esc_attr( $sidebar_heading_color ); ?>;
  }
<?php
}


// Heading Color
$content_heading_color  = cs_get_customize_option( 'content_heading_color' );
if ($content_heading_color) {?>
  .page-wrapper h1,
  .page-wrapper h2,
  .page-wrapper h3,
  .page-wrapper h4,
  .page-wrapper h5,
  .page-wrapper h6,
  body h1,
  body h2,
  body h3,
  body h4,
  body h5,
  body h6,
  .wpo-blog-pg-section .post h3 a,
  .wpo-blog-pg-section .post h2,
  .wpo-blog-pg-section .post h3,
  .wpo-blog-pg-section .post h4,
  .wpo-blog-pg-section .post h5,
  .wpo-blog-pg-section .post h6,
  .blog-single-section .post h2.post-title,
  .blog-single-section .post h2,
  .blog-single-section .post h3,
  .blog-single-section .post h4,
  .blog-single-section .post h5,
  .blog-single-section .post h6,
  .blog-single-section .more-posts .previous-post>a>span,
  .blog-single-section .comments-area .comments-meta h4,
  .blog-single-section .more-posts .next-post>a>span
    {color: <?php echo  esc_attr( $content_heading_color ); ?>;}
<?php
}

  echo   wp_kses_data( $charitio_get_typography );
  $output = ob_get_clean();
  return $output;

  }

}

/**
 * Custom Font Family
 */
if ( ! function_exists( 'charitio_custom_font_load' ) ) {
  function charitio_custom_font_load() {

    $font_family       = cs_get_option( 'font_family' );

    ob_start();

    if( ! empty( $font_family ) ) {

      foreach ( $font_family as $font ) {
        echo '@font-face{';

        echo 'font-family: "'. $font['name'] .'";';

        if( empty( $font['css'] ) ) {
          echo 'font-style: normal;';
          echo 'font-weight: normal;';
        } else {
          echo wp_kses( $font['css'], 'post' );
        }

        echo ( ! empty( $font['ttf']  ) ) ? 'src: url('. $font['ttf'] .');' : '';
        echo ( ! empty( $font['eot']  ) ) ? 'src: url('. $font['eot'] .');' : '';
        echo ( ! empty( $font['woff'] ) ) ? 'src: url('. $font['woff'] .');' : '';
        echo ( ! empty( $font['otf']  ) ) ? 'src: url('. $font['otf'] .');' : '';

        echo '}';
      }

    }

    // Typography
    $output = ob_get_clean();
    return $output;
  }
}

/* Custom Styles */
if( ! function_exists( 'charitio_custom_css' ) ) {
  function charitio_custom_css() {
    wp_enqueue_style('charitio-default-style', get_template_directory_uri() . '/style.css');
    $output  = charitio_custom_font_load();
    $output .= charitio_dynamic_styles();

    if( function_exists( 'charitio_compress_css_lines' ) ) {
      $custom_css = charitio_compress_css_lines( $output );
       wp_add_inline_style( 'charitio-default-style', $custom_css );
    }
    charitio_typography_fonts();
  }
  add_action( 'wp_enqueue_scripts', 'charitio_custom_css' );
}

/* Custom JS */
if( ! function_exists( 'charitio_custom_js' ) ) {
  function charitio_custom_js() {
    $output = cs_get_option( 'theme_custom_js' );
    wp_add_inline_script( 'jquery-migrate', $output );
  }
  add_action( 'wp_enqueue_scripts', 'charitio_custom_js' );
}