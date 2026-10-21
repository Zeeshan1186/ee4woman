<?php
/*
 * Elementor Charitio Title Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Title extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'tmx-charitio_title';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Title', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'ti-direction';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Title widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['tmx-charitio_title'];
	}
	*/
	
	/**
	 * Register Charitio Title widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_Title',
			[
				'label' => esc_html__( 'Title Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'section_subtitle',
			[
				'label' => esc_html__( 'Sub Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Sub Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type sub title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'section_content',
			[
				'label' => esc_html__( 'Title Content', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Title Content', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title content here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_responsive_control(
			'content_min_width',
			[
				'label' => esc_html__( 'Width', 'charitio-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 350,
						'max' => 750,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .section-title-s3 p' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_style' => array('style-one'),
				],
			]
		);
		$this->end_controls_section();// end: Section

		
		// Sub Title
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label' => esc_html__( 'Sub Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'charitio_subtitle_typography',
				'selector' => '{{WRAPPER}} .wpo-section-title span',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-section-title span' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'subtitle_padding',
			[
				'label' => __( 'Sub Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,				
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-section-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'name' => 'charitio_title_typography',
				'selector' => '{{WRAPPER}} .wpo-section-title h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-section-title h2' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,				
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .section-title h2, .section-title-s3 h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .wpo-section-title p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-section-title p' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .wpo-section-title p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		
	}

	/**
	 * Render Title widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();

		$title_style = !empty( $settings['title_style'] ) ? $settings['title_style'] : '';
		$section_subtitle = !empty( $settings['section_subtitle'] ) ? $settings['section_subtitle'] : '';
		$section_title = !empty( $settings['section_title'] ) ? $settings['section_title'] : '';
		$section_content = !empty( $settings['section_content'] ) ? $settings['section_content'] : '';

		// Turn output buffer on

		ob_start(); ?>
		<div class="section-title-area">
			<div class="row justify-content-center">
			  <div class="col-lg-6">
			      <div class="wpo-section-title">
			          <?php 
			        	  if( $section_subtitle ) { echo '<span>'.wp_kses_post( $section_subtitle ).'</span>'; } 
			        	  if( $section_title ) { echo '<h2>'.esc_html( $section_title ).'</h2>'; } 
			        	  if( $section_content ) { echo '<p>'.esc_html( $section_content ).'</p>'; }
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
	 * Render Title widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Title() );