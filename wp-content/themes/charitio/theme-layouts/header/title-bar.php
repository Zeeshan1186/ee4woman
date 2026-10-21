<?php
	// Metabox
	$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
	$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
	$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
	$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
	if ($charitio_meta && is_page()) {
		$charitio_title_bar_padding = $charitio_meta['title_area_spacings'];
	} else { $charitio_title_bar_padding = ''; }
	// Padding - Theme Options
	if ($charitio_title_bar_padding && $charitio_title_bar_padding !== 'padding-default') {
		$charitio_title_top_spacings = $charitio_meta['title_top_spacings'];
		$charitio_title_bottom_spacings = $charitio_meta['title_bottom_spacings'];
		if ($charitio_title_bar_padding === 'padding-custom') {
			$charitio_title_top_spacings = $charitio_title_top_spacings ? 'padding-top:'. charitio_check_px($charitio_title_top_spacings) .';' : '';
			$charitio_title_bottom_spacings = $charitio_title_bottom_spacings ? 'padding-bottom:'. charitio_check_px($charitio_title_bottom_spacings) .';' : '';
			$charitio_custom_padding = $charitio_title_top_spacings . $charitio_title_bottom_spacings;
		} else {
			$charitio_custom_padding = '';
		}
	} else {
		$charitio_title_bar_padding = cs_get_option('title_bar_padding');
		$charitio_titlebar_top_padding = cs_get_option('titlebar_top_padding');
		$charitio_titlebar_bottom_padding = cs_get_option('titlebar_bottom_padding');
		if ($charitio_title_bar_padding === 'padding-custom') {
			$charitio_titlebar_top_padding = $charitio_titlebar_top_padding ? 'padding-top:'. charitio_check_px($charitio_titlebar_top_padding) .';' : '';
			$charitio_titlebar_bottom_padding = $charitio_titlebar_bottom_padding ? 'padding-bottom:'. charitio_check_px($charitio_titlebar_bottom_padding) .';' : '';
			$charitio_custom_padding = $charitio_titlebar_top_padding . $charitio_titlebar_bottom_padding;
		} else {
			$charitio_custom_padding = '';
		}
	}
	// Banner Type - Meta Box
	if ($charitio_meta && is_page()) {
		$charitio_banner_type = $charitio_meta['banner_type'];
	} else { $charitio_banner_type = ''; }
	// Header Style
	if ($charitio_meta) {
	  $charitio_header_design  = $charitio_meta['select_header_design'];
	  $charitio_hide_breadcrumbs  = $charitio_meta['hide_breadcrumbs'];
	} else {
	  $charitio_header_design  = cs_get_option('select_header_design');
	  $charitio_hide_breadcrumbs = cs_get_option('need_breadcrumbs');
	}
	if ( $charitio_header_design === 'default') {
	  $charitio_header_design_actual  = cs_get_option('select_header_design');
	} else {
	  $charitio_header_design_actual = ( $charitio_header_design ) ? $charitio_header_design : cs_get_option('select_header_design');
	}
	if ( $charitio_header_design_actual == 'style_two') {
		$overly_class = ' overly';
	} else {
		$overly_class = ' ';
	}
	// Overlay Color - Theme Options
		if ($charitio_meta && is_page()) {
			$charitio_bg_overlay_color = $charitio_meta['titlebar_bg_overlay_color'];
			$title_color = isset($charitio_meta['title_color']) ? $charitio_meta['title_color'] : '';
		} else { $charitio_bg_overlay_color = ''; }
		if (!empty($charitio_bg_overlay_color)) {
			$charitio_bg_overlay_color = $charitio_bg_overlay_color;
			$title_color = $title_color;
		} else {
			$charitio_bg_overlay_color = cs_get_option('titlebar_bg_overlay_color');
			$title_color = cs_get_option('title_color');
		}
		$e_uniqid        = uniqid();
		$inline_style  = '';
		if ( $charitio_bg_overlay_color ) {
		 $inline_style .= '.page-title-'.$e_uniqid .'.page-title {';
		 $inline_style .= ( $charitio_bg_overlay_color ) ? 'background-color:'. $charitio_bg_overlay_color.';' : '';
		 $inline_style .= '}';
		}
		if ( $title_color ) {
		 $inline_style .= '.page-title-'.$e_uniqid .'.page-title h2, .page-title-'.$e_uniqid .'.page-title .breadcrumb li, .page-title-'.$e_uniqid .'.page-title .breadcrumbs ul li a {';
		 $inline_style .= ( $title_color ) ? 'color:'. $title_color.';' : '';
		 $inline_style .= '}';
		}
		// add inline style
		charitio_add_inline_style( $inline_style );
		$styled_class  = ' page-title-'.$e_uniqid;
	// Background - Type
	if( $charitio_meta ) {
		$title_bar_bg = $charitio_meta['title_area_bg'];
	} else {
		$title_bar_bg = '';
	}
	$charitio_custom_header = get_custom_header();
	$header_text_color = get_theme_mod( 'header_textcolor' );
	$background_color = get_theme_mod( 'background_color' );
	if( isset( $title_bar_bg['image'] ) && ( $title_bar_bg['image'] ||  $title_bar_bg['color'] ) ) {
	  extract( $title_bar_bg );
	  $charitio_background_image       = ( ! empty( $image ) ) ? 'background-image: url(' . esc_url($image) . ');' : '';
	  $charitio_background_repeat      = ( ! empty( $image ) && ! empty( $repeat ) ) ? ' background-repeat: ' . esc_attr( $repeat) . ';' : '';
	  $charitio_background_position    = ( ! empty( $image ) && ! empty( $position ) ) ? ' background-position: ' . esc_attr($position) . ';' : '';
	  $charitio_background_size    = ( ! empty( $image ) && ! empty( $size ) ) ? ' background-size: ' . esc_attr($size) . ';' : '';
	  $charitio_background_attachment    = ( ! empty( $image ) && ! empty( $size ) ) ? ' background-attachment: ' . esc_attr( $attachment ) . ';' : '';
	  $charitio_background_color       = ( ! empty( $color ) ) ? ' background-color: ' . esc_attr( $color ) . ';' : '';
	  $charitio_background_style       = ( ! empty( $image ) ) ? $charitio_background_image . $charitio_background_repeat . $charitio_background_position . $charitio_background_size . $charitio_background_attachment : '';
	  $charitio_title_bg = ( ! empty( $charitio_background_style ) || ! empty( $charitio_background_color ) ) ? $charitio_background_style . $charitio_background_color : '';
	} elseif( $charitio_custom_header->url ) {
		$charitio_title_bg = 'background-image:  url('. esc_url( $charitio_custom_header->url ) .');';
	} else {
		$charitio_title_bg = '';
	}
	if($charitio_banner_type === 'hide-title-area') { // Hide Title Area
	} elseif($charitio_meta && $charitio_banner_type === 'revolution-slider') { // Hide Title Area
		echo do_shortcode($charitio_meta['page_revslider']);
	} else {
	?>
 <!-- start page-title -->
  <section class="wpo-page-title <?php echo esc_attr( $overly_class.$styled_class.' '.$charitio_banner_type ); ?>" style="<?php echo esc_attr( $charitio_title_bg ); ?>">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12" style="<?php echo esc_attr( $charitio_custom_padding ); ?>">
                <div class="wpo-breadcumb-wrap">
                    <h2><?php echo charitio_title_area(); ?></h2>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<?php } ?>