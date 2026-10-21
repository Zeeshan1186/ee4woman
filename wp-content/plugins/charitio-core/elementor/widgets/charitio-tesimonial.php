<?php
/*
 * Elementor Charitio Testimonial Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Testimonial extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_testimonial';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Testimonial', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-blockquote';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Testimonial widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_testimonial'];
	}
	
	/**
	 * Register Charitio Testimonial widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_testimonial',
			[
				'label' => esc_html__( 'Testimonial Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'testimonial_style',
			[
				'label' => esc_html__( 'Testimonial Style', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style One', 'charitio-core' ),
					'style-two' => esc_html__( 'Style Two', 'charitio-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your Testimonial style.', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'testimonial_title',
			[
				'label' => esc_html__( 'Testimonial Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'testimonial_subtitle',
			[
				'label' => esc_html__( 'Testimonial Sub Title', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Testimonial Sub Title', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type testimonial Sub title here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'testimonial_content',
			[
				'label' => esc_html__( 'Testimonial Content', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Testimonial Content', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type testimonial Content here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'testi_image',
			[
				'label' => esc_html__( 'Testimonial Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'testimonialItems_groups',
			[
				'label' => esc_html__( 'Testimonial Items', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'testimonial_title' => esc_html__( 'Testimonial', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ testimonial_title }}}',
			]
		);
		$this->end_controls_section();// end: Section
		

		// Testimonial Content Style 
		$this->start_controls_section(
			'testimonials_section_content_style',
			[
				'label' => esc_html__( 'Testimonial', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'testimonials_quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-testi .wpo-testimonial-wrap .wpo-testimonial-item .wpo-testimonial-content p:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		
		// Testimonial Name Style 
		$this->start_controls_section(
			'testimonials_section_name_style',
			[
				'label' => esc_html__( 'Testimonial Name', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'testimonials_charitio_name_typography',
				'selector' => '{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content h2',
			]
		);
		$this->add_control(
			'testimonials_name_color',
			[
				'label' => esc_html__( 'Name Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		// Testimonial Title Style 
		$this->start_controls_section(
			'testimonials_section_title_style',
			[
				'label' => esc_html__( 'Testimonial Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'testimonials_charitio_title_typography',
				'selector' => '{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content span',
			]
		);
		$this->add_control(
			'testimonials_title_color',
			[
				'label' => esc_html__( 'Name Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content span' => 'color: {{VALUE}};',
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
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'section_content_typography',
				'selector' => '{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-testi .wpo-testimonial-item .wpo-testimonial-content p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		// Dot Color
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dot_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .charitio-testi .wpo-testimonial-wrap .testimonial-slider button' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dot_br_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .charitio-testi .wpo-testimonial-wrap .testimonial-slider button' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dot_color',
			[
				'label' => esc_html__( 'Active Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-testi .wpo-testimonial-wrap .testimonial-slider button i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
	}

	/**
	 * Render Testimonial widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$testimonial_style = !empty( $settings['testimonial_style'] ) ? $settings['testimonial_style'] : '';
		$testimonialItems_groups = !empty( $settings['testimonialItems_groups'] ) ? $settings['testimonialItems_groups'] : [];
	
		if ( $testimonial_style == 'style-one') {
		  $testi_wrapper = 'wpo-testimonial-area';
		  $testi_slider = 'testimonial-slider';
		} else {
		  $testi_wrapper = 'wpo-testimonial-area-s2';
		  $testi_slider = 'testimonial-slider-s2';
		}

		// Turn output buffer on
		ob_start(); ?>
		<div class="charitio-testi <?php echo esc_attr( $testi_wrapper ); ?>">
		    <div class="container">
		        <div class="wpo-testimonial-wrap">
		            <div class="<?php echo esc_attr( $testi_slider ); ?> owl-carousel">
							 		<?php 	// Group Param Output
										if( is_array( $testimonialItems_groups ) && !empty( $testimonialItems_groups ) ){
										foreach ( $testimonialItems_groups as $each_items ) { 

										$testimonial_title = !empty( $each_items['testimonial_title'] ) ? $each_items['testimonial_title'] : '';
										$testimonial_subtitle = !empty( $each_items['testimonial_subtitle'] ) ? $each_items['testimonial_subtitle'] : '';
										$testimonial_content = !empty( $each_items['testimonial_content'] ) ? $each_items['testimonial_content'] : '';
											$bg_testi = !empty( $each_items['testi_image']['id'] ) ? $each_items['testi_image']['id'] : '';	
		
											// Image
											$image_url = wp_get_attachment_url( $bg_testi );
											$image_alt = get_post_meta( $bg_testi, '_wp_attachment_image_alt', true);
										?>
		                <div class="wpo-testimonial-item">
	                    <div class="wpo-testimonial-img">
	                      <?php if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_url( $image_alt ).'">'; } ?>
	                    </div>
	                    <div class="wpo-testimonial-content">
	                       <?php 
                          if( $testimonial_content ) { echo '<p>'.esc_html( $testimonial_content ).'</p>'; }
													if( $testimonial_title ) { echo '<h2>'.esc_html( $testimonial_title ).'</h2>'; } 
		                			if( $testimonial_subtitle ) { echo '<span>'.esc_html( $testimonial_subtitle ).'</span>'; }
		                     ?>
	                    </div>
	                	</div>
		                <?php }
										} ?>
		            </div>
		        </div>
		    </div>
		</div>
		<?php 
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Testimonial widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Testimonial() );