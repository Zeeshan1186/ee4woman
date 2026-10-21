<?php
/*
 * Elementor Charitio EVENTTAB Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_EVENTTAB extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_eventtab';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Event Tab', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-dual-button';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio EVENTTAB widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['tmx-charitio_eventtab'];
	}
	*/
	
	/**
	 * Register Charitio EVENTTAB widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_event_tab',
			[
				'label' => esc_html__( 'Event Tab Content', 'charitio-core' ),
			]
		);
		$this->add_control(
			'eventtab_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Event Schedule', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'eventtab_content',
			[
				'label' => esc_html__( 'Content Text', 'charitio-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Content Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type Content text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section();// end: Section

		$this->start_controls_section(
			'section_event_tab_map',
			[
				'label' => esc_html__( 'Event Tab Map', 'charitio-core' ),
			]
		);
		$this->add_control(
			'map_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Map Location', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'map_content',
			[
				'label' => esc_html__( 'Map iframe', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( ' <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.9147703055!2d-74.11976314309273!3d40.69740344223377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbd!4v1547528325671" allowfullscreen></iframe>', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type ifram text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section();// end: Section

		$this->start_controls_section(
			'section_event_tab_contact',
			[
				'label' => esc_html__( 'Event Tab Contact', 'charitio-core' ),
			]
		);
		$this->add_control(
			'contact_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact Us', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
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
				'selector' => '{{WRAPPER}} .wpo-event-details-tab .nav li a',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-details-tab .nav li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_active_br_color',
			[
				'label' => esc_html__( 'Active Border', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-details-tab .nav li a.active, .wpo-event-details-tab .nav li:hover a' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_br_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-details-tab .nav li a' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wpo-event-details-tab .nav li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .wpo-event-details-content p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-event-details-content p, .wpo-event-details-content ul li' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_line_color',
			[
				'label' => esc_html__( 'Lsit Bullet', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #Schedule ul li:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-event-details-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render EVENTTAB widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$eventtab_title = !empty( $settings['eventtab_title'] ) ? $settings['eventtab_title'] : '';
		$eventtab_content = !empty( $settings['eventtab_content'] ) ? $settings['eventtab_content'] : '';

		$map_title = !empty( $settings['map_title'] ) ? $settings['map_title'] : '';
		$map_content = !empty( $settings['map_content'] ) ? $settings['map_content'] : '';

		$contact_title = !empty( $settings['contact_title'] ) ? $settings['contact_title'] : '';
		$form_id = !empty( $settings['form_id'] ) ? $settings['form_id'] : '';

		// Turn output buffer on
		ob_start(); ?>
		<div class="wpo-event-details-wrap">
  		<div class="wpo-event-details-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
	        	<?php if ( $eventtab_title ) { ?>
	        		 <li class="nav-item" role="presentation">
	                <a class="nav-link active" id="Schedule-tab" data-bs-toggle="tab" href="#Schedule" role="tab" aria-controls="Schedule" aria-selected="true"><?php echo esc_html( $eventtab_title ); ?></a>
	            </li>
	        	<?php } if ( $map_title ) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="Map-tab" data-bs-toggle="tab" href="#Map" role="tab" aria-controls="Map" aria-selected="false"><?php echo esc_html( $map_title ); ?></a>
            </li>
            <?php } if ( $contact_title ) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="Contact-tab" data-bs-toggle="tab" href="#Contact" role="tab" aria-controls="Contact" aria-selected="false"><?php echo esc_html( $contact_title ); ?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="wpo-event-details-content">
        <div class="tab-content">
            <div id="Schedule" class="tab-pane active">
               <?php echo wp_kses_post( $eventtab_content ); ?>
            </div>
            <div id="Map" class="tab-pane">
                <div class="contact-map">
                <?php 
               		 echo ( $map_content );
                 ?>
                </div>
            </div>
            <div id="Contact" class="tab-pane">
                <div class="event-contact">
                    <div class="wpo-donations-details">
                       	<?php echo do_shortcode( '[contact-form-7 id="'. $form_id .'"]' ); ?>
                    </div>
                </div>
            </div>
        </div>
    	</div>
		</div>
		<?php 
		// Return outbut buffer
		echo ob_get_clean();
		
	}
	/**
	 * Render EVENTTAB widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_EVENTTAB() );