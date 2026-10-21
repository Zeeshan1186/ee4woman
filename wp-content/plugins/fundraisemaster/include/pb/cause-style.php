<?php
	/*	
	*	Goodlayers Cause Item Style
	*/
	
	if( !class_exists('frmaster_cause_style') ){
		class frmaster_cause_style{

			public $cause_item_id;

			function __construct(){

				global $cause_item_id;
				$cause_item_id = empty($cause_item_id)? 1: $cause_item_id+1;
				$this->cause_item_id = $cause_item_id;

			}

			// get the content of the cause item
			function get_content( $args ){

				$ret = apply_filters('frmaster_cause_style_content', '', $args, $this);
				if( !empty($ret) ) return $ret;

				switch( $args['cause-style'] ){
					case 'grid':
					case 'grid-with-frame':
						return $this->cause_grid($args);
					
					case 'medium-with-frame':
						return $this->cause_medium($args);

					case 'modern':
						return $this->cause_modern($args);
				}
				
			}
			
			// get cause excerpt from $args
			function get_cause_excerpt( $args ){

				$ret = '';

				if( $args['excerpt'] == 'specify-number' ){
					if( !empty($args['excerpt-number']) ){
						$ret .= '<div class="frmaster-cause-excerpt clearfix" >';
						$ret .= $this->cause_excerpt($args['excerpt-number']);
						$ret .= '</div>';
					}
				}else if( $args['excerpt'] != 'none' ){
					$ret .= '<div class="frmaster-cause-content clearfix" >';
					$ret .= frmaster_content_filter(get_the_content(), true);
					$ret .= '</div>';
				}

				return $ret;
			}

			// get cause excerpt
			function cause_excerpt( $excerpt_length ) {
				
				$post = get_post();

				if( empty($post) || post_password_required() ){ return ''; }
			
				$excerpt = $post->post_excerpt;
				if( empty($excerpt) ){
					$excerpt = get_the_content('');
					$excerpt = strip_shortcodes($excerpt);
					
					$excerpt = apply_filters('the_content', $excerpt);
					$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
				}
				
				$excerpt_more = apply_filters('excerpt_more', '...');
				$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
				
				$excerpt = apply_filters('wp_trim_excerpt', $excerpt, $post->post_excerpt);		
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				
				return $excerpt;
			}			
			
			// get cause thumbnail
			function cause_thumbnail( $args = array(), $thumbnail_atts = array() ){

				$ret = '';

				$feature_image = get_post_thumbnail_id();

				if( !empty($feature_image) ){
					$ret .= '<div class="frmaster-cause-thumbnail frmaster-media-image" ' . frmaster_esc_style($thumbnail_atts) . ' >';
					$ret .= '<a href="' . get_permalink() . '" >';
					$ret .= frmaster_get_image($feature_image, $args['thumbnail-size']);
					$ret .= '<div class="frmaster-cause-thumbnail-gradient" ></div>';
					$ret .= '</a>';
					$ret .= '</div>';
				}
				
				return $ret;
			}

			// cause donate bar
			function cause_donate_bar($args = array(), $follow = false){

				$funding_goal = get_post_meta(get_the_ID(), 'frmaster-funding-goal', true);
				if( empty($funding_goal) ) return '';

				$donated_amount = get_post_meta(get_the_ID(), 'frmaster-donated-amount', true);
				$donated_percent = ($funding_goal == 0)? 0: intval(($donated_amount*100) / $funding_goal);

				$ret  = '<div class="frmaster-cause-donated-bar-wrap clearfix" >';
				$ret .= '<div class="frmaster-cause-donated-amount" ' . gdlr_core_esc_style(array(
					'color' => empty($args['donation-amount-color'])? '': $args['donation-amount-color']
				)) . ' >' . frmaster_money_format($donated_amount) . '</div>';
				if( $follow ){
					$ret .= frmaster_get_follow_link('<i class="fa fa-heart-o" ></i>', 'frmaster-follow-button');
				} 
				$ret .= '<div class="frmaster-cause-donated-bar" ' . gdlr_core_esc_style(array(
					'background' => empty($args['donation-bar-bg-color'])? '': $args['donation-bar-bg-color']
				)) . ' ><span ' . gdlr_core_esc_style(array(
					'width' => $donated_percent . '%',
					'background' => empty($args['donation-bar-color'])? '': $args['donation-bar-color']
				)) . ' ></span></div>';
				$ret .=  '<div class="frmaster-cause-donated-bar-percent" ' . gdlr_core_esc_style(array(
					'color' => empty($args['donation-percent-color'])? '': $args['donation-percent-color']
				)) . ' >' . sprintf(esc_html__('%d%% Donated', 'frmaster'), $donated_percent) . '</div>';
				$ret .=  '<div class="frmaster-cause-goal" ' . gdlr_core_esc_style(array(
					'color' => empty($args['donation-goal-color'])? '': $args['donation-goal-color']
				)) . ' >' . sprintf(esc_html__('Goal : %s', 'frmaster'), frmaster_money_format($funding_goal)) . '</div>';
				$ret .=  '</div>'; // frmaster-cause-donated-bar-wrap
				
				return $ret;
			}

			// cause title
			function cause_title( $args, $permalink = '' ){

				$ret  = '<h3 class="frmaster-cause-title gdlr-core-skin-title" ' . frmaster_esc_style(array(
					'font-size' => empty($args['title-font-size'])? '': $args['title-font-size'],
					'font-weight' => empty($args['title-font-weight'])? '': $args['title-font-weight'],
					'letter-spacing' => empty($args['title-letter-spacing'])? '': $args['title-letter-spacing'],
					'text-transform' => empty($args['title-text-transform'])? '': $args['title-text-transform']
				)) . ' >';
				if( empty($permalink) ){
					$ret .= '<a href="' . get_permalink() . '" >';
				}else{
					$ret .= '<a href="' . esc_attr($permalink) . '" target="_blank" >';
				}
				$ret .= get_the_title();
				$ret .= '</a>';
				$ret .= '</h3>';

				return  $ret;
			}
			
			// cause medium
			function cause_medium( $args ){

				$css_atts = array(
					'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
				);
				if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
					$css_atts['background-shadow-size'] = $args['frame-shadow-size'];
					$css_atts['background-shadow-color'] = $args['frame-shadow-color'];
					$css_atts['background-shadow-opacity'] = $args['frame-shadow-opacity'];
					$css_atts['border-radius'] = empty($args['border-radius'])? '': $args['border-radius'];
					$outer_frame = true;
				}

				$ret  = '<div class="frmaster-cause-medium clearfix" ' . gdlr_core_esc_style($css_atts) . ' >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->cause_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size']
					));
				}

				// content
				$ret .= '<div class="frmaster-cause-medium-content-wrap" >';
				$ret .= $this->cause_title($args);
				$ret .= $this->cause_donate_bar($args);
				$ret .= $this->get_cause_excerpt($args);

				$ret .= '<div class="frmaster-cause-bottom-info clearfix" >';
				$ret .= frmaster_get_donate_button();
				$ret .= frmaster_get_follow_link('<i class="fa fa-heart-o" ></i>', 'frmaster-follow-button');
				$ret .= '</div>';
				$ret .= '</div>'; // frmaster-cause-medium-content-wrap
				$ret .= '</div>'; // frmaster-cause-medium
				
				return $ret;
			}
			
			// cause column
			function cause_grid( $args ){

				$css_atts = array(
					'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
				);
				
				$thumbnail_shadow = array();
				if( $args['cause-style'] == 'grid-with-frame' ){
					$frame_css = ' frmaster-item-mgb frmaster-with-frame gdlr-core-skin-e-background';

					if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
						$css_atts['background-shadow-size'] = $args['frame-shadow-size'];
						$css_atts['background-shadow-color'] = $args['frame-shadow-color'];
						$css_atts['background-shadow-opacity'] = $args['frame-shadow-opacity'];
						$css_atts['border-radius'] = empty($args['border-radius'])? '': $args['border-radius'];
						$outer_frame = true;
					}

					// move up with shadow effect
					if( !empty($args['enable-move-up-shadow-effect']) && $args['enable-move-up-shadow-effect'] == 'enable' ){
						$frame_css .= ' frmaster-move-up-with-shadow';
						$outer_frame = true;
					}

					$frame_css .= empty($outer_frame)? '': ' gdlr-core-outer-frame-element';

					$ret  = '<div class="frmaster-cause-grid gdlr-core-js ' . esc_attr($frame_css) . '" ';
					$ret .= gdlr_core_esc_style($css_atts);
					if( $args['layout'] != 'masonry' ){
						$ret .= ' data-sync-height="cause-item-' . esc_attr($this->cause_item_id) . '" ';
					}
					$ret .= ' >';

				}else{
					if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
						$thumbnail_shadow['background-shadow-size'] = $args['frame-shadow-size'];
						$thumbnail_shadow['background-shadow-color'] = $args['frame-shadow-color'];
						$thumbnail_shadow['background-shadow-opacity'] = $args['frame-shadow-opacity'];
						$outer_frame = true;
					}
					$thumbnail_shadow['border-radius'] = empty($args['border-radius'])? '': $args['border-radius'];
					
					$ret  = '<div class="frmaster-cause-grid ' . (empty($outer_frame)? '': ' gdlr-core-outer-frame-element') . '" ' . gdlr_core_esc_style($css_atts) . ' >';
				}

				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->cause_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size']
					), $thumbnail_shadow);
				}
				
				if( $args['cause-style'] == 'grid-with-frame' ){
					$ret .= '<div class="frmaster-cause-grid-frame" ' . gdlr_core_esc_style(array(
						'padding' => empty($args['frame-padding'])? '': $args['frame-padding'],
					)) . ' >';
				}
				$ret .= $this->cause_title($args);
				$ret .= $this->cause_donate_bar($args);
				$ret .= $this->get_cause_excerpt($args);

				$ret .= '<div class="frmaster-cause-bottom-info clearfix" >';
				$ret .= frmaster_get_donate_button();
				$ret .= frmaster_get_follow_link('<i class="fa fa-heart-o" ></i>', 'frmaster-follow-button');
				$ret .= '</div>';

				if( $args['cause-style'] == 'grid-with-frame' ){
					$ret .= '</div>'; // frmaster-cause-grid-frame
				}

				$ret .= '</div>'; // frmaster-cause-grid
				
				return $ret;
			} 		

			// cause modern
			function cause_modern( $args ){
				
				$feature_image = get_post_thumbnail_id();
				$additional_class  = empty($feature_image)? ' frmaster-no-image': ' frmaster-with-image';
				
				$css_atts = array();
				if( !empty($feature_image) ){
					if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
						$css_atts['background-shadow-size'] = $args['frame-shadow-size'];
						$css_atts['background-shadow-color'] = $args['frame-shadow-color'];
						$css_atts['background-shadow-opacity'] = $args['frame-shadow-opacity'];
					}

					$css_atts['border-radius'] = empty($args['border-radius'])? '': $args['border-radius'];

					$additional_class .= ' gdlr-core-outer-frame-element';
				}

				$ret  = '<div class="frmaster-cause-modern ' . esc_attr($additional_class) . '" ' . gdlr_core_esc_style($css_atts) . ' >';
				$ret .= $this->cause_thumbnail(array(
					'thumbnail-size' => $args['thumbnail-size'],
					'gradient' => true
				));

				$ret .= '<div class="frmaster-cause-modern-content-wrap" ' . gdlr_core_esc_style(array(
					'padding' => empty($args['image-overlay-content-padding'])? array(): $args['image-overlay-content-padding']
				)) . ' >';
				$ret .= $this->cause_title($args);
				$ret .= $this->cause_donate_bar($args, true);
				$ret .= '</div>';
				$ret .= '</div>'; // frmaster-cause-modern
				
				return $ret;
			} 				
			
		} // frmaster_cause_item
	} // class_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	