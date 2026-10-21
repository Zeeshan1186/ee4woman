<?php
/*
 * The template for displaying all single posts.
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
		$charitio_content_padding = $charitio_meta['content_spacings'];
	} else { $charitio_content_padding = ''; }
	// Padding - Metabox
	if ( $charitio_content_padding && $charitio_content_padding !== 'padding-default' ) {
		$charitio_content_top_spacings = $charitio_meta['content_top_spacings'];
		$charitio_content_bottom_spacings = $charitio_meta['content_bottom_spacings'];
		if ( $charitio_content_padding === 'padding-custom' ) {
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
	$charitio_sidebar_position = cs_get_option( 'project_sidebar_position' );
	$charitio_single_comment = cs_get_option( 'project_comment_form' );
	$charitio_sidebar_position = $charitio_sidebar_position ? $charitio_sidebar_position : 'sidebar-hide';
	// Sidebar Position
	if ( $charitio_sidebar_position === 'sidebar-hide' ) {
		$charitio_layout_class = 'col-lg-10 offset-lg-1';
		$charitio_sidebar_class = 'hide-sidebar';
	} elseif ( $charitio_sidebar_position === 'sidebar-left' ) {
		$charitio_layout_class = 'col col-lg-8 order-lg-2';
		$charitio_sidebar_class = 'left-sidebar';
	} else {
		$charitio_layout_class = 'col col-lg-8';
		$charitio_sidebar_class = 'right-sidebar';
	} ?>
<div class="wpo-project-single-section section-padding <?php echo esc_attr( $charitio_content_padding .' '. $charitio_sidebar_class ); ?>" style="<?php echo esc_attr( $charitio_custom_padding ); ?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $charitio_layout_class ); ?>">
				<div class="project-single-content">
					<?php
					if ( have_posts() ) :
						/* Start the Loop */
						while ( have_posts() ) : the_post();
							if ( post_password_required() ) {
									echo '<div class="password-form">'.get_the_password_form().'</div>';
								} else {
									get_template_part( 'theme-layouts/post/project', 'content' );
									$charitio_single_comment = !$charitio_single_comment ? comments_template() : '';

								}
						endwhile;
					else :
						get_template_part( 'theme-layouts/post/content', 'none' );
					endif; ?>
				</div><!-- Blog Div -->
				<?php
		    wp_reset_postdata(); ?>
			</div><!-- Content Area -->
				<?php
				if ( $charitio_sidebar_position !== 'sidebar-hide' ) {
					get_sidebar(); // Sidebar
				} ?>
		</div>
	</div>
</div>
<?php
get_footer();