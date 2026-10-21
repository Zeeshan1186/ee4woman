<?php
/*
 * All Elementor Init
 * Author & Copyright: wpoceans
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists('Charitio_Core_Elementor_init') ){
	class Charitio_Core_Elementor_init{

		/*
		 * Minimum Elementor Version
		*/
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		/*
		 * Minimum PHP Version
		*/
		const MINIMUM_PHP_VERSION = '7.0';

    /*
	   * Instance
	  */
		private static $instance;

		/*
		 * Main Charitio Core plugin Class Constructor
		*/
		public function __construct(){
			add_action( 'plugins_loaded', [ $this, 'init' ] );

			// Style Enqueue
			
			add_action( 'wp_enqueue_scripts', function(){
				wp_enqueue_style('charitio-elementor', CHARITIO_PLUGIN_URL . 'elementor/assets/css/charitio-elementor.css', [], '1.0.0');
			} );
			

			add_action( 'elementor/editor/before_enqueue_scripts', function() {
			   wp_enqueue_style('charitio-ele-editor-linea', CHARITIO_PLUGIN_URL . 'elementor/assets/css/linea.min.css', [], '1.0.0');
			   wp_enqueue_style('charitio-ele-editor-themify', CHARITIO_PLUGIN_URL . 'elementor/assets/css/themify-icons.min.css', [], '1.0.0');
			   wp_enqueue_style('charitio-ele-editor-flat', CHARITIO_PLUGIN_URL . 'elementor/assets/css/flaticon.css', [], '1.0.0');
			} );

			// Js Enqueue
			add_action( 'elementor/frontend/after_enqueue_scripts', function() {

				wp_enqueue_script( 'charitio-elementor', CHARITIO_PLUGIN_URL . 'elementor/assets/js/charitio-elementor.js', [ 'jquery' ], false, true );

			} );

		}

		/*
		 * Class instance
		*/
		public static function getInstance(){
			if (null === self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/*
		 * Initialize the plugin
		*/
		public function init() {
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// elementor Custom Group Controls Include
			self::controls_helper();

			// elementor categories
			add_action( 'elementor/elements/categories_registered', [ $this, 'widget_categories' ] );

			// elementor editor css
			add_action( 'elementor/editor/after_enqueue_scripts', function() {

			  wp_enqueue_style( 'charitio-elementor-editor',CHARITIO_PLUGIN_URL . 'elementor/assets/css/elementor-editor.css');
				wp_enqueue_script( 'tmxheme-googlemap', CHARITIO_PLUGIN_ASTS . '/jquery.googlemap.js', array( 'jquery' ), '1.5.0', true );
		    
			} );

			// Elementor Widgets Registered
			 add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );

		}

		/*
		 * Admin notice
		 * Warning when the site doesn't have Elementor installed or activated.
		*/
		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'charitio-core' ),
				'<strong>' . esc_html__( 'Charitio Core', 'charitio-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'charitio-core' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/*
		 * Admin notice
		 * Warning when the site doesn't have a minimum required Elementor version.
		*/
		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'charitio-core' ),
				'<strong>' . esc_html__( 'Charitio Core', 'charitio-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'charitio-core' ) . '</strong>',
				 self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/*
		 * Admin notice
		 * Warning when the site doesn't have a minimum required PHP version.
		*/
		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'charitio-core' ),
				'<strong>' . esc_html__( 'Charitio Core', 'charitio-core' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'charitio-core' ) . '</strong>',
				 self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/*
		 * Class Group Controls
		*/
		public static function controls_helper(){
			$group_controls = ['lib'];
			foreach($group_controls as $control){
				if( file_exists( CHARITIO_EM_SHORTCODE_BASE_PATH . '/lib/'.$control.'.php' ) ){
					require_once( CHARITIO_EM_SHORTCODE_BASE_PATH . '/lib/'.$control.'.php' );
				}
			}
		}

		/*
		 * Widgets elements categories
		*/
		public function widget_categories($elements_manager){
			$elements_manager->add_category(
				'wpoceans-category',
				[
					'title' => __( 'Charitio Theme : By wpoceanss', 'charitio-core' ),
					'icon' => 'fa fa-plug',
				]
			);
		}

		/*
		 * Widgets registered
		*/
		public function widgets_registered(){
			// init widgets
			$dir = CHARITIO_EM_SHORTCODE_PATH;
			// Open a directory, and read its contents
			if (is_dir($dir)){
			  $dh = opendir($dir);
		    while (($file = readdir($dh)) !== false){
		    	if (!in_array(trim($file), ['.', '..'])) {
						$template_file = CHARITIO_EM_SHORTCODE_BASE_PATH . 'widgets/'.$file;
						if ( $template_file && is_readable( $template_file ) ) {
							include_once $template_file;
						}
			    }
		    }
		    closedir($dh);
			}
		}

	} //end class

	if(class_exists('Charitio_Core_Elementor_init')){
		Charitio_Core_Elementor_init::getInstance();
	}

}

if( ! function_exists( 'charitio_elementor_default_typo_color_active' ) ) {
	function charitio_elementor_default_typo_color_active() {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
	add_action( 'after_switch_theme', 'charitio_elementor_default_typo_color_active' );
}

if( ! function_exists( 'charitio_elementor_default_typo_color_active_after' ) ) {
	function charitio_elementor_default_typo_color_active_after() {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
	add_action( 'pt-ocdi/after_content_import_execution', 'charitio_elementor_default_typo_color_active_after' );
}
