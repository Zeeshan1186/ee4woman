<?php
	/*	
	*	Utility function for uses
	*/

	if( !function_exists('frmaster_get_country_list') ){
		function frmaster_get_country_list( $with_none = false, $single = '' ){
			$ret = array(
				'Afghanistan' => esc_html__('Afghanistan', 'frmaster'),
				'Albania' => esc_html__('Albania', 'frmaster'),
				'Algeria' => esc_html__('Algeria', 'frmaster'),
				'Andorra' => esc_html__('Andorra', 'frmaster'),
				'Angola' => esc_html__('Angola', 'frmaster'),
				'Antigua and Barbuda' => esc_html__('Antigua and Barbuda', 'frmaster'),
				'Argentina' => esc_html__('Argentina', 'frmaster'),
				'Armenia' => esc_html__('Armenia', 'frmaster'),
				'Australia' => esc_html__('Australia', 'frmaster'),
				'Austria' => esc_html__('Austria', 'frmaster'),
				'Azerbaijan' => esc_html__('Azerbaijan', 'frmaster'),
				'Bahamas' => esc_html__('Bahamas', 'frmaster'),
				'Bahrain' => esc_html__('Bahrain', 'frmaster'),
				'Bangladesh' => esc_html__('Bangladesh', 'frmaster'),
				'Barbados' => esc_html__('Barbados', 'frmaster'),
				'Belarus' => esc_html__('Belarus', 'frmaster'),
				'Belgium' => esc_html__('Belgium', 'frmaster'),
				'Belize' => esc_html__('Belize', 'frmaster'),
				'Benin' => esc_html__('Benin', 'frmaster'),
				'Bhutan' => esc_html__('Bhutan', 'frmaster'),
				'Bolivia' => esc_html__('Bolivia', 'frmaster'),
				'Bosnia and Herzegovina' => esc_html__('Bosnia and Herzegovina', 'frmaster'),
				'Botswana' => esc_html__('Botswana', 'frmaster'),
				'Brazil' => esc_html__('Brazil', 'frmaster'),
				'Brunei' => esc_html__('Brunei', 'frmaster'),
				'Bulgaria' => esc_html__('Bulgaria', 'frmaster'),
				'Burkina Faso' => esc_html__('Burkina Faso', 'frmaster'),
				'Burundi' => esc_html__('Burundi', 'frmaster'),
				'Cabo Verde' => esc_html__('Cabo Verde', 'frmaster'),
				'Cambodia' => esc_html__('Cambodia', 'frmaster'),
				'Cameroon' => esc_html__('Cameroon', 'frmaster'),
				'Canada' => esc_html__('Canada', 'frmaster'),
				'Central African Republic (CAR)' => esc_html__('Central African Republic (CAR)', 'frmaster'),
				'Chad' => esc_html__('Chad', 'frmaster'),
				'Chile' => esc_html__('Chile', 'frmaster'),
				'China' => esc_html__('China', 'frmaster'),
				'Colombia' => esc_html__('Colombia', 'frmaster'),
				'Comoros' => esc_html__('Comoros', 'frmaster'),
				'Democratic Republic of the Congo' => esc_html__('Democratic Republic of the Congo', 'frmaster'),
				'Republic of the Congo' => esc_html__('Republic of the Congo', 'frmaster'),
				'Costa Rica' => esc_html__('Costa Rica', 'frmaster'),
				'Cote d\'Ivoire' => esc_html__('Cote d\'Ivoire', 'frmaster'),
				'Croatia' => esc_html__('Croatia', 'frmaster'),
				'Cuba' => esc_html__('Cuba', 'frmaster'),
				'Cyprus' => esc_html__('Cyprus', 'frmaster'),
				'Czech Republic' => esc_html__('Czech Republic', 'frmaster'),
				'Denmark' => esc_html__('Denmark', 'frmaster'),
				'Djibouti' => esc_html__('Djibouti', 'frmaster'),
				'Dominica' => esc_html__('Dominica', 'frmaster'),
				'Dominican Republic' => esc_html__('Dominican Republic', 'frmaster'),
				'Ecuador' => esc_html__('Ecuador', 'frmaster'),
				'Egypt' => esc_html__('Egypt', 'frmaster'),
				'El Salvador' => esc_html__('El Salvador', 'frmaster'),
				'Equatorial Guinea' => esc_html__('Equatorial Guinea', 'frmaster'),
				'Eritrea' => esc_html__('Eritrea', 'frmaster'),
				'Estonia' => esc_html__('Estonia', 'frmaster'),
				'Ethiopia' => esc_html__('Ethiopia', 'frmaster'),
				'Fiji' => esc_html__('Fiji', 'frmaster'),
				'Finland' => esc_html__('Finland', 'frmaster'),
				'France' => esc_html__('France', 'frmaster'),
				'Gabon' => esc_html__('Gabon', 'frmaster'),
				'Gambia' => esc_html__('Gambia', 'frmaster'),
				'Georgia' => esc_html__('Georgia', 'frmaster'),
				'Germany' => esc_html__('Germany', 'frmaster'),
				'Ghana' => esc_html__('Ghana', 'frmaster'),
				'Greece' => esc_html__('Greece', 'frmaster'),
				'Grenada' => esc_html__('Grenada', 'frmaster'),
				'Guatemala' => esc_html__('Guatemala', 'frmaster'),
				'Guinea' => esc_html__('Guinea', 'frmaster'),
				'Guinea-Bissau' => esc_html__('Guinea-Bissau', 'frmaster'),
				'Guyana' => esc_html__('Guyana', 'frmaster'),
				'Haiti' => esc_html__('Haiti', 'frmaster'),
				'Honduras' => esc_html__('Honduras', 'frmaster'),
				'Hungary' => esc_html__('Hungary', 'frmaster'),
				'Iceland' => esc_html__('Iceland', 'frmaster'),
				'India' => esc_html__('India', 'frmaster'),
				'Indonesia' => esc_html__('Indonesia', 'frmaster'),
				'Iran' => esc_html__('Iran', 'frmaster'),
				'Iraq' => esc_html__('Iraq', 'frmaster'),
				'Ireland' => esc_html__('Ireland', 'frmaster'),
				'Israel' => esc_html__('Israel', 'frmaster'),
				'Italy' => esc_html__('Italy', 'frmaster'),
				'Jamaica' => esc_html__('Jamaica', 'frmaster'),
				'Japan' => esc_html__('Japan', 'frmaster'),
				'Jordan' => esc_html__('Jordan', 'frmaster'),
				'Kazakhstan' => esc_html__('Kazakhstan', 'frmaster'),
				'Kenya' => esc_html__('Kenya', 'frmaster'),
				'Kiribati' => esc_html__('Kiribati', 'frmaster'),
				'Kosovo' => esc_html__('Kosovo', 'frmaster'),
				'Kuwait' => esc_html__('Kuwait', 'frmaster'),
				'Kyrgyzstan' => esc_html__('Kyrgyzstan', 'frmaster'),
				'Laos' => esc_html__('Laos', 'frmaster'),
				'Latvia' => esc_html__('Latvia', 'frmaster'),
				'Lebanon' => esc_html__('Lebanon', 'frmaster'),
				'Lesotho' => esc_html__('Lesotho', 'frmaster'),
				'Liberia' => esc_html__('Liberia', 'frmaster'),
				'Libya' => esc_html__('Libya', 'frmaster'),
				'Liechtenstein' => esc_html__('Liechtenstein', 'frmaster'),
				'Lithuania' => esc_html__('Lithuania', 'frmaster'),
				'Luxembourg' => esc_html__('Luxembourg', 'frmaster'),
				'Macedonia' => esc_html__('Macedonia', 'frmaster'),
				'Madagascar' => esc_html__('Madagascar', 'frmaster'),
				'Malawi' => esc_html__('Malawi', 'frmaster'),
				'Malaysia' => esc_html__('Malaysia', 'frmaster'),
				'Maldives' => esc_html__('Maldives', 'frmaster'),
				'Mali' => esc_html__('Mali', 'frmaster'),
				'Malta' => esc_html__('Malta', 'frmaster'),
				'Marshall Islands' => esc_html__('Marshall Islands', 'frmaster'),
				'Mauritania' => esc_html__('Mauritania', 'frmaster'),
				'Mauritius' => esc_html__('Mauritius', 'frmaster'),
				'Mexico' => esc_html__('Mexico', 'frmaster'),
				'Micronesia' => esc_html__('Micronesia', 'frmaster'),
				'Moldova' => esc_html__('Moldova', 'frmaster'),
				'Monaco' => esc_html__('Monaco', 'frmaster'),
				'Mongolia' => esc_html__('Mongolia', 'frmaster'),
				'Montenegro' => esc_html__('Montenegro', 'frmaster'),
				'Morocco' => esc_html__('Morocco', 'frmaster'),
				'Mozambique' => esc_html__('Mozambique', 'frmaster'),
				'Myanmar (Burma)' => esc_html__('Myanmar (Burma)', 'frmaster'),
				'Namibia' => esc_html__('Namibia', 'frmaster'),
				'Nauru' => esc_html__('Nauru', 'frmaster'),
				'Nepal' => esc_html__('Nepal', 'frmaster'),
				'Netherlands' => esc_html__('Netherlands', 'frmaster'),
				'New Zealand' => esc_html__('New Zealand', 'frmaster'),
				'Nicaragua' => esc_html__('Nicaragua', 'frmaster'),
				'Niger' => esc_html__('Niger', 'frmaster'),
				'Nigeria' => esc_html__('Nigeria', 'frmaster'),
				'North Korea' => esc_html__('North Korea', 'frmaster'),
				'Norway' => esc_html__('Norway', 'frmaster'),
				'Oman' => esc_html__('Oman', 'frmaster'),
				'Pakistan' => esc_html__('Pakistan', 'frmaster'),
				'Palau' => esc_html__('Palau', 'frmaster'),
				'Palestine' => esc_html__('Palestine', 'frmaster'),
				'Panama' => esc_html__('Panama', 'frmaster'),
				'Papua New Guinea' => esc_html__('Papua New Guinea', 'frmaster'),
				'Paraguay' => esc_html__('Paraguay', 'frmaster'),
				'Peru' => esc_html__('Peru', 'frmaster'),
				'Philippines' => esc_html__('Philippines', 'frmaster'),
				'Poland' => esc_html__('Poland', 'frmaster'),
				'Portugal' => esc_html__('Portugal', 'frmaster'),
				'Puerto Rico' => esc_html__('Puerto Rico', 'frmaster'),
				'Qatar' => esc_html__('Qatar', 'frmaster'),
				'Romania' => esc_html__('Romania', 'frmaster'),
				'Russia' => esc_html__('Russia', 'frmaster'),
				'Rwanda' => esc_html__('Rwanda', 'frmaster'),
				'Saint Kitts and Nevis' => esc_html__('Saint Kitts and Nevis', 'frmaster'),
				'Saint Lucia' => esc_html__('Saint Lucia', 'frmaster'),
				'Saint Vincent and the Grenadines' => esc_html__('Saint Vincent and the Grenadines', 'frmaster'),
				'Samoa' => esc_html__('Samoa', 'frmaster'),
				'San Marino' => esc_html__('San Marino', 'frmaster'),
				'Sao Tome and Principe' => esc_html__('Sao Tome and Principe', 'frmaster'),
				'Saudi Arabia' => esc_html__('Saudi Arabia', 'frmaster'),
				'Senegal' => esc_html__('Senegal', 'frmaster'),
				'Serbia' => esc_html__('Serbia', 'frmaster'),
				'Seychelles' => esc_html__('Seychelles', 'frmaster'),
				'Sierra Leone' => esc_html__('Sierra Leone', 'frmaster'),
				'Singapore' => esc_html__('Singapore', 'frmaster'),
				'Slovakia' => esc_html__('Slovakia', 'frmaster'),
				'Slovenia' => esc_html__('Slovenia', 'frmaster'),
				'Solomon Islands' => esc_html__('Solomon Islands', 'frmaster'),
				'Somalia' => esc_html__('Somalia', 'frmaster'),
				'South Africa' => esc_html__('South Africa', 'frmaster'),
				'South Korea' => esc_html__('South Korea', 'frmaster'),
				'South Sudan' => esc_html__('South Sudan', 'frmaster'),
				'Spain' => esc_html__('Spain', 'frmaster'),
				'Sri Lanka' => esc_html__('Sri Lanka', 'frmaster'),
				'Sudan' => esc_html__('Sudan', 'frmaster'),
				'Suriname' => esc_html__('Suriname', 'frmaster'),
				'Swaziland' => esc_html__('Swaziland', 'frmaster'),
				'Sweden' => esc_html__('Sweden', 'frmaster'),
				'Switzerland' => esc_html__('Switzerland', 'frmaster'),
				'Syria' => esc_html__('Syria', 'frmaster'),
				'Taiwan' => esc_html__('Taiwan', 'frmaster'),
				'Tajikistan' => esc_html__('Tajikistan', 'frmaster'),
				'Tanzania' => esc_html__('Tanzania', 'frmaster'),
				'Thailand' => esc_html__('Thailand', 'frmaster'),
				'Timor-Leste' => esc_html__('Timor-Leste', 'frmaster'),
				'Togo' => esc_html__('Togo', 'frmaster'),
				'Tonga' => esc_html__('Tonga', 'frmaster'),
				'Trinidad and Tobago' => esc_html__('Trinidad and Tobago', 'frmaster'),
				'Tunisia' => esc_html__('Tunisia', 'frmaster'),
				'Turkey' => esc_html__('Turkey', 'frmaster'),
				'Turkmenistan' => esc_html__('Turkmenistan', 'frmaster'),
				'Tuvalu' => esc_html__('Tuvalu', 'frmaster'),
				'Uganda' => esc_html__('Uganda', 'frmaster'),
				'Ukraine' => esc_html__('Ukraine', 'frmaster'),
				'United Arab Emirates (UAE)' => esc_html__('United Arab Emirates (UAE)', 'frmaster'),
				'United Kingdom (UK)' => esc_html__('United Kingdom (UK)', 'frmaster'),
				'United States of America (USA)' => esc_html__('United States of America (USA)', 'frmaster'),
				'Uruguay' => esc_html__('Uruguay', 'frmaster'),
				'Uzbekistan' => esc_html__('Uzbekistan', 'frmaster'),
				'Vanuatu' => esc_html__('Vanuatu', 'frmaster'),
				'Vatican City (Holy See)' => esc_html__('Vatican City (Holy See)', 'frmaster'),
				'Venezuela' => esc_html__('Venezuela', 'frmaster'),
				'Vietnam' => esc_html__('Vietnam', 'frmaster'),
				'Yemen' => esc_html__('Yemen', 'frmaster'),
				'Zambia' => esc_html__('Zambia', 'frmaster'),
				'Zimbabwe' => esc_html__('Zimbabwe', 'frmaster')
			);

			if( $with_none ){
				$ret = array( '' => esc_html__('None', 'frmaster') ) + $ret;
			} 

			if( !empty($single) && !empty($ret[$single]) ){
				return $ret[$single];
			}

			return $ret;
		}
	}

	if( !function_exists('frmaster_user_content_block_start') ){
		function frmaster_user_content_block_start( $settings = array() ){
			echo '<div class="frmaster-user-content-block" >';
			if( !empty($settings['title']) ){
				echo '<div class="frmaster-user-content-title-wrap" >';
				echo '<h3 class="frmaster-user-content-title">' . $settings['title'] . '</h3>';
				
				if( !empty($settings['title-link']) ){
					echo '<a class="frmaster-user-content-title-link" href="' . esc_url($settings['title-link']) . '" >';
					echo $settings['title-link-text'];
					echo '</a>';
				}
				echo '</div>'; // frmaster-user-content-title-wrap

				echo '<div class="frmaster-user-content-block-content" >';
			}
			
		} // frmaster_user_content_block_start
	}

	if( !function_exists('frmaster_update_profile_avatar') ){
		function frmaster_update_profile_avatar(){
			
			// upload the file
			if( !empty($_FILES['profile-image']['size']) ){
				if ( !function_exists('wp_handle_upload') ) {
				    require_once(ABSPATH . 'wp-admin/includes/file.php');
				}
				add_filter('upload_dir', 'frmaster_set_avatar_upload_folder');
				$uploaded_file = wp_handle_upload($_FILES['profile-image'], array('test_form' => false));
				remove_filter('upload_dir', 'frmaster_set_avatar_upload_folder');
			}

			// upload error
			if( !empty($uploaded_file) && empty($uploaded_file['error']) ){
				$avatar = array();
				$avatar['local_url'] = $uploaded_file['file'];
				$avatar['file_url'] = $uploaded_file['url'];

				$cropped_image = wp_get_image_editor($avatar['local_url']);
				if( !is_wp_error($cropped_image) ) {
					$orig_info = pathinfo($avatar['local_url']);
					$dir = $orig_info['dirname'];
					$ext = $orig_info['extension'];	
					$name = wp_basename($avatar['local_url'], ".{$ext}");
					$destfilename = "{$dir}/{$name}-150x150.{$ext}";

					$cropped_image->resize(150, 150, true);
					$cropped_image->save($destfilename);
					$avatar['thumbnail'] = str_replace($name, $name . '-150x150', $avatar['file_url']);
				}

				global $current_user;
				$user_id = $current_user->ID;
				update_user_meta($user_id, 'frmaster-user-avatar', $avatar);
			}

		} // frmaster_update_profile_avatar
	}

	if( !function_exists('frmaster_user_update_notification') ){
		function frmaster_user_update_notification( $content, $success = true ){

			echo '<div class="frmaster-user-update-notification frmaster-' . ($success? 'success': 'failure') . '" >';
			if( $success ){
				echo '<i class="fa fa-check" ></i>';
			}else if( $success == 'fail' ){
				echo '<i class="fa fa-remove" ></i>';
			}
			echo $content;
			echo '</div>';

		} // frmaster_user_update_notification
	}

	if( !function_exists('frmaster_user_content_block_end') ){
		function frmaster_user_content_block_end(){

			echo '</div>'; // frmaster-user-content-block-content
			echo '</div>'; // frmaster-user-content-block

		} // frmaster_user_content_block_end
	}

	if( !function_exists('frmaster_get_user_meta') ){
		function frmaster_get_user_meta( $user_id = null, $type = 'full_name', $default = ''){

			if( $type == 'full_name' ){
				$name  = get_the_author_meta('first_name', $user_id);
				if( !empty($name) ){
					$name .= ' ' . get_the_author_meta('last_name', $user_id);
				}else{
					$name  = get_the_author_meta('display_name', $user_id);
				}

				if( !empty($name) ){
					return $name;
				}
			}else{
				$user_meta = get_the_author_meta($type, $user_id);

				if( !empty($user_meta) ){
					return $user_meta;
				}
			}

			return $default;

		} // frmaster_get_user_meta
	}	

	if( !function_exists('frmaster_validate_profile_field') ){
		function frmaster_validate_profile_field( $fields ){

			$error = new WP_ERROR();

			foreach( $fields as $slug => $field ){
				if( !empty($field['required']) && empty($_POST[$slug]) && empty($error_message) ){
					$error->add('1', sprintf(esc_html__('Please fill all required fields (%s).', 'frmaster'), $field['title']));
				}

				if( !empty($field['type']) && $field['type'] == 'email' && !is_email($_POST[$slug]) ){
					$error->add('2', esc_html__('Incorrect email address.', 'frmaster'));
				}

				if( !empty($_POST[$slug]) && $field['type'] != 'email' ){
					if( preg_match('/[£^$%&*}{@#~?><|=+]/', $_POST[$slug]) ){
						$error->add('3', sprintf(esc_html__('Special characters is not allowed in "%s".', 'frmaster'), $field['title']));
					}
				}
			}

			$error_message = $error->get_error_message();
			if( !empty($error_message) ){
				return $error;
			}else{
				return true;
			}

		} // frmaster_validate_profile_field
	}

	if( !function_exists('frmaster_update_profile_field') ){
		function frmaster_update_profile_field( $fields, $user_id = '' ){
			global $current_user;

			if( empty($user_id) ){
				$user_id = $current_user->ID;
			}

			foreach( $fields as $slug => $field ){
				if( $slug == 'email' ){
					if( !empty($_POST['email']) ){
			        	wp_update_user(array(
			                'ID' => $user_id,
			                'user_email' => $_POST['email']
			            ));
			        }
				}else{
					$value = empty($_POST[$slug])? '': $_POST[$slug];
					update_user_meta($user_id, $slug, $value);
				}
			}

		} // frmaster_update_profile_field
	}

	if( !function_exists('frmaster_get_profile_fields') ){
		function frmaster_get_profile_fields(){
			return apply_filters('frmaster_profile_fields', array(
				'first_name' => array(
					'title' => esc_html__('First Name', 'frmaster'),
					'type' => 'text',
					'required' => true
				),
				'last_name' => array(
					'title' => esc_html__('Last Name', 'frmaster'),
					'type' => 'text',
					'required' => true
				),
				'email' => array(
					'title' => esc_html__('Email', 'frmaster'),
					'type' => 'email',
					'required' => true
				),
				'phone' => array(
					'title' => esc_html__('Phone', 'frmaster'),
					'type' => 'text',
					'required' => true
				),
				'contact_address' => array(
					'title' => esc_html__('Contact Address', 'frmaster'),
					'type' => 'textarea'
				),
				'country' => array(
					'title' => esc_html__('Country', 'frmaster'),
					'type' => 'combobox',
					'options' => frmaster_get_country_list(),
					'required' => true,
					'default' => frmaster_get_option('general', 'user-default-country', '')
				),
			));
		}
	}	

	// user nav list
	if( !function_exists('frmaster_get_user_nav_list') ){
		function frmaster_get_user_nav_list(){
			return apply_filters('frmaster_user_nav_list', array(
				'my-account-title' => array(
					'type' => 'title',
					'title' => esc_html__('My Account', 'frmaster')
				),
				'dashboard' => array(
					'title' => esc_html__('Dashboard', 'frmaster'),
					'icon' => 'fa fa-dashboard',
					'top-bar' => true,
				),
				'edit-profile' => array(
					'title' => esc_html__('Edit Profile', 'frmaster'),
					'icon' => 'fa fa-edit',
				),
				'change-password' => array(
					'title' => esc_html__('Change Password', 'frmaster'),
					'icon' => 'fa fa-unlock-alt'
				),
				'contribution-title' => array(
					'type' => 'title',
					'title' => esc_html__('Contributions', 'frmaster')
				),
				'my-contribution' => array(
					'title' => esc_html__('My Contributions', 'frmaster'),
					'icon' => 'icon_document',
					'top-bar' => true,
				),
				'following' => array(
					'title' => esc_html__('Following', 'frmaster'),
					'icon' => 'fa fa-heart-o',
					'top-bar' => true,
				),
				'receipts' => array(
					'title' => esc_html__('Receipts', 'frmaster'),
					'icon' => 'icon_wallet'
				),
				'sign-out' => array(
					'title' => esc_html__('Sign Out', 'frmaster'),
					'icon' => 'icon_lock-open_alt',
					'link' => wp_logout_url( home_url('/') ),
					'top-bar' => true,
				),
			));
		}
	}

	// user page breadcrumbs
	if( !function_exists('frmaster_get_user_breadcrumb') ){
		function frmaster_get_user_breadcrumb(){

			$main_page = empty($_GET['page_type'])? 'dashboard': $_GET['page_type'];
			$sub_page = empty($_GET['sub_page'])? '': $_GET['sub_page'];
			$nav_list = frmaster_get_user_nav_list();

			echo '<div class="frmaster-user-breadcrumbs" >';

			// dashboard
			if( !empty($nav_list['dashboard']['title']) ){
				$page_link = frmaster_get_template_url('user', array('page_type'=>'dashboard'));

				echo '<a class="frmaster-user-breadcrumbs-item ' . (($main_page == 'dashboard')? 'frmaster-active': '') . '" href="' . esc_url($page_link) . '" >';
				echo $nav_list['dashboard']['title'];
				echo '</a>';

				if( $main_page != 'dashboard' ){
					echo '<span class="frmaster-sep" >></span>';
				}
			}

			// main navigation
			if( $main_page != 'dashboard' ){
				if( !empty($nav_list[$main_page]['title']) ){
					$main_nav_title = $nav_list[$main_page]['title'];
				}else{
					$main_nav_title = $main_page;
				}

				if( empty($sub_page) ){
					echo '<span class="frmaster-user-breadcrumbs-item frmaster-active" >' . $main_nav_title . '</span>';
				}else{
					$page_link = frmaster_get_template_url('user', array('page_type'=>$main_page));
					echo '<a class="frmaster-user-breadcrumbs-item" href="' . $page_link . '" >' . $main_nav_title . '</a>';
					echo '<span class="frmaster-sep" >></span>';
				}	
			}

			// sub navigation
			if( !empty($sub_page) ){
				if( !empty($_GET['cause_id']) ){
					$sub_nav_title = get_the_title($_GET['cause_id']);
				}else{
					$sub_nav_title = $sub_page;
				}

				echo '<span class="frmaster-user-breadcrumbs-item frmaster-active" >' . $sub_nav_title . '</span>';
			}

			echo '</div>';

		} // frmaster_get_user_breadcrumb
	}		

	// for user top bar
	if( !function_exists('frmaster_user_top_bar') ){
		function frmaster_user_top_bar(){
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
			if( $enable_membership == 'disable' ){
				return;
			}

			if( is_user_logged_in() ){
				global $current_user;
				$avatar = get_the_author_meta('frmaster-user-avatar', $current_user->data->ID);

				$ret  = '<div class="frmaster-user-top-bar frmaster-user" id="frmaster-user-top-bar" data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" >';
				if( !empty($avatar['thumbnail']) ){
					$ret .= '<img src="' . esc_url($avatar['thumbnail']) . '" alt="profile-image" />';
				}else if( !empty($avatar['file_url']) ){
					$ret .= '<img src="' . esc_url($avatar['file_url']) . '" alt="profile-image" />';
				}else{
					$ret .= get_avatar($current_user->data->ID, 30);
				}	
				$ret .= '<span class="frmaster-user-top-bar-name" >' . frmaster_get_user_meta($current_user->data->ID, 'full_name') . '</span>';
				$ret .= '<i class="fa fa-sort-down" ></i>';

				$nav_list = frmaster_get_user_nav_list();
				$user_page = frmaster_get_template_url('user');
				$ret .= '<div class="frmaster-user-top-bar-nav" >';
				$ret .= '<div class="frmaster-user-top-bar-nav-inner" >';
				foreach( $nav_list as $nav_slug => $nav ){
					if( !empty($nav['top-bar']) && !empty($nav['title']) ){
						$nav_link = empty($nav['link'])? add_query_arg(array('page_type'=>$nav_slug), $user_page): $nav['link'];

						$ret .= '<div class="frmaster-user-top-bar-nav-item frmaster-nav-' . esc_attr($nav_slug) . '" >';
						$ret .= '<a href="' . esc_url($nav_link) . '" >' . $nav['title'] . '</a>';
						$ret .= '</div>';
					}
				}
				$ret .= '</div>'; // frmaster-user-top-bar-nav-inner
				$ret .= '</div>'; // frmaster-user-top-bar-nav
				$ret .= '</div>'; // frmaster-user-top-bar
			}else{

				$recaptcha = frmaster_get_option('general', 'enable-recaptcha', 'disable');

				if( $recaptcha == 'enable' ){
					$login_url = frmaster_get_template_url('login');
					$register_url = frmaster_get_template_url('register');

					$ret  = '<div class="frmaster-user-top-bar frmaster-guest" id="frmaster-user-top-bar" data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" >';
					$ret .= '<a class="frmaster-user-top-bar-login" href="' . esc_url($login_url) . '" >';
					$ret .= '<i class="icon_lock_alt" ></i>';
					$ret .= '<span class="frmaster-text" >' . esc_html__('Login', 'frmaster') . '</span>';
					$ret .= '</a>';
					$ret .= '<a class="frmaster-user-top-bar-signup" href="' . esc_url($register_url) . '" >';
					$ret .= '<i class="fa fa-user" ></i>';
					$ret .= '<span class="frmaster-text" >' . esc_html__('Sign Up', 'frmaster') . '</span>';
					$ret .= '</a>';
					$ret .= '</div>';

				}else{

					$mobile_login_link = frmaster_get_option('general', 'mobile-login-link', 'disable');
					$mobile_login_link = ($mobile_login_link == 'enable')? true: false;

					$ret  = '<div class="frmaster-user-top-bar frmaster-guest" id="frmaster-user-top-bar" data-ajax-url="' . esc_attr(FRMASTER_AJAX_URL) . '" >';
					$ret .= '<span class="frmaster-user-top-bar-login ';
					$ret .= ($mobile_login_link)? 'frmaster-hide-on-mobile': '';
					$ret .= '" data-frmlb="login" >';
					$ret .= '<i class="icon_lock_alt" ></i>';
					$ret .= '<span class="frmaster-text" >' . esc_html__('Login', 'frmaster') . '</span>';
					$ret .= '</span>';
					$ret .= frmaster_lightbox_content(array(
						'id' => 'login',
						'title' => esc_html__('Login', 'frmaster'),
						'content' => frmaster_get_login_form(false)
					));
					$ret .= '<span class="frmaster-user-top-bar-signup ';
					$ret .= ($mobile_login_link)? 'frmaster-hide-on-mobile': '';
					$ret .= '" data-frmlb="signup" >';
					$ret .= '<i class="fa fa-user" ></i>';
					$ret .= '<span class="frmaster-text" >' . esc_html__('Sign Up', 'frmaster') . '</span>';
					$ret .= '</span>';
					$ret .= frmaster_lightbox_content(array(
						'id' => 'signup',
						'title' => esc_html__('Sign Up', 'frmaster'),
						'content' => frmaster_get_registration_form(false)
					));

					if( $mobile_login_link ){
						$login_url = frmaster_get_template_url('login');
						$ret .= '<a class="frmaster-user-top-bar-login frmaster-show-on-mobile" href="' . esc_url($login_url) . '" >';
						$ret .= '<i class="icon_lock_alt" ></i>';
						$ret .= '<span class="frmaster-text" >' . esc_html__('Login', 'frmaster') . '</span>';
						$ret .= '</a>';

						$register_url = frmaster_get_template_url('register');
						$ret .= '<a class="frmaster-user-top-bar-signup frmaster-show-on-mobile" href="' . esc_url($register_url) . '" >';
						$ret .= '<i class="fa fa-user" ></i>';
						$ret .= '<span class="frmaster-text" >' . esc_html__('Sign Up', 'frmaster') . '</span>';
						$ret .= '</a>';
					}
					$ret .= '</div>'; 

				}

			}
			
			return $ret;
		}
	}
	add_action('wp_ajax_refresh_user_top_bar', 'frmaster_refresh_user_top_bar');
	add_action('wp_ajax_nopriv_refresh_user_top_bar', 'frmaster_refresh_user_top_bar');
	if( !function_exists('frmaster_refresh_user_top_bar') ){
		function frmaster_refresh_user_top_bar($atts){
			$ret = array();
			$ret['content'] = frmaster_user_top_bar();

			die(json_encode($ret));
		}
	}

	add_shortcode('frmaster_login_bar', 'frmaster_user_top_bar_shortcode');
	if( !function_exists('frmaster_user_top_bar_shortcode') ){
		function frmaster_user_top_bar_shortcode($atts){
			$atts = wp_parse_args($atts, array());

			$ret  = '<div class="frmaster-login-bar-shortcode clearfix" >';
			$ret .= frmaster_user_top_bar();
			$ret .= '</div>';

			return $ret;
		}
	}

	// login form
	if( !function_exists('frmaster_get_login_form') ){
		function frmaster_get_login_form( $echo = true, $settings = array() ){

			$settings = wp_parse_args($settings, array(
				'label' => true,
				'placeholder' => false,
				'forget-password' => true,
				'register' => true,
				'login-form-action' => '1'
			));

			if( !$echo ){
				ob_start();
			}
?>
<form class="frmaster-login-form frmaster-form-field frmaster-with-border" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
	<div class="frmaster-login-form-fields clearfix" >
		<p class="frmaster-login-user">
			<?php echo $settings['label']? '<label>' . esc_html__('Username or E-Mail', 'frmaster') . '</label>': ''; ?>
			<input type="text" name="log" <?php echo $settings['placeholder']? 'placeholder="' . esc_html__('Email*', 'frmaster') . '" ': ''; ?> />
		</p>
		<p class="frmaster-login-pass">
			 <?php echo $settings['label']? '<label>' . esc_html__('Password', 'frmaster') . '</label>': ''; ?>
			 <input type="password" name="pwd" <?php echo $settings['placeholder']? 'placeholder="' . esc_html__('Password*', 'frmaster') . '" ': ''; ?> />
		</p>
	</div>
	<?php if( $settings['login-form-action'] == '1' ){ do_action('login_form'); } ?> 
	<p class="frmaster-login-submit" >
		<input type="submit" name="wp-submit" class="frmaster-button" value="<?php echo esc_html__('Sign In!', 'frmaster'); ?>" />
	</p>
	<?php if( $settings['login-form-action'] == '2' ){ do_action('login_form'); } ?> 
	<?php if( $settings['forget-password']){ ?>
	<p class="frmaster-login-lost-password" >
		<a href="<?php echo add_query_arg(array(
			'source'=>'tm', 
			'lang'=>(defined('ICL_LANGUAGE_CODE')? ICL_LANGUAGE_CODE: '')
		), wp_lostpassword_url()); ?>" ><?php echo esc_html__('Forget Password?','frmaster'); ?></a>
	</p>
	<?php } ?>

	<input type="hidden" name="rememberme"  value="forever" />
	<input type="hidden" name="redirect_to" value="<?php 
		if( !empty($_GET['redirect']) ){
			if( is_numeric($_GET['redirect']) ){
				$redirect_url = get_permalink($_GET['redirect']);
			}else{
				$redirect_url = frmaster_get_template_url($_GET['redirect']);
				$redirect_url = empty($redirect_url)? $_GET['redirect']: $redirect_url;
			}

			echo esc_url($redirect_url);
		}else{
			echo esc_url(add_query_arg(null, null));
		}
	?>" />
	<input type="hidden" name="redirect" value="<?php echo empty($_GET['redirect'])? '': esc_attr($_GET['redirect']); ?>" />
	<input type="hidden" name="source"  value="tm" />
