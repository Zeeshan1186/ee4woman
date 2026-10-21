<?php
    // Logo Image
    // Metabox - Header Transparent
    $charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
    $charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
    $charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
    $charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox'. true );
    $charitio_preloader_image  = cs_get_option( 'preloader_image' );

    $charitio_preloader_url = wp_get_attachment_url( $charitio_preloader_image );
    $charitio_preloader_alt = get_post_meta( $charitio_preloader_image, '_wp_attachment_image_alt', true );

    if ( $charitio_preloader_url ) {
        $charitio_preloader_url = $charitio_preloader_url;
    } else {
        $charitio_preloader_url = CHARITIO_IMAGES.'/preloader.png';
    }

?>
<!-- start preloader -->
<div class="preloader">
    <div class="vertical-centered-box">
        <div class="content">
            <div class="loader-circle"></div>
            <div class="loader-line-mask">
                <div class="loader-line"></div>
            </div>
            <img src="<?php echo esc_url( $charitio_preloader_url ); ?>" alt="<?php echo esc_attr( $charitio_preloader_alt ); ?>">
        </div>
    </div>
</div>
<!-- end preloader -->