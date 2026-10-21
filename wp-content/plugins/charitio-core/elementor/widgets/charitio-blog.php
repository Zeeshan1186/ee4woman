<?php
/*
 * Elementor Charitio Blog Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Blog extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_blog';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Blog', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-single-post';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Blog widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_blog'];
	}
	
	/**
	 * Register Charitio Blog widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$posts = get_posts( 'post_type="post"&numberposts=-1' );
    $PostID = array();
    if ( $posts ) {
      foreach ( $posts as $post ) {
        $PostID[ $post->ID ] = $post->ID;
      }
    } else {
      $PostID[ __( 'No ID\'s found', 'charitio' ) ] = 0;
    }
		
		
		$this->start_controls_section(
			'section_blog_metas',
			[
				'label' => esc_html__( 'Meta\'s Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'blog_image',
			[
				'label' => esc_html__( 'Image', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'charitio-core' ),
				'label_off' => esc_html__( 'Hide', 'charitio-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'blog_date',
			[
				'label' => esc_html__( 'Date', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'charitio-core' ),
				'label_off' => esc_html__( 'Hide', 'charitio-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'blog_author',
			[
				'label' => esc_html__( 'Tags', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'charitio-core' ),
				'label_off' => esc_html__( 'Hide', 'charitio-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->end_controls_section();// end: Section


		$this->start_controls_section(
			'section_blog_listing',
			[
				'label' => esc_html__( 'Listing Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'blog_limit',
			[
				'label' => esc_html__( 'Blog Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'blog_order',
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
			'blog_orderby',
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
			'blog_show_category',
			[
				'label' => __( 'Certain Categories?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => Controls_Helper_Output::get_terms_names( 'category'),
				'multiple' => true,
			]
		);
		$this->add_control(
			'blog_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->add_control(
			'blog_pagination',
			[
				'label' => esc_html__( 'Pagination', 'charitio-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'charitio-core' ),
				'label_off' => esc_html__( 'Hide', 'charitio-core' ),
				'return_value' => 'true',
				'default' => 'true',
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
				'selector' => '{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-top h2 a',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-top h2 a,.blog-pg-section .entry-meta li a,.blog-pg-section .entry-meta li' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-top h2 a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// User
		$this->start_controls_section(
			'section_user_title_style',
			[
				'label' => esc_html__( 'User', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'charitio_user_title_typography',
				'selector' => '{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-btm-left-text h4 ',
			]
		);
		$this->add_control(
			'user_title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-btm-left-text h4' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'user_title_padding',
			[
				'label' => __( 'Title Padding', 'charitio-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-btm-left-text h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Date
		$this->start_controls_section(
			'blog_section_date_style',
			[
				'label' => esc_html__( 'Date', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'blog_section_date_typography',
				'selector' => '{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-btm .wpo-blog-content-btm-right span',
			]
		);
		$this->add_control(
			'blog_date_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpo-blog-section .wpo-blog-content .wpo-blog-content-btm .wpo-blog-content-btm-right span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Blog widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();

		$blog_limit = !empty( $settings['blog_limit'] ) ? $settings['blog_limit'] : '';
		$blog_image  = ( isset( $settings['blog_image'] ) && ( 'true' == $settings['blog_image'] ) ) ? true : false;
		$blog_date  = ( isset( $settings['blog_date'] ) && ( 'true' == $settings['blog_date'] ) ) ? true : false;
		$blog_author  = ( isset( $settings['blog_author'] ) && ( 'true' == $settings['blog_author'] ) ) ? true : false;

		$blog_order = !empty( $settings['blog_order'] ) ? $settings['blog_order'] : '';
		$blog_orderby = !empty( $settings['blog_orderby'] ) ? $settings['blog_orderby'] : '';
		$blog_show_category = !empty( $settings['blog_show_category'] ) ? $settings['blog_show_category'] : [];
		$blog_show_id = !empty( $settings['blog_show_id'] ) ? $settings['blog_show_id'] : [];
		$blog_pagination  = ( isset( $settings['blog_pagination'] ) && ( 'true' == $settings['blog_pagination'] ) ) ? true : false;

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

    if ($blog_show_id) {
			$blog_show_id = json_encode( $blog_show_id );
			$blog_show_id = str_replace(array( '[', ']' ), '', $blog_show_id);
			$blog_show_id = str_replace(array( '"', '"' ), '', $blog_show_id);
      $blog_show_id = explode(',',$blog_show_id);
    } else {
      $blog_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'post',
		  'posts_per_page' => (int)$blog_limit,
		  'category' => implode(',', $blog_show_category),
		  'orderby' => $blog_orderby,
		  'order' => $blog_order,
      'post__in' => $blog_show_id,
		);

		$charitio_post = new \WP_Query( $args ); ?>
		<div class="wpo-blog-section">
    	<div class="container">
	      <div class="wpo-blog-items">
	       <div class="row">
				<?php 
				  if ($charitio_post->have_posts()) : while ($charitio_post->have_posts()) : $charitio_post->the_post();
				  $large_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' );
				  $large_alt = get_post_meta( get_post_thumbnail_id(get_the_ID()) , '_wp_attachment_image_alt', true); 
				  $large_image = $large_image[0];  

				  $post_options = get_post_meta( get_the_ID(), 'post_options', true );
					$grid_image = isset( $post_options['grid_image'] ) ? $post_options['grid_image'] : '';
					$image_url = wp_get_attachment_url( $grid_image );
          $image_alt = get_post_meta( $grid_image , '_wp_attachment_image_alt', true); 

          ?>
           <div class="col col-lg-4 col-md-6 col-12">
              <div class="wpo-blog-item">
              		<?php if ( $image_url ) { ?>
                  <div class="wpo-blog-img">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr( $image_alt); ?>">
                  </div>
                  <?php } ?>
                  <div class="wpo-blog-content">
                      <div class="wpo-blog-content-top">
                        <h2>
                        	<a href="<?php echo esc_url( get_permalink() ); ?>">
                        		<?php echo esc_html(get_the_title()); ?>
                        	</a>
                        </h2>
                      </div>
                      <div class="wpo-blog-content-btm">
                          <div class="wpo-blog-content-btm-left">
                          	<?php if ( $blog_author ) { ?>
                          		<div class="wpo-blog-content-btm-left-img">
                                  <img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" alt/>
                              </div>
                              <div class="wpo-blog-content-btm-left-text">
                                  <h4><?php echo get_the_author_meta('display_name', get_the_author_meta( 'ID' ) ); ?></h4>
                              </div>
                          	<?php } ?>
                          </div>
                          <?php if ( $blog_date ) { ?>
                            <div class="wpo-blog-content-btm-right">
                                <span><?php echo esc_html( get_the_date('M d Y') );  ?></span>
                            </div>
                          <?php } ?>
                      </div>
                  </div>
              </div>
          	</div>
						<?php 
					 	endwhile;
					  endif;
					  wp_reset_postdata();
						if ( $blog_pagination ) { ?>
						  <div class="page-pagination-wrap">
						  <?php 	echo '<div class="paginations">';
								$big = 999999999;
								echo paginate_links( array(
	                'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	                'format'    => '?paged=%#%',
	                'total'     => $charitio_post->max_num_pages,
	                'show_all'  => false,
	                'current'   => max( 1, $my_page ),
									'prev_text'    => '<div class="fi flaticon-back"></div>',
									'next_text'    => '<div class="fi flaticon-next"></div>',
	                'mid_size'  => 1,
	                'type'      => 'list'
	              ) );
		        	echo '</div>'; ?>
						  </div>
						<?php } ?>
	    		</div>
	    	</div>
	    </div>
		</div>
		<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Blog widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Blog() );