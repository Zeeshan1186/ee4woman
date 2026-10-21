<?php
/*
 * Elementor Charitio ProjectItem Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_ProjectItem extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_projectitem';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Project Item', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-editor-list-ul';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio ProjectItem widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['wpo-charitio_projectitem'];
	}
	*/
	
	/**
	 * Register Charitio ProjectItem widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_ProjectItem',
			[
				'label' => esc_html__( 'ProjectItem Options', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'single_feature_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'single_feature_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'default' => esc_html__( 'your content text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);

		$this->add_control(
			'single_featureItems_groups',
			[
				'label' => esc_html__( 'Feature Icons', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'single_feature_title' => esc_html__( 'Feature', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ single_feature_title }}}',
			]
		);
		$this->end_controls_section();// end: Section

			// Title
		$this->start_controls_section(
			'single_service_section_title_style',
			[
				'label' => esc_html__( 'Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'sasban_title_typography',
				'selector' => '{{WRAPPER}} .wpo-project-details-text h2',
			]
		);
		$this->add_control(
			'single_service_title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-details-text h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'single_service_title_padding',
			[
				'label' => __( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-project-details-text h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

			// Content
		$this->start_controls_section(
			'single_service_section_content_style',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'single_service_content_typography',
				'selector' => '{{WRAPPER}} .wpo-project-details-text span',
			]
		);
		$this->add_control(
			'single_service_content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-project-details-text span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'single_service_content_padding',
			[
				'label' => __( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-project-details-text span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render ProjectItem widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$single_featureItems_groups = !empty( $settings['single_featureItems_groups'] ) ? $settings['single_featureItems_groups'] : [];

// Turn output buffer on
		ob_start(); ?>
		<div class="wpo-project-single-box">
			<ul>
	    <?php 

	  		// Group Param Output
				if( is_array( $single_featureItems_groups ) && !empty( $single_featureItems_groups ) ){
				foreach ( $single_featureItems_groups as $each_item ) { 

				$single_feature_title = !empty( $each_item['single_feature_title'] ) ? $each_item['single_feature_title'] : '';
				$single_feature_content = !empty( $each_item['single_feature_content'] ) ? $each_item['single_feature_content'] : '';
			
        	if( $single_feature_title ) { echo '<li>'.esc_html( $single_feature_title ).'<span>'.esc_html( $single_feature_content ).'</span></li>'; }
         }
				} 
			?>
	    </ul>
		</div>
		<?php
		// Return outbut buffer
		echo ob_get_clean();
		
	}
	/**
	 * Render ProjectItem widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_ProjectItem() );