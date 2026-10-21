<?php
/*
 * Elementor Charitio Client Widget
 * Author & Copyright: wpoceans
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Charitio_Client extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'wpo-charitio_client';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Client', 'charitio-core' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-photo-library';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['wpoceans-category'];
	}

	/**
	 * Retrieve the list of scripts the Charitio Client widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	*/
	public function get_script_depends() {
		return ['wpo-charitio_client'];
	}
	
	/**
	 * Register Charitio Client widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){
		
		$this->start_controls_section(
			'section_client',
			[
				'label' => esc_html__( 'Client Options', 'charitio-core' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'client_title',
			[
				'label' => esc_html__( 'Title Text', 'charitio-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title Text', 'charitio-core' ),
				'placeholder' => esc_html__( 'Type title text here', 'charitio-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'client_logo',
			[
				'label' => esc_html__( 'Logo Image', 'charitio-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				
			]
		);
		$repeater->add_control(
			'client_link',
			[
				'label' => esc_html__( 'Link', 'charitio-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'charitio-core' ),
				'label_block' => true,
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'clientLogos_groups',
			[
				'label' => esc_html__( 'Client Logos', 'charitio-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'client_title' => esc_html__( 'Client', 'charitio-core' ),
					],
					
				],
				'fields' =>  $repeater->get_controls(),
				'title_field' => '{{{ client_title }}}',
			]
		);
		$this->end_controls_section();// end: Section
		
		
	}

	/**
	 * Render Client widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$clientLogos_groups = !empty( $settings['clientLogos_groups'] ) ? $settings['clientLogos_groups'] : [];
		
		// Turn output buffer on
		ob_start();
		 ?>
		<div class="partners-section">
   	 <div class="container">
      <div class="row">
        <div class="col col-xs-12">
          <div class="partner-grids partners-slider owl-carousel">
        	<?php 	// Group Param Output
					if( is_array( $clientLogos_groups ) && !empty( $clientLogos_groups ) ){
						foreach ( $clientLogos_groups as $each_logo ) { 

						$image_url = wp_get_attachment_url( $each_logo['client_logo']['id'] );
						$image_alt = get_post_meta( $each_logo['client_logo']['id'], '_wp_attachment_image_alt', true);

						$image_link = !empty( $each_logo['client_link']['url'] ) ? $each_logo['client_link']['url'] : '';
						$image_link_external = !empty( $each_logo['client_link']['is_external'] ) ? 'target="_blank"' : '';
						$image_link_nofollow = !empty( $each_logo['client_link']['nofollow'] ) ? 'rel="nofollow"' : '';
						$image_link_attr = !empty( $image_link ) ?  $image_link_external.' '.$image_link_nofollow : '';

						?>
		        <div class="grid">
                <?php if( $image_link ) { echo '<a href="'.esc_url( $image_link ).'" '.esc_attr( $image_link_attr ).'>'; } ?>
                   <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                <?php if( $image_link ) { echo '</a>'; } ?>
            </div>
            <?php }
						} ?>
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
	 * Render Client widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	*/
	
	//protected function _content_template(){}
	
}
Plugin::instance()->widgets_manager->register_widget_type( new Charitio_Client() );