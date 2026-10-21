<?php
$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true); ?>

<div class="mini-cart">
    <button class="cart-toggle-btn"> <i class="fi flaticon-shopping-basket"></i> <span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span></button>
    <div class="mini-cart-content">
        <div class="mini-cart-title">
            <p><?php echo esc_html__('Shopping Cart','charitio'); ?></p>
        </div>
        <?php if ( ! WC()->cart->is_empty() ) : ?>
          <div class="mini-cart-items">
             <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
              $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
              $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

              if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
            <div class="mini-cart-item clearfix">
                <div class="mini-cart-item-image">
                    <?php
                      $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                      if ( ! $product_permalink ) {
                        echo wp_kses_post( $thumbnail );
                      } else {
                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                      }
                    ?>
                </div>
                <div class="mini-cart-item-des">
                     <?php
                      if ( ! $product_permalink ) {
                        echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
                      } else {
                        echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
                      }
                    ?>
                    <span class="mini-cart-item-price">
                    <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                    </span>
                    <span class="mini-cart-item-quantity"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
                    <?php
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                          '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                          esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                          esc_html__( 'Remove this item', 'charitio' ),
                          esc_attr( $product_id ),
                          esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                      ?>
                </div>
            </div>
            <?php
              }
             }
            ?>
        </div>
        <?php else : ?>
          <span class="no-products"><?php echo esc_html__(' No products in the cart.','charitio' ); ?></span>
        <?php endif; ?>
        <div class="mini-cart-action clearfix">
            <span class="mini-checkout-price"><?php echo WC()->cart->get_cart_total(); ?></span>
             <?php $mini_cart_url = wc_get_page_permalink( 'cart' ); $mini_shop_url = wc_get_page_permalink( 'shop' ); ?>
             <?php if (! WC()->cart->is_empty() ) { ?>
              <a href="<?php  echo esc_url( $mini_cart_url ) ?>" class="view-cart-btn"><?php echo esc_html__('View Cart','charitio' ); ?>
            </a>
             <?php } else { ?>
               <a href="<?php  echo esc_url( $mini_shop_url ) ?>" class="view-cart-btn"><?php echo esc_html__('Go Shop','charitio' ); ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>