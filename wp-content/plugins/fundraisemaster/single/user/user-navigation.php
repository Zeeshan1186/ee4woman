<?php

	$nav_list = frmaster_get_user_nav_list();
	$nav_active = empty($_GET['page_type'])? '': $_GET['page_type'];
	
	foreach( $nav_list as $nav_slug => $nav ){
		if( !empty($nav['type']) && $nav['type'] == 'title' ){
			echo '<h3 class="frmaster-user-navigation-head" >' . $nav['title'] . '</h3>';
		}else{

			// assign active class
			$nav_class = 'frmaster-user-navigation-item-' . $nav_slug;

			if( empty($nav_active) || $nav_active == $nav_slug ){
				$nav_active = $nav_slug;
				$nav_class = ' frmaster-active'; 
			}

			// get the navigation link
			if( !empty($nav['link']) ){
				$nav_link = $nav['link'];
			}else{
				$nav_link = frmaster_get_template_url('user', array('page_type'=>$nav_slug));
			}

			echo '<div class="frmaster-user-navigation-item ' . esc_attr($nav_class) . '" >';
			echo '<a href="' . esc_url($nav_link) . '" >';
			if( !empty($nav['icon']) ){
				echo '<i class="frmaster-user-navigation-item-icon ' . esc_attr($nav['icon']) . '" ></i>';
			}
			echo $nav['title'];
			echo '</a>';
			echo '</div>';		
		}
		
		
	}




?>