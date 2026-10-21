<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/

	add_action('plugins_loaded', 'frmaster_add_pb_element_content_navigation');
	if( !function_exists('frmaster_add_pb_element_content_navigation') ){
		function frmaster_add_pb_element_content_navigation(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('content-navigation', 'frmaster_pb_element_content_navigation'); 
			}
			
		}
	}
	
	if( !class_exists('frmaster_pb_element_content_navigation') ){
		class frmaster_pb_element_content_navigation{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-plane',
					'title' => esc_html__('Content Navigation', 'frmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				return array(					
					'general' => array(
						'title' => esc_html__('General', 'frmaster'),
						'options' => array(

							'tabs' => array(
								'title' => esc_html__('Add New Tab', 'frmaster'),
								'type' => 'custom',
								'item-type' => 'tabs',
								'wrapper-class' => 'gdlr-core-fullsize',
								'options' => array(
									'id' => array(
										'title' => esc_html__('ID', 'frmaster'),
										'type' => 'text'
									),
									'title' => array(
										'title' => esc_html__('Title', 'frmaster'),
										'type' => 'text'
									),
								),
								'default' => array(
									array(
										'id' => esc_html__('section-1', 'frmaster'),
										'title' => esc_html__('Section 1', 'frmaster'),
									),
									array(
										'id' => esc_html__('section-2', 'frmaster'),
										'title' => esc_html__('Section 2', 'frmaster'),
									),
								)
							),
							
						),
					),
					'style' => array(
						'title' => esc_html('Style', 'frmaster'),
						'options' => array(
							'background-color' => array(
								'title' => esc_html__('Background Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'text-color' => array(
								'title' => esc_html__('Text Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'text-active-color' => array(
								'title' => esc_html__('Text Active Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'enable-bottom-border' => array(
								'title' => esc_html__('Enable Bottom Border', 'frmaster'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'border-color' => array(
								'title' => esc_html__('Border Color', 'frmaster'),
								'type' => 'colorpicker',
								'condition' => array( 'enable-bottom-border' => 'enable' )
							),
							'slide-bar-color' => array(
								'title' => esc_html__('Slide Bar Color', 'frmaster'),
								'type' => 'colorpicker'
							),
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'frmaster'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'frmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '30px'
							),
						)
					),

				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'tabs' => array(
							array(
								'id' => esc_html__('section-1', 'frmaster'),
								'title' => esc_html__('Section 1', 'frmaster'),
							),
							array(
								'id' => esc_html__('section-2', 'frmaster'),
								'title' => esc_html__('Section 2', 'frmaster'),
							),
						)
					);
				}

				$custom_style  = '';
				if( !empty($settings['text-active-color']) ){
					$custom_style .= '#custom_style_id .frmaster-content-navigation-item-outer .frmaster-content-navigation-tab:hover, ';
					$custom_style .= '#custom_style_id .frmaster-content-navigation-item-outer .frmaster-content-navigation-tab.frmaster-active{ ' . gdlr_core_esc_style(array(
						'color' => empty($settings['text-active-color'])? '': $settings['text-active-color']
					), false, true) . '} ';
				}
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $gdlr_core_cn_id;
						$gdlr_core_cn_id = empty($gdlr_core_cn_id)? array(): $gdlr_core_cn_id;

						// generate unique id so it does not get overwritten in admin area
						$rnd_cn_id = mt_rand(0, 99999);
						while( in_array($rnd_cn_id, $gdlr_core_cn_id) ){
							$rnd_cn_id = mt_rand(0, 99999);
						}
						$gdlr_core_cn_id[] = $rnd_cn_id;
						$settings['id'] = 'gdlr-content-navigation-' . $rnd_cn_id;
					}

					$custom_style = str_replace('custom_style_id', $settings['id'], $custom_style); 
					if( $preview ){
						$custom_style = '<style>' . $custom_style . '</style>';
					}else{
						gdlr_core_add_inline_style($custom_style);
						$custom_style = '';
					}
				}

				$css_atts = array(
					'background-color' => empty($settings['background-color'])? '': $settings['background-color'],
					'border-color' => empty($settings['border-color'])? '': $settings['border-color'],
				);
				if( !empty($settings['enable-bottom-border']) && $settings['enable-bottom-border'] == 'enable' ){
					$css_atts['border-bottom-width'] = '1px';
					$css_atts['border-bottom-style'] = 'solid';
				}
				
				$ret  = '<div class="frmaster-content-navigation-item-wrap clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != '30px' ){
					$ret .= frmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				$ret .= '<div class="frmaster-content-navigation-item-outer" id="frmaster-content-navigation-item-outer" ' . frmaster_esc_style($css_atts) . ' >';
				$ret .= '<div class="frmaster-content-navigation-item-container frmaster-container" >';
				$ret .= '<div class="frmaster-content-navigation-item frmaster-item-pdlr" >';
				if( !empty($settings['tabs']) ){
					$active = true;
					foreach( $settings['tabs'] as $tab ){

						$id = empty($tab['id'])? '': $tab['id'];
						$title = empty($tab['title'])? '': $tab['title'];

						$ret .= '<a class="frmaster-content-navigation-tab ';
						$ret .= ($active)? 'frmaster-active': '';
						$ret .= '" href="#' . esc_attr($id) . '" '; 
						$ret .= gdlr_core_esc_style(array(
							'color' => empty($settings['text-color'])? '': $settings['text-color'],
						));
						$ret .= ' >' . $title . '</a>';

						$active = false;
					}
				}
				$ret .= '<div class="frmaster-content-navigation-slider" ' . gdlr_core_esc_style(array(
					'background-color' => empty($settings['slide-bar-color'])? '': $settings['slide-bar-color']
				)) . '></div>';
				$ret .= '</div>'; // frmaster-content-navigation-item
				$ret .= '</div>'; // frmaster-content-navigation-item-container
				$ret .= '</div>'; // frmaster-content-navigation-item-outer
				$ret .= '</div>'; // frmaster-content-navigation-item-wrap
				$ret .= $custom_style;

				return $ret;
			}			
			
		} // frmaster_pb_element_content_navigation
	} // class_exists	