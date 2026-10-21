<?php
	/**
	 * The Template for displaying product archives, including the main shop page which is a post type archive
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see 	    https://docs.woocommerce.com/document/template-structure/
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     3.4.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	get_header( 'shop' );
	// Theme Options
	$charitio_sidebar_position = cs_get_option('woo_sidebar_position');
	$charitio_sidebar_position = $charitio_sidebar_position ? $charitio_sidebar_position : 'right-sidebar';

	$charitio_woo_widget = cs_get_option( 'woo_widget' );
	$charitio_woo_widget = $charitio_woo_widget ? $charitio_woo_widget : 'sidebar-1';
	// Sidebar Position
	if ( $charitio_sidebar_position === 'sidebar-hide' ) {
		$layout_class = 'col col col-md-12';
		$charitio_sidebar_class = 'hide-sidebar';
	} elseif ( $charitio_sidebar_position === 'sidebar-left' && is_active_sidebar( $charitio_woo_widget ) ) {
		$layout_class = 'col col-md-8 col-md-push-4';
		$charitio_sidebar_class = 'left-sidebar';
	} elseif( is_active_sidebar( $charitio_woo_widget ) ) {
		$layout_class = 'col col-md-8';
		$charitio_sidebar_class = 'right-sidebar';
	} else {
		$layout_class = 'col col-md-12';
		$charitio_sidebar_class = 'hide-sidebar';
	}
?>
<section class="shop-section section-padding">
  <div class="container">
    <div class="row">
			<div class="<?php echo esc_attr( $layout_class); ?>">
				<div class="row">
						<?php
						/**
						 * Hook: woocommerce_before_main_content.
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 * @hooked WC_Structured_Data::generate_website_data() - 30
						 */
						do_action( 'woocommerce_before_main_content' );
						?>
						<?php

						/**
						 * Hook: woocommerce_archive_description.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description' );
						?>

						<?php

						if ( have_posts() ) {
							?>
						<div class="col-md-12">
							<div class="shop_list_inner_area row m0">
							<?php

							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked wc_print_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
								do_action( 'woocommerce_before_shop_loop' );

								?>
							</div>
						</div>

								<?php

								woocommerce_product_loop_start();

								if ( wc_get_loop_prop( 'total' ) ) {
									while ( have_posts() ) {
										the_post();

										/**
										 * Hook: woocommerce_shop_loop.
										 *
										 * @hooked WC_Structured_Data::generate_product_data() - 10
										 */
										do_action( 'woocommerce_shop_loop' );

										wc_get_template_part( 'content', 'product' );
									}
								}

								woocommerce_product_loop_end();

								/**
								 * Hook: woocommerce_after_shop_loop.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action( 'woocommerce_after_shop_loop' );
							} else {
								/**
								 * Hook: woocommerce_no_products_found.
								 *
								 * @hooked wc_no_products_found - 10
								 */
								do_action( 'woocommerce_no_products_found' );
							}

							/**
							 * Hook: woocommerce_after_main_content.
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action( 'woocommerce_after_main_content' );
							?>
					</div>
				</div>
				<?php
				if ( $charitio_sidebar_position !== 'sidebar-hide' && is_active_sidebar( $charitio_woo_widget ) ) {
					/**
					 * Hook: woocommerce_sidebar.
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				}
				?>
		</div>
	</div>
</section>
<?php
get_footer( 'shop' );
