<?php
/*
 * Elementor Charitio Funfact Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Funfact extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_funfact';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Funfact', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-counter';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Funfact widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_funfact'];
	}
	
	/**
	 * Register Charitio Funfact widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_funfact',
			[
				'label' => esc_html__( 'Funfact Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'shape_image',
			[
				'label' => esc_html__( 'Shape Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'funfact_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'funfact_number',
			[
				'label' => esc_html__( 'Funfact Number', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '250', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type funfact Number here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'funfact_plus',
			[
				'label' => esc_html__( 'Funfact Plus/Percentage', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '+', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type funfact Plus/Percentage here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'funfactItems_groups',
			[
				'label' => esc_html__( 'Funfact Items', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'funfact_title' => esc_html__( 'Funfact', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ funfact_title }}}',
			]
		);
		$this->end_controls_section();// end: Section
		

		// Funfact Number
		$this->start_controls_section(
			'funfact_section_style',
			[
				'label' => esc_html__( 'Funfact', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'funfact_section_bg_color',
				'label' => esc_html__( 'Background', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .wpo-fun-fact-section .wpo-fun-fact-grids',
			]
		);
	
		$this->end_controls_section();// end: Section

		// Funfact Number
		$this->start_controls_section(
			'funfact_number_style',
			[
				'label' => esc_html__( 'Number', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_number_typography',
				'selector' => '{{WRAPPER}} .wpo-fun-fact-section .grid h3',
			]
		);
		$this->add_control(
			'funfact_item_number_color',
			[
				'label' => esc_html__( 'Number Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-fun-fact-section .grid h3' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'number_padding',
			[
				'label' => __( 'Number Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-fun-fact-section .grid h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Funfact Title
		$this->start_controls_section(
			'funfact_title_style',
			[
				'label' => esc_html__( 'Funfact Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'ntrsvt_funfact_title_typography',
				'selector' => '{{WRAPPER}} .wpo-fun-fact-section .grid h3+p',
			]
		);
		$this->add_control(
			'funfact_title',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-fun-fact-section .grid h3+p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'funfact_title_padding',
			[
				'label' => __( 'Number Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-fun-fact-section .grid h3+p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Funfact widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$funfactItems_groups = !empty( $settings['funfactItems_groups'] ) ? $settings['funfactItems_groups'] : [];
		$shape_bg = !empty( $settings['shape_image']['id'] ) ? $settings['shape_image']['id'] : '';	

		$shape_url = wp_get_attachment_url( $shape_bg );
		$shape_alt = get_post_meta( $shape_bg, '_wp_attachment_image_alt', true);
		// Turn output buffer on
		ob_start(); ?>
		<div class="wpo-fun-fact-section">
	    <div class="container">
	        <div class="row">
	            <div class="col col-xs-12">
	                <div class="wpo-fun-fact-grids clearfix">
	                <?php 	// Group Param Output
									if( is_array( $funfactItems_groups ) && !empty( $funfactItems_groups ) ){
									foreach ( $funfactItems_groups as $each_item ) { 
									$funfact_title = !empty( $each_item['funfact_title'] ) ? $each_item['funfact_title'] : '';
									$funfact_number = !empty( $each_item['funfact_number'] ) ? $each_item['funfact_number'] : '';
									$funfact_plus = !empty( $each_item['funfact_plus'] ) ? $each_item['funfact_plus'] : '';
									?>
                  <div class="grid">
                      <div class="info">
                        <?php 
					            		if( $funfact_number ) { echo '<h3><span class="odometer" data-count="'.esc_attr( $funfact_number ).'">'.esc_html__( '00','charitio-core' ).'</span>'.esc_html( $funfact_plus ).'</h3>'; } 
					            		 if( $funfact_title ) { echo '<p>'.esc_html__( $funfact_title ).'</p>'; }
					            	?>
                      </div>
                  </div>
									<?php }
									} ?>
									<div class="shape">
										<?php if( $shape_url ) { echo '<img src="'.esc_url( $shape_url ).'" alt="'.esc_url( $shape_alt ).'">'; } ?>
									</div>
	                </div>
	            </div>
	        </div>
	    </div> <!-- end container -->
		</div>
		<?php 
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Funfact widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Funfact() );