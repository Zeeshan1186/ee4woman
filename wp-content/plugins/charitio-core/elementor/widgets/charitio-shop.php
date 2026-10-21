<?php
/*
 * Elementor Charitio Product Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Product extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_product';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Product', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-basket-solid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Product widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_product'];
	}
	
	/**
	 * Register Charitio Product widget controls.
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
			'section_product_listing',
			[
				'label' => esc_html__( 'Listing Options', 'charitio-core' ),
			]
		);
		$this->add_control(
			'product_limit',
			[
				'label' => esc_html__( 'Product Limit', 'charitio-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'description' => esc_html__( 'Enter the number of items to show.', 'charitio-core' ),
			]
		);
		$this->add_control(
			'product_order',
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
			'product_orderby',
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
			'product_show_category',
			[
				'label' => __( 'Certain Categories?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => Controls_Helper_Output::get_terms_names( 'category'),
				'multiple' => true,
			]
		);
		$this->add_control(
			'product_show_id',
			[
				'label' => __( 'Certain ID\'s?', 'charitio-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => [],
				'options' => $PostID,
				'multiple' => true,
			]
		);
		$this->add_control(
			'product_pagination',
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
				'name' => 'sasban_title_typography',
				'selector' => '{{WRAPPER}} .shop-pg-section .details h4 a',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shop-pg-section .details h4 a' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .shop-pg-section .details h4 a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();// end: Section

		// Meta
		$this->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta', 'charitio-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'charitio-core' ),
				'name' => 'sasban_meta_typography',
				'selector' => '{{WRAPPER}} .shop-pg-section .details .price',
			]
		);
		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__( 'Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shop-pg-section .details .price,.shop-pg-section .details del' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .shop-pg-section .cart-details li a' => 'color: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'charitio-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shop-pg-section .cart-details li a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();// end: Section

		
	}

	/**
	 * Render Product widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();

		$product_limit = !empty( $settings['product_limit'] ) ? $settings['product_limit'] : '';

		$product_order = !empty( $settings['product_order'] ) ? $settings['product_order'] : '';
		$product_orderby = !empty( $settings['product_orderby'] ) ? $settings['product_orderby'] : '';
		$product_show_category = !empty( $settings['product_show_category'] ) ? $settings['product_show_category'] : [];
		$product_show_id = !empty( $settings['product_show_id'] ) ? $settings['product_show_id'] : [];
		$product_pagination  = ( isset( $settings['product_pagination'] ) && ( 'true' == $settings['product_pagination'] ) ) ? true : false;
		
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

    if ($product_show_id) {
			$product_show_id = json_encode( $product_show_id );
			$product_show_id = str_replace(array( '[', ']' ), '', $product_show_id);
			$product_show_id = str_replace(array( '"', '"' ), '', $product_show_id);
      $product_show_id = explode(',',$product_show_id);
    } else {
      $product_show_id = '';
    }

		$args = array(
		  // other query params here,
		  'paged' => $my_page,
		  'post_type' => 'product',
		  'posts_per_page' => (int)$product_limit,
		  'category_name' => implode(',', $product_show_category),
		  'orderby' => $product_orderby,
		  'order' => $product_order,
      'post__in' => $product_show_id,
		);

		$charitio_post = new \WP_Query( $args ); ?>
			<div class="shop-pg-section">
    		<div class="shop-grids">
	       <?php 
				  if ($charitio_post->have_posts()) : while ($charitio_post->have_posts()) : $charitio_post->the_post();
				  $product_thumbnail_id    = get_post_thumbnail_id();
					$product_thumbnail_full  = wp_get_attachment_image_src($product_thumbnail_id, 'full'); 
					$product_alt = get_post_meta( $product_thumbnail_id, '_wp_attachment_image_alt', true);
					global $product; 

					?>
					<div class="grid">
            <div class="img-cart">
                <div class="img-holder">
                   <img src="<?php echo esc_url( $product_thumbnail_full[0] ); ?>" alt="<?php echo esc_attr( $product_alt ); ?>">
                </div>
                <div class="cart-details">
                    <ul>
                        <li>
                        	<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="ajax_add_to_cart theme-btn">
                        		<?php echo esc_html( $product->add_to_cart_text() ); ?>
                        	</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="details">
               <h4>
                 	<a href="<?php echo get_the_permalink($product->get_id()); ?>">
                 		<?php echo esc_attr(get_the_title($product->get_id())); ?>
                 	</a>
               </h4>
              <span class="price"><?php echo $product->get_price_html(); ?></span>
            </div>
          </div>
					<?php endwhile;
				  endif;
				  wp_reset_postdata();
					if ($product_pagination) { ?>
					  <div class="page-pagination-wrap text-center">
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
			<?php
			// Return outbut buffer
			echo ob_get_clean();	
		}
	/**
	 * Render Product widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Product() );