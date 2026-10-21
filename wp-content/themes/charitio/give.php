<?php
/*
 * The template for displaying all pages.
 * Author & Copyright: wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

global $post;
$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'large' );
$image_alt = get_post_meta( get_post_thumbnail_id( $post->ID ) , '_wp_attachment_image_alt', true);

$form = new \Give_Donate_Form( get_the_ID() );
$goal_option = get_post_meta( get_the_ID(), '_give_goal_option', true );
$goal        = $form->goal;
$goal_format = get_post_meta( get_the_ID(), '_give_goal_format', true );
$income      = $form->get_earnings();
$color       = get_post_meta( get_the_ID(), '_give_goal_color', true );
//Sanity check - ensure form has goal set to output
if ( empty( $form->ID ) || ( is_singular( 'give_forms' ) && ! give_is_setting_enabled( $goal_option ) ) || ! give_is_setting_enabled( $goal_option ) || $goal == 0 ) {
  return false;
}
$progress = round( ( $income / $goal ) * 100, 2 );
if ( $income >= $goal ) {
  $progress = 100;
}
$customer_id = give_get_payment_donor_id( get_the_ID() );
$income = give_human_format_large_amount( give_format_amount( $income ) );
$goal = give_human_format_large_amount( give_format_amount( $goal ) );
$payment_mode = give_get_chosen_gateway( get_the_ID() );
$form_action = add_query_arg( apply_filters( 'give_form_action_args', array( 'payment-mode' => $payment_mode, ) ),  give_get_current_page_url() );

$causes_options = get_post_meta( get_the_ID(), 'causes_options', true );
$case_form_title = isset( $causes_options['case_form_title']) ? $causes_options['case_form_title'] : '';

get_header();
?>
<div class="case-single-section wpo-case-details-wrap section-padding">
    <div class="donate-area-bottom">
        <div class="container">
            <div class="row">
                <div class="col col-lg-8">
                    <?php if ( isset( $image_url ) ): ?>
                        <div class="img-holder big-img">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                        </div>
                    <?php endif ?>
                    <?php if( $case_form_title ) { echo '<h3>'.esc_html( $case_form_title ).'</h3>'; }  ?>
                    <div class="donate-area-wrapper">
                    	<?php echo do_action( 'give_single_form_summary' ); ?>
                    </div> 
                </div>
                <div class="col col-lg-4 col-12">
                    <div class="case-single-sidebar blog-sidebar">
                       <?php
    					if ( is_active_sidebar( 'give-forms-sidebar' ) ) {
    						dynamic_sidebar( 'give-forms-sidebar' );
    					} ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div>
<?php
get_footer();