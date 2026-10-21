<?php
/*
 * Elementor Charitio Contactinfo Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Contactinfo extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_contactinfo';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Contact Info', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-icon-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Contactinfo widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_contactinfo'];
	}
	
	/**
	 * Register Charitio Contactinfo widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_contactinfo',
			[
				'label' => esc_html__( 'Contactinfo Options', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'contactinfo_icon',
			[
				'label' => __( 'Icon', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fi flaticon-placeholder',
					'library' => 'solid',
				],
			]
		);
		$repeater->add_control(
			'contactinfo_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '24/7 customer support.', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'contactinfo_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'default' => esc_html__( 'your content text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);
		$this->add_control(
			'contactinfoItems_groups',
			[
				'label' => esc_html__( 'Contactinfo Icons', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'contactinfo_title' => esc_html__( 'Contactinfo', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ contactinfo_title }}}',
			]
		);
		$this->end_controls_section();// end: Section
		

		$this->start_controls_section(
			'section_contactinfo_section_style',
			[
				'label' => esc_html__( 'Contactinfo BG', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]

		);
		$this->add_control(
			'contactinfo_item_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .office-info .office-info-item' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section


		// Contactinfo Icons
		$this->start_controls_section(
			'section_contactinfo_icon_section_style',
			[
				'label' => esc_html__( 'Icon BG', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'contactinfo_item_icon_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .office-info .office-info-item .office-info-icon' => 'background-color: {{VALUE}};',
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
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_title_typography',
				'selector' => '{{WRAPPER}} .office-info .office-info-item .office-info-text h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .office-info .office-info-item .office-info-text h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_padding',
			[
				'label' => __( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .office-info .office-info-item .office-info-text h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .office-info .office-info-item .office-info-text p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .office-info .office-info-item .office-info-text p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
	}

	/**
	 * Render Contactinfo widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$contactinfoItems_groups = !empty( $settings['contactinfoItems_groups'] ) ? $settings['contactinfoItems_groups'] : [];
		// Turn output buffer on
	
		ob_start(); ?>
		<div class="office-info">
	    <div class="row">
	        <?php
        		// Group Param Output
						if( is_array( $contactinfoItems_groups ) && !empty( $contactinfoItems_groups ) ){
						foreach ( $contactinfoItems_groups as $each_item ) { 	
						$contactinfo_title = !empty( $each_item['contactinfo_title'] ) ? $each_item['contactinfo_title'] : '';
						$contactinfo_content = !empty( $each_item['contactinfo_content'] ) ? $each_item['contactinfo_content'] : '';
						$contactinfo_icon = !empty( $each_item['contactinfo_icon']['value'] ) ? $each_item['contactinfo_icon']['value'] : '';
						$contactinfo_svg_url = !empty( $each_item['contactinfo_icon']['value']['url'] ) ? $each_item['contactinfo_icon']['value']['url'] : '';
						$svg_alt = get_post_meta( $contactinfo_svg_url , '_wp_attachment_image_alt', true);
					?>
	        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
	            <div class="office-info-item">
	                <div class="office-info-icon">
	                    <div class="icon">
	                       <?php
                         	if ( $contactinfo_svg_url ) { 
				            			 echo '<img class="img-responsive default-icon"  src="'.esc_url( $contactinfo_svg_url ).'" alt="'.esc_url( $svg_alt ).'">';
					            		} else {
					            			echo '<i class="'.esc_attr( $contactinfo_icon ).'"></i>';
					            		} 
                        ?>
	                    </div>
	                </div>
	                <div class="office-info-text">
	                    <?php 
				            	if( $contactinfo_title ) { echo '<h2>'.esc_html( $contactinfo_title ).'</h2>'; }
				            	if( $contactinfo_content ) { echo wp_kses_post( $contactinfo_content ); }
				             ?>
	                </div>
	            </div>
	        </div>
	        <?php }
					} ?>
	    </div>
		</div>
		<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Contactinfo widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Contactinfo() );