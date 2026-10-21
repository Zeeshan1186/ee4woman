<?php
/*
 * Elementor Charitio Video Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Video extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_video';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Video', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-video-playlist';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Video widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['tmx-charitio_video'];
	}
	*/
	
	/**
	 * Register Charitio Video widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_Video',
			[
				'label' => esc_html__( 'Video Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'video_image',
			[
				'label' => esc_html__( 'Video Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'video_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Button Text', 'charitio-core' ),
				'default' => esc_html__( '#', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type button Text here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->end_controls_section();// end: Section

		// Section
		$this->start_controls_section(
			'video_section_bg_style',
			[
				'label' => esc_html__( 'Video Section', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'video_bg_color',
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .charitio-video .wpo-video-section',
			]
		);
		$this->add_control(
			'video_section_padding',
			[
				'label' => esc_html__( 'Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-video .wpo-video-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-video .wpo-video-content h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-video .wpo-video-content h2' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-video .wpo-video-content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		

		// Button
		$this->start_controls_section(
			'section_content_button_style',
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
					'{{WRAPPER}} .charitio-video .wpo-video-content a' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-video .wpo-video-content a' => 'background-color: {{VALUE}};',
				],
			]
		);	
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render Video widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_title = !empty( $settings['video_title'] ) ? $settings['video_title'] : '';
		$btn_link = !empty( $settings['btn_link'] ) ? $settings['btn_link'] : '';	

		$video_image = !empty( $settings['video_image']['id'] ) ? $settings['video_image']['id'] : '';	
		$video_url = wp_get_attachment_url( $video_image );
		$video_alt = get_post_meta( $video_image, '_wp_attachment_image_alt', true);

		// Turn output buffer on
		ob_start(); ?>
		<div class="wpo-about-video-area">
	    <div class="container">
	        <div class="row justify-content-center">
	            <div class="col-lg-8">
	                <div class="wpo-about-video-item">
	                    <div class="wpo-about-video-img">
	                        <?php 
	                        if( $video_url ) { echo '<img src="'.esc_url( $video_url ).'" alt="'.esc_url( $video_alt ).'">'; } 
	                        if ( $btn_link ) { ?>
	                        <div class="entry-media video-holder">
	                            <a href="<?php echo esc_url( $btn_link ); ?>" class="video-btn" data-type="iframe">
	                                <i class=""></i>
	                            </a>
	                        </div>
	                       <?php } ?>
	                    </div>
	                    <?php 
	                    	if( $video_title ) { echo '<h2>'.wp_kses_post( $video_title ).'</h2>'; }
                    	?>
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
	 * Render Video widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Video() );