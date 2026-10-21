<?php
/*
 * Causes Post Widget
 * Author & Copyright: designakb
 * URL: http://themeforest.net/user/designakb
 */
class charitio_causes_posts extends WP_Widget {

  /**
   * Specifies the widget name, description, class name and instatiates it
   */
  public function __construct() {
    parent::__construct(
      '-causes-blog',
      CHARITIO_THEME_NAME_PLUGIN . esc_html__( ': Causes Posts', 'charitio' ),
      array(
        'classname'   => 'recent-post-widget',
        'description' => CHARITIO_THEME_NAME_PLUGIN . esc_html__( ' widget that displays causes posts.', 'charitio' )
      )
    );
  }

  /**
   * Generates the back-end layout for the widget
   */
  public function form( $instance ) {
    // Default Values
    $instance   = wp_parse_args( $instance, array(
      'title'    => esc_html__( 'Causes Posts', 'charitio' ),
      'ptypes'   => 'post',
      'limit'    => '3',
      'date'     => true,
      'category' => '',
      'order' => '',
      'orderby' => '',
    ));

    // Title
    $title_value = esc_attr( $instance['title'] );
    $title_field = array(
      'id'    => $this->get_field_name('title'),
      'name'  => $this->get_field_name('title'),
      'type'  => 'text',
      'title' => esc_html__( 'Title :', 'charitio' ),
      'wrap_class' => 'cs-widget-fields',
    );
    echo cs_add_element( $title_field, $title_value );

    // Post Type
    $ptypes_value = esc_attr( $instance['ptypes'] );
    $ptypes_field = array(
      'id'    => $this->get_field_name('ptypes'),
      'name'  => $this->get_field_name('ptypes'),
      'type' => 'select',
      'options' => 'post_types',
      'default_option' => esc_html__( 'Select Post Type', 'charitio' ),
      'title' => esc_html__( 'Post Type :', 'charitio' ),
    );
    echo cs_add_element( $ptypes_field, $ptypes_value );

    // Limit
    $limit_value = esc_attr( $instance['limit'] );
    $limit_field = array(
      'id'    => $this->get_field_name('limit'),
      'name'  => $this->get_field_name('limit'),
      'type'  => 'text',
      'title' => esc_html__( 'Limit :', 'charitio' ),
      'help' => esc_html__( 'How many posts want to show?', 'charitio' ),
    );
    echo cs_add_element( $limit_field, $limit_value );

    // Date
    $date_value = esc_attr( $instance['date'] );
    $date_field = array(
      'id'    => $this->get_field_name('date'),
      'name'  => $this->get_field_name('date'),
      'type'  => 'switcher',
      'on_text'  => esc_html__( 'Yes', 'charitio' ),
      'off_text'  => esc_html__( 'No', 'charitio' ),
      'title' => esc_html__( 'Display Date :', 'charitio' ),
    );
    echo cs_add_element( $date_field, $date_value );

    // Category
    $category_value = esc_attr( $instance['category'] );
    $category_field = array(
      'id'    => $this->get_field_name('category'),
      'name'  => $this->get_field_name('category'),
      'type'  => 'text',
      'title' => esc_html__( 'Category :', 'charitio' ),
      'help' => esc_html__( 'Enter category slugs with comma(,) for multiple items', 'charitio' ),
    );
    echo cs_add_element( $category_field, $category_value );

    // Order
    $order_value = esc_attr( $instance['order'] );
    $order_field = array(
      'id'    => $this->get_field_name('order'),
      'name'  => $this->get_field_name('order'),
      'type' => 'select',
      'options'   => array(
        'ASC' => 'Ascending',
        'DESC' => 'Descending',
      ),
      'default_option' => esc_html__( 'Select Order', 'charitio' ),
      'title' => esc_html__( 'Order :', 'charitio' ),
    );
    echo cs_add_element( $order_field, $order_value );

    // Orderby
    $orderby_value = esc_attr( $instance['orderby'] );
    $orderby_field = array(
      'id'    => $this->get_field_name('orderby'),
      'name'  => $this->get_field_name('orderby'),
      'type' => 'select',
      'options'   => array(
        'none' => esc_html__('None', 'charitio'),
        'ID' => esc_html__('ID', 'charitio'),
        'author' => esc_html__('Author', 'charitio'),
        'title' => esc_html__('Title', 'charitio'),
        'name' => esc_html__('Name', 'charitio'),
        'type' => esc_html__('Type', 'charitio'),
        'date' => esc_html__('Date', 'charitio'),
        'modified' => esc_html__('Modified', 'charitio'),
        'rand' => esc_html__('Random', 'charitio'),
      ),
      'default_option' => esc_html__( 'Select OrderBy', 'charitio' ),
      'title' => esc_html__( 'OrderBy :', 'charitio' ),
    );
    echo cs_add_element( $orderby_field, $orderby_value );

  }

