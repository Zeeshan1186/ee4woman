<?php
/*
 * Elementor Charitio About Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_About extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_about';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'About', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'ti-id-badge';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio About widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_about'];
	}
	
	/**
	 * Register Charitio About widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_about',
			[
				'label' => esc_html__( 'About Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'about_style',
			[
				'label' => esc_html__( 'Hero Style', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Charity', 'charitio-core' ),
					'style-two' => esc_html__( 'Education', 'charitio-core' ),
					'style-three' => esc_html__( 'Wild Life', 'charitio-core' ),
					'style-four' => esc_html__( 'Oceans Polution', 'charitio-core' ),
					'style-five' => esc_html__( 'Corona Virus', 'charitio-core' ),
					'style-six' => esc_html__( 'Nature', 'charitio-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your Hero style.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label' => esc_html__( 'Sub Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sub Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Sub Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'about_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'about_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'default' => esc_html__( 'your content text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Text', 'charitio-core' ),
				'default' => esc_html__( 'button text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type button Text here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Button Link', 'charitio-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'video_btn',
			[
				'label' => esc_html__( 'Video Link', 'charitio-core' ),
				'default' => esc_html__( '#', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type button Link here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'about_style' => array('style-four','style-five'),
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'about_image',
			[
				'label' => esc_html__( 'About Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'about_image2',
			[
				'label' => esc_html__( 'About Image 2', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'about_style' => array('style-three','style-five'),
				],
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'about_image3',
			[
				'label' => esc_html__( 'About Image 3', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'about_style' => array('style-three'),
				],
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'causes_icon',
			[
				'label' => __( 'Icon', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'about_style' => array('style-one','style-two','style-three'),
				],
				'default' => [
					'value' => 'fi flaticon-wallet-filled-money-tool',
					'library' => 'solid',
				],
			]
		);
		$this->add_control(
			'causes_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'about_style' => array('style-one','style-two','style-three'),
				],
				'default' => esc_html__( 'Total Raised.', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'causes_number',
			[
				'label' => esc_html__( 'Number', 'charitio-core' ),
				'default' => esc_html__( '$25000', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'about_style' => array('style-one','style-two','style-three'),
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'causes_prograss',
			[
				'label' => esc_html__( 'Prograss', 'charitio-core' ),
				'default' => esc_html__( '60%', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'about_style' => array('style-one','style-two','style-three'),
				],
				'label_block' => true,
			]
		);
		$this->end_controls_section();// end: Section

		
		// About Section
		$this->start_controls_section(
			'about_section_style',
			[
				'label' => esc_html__( 'Section', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-about.section-padding' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'section_bg_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'about_style' => array('style-three'),
				],
				'selectors' => [
					'{{WRAPPER}} .charitio-about' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'section_five_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'about_style' => array('style-four','style-five'),
				],
				'selectors' => [
					'{{WRAPPER}} .wpo-about-section-s4 .wpo-about-items, .wpo-about-section-s5 .wpo-about-items' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'shap_bg_color',
			[
				'label' => esc_html__( 'left Shape Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'about_style' => array('style-one','style-two'),
				],
				'selectors' => [
					'{{WRAPPER}} .charitio-about:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'square_shape_heading',
			[
				'label' => esc_html__( 'Square Shape Color', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'about_style' => array('style-one','style-six'),
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'square_shape_one',
				'label' => esc_html__( 'Square Shape', 'charitio-core' ),
				'types' => [  'gradient' ],
				'condition' => [
					'about_style' => array('style-one','style-six'),
				],
				'selector' => '{{WRAPPER}} .wpo-about-section .wpo-about-wrap .wpo-about-img .wpo-ab-shape-1 .s-s1, .wpo-about-section-s6 .wpo-about-items .wpo-about-wrap .wpo-about-img .shp-1',
			]
		);
		$this->add_control(
			'square_shape_two_heading',
			[
				'label' => esc_html__( 'Square Shape 2 Color', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'about_style' => array('style-one','style-six'),
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'square_shape_two',
				'label' => esc_html__( 'Square Shape Two ', 'charitio-core' ),
				'types' => [  'gradient' ],
				'condition' => [
					'about_style' => array('style-one','style-six'),
				],
				'selector' => '{{WRAPPER}} .wpo-about-section .wpo-about-wrap .wpo-about-img .wpo-ab-shape-1 .s-s2, .wpo-about-section-s6 .wpo-about-items .wpo-about-wrap .wpo-about-img .shp-2',
			]
		);
		$this->add_control(
			'square_round_heading',
			[
				'label' => esc_html__( 'Round Shape Color', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'about_style' => array('style-two'),
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'round_shape_two',
				'label' => esc_html__( 'Round Shape ', 'charitio-core' ),
				'types' => [  'gradient' ],
				'condition' => [
					'about_style' => array('style-two'),
				],
				'selector' => '{{WRAPPER}} .wpo-about-section-s2 .round-ball-1, .wpo-about-section-s2 .round-ball-2, .wpo-about-section-s2 .round-ball-3, .wpo-about-section-s2 .round-ball-4',
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
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .charitio-about .wpo-about-text span',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'subtitle_padding',
			[
				'label' => esc_html__( 'Sub Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-about .wpo-about-text h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text h2, .charitio-about .wpo-about-text ul li, .charitio-about .wpo-about-text ul li:before' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-about .wpo-about-text h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-about .wpo-about-text p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text p' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-about .wpo-about-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Button
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text .theme-btn-s2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text .theme-btn-s2' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text .theme-btn-s2:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-text .theme-btn-s2:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Prograss
		$this->start_controls_section(
			'section_prograss_style',
			[
				'label' => esc_html__( 'Prograss', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'about_style' => array('style-one','style-two','style-three'),
				],
			]
		);
		$this->add_control(
			'prograss_title_color',
			[
				'label' => esc_html__( 'Title Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-total-raised-text ul li' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_number_color',
			[
				'label' => esc_html__( 'Number Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-wrap .wpo-about-img .wpo-total-raised .wpo-total-raised-wrap .wpo-total-raised-text ul li span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-wrap .wpo-about-img .wpo-total-raised .progress .progress-bar' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_bg_two_color',
			[
				'label' => esc_html__( 'Background 2 Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-wrap .wpo-about-img .wpo-total-raised .progress' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-wrap .wpo-about-img .wpo-total-raised .wpo-total-raised-wrap .wpo-total-raised-icon i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_icon_bg_color',
			[
				'label' => esc_html__( 'Icon BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-about .wpo-about-wrap .wpo-about-img .wpo-total-raised .wpo-total-raised-wrap .wpo-total-raised-icon' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
		
	}

	/**
	 * Render About widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$about_style = !empty( $settings['about_style'] ) ? $settings['about_style'] : '';
		$sub_title = !empty( $settings['sub_title'] ) ? $settings['sub_title'] : '';
		$about_title = !empty( $settings['about_title'] ) ? $settings['about_title'] : '';
		$about_content = !empty( $settings['about_content'] ) ? $settings['about_content'] : '';
		$video_btn = !empty( $settings['video_btn'] ) ? $settings['video_btn'] : '';

		$causes_title = !empty( $settings['causes_title'] ) ? $settings['causes_title'] : '';
		$causes_number = !empty( $settings['causes_number'] ) ? $settings['causes_number'] : '';
		$causes_prograss = !empty( $settings['causes_prograss'] ) ? $settings['causes_prograss'] : '';

		$causes_icon = !empty( $settings['causes_icon']['value'] ) ? $settings['causes_icon']['value'] : '';
		$causes_svg_url = !empty( $settings['causes_icon']['value']['url'] ) ? $settings['causes_icon']['value']['url'] : '';
		$svg_alt = get_post_meta( $causes_svg_url , '_wp_attachment_image_alt', true);

		$bg_image = !empty( $settings['about_image']['id'] ) ? $settings['about_image']['id'] : '';	
		$bg_image2 = !empty( $settings['about_image2']['id'] ) ? $settings['about_image2']['id'] : '';	
		$bg_image3 = !empty( $settings['about_image3']['id'] ) ? $settings['about_image3']['id'] : '';	

		$button_text = !empty( $settings['btn_text'] ) ? $settings['btn_text'] : '';	
		$button_link = !empty( $settings['btn_link']['url'] ) ? $settings['btn_link']['url'] : '';
		$button_link_external = !empty( $settings['btn_link']['is_external'] ) ? 'target="_blank"' : '';
		$button_link_nofollow = !empty( $settings['btn_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$button_link_attr = !empty( $button_link ) ?  $button_link_external.' '.$button_link_nofollow : '';
  
		// Image
		$image_url = wp_get_attachment_url( $bg_image );
		$image_alt = get_post_meta( $settings['about_image']['id'], '_wp_attachment_image_alt', true);
		// Image
		$image2_url = wp_get_attachment_url( $bg_image2 );
		$image2_alt = get_post_meta( $bg_image2, '_wp_attachment_image_alt', true);
		// Image
		$image3_url = wp_get_attachment_url( $bg_image3 );
		$image3_alt = get_post_meta( $bg_image3, '_wp_attachment_image_alt', true);

		$charitio_button = $button_link ? '<a href="'.esc_url($button_link).'" '.$button_link_attr.' class="theme-btn-s2">'.esc_html( $button_text ).'</a>' : '';

		if ( $causes_prograss ) {
			$causes_style = ' style="';
			$causes_style .= ( $causes_prograss ) ? 'width:  '. esc_attr( $causes_prograss ) .';' : '';
			$causes_style .= '"';
		} else {
			$causes_style = '';
		}

		if ( $about_style == 'style-six') {
			$about_class = 'wpo-about-section-s6';
			$about_col = 'col-lg-5 col-md-12 col-12';
		} elseif ( $about_style == 'style-five') {
			$about_class = 'wpo-about-section-s5';
			$about_col = 'col-lg-5 col-md-12 col-12';
		} elseif ( $about_style == 'style-four') {
			$about_class = 'wpo-about-section-s4';
			$about_col = 'col-lg-5 col-md-12 col-12';
		}	elseif ( $about_style == 'style-three') {
			$about_class = 'wpo-about-section-s3';
			$about_col = 'col-lg-6 col-md-12 col-12';
		} elseif ( $about_style == 'style-two') {
			$about_class = 'wpo-about-section-s2';
			$about_col = 'col-lg-6 col-md-12 col-12';
		} else {
			$about_class = 'wpo-about-section';
			$about_col = 'col-lg-6 col-md-12 col-12';
		}

		// Turn output buffer on
		ob_start(); ?>
		<div class="charitio-about section-padding <?php echo esc_attr( $about_class ); ?>">
	    <div class="container">
	    	<?php if ( $about_style == 'style-four' || $about_style == 'style-five' || $about_style == 'style-six' ) { 
	    		echo '<div class="wpo-about-items">';
	    	}?>
	        <div class="row align-items-center">
	            <div class="<?php echo esc_attr( $about_col ); ?>">
	                <div class="wpo-about-wrap">
	                    <div class="wpo-about-img">
	                        <?php if( $image_url ) { echo '<img class="img-responsive" src="'.esc_url( $image_url ).'" alt="'.esc_url( $image_alt ).'">'; } ?>
	                        <?php if ( $about_style == 'style-one' ) { ?>
	                        	<div class="wpo-ab-shape-1">
		                            <div class="s-s1"></div>
		                            <div class="s-s2"></div>
		                        </div>
	                        <?php } if ( $about_style == 'style-one' || $about_style == 'style-two' || $about_style == 'style-three' ) { ?>
	                        <div class="wpo-total-raised">
	                            <div class="wpo-total-raised-wrap">
	                                <div class="wpo-total-raised-icon">
	                                  <?php
							                      	if ( $causes_svg_url ) { 
										            			 echo '<img class="img-responsive default-icon"  src="'.esc_url( $causes_svg_url ).'" alt="'.esc_url( $svg_alt ).'">';
											            		} else {
											            			echo '<i class="'.esc_attr( $causes_icon ).'"></i>';
											            		} 
							                     	?>
	                                </div>
	                                <div class="wpo-total-raised-text">
	                                    <ul>
	                                    	<?php if( $causes_title ) { echo ' <li>'.esc_html( $causes_title ).'<span>'.esc_html( $causes_number ).'</span></li>'; }  ?>
	                                    </ul>
	                                    <div class="progress-section">
	                                        <div class="process">
	                                            <div class="progress">
	                                                <div class="progress-bar" <?php echo $causes_style; ?>>
	                                                    <div class="progress-value"></div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                      	<?php } if ( $about_style == 'style-two' ) { ?>
	                        	<div class="round-ball-1"></div>
		                        <div class="round-ball-2"></div>
		                        <div class="round-ball-3"></div>
		                        <div class="round-ball-4"></div>
	                        <?php } if ( $about_style == 'style-six' ) { ?>
	                        	<div class="shp-1"></div>
                            <div class="shp-2"></div>
	                        <?php } if ( $about_style == 'style-four' || $about_style == 'style-five' ) { ?>
	                        <div class="pop-up-video">
	                        	<?php if ( $video_btn ) { ?>
	                        		<div class="video-holder">
                                  <a href="<?php echo esc_url( $video_btn ); ?>" class="video-btn" data-type="iframe"><i class="fi flaticon-play"></i></a>
                              </div>
	                        	<?php } ?>
                          </div>
                          <?php } ?>
	                    </div>
	                   	<?php if ( $about_style == 'style-five' ) { ?>
                      <div class="ab-shape"> 
                      	<?php if( $image2_url ) { echo '<img src="'.esc_url( $image2_url ).'" alt="'.esc_url( $image2_alt ).'">'; } ?>
                      </div>
                    	<?php } ?>
	                </div>
	            </div>
	            <div class="col-lg-6 col-md-12 col-12">
	                <div class="wpo-about-text">
	                	<?php 
	                    	if( $sub_title ) { echo '<span>'.esc_html( $sub_title ).'</span>'; } 
			                  if( $about_title ) { echo '<h2>'.esc_html( $about_title ).'</h2>'; } 
			                  if( $about_content ) { echo wp_kses_post( $about_content ); } 
			                  echo $charitio_button;
	                    ?>
	                </div>
	            </div>
	        </div>
	        <?php if ( $about_style == 'style-four' || $about_style == 'style-five' || $about_style == 'style-six' ) { 
		    		echo '</div>';
		    	}?>
	    </div>
 			<?php if ( $about_style == 'style-three' ) { ?>
	    <div class="ab-left-img">
        <?php if( $image2_url ) { echo '<img src="'.esc_url( $image2_url ).'" alt="'.esc_url( $image2_alt ).'">'; } ?>
	    </div>
	    <div class="ab-right-img">
	      <?php if( $image3_url ) { echo '<img src="'.esc_url( $image3_url ).'" alt="'.esc_url( $image3_alt ).'">'; } ?>
	    </div>
	  	<?php } ?>
		</div>
		<?php 
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render About widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_About() );