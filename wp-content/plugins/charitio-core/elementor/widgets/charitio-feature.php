<?php
/*
 * Elementor Charitio Feature Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Feature extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_feature';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Feature', 'charitio-core' );
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
	 * Retrieve the list of scripts the Charitio Feature widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_feature'];
	}
	
	/**
	 * Register Charitio Feature widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_feature',
			[
				'label' => esc_html__( 'Feature Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'feature_style',
			[
				'label' => esc_html__( 'Feature Style', 'finco-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style One', 'finco-core' ),
					'style-two' => esc_html__( 'Style Two', 'finco-core' ),
					'style-three' => esc_html__( 'Style Three', 'finco-core' ),
					'style-four' => esc_html__( 'Style Four', 'finco-core' ),
					'style-five' => esc_html__( 'Style Five', 'finco-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your feature style.', 'finco-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'feature_icon',
			[
				'label' => __( 'Icon', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fi flaticon-vegetable',
					'library' => 'solid',
				],
			]
		);
		$repeater->add_control(
			'feature_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Healthy Food.', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'feature_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'default' => esc_html__( 'your content text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'feature_link',
			[
				'label' => esc_html__( 'link', 'charitio-core' ),
				'default' => esc_html__( '#', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your link here', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'featureItems_groups',
			[
				'label' => esc_html__( 'Feature Icons', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'feature_title' => esc_html__( 'Feature', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ feature_title }}}',
			]
		);
		$this->end_controls_section();// end: Section
		

		$this->start_controls_section(
			'section_feature_section_style',
			[
				'label' => esc_html__( 'Feature BG', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]

		);
		$this->add_control(
			'feature_item_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-feature .wpo-features-item' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section


		// Feature Icons
		$this->start_controls_section(
			'section_feature_icon_section_style',
			[
				'label' => esc_html__( 'Icon BG', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]

		);
		$this->add_control(
			'feature_item_icon_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-feature .wpo-features-item .wpo-features-icon i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'feature_item_icon_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-feature .wpo-features-item .wpo-features-icon' => 'background-color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .charitio-feature .wpo-features-text h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-feature .wpo-features-text h2 a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-feature .wpo-features-text h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-feature .wpo-features-text p',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-feature .wpo-features-text p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section
		
	}

	/**
	 * Render Feature widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$featureItems_groups = !empty( $settings['featureItems_groups'] ) ? $settings['featureItems_groups'] : [];
		$feature_style = !empty( $settings['feature_style'] ) ? $settings['feature_style'] : '';
		// Turn output buffer on

		if ( $feature_style == 'style-five') {
			$features_class = 'wpo-features-section-s3';
			$features_col = 'col col-xl-4 col-lg-4 col-sm-6 col-12';
		} elseif ( $feature_style == 'style-four') {
			$features_class = 'wpo-features-section-s5';
			$features_col = 'col col-xl-4 col-lg-4 col-sm-6 col-12';
		} elseif ( $feature_style == 'style-three') {
			$features_class = 'wpo-features-section-s4';
			$features_col = 'col col-xl-4 col-lg-4 col-sm-6 col-12';
		} elseif ( $feature_style == 'style-two') {
			$features_class = 'wpo-features-section-s2';
			$features_col = 'col col-xl-3 col-lg-6 col-sm-6 col-12';
		} else {
			$features_class = 'wpo-features-section-s2 v1';
			$features_col = 'col col-xl-3 col-lg-6 col-sm-6 col-12';
		}
		ob_start(); ?>
		<div class="charitio-feature <?php echo esc_attr( $features_class ); ?>">
    	<div class="container">
        <div class="row">
		      <?php
		      	$id = 0;
        		// Group Param Output
						if( is_array( $featureItems_groups ) && !empty( $featureItems_groups ) ){
						foreach ( $featureItems_groups as $each_item ) { 	
						$id++;
						$feature_subtitle = !empty( $each_item['feature_subtitle'] ) ? $each_item['feature_subtitle'] : '';
						$feature_title = !empty( $each_item['feature_title'] ) ? $each_item['feature_title'] : '';
						$feature_content = !empty( $each_item['feature_content'] ) ? $each_item['feature_content'] : '';
						$feature_link = !empty( $each_item['feature_link'] ) ? $each_item['feature_link'] : '';
						
						$feature_icon = !empty( $each_item['feature_icon']['value'] ) ? $each_item['feature_icon']['value'] : '';
						$feature_svg_url = !empty( $each_item['feature_icon']['value']['url'] ) ? $each_item['feature_icon']['value']['url'] : '';
						$svg_alt = get_post_meta( $feature_svg_url , '_wp_attachment_image_alt', true);

						$bg_icon = !empty( $each_item['icon_image']['id'] ) ? $each_item['icon_image']['id'] : '';	
						// Image
						$image_url = wp_get_attachment_url( $bg_icon );
						$image_alt = get_post_meta( $bg_icon, '_wp_attachment_image_alt', true);

						if ( $feature_link ) {
				      $link_o = '<a href="'. $feature_link .'" class="more">';
				      $link_c = '</a>';
				    } else {
				      $link_o = '';
				      $link_c = '';
				    }
			    
					?>
           <div class="<?php echo esc_attr( $features_col ); ?>">
              <div class="wpo-features-item">
                  <div class="wpo-features-icon">
                      <div class="icon">
                      <?php
                      	if ( $feature_svg_url ) { 
			            			 echo '<img class="img-responsive default-icon"  src="'.esc_url( $feature_svg_url ).'" alt="'.esc_url( $svg_alt ).'">';
				            		} else {
				            			echo '<i class="'.esc_attr( $feature_icon ).'"></i>';
				            		} 
                     	?>
                      </div>
                  </div>
                  <div class="wpo-features-text">
                  	 <?php 
				            	if( $feature_title ) { echo '<h2>'.$link_o.''.esc_html( $feature_title ).''.$link_c.'</h2>'; }
				            	if( $feature_content ) { echo '<p>'.esc_html( $feature_content ).'</p>'; }
				             ?>
                  </div>
              </div>
          </div>
		      <?php }
					} ?>
		  	</div>
		  </div>
		</div>
		<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Feature widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Feature() );