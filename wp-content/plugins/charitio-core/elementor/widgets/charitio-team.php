<?php
/*
 * Elementor Charitio Team Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Team extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_team';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Team', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-person';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Team widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_team'];
	}
	
	/**
	 * Register Charitio Team widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){


		$posts = get_posts( 'post_type="team"&numberposts=-1' );
    $PostID = array();
    if ( $posts ) {
      foreach ( $posts as $post ) {
        $PostID[ $post->ID ] = $post->ID;
      }
    } else {
      $PostID[ __( 'No ID\'s found', 'charitio' ) ] = 0;
    }

		$this->start_controls_section(
			'section_team_listing',
			[
				'label' => esc_html__( 'Team Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'team_style',
			[
				'label' => esc_html__( 'Slide Style', 'charitio-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-one' => esc_html__( 'Style Slider', 'charitio-core' ),
					'style-two' => esc_html__( 'Style Grid', 'charitio-core' ),
				],
				'default' => 'style-one',
				'description' => esc_html__( 'Select your Slide style.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'team_limit',
			[
				'label' => esc_html__( 'Team Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'team_order',
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
			'team_orderby',
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
			'team_show_category',
			[
				'label' => __( 'Certain Categories?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => Controls_Helper_Output::get_terms_names( 'team_category'),
				'multiple' => true,
			]
		);
		$this->add_control(
			'team_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->end_controls_section();// end: Section


		// Team Title
		$this->start_controls_section(
			'section_team_title_style',
			[
				'label' => esc_html__( 'Team Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_team_title_typography',
				'selector' => '{{WRAPPER}} .wpo-team-area .wpo-team-item .wpo-team-content h2 a',
			]
		);
		$this->add_control(
			'team_team_title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-team-area .wpo-team-item .wpo-team-content h2 a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Team Subtitle
		$this->start_controls_section(
			'section_team_subtitle_style',
			[
				'label' => esc_html__( 'Team Sub Title', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_team_subtitle_typography',
				'selector' => '{{WRAPPER}} .wpo-team-area .wpo-team-item .wpo-team-content p',
			]
		);
		$this->add_control(
			'team_team_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-team-area .wpo-team-item .wpo-team-content p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Team widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();

		$team_style = !empty( $settings['team_style'] ) ? $settings['team_style'] : '';
		$team_limit = !empty( $settings['team_limit'] ) ? $settings['team_limit'] : '';
		$team_order = !empty( $settings['team_order'] ) ? $settings['team_order'] : '';
		$team_orderby = !empty( $settings['team_orderby'] ) ? $settings['team_orderby'] : '';
		$team_show_category = !empty( $settings['team_show_category'] ) ? $settings['team_show_category'] : [];
		$team_show_id = !empty( $settings['team_show_id'] ) ? $settings['team_show_id'] : [];

		if ( $team_style == 'style-one') {
			$team_wrap = 'wpo-team-area';
			$team_slide = 'team-slider owl-carousel';
		} else {
			$team_wrap = 'wpo-team-area-s2';
			$team_slide = 'team-items';
		}

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

    if ($team_show_id) {
			$team_show_id = json_encode( $team_show_id );
			$team_show_id = str_replace(array( '[', ']' ), '', $team_show_id);
			$team_show_id = str_replace(array( '"', '"' ), '', $team_show_id);
      $team_show_id = explode(',',$team_show_id);
    } else {
      $team_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'team',
		  'posts_per_page' => (int)$team_limit,
		  'category_name' => implode(',', $team_show_category),
		  'orderby' => $team_orderby,
		  'order' => $team_order,
      'post__in' => $team_show_id,
		);

		$charitio_team = new \WP_Query( $args );
		if ( $charitio_team->have_posts()) :
		?>
		<div class="<?php echo esc_attr( $team_wrap ); ?>">
    	<div class="container">
        <div class="wpo-team-wrap">
          <div class="<?php echo esc_attr( $team_slide ); ?>">

            <?php 
            if ( $team_style == 'style-two' ) {
            	echo ' <div class="row">';
            }
						 while ( $charitio_team->have_posts()) : $charitio_team->the_post();
						
							$team_options = get_post_meta( get_the_ID(), 'team_options', true );
							$team_title = isset( $team_options['team_title']) ? $team_options['team_title'] : '';
							$team_subtitle = isset( $team_options['team_subtitle']) ? $team_options['team_subtitle'] : '';
							$team_image = isset( $team_options['team_image']) ? $team_options['team_image'] : '';
							global $post;
							$image_url = wp_get_attachment_url( $team_image );
							$image_alt = get_post_meta( $team_image , '_wp_attachment_image_alt', true);
							if ( $team_style == 'style-two' ) {
	            	echo '<div class="col-lg-3 col-md-6 col-12">';
	            }
						 ?>

          	 <div class="wpo-team-item">
              <div class="wpo-team-img">
                 <?php if( $image_url ) { echo '<img src="'.esc_url( $image_url ).'" alt="'.esc_attr( $image_alt ).'">'; } ?>
              </div>
              <div class="wpo-team-content">
              		<?php 
		            		if( $team_title) { echo '<h2><a href="'.esc_url( get_permalink() ).'">'.esc_html( $team_title ).'</a></h2>'; }
		            		if( $team_subtitle ) { echo '<p>'.esc_html( $team_subtitle ).'</p>'; }
		            	?>
              </div>
          	</div>
						<?php 
						if ( $team_style == 'style-two' ) {
            	echo '</div>';
            }
					  endwhile;
					  wp_reset_postdata();
					  if ( $team_style == 'style-two' ) {
            	echo ' </div>';
            }
					 ?>
			   	 </div>
			  	</div>
				</div>
			</div>
			<?php
			 endif;
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Team widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Team() );