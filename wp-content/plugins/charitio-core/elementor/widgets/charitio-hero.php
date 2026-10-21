<?php
/*
 * Elementor Charitio Hero Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Hero extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_hero';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Hero', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-cogs-check';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Hero widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	
	public function get_script_depends() {
		return ['wpo-charitio_hero'];
	}
	
	
	/**
	 * Register Charitio Hero widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_hero',
			[
				'label' => __( 'Hero/Hero Content', 'charitio-core' ),
			]
		);
		$this->add_control(
			'hero_style',
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
			'hero_subtitle',
			[
				'label' => esc_html__( 'Sub Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sub Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type subtitle text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'hero_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'hero_content',
			[
				'label' => esc_html__( 'Content', 'charitio-core' ),
				'default' => esc_html__( 'your content text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'charitio-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_txt',
			[
				'label' => esc_html__( 'Button Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Type your button text here', 'charitio-core' ),
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'charitio-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'charitio-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
				],
			]
		);
		$this->add_control(
			'hero_image',
			[
				'label' => esc_html__( 'Hero Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'hero_image2',
			[
				'label' => esc_html__( 'Hero Image 2', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'condition' => [
					'hero_style' => array('style-one','style-five'),
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set Shape image for Hero.', 'charitio-core'),
			]
		);
		$this->add_control(
			'case_icon',
			[
				'label' => __( 'Icon', 'charitio-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'hero_style' => array('style-one'),
				],
				'default' => [
					'value' => 'fi flaticon-salary',
					'library' => 'solid',
				],
			]
		);
		$this->add_control(
			'case_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'hero_style' => array('style-one'),
				],
				'default' => esc_html__( 'Total Projects', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'case_number',
			[
				'label' => esc_html__( 'Number Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'hero_style' => array('style-one'),
				],
				'default' => esc_html__( '252+', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type number here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'case_shape',
			[
				'label' => esc_html__( 'Case Shape', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'condition' => [
					'hero_style' => array('style-one'),
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->end_controls_section();// end: Section


		$this->start_controls_section(
			'section_hero_carousel',
			[
				'label' => esc_html__( 'Donner Thumb', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'donnar_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Make Donation', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'donner_image',
			[
				'label' => esc_html__( 'Donner Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'charitio-core'),
			]
		);
		$this->add_control(
			'donnarItems_groups',
			[
				'label' => esc_html__( 'Donner', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'donnar_title' => esc_html__( 'Donner', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ donnar_title }}}',
			]
		);
		$this->end_controls_section();// end: Section

			// Hero
		$this->start_controls_section(
			'section_hero_style',
			[
				'label' => esc_html__( 'Hero', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'hero_style' => array('style-one'),
				],
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Shape Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-hero-section-1:before' => 'background-color: {{VALUE}};',
				],
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
				'name' => 'charitio_subtitle_typography',
				'selector' => '{{WRAPPER}} .charitio-hero .wpo-hero-title-top span',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-hero .wpo-hero-title-top span' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'subtitle_padding',
			[
				'label' => esc_html__( 'Sub Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,				
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .charitio-hero .wpo-hero-title-top span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .charitio-hero .wpo-hero-title h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .charitio-hero .wpo-hero-title h2' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .charitio-hero .wpo-hero-title h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .charitio-hero .wpo-hero-subtitle p',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .charitio-hero .wpo-hero-subtitle p' => 'color: {{VALUE}};',
					],
				]
			);
			
		$this->end_controls_section();// end: Section

		// Button Style
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'theme_btn_one',
				'label' => esc_html__( 'Background', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .charitio-hero .btns .theme-btn-s2',
			]
		);
		$this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .charitio-hero .btns .theme-btn-s2' => 'color: {{VALUE}};',
					],
				]
			);
		$this->add_control(
				'button_border_color',
				[
					'label' => esc_html__( 'Border Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .charitio-hero .btns .theme-btn-s2' => 'box-shadow:0 0 0 5px {{VALUE}};',
					],
				]
			);
		$this->end_controls_section();// end: Section

		// Button Style 1	
		$this->start_controls_section(
			'section_project_style',
			[
				'label' => esc_html__( 'Project Style', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'hero_style' => array('style-one'),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'project_bg',
				'label' => esc_html__( 'Background', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .wpo-hero-section-1 .right-vec .right-items-wrap .right-item .wpo-total-project',
			]
		);
		$this->add_control(
				'icon_bg_color',
				[
					'label' => esc_html__( 'Icon BG Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-hero-section-1 .right-vec .right-items-wrap .right-item .wpo-total-project .wpo-total-project-wrap .wpo-total-project-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
		$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-hero-section-1 .right-vec .right-items-wrap .right-item .wpo-total-project .wpo-total-project-wrap .wpo-total-project-icon i:before' => 'color: {{VALUE}};',
					],
				]
			);
		$this->add_control(
				'number_color',
				[
					'label' => esc_html__( 'number Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-hero-section-1 .right-vec .right-items-wrap .right-item .wpo-total-project .wpo-total-project-wrap h3' => 'color: {{VALUE}};',
					],
				]
			);
		$this->add_control(
				'desc_color',
				[
					'label' => esc_html__( 'Description Color', 'charitio-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpo-hero-section-1 .right-vec .right-items-wrap .right-item .wpo-total-project .wpo-total-project-wrap p' => 'color: {{VALUE}};',
					],
				]
			);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render App Works widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$donnarItems_groups = !empty( $settings['donnarItems_groups'] ) ? $settings['donnarItems_groups'] : [];
		$hero_style = !empty( $settings['hero_style'] ) ? $settings['hero_style'] : '';

		$hero_subtitle = !empty( $settings['hero_subtitle'] ) ? $settings['hero_subtitle'] : '';	
		$hero_title = !empty( $settings['hero_title'] ) ? $settings['hero_title'] : '';	
		$hero_content = !empty( $settings['hero_content'] ) ? $settings['hero_content'] : '';	

		$case_title = !empty( $settings['case_title'] ) ? $settings['case_title'] : '';	
		$case_number = !empty( $settings['case_number'] ) ? $settings['case_number'] : '';	

		$case_icon = !empty( $settings['case_icon']['value'] ) ? $settings['case_icon']['value'] : '';
		$case_svg_url = !empty( $settings['case_icon']['value']['url'] ) ? $settings['case_icon']['value']['url'] : '';
		$svg_alt = get_post_meta( $case_svg_url , '_wp_attachment_image_alt', true);

		$bg_hero = !empty( $settings['hero_image']['id'] ) ? $settings['hero_image']['id'] : '';	
		$bg_hero2 = !empty( $settings['hero_image2']['id'] ) ? $settings['hero_image2']['id'] : '';	
		$bg_shape = !empty( $settings['case_shape']['id'] ) ? $settings['case_shape']['id'] : '';	

		// Image
		$hero_url = wp_get_attachment_url( $bg_hero );
		$hero_alt = get_post_meta( $bg_hero , '_wp_attachment_image_alt', true);

		// Image
		$hero2_url = wp_get_attachment_url( $bg_hero2 );
		$hero2_alt = get_post_meta( $bg_hero2 , '_wp_attachment_image_alt', true);

		// Image
		$shape_url = wp_get_attachment_url( $bg_shape );
		$shape_alt = get_post_meta( $bg_shape , '_wp_attachment_image_alt', true);

		$button_text = !empty( $settings['btn_txt'] ) ? $settings['btn_txt'] : '';
		$button_link = !empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '';
		$button_link_external = !empty( $settings['button_link']['is_external'] ) ? 'target="_blank"' : '';
		$button_link_nofollow = !empty( $settings['button_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$button_link_attr = !empty( $button_link ) ?  $button_link_external.' '.$button_link_nofollow : '';

		$button_one = $button_link ? '<a href="'.esc_url($button_link).'" '.$button_link_attr.' class="btn theme-btn-s2" >'. $button_text .'</a>' : '';


		// Turn output buffer on
		ob_start();

		if ( $hero_style == 'style-one' ) { ?>
		<div class="charitio-hero wpo-hero-section-1">
	    <div class="container-fluid">
	        <div class="row align-items-center">
	            <div class="col col-xs-6 col-lg-6">
	                <div class="wpo-hero-section-text">
	                    <div class="wpo-hero-title-top">
	                    	<?php if( $hero_subtitle ) { echo '<span>'.esc_html( $hero_subtitle ).'</span>'; } ?>
	                    </div>

	                    <div class="wpo-hero-title">
	                    	<?php if( $hero_title ) { echo '<h2>'.esc_html( $hero_title ).'</h2>'; } ?>
	                    </div>
	                    <div class="wpo-hero-subtitle">
	                      	<?php if( $hero_content ) { echo '<p>'.esc_html( $hero_content ).'</p>'; } ?>
	                    </div>
	                    <div class="btns">
	                    	<?php echo $button_one; ?>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-6">
	                <div class="right-vec">
	                    <div class="right-items-wrap">
	                        <div class="right-item">
	                            <div class="r-img">
	                            	<?php if( $hero_url ) { echo '<img src="'.esc_url( $hero_url ).'" alt="'.esc_url( $hero_alt ).'">'; } ?>
	                            </div>
	                            <div class="wpo-happy-client">
	                                <div class="wpo-happy-client-img">
	                                    <ul class="wpo-happy-client-slide owl-carousel">
	                                    	<?php 
									           						// Group Param Output
																				if( is_array( $donnarItems_groups ) && !empty( $donnarItems_groups ) ){
																				foreach ( $donnarItems_groups as $each_item ) { 

																				$bg_image = !empty( $each_item['donner_image']['id'] ) ? $each_item['donner_image']['id'] : '';	
																				// Image
																				$image_url = wp_get_attachment_url( $bg_image );
																				$image_alt = get_post_meta( $bg_image, '_wp_attachment_image_alt', true);

																				?>
                                        <li>
                                        	<?php if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_url( $image_alt ).'">'; } ?>
                                        </li>
																        <?php }
																				} ?>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="right-item">
	                            <div class="wpo-total-project">
	                                <div class="wpo-total-project-wrap">
	                                    <div class="wpo-total-project-icon">
	                                      <?php
	                                       if ( $case_svg_url ) { 
													            			 echo '<img src="'.esc_url( $case_svg_url ).'" alt="'.esc_url( $svg_alt ).'">';
													            		} else {
													            			echo '<i class="'.esc_attr( $case_icon ).'"></i>';
													            		} 
	                                       ?>
	                                    </div>
	                                    <div class="wpo-total-project-text">
	                                    <?php 
	                                    	if( $case_number ) { echo '<h3>'.esc_html( $case_number ).'</h3>'; }
	                                    	if( $case_title ) { echo '<p>'.esc_html( $case_title ).'</p>'; }
	                                    ?>
	                                    </div>
	                                </div>
	                                <div class="project-shape">
	                                  <?php if( $shape_url ) { echo '<img src="'.esc_url( $shape_url ).'" alt="'.esc_url( $shape_alt ).'">'; } ?>
	                                </div>
	                            </div>
	                            <div class="r-img">
	                              <?php if( $hero2_url ) { echo '<img src="'.esc_url( $hero2_url ).'" alt="'.esc_url( $hero2_alt ).'">'; } ?>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
		</div>
		<?php } elseif ( $hero_style == 'style-two' ) { ?>
			<div class="charitio-hero wpo-hero-section-2">
		    <div class="container-fluid">
		        <div class="row align-items-center">
		            <div class="col col-xs-6 col-lg-6">
		                <div class="wpo-hero-section-text">
		                    <div class="wpo-hero-title">
		                        <?php if( $hero_title ) { echo '<h2>'.wp_kses_post( $hero_title ).'</h2>'; } ?>
		                    </div>
		                    <div class="wpo-hero-subtitle">
		                        <?php if( $hero_content ) { echo '<p>'.esc_html( $hero_content ).'</p>'; } ?>
		                    </div>
		                    <div class="btns">
		                        <?php echo $button_one; ?>
		                    </div>
		                </div>
		            </div>
		            <div class="col-lg-6">
		                <div class="right-vec">
		                    <div class="right-items-wrap">
		                        <div class="right-item">
		                            <div class="r-img">
		                              <?php if( $hero_url ) { echo '<img src="'.esc_url( $hero_url ).'" alt="'.esc_url( $hero_alt ).'">'; } ?>
		                            </div>
		                            <?php 
					           						// Group Param Output
					           						$id = 0;
																if( is_array( $donnarItems_groups ) && !empty( $donnarItems_groups ) ){
																foreach ( $donnarItems_groups as $each_item ) { 
																$id++;
																$bg_image = !empty( $each_item['donner_image']['id'] ) ? $each_item['donner_image']['id'] : '';	
																// Image
																$image_url = wp_get_attachment_url( $bg_image );
																$image_alt = get_post_meta( $bg_image, '_wp_attachment_image_alt', true);

																?>
		                            <div class="sp-<?php echo $id; ?>">
		                            	<?php if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_url( $image_alt ).'">'; } ?>
		                            </div>
		                            <?php }
																} ?>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<?php } elseif ( $hero_style == 'style-three' ) { ?>
			<div class="wpo-hero-section-3">
	    <div class="container-fluid">
	        <div class="row align-items-center">
	            <div class="col col-xs-6 col-lg-6">
	                <div class="wpo-hero-section-text">
	                    <div class="wpo-hero-title">
	                      <?php if( $hero_title ) { echo '<h2>'.wp_kses_post( $hero_title ).'</h2>'; } ?>
	                    </div>
	                    <div class="wpo-hero-subtitle">
	                      <?php if( $hero_content ) { echo '<p>'.esc_html( $hero_content ).'</p>'; } ?>
	                    </div>
	                    <div class="btns">
	                    	<?php echo $button_one; ?>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-6">
	                <div class="right-vec">
	                    <?php if( $hero_url ) { echo '<div class="right-tiger-img">
	                        <div class="r-img"><img src="'.esc_url( $hero_url ).'" alt="'.esc_url( $hero_alt ).'"></div>
	                    </div>'; } ?>
	                </div>
	            </div>
	        </div>
	    </div>
	    <?php 
				// Group Param Output
				$id = 0;
			if( is_array( $donnarItems_groups ) && !empty( $donnarItems_groups ) ){
			foreach ( $donnarItems_groups as $each_item ) { 
			$id++;
			$bg_image = !empty( $each_item['donner_image']['id'] ) ? $each_item['donner_image']['id'] : '';	
			// Image
			$image_url = wp_get_attachment_url( $bg_image );
			$image_alt = get_post_meta( $bg_image, '_wp_attachment_image_alt', true);

			?>
      <div class="sd-<?php echo $id; ?>">
      	<?php if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_url( $image_alt ).'">'; } ?>
      </div>
      <?php }
			} ?>
		</div>
		<?php } elseif ( $hero_style == 'style-four' ) { ?>
		<div class="wpo-hero-section-4">
      <div class="container-fluid">
          <div class="row align-items-center">
              <div class="col col-xs-6 col-lg-6">
                  <div class="wpo-hero-section-text">
                      <div class="wpo-hero-title">
                        <?php if( $hero_title ) { echo '<h2>'.wp_kses_post( $hero_title ).'</h2>'; } ?>
                      </div>
                      <div class="wpo-hero-subtitle">
                        <?php if( $hero_content ) { echo '<p>'.esc_html( $hero_content ).'</p>'; } ?>
                      </div>
                      <div class="btns">
                      	<?php echo $button_one; ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  	</div>
		<?php } else { ?>
			<div class="wpo-hero-section-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col col-xs-6 col-lg-6">
                    <div class="wpo-hero-section-text">
                        <div class="wpo-hero-title-top">
                          <?php if( $hero_subtitle ) { echo '<span>'.esc_html( $hero_subtitle ).'</span>'; } ?>
                        </div>
                        <div class="wpo-hero-title">
                          <?php if( $hero_title ) { echo '<h2>'.wp_kses_post( $hero_title ).'</h2>'; } ?>
                        </div>
                        <div class="wpo-hero-subtitle">
                          <?php if( $hero_content ) { echo '<p>'.esc_html( $hero_content ).'</p>'; } ?>
                        </div>
                        <div class="btns">
                        	<?php echo $button_one; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-vec">
                        <div class="right-items-wrap">
                            <div class="right-item">
                                <div class="r-img">
                                    <?php if( $hero_url ) { echo '<img src="'.esc_url( $hero_url ).'" alt="'.esc_url( $hero_alt ).'">'; } ?>
                                    <div class="r-shape">
                                    	<?php if( $hero2_url ) { echo '<img src="'.esc_url( $hero2_url ).'" alt="'.esc_url( $hero2_alt ).'">'; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<?php } 
		// Return outbut buffer
		echo ob_get_clean();
		
	}
	/**
	 * Render Hero widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Hero() );