<?php
/*
 * The sidebar containing the main widget area.
 * Author & Copyright: wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */
$charitio_blog_widget = cs_get_option( 'blog_widget' );
$charitio_single_blog_widget = cs_get_option( 'single_blog_widget' );
$charitio_project_sidebar_position = cs_get_option( 'project_sidebar_position' );
$charitio_project_widget = cs_get_option( 'single_project_widget' );
$charitio_event_sidebar_position = cs_get_option( 'event_sidebar_position' );
$charitio_event_widget = cs_get_option( 'single_event_widget' );
$charitio_blog_sidebar_position = cs_get_option( 'blog_sidebar_position' );
$charitio_sidebar_position = cs_get_option( 'single_sidebar_position' );
$woo_widget = cs_get_option('woo_widget');
$charitio_page_layout_shop = cs_get_option( 'woo_sidebar_position' );
$shop_sidebar_position = ( is_woocommerce_shop() ) ? $charitio_page_layout_shop : '';
if ( is_home() || is_archive() || is_search() ) {
	$charitio_blog_sidebar_position = $charitio_blog_sidebar_position;
} else {
	$charitio_blog_sidebar_position = '';
}
if ( is_single() ) {
	$charitio_sidebar_position = $charitio_sidebar_position;
} else {
	$charitio_sidebar_position = '';
}

if ( is_singular( 'project' ) ) {
	$charitio_project_sidebar_position = $charitio_project_sidebar_position;
} else {
	$charitio_project_sidebar_position = '';
}

if ( is_singular( 'event' ) ) {
	$charitio_event_sidebar_position = $charitio_event_sidebar_position;
} else {
	$charitio_event_sidebar_position = '';
}

if ( is_page() ) {
	// Page Layout Options
	$charitio_page_layout = get_post_meta( get_the_ID(), 'page_layout_options', true );
	if ( $charitio_page_layout ) {
		$charitio_page_sidebar_pos = $charitio_page_layout['page_layout'];
	} else {
		$charitio_page_sidebar_pos = '';
	}
} else {
	$charitio_page_sidebar_pos = '';
}
if (isset($_GET['sidebar'])) {
  $charitio_blog_sidebar_position = $_GET['sidebar'];
}
// sidebar class
if ( $charitio_sidebar_position === 'sidebar-left' || $charitio_page_sidebar_pos == 'left-sidebar' || $charitio_blog_sidebar_position === 'sidebar-left' ) {
	$col_class = ' order-lg-1 col-12';
} else {
	$col_class = '';
}

if ( $charitio_project_sidebar_position === 'sidebar-left' ) {
	$atn_push_class = ' order-lg-1 col-12';
} else {
	$atn_push_class = '';
}
if ( $charitio_event_sidebar_position === 'sidebar-left'  ) {
	$event_push_class = ' order-lg-1 col-12';
} else {
	$event_push_class = '';
}

if ( is_singular( 'project' ) ) {
	$custom_col = ' col-lg-4 col-md-8 ';
	$sidebar_class = 'wpo-event-sidebar blog-sidebar';
}	elseif ( is_singular( 'event' ) ) {
	$custom_col = ' col-lg-4 col-md-8 ';
	$sidebar_class = 'wpo-event-sidebar blog-sidebar';
} else {
	$custom_col = '';
	$sidebar_class = 'blog-sidebar';
}

if (  $shop_sidebar_position == 'left-sidebar' ) {
	$shop_push_class = ' order-lg-1 col-12';
} else {
	$shop_push_class = '';
}

if (  class_exists( 'WooCommerce' ) && is_shop() ) {
	$shop_col = ' shop-sidebar col-lg-4 col-md-8';
} else {
	$shop_col = '';
}

?>
<div class="col-lg-4 <?php echo esc_attr( $col_class.$custom_col.$atn_push_class.$shop_col.$shop_push_class.$event_push_class ); ?>">
	<div class="<?php echo esc_attr( $sidebar_class ); ?>">
		<?php
		if (is_page() && isset( $charitio_page_layout['page_sidebar_widget'] ) && !empty( $charitio_page_layout['page_sidebar_widget'] ) ) {
			if ( is_active_sidebar( $charitio_page_layout['page_sidebar_widget'] ) ) {
				dynamic_sidebar( $charitio_page_layout['page_sidebar_widget'] );
			}
		} elseif (!is_page() && $charitio_blog_widget && !$charitio_single_blog_widget) {
			if ( is_active_sidebar( $charitio_blog_widget ) ) {
				dynamic_sidebar( $charitio_blog_widget );
			}
		} elseif ( $charitio_project_widget && is_singular( 'project' ) ) {
			if ( is_active_sidebar( $charitio_project_widget ) ) {
				dynamic_sidebar( $charitio_project_widget );
			}
		}  elseif ( $charitio_event_widget && is_singular( 'event' ) ) {
			if ( is_active_sidebar( $charitio_event_widget ) ) {
				dynamic_sidebar( $charitio_event_widget );
			}
		}  elseif (is_woocommerce_shop() && $woo_widget) {
			if (is_active_sidebar($woo_widget)) {
				dynamic_sidebar($woo_widget);
			}
		} elseif ( is_single() && $charitio_single_blog_widget ) {
			if ( is_active_sidebar( $charitio_single_blog_widget ) ) {
				dynamic_sidebar( $charitio_single_blog_widget );
			}
		} else {
			if ( is_active_sidebar( 'sidebar-1' ) ) {
				dynamic_sidebar( 'sidebar-1' );
			}
		} ?>
	</div>
</div><!-- #secondary -->
