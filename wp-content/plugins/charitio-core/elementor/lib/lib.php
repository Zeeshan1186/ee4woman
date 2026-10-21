<?php
namespace Elementor;
/*
 * All Elementor Group Controls Output
 * Author & Copyright: Themexshaper
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function charitio_insert_elementor($atts){
  if(!class_exists('Elementor\Plugin')){
      return '';
  }
  if(!isset($atts['id']) || empty($atts['id'])){
      return '';
  }

  $post_id = $atts['id'];
  $response = Plugin::instance()->frontend->get_builder_content_for_display($post_id);
  return $response;
}
add_shortcode('charitio_elementor_template','Elementor\charitio_insert_elementor');

if( !class_exists('Controls_Helper_Output') ){
	
	class Controls_Helper_Output{
		
		/**
		* Class Constructor
		*/
		
		//public function __construct(){}
		
		/**
		* Get Posts
		*/
		public static function get_posts( $post_type = '', $numberposts = ''){
			$numberposts = -1;
			$gen_posts = get_posts( [
				'post_type' => $post_type,
				'posts_per_page' => $numberposts,
			] );
			$all_posts = [];
			if ( is_array( $gen_posts ) && !empty( $gen_posts ) ) {
			  foreach ( $gen_posts as $sing_post ) {
				$all_posts[$sing_post->ID] = $sing_post->post_title;
			  }
			} else {
			  $all_posts = esc_html__( 'No contact forms found', 'charitio-core' );
			}
			return $all_posts;
		}
		
	/**
		* Get Post terms
		*/
		public static function get_terms_names( $term_name = '', $output = '', $hide_empty = false ){
			$return_val = [];
			$terms = get_terms([
			    'taxonomy'   => $term_name,
			    'hide_empty' => $hide_empty,
			]);
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach( $terms as $term ){
					if( 'id' == $output ){
						$return_val[$term->term_id] = $term->name;
					}
					else{
						$return_val[$term->slug] = $term->name;
					}
				}
			}
			return $return_val;
		}
		
		/**
		* Get Icons
		*/
		public static function get_include_icons(){
			$default_icons = Control_Icon::get_icons();
			
			// Line icon
			$line_icons = CHARITIO_EM_SHORTCODE_BASE_PATH . '/lib/icons/linea.json';
			$line_icons = file_get_contents($line_icons);
			$line_icons = json_decode($line_icons)->icons;
			
			//Themify icon
			$themify_icons = CHARITIO_EM_SHORTCODE_BASE_PATH . '/lib/icons/themify.json';
			$themify_icons = file_get_contents($themify_icons);
			$themify_icons = json_decode($themify_icons)->icons;

			//Themify icon
			$flat_icons = CHARITIO_EM_SHORTCODE_BASE_PATH . '/lib/icons/flat.json';
			$flat_icons = file_get_contents($flat_icons);
			$flat_icons = json_decode($flat_icons)->icons;

			// All icons join
			$get_icons = [];
			if( is_array( $line_icons ) && !empty( $line_icons ) ){
				foreach( $line_icons as $line_icon ){
					$get_icons[$line_icon] = str_replace(['icon-','basic-','ecommerce-'],['','',''],$line_icon);
				}
			}

			if( is_array( $themify_icons ) && !empty( $themify_icons ) ){
				foreach( $themify_icons as $themify_icon ){
					$get_icons[$themify_icon] = str_replace('ti-','',$themify_icon);
				}
			}
			
			if( is_array( $flat_icons ) && !empty( $flat_icons ) ){
				foreach( $flat_icons as $flat_icon ){
					$get_icons[$flat_icon] = str_replace('fi-','',$flat_icon);
				}
			}
			
			
			return $default_icons+$get_icons;
		}

	}// end class		
}