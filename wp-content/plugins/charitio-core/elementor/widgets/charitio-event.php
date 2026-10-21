<?php
/*
 * Elementor Charitio Event Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Event extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_event';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Event', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-calendar';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Event widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_event'];
	}
	
	/**
	 * Register Charitio Event widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){


		$posts = get_posts( 'post_type="event"&numberposts=-1' );
    $PostID = array();
    if ( $posts ) {
      foreach ( $posts as $post ) {
        $PostID[ $post->ID ] = $post->ID;
      }
    } else {
      $PostID[ __( 'No ID\'s found', 'charitio' ) ] = 0;
    }
		

		$this->start_controls_section(
			'section_event_listing',
			[
				'label' => esc_html__( 'Listing Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'event_style',
			[
				'label' => esc_html__( 'Event Style', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style One', 'charitio-core' ),
					'style-two' => esc_html__( 'Style Two', 'charitio-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your event style.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'event_limit',
			[
				'label' => esc_html__( 'Event Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'event_order',
			[
				'label' => __( 'Order', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__( 'Asending', 'charitio-core' ),
					'DESC' => esc_html__( 'Desending', 'charitio-core' ),
				],
				'default' => 'DESC',
			]
		);
		$this->add_control(
			'event_orderby',
			[
				'label' => __( 'Order By', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'charitio-core' ),
					'ID' => esc_html__( 'ID', 'charitio-core' ),
					'author' => esc_html__( 'Author', 'charitio-core' ),
					'title' => esc_html__( 'Title', 'charitio-core' ),
					'date' => esc_html__( 'Date', 'charitio-core' ),
				],
				'default' => 'date',
			]
		);
		$this->add_control(
			'event_show_category',
			[
				'label' => __( 'Certain Categories?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => Controls_Helper_Output::get_terms_names( 'event_category'),
				'multiple' => true,
			]
		);
		$this->add_control(
			'event_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->add_control(
			'read_more_txt',
			[
				'label' => esc_html__( 'Read More Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Read More',
				'placeholder' => esc_html__( 'Type your Read More text here', 'charitio-core' ),
			]
		);
		$this->end_controls_section();// end: Section

	
		// Event Title
		$this->start_controls_section(
			'section_event_title_style',
			[
				'label' => esc_html__( 'Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_event_title_typography',
				'selector' => '{{WRAPPER}} .charitio-event .wpo-event-wrap .wpo-event-content h2 a',
			]
		);
		$this->add_control(
			'event_title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-event .wpo-event-wrap .wpo-event-content h2 a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'event_title_padding',
			[
				'label' => esc_html__( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-event .wpo-event-wrap .wpo-event-content h2 a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Content
		$this->start_controls_section(
			'event_section_content_style',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'event_section_content_typography',
				'selector' => '{{WRAPPER}} .charitio-event .wpo-event-wrap .wpo-event-content p',
			]
		);
		$this->add_control(
			'event_content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-event .wpo-event-wrap .wpo-event-content p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Event Date
		$this->start_controls_section(
			'section_event_date_style',
			[
				'label' => esc_html__( 'Date', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'event_date_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-area .wpo-event-wrap .wpo-event-img .thumb, .wpo-event-area-s2 .wpo-event-single .wpo-event-item .wpo-event-content span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'event_date_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-area .wpo-event-wrap .wpo-event-img .thumb' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'event_desc_padding',
			[
				'label' => esc_html__( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-event-area .wpo-event-wrap .wpo-event-img .thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Border
		$this->start_controls_section(
			'section_event_border_style',
			[
				'label' => esc_html__( 'Border', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'event_border_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-area-s2 .wpo-event-single .wpo-event-item::before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Event widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$event_style = !empty( $settings['event_style'] ) ? $settings['event_style'] : '';
		$event_limit = !empty( $settings['event_limit'] ) ? $settings['event_limit'] : '';
		$event_order = !empty( $settings['event_order'] ) ? $settings['event_order'] : '';
		$event_orderby = !empty( $settings['event_orderby'] ) ? $settings['event_orderby'] : '';
		$event_show_category = !empty( $settings['event_show_category'] ) ? $settings['event_show_category'] : [];
		$event_show_id = !empty( $settings['event_show_id'] ) ? $settings['event_show_id'] : [];
		$read_more_txt = !empty( $settings['read_more_txt'] ) ? $settings['read_more_txt'] : '';

		if ( $event_style == 'style-one') {
			$event_wrap = 'wpo-event-area';
			$event_row = '';
		} else {
			$event_wrap = 'wpo-event-area-s2';
			$event_row = 'justify-content-center';
		}


		// Turn output buffer on
		ob_start();

		// Pagination
		global $paged;
		if( get_query_var( 'paged' ) )
		  $my_page = get_query_var( 'paged' );
		else {
		  if( get_query_var( 'page' ) )
			$my_page = get_query_var( 'page' );
		  else
			$my_page = 1;
		  set_query_var( 'paged', $my_page );
		  $paged = $my_page;
		}

    if ($event_show_id) {
			$event_show_id = json_encode( $event_show_id );
			$event_show_id = str_replace(array( '[', ']' ), '', $event_show_id);
			$event_show_id = str_replace(array( '"', '"' ), '', $event_show_id);
      $event_show_id = explode(',',$event_show_id);
    } else {
      $event_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'event',
		  'posts_per_page' => (int)$event_limit,
		  'event_category' => implode(',', $event_show_category),
		  'orderby' => $event_orderby,
		  'order' => $event_order,
      'post__in' => $event_show_id,
		);

		$charitio_event = new \WP_Query( $args );

		?>
		<div class="charitio-event <?php echo esc_attr( $event_wrap ); ?>">
	  	<div class="container">
	      <div class="wpo-event-wrap">
	        <div class="row <?php echo esc_attr( $event_row ); ?>">
		    	<?php 

			    	if ( $event_style == 'style-two' ) {
			    		echo '<div class="col col-lg-10">';
			    	}
						if ( $charitio_event->have_posts()) : while ( $charitio_event->have_posts()) : $charitio_event->the_post();
						
		        global $post;

		       	$event_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'charitio-event-large', false, '' );
						$event_image = $event_image ? $event_image[0] : '';
						$event_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

		        $event_excerpt = get_the_excerpt();

					 	if ( $event_style == 'style-one' ) {
						echo ' <div class="col col-lg-4 col-md-6 col-12">';
						} ?>
				   
              <div class="wpo-event-single">
                  <div class="wpo-event-item">
                      <div class="wpo-event-img">
                      	<?php if( $event_image ) { echo '<img src="'.esc_url( $event_image ).'" alt="'.esc_url( $event_alt ).'">'; } if ( $event_style == 'style-one' ) { ?>
                    		 <span class="thumb">
                    		 	<?php echo get_the_date('d'); ?><span><?php echo get_the_date('M'); ?></span>
                    		 </span>
                      	<?php } ?>
                      </div>
                      <div class="wpo-event-content">
                          <div class="wpo-event-text-top">
                          	<?php if ( $event_style == 'style-two' ) {
                          		echo '<span>'.esc_html( get_the_date() ).'</span>';
                          	} ?>
                            <h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h2>
                             <?php  
                             if( $event_excerpt ) { echo '<p>'.esc_html( $event_excerpt ).'</p>'; } 
                             if( $read_more_txt ) { echo '<a class="read-more" href="'.esc_url( get_permalink()  ).'">'.esc_html( $read_more_txt ).'</a>'; } 

                             ?>
                          </div>
                      </div>
                  </div>
              </div>
            <?php if ( $event_style == 'style-one' ) {
            echo '</div>';
            } 
				 	 endwhile;
				 	 endif;
				 	 wp_reset_postdata();
				 	 if ( $event_style == 'style-two' ) {
		    		echo '</div>';
		    	}
				 	?>
		      </div>
        </div>
    	</div>
		</div>
		<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Event widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Event() );