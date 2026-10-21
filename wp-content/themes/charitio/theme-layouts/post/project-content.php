<?php
/**
 * Single Event.
 */
$charitio_large_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' );
$charitio_large_image = $charitio_large_image[0];
$image_alt = get_post_meta( $charitio_large_image, '_wp_attachment_image_alt', true);
$project_options = get_post_meta( get_the_ID(), 'project_options', true );
$project_page_options = get_post_meta( get_the_ID(), 'project_page_options', true );

$charitio_prev_pro = cs_get_option('prev_service');
$charitio_next_pro = cs_get_option('next_servic');
$charitio_prev_pro = ($charitio_prev_pro) ? $charitio_prev_pro : esc_html__('Previous project', 'charitio');
$charitio_next_pro = ($charitio_next_pro) ? $charitio_next_pro : esc_html__('Next project', 'charitio');
$charitio_prev_post = get_previous_post( '', false);
$charitio_next_post = get_next_post( '', false);

?>        
<div class="content-area">
			<div class="project-thumb">
				<?php if ( isset( $charitio_large_image ) ): ?>
        <img src="<?php echo esc_url( $charitio_large_image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
      	<?php endif ?>
			</div>
			<div class="project-article">
     		<?php the_content(); ?>
     </div>
</div> 

 