<?php
$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true);

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

$charitio_search  = cs_get_option( 'charitio_header_search' );

$charitio_menu_cta  = cs_get_option( 'charitio_menu_cta' );
$header_cta_text  = cs_get_option( 'header_cta_text' );
$header_cta_link  = cs_get_option( 'header_cta_link' );

if ( $charitio_header_design_actual == 'style_one' ) {
 $btn_class = 'theme-btn';
} elseif ( $charitio_header_design_actual == 'style_two' ){
 $btn_class = 'theme-btn';
} else {
 $btn_class = 'theme-btn-s2';
}

?>
<div class="col-lg-2 col-md-2 col-2">
  <div class="header-search-form-wrapper header-right">
      <?php if ( $charitio_menu_cta ) { ?>
        <div class="close-form">
          <a class="<?php echo esc_attr( $btn_class ); ?>" href="<?php echo esc_url( $header_cta_link ); ?>">
           <?php echo esc_html( $header_cta_text ) ?>
          </a>
        </div>
      <?php }
      if ( !$charitio_search ) { ?>
      <div class="cart-search-contact">
          <button class="search-toggle-btn"><i class="fi ti-search"></i></button>
          <div class="header-search-form">
              <form method="get" action="<?php echo esc_url( home_url('/') ); ?>" class="form" >
                  <div>
                      <input type="text" name="s" class="form-control" placeholder="<?php echo esc_attr__( 'Search here','charitio' ); ?>">
                      <button type="submit"><i class="fi ti-search"></i></button>
                  </div>
              </form>
          </div>
      </div>
    <?php } ?>
  </div>
</div>