</form>
<?php if( $settings['register'] ){ ?>
<div class="frmaster-login-bottom" >
	<h3 class="frmaster-login-bottom-title" ><?php echo esc_html__('Do not have an account?', 'frmaster'); ?></h3>
	<a class="frmaster-login-bottom-link" href="<?php echo frmaster_get_template_url('register'); ?>" ><?php echo esc_html__('Create an Account', 'frmaster'); ?></a>
</div>
<?php }
			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // frmaster_get_login_form
	}

	// registration form
	if( !function_exists('frmaster_get_registration_form') ){
		function frmaster_get_registration_form( $echo = true, $query_args = array() ){
			if( !$echo ){
				ob_start();
			}

			$profile_fields = array_merge(array(
				'username' => array(
					'title' => esc_html__('Username', 'frmaster'),
					'type' => 'text',
					'required' => true
				),
				'password' => array(
					'title' => esc_html__('Password', 'frmaster'),
					'type' => 'password',
					'required' => true
				),
				'confirm-password' => array(
					'title' => esc_html__('Confirm Password', 'frmaster'),
					'type' => 'password',
					'required' => true
				),
			), frmaster_get_profile_fields());

			$action_url = frmaster_get_template_url('register');
			if( !empty($query_args) ){
				$action_url = add_query_arg($query_args, $action_url);
			}
			echo '<form class="frmaster-register-form frmaster-form-field frmaster-with-border" action="' . esc_url($action_url) . '" method="post" >';

			echo '<div class="frmaster-register-message" >';
			echo esc_html__('After creating an account, you\'ll be able to track your payment status, track the confirmation.', 'frmaster');
			echo '</div>';

			echo '<div class="frmaster-register-form-fields clearfix" >';
			foreach( $profile_fields as $slug => $profile_field ){
				$profile_field['slug'] = $slug;
				frmaster_get_form_field($profile_field, 'profile');
			}
			echo '</div>';

			echo '<input type="hidden" name="redirect" value="';
			if( !empty($_GET['redirect']) ){
				echo esc_attr($_GET['redirect']);
			}else if( !empty($_POST['redirect']) ){
				echo esc_attr($_POST['redirect']);
			}else{
				global $frmaster_template;
				if( empty($frmaster_template) ){
					echo add_query_arg(array());
				}
			}
			echo '" >';
			
			$recaptcha = frmaster_get_option('general', 'enable-recaptcha', 'disable');
			if( $recaptcha == 'enable' ){
				echo apply_filters('gglcptch_display_recaptcha', '', 'registration_form');
			}

			$our_term = frmaster_get_option('general', 'register-term-of-service-page', '#');
			$our_term = is_numeric($our_term)? get_permalink($our_term): $our_term; 
			$privacy = frmaster_get_option('general', 'register-privacy-statement-page', '#');
			$privacy = is_numeric($privacy)? get_permalink($privacy): $privacy; 
			echo '<div class="frmaster-register-term" >';
			echo '<input type="checkbox" name="frmaster-require-acceptance" />';
			echo sprintf(wp_kses(
				__('* Creating an account means you\'re okay with our <a href="%s" target="_blank">Terms of Service</a> and <a href="%s" target="_blank">Privacy Statement</a>.', 'frmaster'), 
				array('a' => array( 'href'=>array(), 'target'=>array() ))
			), $our_term, $privacy);
			echo '<div class="frmaster-notification-box frmaster-failure" >' . esc_html__('Please agree to all the terms and conditions before proceeding to the next step', 'frmaster') . '</div>';
			echo '</div>';
			echo '<input type="submit" class="frmaster-register-submit frmaster-button" value="' . esc_html__('Sign Up', 'frmaster') . '" />';

			if( class_exists('NextendSocialLogin') ){
				echo do_shortcode('[nextend_social_login]');
			}
			echo '<input type="hidden" name="security" value="' . esc_attr(wp_create_nonce('frmaster-registration')) . '" />';
			echo '</form>';

			echo '<div class="frmaster-register-bottom" >';
			echo '<h3 class="frmaster-register-bottom-title" >' . esc_html__('Already a member?', 'frmaster') . '</h3>';
			echo '<a class="frmaster-register-bottom-link" href="' . frmaster_get_template_url('login') . '" >' . esc_html__('Login', 'frmaster') . '</a>';
			echo '</div>';

			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // frmaster_get_registration_form
	}
	if( !function_exists('frmaster_get_donate_registration_form') ){
		function frmaster_get_donate_registration_form( $echo = true ){

			$profile_fields = frmaster_get_profile_fields();

			echo '<form class="frmaster-register-form frmaster-form-field frmaster-with-border" data-slug="register-form" >';
			echo '<h3 class="frmaster-register-form-head" >' . esc_html__('Personal Details', 'frmaster') . '</h3>';

			echo '<div class="frmaster-register-form-fields clearfix" >';
			foreach( $profile_fields as $slug => $profile_field ){
				$profile_field['slug'] = $slug;
				$profile_field['placeholder'] = true;
				$profile_field['label'] = false; 
				frmaster_get_form_field($profile_field, 'profile');
			}
			echo '</div>';
			
			$enable_membership = frmaster_get_option('general', 'enable-membership', 'enable');
				
			if( !is_user_logged_in() && $enable_membership == 'enable' ){

				$our_term = frmaster_get_option('general', 'register-term-of-service-page', '#');
				$our_term = is_numeric($our_term)? get_permalink($our_term): $our_term; 
				$privacy = frmaster_get_option('general', 'register-privacy-statement-page', '#');
				$privacy = is_numeric($privacy)? get_permalink($privacy): $privacy; 
				echo '<div class="frmaster-create-account-wrap" >';
				echo '<div class="frmaster-create-account" >';
				echo '<input type="checkbox" name="create-account" />';
				echo sprintf(wp_kses(
					__('Create an account for me. Creating an account means you\'re okay with our <a href="%s" target="_blank">Terms of Service</a> and <a href="%s" target="_blank">Privacy Statement</a>.', 'frmaster'), 
					array('a' => array( 'href'=>array(), 'target'=>array() ))
				), $our_term, $privacy);
				echo '</div>'; // frmaster-create-account

				echo '<div class="frmaster-notification-box frmaster-failure" >' . esc_html__('Please agree to all the terms and conditions before proceeding to the next step', 'frmaster') . '</div>';
				echo '</div>'; // frmaster-create-account-wrap

				$password_field = array(
					'required' => true,
					'type' => 'password',
					'placeholder' => true,
					'label' => false
				);
				echo '<div class="frmaster-register-form-fields frmaster-register-form-fields-password clearfix" >';
				$password_field['slug'] = 'password';
				$password_field['title'] = esc_html__('Password', 'frmaster');
				frmaster_get_form_field($password_field, 'profile');
				$password_field['slug'] = 'confirm-password';
				$password_field['title'] = esc_html__('Confirm Password', 'frmaster');
				frmaster_get_form_field($password_field, 'profile');
				echo '</div>';
			}
			echo '</form>';

			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		}
	}

	add_action('wp_ajax_frmaster_follow', 'frmaster_add_follow');
	add_action('wp_ajax_nopriv_frmaster_follow', 'frmaster_add_follow');
	if( !function_exists('frmaster_add_follow') ){
		function frmaster_add_follow(){
			
			if( is_user_logged_in() && !empty($_POST['cause-id']) ){
				global $current_user;
				
				$follow_ids = get_user_meta($current_user->ID, 'frmaster-follow', true);
				$follow_ids = empty($follow_ids)? array(): $follow_ids;

				if( !in_array($_POST['cause-id'], $follow_ids) ){
					$follow_ids[] = $_POST['cause-id'];
					update_user_meta($current_user->ID, 'frmaster-follow', $follow_ids);
				}
			}

			die(json_encode($_POST));
		} // frmaster_add_follow
	}

	// set upload directory to frmaster_avatar
	if( !function_exists('frmaster_set_avatar_upload_folder') ){
		function frmaster_set_avatar_upload_folder( $uploads ){
			$keys = array( 'path', 'url', 'basedir', 'baseurl' );

			foreach( $keys as $key ){
				if( !empty($uploads[$key]) ){
					$uploads[$key] = str_replace('/wp-content/uploads', '/wp-content/uploads/frmaster-avatar', $uploads[$key]);
				}
			}
			
			return $uploads;
		}
	}