<?php
/*
 * Elementor Charitio Causes Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Causes extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_causes';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Causes', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'ti-briefcase';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Causes widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_causes'];
	}

	/**
	 * Register Charitio Causes widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){


		$posts = get_posts( 'post_type="give_forms"&numberposts=-1' );
    $PostID = array();
    if ( $posts ) {
      foreach ( $posts as $post ) {
        $PostID[ $post->ID ] = $post->ID;
      }
    } else {
      $PostID[ __( 'No ID\'s found', 'charitio' ) ] = 0;
    }


		$this->start_controls_section(
			'section_causes_listing',
			[
				'label' => esc_html__( 'Causes Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'causes_limit',
			[
				'label' => esc_html__( 'Causes Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'causes_order',
			[
				'label' => __( 'Order', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__( 'Asending', 'charitio-core' ),
					'DESC' => esc_html__( 'Desending', 'charitio-core' ),
				],
				'default' => 'DESC',
			]
		);
		$this->add_control(
			'causes_orderby',
			[
				'label' => __( 'Order By', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'charitio-core' ),
					'ID' => esc_html__( 'ID', 'charitio-core' ),
					'author' => esc_html__( 'Author', 'charitio-core' ),
					'title' => esc_html__( 'Title', 'charitio-core' ),
					'date' => esc_html__( 'Date', 'charitio-core' ),
				],
				'default' => 'date',
			]
		);
		$this->add_control(
			'causes_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->end_controls_section();// end: Section

		

		// Campain Title
		$this->start_controls_section(
			'section_campain_title_style',
			[
				'label' => esc_html__( 'Campain Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_campain_title_typography',
				'selector' => '{{WRAPPER}} .wpo-campaign-area .wpo-campaign-content h2 a',
			]
		);
		$this->add_control(
			'campain_content_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .wpo-campaign-content h2 a' => 'color: {{VALUE}};',
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
			]
		);
		$this->add_control(
			'prograss_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .progress' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'prograss_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .progress .progress-bar' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Number
		$this->start_controls_section(
			'section_content_number_style',
			[
				'label' => esc_html__( 'Number', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_content_number_typography',
				'selector' => '{{WRAPPER}} .wpo-campaign-area .wpo-campaign-text-top ul li',
			]
		);
		$this->add_control(
			'content_number_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .wpo-campaign-text-top ul li' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Tags
		$this->start_controls_section(
			'section_tag_style',
			[
				'label' => esc_html__( 'Tag', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'tag_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .wpo-campaign-item .wpo-campaign-img .thumb' => 'color: {{VALUE}};',
				],
			]
		);
	$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tag_bg_color',
				'label' => esc_html__( 'Background', 'charitio-core' ),
				'types' => [  'gradient' ],
				'selector' => '{{WRAPPER}} .wpo-campaign-area .wpo-campaign-item .wpo-campaign-img .thumb',
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
					'{{WRAPPER}} .wpo-campaign-area .campaign-btn ul li a.e-btn' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .campaign-btn ul li a.e-btn' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_br_color',
			[
				'label' => esc_html__( 'Border Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-campaign-area .campaign-btn ul li a.e-btn' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section


	}

	/**
	 * Render Causes widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$causes_limit = !empty( $settings['causes_limit'] ) ? $settings['causes_limit'] : '';
		$causes_order = !empty( $settings['causes_order'] ) ? $settings['causes_order'] : '';
		$causes_orderby = !empty( $settings['causes_orderby'] ) ? $settings['causes_orderby'] : '';
		$causes_show_id = !empty( $settings['causes_show_id'] ) ? $settings['causes_show_id'] : [];

		// Turn output buffer on
		ob_start();

		// Pagination
		global $paged;
		if( get_query_var( 'paged' ) )
		  $my_page = get_query_var( 'paged' );
		else {
		  if( get_query_var( 'page' ) )
			$my_page = get_query_var( 'page' );
		  else
			$my_page = 1;
		  set_query_var( 'paged', $my_page );
		  $paged = $my_page;
		}

    if ($causes_show_id) {
			$causes_show_id = json_encode( $causes_show_id );
			$causes_show_id = str_replace(array( '[', ']' ), '', $causes_show_id);
			$causes_show_id = str_replace(array( '"', '"' ), '', $causes_show_id);
      $causes_show_id = explode(',',$causes_show_id);
    } else {
      $causes_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'give_forms',
		  'posts_per_page' => (int)$causes_limit,
		  'orderby' => $causes_orderby,
		  'order' => $causes_order,
      'post__in' => $causes_show_id,
		);

		$charitio_causes = new \WP_Query( $args );

	 	?>
		<div class="wpo-campaign-area">
    	<div class="container">
        <div class="wpo-campaign-wrap">
          <div class="row">
		 			<?php
						if ( $charitio_causes->have_posts()) : while ( $charitio_causes->have_posts()) : $charitio_causes->the_post();

						$causes_options = get_post_meta( get_the_ID(), 'causes_options', true );
	          $causes_image = isset( $causes_options['causes_image']) ? $causes_options['causes_image'] : '';
	          $case_form_tag = isset( $causes_options['case_form_tag']) ? $causes_options['case_form_tag'] : '';
	          global $post;
	          $image_url = wp_get_attachment_url( $causes_image );
	          $image_alt = get_post_meta( $causes_image , '_wp_attachment_image_alt', true);

						if ( class_exists( 'Give_Donate_Form' ) ) {
							$form        = new \Give_Donate_Form( get_the_ID() );
							$goal_option = get_post_meta( get_the_ID(), '_give_goal_option', true );
							$goal        = $form->goal;
							$goal        = (int) $goal;
							$goal_format = get_post_meta( get_the_ID(), '_give_goal_format', true );
							$income      = $form->get_earnings();
							$color       = get_post_meta( get_the_ID(), '_give_goal_color', true );
						
							if ( $goal > 0 ) {
								$progress = round( ( $income / $goal ) * 100, 2 );
								if ( $income >= $goal ) {
								  $progress = 100;
								}
							}

							$customer_id = function_exists( 'give_get_payment_donor_id' ) ? give_get_payment_donor_id( get_the_ID() ) : 0;
							$income = function_exists( 'give_human_format_large_amount' ) ? give_human_format_large_amount( give_format_amount( $income ) ) : $income;
							$goal = function_exists( 'give_human_format_large_amount' ) ? give_human_format_large_amount( give_format_amount( $goal ) ) : $goal;
							$payment_mode = function_exists( 'give_get_chosen_gateway' ) ? give_get_chosen_gateway( get_the_ID() ) : '';
							$form_action = function_exists( 'give_get_current_page_url' ) ? add_query_arg( apply_filters( 'give_form_action_args', array( 'payment-mode' => $payment_mode, ) ),  give_get_current_page_url() ) : '#';
						} else {
							$goal = 0;
							$income = 0;
							$progress = 0;
							$form_action = '#';
						}

						// remaining date
						$dead_line = get_post_meta( get_the_ID(), '_donation_form_metabox', true );
						$donation_deadline = $dead_line['donation_deadline'];
						$deadline = str_replace('/', '-', $donation_deadline);
						$deadline = date('F d, Y', strtotime($deadline));

						$date = strtotime($deadline);
						$remaining = $date - time();

						$days_remaining = floor($remaining / 86400);
						$hours_remaining = floor(($remaining % 86400) / 3600);
						$display_label_field = get_post_meta( get_the_ID(), '_give_checkout_label', true );
						$display_label       = ( ! empty( $display_label_field ) ? $display_label_field : esc_html__( 'Donate Now', 'groppe' ) );
						?>
	           <div class="col-lg-4 col-md-6 col-12">
                <div class="wpo-campaign-single">
                    <div class="wpo-campaign-item">
                        <div class="wpo-campaign-img">
                         <?php 
                          if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_attr( $image_alt ).'">'; }
                          if( $case_form_tag ) { echo '<span class="thumb">'.esc_html( $case_form_tag ).'</span>'; } 
                        ?>
                        </div>
                        <div class="wpo-campaign-content">
                            <div class="wpo-campaign-text-top">
                                <h2>
                                	<a href="<?php echo esc_url( get_permalink() ); ?>">
                                		<?php echo esc_html(get_the_title()); ?>
                                	</a>
                                </h2>
                                <div class="progress-section">
                                    <div class="process">
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $progress; ?>%">
                                                <div class="progress-value"><span><?php echo esc_html( $progress ); ?>
                                                </span><?php echo esc_html__( '%','charitio-core' ); ?>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul>
                                   <li><span><?php echo esc_html__( 'Raised:','charitio-core' ); ?></span> <?php echo apply_filters( 'give_goal_amount_raised_output', give_currency_filter( $income ) ); ?></li>
		                                <?php if ( $goal > 0 ) { ?>
		                                <li><span><?php echo esc_html__( 'Goal:','charitio-core' ); ?></span> <?php echo apply_filters( 'give_goal_amount_target_output', give_currency_filter( $goal ) ); ?></li>
		                              	<?php } ?>
                                </ul>
                                <div class="campaign-btn">
                                    <ul>
                                        <li>
																		     <span class="user-img">
																		     	<img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" alt/>
																		     </span>
                                          <span>
                                          <?php echo get_the_author_meta('display_name', get_the_author_meta( 'ID' ) ); ?>
                                          </span>
                                        </li>
                                        <li>
                                        	<a class="e-btn" href="<?php echo esc_url( get_the_permalink() ); ?>">
                                        		<?php echo esc_html( $display_label ); ?>
                                        	</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
			       <?php
						  endwhile;
						  endif;
						  wp_reset_postdata();
						 ?>
		    		</div>
		    	</div>
		    </div>
			</div>
	 		<?php 
			// Return outbut buffer
			echo ob_get_clean();
		}
	/**
	 * Render Causes widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/

	//protected function _content_template(){}

}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Causes() );