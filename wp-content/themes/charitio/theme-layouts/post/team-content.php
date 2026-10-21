<?php
/**
 * Single Team.
 */
$team_options = get_post_meta( get_the_ID(), 'team_options', true );
$team_infos = isset($team_options['team_infos']) ? $team_options['team_infos'] : '';

$team_title = isset( $team_options['team_title']) ? $team_options['team_title'] : '';
$team_subtitle = isset( $team_options['team_subtitle']) ? $team_options['team_subtitle'] : '';
// Team Page Options
global $post;
$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'large' );
$image_alt = get_post_meta( get_post_thumbnail_id( $post->ID ) , '_wp_attachment_image_alt', true);

?>        
<div class="attorney-pg-area">
    <div class="container">
        <div class="attorney-info-wrap">
            <div class="row align-items-center">
                <div class="col-lg-6">
                  <div class="attorney-info-img">
                    <?php if ( isset( $image_url ) ): ?>
                      <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                    <?php endif ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="attorney-info-text">
                       <?php 
                          if( $team_title ) { echo '<h2>'.esc_html( $team_title ).'</h2>'; }
                        ?>
                      <ul>
                        <?php if ( $team_infos ) {
                          foreach ( $team_infos  as $key => $team_info ) :
                          if( $team_info ) { echo ' <li>'.esc_html( $team_info['info_title'] ).'<span>'.esc_html( $team_info['info_desc'] ).'</span></li>'; } 

                          endforeach;
                        } ?>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="exprience-area">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                     <?php echo the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>