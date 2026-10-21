<?php
	/*	
	*	Tourmaster Plugin
	*/

	if( !function_exists('frmaster_plugin_activation') ){
		function frmaster_plugin_activation(){
			frmaster_table_init();
			frmaster_set_plugin_role();
		}	
	}

	if( !function_exists('frmaster_table_init') ){
		function frmaster_table_init(){

			// require necessary function
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			// order table
			$sql = "CREATE TABLE {$wpdb->prefix}frmaster_order (
				id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				user_id bigint(20) UNSIGNED DEFAULT NULL,
				cause_id bigint(20) UNSIGNED DEFAULT NULL,
				booking_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				booking_detail longtext DEFAULT NULL,
				order_status varchar(20) DEFAULT NULL,
				donation_amount decimal(19,4) DEFAULT NULL,
				payment_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				payment_info longtext DEFAULT NULL,
				recurring_order_id bigint(20) UNSIGNED DEFAULT NULL,
				PRIMARY KEY (id)
			) {$charset_collate};";
			dbDelta($sql);
		}
	}

	add_action('frmaster_after_save_plugin_option', 'frmaster_set_plugin_custom_role', 99);
	if( !function_exists('frmaster_set_plugin_custom_role') ){
		function frmaster_set_plugin_custom_role(){ 

			// role/capability
			remove_role('cause_author'); 

			// for cause author
			$author_cap = frmaster_get_option('general', 'cause-author-capability', '');
			$author_capability = array( 'read' => true );
			if( !empty($author_cap) ){
				foreach( $author_cap as $cap ){
					$author_capability[$cap] = true;
				}
			}
			$author_capability['manage_woocommerce'] = true;
			add_role('cause_author', esc_html__('Cause Author', 'tourmaster'), $author_capability);

		}
	}
	if( !function_exists('frmaster_set_plugin_role') ){
		function frmaster_set_plugin_role(){

			// for administrator
			$post_type_cap = array('edit_%s', 'read_%s', 'delete_%s',  
				'edit_%ss', 'edit_others_%ss', 'publish_%ss', 'read_private_%ss', 'delete_%ss');

			$admin = get_role('administrator');
			foreach( $post_type_cap as $cap ){
				$admin->add_cap(str_replace('%s', 'cause', $cap));
			}
			$admin->add_cap('manage_cause_category');
			$admin->add_cap('manage_cause_tag');
			$admin->add_cap('manage_cause_filter');
			$admin->add_cap('manage_cause_order');

			// custom role
			frmaster_set_plugin_custom_role();

		} // tourmaster_set_plugin_role
	}