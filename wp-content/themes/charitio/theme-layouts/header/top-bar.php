<?php
// Metabox
global $post;
$charitio_id    = ( isset( $post ) ) ? $post->ID : false;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_id    = ( ! is_tag() && ! is_archive() && ! is_search() && ! is_404() && ! is_singular('testimonial') ) ? $charitio_id : false;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
  if ($charitio_meta) {
    $charitio_topbar_options = $charitio_meta['topbar_options'];
  } else {
    $charitio_topbar_options = '';
  }

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

// Define Theme Options and Metabox varials in right way!
if ($charitio_meta) {
  if ($charitio_topbar_options === 'custom' && $charitio_topbar_options !== 'default') {
    $charitio_top_left          = $charitio_meta['top_left'];
    $charitio_top_right          = $charitio_meta['top_right'];
    $charitio_hide_topbar        = $charitio_topbar_options;
    $charitio_topbar_bg          = $charitio_meta['topbar_bg'];
    if ($charitio_topbar_bg) {
      $charitio_topbar_bg = 'background-color: '. $charitio_topbar_bg .';';
    } else {$charitio_topbar_bg = '';}
  } else {
    $charitio_top_left          = cs_get_option('top_left');
    $charitio_top_right          = cs_get_option('top_right');
    $charitio_hide_topbar        = cs_get_option('top_bar');
    $charitio_topbar_bg          = '';
  }
} else {
  // Theme Options fields
  $charitio_top_left         = cs_get_option('top_left');
  $charitio_top_right          = cs_get_option('top_right');
  $charitio_hide_topbar        = cs_get_option('top_bar');
  $charitio_topbar_bg          = '';
}
// All options
if ( $charitio_meta && $charitio_topbar_options === 'custom' && $charitio_topbar_options !== 'default' ) {
  $charitio_top_right = ( $charitio_top_right ) ? $charitio_meta['top_right'] : cs_get_option('top_right');
  $charitio_top_left = ( $charitio_top_left ) ? $charitio_meta['top_left'] : cs_get_option('top_left');
} else {
  $charitio_top_right = cs_get_option('top_right');
  $charitio_top_left = cs_get_option('top_left');
}
if ( $charitio_meta && $charitio_topbar_options !== 'default' ) {
  if ( $charitio_topbar_options === 'hide_topbar' ) {
    $charitio_hide_topbar = 'hide';
  } else {
    $charitio_hide_topbar = 'show';
  }
} else {
  $charitio_hide_topbar_check = cs_get_option( 'top_bar' );
  if ( $charitio_hide_topbar_check === true ) {
     $charitio_hide_topbar = 'hide';
  } else {
     $charitio_hide_topbar = 'show';
  }
}
if ( $charitio_meta ) {
  $charitio_topbar_bg = ( $charitio_topbar_bg ) ? $charitio_meta['topbar_bg'] : '';
} else {
  $charitio_topbar_bg = '';
}
if ( $charitio_topbar_bg ) {
  $charitio_topbar_bg = 'background-color: '. $charitio_topbar_bg .';';
} else { $charitio_topbar_bg = ''; }

if( $charitio_hide_topbar === 'show' && ( $charitio_top_left || $charitio_top_right ) ) {
?>
 <div class="topbar" style="<?php echo esc_attr( $charitio_topbar_bg ); ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-7 col-sm-12 col-12">
               <?php if ( ! empty( $charitio_top_left ) ) { echo do_shortcode( $charitio_top_left ); } ?>
            </div>
            <div class="col col-md-5 col-sm-12 col-12">
                <?php if ( ! empty( $charitio_top_right ) ) { echo do_shortcode( $charitio_top_right ); } ?>
            </div>
        </div>
    </div>
</div> <!-- end topbar -->
<?php } // Hide Topbar - From Metabox