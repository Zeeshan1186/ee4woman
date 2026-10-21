<?php
/**
 * Single Service.
 */
global $post;
$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'large' );
$image_alt = get_post_meta( get_post_thumbnail_id( $post->ID ) , '_wp_attachment_image_alt', true);

?>        
<div class="wpo-event-item">
    <div class="wpo-event-img">
       <?php if ( isset( $image_url ) ): ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
        <?php endif ?>
    </div>
    <div class="event-details">
      <?php echo the_content(); ?>
    </div>
</div>