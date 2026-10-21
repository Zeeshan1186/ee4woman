<?php
/*
 * All Theme Options for Charitio theme.
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

function charitio_settings( $settings ) {

  $settings           = array(
    'menu_title'      => CHARITIO_NAME . esc_html__(' Options', 'charitio'),
    'menu_slug'       => sanitize_title(CHARITIO_NAME) . '_options',
    'menu_type'       => 'theme',
    'menu_icon'       => 'dashicons-awards',
    'menu_position'   => '4',
    'ajax_save'       => false,
    'show_reset_all'  => true,
    'framework_title' => CHARITIO_NAME .' <small>V-'. CHARITIO_VERSION .' by <a href="'. CHARITIO_BRAND_URL .'" target="_blank">'. CHARITIO_BRAND_NAME .'</a></small>',
  );

  return $settings;

}
add_filter( 'cs_framework_settings', 'charitio_settings' );

// Theme Framework Options
function charitio_options( $options ) {

  $options      = array(); // remove old options

  // ------------------------------
  // Branding
  // ------------------------------
  $options[]   = array(
    'name'     => 'charitio_theme_branding',
    'title'    => esc_html__('Brand', 'charitio'),
    'icon'     => 'fa fa-trophy',
    'sections' => array(

      // brand logo tab
      array(
        'name'     => 'brand_logo',
        'title'    => esc_html__('Logo', 'charitio'),
        'icon'     => 'fa fa-star',
        'fields'   => array(

          // Site Logo
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Site Logo', 'charitio')
          ),
          array(
            'id'    => 'charitio_logo',
            'type'  => 'image',
            'title' => esc_html__('Default Logo', 'charitio'),
            'info'  => esc_html__('Upload your default logo here. If you not upload, then site title will load in this logo location.', 'charitio'),
            'add_title' => esc_html__('Add Logo', 'charitio'),
          ),
          array(
            'id'    => 'charitio_trlogo',
            'type'  => 'image',
            'title' => esc_html__('Transparent Logo', 'charitio'),
            'info'  => esc_html__('Upload your Transparent logo here. If you not upload, then site title will load in this logo location.', 'charitio'),
            'add_title' => esc_html__('Add Logo', 'charitio'),
          ),
          array(
            'id'          => 'charitio_logo_top',
            'type'        => 'number',
            'title'       => esc_html__('Logo Top Space', 'charitio'),
            'attributes'  => array( 'placeholder' => 5 ),
            'unit'        => 'px',
          ),
          array(
            'id'          => 'charitio_logo_bottom',
            'type'        => 'number',
            'title'       => esc_html__('Logo Bottom Space', 'charitio'),
            'attributes'  => array( 'placeholder' => 5 ),
            'unit'        => 'px',
          ),
          // WordPress Admin Logo
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('WordPress Admin Logo', 'charitio')
          ),
          array(
            'id'    => 'brand_logo_wp',
            'type'  => 'image',
            'title' => esc_html__('Login logo', 'charitio'),
            'info'  => esc_html__('Upload your WordPress login page logo here.', 'charitio'),
            'add_title' => esc_html__('Add Login Logo', 'charitio'),
          ),
        ) // end: fields
      ), // end: section
    ),
  );

  // ------------------------------
  // Layout
  // ------------------------------
  $options[] = array(
    'name'   => 'theme_layout',
    'title'  => esc_html__('Layout', 'charitio'),
    'icon'   => 'fa fa-file-text'
  );

  $options[]      = array(
    'name'        => 'theme_general',
    'title'       => esc_html__('General', 'charitio'),
    'icon'        => 'fa fa-wrench',

    // begin: fields
    'fields'      => array(

      // -----------------------------
      // Begin: Responsive
      // -----------------------------
       array(
        'id'    => 'theme_responsive',
        'off_text'  => 'No',
        'on_text'  => 'Yes',
        'type'  => 'switcher',
        'title' => esc_html__('Responsive', 'charitio'),
        'info' => esc_html__('Turn on if you don\'t want your site to be responsive.', 'charitio'),
        'default' => false,
      ),
      array(
        'id'    => 'theme_preloder',
        'off_text'  => 'No',
        'on_text'  => 'Yes',
        'type'  => 'switcher',
        'title' => esc_html__('Preloder', 'charitio'),
        'info' => esc_html__('Turn off if you don\'t want your site to be Preloder.', 'charitio'),
        'default' => true,
      ),
      array(
        'id'    => 'preloader_image',
        'type'  => 'image',
        'title' => esc_html__('Preloader Logo', 'charitio'),
        'info'  => esc_html__('Upload your preoader logo here. If you not upload, then site preoader will load in this preloader location.', 'charitio'),
        'add_title' => esc_html__('Add Logo', 'charitio'),
        'dependency' => array( 'theme_preloder', '==', 'true' ),
      ),
      array(
        'id'    => 'theme_layout_width',
        'type'  => 'image_select',
        'title' => esc_html__('Full Width & Extra Width', 'charitio'),
        'info' => esc_html__('Boxed or Fullwidth? Choose your site layout width. Default : Full Width', 'charitio'),
        'options'      => array(
          'container'    => CHARITIO_CS_IMAGES .'/boxed-width.jpg',
          'container-fluid'    => CHARITIO_CS_IMAGES .'/full-width.jpg',
        ),
        'default'      => 'container-fluid',
        'radio'      => true,
      ),
       array(
        'id'    => 'theme_page_comments',
        'type'  => 'switcher',
        'title' => esc_html__('Hide Page Comments?', 'charitio'),
        'label' => esc_html__('Yes! Hide Page Comments.', 'charitio'),
        'on_text' => esc_html__('Yes', 'charitio'),
        'off_text' => esc_html__('No', 'charitio'),
        'default' => false,
      ),
      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Background Options', 'charitio'),
        'dependency' => array( 'theme_layout_width_container', '==', 'true' ),
      ),
      array(
        'id'             => 'theme_layout_bg_type',
        'type'           => 'select',
        'title'          => esc_html__('Background Type', 'charitio'),
        'options'        => array(
          'bg-image' => esc_html__('Image', 'charitio'),
          'bg-pattern' => esc_html__('Pattern', 'charitio'),
        ),
        'dependency' => array( 'theme_layout_width_container', '==', 'true' ),
      ),
      array(
        'id'    => 'theme_layout_bg_pattern',
        'type'  => 'image_select',
        'title' => esc_html__('Background Pattern', 'charitio'),
        'info' => esc_html__('Select background pattern', 'charitio'),
        'options'      => array(
          'pattern-1'    => CHARITIO_CS_IMAGES . '/pattern-1.png',
          'pattern-2'    => CHARITIO_CS_IMAGES . '/pattern-2.png',
          'pattern-3'    => CHARITIO_CS_IMAGES . '/pattern-3.png',
          'pattern-4'    => CHARITIO_CS_IMAGES . '/pattern-4.png',
          'custom-pattern'  => CHARITIO_CS_IMAGES . '/pattern-5.png',
        ),
        'default'      => 'pattern-1',
        'radio'      => true,
        'dependency' => array( 'theme_layout_width_container|theme_layout_bg_type', '==|==', 'true|bg-pattern' ),
      ),
      array(
        'id'      => 'custom_bg_pattern',
        'type'    => 'upload',
        'title'   => esc_html__('Custom Pattern', 'charitio'),
        'dependency' => array( 'theme_layout_width_container|theme_layout_bg_type|theme_layout_bg_pattern_custom-pattern', '==|==|==', 'true|bg-pattern|true' ),
        'info' => __('Select your custom background pattern. <br />Note, background pattern image will be repeat in all x and y axis. So, please consider all repeatable area will perfectly fit your custom patterns.', 'charitio'),
      ),
      array(
        'id'      => 'theme_layout_bg',
        'type'    => 'background',
        'title'   => esc_html__('Background', 'charitio'),
        'dependency' => array( 'theme_layout_width_container|theme_layout_bg_type', '==|==', 'true|bg-image' ),
      ),

    ), // end: fields

  );

  // ------------------------------
  // Header Sections
  // ------------------------------
  $options[]   = array(
    'name'     => 'theme_header_tab',
    'title'    => esc_html__('Header', 'charitio'),
    'icon'     => 'fa fa-bars',
    'sections' => array(

      // header design tab
      array(
        'name'     => 'header_design_tab',
        'title'    => esc_html__('Design', 'charitio'),
        'icon'     => 'fa fa-magic',
        'fields'   => array(

          // Header Select
          array(
            'id'           => 'select_header_design',
            'type'         => 'image_select',
            'title'        => esc_html__('Select Header Design', 'charitio'),
            'options'      => array(
              'style_one'    => CHARITIO_CS_IMAGES .'/hs-1.png',
              'style_two'    => CHARITIO_CS_IMAGES .'/hs-2.png',
              'style_three'    => CHARITIO_CS_IMAGES .'/hs-3.png',
            ),
            'attributes' => array(
              'data-depend-id' => 'header_design',
            ),
            'radio'        => true,
            'default'   => 'style_one',
            'info' => esc_html__('Select your header design, following options will may differ based on your selection of header design.', 'charitio'),
          ),
          // Header Select

          // Extra's
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Extra\'s', 'charitio'),
          ),
          array(
            'id'    => 'sticky_header',
            'type'  => 'switcher',
            'title' => esc_html__('Sticky Header', 'charitio'),
            'info' => esc_html__('Turn On if you want your naviagtion bar on sticky.', 'charitio'),
            'default' => true,
          ),
          array(
            'id'    => 'charitio_header_search',
            'type'  => 'switcher',
            'title' => esc_html__('Header Search', 'charitio'),
            'info' => esc_html__('Turn On if you want to Hide Header Search .', 'charitio'),
            'default' => false,
          ),
          array(
            'id'    => 'charitio_menu_cta',
            'type'  => 'switcher',
            'title' => esc_html__('Header CTA', 'charitio'),
            'info' => esc_html__('Turn On if you want to Show Header CTA .', 'charitio'),
            'default' => false,
          ),
          array(
            'id'    => 'header_cta_text',
            'type'  => 'text',
            'title' => esc_html__('Header CTA Text', 'charitio'),
            'info' => esc_html__('Write Header CTA Text here.', 'charitio'),
            'type'        => 'text',
            'default' => 'Donate Now',
            'dependency'  => array('charitio_menu_cta', '==', true),
          ),
          array(
            'id'    => 'header_cta_link',
            'type'  => 'text',
            'title' => esc_html__('Header CTA Link', 'charitio'),
            'info' => esc_html__('Write Header CTA Link here.', 'charitio'),
            'type'        => 'text',
            'default' => '#',
            'dependency'  => array('charitio_menu_cta', '==', true),
          ),
        )
      ),

      // header top bar
      array(
        'name'     => 'header_top_bar_tab',
        'title'    => esc_html__('Top Bar', 'charitio'),
        'icon'     => 'fa fa-minus',
        'fields'   => array(

          array(
            'id'          => 'top_bar',
            'type'        => 'switcher',
            'title'       => esc_html__('Hide Top Bar', 'charitio'),
            'on_text'     => esc_html__('Yes', 'charitio'),
            'off_text'    => esc_html__('No', 'charitio'),
            'default'     => true,
          ),
          array(
            'id'          => 'top_left',
            'title'       => esc_html__('Top left Block', 'charitio'),
            'desc'        => esc_html__('Top bar left block.', 'charitio'),
            'type'        => 'textarea',
            'shortcode'   => true,
            'dependency'  => array('top_bar', '==', false),
          ),
          array(
            'id'          => 'top_right',
            'title'       => esc_html__('Top Right Block', 'charitio'),
            'desc'        => esc_html__('Top bar right block.', 'charitio'),
            'type'        => 'textarea',
            'shortcode'   => true,
            'dependency'  => array('top_bar', '==', false),
          ),
        )
      ),

      // header banner
      array(
        'name'     => 'header_banner_tab',
        'title'    => esc_html__('Title Bar (or) Banner', 'charitio'),
        'icon'     => 'fa fa-bullhorn',
        'fields'   => array(

          // Title Area
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Title Area', 'charitio')
          ),
          array(
            'id'      => 'need_title_bar',
            'type'    => 'switcher',
            'title'   => esc_html__('Title Bar ?', 'charitio'),
            'label'   => esc_html__('If you want to Hide title bar in your sub-pages, please turn this ON.', 'charitio'),
            'default'    => false,
          ),
          array(
            'id'             => 'title_bar_padding',
            'type'           => 'select',
            'title'          => esc_html__('Padding Spaces Top & Bottom', 'charitio'),
            'options'        => array(
              'padding-default' => esc_html__('Default Spacing', 'charitio'),
              'padding-custom' => esc_html__('Custom Padding', 'charitio'),
            ),
            'dependency'   => array( 'need_title_bar', '==', 'false' ),
          ),
          array(
            'id'             => 'titlebar_top_padding',
            'type'           => 'text',
            'title'          => esc_html__('Padding Top', 'charitio'),
            'attributes' => array(
              'placeholder'     => '100px',
            ),
            'dependency'   => array( 'title_bar_padding', '==', 'padding-custom' ),
          ),
          array(
            'id'             => 'titlebar_bottom_padding',
            'type'           => 'text',
            'title'          => esc_html__('Padding Bottom', 'charitio'),
            'attributes' => array(
              'placeholder'     => '100px',
            ),
            'dependency'   => array( 'title_bar_padding', '==', 'padding-custom' ),
          ),

          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Background Options', 'charitio'),
            'dependency' => array( 'need_title_bar', '==', 'false' ),
          ),
          array(
            'id'      => 'titlebar_bg_overlay_color',
            'type'    => 'color_picker',
            'title'   => esc_html__('Overlay Color', 'charitio'),
            'dependency' => array( 'need_title_bar', '==', 'false' ),
          ),
          array(
            'id'    => 'title_color',
            'type'  => 'color_picker',
            'title' => esc_html__('Title Color', 'charitio'),
            'dependency'   => array('banner_type', '==', 'default-title'),
          ),

          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Breadcrumbs', 'charitio'),
          ),
         array(
            'id'      => 'need_breadcrumbs',
            'type'    => 'switcher',
            'title'   => esc_html__('Hide Breadcrumbs', 'charitio'),
            'label'   => esc_html__('If you want to hide breadcrumbs in your banner, please turn this ON.', 'charitio'),
            'default'    => false,
          ),
        )
      ),

    ),
  );

  // ------------------------------
  // Footer Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'footer_section',
    'title'    => esc_html__('Footer', 'charitio'),
    'icon'     => 'fa fa-ellipsis-h',
    'sections' => array(

      // footer widgets
      array(
        'name'     => 'footer_widgets_tab',
        'title'    => esc_html__('Widget Area', 'charitio'),
        'icon'     => 'fa fa-th',
        'fields'   => array(

          // Footer Widget Block
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Footer Widget Block', 'charitio')
          ),
          array(
            'id'    => 'footer_widget_block',
            'type'  => 'switcher',
            'title' => esc_html__('Enable Widget Block', 'charitio'),
            'info' => __('If you turn this ON, then Goto : Appearance > Widgets. There you can see <strong>Footer Widget 1,2,3 or 4</strong> Widget Area, add your widgets there.', 'charitio'),
            'default' => true,
          ),
          array(
            'id'    => 'footer_widget_layout',
            'type'  => 'image_select',
            'title' => esc_html__('Widget Layouts', 'charitio'),
            'info' => esc_html__('Choose your footer widget theme-layouts.', 'charitio'),
            'default' => 4,
            'options' => array(
              1   => CHARITIO_CS_IMAGES . '/footer/footer-1.png',
              2   => CHARITIO_CS_IMAGES . '/footer/footer-2.png',
              3   => CHARITIO_CS_IMAGES . '/footer/footer-3.png',
              4   => CHARITIO_CS_IMAGES . '/footer/footer-4.png',
              5   => CHARITIO_CS_IMAGES . '/footer/footer-5.png',
              6   => CHARITIO_CS_IMAGES . '/footer/footer-6.png',
              7   => CHARITIO_CS_IMAGES . '/footer/footer-7.png',
              8   => CHARITIO_CS_IMAGES . '/footer/footer-8.png',
              9   => CHARITIO_CS_IMAGES . '/footer/footer-9.png',
            ),
            'radio'       => true,
            'dependency'  => array('footer_widget_block', '==', true),
          ),
           array(
            'id'    => 'charitio_ft_bg',
            'type'  => 'image',
            'title' => esc_html__('Footer Background', 'charitio'),
            'info'  => esc_html__('Upload your footer background.', 'charitio'),
            'add_title' => esc_html__('footer background', 'charitio'),
            'dependency'  => array('footer_widget_block', '==', true),
          ),

        )
      ),

      // footer copyright
      array(
        'name'     => 'footer_copyright_tab',
        'title'    => esc_html__('Copyright Bar', 'charitio'),
        'icon'     => 'fa fa-copyright',
        'fields'   => array(

          // Copyright
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Copyright Layout', 'charitio'),
          ),
         array(
            'id'    => 'hide_copyright',
            'type'  => 'switcher',
            'title' => esc_html__('Hide Copyright?', 'charitio'),
            'default' => false,
            'on_text' => esc_html__('Yes', 'charitio'),
            'off_text' => esc_html__('No', 'charitio'),
            'label' => esc_html__('Yes, do it!', 'charitio'),
          ),
          array(
            'id'    => 'footer_copyright_layout',
            'type'  => 'image_select',
            'title' => esc_html__('Select Copyright Layout', 'charitio'),
            'info' => esc_html__('In above image, blue box is copyright text and yellow box is secondary text.', 'charitio'),
            'default'      => 'copyright-3',
            'options'      => array(
              'copyright-1'    => CHARITIO_CS_IMAGES .'/footer/copyright-1.png',
              ),
            'radio'        => true,
            'dependency'     => array('hide_copyright', '!=', true),
          ),
          array(
            'id'    => 'copyright_text',
            'type'  => 'textarea',
            'title' => esc_html__('Copyright Text', 'charitio'),
            'shortcode' => true,
            'dependency' => array('hide_copyright', '!=', true),
            'after'       => 'Helpful shortcodes: [current_year] [home_url] or any shortcode.',
          ),

          // Copyright Another Text
          array(
            'type'    => 'notice',
            'class'   => 'warning cs-charitio-heading',
            'content' => esc_html__('Copyright Secondary Text', 'charitio'),
             'dependency'     => array('hide_copyright', '!=', true),
          ),
          array(
            'id'    => 'secondary_text',
            'type'  => 'textarea',
            'title' => esc_html__('Secondary Text', 'charitio'),
            'shortcode' => true,
            'dependency'     => array('hide_copyright', '!=', true),
          ),

        )
      ),

    ),
  );

  // ------------------------------
  // Design
  // ------------------------------
  $options[] = array(
    'name'   => 'theme_design',
    'title'  => esc_html__('Design', 'charitio'),
    'icon'   => 'fa fa-magic'
  );

  // ------------------------------
  // color section
  // ------------------------------
  $options[]   = array(
    'name'     => 'theme_color_section',
    'title'    => esc_html__('Colors', 'charitio'),
    'icon'     => 'fa fa-eyedropper',
    'fields' => array(

      array(
        'type'    => 'heading',
        'content' => esc_html__('Color Options', 'charitio'),
      ),
      array(
        'type'    => 'subheading',
        'wrap_class' => 'color-tab-content',
        'content' => esc_html__('All color options are available in our theme customizer. The reason of we used customizer options for color section is because, you can choose each part of color from there and see the changes instantly using customizer. Highly customizable colors are in Appearance > Customize', 'charitio'),
      ),

    ),
  );

  // ------------------------------
  // Typography section
  // ------------------------------
  $options[]   = array(
    'name'     => 'theme_typo_section',
    'title'    => esc_html__('Typography', 'charitio'),
    'icon'     => 'fa fa-header',
    'fields' => array(

      // Start fields
      array(
        'id'                  => 'typography',
        'type'                => 'group',
        'fields'              => array(
          array(
            'id'              => 'title',
            'type'            => 'text',
            'title'           => esc_html__('Title', 'charitio'),
          ),
          array(
            'id'              => 'selector',
            'type'            => 'textarea',
            'title'           => esc_html__('Selector', 'charitio'),
            'info'           => wp_kses( __('Enter css selectors like : <strong>body, .custom-class</strong>', 'charitio'), array( 'strong' => array() ) ),
          ),
          array(
            'id'              => 'font',
            'type'            => 'typography',
            'title'           => esc_html__('Font Family', 'charitio'),
          ),
          array(
            'id'              => 'size',
            'type'            => 'text',
            'title'           => esc_html__('Font Size', 'charitio'),
          ),
          array(
            'id'              => 'line_height',
            'type'            => 'text',
            'title'           => esc_html__('Line-Height', 'charitio'),
          ),
          array(
            'id'              => 'css',
            'type'            => 'textarea',
            'title'           => esc_html__('Custom CSS', 'charitio'),
          ),
        ),
        'button_title'        => esc_html__('Add New Typography', 'charitio'),
        'accordion_title'     => esc_html__('New Typography', 'charitio'),
      ),

      // Subset
      array(
        'id'                  => 'subsets',
        'type'                => 'select',
        'title'               => esc_html__('Subsets', 'charitio'),
        'class'               => 'chosen',
        'options'             => array(
          'latin'             => 'latin',
          'latin-ext'         => 'latin-ext',
          'cyrillic'          => 'cyrillic',
          'cyrillic-ext'      => 'cyrillic-ext',
          'greek'             => 'greek',
          'greek-ext'         => 'greek-ext',
          'vietnamese'        => 'vietnamese',
          'devanagari'        => 'devanagari',
          'khmer'             => 'khmer',
        ),
        'attributes'         => array(
          'data-placeholder' => 'Subsets',
          'multiple'         => 'multiple',
          'style'            => 'width: 200px;'
        ),
        'default'             => array( 'latin' ),
      ),

      array(
        'id'                  => 'font_weight',
        'type'                => 'select',
        'title'               => esc_html__('Font Weights', 'charitio'),
        'class'               => 'chosen',
        'options'             => array(
          '100'   => esc_html__('Thin 100', 'charitio'),
          '100i'  => esc_html__('Thin 100 Italic', 'charitio'),
          '200'   => esc_html__('Extra Light 200', 'charitio'),
          '200i'  => esc_html__('Extra Light 200 Italic', 'charitio'),
          '300'   => esc_html__('Light 300', 'charitio'),
          '300i'  => esc_html__('Light 300 Italic', 'charitio'),
          '400'   => esc_html__('Regular 400', 'charitio'),
          '400i'  => esc_html__('Regular 400 Italic', 'charitio'),
          '500'   => esc_html__('Medium 500', 'charitio'),
          '500i'  => esc_html__('Medium 500 Italic', 'charitio'),
          '600'   => esc_html__('Semi Bold 600', 'charitio'),
          '600i'  => esc_html__('Semi Bold 600 Italic', 'charitio'),
          '700'   => esc_html__('Bold 700', 'charitio'),
          '700i'  => esc_html__('Bold 700 Italic', 'charitio'),
          '800'   => esc_html__('Extra Bold 800', 'charitio'),
          '800i'  => esc_html__('Extra Bold 800 Italic', 'charitio'),
          '900'   => esc_html__('Black 900', 'charitio'),
          '900i'  => esc_html__('Black 900 Italic', 'charitio'),
        ),
        'attributes'         => array(
          'data-placeholder' => esc_html__('Font Weight', 'charitio'),
          'multiple'         => 'multiple',
          'style'            => 'width: 200px;'
        ),
        'default'             => array( '400' ),
      ),

      // Custom Fonts Upload
      array(
        'id'                 => 'font_family',
        'type'               => 'group',
        'title'              => esc_html__('Upload Custom Fonts', 'charitio'),
        'button_title'       => esc_html__('Add New Custom Font', 'charitio'),
        'accordion_title'    => esc_html__('Adding New Font', 'charitio'),
        'accordion'          => true,
        'desc'               => esc_html__('It is simple. Only add your custom fonts and click to save. After you can check "Font Family" selector. Do not forget to Save!', 'charitio'),
        'fields'             => array(

          array(
            'id'             => 'name',
            'type'           => 'text',
            'title'          => esc_html__('Font-Family Name', 'charitio'),
            'attributes'     => array(
              'placeholder'  => esc_html__('for eg. Arial', 'charitio')
            ),
          ),

          array(
            'id'             => 'ttf',
            'type'           => 'upload',
            'title'          => wp_kses(__('Upload .ttf <small><i>(optional)</i></small>', 'charitio'), array( 'small' => array(), 'i' => array() )),
            'settings'       => array(
              'upload_type'  => 'font',
              'insert_title' => esc_html__('Use this Font-Format', 'charitio'),
              'button_title' => wp_kses(__('Upload <i>.ttf</i>', 'charitio'), array( 'i' => array() )),
            ),
          ),

          array(
            'id'             => 'eot',
            'type'           => 'upload',
            'title'          => wp_kses(__('Upload .eot <small><i>(optional)</i></small>', 'charitio'), array( 'small' => array(), 'i' => array() )),
            'settings'       => array(
              'upload_type'  => 'font',
              'insert_title' => esc_html__('Use this Font-Format', 'charitio'),
              'button_title' => wp_kses(__('Upload <i>.eot</i>', 'charitio'), array( 'i' => array() )),
            ),
          ),

          array(
            'id'             => 'otf',
            'type'           => 'upload',
            'title'          => wp_kses(__('Upload .otf <small><i>(optional)</i></small>', 'charitio'), array( 'small' => array(), 'i' => array() )),
            'settings'       => array(
              'upload_type'  => 'font',
              'insert_title' => esc_html__('Use this Font-Format', 'charitio'),
              'button_title' => wp_kses(__('Upload <i>.otf</i>', 'charitio'), array( 'i' => array() )),
            ),
          ),

          array(
            'id'             => 'woff',
            'type'           => 'upload',
            'title'          => wp_kses(__('Upload .woff <small><i>(optional)</i></small>', 'charitio'), array( 'small' => array(), 'i' => array() )),
            'settings'       => array(
              'upload_type'  => 'font',
              'insert_title' => esc_html__('Use this Font-Format', 'charitio'),
              'button_title' =>wp_kses(__('Upload <i>.woff</i>', 'charitio'), array( 'i' => array() )),
            ),
          ),

          array(
            'id'             => 'css',
            'type'           => 'textarea',
            'title'          => wp_kses(__('Extra CSS Style <small><i>(optional)</i></small>', 'charitio'), array( 'small' => array(), 'i' => array() )),
            'attributes'     => array(
              'placeholder'  => esc_html__('for eg. font-weight: normal;', 'charitio'),
            ),
          ),

        ),
      ),
      // End All field

    ),
  );

  // ------------------------------
  // Pages
  // ------------------------------
  $options[] = array(
    'name'   => 'theme_pages',
    'title'  => esc_html__('Pages', 'charitio'),
    'icon'   => 'fa fa-files-o'
  );


  
  // ------------------------------
  // Event Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'event_section',
    'title'    => esc_html__('Service', 'charitio'),
    'icon'     => 'fa fa-address-book-o',
    'fields' => array(

      // event name change
      array(
        'type'    => 'notice',
        'class'   => 'info cs-tmx-heading',
        'content' => esc_html__('Name Change', 'charitio')
      ),
      array(
        'id'      => 'theme_event_name',
        'type'    => 'text',
        'title'   => esc_html__('Service Name', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'Service'
        ),
      ),
      array(
        'id'      => 'theme_event_slug',
        'type'    => 'text',
        'title'   => esc_html__('Service Slug', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'event-item'
        ),
      ),
      array(
        'id'      => 'theme_event_cat_slug',
        'type'    => 'text',
        'title'   => esc_html__('Service Category Slug', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'event-category'
        ),
      ),
      array(
        'type'    => 'notice',
        'class'   => 'danger',
        'content' => __('<strong>Important</strong>: Please do not set event slug and page slug as same. It\'ll not work.', 'charitio')
      ),
      // Service Start
      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Service Single', 'charitio')
      ),
      array(
          'id'             => 'event_sidebar_position',
          'type'           => 'select',
          'title'          => esc_html__('Sidebar Position', 'charitio'),
          'options'        => array(
            'sidebar-right' => esc_html__('Right', 'charitio'),
            'sidebar-left' => esc_html__('Left', 'charitio'),
            'sidebar-hide' => esc_html__('Hide', 'charitio'),
          ),
          'default_option' => 'Select sidebar position',
          'info'          => esc_html__('Default option : Right', 'charitio'),
        ),
        array(
          'id'             => 'single_event_widget',
          'type'           => 'select',
          'title'          => esc_html__('Sidebar Widget', 'charitio'),
          'options'        => charitio_registered_sidebars(),
          'default_option' => esc_html__('Select Widget', 'charitio'),
          'dependency'     => array('event_sidebar_position', '!=', 'sidebar-hide'),
          'info'          => esc_html__('Default option : Main Widget Area', 'charitio'),
        ),
        array(
          'id'    => 'event_comment_form',
          'type'  => 'switcher',
          'title' => esc_html__('Comment Area/Form', 'charitio'),
          'info' => esc_html__('If need to hide comment area and that form on single blog page, please turn this OFF.', 'charitio'),
          'default' => true,
        ),
    ),
  );


  // ------------------------------
  // Project Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'project_section',
    'title'    => esc_html__('Project', 'charitio'),
    'icon'     => 'fa fa-medkit',
    'fields' => array(

      // project name change
      array(
        'type'    => 'notice',
        'class'   => 'info cs-tmx-heading',
        'content' => esc_html__('Name Change', 'charitio')
      ),
      array(
        'id'      => 'theme_project_name',
        'type'    => 'text',
        'title'   => esc_html__('Project Name', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'Project'
        ),
      ),
      array(
        'id'      => 'theme_project_slug',
        'type'    => 'text',
        'title'   => esc_html__('Project Slug', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'project-item'
        ),
      ),
      array(
        'id'      => 'theme_project_cat_slug',
        'type'    => 'text',
        'title'   => esc_html__('Project Category Slug', 'charitio'),
        'attributes'     => array(
          'placeholder'  => 'project-category'
        ),
      ),
      array(
        'type'    => 'notice',
        'class'   => 'danger',
        'content' => __('<strong>Important</strong>: Please do not set project slug and page slug as same. It\'ll not work.', 'charitio')
      ),

      // Project Start
      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Project Single', 'charitio')
      ),
      array(
          'id'             => 'project_sidebar_position',
          'type'           => 'select',
          'title'          => esc_html__('Sidebar Position', 'charitio'),
          'options'        => array(
            'sidebar-right' => esc_html__('Right', 'charitio'),
            'sidebar-left' => esc_html__('Left', 'charitio'),
            'sidebar-hide' => esc_html__('Hide', 'charitio'),
          ),
          'default_option' => 'Select sidebar position',
          'info'          => esc_html__('Default option : Right', 'charitio'),
        ),
        array(
          'id'             => 'single_project_widget',
          'type'           => 'select',
          'title'          => esc_html__('Sidebar Widget', 'charitio'),
          'options'        => charitio_registered_sidebars(),
          'default_option' => esc_html__('Select Widget', 'charitio'),
          'dependency'     => array('project_sidebar_position', '!=', 'sidebar-hide'),
          'info'          => esc_html__('Default option : Main Widget Area', 'charitio'),
        ),
        array(
          'id'    => 'project_comment_form',
          'type'  => 'switcher',
          'title' => esc_html__('Comment Area/Form', 'charitio'),
          'info' => esc_html__('If need to hide comment area and that form on single blog page, please turn this OFF.', 'charitio'),
          'default' => true,
        ),
    ),
  );

  // ------------------------------
  // Blog Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'blog_section',
    'title'    => esc_html__('Blog', 'charitio'),
    'icon'     => 'fa fa-edit',
    'sections' => array(

      // blog general section
      array(
        'name'     => 'blog_general_tab',
        'title'    => esc_html__('General', 'charitio'),
        'icon'     => 'fa fa-cog',
        'fields'   => array(

          // Layout
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Layout', 'charitio')
          ),
          array(
            'id'             => 'blog_sidebar_position',
            'type'           => 'select',
            'title'          => esc_html__('Sidebar Position', 'charitio'),
            'options'        => array(
              'sidebar-right' => esc_html__('Right', 'charitio'),
              'sidebar-left' => esc_html__('Left', 'charitio'),
              'sidebar-hide' => esc_html__('Hide', 'charitio'),
            ),
            'default_option' => 'Select sidebar position',
            'help'          => esc_html__('This style will apply, default blog pages - Like : Archive, Category, Tags, Search & Author.', 'charitio'),
            'info'          => esc_html__('Default option : Right', 'charitio'),
          ),
          array(
            'id'             => 'blog_widget',
            'type'           => 'select',
            'title'          => esc_html__('Sidebar Widget', 'charitio'),
            'options'        => charitio_registered_sidebars(),
            'default_option' => esc_html__('Select Widget', 'charitio'),
            'dependency'     => array('blog_sidebar_position', '!=', 'sidebar-hide'),
            'info'          => esc_html__('Default option : Main Widget Area', 'charitio'),
          ),
          // Layout
          // Global Options
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Global Options', 'charitio')
          ),
          array(
            'id'         => 'theme_exclude_categories',
            'type'       => 'checkbox',
            'title'      => esc_html__('Exclude Categories', 'charitio'),
            'info'      => esc_html__('Select categories you want to exclude from blog page.', 'charitio'),
            'options'    => 'categories',
          ),
          array(
            'id'      => 'theme_blog_excerpt',
            'type'    => 'text',
            'title'   => esc_html__('Excerpt Length', 'charitio'),
            'info'   => esc_html__('Blog short content length, in blog listing pages.', 'charitio'),
            'default' => '55',
          ),
          array(
            'id'      => 'theme_metas_hide',
            'type'    => 'checkbox',
            'title'   => esc_html__('Meta\'s to hide', 'charitio'),
            'info'    => esc_html__('Check items you want to hide from blog/post meta field.', 'charitio'),
            'class'      => 'horizontal',
            'options'    => array(
              'category'   => esc_html__('Category', 'charitio'),
              'date'    => esc_html__('Date', 'charitio'),
              'author'     => esc_html__('Author', 'charitio'),
              'comments'      => esc_html__('Comments', 'charitio'),
              'Tag'      => esc_html__('Tag', 'charitio'),
            ),
            // 'default' => '30',
          ),
          // End fields

        )
      ),

      // blog single section
      array(
        'name'     => 'blog_single_tab',
        'title'    => esc_html__('Single', 'charitio'),
        'icon'     => 'fa fa-sticky-note',
        'fields'   => array(

          // Start fields
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Enable / Disable', 'charitio')
          ),
          array(
            'id'    => 'single_featured_image',
            'type'  => 'switcher',
            'title' => esc_html__('Featured Image', 'charitio'),
            'info' => esc_html__('If need to hide featured image from single blog post page, please turn this OFF.', 'charitio'),
            'default' => true,
          ),
           array(
            'id'    => 'single_author_info',
            'type'  => 'switcher',
            'title' => esc_html__('Author Info', 'charitio'),
            'info' => esc_html__('If need to hide author info on single blog page, please turn this On.', 'charitio'),
            'default' => false,
          ),
          array(
            'id'    => 'single_share_option',
            'type'  => 'switcher',
            'title' => esc_html__('Share Option', 'charitio'),
            'info' => esc_html__('If need to hide share option on single blog page, please turn this OFF.', 'charitio'),
            'default' => true,
          ),
          array(
            'id'    => 'single_comment_form',
            'type'  => 'switcher',
            'title' => esc_html__('Comment Area/Form ?', 'charitio'),
            'info' => esc_html__('If need to hide comment area and that form on single blog page, please turn this On.', 'charitio'),
            'default' => false,
          ),
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Sidebar', 'charitio')
          ),
          array(
            'id'             => 'single_sidebar_position',
            'type'           => 'select',
            'title'          => esc_html__('Sidebar Position', 'charitio'),
            'options'        => array(
              'sidebar-right' => esc_html__('Right', 'charitio'),
              'sidebar-left' => esc_html__('Left', 'charitio'),
              'sidebar-hide' => esc_html__('Hide', 'charitio'),
            ),
            'default_option' => 'Select sidebar position',
            'info'          => esc_html__('Default option : Right', 'charitio'),
          ),
          array(
            'id'             => 'single_blog_widget',
            'type'           => 'select',
            'title'          => esc_html__('Sidebar Widget', 'charitio'),
            'options'        => charitio_registered_sidebars(),
            'default_option' => esc_html__('Select Widget', 'charitio'),
            'dependency'     => array('single_sidebar_position', '!=', 'sidebar-hide'),
            'info'          => esc_html__('Default option : Main Widget Area', 'charitio'),
          ),
          // End fields

        )
      ),

    ),
  );

if (class_exists( 'WooCommerce' )){
  // ------------------------------
  // WooCommerce Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'woocommerce_section',
    'title'    => esc_html__('WooCommerce', 'charitio'),
    'icon'     => 'fa fa-shopping-cart',
    'fields' => array(

      // Start fields
      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Layout', 'charitio')
      ),
     array(
        'id'             => 'woo_product_columns',
        'type'           => 'select',
        'title'          => esc_html__('Product Column', 'charitio'),
        'options'        => array(
          2 => esc_html__('Two Column', 'charitio'),
          3 => esc_html__('Three Column', 'charitio'),
          4 => esc_html__('Four Column', 'charitio'),
        ),
        'default_option' => esc_html__('Select Product Columns', 'charitio'),
        'help'          => esc_html__('This style will apply, default woocommerce shop and archive pages.', 'charitio'),
      ),
      array(
        'id'             => 'woo_sidebar_position',
        'type'           => 'select',
        'title'          => esc_html__('Sidebar Position', 'charitio'),
        'options'        => array(
          'right-sidebar' => esc_html__('Right', 'charitio'),
          'left-sidebar' => esc_html__('Left', 'charitio'),
          'sidebar-hide' => esc_html__('Hide', 'charitio'),
        ),
        'default_option' => esc_html__('Select sidebar position', 'charitio'),
        'info'          => esc_html__('Default option : Right', 'charitio'),
      ),
      array(
        'id'             => 'woo_widget',
        'type'           => 'select',
        'title'          => esc_html__('Sidebar Widget', 'charitio'),
        'options'        => charitio_registered_sidebars(),
        'default_option' => esc_html__('Select Widget', 'charitio'),
        'dependency'     => array('woo_sidebar_position', '!=', 'sidebar-hide'),
        'info'          => esc_html__('Default option : Shop Page', 'charitio'),
      ),

      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Listing', 'charitio')
      ),
      array(
        'id'      => 'theme_woo_limit',
        'type'    => 'text',
        'title'   => esc_html__('Product Limit', 'charitio'),
        'info'   => esc_html__('Enter the number value for per page products limit.', 'charitio'),
      ),
      // End fields

      // Start fields
      array(
        'type'    => 'notice',
        'class'   => 'info cs-charitio-heading',
        'content' => esc_html__('Single Product', 'charitio')
      ),
      array(
        'id'             => 'woo_related_limit',
        'type'           => 'text',
        'title'          => esc_html__('Related Products Limit', 'charitio'),
      ),
      array(
        'id'    => 'woo_single_upsell',
        'type'  => 'switcher',
        'title' => esc_html__('You May Also Like', 'charitio'),
        'info' => esc_html__('If you don\'t want \'You May Also Like\' products in single product page, please turn this ON.', 'charitio'),
        'default' => false,
      ),
      array(
        'id'    => 'woo_single_related',
        'type'  => 'switcher',
        'title' => esc_html__('Related Products', 'charitio'),
        'info' => esc_html__('If you don\'t want \'Related Products\' in single product page, please turn this ON.', 'charitio'),
        'default' => false,
      ),
      // End fields

    ),
  );
}

  // ------------------------------
  // Extra Pages
  // ------------------------------
  $options[]   = array(
    'name'     => 'theme_extra_pages',
    'title'    => esc_html__('Extra Pages', 'charitio'),
    'icon'     => 'fa fa-clone',
    'sections' => array(

      // error 404 page
      array(
        'name'     => 'error_page_section',
        'title'    => esc_html__('404 Page', 'charitio'),
        'icon'     => 'fa fa-exclamation-triangle',
        'fields'   => array(

          // Start 404 Page
          array(
            'id'    => 'error_heading',
            'type'  => 'text',
            'title' => esc_html__('404 Page Heading', 'charitio'),
            'info'  => esc_html__('Enter 404 page heading.', 'charitio'),
          ),
          array(
            'id'    => 'error_subheading',
            'type'  => 'textarea',
            'title' => esc_html__('404 Page Sub Heading', 'charitio'),
            'info'  => esc_html__('Enter 404 page Sub heading.', 'charitio'),
          ),
          array(
            'id'    => 'error_page_content',
            'type'  => 'textarea',
            'title' => esc_html__('404 Page Content', 'charitio'),
            'info'  => esc_html__('Enter 404 page content.', 'charitio'),
            'shortcode' => true,
          ),
          array(
            'id'    => 'error_btn_text',
            'type'  => 'text',
            'title' => esc_html__('Button Text', 'charitio'),
            'info'  => esc_html__('Enter BACK TO HOME button text. If you want to change it.', 'charitio'),
          ),
          // End 404 Page

        ) // end: fields
      ), // end: fields section

      // maintenance mode page
      array(
        'name'     => 'maintenance_mode_section',
        'title'    => esc_html__('Maintenance Mode', 'charitio'),
        'icon'     => 'fa fa-hourglass-half',
        'fields'   => array(

          // Start Maintenance Mode
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('If you turn this ON : Only Logged in users will see your pages. All other visiters will see, selected page of : <strong>Maintenance Mode Page</strong>', 'charitio')
          ),
          array(
            'id'             => 'enable_maintenance_mode',
            'type'           => 'switcher',
            'title'          => esc_html__('Maintenance Mode', 'charitio'),
            'default'        => false,
          ),
          array(
            'id'             => 'maintenance_mode_page',
            'type'           => 'select',
            'title'          => esc_html__('Maintenance Mode Page', 'charitio'),
            'options'        => 'pages',
            'default_option' => esc_html__('Select a page', 'charitio'),
            'dependency'   => array( 'enable_maintenance_mode', '==', 'true' ),
          ),
          array(
            'id'             => 'maintenance_mode_title',
            'type'           => 'text',
            'title'          => esc_html__('Maintenance Mode Text', 'charitio'),
            'dependency'   => array( 'enable_maintenance_mode', '==', 'true' ),
          ),
          array(
            'id'             => 'maintenance_mode_text',
            'type'           => 'textarea',
            'title'          => esc_html__('Maintenance Mode Text', 'charitio'),
            'dependency'   => array( 'enable_maintenance_mode', '==', 'true' ),
          ),
          array(
            'id'             => 'maintenance_mode_bg',
            'type'           => 'background',
            'title'          => esc_html__('Page Background', 'charitio'),
            'dependency'   => array( 'enable_maintenance_mode', '==', 'true' ),
          ),
          // End Maintenance Mode

        ) // end: fields
      ), // end: fields section

    )
  );

  // ------------------------------
  // Advanced
  // ------------------------------
  $options[] = array(
    'name'   => 'theme_advanced',
    'title'  => esc_html__('Advanced', 'charitio'),
    'icon'   => 'fa fa-cog'
  );

  // ------------------------------
  // Misc Section
  // ------------------------------
  $options[]   = array(
    'name'     => 'misc_section',
    'title'    => esc_html__('Misc', 'charitio'),
    'icon'     => 'fa fa-recycle',
    'sections' => array(

      // custom sidebar section
      array(
        'name'     => 'custom_sidebar_section',
        'title'    => esc_html__('Custom Sidebar', 'charitio'),
        'icon'     => 'fa fa-reorder',
        'fields'   => array(

          // start fields
          array(
            'id'              => 'custom_sidebar',
            'title'           => esc_html__('Sidebars', 'charitio'),
            'desc'            => esc_html__('Go to Appearance -> Widgets after create sidebars', 'charitio'),
            'type'            => 'group',
            'fields'          => array(
              array(
                'id'          => 'sidebar_name',
                'type'        => 'text',
                'title'       => esc_html__('Sidebar Name', 'charitio'),
              ),
              array(
                'id'          => 'sidebar_desc',
                'type'        => 'text',
                'title'       => esc_html__('Custom Description', 'charitio'),
              )
            ),
            'accordion'       => true,
            'button_title'    => esc_html__('Add New Sidebar', 'charitio'),
            'accordion_title' => esc_html__('New Sidebar', 'charitio'),
          ),
          // end fields

        )
      ),
      // custom sidebar section

      // Custom CSS/JS
      array(
        'name'        => 'custom_css_js_section',
        'title'       => esc_html__('Custom Codes', 'charitio'),
        'icon'        => 'fa fa-code',

        // begin: fields
        'fields'      => array(
          // Start Custom CSS/JS
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Custom JS', 'charitio')
          ),
          array(
            'id'             => 'theme_custom_js',
            'type'           => 'textarea',
            'attributes' => array(
              'rows'     => 10,
              'placeholder'     => esc_html__('Enter your JS code here...', 'charitio'),
            ),
          ),
          // End Custom CSS/JS

        ) // end: fields
      ),

      // Translation
      array(
        'name'        => 'theme_translation_section',
        'title'       => esc_html__('Translation', 'charitio'),
        'icon'        => 'fa fa-language',

        // begin: fields
        'fields'      => array(

          // Start Translation
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Common Texts', 'charitio')
          ),
          array(
            'id'          => 'read_more_text',
            'type'        => 'text',
            'title'       => esc_html__('Read More Text', 'charitio'),
          ),
          array(
            'id'          => 'view_more_text',
            'type'        => 'text',
            'title'       => esc_html__('View More Text', 'charitio'),
          ),
          array(
            'id'          => 'share_text',
            'type'        => 'text',
            'title'       => esc_html__('Share Text', 'charitio'),
          ),
          array(
            'id'          => 'share_on_text',
            'type'        => 'text',
            'title'       => esc_html__('Share On Tooltip Text', 'charitio'),
          ),
          array(
            'id'          => 'author_text',
            'type'        => 'text',
            'title'       => esc_html__('Author Text', 'charitio'),
          ),
          array(
            'id'          => 'post_comment_text',
            'type'        => 'text',
            'title'       => esc_html__('Post Comment Text [Submit Button]', 'charitio'),
          ),
          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('WooCommerce', 'charitio')
          ),
          array(
            'id'          => 'add_to_cart_text',
            'type'        => 'text',
            'title'       => esc_html__('Add to Cart Text', 'charitio'),
          ),
          array(
            'id'          => 'details_text',
            'type'        => 'text',
            'title'       => esc_html__('Details Text', 'charitio'),
          ),

          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Pagination', 'charitio')
          ),
          array(
            'id'          => 'older_post',
            'type'        => 'text',
            'title'       => esc_html__('Older Posts Text', 'charitio'),
          ),
          array(
            'id'          => 'newer_post',
            'type'        => 'text',
            'title'       => esc_html__('Newer Posts Text', 'charitio'),
          ),

          array(
            'type'    => 'notice',
            'class'   => 'info cs-charitio-heading',
            'content' => esc_html__('Single Portfolio Pagination', 'charitio')
          ),
          array(
            'id'          => 'prev_port',
            'type'        => 'text',
            'title'       => esc_html__('Prev Case Text', 'charitio'),
          ),
          array(
            'id'          => 'next_port',
            'type'        => 'text',
            'title'       => esc_html__('Next Case Text', 'charitio'),
          ),
          // End Translation

        ) // end: fields
      ),

    ),
  );

  
  // ------------------------------
  // backup                       -
  // ------------------------------
  $options[]   = array(
    'name'     => 'backup_section',
    'title'    => 'Backup',
    'icon'     => 'fa fa-shield',
    'fields'   => array(

      array(
        'type'    => 'notice',
        'class'   => 'warning',
        'content' => esc_html__('You can save your current options. Download a Backup and Import.', 'charitio'),
      ),

      array(
        'type'    => 'backup',
      ),

    )
  );

  return $options;

}
add_filter( 'cs_framework_options', 'charitio_options' );