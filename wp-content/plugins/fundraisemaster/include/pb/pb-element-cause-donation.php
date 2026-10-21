<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	

	add_action('plugins_loaded', 'tourmaster_add_pb_element_cause_donation');
	if( !function_exists('tourmaster_add_pb_element_cause_donation') ){
		function tourmaster_add_pb_element_cause_donation(){
			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('cause-donation', 'frmaster_pb_element_cause_donation'); 
			}
		}
	}

	if( !class_exists('frmaster_pb_element_cause_donation') ){
		class frmaster_pb_element_cause_donation{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-newspaper-o',
					'title' => esc_html__('Cause Donation', 'frmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return apply_filters('frmaster_cause_donation_item_options', array(					
					'general' => array(
						'title' => esc_html__('General', 'frmaster'),
						'options' => array(
							'cause-id' => array(
								'title' => esc_html__('Select Cause', 'frmaster'),
								'type' => 'combobox',
								'options' => frmaster_get_post_list('cause')
							),
							'donation-amount-1' => array(
								'title' => esc_html__('Donation Amount 1', 'frmaster'),
								'type' => 'text',
								'default' => '10'
							),
							'donation-amount-2' => array(
								'title' => esc_html__('Donation Amount 2', 'frmaster'),
								'type' => 'text',
								'default' => '25'
							),
							'donation-amount-3' => array(
								'title' => esc_html__('Donation Amount 3', 'frmaster'),
								'type' => 'text',
								'default' => '50'
							),
							'donation-amount-4' => array(
								'title' => esc_html__('Donation Amount 4', 'frmaster'),
								'type' => 'text',
								'default' => '100'
							),
						),
					),
					'settings' => array(
						'title' => esc_html__('Cause Style', 'frmaster'),
						'options' => array(
							'form-color' => array(
								'title' => esc_html__('Form Color', 'frmaster'),
								'type' => 'colorpicker'
							),
							'active-color' => array(
								'title' => esc_html__('Active Color', 'frmaster'),
								'type' => 'colorpicker'
							),
						),
					),
					'spacing' => array(
						'title' => esc_html__('Frame / Spacing', 'frmaster'),
						'options' => array(
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
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'donation-amount-1' => '10', 'donation-amount-2' => '25',
						'donation-amount-3' => '50', 'donation-amount-4' => '100',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$custom_style  = '';
				if( !empty($settings['form-color']) ){
					$custom_style .= '#custom_style_id .frmaster-cause-donation-form .frmaster-cause-donation-form-button, #custom_style_id .frmaster-cause-donation-form input[type="text"]{ border-color: ' . $settings['form-color'] . '; color: ' . $settings['form-color'] . '; }';
				}
				if( !empty($settings['active-color']) ){
					$custom_style .= '#custom_style_id .frmaster-cause-donation-form .frmaster-cause-donation-form-button.frmaster-active{ color: #fff; background-color: ' . $settings['active-color'] . '; border-color: ' . $settings['active-color'] . '; }';
				}
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $frmaster_cause_donation_id;
						$frmaster_cause_donation_id = empty($frmaster_cause_donation_id)? array(): $frmaster_cause_donation_id;

						// generate unique id so it does not get overwritten in admin area
						$rnd_cause_donation_id = mt_rand(0, 99999);
						while( in_array($rnd_cause_donation_id, $frmaster_cause_donation_id) ){
							$rnd_cause_donation_id = mt_rand(0, 99999);
						}
						$frmaster_cause_donation_id[] = $rnd_cause_donation_id;
						$settings['id'] = 'frmaster-cause-donation-' . $rnd_cause_donation_id;
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
				$ret  = '<div class="frmaster-cause-donation-item gdlr-core-item-pdb gdlr-core-item-pdlr clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= frmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				$ret .= '<' . (($preview)? 'div': 'form') .' class="frmaster-cause-donation-form" method="get" action="' . esc_attr(frmaster_get_template_url('payment')) . '" >';
				$ret .= '<input type="hidden" name="cause_id" value="' . esc_attr($settings['cause-id']) . '" />';
				for( $i=1; $i<=4; $i++ ){
					$ret .= '<div class="frmaster-cause-donation-form-button ' . ($i==1? 'frmaster-active': '') . '" ';
					$ret .= ' data-value="' . esc_attr($settings['donation-amount-' . $i]) . '" ';
					$ret .= ' >' . frmaster_money_format($settings['donation-amount-' . $i], -2) . '</div>';
				}
				$ret .= '<input type="text" class="frmaster-cause-donation-form-custom" placeholder="' . esc_html__('Other Amount (USD)', 'frmaster') . '" />';
				$ret .= '<input type="hidden" name="donation-amount" value="' . esc_attr($settings['donation-amount-1']) . '" />';
				$ret .= '<div class="clear" ></div>';
				$ret .= '<input type="submit" value="' . esc_html__('Donate Now', 'frmaster') . '" />';
				$ret .= '</' . (($preview)? 'div': 'form') .'>';
				$ret .= '</div>'; // frmaster-cause-item
				$ret .= $custom_style;
				
				return $ret;
			}			
			
		} // frmaster_pb_element_cause_donation
	} // class_exists	