  /**
   * Processes the widget's values
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;

    // Update values
    $instance['title']        = strip_tags( stripslashes( $new_instance['title'] ) );
    $instance['ptypes']       = strip_tags( stripslashes( $new_instance['ptypes'] ) );
    $instance['limit']        = strip_tags( stripslashes( $new_instance['limit'] ) );
    $instance['date']         = strip_tags( stripslashes( $new_instance['date'] ) );
    $instance['category']     = strip_tags( stripslashes( $new_instance['category'] ) );
    $instance['order']        = strip_tags( stripslashes( $new_instance['order'] ) );
    $instance['orderby']      = strip_tags( stripslashes( $new_instance['orderby'] ) );

    return $instance;
  }

  /**
   * Output the contents of the widget
   */
  public function widget( $args, $instance ) {
    // Extract the arguments
    extract( $args );

    $title          = apply_filters( 'widget_title', $instance['title'] );
    $ptypes         = $instance['ptypes'];
    $limit          = $instance['limit'];
    $display_date   = $instance['date'];
    $category       = $instance['category'];
    $order          = $instance['order'];
    $orderby        = $instance['orderby'];

    $args = array(
      // other query params here,
      'post_type' => esc_attr($ptypes),
      'posts_per_page' => (int)$limit,
      'orderby' => esc_attr($orderby),
      'order' => esc_attr($order),
      'category_name' => esc_attr($category),
      'ignore_sticky_posts' => 1,
     );

     $charitio_rpw = new WP_Query( $args );
     global $post;

    // Display the markup before the widget
    echo $before_widget;

    if ( $title ) {
      echo $before_title . $title . $after_title;
    }
    echo '<div class="posts">';
    if ($charitio_rpw->have_posts()) : while ($charitio_rpw->have_posts()) : $charitio_rpw->the_post();
      $case_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), '', false, '' );
      $case_image = $case_image ? $case_image[0] : '';
      $post_options = get_post_meta( get_the_ID(), 'post_options', true );
      $grid_image = isset( $post_options['grid_image'] ) ? $post_options['grid_image'] : '';
      $image_url = wp_get_attachment_url( $grid_image );
      $image_alt = get_post_meta( $grid_image , '_wp_attachment_image_alt', true);

      $causes_options = get_post_meta( get_the_ID(), 'causes_options', true );
      $causes_image = isset( $causes_options['causes_image']) ? $causes_options['causes_image'] : '';
      global $post;
      $case_image_url = wp_get_attachment_url( $causes_image );
      $case_image_alt = get_post_meta( $causes_image , '_wp_attachment_image_alt', true);
      if ( ! class_exists( 'Give_Donate_Form' ) || ! function_exists( 'give_is_setting_enabled' ) ) {
        return false;
      }

      $form        = new \Give_Donate_Form( get_the_ID() );
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

      // echo var_dump( $case_image );

      if(class_exists('Aq_Resize')) {
        $post_img = aq_resize( $case_image_url, '70', '70', true );
      } else {
         $post_img = $image_url;
      }
      if (!empty( $post_img )) {
        $post_img = $post_img;
      } else {
        $post_img = CHARITIO_PLUGIN_IMGS.'/70X80.jpg';
      } ?>
    <div class="post">
        <div class="img-holder">
            <img src="<?php echo esc_url( $post_img ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
        </div>
        <div class="details">
            <h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
            <span class="give_goal_raised"><span class="goal"> Goal: </span><?php echo apply_filters( 'give_goal_amount_raised_output', give_currency_filter( $income ) ); ?><span class="raised"> Raised:</span> <?php echo apply_filters( 'give_goal_amount_target_output', give_currency_filter( $goal ) ); ?></span>
            <?php if ($display_date === '1') { ?>
            <p class="date"><i class="fa fa-calendar-o"></i>&nbsp; <?php  echo get_the_date(); ?></p>
            <?php } ?>
        </div>
    </div>

  <?php
    endwhile; endif;
    echo '</div>';
    wp_reset_postdata();
    // Display the markup after the widget
    echo $after_widget;
  }
}

// Register the widget using an annonymous function
add_action( 'widgets_init', function() { register_widget( "charitio_causes_posts" ); } );