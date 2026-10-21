<?php
	/**
	 * A widget that show recent posts ( Specified by category ).
	 */

	add_action('widgets_init', 'frmaster_cause_widget');
	if( !function_exists('frmaster_cause_widget') ){
		function frmaster_cause_widget() {
			register_widget( 'FRmaster_Cause_Widget' );
		}
	}

	if( !class_exists('FRmaster_Cause_Widget') ){
		class FRmaster_Cause_Widget extends WP_Widget{

			// Initialize the widget
			function __construct() {

				parent::__construct(
					'frmaster-cause-widget', 
					esc_html__('Cause Widget ( Goodlayers )', 'frmaster'), 
					array('description' => esc_html__('A widget that show latest cause', 'frmaster'))
				);  

			}

			// Output of the widget
			function widget( $args, $instance ) {
	
				$title = empty($instance['title'])? '': apply_filters('widget_title', $instance['title']);
				$category = empty($instance['category'])? '': $instance['category'];
				$num_fetch = empty($instance['num-fetch'])? '': $instance['num-fetch'];
					
				// Opening of widget
				echo $args['before_widget'];
				
				// Open of title tag
				if( !empty($title) ){ 
					echo $args['before_title'] . $title . $args['after_title']; 
				}
					
				// Widget Content
				$query_args = array(
					'post_type' => 'cause', 
					'suppress_filters' => false,
					'orderby' => 'post_date',
					'order' => 'desc',
					'paged' => 1,
					'ignore_sticky_posts' => 1,
					'posts_per_page' => $num_fetch,
					'cause_category' => $category,
					'post__not_in' => array(get_the_ID())
				);
				$query = new WP_Query( $query_args );
				
				
				if($query->have_posts()){
					frmaster_setup_admin_postdata();
					echo '<div class="frmaster-cause-widget">';
					while( $query->have_posts() ){ $query->the_post();
						echo '<div class="frmaster-cause-widget-item clearfix" >';

						$feature_image = get_post_thumbnail_id();
						if( !empty($feature_image) ){
							echo '<div class="frmaster-cause-widget-thumbnail frmaster-media-image" ><a href="' . esc_attr(get_permalink()) . '" >';
							echo frmaster_get_image($feature_image, 'thumbnail');
							echo '</a></div>';
						}

						$funding_goal = get_post_meta(get_the_ID(), 'frmaster-funding-goal', true);
						$donated_amount = get_post_meta(get_the_ID(), 'frmaster-donated-amount', true);
						$donated_percent = ($funding_goal == 0)? 0: intval(($donated_amount*100) / $funding_goal);
						echo '<div class="frmaster-cause-widget-content-wrap" >';
						echo '<h3 class="frmaster-cause-widget-title" ><a href="' . esc_attr(get_permalink()) . '" >' . get_the_title() . '</a></h3>';
						echo '<div class="frmaster-cause-widget-info" >';
						echo '<div class="frmaster-cause-widget-donation-bar" >';
						echo '<div class="frmaster-cause-widget-donation-bar-filled" ' . frmaster_esc_style(array(
							'width' => $donated_percent . '%'
						)) . ' ></div>';
						echo '</div>'; // frmaster-cause-widget-donation-bar
						echo '<div class="frmaster-cause-widget-donation-percent" >' . sprintf(esc_html__('%d%% Donated', 'frmaster'), $donated_percent) . '</div>';
						echo '</div>'; // frmaster-cause-widget-info
						echo '</div>'; // frmaster-cause-widget-content-wrap

						echo '</div>';
					}
					echo '</div>'; // tourmaster-recent-tour-widget
					wp_reset_postdata();
					frmaster_reset_admin_postdata();
				}
						
				// Closing of widget
				echo $args['after_widget'];

			}

			// Widget Form
			function form( $instance ) {

				if( class_exists('frmaster_widget_util') ){
					frmaster_widget_util::get_option(array(
						'title' => array(
							'type' => 'text',
							'id' => $this->get_field_id('title'),
							'name' => $this->get_field_name('title'),
							'title' => esc_html__('Title', 'frmaster'),
							'value' => (isset($instance['title'])? $instance['title']: '')
						),
						'category' => array(
							'type' => 'combobox',
							'id' => $this->get_field_id('category'),
							'name' => $this->get_field_name('category'),
							'title' => esc_html__('Category', 'frmaster'),
							'options' => frmaster_get_term_list('cause_category', '', true),
							'value' => (isset($instance['category'])? $instance['category']: '')
						),
						'num-fetch' => array(
							'type' => 'text',
							'id' => $this->get_field_id('num-fetch'),
							'name' => $this->get_field_name('num-fetch'),
							'title' => esc_html__('Display Number', 'frmaster'), 
							'value' => (isset($instance['num-fetch'])? $instance['num-fetch']: '3')
						),
					));
				}

			}
			
			// Update the widget
			function update( $new_instance, $old_instance ) {

				if( class_exists('frmaster_widget_util') ){
					return frmaster_widget_util::get_option_update($new_instance);
				}

				return $new_instance;
			}	
		} // class
	} // class_exists
?>