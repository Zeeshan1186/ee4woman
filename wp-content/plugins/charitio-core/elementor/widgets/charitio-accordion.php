<?php
/*
 * Elementor Charitio Accordion  Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Accordion  extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_accordion';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Accordion ', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-accordion';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Accordion  widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_accordion'];
	}
	
	/**
	 * Register Charitio Accordion  widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_accordion',
			[
				'label' => esc_html__( 'Accordion  Options', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'active_tabs',
			[
				'label' => __( 'Active Accordion', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'charitio-core' ),
				'label_off' => __( 'Hide', 'charitio-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$repeater->add_control(
			'accordion_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'accordion_content',
			[
				'label' => esc_html__( 'Content Text', 'charitio-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Content Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type content text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'accordionItems_groups',
			[
				'label' => esc_html__( 'Accordion  Items', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'accordion_title' => esc_html__( 'Accordion ', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ accordion_title }}}',
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
				'selector' => '{{WRAPPER}} .theme-accordion .accordion .accordion-item h3 button',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-item h3 button' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-item h3 button' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_br_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-item' => 'border-left-color: {{VALUE}};',
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
					'{{WRAPPER}} .theme-accordion .accordion .accordion-item h3 button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section


		// Accordion Content
		$this->start_controls_section(
			'section_accordion_content_style',
			[
				'label' => esc_html__( 'Accordion Content', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_accordion_content_typography',
				'selector' => '{{WRAPPER}} .theme-accordion .accordion .accordion-body p',
			]
		);
		$this->add_control(
			'accordion_content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-body p' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'accordion_content_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-body' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'accordion_br_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theme-accordion .accordion .accordion-body' => 'border-top-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Accordion  widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$accordionItems_groups = !empty( $settings['accordionItems_groups'] ) ? $settings['accordionItems_groups'] : [];
		// Turn output buffer on
		ob_start();
		?>
		<div class="theme-accordion">
			<div class="accordion" id="accordionExample">
     <?php 	// Group Param Output
			if( is_array( $accordionItems_groups ) && !empty( $accordionItems_groups ) ){
				$id = 1;
				foreach ( $accordionItems_groups as $each_items ) { 
				$id++;
				$accordion_title = !empty( $each_items['accordion_title'] ) ? $each_items['accordion_title'] : '';
				$accordion_content = !empty( $each_items['accordion_content'] ) ? $each_items['accordion_content'] : '';
				$active_tabs = !empty( $each_items['active_tabs'] ) ? $each_items['active_tabs'] : '';

				 if ( $active_tabs == 'yes') {
          $active_class = 'show';
          $heade_class = '';
        } else {
          $active_class = '';
          $heade_class = 'collapsed';
        }

			?>
      <div class="accordion-item">
      		<?php if ( $accordion_title ) {
	        	echo'<h3 class="accordion-header" id="heading'.esc_attr( $id ).'">
	            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.esc_attr( $id ).'" aria-expanded="true" aria-controls="collapse'.esc_attr( $id ).'">
	              '.esc_html( $accordion_title ).'
	            </button>
	        	</h3>';
	        	} 
	        if ( $accordion_content ) { ?>
	        <div id="collapse<?php echo esc_attr( $id ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $active_class ); ?>" aria-labelledby="heading<?php echo esc_attr( $id ); ?>" data-bs-parent="#accordionExample">
	            <div class="accordion-body">
	               <?php echo wp_kses_post( $accordion_content ); ?>
	        		</div>
	        </div>
	         <?php } ?>
	      </div>
	     <?php } } ?>
  		</div>
  	</div>
		<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Accordion  widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Accordion () );