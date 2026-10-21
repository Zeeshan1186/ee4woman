<?php
/*
 * Elementor Charitio Contact Form 7 Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Contact_Form extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_contact_form';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Contact Form', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Contact Form widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['wpo-charitio_contact_form'];
	}
	 */
	
	/**
	 * Register Charitio Contact Form widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_contact_form',
			[
				'label' => esc_html__( 'Form Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'form_title',
			[
				'label' => esc_html__( 'Title', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Default title', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'charitio-core' ),
			]
		);	
		$this->add_control(
			'form_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__( 'Default content', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
			]
		);
		$this->add_control(
			'form_id',
			[
				'label' => esc_html__( 'Select contact form', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => Controls_Helper_Output::get_posts('wpcf7_contact_form'),
			]
		);
		$this->end_controls_section();// end: Section

		// Title Style
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
				'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-title h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} wpo-contact-pg-section .wpo-contact-title h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_pad',
			[
				'label' => __( 'Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} wpo-contact-pg-section .wpo-contact-title h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Content Style

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
				'selector' => '{{WRAPPER}} wpo-contact-pg-section .wpo-contact-title p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} wpo-contact-pg-section .wpo-contact-title p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_pad',
			[
				'label' => __( 'Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} wpo-contact-pg-section .wpo-contact-title p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		$this->start_controls_section(
			'section_form_style',
			[
				'label' => esc_html__( 'Form', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_typography',
				'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="text"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="email"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="date"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="time"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="number"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea, 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area select, 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .form-control, 
				{{WRAPPER}} .track-contact .track-trace select, 
				{{WRAPPER}} .track-contact .track-trace input',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_border',
				'label' => esc_html__( 'Border', 'charitio-core' ),
				'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="text"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="email"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-areainput[type="date"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="time"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="number"], 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea, 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area select, 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .form-control, 
				{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .nice-select,
				{{WRAPPER}} .track-contact .track-trace select, 
				{{WRAPPER}} .track-contact .track-trace input',

			]
		);
		$this->add_control(
			'placeholder_text_color',
			[
				'label' => __( 'Placeholder Text Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input:not([type="submit"])::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input:not([type="submit"])::-moz-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input:not([type="submit"])::-ms-input-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input:not([type="submit"])::-o-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea::-moz-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea::-ms-input-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea::-o-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .track-contact .track-trace input::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .track-contact .track-trace select::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area label' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="text"], 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="email"], 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="date"], 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="time"], 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area input[type="number"], 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area textarea, 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area select, 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .form-control, 
					{{WRAPPER}} .track-contact .track-trace input, 
					{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .nice-select' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit',
			]
		);
		$this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Width', 'charitio-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'btn_margin',
			[
				'label' => __( 'Margin', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'button_style' );
			$this->start_controls_tab(
				'button_normal',
				[
					'label' => esc_html__( 'Normal', 'charitio-core' ),
				]
			);
			$this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'button_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => esc_html__( 'Border', 'charitio-core' ),
					'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit',
				]
			);
			$this->end_controls_tab();  // end:Normal tab
			
			$this->start_controls_tab(
				'button_hover',
				[
					'label' => esc_html__( 'Hover', 'charitio-core' ),
				]
			);
			$this->add_control(
				'button_hover_color',
				[
					'label' => esc_html__( 'Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'button_bg_hover_color',
				[
					'label' => esc_html__( 'Background Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'button_hover_border',
					'label' => esc_html__( 'Border', 'charitio-core' ),
					'selector' => '{{WRAPPER}} .wpo-contact-pg-section .wpo-contact-form-area .wpcf7-form-control.wpcf7-submit:hover',
				]
			);
			$this->end_controls_tab();  // end:Hover tab
		$this->end_controls_tabs(); // end tabs
		
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render Contact Form widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$form_id = !empty( $settings['form_id'] ) ? $settings['form_id'] : '';
		$form_title = !empty( $settings['form_title'] ) ? $settings['form_title'] : '';
		$form_content = !empty( $settings['form_content'] ) ? $settings['form_content'] : '';

		// Turn output buffer on
		ob_start(); ?>
		<div class="wpo-contact-pg-section">
        <div class="wpo-contact-title">
          <?php 
          	if( $form_title ) { echo '<h2>'.esc_html( $form_title ).'</h2>'; } 
            if( $form_content ) { echo '<p>'.esc_html( $form_content ).'</p>'; } 
         ?>
        </div>
        <div class="wpo-contact-form-area">
           	<?php echo do_shortcode( '[contact-form-7 id="'. $form_id .'"]' ); ?>
        </div>
		</div>
		<?php
		// Return outbut buffer
		echo ob_get_clean();
		
		} 
		


	/**
	 * Render Contact Form widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Contact_Form() );