<?php
/*
 * All Metabox related options for Charitio theme.
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

function charitio_metabox_options( $options ) {

 $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
    $contact_forms = array();
    if ( $cf7 ) {
      foreach ( $cf7 as $cform ) {
        $contact_forms[ $cform->ID ] = $cform->post_title;
      }
    } else {
      $contact_forms[ esc_html__( 'No contact forms found', 'charitio' ) ] = 0;
    }
  $options      = array();

  // -----------------------------------------
  // Post Metabox Options                    -
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'post_type_metabox',
    'title'     => esc_html__('Post Options', 'charitio'),
    'post_type' => 'post',
    'context'   => 'normal',
    'priority'  => 'default',
    'sections'  => array(

      // All Post Formats
      array(
        'name'   => 'section_post_formats',
        'fields' => array(

          // Standard, Image
          array(
            'title' => 'Standard Image',
            'type'  => 'subheading',
            'content' => esc_html__('There is no Extra Option for this Post Format!', 'charitio'),
            'wrap_class' => 'charitio-minimal-heading hide-title',
          ),
          // Standard, Image

          // Gallery
          array(
            'type'    => 'notice',
            'title'   => 'Gallery Format',
            'wrap_class' => 'hide-title',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Gallery Format', 'charitio')
          ),
          array(
            'id'          => 'gallery_post_format',
            'type'        => 'gallery',
            'title'       => esc_html__('Add Gallery', 'charitio'),
            'add_title'   => esc_html__('Add Image(s)', 'charitio'),
            'edit_title'  => esc_html__('Edit Image(s)', 'charitio'),
            'clear_title' => esc_html__('Clear Image(s)', 'charitio'),
          ),
          array(
            'type'    => 'text',
            'title'   => esc_html__('Add Video URL', 'charitio' ),
            'id'   => 'video_post_format',
            'desc' => esc_html__('Add youtube or vimeo video link', 'charitio' ),
            'wrap_class' => 'video_post_format',
          ),
          array(
            'type'    => 'icon',
            'title'   => esc_html__('Add Quote Icon', 'charitio' ),
            'id'   => 'quote_post_format',
            'desc' => esc_html__('Add Quote Icon here', 'charitio' ),
            'wrap_class' => 'quote_post_format',
          ),
          // Gallery

        ),
      ),

    ),
  );

  // -----------------------------------------
  // Page Metabox Options                    -
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'page_type_metabox',
    'title'     => esc_html__('Page Custom Options', 'charitio'),
    'post_type' => array('post', 'page'),
    'context'   => 'normal',
    'priority'  => 'default',
    'sections'  => array(

      // Title Section
      array(
        'name'  => 'page_topbar_section',
        'title' => esc_html__('Top Bar', 'charitio'),
        'icon'  => 'fa fa-minus',

        // Fields Start
        'fields' => array(

          array(
            'id'           => 'topbar_options',
            'type'         => 'image_select',
            'title'        => esc_html__('Topbar', 'charitio'),
            'options'      => array(
              'default'     => CHARITIO_CS_IMAGES .'/topbar-default.png',
              'custom'      => CHARITIO_CS_IMAGES .'/topbar-custom.png',
              'hide_topbar' => CHARITIO_CS_IMAGES .'/topbar-hide.png',
            ),
            'attributes' => array(
              'data-depend-id' => 'hide_topbar_select',
            ),
            'radio'     => true,
            'default'   => 'default',
          ),
          array(
            'id'          => 'top_left',
            'type'        => 'textarea',
            'title'       => esc_html__('Top Left', 'charitio'),
            'dependency'  => array('hide_topbar_select', '==', 'custom'),
            'shortcode'       => true,
          ),
          array(
            'id'          => 'top_right',
            'type'        => 'textarea',
            'title'       => esc_html__('Top Right', 'charitio'),
            'dependency'  => array('hide_topbar_select', '==', 'custom'),
            'shortcode'       => true,
          ),
          array(
            'id'    => 'topbar_bg',
            'type'  => 'color_picker',
            'title' => esc_html__('Topbar Background Color', 'charitio'),
            'dependency'  => array('hide_topbar_select', '==', 'custom'),
          ),
          array(
            'id'    => 'topbar_border',
            'type'  => 'color_picker',
            'title' => esc_html__('Topbar Border Color', 'charitio'),
            'dependency'  => array('hide_topbar_select', '==', 'custom'),
          ),

        ), // End : Fields

      ), // Title Section

      // Header
      array(
        'name'  => 'header_section',
        'title' => esc_html__('Header', 'charitio'),
        'icon'  => 'fa fa-bars',
        'fields' => array(

          array(
            'id'           => 'select_header_design',
            'type'         => 'image_select',
            'title'        => esc_html__('Select Header Design', 'charitio'),
            'options'      => array(
              'default'     => CHARITIO_CS_IMAGES .'/hs-0.png',
              'style_one'   => CHARITIO_CS_IMAGES .'/hs-1.png',
              'style_two'   => CHARITIO_CS_IMAGES .'/hs-2.png',
              'style_three'   => CHARITIO_CS_IMAGES .'/hs-3.png',
            ),
            'attributes' => array(
              'data-depend-id' => 'header_design',
            ),
            'radio'     => true,
            'default'   => 'default',
            'info'      => esc_html__('Select your header design, following options will may differ based on your selection of header design.', 'charitio'),
          ),
          array(
            'id'    => 'transparency_header',
            'type'  => 'switcher',
            'title' => esc_html__('Transparent Header', 'charitio'),
            'info' => esc_html__('Use Transparent Method', 'charitio'),
          ),
          array(
            'id'    => 'transparent_menu_color',
            'type'  => 'color_picker',
            'title' => esc_html__('Menu Color', 'charitio'),
            'info' => esc_html__('Pick your menu color. This color will only apply for non-sticky header mode.', 'charitio'),
            'dependency'   => array('transparency_header', '==', 'true'),
          ),
          array(
            'id'    => 'transparent_menu_hover_color',
            'type'  => 'color_picker',
            'title' => esc_html__('Menu Hover Color', 'charitio'),
            'info' => esc_html__('Pick your menu hover color. This color will only apply for non-sticky header mode.', 'charitio'),
            'dependency'   => array('transparency_header', '==', 'true'),
          ),
          array(
            'id'             => 'choose_menu',
            'type'           => 'select',
            'title'          => esc_html__('Choose Menu', 'charitio'),
            'desc'          => esc_html__('Choose custom menus for this page.', 'charitio'),
            'options'        => 'menus',
            'default_option' => esc_html__('Select your menu', 'charitio'),
          ),

          // Enable & Disable
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Enable & Disable', 'charitio'),
            'dependency' => array('header_design', '!=', 'default'),
          ),
          array(
            'id'    => 'sticky_header',
            'type'  => 'switcher',
            'title' => esc_html__('Sticky Header', 'charitio'),
            'info' => esc_html__('Turn On if you want your naviagtion bar on sticky.', 'charitio'),
            'default' => true,
            'dependency' => array('header_design', '!=', 'default'),
          ),
        ),
      ),
      // Header

      // Banner & Title Area
      array(
        'name'  => 'banner_title_section',
        'title' => esc_html__('Banner & Title Area', 'charitio'),
        'icon'  => 'fa fa-bullhorn',
        'fields' => array(

          array(
            'id'        => 'banner_type',
            'type'      => 'select',
            'title'     => esc_html__('Choose Banner Type', 'charitio'),
            'options'   => array(
              'default-title'    => 'Default Title',
              'revolution-slider' => 'Shortcode [Rev Slider]',
              'hide-title-area'   => 'Hide Title/Banner Area',
            ),
          ),
          array(
            'id'    => 'page_revslider',
            'type'  => 'textarea',
            'title' => esc_html__('Revolution Slider or Any Shortcodes', 'charitio'),
            'desc' => __('Enter any shortcodes that you want to show in this page title area. <br />Eg : Revolution Slider shortcode.', 'charitio'),
            'attributes' => array(
              'placeholder' => esc_html__('Enter your shortcode...', 'charitio'),
            ),
            'dependency'   => array('banner_type', '==', 'revolution-slider'),
          ),
          array(
            'id'    => 'page_custom_title',
            'type'  => 'text',
            'title' => esc_html__('Custom Title', 'charitio'),
            'attributes' => array(
              'placeholder' => esc_html__('Enter your custom title...', 'charitio'),
            ),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),
          array(
            'id'        => 'title_area_spacings',
            'type'      => 'select',
            'title'     => esc_html__('Title Area Spacings', 'charitio'),
            'options'   => array(
              'padding-default' => esc_html__('Default Spacing', 'charitio'),
              'padding-custom' => esc_html__('Custom Padding', 'charitio'),
            ),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),
          array(
            'id'    => 'title_top_spacings',
            'type'  => 'text',
            'title' => esc_html__('Top Spacing', 'charitio'),
            'attributes'  => array( 'placeholder' => '100px' ),
            'dependency'  => array('banner_type|title_area_spacings', '==|==', 'default-title|padding-custom'),
          ),
          array(
            'id'    => 'title_bottom_spacings',
            'type'  => 'text',
            'title' => esc_html__('Bottom Spacing', 'charitio'),
            'attributes'  => array( 'placeholder' => '100px' ),
            'dependency'  => array('banner_type|title_area_spacings', '==|==', 'default-title|padding-custom'),
          ),
          array(
            'id'    => 'title_area_bg',
            'type'  => 'background',
            'title' => esc_html__('Background', 'charitio'),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),
          array(
            'id'    => 'titlebar_bg_overlay_color',
            'type'  => 'color_picker',
            'title' => esc_html__('Overlay Color', 'charitio'),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),
          array(
            'id'    => 'title_color',
            'type'  => 'color_picker',
            'title' => esc_html__('Title Color', 'charitio'),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),

        ),
      ),
      // Banner & Title Area

      // Content Section
      array(
        'name'  => 'page_content_options',
        'title' => esc_html__('Content Options', 'charitio'),
        'icon'  => 'fa fa-file',

        'fields' => array(

          array(
            'id'        => 'content_spacings',
            'type'      => 'select',
            'title'     => esc_html__('Content Spacings', 'charitio'),
            'options'   => array(
              'padding-default' => esc_html__('Default Spacing', 'charitio'),
              'padding-custom' => esc_html__('Custom Padding', 'charitio'),
            ),
            'desc' => esc_html__('Content area top and bottom spacings.', 'charitio'),
          ),
          array(
            'id'    => 'content_top_spacings',
            'type'  => 'text',
            'title' => esc_html__('Top Spacing', 'charitio'),
            'attributes'  => array( 'placeholder' => '100px' ),
            'dependency'  => array('content_spacings', '==', 'padding-custom'),
          ),
          array(
            'id'    => 'content_bottom_spacings',
            'type'  => 'text',
            'title' => esc_html__('Bottom Spacing', 'charitio'),
            'attributes'  => array( 'placeholder' => '100px' ),
            'dependency'  => array('content_spacings', '==', 'padding-custom'),
          ),
        ), // End Fields
      ), // Content Section

      // Enable & Disable
      array(
        'name'  => 'hide_show_section',
        'title' => esc_html__('Enable & Disable', 'charitio'),
        'icon'  => 'fa fa-toggle-on',
        'fields' => array(

          array(
            'id'    => 'hide_header',
            'type'  => 'switcher',
            'title' => esc_html__('Hide Header', 'charitio'),
            'label' => esc_html__('Yes, Please do it.', 'charitio'),
          ),
          array(
            'id'    => 'hide_breadcrumbs',
            'type'  => 'switcher',
            'title' => esc_html__('Hide Breadcrumbs', 'charitio'),
            'label' => esc_html__('Yes, Please do it.', 'charitio'),
          ),
          array(
            'id'    => 'hide_footer',
            'type'  => 'switcher',
            'title' => esc_html__('Hide Footer', 'charitio'),
            'label' => esc_html__('Yes, Please do it.', 'charitio'),
          ),
       
        ),
      ),
      // Enable & Disable

    ),
  );

  // -----------------------------------------
  // Page Layout
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'page_layout_options',
    'title'     => esc_html__('Page Layout', 'charitio'),
    'post_type' => 'page',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(

      array(
        'name'   => 'page_layout_section',
        'fields' => array(

          array(
            'id'        => 'page_layout',
            'type'      => 'image_select',
            'options'   => array(
              'full-width'    => CHARITIO_CS_IMAGES . '/page-1.png',
              'extra-width'   => CHARITIO_CS_IMAGES . '/page-2.png',
              'left-sidebar'  => CHARITIO_CS_IMAGES . '/page-3.png',
              'right-sidebar' => CHARITIO_CS_IMAGES . '/page-4.png',
            ),
            'attributes' => array(
              'data-depend-id' => 'page_layout',
            ),
            'default'    => 'full-width',
            'radio'      => true,
            'wrap_class' => 'text-center',
          ),
          array(
            'id'            => 'page_sidebar_widget',
            'type'           => 'select',
            'title'          => esc_html__('Sidebar Widget', 'charitio'),
            'options'        => charitio_registered_sidebars(),
            'default_option' => esc_html__('Select Widget', 'charitio'),
            'dependency'   => array('page_layout', 'any', 'left-sidebar,right-sidebar'),
          ),

        ),
      ),

    ),
  );


// -----------------------------------------
  // Project
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'project_options',
    'title'     => esc_html__('Project Extra Options', 'charitio'),
    'post_type' => 'project',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(

      array(
        'name'   => 'project_option_section',
        'fields' => array(
          array(
            'id'           => 'project_title',
            'type'         => 'text',
            'title'        => esc_html__('Project title', 'charitio'),
            'add_title' => esc_html__('Add Project title', 'charitio'),
            'attributes' => array(
              'placeholder' => esc_html__('Project Title', 'charitio'),
            ),
            'info'    => esc_html__('Write Project Title.', 'charitio'),
          ),  
          array(
            'id'           => 'project_grid',
            'type'         => 'image',
            'title'        => esc_html__('Project Grid', 'charitio'),
            'add_title' => esc_html__('Add Project Grid', 'charitio'),
          ),
           // Start fields
        ),
      ),

    ),
  );



 // -----------------------------------------
  // Service
  // -----------------------------------------

  $options[]    = array(
    'id'        => 'service_options',
    'title'     => esc_html__('Service Meta', 'charitio'),
    'post_type' => 'service',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(
      array(
        'name'   => 'service_infos',
        'fields' => array(
          array(
            'title'   => esc_html__('Service Title', 'charitio'),
            'id'      => 'service_title',
            'type'    => 'text',
            'attributes' => array(
              'placeholder' => esc_html__('Jhon Deno', 'charitio'),
            ),
            'info'    => esc_html__('Write Service Title.', 'charitio'),

          ),
          array(
            'title'   => esc_html__('Service Excerpt', 'charitio'),
            'id'      => 'service_excerpt',
            'type'    => 'textarea',
            'attributes' => array(
              'placeholder' => esc_html__('Excerpt Content', 'charitio'),
            ),
            'info'    => esc_html__('Write Service Short Content.', 'charitio'),

          ),
         array(
            'id'           => 'service_icon',
            'type'         => 'image',
            'title'        => esc_html__('Service Icon Image', 'charitio'),
            'add_title' => esc_html__('Service icon', 'charitio'),
            'info'    => esc_html__('Attached Service icon.', 'charitio'),
          ),
         array(
            'id'           => 'service_thumb',
            'type'         => 'image',
            'title'        => esc_html__('Service Image', 'charitio'),
            'add_title' => esc_html__('Service grid image', 'charitio'),
            'info'    => esc_html__('Attached Service Image.', 'charitio'),
          ),

        ),
      ),
    ),
  );


  // -----------------------------------------
  // Team
  // -----------------------------------------

  $options[]    = array(
    'id'        => 'team_options',
    'title'     => esc_html__('Team Meta', 'charitio'),
    'post_type' => 'team',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(
      array(
        'name'   => 'team_infos',
        'fields' => array(
          array(
            'title'   => esc_html__('Team Title', 'charitio'),
            'id'      => 'team_title',
            'type'    => 'text',
            'attributes' => array(
              'placeholder' => esc_html__('Jhon Deno', 'charitio'),
            ),
            'info'    => esc_html__('Write Team Title.', 'charitio'),

          ),
          array(
            'title'   => esc_html__('Team Sub Title', 'charitio'),
            'id'      => 'team_subtitle',
            'type'    => 'text',
             'attributes' => array(
              'placeholder' => esc_html__('Volunteer', 'charitio'),
            ),
            'info'    => esc_html__('Write Team Sub Title.', 'charitio'),
          ),
          // Start fields
          array(
            'id'                  => 'team_infos',
            'title'   => esc_html__('Team Info', 'charitio'),
            'type'                => 'group',
            'fields'              => array(
              array(
                'id'              => 'info_title',
                'type'            => 'text',
                'title'           => esc_html__('Info Title', 'charitio'),
              ),
              array(
                'id'              => 'info_desc',
                'type'            => 'text',
                'title'           => esc_html__('Info Description', 'charitio'),
              ),
            ),
            'button_title'        => esc_html__('Add Team info', 'charitio'),
            'accordion_title'     => esc_html__('team Info', 'charitio'),
          ),
         array(
            'id'           => 'team_image',
            'type'         => 'image',
            'title'        => esc_html__('Team Grid Image', 'charitio'),
            'add_title' => esc_html__('Team Image', 'charitio'),
            'info'    => esc_html__('Attached Team Grid Image.', 'charitio'),
          ),

        ),
      ),
    ),
  );


if (class_exists( 'WooCommerce' )){ 
   // -----------------------------------------
    // Product
    // -----------------------------------------
    $options[]    = array(
      'id'        => 'charitio_woocommerce_section',
      'title'     => esc_html__('Product Title', 'charitio'),
      'post_type' => 'product',
      'context'   => 'normal',
      'priority'  => 'high',
      'sections'  => array(

        // All Post Formats
        array(
          'name'   => 'charitio_single_title',
          'fields' => array(
            array(
              'id'          => 'charitio_product_title',
              'type'        => 'text',
              'title'       => esc_html__('Single Title', 'charitio'),
              'attributes' => array(
                'placeholder' => 'The Title Gose Here'
              ),
            ),

          ),
        ),

      ),
    );
}
// -----------------------------------------
  // Donation Forms
  // -----------------------------------------
  $options[]    = array(
    'id'        => '_donation_form_metabox',
    'title'     => esc_html__('Donation Deadline', 'charitio'),
    'post_type' => 'give_forms',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(

      // All Post Formats
      array(
        'name'   => 'section_deadline',
        'fields' => array(
          array(
            'id'          => 'donation_deadline',
            'type'        => 'text',
            'title'       => esc_html__('Deadline Date', 'charitio'),
            'attributes' => array(
              'placeholder' => 'DD/MM/YYYY'
            ),
          ),
          // Gallery

        ),
      ),

    ),
  );
  
  // -----------------------------------------
  // Causes
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'causes_options',
    'title'     => esc_html__('Causes Extra Options', 'charitio'),
    'post_type' => 'give_forms',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(

      array(
        'name'   => 'causes_option_section',
        'fields' => array(
         array(
            'id'           => 'causes_image',
            'type'         => 'image',
            'title'        => esc_html__('Causes Image', 'charitio'),
            'add_title' => esc_html__('Add Causes Image', 'charitio'),
          ),
         array(
            'id'           => 'case_form_title',
            'type'         => 'text',
            'default'    => 'Donate Now',
            'title'        => esc_html__('Form Title', 'charitio'),
            'add_title' => esc_html__('Add Form Title here', 'charitio'),
          ),
         array(
            'id'           => 'case_form_tag',
            'type'         => 'text',
            'default'    => 'Education',
            'title'        => esc_html__('Form Tag', 'charitio'),
            'add_title' => esc_html__('Add Form Tag here', 'charitio'),
          ),
        ),
      ),

    ),
  );

  

  // -----------------------------------------
  // post options
  // -----------------------------------------
  $options[]    = array(
    'id'        => 'post_options',
    'title'     => esc_html__('Grid Image', 'charitio'),
    'post_type' => 'post',
    'context'   => 'side',
    'priority'  => 'default',
    'sections'  => array(
      array(
        'name'   => 'post_option_section',
        'fields' => array(
          array(
            'id'           => 'widget_post_title',
            'type'         => 'text',
            'title'        => esc_html__('Widget Post Title', 'charitio'),
            'add_title' => esc_html__('Add Widget Post Title here', 'charitio'),
          ),
          array(
            'id'           => 'grid_image',
            'type'         => 'image',
            'title'        => esc_html__('Post Grid Image', 'charitio'),
            'add_title' => esc_html__('Add Post Grid Image', 'charitio'),
          ),
        ),
      ),

    ),
  );


  return $options;

}
add_filter( 'cs_metabox_options', 'charitio_metabox_options' );