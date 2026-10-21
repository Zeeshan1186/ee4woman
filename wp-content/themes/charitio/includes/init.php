<?php
/*
 * All Charitio Theme Related Functions Files are Linked here
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

/* Theme All Charitio Setup */
require_once( CHARITIO_FRAMEWORK . '/theme-support.php' );
require_once( CHARITIO_FRAMEWORK . '/backend-functions.php' );
require_once( CHARITIO_FRAMEWORK . '/frontend-functions.php' );
require_once( CHARITIO_FRAMEWORK . '/enqueue-files.php' );
require_once( CHARITIO_CS_FRAMEWORK . '/custom-style.php' );
require_once( CHARITIO_CS_FRAMEWORK . '/config.php' );

/* Install Plugins */
require_once( CHARITIO_FRAMEWORK . '/theme-options/plugins/activation.php' );

/* Breadcrumbs */
require_once( CHARITIO_FRAMEWORK . '/theme-options/plugins/breadcrumb-trail.php' );

/* Aqua Resizer */
require_once( CHARITIO_FRAMEWORK . '/theme-options/plugins/aq_resizer.php' );

/* Bootstrap Menu Walker */
require_once( CHARITIO_FRAMEWORK . '/core/wp_bootstrap_navwalker.php' );

/* Sidebars */
require_once( CHARITIO_FRAMEWORK . '/core/sidebars.php' );

if ( class_exists( 'WooCommerce' ) ) :
	require_once( CHARITIO_FRAMEWORK . '/woocommerce-extend.php' );
endif;