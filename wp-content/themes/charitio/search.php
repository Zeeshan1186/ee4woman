<?php
/*
 * The search template file.
 * Author & Copyright: wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */
get_header();
	// Metabox
	$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
	$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
	$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
	$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
	if ( $charitio_meta ) {
		$charitio_content_padding = isset( $charitio_meta['content_spacings'] ) ? $charitio_meta['content_spacings'] : '';
	} else { $charitio_content_padding = ''; }
	// Padding - Metabox
	if ($charitio_content_padding && $charitio_content_padding !== 'padding-default') {
		$charitio_content_top_spacings = $charitio_meta['content_top_spacings'];
		$charitio_content_bottom_spacings = $charitio_meta['content_bottom_spacings'];
		if ($charitio_content_padding === 'padding-custom') {
			$charitio_content_top_spacings = $charitio_content_top_spacings ? 'padding-top:'. charitio_check_px($charitio_content_top_spacings) .';' : '';
			$charitio_content_bottom_spacings = $charitio_content_bottom_spacings ? 'padding-bottom:'. charitio_check_px($charitio_content_bottom_spacings) .';' : '';
			$charitio_custom_padding = $charitio_content_top_spacings . $charitio_content_bottom_spacings;
		} else {
			$charitio_custom_padding = '';
		}
	} else {
		$charitio_custom_padding = '';
	}
	// Theme Options
	$charitio_sidebar_position = cs_get_option( 'blog_sidebar_position' );
	$charitio_sidebar_position = $charitio_sidebar_position ?$charitio_sidebar_position : 'sidebar-right';
	$charitio_blog_widget = cs_get_option( 'blog_widget' );
	$charitio_blog_widget = $charitio_blog_widget ? $charitio_blog_widget : 'sidebar-1';

	if (isset($_GET['sidebar'])) {
	  $charitio_sidebar_position = $_GET['sidebar'];
	}

	$charitio_sidebar_position = $charitio_sidebar_position ? $charitio_sidebar_position : 'sidebar-right';

	// Sidebar Position
	if ( $charitio_sidebar_position === 'sidebar-hide' ) {
		$layout_class = 'col col col-md-10 col-md-offset-1';
		$charitio_sidebar_class = 'hide-sidebar';
	} elseif ( $charitio_sidebar_position === 'sidebar-left' && is_active_sidebar( $charitio_blog_widget ) ) {
		$layout_class = 'col col-md-8 col-md-push-3';
		$charitio_sidebar_class = 'left-sidebar';
	} elseif( is_active_sidebar( $charitio_blog_widget ) ) {
		$layout_class = 'col col-md-8';
		$charitio_sidebar_class = 'right-sidebar';
	} else {
		$layout_class = 'col col-md-12';
		$charitio_sidebar_class = 'hide-sidebar';
	}
	?>
<div class="wpo-blog-pg-section section-padding">
	<div class="container <?php echo esc_attr( $charitio_content_padding .' '. $charitio_sidebar_class ); ?>" style="<?php echo esc_attr( $charitio_custom_padding ); ?>">
		<div class="row">
			<div class="<?php echo esc_attr( $layout_class ); ?>">
				<div class="blog-content">
				<?php
				if ( have_posts() ) :
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						get_template_part( 'theme-layouts/post/content', 'search');
					endwhile;
				else :
					get_template_part( 'theme-layouts/post/content', 'none' );
				endif;
				charitio_posts_navigation();
		    wp_reset_postdata(); ?>
		    </div>
			</div><!-- Content Area -->
			<?php
			if ( $charitio_sidebar_position !== 'sidebar-hide' && is_active_sidebar( $charitio_blog_widget ) ) {
				get_sidebar(); // Sidebar
			} ?>
		</div>
	</div>
</div>
<?php
get_footer();