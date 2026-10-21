<?php
/*
 * Elementor Charitio Project Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Project extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_project';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Project', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-hotspot';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Project widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_project'];
	}
	
	/**
	 * Register Charitio Project widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){


		$posts = get_posts( 'post_type="project"&numberposts=-1' );
    $PostID = array();
    if ( $posts ) {
      foreach ( $posts as $post ) {
        $PostID[ $post->ID ] = $post->ID;
      }
    } else {
      $PostID[ __( 'No ID\'s found', 'charitio' ) ] = 0;
    }
		

		$this->start_controls_section(
			'section_project_listing',
			[
				'label' => esc_html__( 'Project Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'project_style',
			[
				'label' => esc_html__( 'Project Style', 'finco-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style One', 'finco-core' ),
					'style-two' => esc_html__( 'Style Two', 'finco-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your project style.', 'finco-core' ),
			]
		);
		
		$this->add_control(
			'project_limit',
			[
				'label' => esc_html__( 'Project Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'project_order',
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
			'project_orderby',
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
			'project_show_category',
			[
				'label' => __( 'Certain Categories?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => Controls_Helper_Output::get_terms_names( 'project_category'),
				'multiple' => true,
			]
		);
		$this->add_control(
			'project_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->add_control(
			'project_more',
			[
				'label' => esc_html__( 'Plus', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'charitio-core' ),
				'label_off' => esc_html__( 'Hide', 'charitio-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'short_content',
			[
				'label' => esc_html__( 'Excerpt Length', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 16,
				'description' => esc_html__( 'How many words you want in short content paragraph.', 'charitio-core' ),
			]
		);
		$this->end_controls_section();// end: Section


		// Title
		$this->start_controls_section(
			'section_project_overly_style',
			[
				'label' => esc_html__( 'Overly', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overly_color',
				'label' => esc_html__( 'Square Shape Two ', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .wpo-project-section .grid .img-holder:before, .wpo-project-section-s2 .grid .img-holder:before',
			]
		);
		$this->end_controls_section();// end: Section

		// Title
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_title_typography',
				'selector' => '{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content h4 a, .wpo-project-section-s2 .grid .img-holder .hover-content h4 a',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content h4 a, .wpo-project-section-s2 .grid .img-holder .hover-content h4 a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content h4 a, .wpo-project-section-s2 .grid .img-holder .hover-content h4 a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'charitio_content_typography',
				'selector' => '{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content p, .wpo-project-section-s2 .grid .img-holder .hover-content p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content p, .wpo-project-section-s2 .grid .img-holder .hover-content p' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,				
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content p, .wpo-project-section-s2 .grid .img-holder .hover-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Plus
		$this->start_controls_section(
			'section_overly_style',
			[
				'label' => esc_html__( 'Plus Btn', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'plus_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content a.plus i:before, .wpo-project-section-s2 .grid .img-holder .hover-content a.plus i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'plus_hover_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-section .grid .img-holder .hover-content a.plus, .wpo-project-section-s2 .grid .img-holder .hover-content a.plus' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render Project widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$project_style = !empty( $settings['project_style'] ) ? $settings['project_style'] : '';

		$project_limit = !empty( $settings['project_limit'] ) ? $settings['project_limit'] : '';
		$project_order = !empty( $settings['project_order'] ) ? $settings['project_order'] : '';
		$project_orderby = !empty( $settings['project_orderby'] ) ? $settings['project_orderby'] : '';
		$project_show_category = !empty( $settings['project_show_category'] ) ? $settings['project_show_category'] : [];
		$project_show_id = !empty( $settings['project_show_id'] ) ? $settings['project_show_id'] : [];

		$project_more = !empty( $settings['project_more'] ) ? $settings['project_more'] : [];

		$short_content = !empty( $settings['short_content'] ) ? $settings['short_content'] : '';
		$excerpt_length = $short_content ? $short_content : '16';

		if ( $project_style == 'style-two' ) { 
			$project_wrapper = 'wpo-project-section-s2';
			$project_container = 'gallery-active owl-carousel clearfix';
		 } else {
			$project_wrapper = 'wpo-project-section';
			$project_container = 'gallery-container clearfix';
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

    if ($project_show_id) {
			$project_show_id = json_encode( $project_show_id );
			$project_show_id = str_replace(array( '[', ']' ), '', $project_show_id);
			$project_show_id = str_replace(array( '"', '"' ), '', $project_show_id);
      $project_show_id = explode(',',$project_show_id);
    } else {
      $project_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'project',
		  'posts_per_page' => (int)$project_limit,
		  'project_category' => implode(',', $project_show_category),
		  'orderby' => $project_orderby,
		  'order' => $project_order,
      'post__in' => $project_show_id,
		);

		$charitio_project = new \WP_Query( $args );
		?>
		<div class="<?php echo esc_attr( $project_wrapper ); ?>">
			<div class="container-fluid">
		  	<div class="sortable-gallery">
		    	<div class="project-grids  <?php echo esc_attr( $project_container ); ?>">
	    		<?php 
		    	
						if ( $charitio_project->have_posts()) : while ( $charitio_project->have_posts()) : $charitio_project->the_post();
						
						$project_options = get_post_meta( get_the_ID(), 'project_options', true );
	       
	          $project_title = isset( $project_options['project_title']) ? $project_options['project_title'] : '';
	          $project_grid = isset( $project_options['project_grid']) ? $project_options['project_grid'] : '';

	          global $post;
	          $grid_url = wp_get_attachment_url( $project_grid );
	          $grid_alt = get_post_meta( $project_grid , '_wp_attachment_image_alt', true);

						?>
		        <div class="grid">
	              <div class="img-holder">
		              	<?php if( $grid_url ) { echo '<img src="'.esc_url( $grid_url ).'" alt="'.esc_attr( $grid_alt ).'">'; } ?>
	                  <div class="hover-content">
	                      <a class="plus" href="<?php echo esc_url( get_permalink() ); ?>"><i class="ti-plus"></i></a>
	                      <h4>
	                      	<a href="<?php echo esc_url( get_permalink() ); ?>">
	                      		<?php echo esc_html( $project_title ); ?>
	                      	</a>
	                      </h4>
	                      <p><?php echo wp_trim_words( get_the_content(), $excerpt_length, ' ' ); ?></p>
	                  </div>
	              </div>
	          </div>
		        <!--/item-->
		        <?php 
						  endwhile;
						  endif;
						  wp_reset_postdata();
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
	 * Render Project widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Project() );