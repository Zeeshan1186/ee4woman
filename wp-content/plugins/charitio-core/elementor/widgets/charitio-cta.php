<?php
/*
 * Elementor Charitio CTA Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_CTA extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_cta';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'CTA', 'charitio-core' );
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
	 * Retrieve the list of scripts the Charitio CTA widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	/*
	public function get_script_depends() {
		return ['tmx-charitio_cta'];
	}
	*/
	
	/**
	 * Register Charitio CTA widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_CTA',
			[
				'label' => esc_html__( 'CTA Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'cta_style',
			[
				'label' => esc_html__( 'CTA Style', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style One', 'charitio-core' ),
					'style-two' => esc_html__( 'Style Two', 'charitio-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your CTA style.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'cta_image',
			[
				'label' => esc_html__( 'CTA Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'cta_shape',
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
		$this->add_control(
			'cta_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
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
		$this->end_controls_section();// end: Section

		// Section
		$this->start_controls_section(
			'cta_section_bg_style',
			[
				'label' => esc_html__( 'CTA Section', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cta_bg_color',
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .charitio-cta .wpo-cta-section',
			]
		);
		$this->add_control(
			'cta_section_padding',
			[
				'label' => esc_html__( 'Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-cta .wpo-cta-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-cta .wpo-cta-content h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-cta .wpo-cta-content h2' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-cta .wpo-cta-content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .charitio-cta .wpo-cta-content a' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-cta .wpo-cta-content a' => 'background-color: {{VALUE}};',
				],
			]
		);	
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render CTA widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$cta_style = !empty( $settings['cta_style'] ) ? $settings['cta_style'] : '';
		$cta_title = !empty( $settings['cta_title'] ) ? $settings['cta_title'] : '';
		$button_text = !empty( $settings['btn_text'] ) ? $settings['btn_text'] : '';	
		$button_link = !empty( $settings['btn_link']['url'] ) ? $settings['btn_link']['url'] : '';

		$cta_image = !empty( $settings['cta_image']['id'] ) ? $settings['cta_image']['id'] : '';	
		$cta_url = wp_get_attachment_url( $cta_image );
		$cta_alt = get_post_meta( $cta_image, '_wp_attachment_image_alt', true);

		$shape_image = !empty( $settings['cta_shape']['id'] ) ? $settings['cta_shape']['id'] : '';	
		$shape_url = wp_get_attachment_url( $shape_image );
		$shape_alt = get_post_meta( $shape_image, '_wp_attachment_image_alt', true);

		$charitio_button = $button_link ? '<a href="'.esc_url($button_link).'" class="theme-btn">'.wp_kses_post( $button_text ).'</a>' : '';
		
		if ( $cta_style == 'style-one') {
		 $cta_class = 'wpo-cta-area';
		} else {
			$cta_class = 'wpo-cta-area-s2';
		}

		// Turn output buffer on
		ob_start(); ?>
		<div class="charitio-cta <?php echo esc_attr( $cta_class ); ?>">
		    <div class="container-fluid">
		        <div class="row">
		            <div class="col-12">
		                <div class="wpo-cta-section">
		                    <div class="wpo-cta-content">
		                    	<?php 
			                    	if( $cta_title ) { echo '<h2>'.esc_html( $cta_title ).'</h2>'; }
			                    	echo $charitio_button;
		                    	?>
		                    </div>
		                    <div class="volunteer-img">
		                      <?php if( $cta_url ) { echo '<img src="'.esc_url( $cta_url ).'" alt="'.esc_url( $cta_alt ).'">'; } ?>
		                    </div>
		                    <div class="shape">
		                    	<?php if( $shape_url ) { echo '<img src="'.esc_url( $shape_url ).'" alt="'.esc_url( $shape_alt ).'">'; } ?>
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
	 * Render CTA widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_CTA() );