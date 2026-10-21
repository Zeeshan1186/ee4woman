<?php
/*
 * The template for displaying all pages.
 * Author & Copyright: wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */
$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
if ( $charitio_meta ) {
	$charitio_content_padding = $charitio_meta['content_spacings'];
} else { $charitio_content_padding = 'section-padding'; }
// Top and Bottom Padding
if ( $charitio_content_padding && $charitio_content_padding !== 'padding-default' ) {
	$charitio_content_top_spacings = isset( $charitio_meta['content_top_spacings'] ) ? $charitio_meta['content_top_spacings'] : '';
	$charitio_content_bottom_spacings = isset( $charitio_meta['content_bottom_spacings'] ) ? $charitio_meta['content_bottom_spacings'] : '';
	if ( $charitio_content_padding === 'padding-custom' ) {
		$charitio_content_top_spacings = $charitio_content_top_spacings ? 'padding-top:'. charitio_check_px( $charitio_content_top_spacings ) .';' : '';
		$charitio_content_bottom_spacings = $charitio_content_bottom_spacings ? 'padding-bottom:'. charitio_check_px($charitio_content_bottom_spacings) .';' : '';
		$charitio_custom_padding = $charitio_content_top_spacings . $charitio_content_bottom_spacings;
	} else {
		$charitio_custom_padding = '';
	}
	$padding_class = '';
} else {
	$charitio_custom_padding = '';
	$padding_class = '';
}

// Page Layout
$page_layout_options = get_post_meta( get_the_ID(), 'page_layout_options', true );
if ( $page_layout_options ) {
	$charitio_page_layout = $page_layout_options['page_layout'];
	$page_sidebar_widget = $page_layout_options['page_sidebar_widget'];
} else {
	$charitio_page_layout = 'right-sidebar';
	$page_sidebar_widget = '';
}
$page_sidebar_widget = $page_sidebar_widget ? $page_sidebar_widget : 'sidebar-1';
if ( $charitio_page_layout === 'extra-width' ) {
	$charitio_page_column = 'extra-width';
	$charitio_page_container = 'container-fluid';
} elseif ( $charitio_page_layout === 'full-width' ) {
	$charitio_page_column = 'col-md-12';
	$charitio_page_container = 'container ';
} elseif( ( $charitio_page_layout === 'left-sidebar' || $charitio_page_layout === 'right-sidebar' ) && is_active_sidebar( $page_sidebar_widget ) ) {
	if( $charitio_page_layout === 'left-sidebar' ){
		$charitio_page_column = 'col-md-8 order-12';
	} else {
		$charitio_page_column = 'col-md-8';
	}
	$charitio_page_container = 'container ';
} else {
	$charitio_page_column = 'col-md-12';
	$charitio_page_container = 'container ';
}
$charitio_theme_page_comments = cs_get_option( 'theme_page_comments' );
get_header();
?>
<div class="page-wrap <?php echo esc_attr( $padding_class.''.$charitio_content_padding ); ?>">
	<div class="<?php echo esc_attr( $charitio_page_container.''.$charitio_page_layout ); ?>" style="<?php echo esc_attr( $charitio_custom_padding ); ?>">
		<div class="row">
			<div class="<?php echo esc_attr( $charitio_page_column ); ?>">
				<div class="page-wraper clearfix">
				<?php
				while ( have_posts() ) : the_post();
					the_content();
					if ( !$charitio_theme_page_comments && ( comments_open() || get_comments_number() ) ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>
				</div>
				<div class="page-link-wrap">
					<?php charitio_wp_link_pages(); ?>
				</div>
			</div>
			<?php
			// Sidebar
			if( ($charitio_page_layout === 'left-sidebar' || $charitio_page_layout === 'right-sidebar') && is_active_sidebar( $page_sidebar_widget )  ) {
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>
<?php
get_footer();