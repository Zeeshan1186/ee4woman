<?php
	/*	
	*	Utility Files
	*	---------------------------------------------------------------------
	*	This file contains the function that helps doing things
	*	---------------------------------------------------------------------
	*/

	// Setup a post object and store the original loop item so we can reset it later
	if( !function_exists('frmaster_setup_admin_postdata') ){
		function frmaster_setup_admin_postdata(){
			global $post;

			if( is_admin() ){
				global $frmaster_post;
				$frmaster_post = $post;
			}
		}
	}

	// Reset $post back to the original item
	if( !function_exists('frmaster_reset_admin_postdata') ){
		function frmaster_reset_admin_postdata(){
			global $frmaster_post;

			if( is_admin() && !empty($frmaster_post) ){
				global $post;
				$post = $frmaster_post;
				setup_postdata($post);

				// clean up the data
				unset($frmaster_post);
			}
		}
	}

	// include utility function for uses 
	// make sure to call this function inside wp_enqueue_script action
	if( !function_exists('frmaster_include_utility_script') ){
		function frmaster_include_utility_script( $settings = array() ){

			frmaster_enqueue_icon();
			wp_enqueue_style('google-Montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700');

			if( !empty($settings['font-family']) && $settings['font-family'] == 'Open Sans' ){
				wp_enqueue_style('google-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,700');
			}

			wp_enqueue_style('frmaster-utility', FRMASTER_URL . '/framework/css/utility.css');

			wp_enqueue_script('frmaster-utility', FRMASTER_URL . '/framework/js/utility.js', array('jquery'), false, true);
			wp_localize_script('frmaster-utility', 'frmaster_utility', array(
				'confirm_head' => esc_html__('Just to confirm', 'frmaster'),
				'confirm_text' => esc_html__('Are you sure to do this ?', 'frmaster'),
				'confirm_sub' => esc_html__('* Please noted that this could not be undone.', 'frmaster'),
				'confirm_yes' => esc_html__('Yes', 'frmaster'),
				'confirm_no' => esc_html__('No', 'frmaster'),
			));

		} // frmaster_include_utility_script
	} // function_exists

	if( !function_exists('frmaster_enqueue_icon') ){
		function frmaster_enqueue_icon(){
			
			$font_awesome = frmaster_get_option('plugin', 'font-awesome', 'enable');
			if( $font_awesome == 'enable' ){
				wp_enqueue_style('font-awesome', FRMASTER_URL . '/plugins/font-awesome/font-awesome.min.css');
			}

			$elegant_icon = frmaster_get_option('plugin', 'elegant-icon', 'enable');
			if( $elegant_icon = 'enable' ){
				wp_enqueue_style('elegant-font', FRMASTER_URL . '/plugins/elegant-font/style.css');
			}

		} // frmaster_include_fontawesome
	} // function_exists

	// page builder content/text filer to execute the shortcode	
	if( !function_exists('frmaster_content_filter') ){
		add_filter( 'frmaster_the_content', 'wptexturize'        ); add_filter( 'frmaster_the_content', 'convert_smilies'    );
		add_filter( 'frmaster_the_content', 'convert_chars'      ); add_filter( 'frmaster_the_content', 'wpautop'            );
		add_filter( 'frmaster_the_content', 'shortcode_unautop'  ); add_filter( 'frmaster_the_content', 'prepend_attachment' );	
		add_filter( 'frmaster_the_content', 'do_shortcode', 11   );
		function frmaster_content_filter( $content, $main_content = false ){
			if($main_content) return str_replace( ']]>', ']]&gt;', apply_filters('the_content', $content) );
			
			$content = preg_replace_callback( '|(https?://[^\s"<]+)|im', 'frmaster_content_oembed', $content );
			
			return apply_filters('frmaster_the_content', $content);
		}		
	}
	if( !function_exists('frmaster_content_oembed') ){
		function frmaster_content_oembed( $link ){

			if( preg_match('/youtube|youtu\.be|vimeo/', $link[1]) ){
				$html = wp_oembed_get($link[1]);
				
				if( $html ) return $html;
			}
			return $link[1];
		}
	}
	if( !function_exists('frmaster_text_filter') ){
		add_filter('frmaster_text_filter', 'do_shortcode', 11);
		function frmaster_text_filter( $text ){
			return apply_filters('frmaster_text_filter', $text);
		}
	}

	// process data sent from the post variable
	if( !function_exists('frmaster_process_post_data') ){
		function frmaster_process_post_data( $post ){
			return stripslashes_deep($post);
		} // frmaster_process_post_data
	} // function_exists

	// use to add style attribute
	if( !function_exists('frmaster_esc_style') ){
		function frmaster_esc_style($atts, $wrap = true){
			if( empty($atts) ) return '';

			$att_style = '';

			// special attribute
			if( !empty($atts['background-shadow-color']) ){
				if( !empty($atts['background-shadow-size']['size']) && $atts['background-shadow-opacity'] ){
					$bgs_sizex = empty($atts['background-shadow-size']['x'])? '0': $atts['background-shadow-size']['x'];
					$bgs_sizey = empty($atts['background-shadow-size']['y'])? '0': $atts['background-shadow-size']['y'];
					$bgs  = $bgs_sizex . ' ' . $bgs_sizey . ' ' . $atts['background-shadow-size']['size'] . ' ';
					$bgs .= 'rgba(' . frmaster_format_datatype($atts['background-shadow-color'], 'rgba') . ',' . $atts['background-shadow-opacity'] . ')';

					$att_style .= 'box-shadow: ' . $bgs . '; ';
					$att_style .= '-moz-box-shadow: ' . $bgs . '; ';
					$att_style .= '-webkit-box-shadow: ' . $bgs . '; ';
				}
			}
			unset($atts['background-shadow-color']);
			unset($atts['background-shadow-size']);
			unset($atts['background-shadow-opacity']);

			foreach($atts as $key => $value){
				if( empty($value) ) continue;
				
				switch($key){
					
					case 'border-radius': 
						$att_style .= "border-radius: {$value};";
						$att_style .= "-moz-border-radius: {$value};";
						$att_style .= "-webkit-border-radius: {$value};";
						break;
					
					case 'gradient': 
						if( is_array($value) && sizeOf($value) > 1 ){
							$att_style .= "background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-moz-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-o-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-webkit-background: linear-gradient({$value[0]}, {$value[1]});";
						}
						break;
					
					case 'background':
					case 'background-color':
					case 'border':
					case 'border-color':
					case 'border-top-color':
					case 'border-right-color':
					case 'border-bottom-color':
					case 'border-left-color':
						if( is_array($value) ){
							$rgba_value = frmaster_format_datatype($value[0], 'rgba');
							$att_style .= "{$key}: rgba({$rgba_value}, {$value[1]});";
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;

					case 'background-image':
						if( is_numeric($value) ){
							$image_url = frmaster_get_image_url($value);
							if( !empty($image_url) ){
								$att_style .= "background-image: url({$image_url});";
							}
						}else{
							$att_style .= "background-image: url({$value});";
						}
						break;
					
					case 'padding':
					case 'margin':
					case 'border-width':
						if( is_array($value) ){
							if( !empty($value['top']) && !empty($value['right']) && !empty($value['bottom']) && !empty($value['left']) ){
								$att_style .= "{$key}: {$value['top']} {$value['right']} {$value['bottom']} {$value['left']};";
							}else{
								foreach($value as $pos => $val){
									if( $pos != 'settings' && (!empty($val) || $val === '0') ){
										if( $key == 'border-width' ){
											$att_style .= "border-{$pos}-width: {$val};";
										}else{
											$att_style .= "{$key}-{$pos}: {$val};";
										}
									}
								}
							}
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;
					
					default: 
						$value = is_array($value)? ((empty($value[0]) || $value[0] === '0')? '': $value[0]): $value;
						$att_style .= "{$key}: {$value};";
				}
			}
			
			if( !empty($att_style) ){
				if( $wrap ){
					return 'style="' . esc_attr($att_style) . '" ';
				}
				return $att_style;
			}
			return '';
		}
	}

	// get table html data
	if( !function_exists('frmaster_get_table_head') ){
		function frmaster_get_table_head( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<th>' . $column . '</th>';
			}
			echo '</tr>';
		}
	}
	if( !function_exists('frmaster_get_table_content') ){
		function frmaster_get_table_content( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<td>' . $column . '</td>';
			}
			echo '</tr>';
		}
	}

	// format data to specific type
	if( !function_exists('frmaster_format_datatype') ){
		function frmaster_format_datatype( $value, $data_type ){
			if( $data_type == 'color' ){
				return (strpos($value, '#') === false)? '#' . $value: $value; 
			}else if( $data_type == 'rgba' ){
				$value = str_replace('#', '', $value);
				if(strlen($value) == 3) {
					$r = hexdec(substr($value,0,1) . substr($value,0,1));
					$g = hexdec(substr($value,1,1) . substr($value,1,1));
					$b = hexdec(substr($value,2,1) . substr($value,2,1));
				}else{
					$r = hexdec(substr($value,0,2));
					$g = hexdec(substr($value,2,2));
					$b = hexdec(substr($value,4,2));
				}
				return $r . ', ' . $g . ', ' . $b;
			}else if( $data_type == 'text' ){
				return trim($value);
			}else if( $data_type == 'pixel' ){
				return (is_numeric($value))? $value . 'px': $value;
			}else if( $data_type == 'file' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'font'){
				return trim($value);
			}else if( $data_type == 'percent' ){
				return (is_numeric($value))? $value . '%': $value;
			}else if( $data_type == 'opacity' ){
				return (intval($value) / 100);
			} 
		}
	}	

	// get option for uses
	if( !function_exists('frmaster_get_option') ){
		function frmaster_get_option($option, $key = '', $default = ''){
			$option = 'frmaster_' . $option;
			
			if( empty($GLOBALS[$option]) ){
				$GLOBALS[$option] = get_option($option, '');
			}
				
			if( !empty($key) ){
				if( !empty($GLOBALS[$option][$key]) || (isset($GLOBALS[$option][$key]) && $GLOBALS[$option][$key] === '0') ){
					return $GLOBALS[$option][$key];
				}else{
					return $default;
				}
			}else{
				return $GLOBALS[$option];
			}
		}
	}
	if( !function_exists('frmaster_get_post_meta') ){
		function frmaster_get_post_meta($post_id, $key = ''){
			global $frmaster_post_meta;

			if( empty($frmaster_post_meta['id']) || $frmaster_post_meta['id'] != $post_id ){
				$frmaster_post_meta = array(
					'id' => $post_id,
					'value' => get_post_meta($post_id, $key, true)
				);
			}
			return $frmaster_post_meta['value'];
		}
	}

	// retrieve all posts from each post type
	if( !function_exists('frmaster_get_post_list') ){	
		function frmaster_get_post_list( $post_type, $with_none = false ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>999));

			$ret = array();
			if( !empty($with_none) ){
				$ret[''] = esc_html__('None', 'frmaster');
			}

			if( !empty($post_list) ){
				foreach( $post_list as $post ){
					$ret[$post->ID] = $post->post_title;
				}
			}
				
			return $ret;
		}	
	}

	// retrieve all categories from each post type
	if( !function_exists('frmaster_get_term_list') ){	
		function frmaster_get_term_list( $taxonomy, $cat = '', $with_all = false ){
			$term_atts = array(
				'taxonomy'=>$taxonomy, 
				'hide_empty'=>0,
				'number'=>999
			);
			if( !empty($cat) ){
				if( is_array($cat) ){
					$term_atts['slug'] = $cat;
				}else{
					$term_atts['parent'] = $cat;
				}
			}
			$term_list = get_categories($term_atts);

			$ret = array();
			if( !empty($with_all) ){
				$ret[$cat] = esc_html__('All', 'goodlayers-core'); 
			}

			if( !empty($term_list) ){
				foreach( $term_list as $term ){
					if( !empty($term->slug) && !empty($term->name) ){
						$ret[$term->slug] = $term->name;
					}
				}
			}

			return $ret;
		}	
	}
	if( !function_exists('frmaster_get_term_list_id') ){	
		function frmaster_get_term_list_id( $taxonomy ){
			$term_atts = array(
				'taxonomy'=>$taxonomy, 
				'hide_empty'=>0,
				'number'=>5000
			);

			$term_list = get_categories($term_atts);

			$ret = array();
			if( !empty($term_list) ){
				foreach( $term_list as $term ){
					if( !empty($term->term_id) && !empty($term->name) ){
						$ret[$term->term_id] = $term->name;
					}
				}
			}

			return $ret;
		}	
	}

	// get all thumbnail name
	if( !function_exists('frmaster_get_thumbnail_list') ){
		function frmaster_get_thumbnail_list(){
			$ret = array();
			
			$thumbnails = get_intermediate_image_sizes();
			$ret['full'] = esc_html__('full size', 'frmaster');
			foreach( $thumbnails as $thumbnail ) {
				if( !empty($GLOBALS['_wp_additional_image_sizes'][$thumbnail]) ){
					$width = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['width'];
					$height = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['height'];
				}else{
					$width = get_option($thumbnail . '_size_w', '');
					$height = get_option($thumbnail . '_size_h', '');
				}
				$ret[$thumbnail] = $thumbnail . ' ' . $width . '-' . $height;
			}
			return $ret;
		}
	}

	// get all sidebar name
	if( !function_exists('frmaster_get_sidebar_list') ){
		function frmaster_get_sidebar_list( $settings = array() ){
			global $wp_registered_sidebars;
			
			$sidebars = array();
			if( !empty($settings['with-none']) ){
				$sidebars['none'] = esc_html__('None', 'frmaster');
			}
			if( !empty($settings['with-default']) ){
				$sidebars['default'] = esc_html__('Default', 'frmaster');
			}
			if( !empty($wp_registered_sidebars) && is_array($wp_registered_sidebars) ){
				foreach( $wp_registered_sidebars as $sidebar_id => $value ) {
					$sidebars[$sidebar_id] = $value['name'];
				}
			}
			
			return $sidebars;
		}
	}

	// create pagination link
	if( !function_exists('frmaster_get_pagination') ){	
		function frmaster_get_pagination($max_num_page, $settings = array(), $extra_class = '', $style = ''){
			if( function_exists('gdlr_core_get_pagination') ){
				return gdlr_core_get_pagination($max_num_page, $settings, $extra_class, $style);
			}

			if( $max_num_page <= 1 ) return '';
		
			$big = 999999999; // need an unlikely integer

			if( empty($settings['pagination-style']) || $settings['pagination-style'] == 'default' ){
				$style = apply_filters('frmaster_pagination_style', 'round');
			}else{
				$style = $settings['pagination-style'];
			}
			if( empty($settings['pagination-align']) || $settings['pagination-align'] == 'default' ){
				$align = apply_filters('frmaster_pagination_align', 'right');
			}else{
				$align = $settings['pagination-align'];
			}

			$with_border = (strpos($style, '-border') !== false);
			$style = str_replace('-border', '', $style);
			$current_page = empty($settings['paged']) ? 1: $settings['paged'];

			$pagination_class  = ' frmaster-style-' .  $style;
			$pagination_class .= ' frmaster-' .  $align . '-align';
			$pagination_class .= empty($with_border)? '': ' frmaster-with-border';
			$pagination_class .= empty($extra_class)? '': ' ' . $extra_class;
			
			if( is_single() ){
				return '<div class="frmaster-pagination ' . esc_attr($pagination_class) . '">' . paginate_links(array(
					'base' => add_query_arg(array('page'=>'%#%'), get_permalink()),
					'format' => '?page=%#%',
					'current' => max(1, $current_page),
					'total' => $max_num_page,
					'prev_text'=> '',
					'next_text'=> ''
				)) . '</div>';
			}else{
				return '<div class="frmaster-pagination ' . esc_attr($pagination_class) . '">' . paginate_links(array(
					'base' => str_replace($big, '%#%', get_pagenum_link($big, false)),
					'format' => '?paged=%#%',
					'current' => max(1, $current_page),
					'total' => $max_num_page,
					'prev_text'=> '',
					'next_text'=> ''
				)) . '</div>';
			}
		}	
	}
	if( !function_exists('frmaster_get_ajax_pagination') ){	
		function frmaster_get_ajax_pagination($post_type, $settings, $max_num_page, $target, $extra_class = ''){
			if( $max_num_page <= 1 ) return '';
			
			if( empty($settings['pagination-style']) || $settings['pagination-style'] == 'default' ){
				$style = apply_filters('frmaster_pagination_style', 'round');
			}else{
				$style = $settings['pagination-style'];
			}
			if( empty($settings['pagination-align']) || $settings['pagination-align'] == 'default' ){
				$align = apply_filters('frmaster_pagination_align', 'right');
			}else{
				$align = $settings['pagination-align'];
			}
			$with_border = (strpos($style, '-border') !== false);
			$style = str_replace('-border', '', $style);
			$current_page = empty($settings['paged']) ? 1: $settings['paged'];

			$pagination_class  = ' frmaster-style-' .  $style;
			$pagination_class .= ' frmaster-' .  $align . '-align';
			$pagination_class .= empty($with_border)? '': ' frmaster-with-border';
			$pagination_class .= empty($extra_class)? '': ' ' . str_replace('gdlr-core', 'frmaster', $extra_class);

			$ret  = '<div class="frmaster-pagination frmaster-ajax-action ' . esc_attr($pagination_class) . '" ';
			$ret .= 'data-tm-ajax="frmaster_' . esc_attr($post_type) . '_ajax" ';
			$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
			$ret .= 'data-target="' . esc_attr($target) . '" ';
			$ret .= 'data-target-action="replace" ';
			$ret .= 'data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
			$ret .= '>';

			$dot = false;
			for($i=1; $i<=$max_num_page; $i++){
				if( $i == $current_page ){
					$dot = true;
					$ret .= '<a class="page-numbers frmaster-active" data-ajax-name="paged" data-ajax-value="' . $i . '" >' . $i . '</a> ';
				}else if( ($i <= $current_page + 2 && $i >= $current_page -2) || $i == 1 || $i == $max_num_page ){
					$dot = true;
					$ret .= '<a class="page-numbers" data-ajax-name="paged" data-ajax-value="' . $i . '" >' . $i . '</a> ';
				}else if( $dot ){
					$dot = false;
					$ret .= '<span class="page-numbers dots">…</span>';
				}
			}
			$ret .= '</div>';

			return $ret;
		}	
	}
	if( !function_exists('frmaster_get_ajax_load_more') ){	
		function frmaster_get_ajax_load_more($post_type, $settings, $paged, $max_num_page, $target, $extra_class){
			$ret  = '';
			if( $paged <= $max_num_page ){
				$extra_class = str_replace('gdlr-core', 'frmaster', $extra_class);

				$ret  = '<div class="frmaster-load-more-wrap frmaster-ajax-action frmaster-center-align ' . esc_attr($extra_class) . '" ';
				$ret .= 'data-tm-ajax="frmaster_' . esc_attr($post_type) . '_ajax" ';
				$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
				$ret .= 'data-target="' . esc_attr($target) . '" ';
				$ret .= 'data-target-action="append" ';
				$ret .= 'data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
				$ret .= '>';
				if( $paged <= $max_num_page ){
					$ret .= '<a href="#" class="frmaster-load-more frmaster-button" data-ajax-name="paged" data-ajax-value="' . esc_attr($paged) . '" >';
					$ret .= esc_html__('Load More', 'frmaster');
					$ret .= '</a>';
				}
				$ret .= '</div>';
			}

			return $ret;
		}
	}
	if( !function_exists('frmaster_get_ajax_filterer') ){	
		function frmaster_get_ajax_filterer($post_type, $taxonomy, $settings, $target, $extra_class){
			$extra_class = str_replace('gdlr-core', 'frmaster', $extra_class);

			$ret  = '<div class="frmaster-filterer-wrap frmaster-ajax-action ' . esc_attr($extra_class) . '" ';
			$ret .= 'data-tm-ajax="frmaster_' . esc_attr($post_type) . '_ajax" ';
			$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
			$ret .= 'data-target="' . esc_attr($target) . '" ';
			$ret .= 'data-target-action="replace" ';
			$ret .= 'data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" ';
			$filterer_atts = apply_filters('frmaster_filterer_css_atts', array(), $settings);
			if( !empty($settings['filterer-bottom-margin']) ){
				$filterer_atts['margin-bottom'] = $settings['filterer-bottom-margin'];
			}
			if( !empty($filterer_atts) ){
				$ret .= frmaster_esc_style($filterer_atts);
			}
			$ret .= ' >';

			// for all
			if( empty($settings['category']) ){

				$ret .= '<a href="#" class="frmaster-filterer frmaster-button-color frmaster-active" >' . esc_html__('All', 'frmaster') . '</a>';
				$filters = frmaster_get_term_list($taxonomy);

			// parent category
			}else if( sizeof($settings['category']) == 1 ){

				$term = get_term_by('slug', $settings['category'][0], $taxonomy);
				$ret .= '<a href="#" class="frmaster-filterer frmaster-button-color frmaster-active" >' . $term->name . '</a>';
				$filters = frmaster_get_term_list($taxonomy, $term->term_id);

			// multiple category select
			}else{

				$ret .= '<a href="#" class="frmaster-filterer frmaster-button-color frmaster-active" >' . esc_html__('All', 'frmaster') . '</a>';
				$filters = frmaster_get_term_list($taxonomy, $settings['category']);
				
			}

			$filter_sep = apply_filters('gdlr_core_filterer_separator', '');
			foreach( $filters as $slug => $name ){
				$ret .= $filter_sep;
				$ret .= '<a href="#" class="frmaster-filterer frmaster-button-color" data-ajax-name="category" data-ajax-value="' . esc_attr($slug) . '" >';
				$ret .= $name;
				$ret .= '</a>';
			}

			$ret .= '</div>'; // frmaster-filterer-wrap

			return $ret;
		}
	}