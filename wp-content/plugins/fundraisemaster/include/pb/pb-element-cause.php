<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	

	add_action('plugins_loaded', 'frmaster_add_pb_element_cause');
	if( !function_exists('frmaster_add_pb_element_cause') ){
		function frmaster_add_pb_element_cause(){
			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('cause', 'frmaster_pb_element_cause'); 
			}
		}
	}

	if( !class_exists('frmaster_pb_element_cause') ){
		class frmaster_pb_element_cause{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-newspaper-o',
					'title' => esc_html__('Cause', 'frmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return apply_filters('frmaster_cause_item_options', array(					
					'general' => array(
						'title' => esc_html__('General', 'frmaster'),
						'options' => array(
							'category' => array(
								'title' => esc_html__('Category', 'frmaster'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('cause_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'frmaster'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'frmaster'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('cause_tag')
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'frmaster'),
								'type' => 'text',
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing', 'frmaster')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'frmaster'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'frmaster'), 
									'title' => esc_html__('Title', 'frmaster'), 
									'rand' => esc_html__('Random', 'frmaster'), 
									'menu_order' => esc_html__('Menu Order', 'frmaster'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'frmaster'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'frmaster'), 
									'asc'=> esc_html__('Ascending Order', 'frmaster'), 
								)
							),
							'pagination' => array(
								'title' => esc_html__('Pagination', 'frmaster'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'frmaster'), 
									'page'=>esc_html__('Page', 'frmaster'), 
								),
								'description' => esc_html__('Pagination is not supported and will be automatically disabled on "carousel layout".', 'frmaster'),
							),
							'offset' => array(
								'title' => esc_html__('Query Offset', 'goodlayers-core'),
								'type' => 'text',
								'default' => 0,
								'data-input-type' => 'number',
								'condition' => array( 'pagination' => 'none' ),
								'description' => esc_html__('The number of posts you want to skip, cannot be used with pagination.', 'goodlayers-core')
							)
						),
					),
					'settings' => array(
						'title' => esc_html__('Cause Style', 'frmaster'),
						'options' => array(
							'cause-style' => array(
								'title' => esc_html__('Cause Style', 'frmaster'),
								'type' => 'combobox',
								'options' => array(
									'grid' => esc_html__('Grid', 'frmaster'),
									'grid-with-frame' => esc_html__('Grid With Frame', 'frmaster'),
									'modern' => esc_html__('Modern', 'frmaster'),
									'medium-with-frame' => esc_html__('Medium', 'frmaster'),
								),
								'default' => 'grid',
							),
							'no-space' => array(
								'title' => esc_html__('No Space', 'frmaster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'cause-style' => array('grid-with-frame', 'modern') )
							),
							'show-thumbnail' => array(
								'title' => esc_html__('Show Thumbnail', 'frmaster'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'frmaster'),
								'type' => 'combobox',
								'options' => 'thumbnail-size',
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'frmaster'),
								'type' => 'combobox',
								'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
								'default' => 20,
								'condition' => array('cause-style' => array('grid', 'grid-with-frame', 'modern'))
							),
							'layout' => array(
								'title' => esc_html__('Layout', 'frmaster'),
								'type' => 'combobox',
								'options' => array( 
									'fitrows' => esc_html__('Fit Rows', 'frmaster'),
									'carousel' => esc_html__('Carousel', 'frmaster'),
									'masonry' => esc_html__('Masonry', 'frmaster'),
								),
								'default' => 'fitrows',
								'condition' => array('cause-style' => array('grid', 'grid-with-frame', 'modern'))
							),
							'carousel-scrolling-item-amount' => array(
								'title' => esc_html__('Carousel Scrolling Item Amount', 'frmaster'),
								'type' => 'text',
								'default' => '1',
								'condition' => array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'frmaster'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'frmaster'),
								'type' => 'combobox',
								'options' => (function_exists('gdlr_core_get_flexslider_navigation_types')? gdlr_core_get_flexslider_navigation_types(): array()),
								'default' => 'navigation',
								'condition' => array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')
							),
							'carousel-navigation-align' => (function_exists('gdlr_core_get_flexslider_navigation_align')? gdlr_core_get_flexslider_navigation_align(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-left-icon' => (function_exists('gdlr_core_get_flexslider_navigation_left_icon')? gdlr_core_get_flexslider_navigation_left_icon(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-right-icon' => (function_exists('gdlr_core_get_flexslider_navigation_right_icon')? gdlr_core_get_flexslider_navigation_right_icon(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-icon-color' => (function_exists('gdlr_core_get_flexslider_navigation_icon_color')? gdlr_core_get_flexslider_navigation_icon_color(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-icon-bg' => (function_exists('gdlr_core_get_flexslider_navigation_icon_background')? gdlr_core_get_flexslider_navigation_icon_background(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-icon-padding' => (function_exists('gdlr_core_get_flexslider_navigation_icon_padding')? gdlr_core_get_flexslider_navigation_icon_padding(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-icon-radius' => (function_exists('gdlr_core_get_flexslider_navigation_icon_radius')? gdlr_core_get_flexslider_navigation_icon_radius(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-size' => (function_exists('gdlr_core_get_flexslider_navigation_icon_size')? gdlr_core_get_flexslider_navigation_icon_size(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-margin' => (function_exists('gdlr_core_get_flexslider_navigation_margin')? gdlr_core_get_flexslider_navigation_margin(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-navigation-icon-margin' => (function_exists('gdlr_core_get_flexslider_navigation_icon_margin')? gdlr_core_get_flexslider_navigation_icon_margin(): array('cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel')),
							'carousel-bullet-style' => array(
								'title' => esc_html__('Carousel Bullet Style', 'frmaster'),
								'type' => 'combobox',
								'options' => (function_exists('gdlr_core_get_flexslider_bullet_types')? gdlr_core_get_flexslider_bullet_types(): array()),
								'condition' => array( 'cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel', 'carousel-navigation' => array('bullet','both') )
							),
							'carousel-bullet-top-margin' => array(
								'title' => esc_html__('Carousel Bullet Top Margin', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'condition' => array( 'cause-style' => array('grid', 'grid-with-frame', 'modern'), 'layout' => 'carousel', 'carousel-navigation' => array('bullet','both') )
							),
							'excerpt' => array(
								'title' => esc_html__('Excerpt Type', 'frmaster'),
								'type' => 'combobox',
								'options' => array(
									'specify-number' => esc_html__('Specify Number', 'frmaster'),
									'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'frmaster'),
								),
								'default' => 'specify-number',
								'condition' => array( 'cause-style' => array('grid', 'grid-with-frame', 'medium-with-frame') )
							),
							'excerpt-number' => array(
								'title' => esc_html__('Excerpt Number', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 55,
								'condition' => array( 'cause-style' => array('grid', 'grid-with-frame', 'medium-with-frame'), 'excerpt' => 'specify-number' )
							),
						),
					),	
					'typography' => array(
						'title' => esc_html__('Typography', 'frmaster'),
						'options' => array(
							'title-font-size' => array(
								'title' => esc_html__('Title Font Size', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'title-font-weight' => array(
								'title' => esc_html__('Title Font Weight', 'frmaster'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'frmaster')
							),
							'title-letter-spacing' => array(
								'title' => esc_html__('Title Letter Spacing', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'title-text-transform' => array(
								'title' => esc_html__('Title Text Transform', 'frmaster'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'' => esc_html__('Default', 'frmaster'),
									'none' => esc_html__('None', 'frmaster'),
									'uppercase' => esc_html__('Uppercase', 'frmaster'),
									'lowercase' => esc_html__('Lowercase', 'frmaster'),
									'capitalize' => esc_html__('Capitalize', 'frmaster'),
								),
								'default' => 'none'
							),
						),
					),
					'shadow' => array(
						'title' => esc_html__('Color/Shadow', 'frmaster'),
						'options' => array(
							'donation-bar-color' => array(
								'title' => esc_html__('Donation Bar Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'donation-bar-bg-color' => array(
								'title' => esc_html__('Donation Bar Background Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'donation-goal-color' => array(
								'title' => esc_html__('Donation Goal Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'donation-amount-color' => array(
								'title' => esc_html__('Donation Amount Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'donation-percent-color' => array(
								'title' => esc_html__('Donation Percent Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'frame-shadow-size' => array(
								'title' => esc_html__('Shadow Size ( for image/frame )', 'frmaster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'options' => array('x', 'y', 'size'),
								'data-input-type' => 'pixel',
							),
							'frame-shadow-color' => array(
								'title' => esc_html__('Shadow Color ( for image/frame )', 'frmaster'),
								'type' => 'colorpicker'
							),
							'frame-shadow-opacity' => array(
								'title' => esc_html__('Shadow Opacity ( for image/frame )', 'frmaster'),
								'type' => 'text',
								'default' => '0.2',
								'description' => esc_html__('Fill the number between 0.01 to 1', 'frmaster')
							),
							'enable-move-up-shadow-effect' => array(
								'title' => esc_html__('Move Up Shadow Hover Effect', 'frmaster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('Only effects the "Column With Frame" style', 'frmaster')
							),
							'move-up-effect-length' => array(
								'title' => esc_html__('Move Up Hover Effect Length', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-size' => array(
								'title' => esc_html__('Shadow Hover Size', 'frmaster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'options' => array('x', 'y', 'size'),
								'data-input-type' => 'pixel',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-color' => array(
								'title' => esc_html__('Shadow Hover Color', 'frmaster'),
								'type' => 'colorpicker',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-opacity' => array(
								'title' => esc_html__('Shadow Hover Opacity', 'frmaster'),
								'type' => 'text',
								'default' => '0.2',
								'description' => esc_html__('Fill the number between 0.01 to 1', 'frmaster'),
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
						),
					),
					'spacing' => array(
						'title' => esc_html__('Frame / Spacing', 'frmaster'),
						'options' => array(
							'border-radius' => array(
								'title' => esc_html__('Frame/Thumbnail Border Radius', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'frame-padding' => array(
								'title' => esc_html__('Frame Padding', 'frmaster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'unlink' ),
							),
							'image-overlay-content-padding' => array(
								'title' => esc_html__('Image Overlay Content Padding', 'frmaster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'unlink' ),
							),
							'margin-bottom' => array(
								'title' => esc_html__('Margin Bottom ( Each Cause List )', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Whole Item )', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),
						),
					)
				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script id="frmaster-preview-cause-<?php echo esc_attr($id); ?>" >
if( document.readyState == 'complete' ){
	jQuery(document).ready(function(){
		var cause_preview = jQuery('#frmaster-preview-cause-<?php echo esc_attr($id); ?>').parent();
		cause_preview.gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_content_script();
		new gdlr_core_sync_height(cause_preview);
	});
}else{
	jQuery(window).load(function(){
		var cause_preview = jQuery('#frmaster-preview-cause-<?php echo esc_attr($id); ?>').parent();
		cause_preview.gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_content_script();
		new gdlr_core_sync_height(cause_preview);
	});
}
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'category' => '', 'tag' => '', 'num-fetch' => '9', 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'desc',
						'cause-style' => 'grid', 'excerpt' => 'specify-number', 'excerpt-number' => 55, 'column-size' => 20,
						'show-thumbnail' => 'enable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$settings['cause-style'] = empty($settings['cause-style'])? 'grid': $settings['cause-style'];
				$settings['layout'] = empty($settings['layout'])? 'fitrows': $settings['layout'];

				if( $settings['cause-style'] == 'medium-with-frame' ){
					$settings['layout'] = 'fitrows';
					$settings['column-size'] = 60;
				}

				$settings['no-space'] = empty($settings['no-space'])? 'disable': $settings['no-space'];
				if( in_array($settings['cause-style'], array('grid', 'medium-with-frame')) ){
					$settings['no-space'] = 'disable';
				}

				$custom_style  = '';
				if( $settings['cause-style'] == 'grid-with-frame' ){
					
					if( !empty($settings['enable-move-up-shadow-effect']) && $settings['enable-move-up-shadow-effect'] == 'enable' ){
						$custom_style .= frmaster_esc_style(array(
							'background-shadow-size' => empty($settings['frame-hover-shadow-size'])? '': $settings['frame-hover-shadow-size'],
							'background-shadow-color' => empty($settings['frame-hover-shadow-color'])? '': $settings['frame-hover-shadow-color'],
							'background-shadow-opacity' => empty($settings['frame-hover-shadow-opacity'])? '': $settings['frame-hover-shadow-opacity'],
						), false);

						if( !empty($settings['move-up-effect-length']) ){
							$custom_style .= 'transform: translate3d(0, -' . $settings['move-up-effect-length'] . ', 0); ';
						}

						if( !empty($custom_style) ){
							$custom_style .= '#custom_style_id .frmaster-move-up-with-shadow:hover{ ' . $custom_style_temp . ' }';
						}
					}
				}
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $frmaster_cause_id;
						$frmaster_cause_id = empty($frmaster_cause_id)? array(): $frmaster_cause_id;

						// generate unique id so it does not get overwritten in admin area
						$rnd_cause_id = mt_rand(0, 99999);
						while( in_array($rnd_cause_id, $frmaster_cause_id) ){
							$rnd_cause_id = mt_rand(0, 99999);
						}
						$frmaster_cause_id[] = $rnd_cause_id;
						$settings['id'] = 'frmaster-cause-' . $rnd_cause_id;
					}

					$custom_style = str_replace('custom_style_id', $settings['id'], $custom_style); 
					if( $preview ){
						$custom_style = '<style>' . $custom_style . '</style>';
					}else{
						gdlr_core_add_inline_style($custom_style);
						$custom_style = '';
					}
				}

				// start printing item
				$extra_class  = ' frmaster-style-' . $settings['cause-style'];
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				if( $settings['no-space'] == 'enable' || $settings['layout'] == 'carousel' ){
					$extra_class .= ' frmaster-item-pdlr';
				}

				$ret  = '<div class="frmaster-cause-item gdlr-core-item-pdb clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= frmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				// pring cause item
				$cause_item = new frmaster_cause_item($settings);

				$ret .= $cause_item->get_content();
				
				$ret .= '</div>'; // frmaster-cause-item
				$ret .= $custom_style;
				
				return $ret;
			}			
			
		} // frmaster_pb_element_cause
	} // class_exists	