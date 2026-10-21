<?php
/*
 * All Custom Shortcode for [theme_name] theme.
 * Author & Copyright: wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

if( ! function_exists( 'charitio_shortcodes' ) ) {
  function charitio_shortcodes( $options ) {

    $options       = array();

    /* Topbar Shortcodes */
    $options[]     = array(
      'title'      => esc_html__('Topbar Shortcodes', 'charitio'),
      'shortcodes' => array(

        // Topbar item
        array(
          'name'          => 'charitio_widget_topbars',
          'title'         => esc_html__('Topbar info', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_widget_topbar',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'donate_text',
              'type'      => 'text',
              'title'     => esc_html__('Donate Text', 'charitio'),
            ),
            array(
              'id'        => 'donate_link',
              'type'      => 'text',
              'title'     => esc_html__('Donate Link', 'charitio'),
            ),
            
          ),
          'clone_fields'  => array(
           
            array(
              'id'        => 'title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio'),
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'title'     => esc_html__('Link', 'charitio'),
            ),
            array(
              'id'        => 'open_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'yes'     => esc_html__('Yes', 'charitio'),
              'no'     => esc_html__('No', 'charitio'),
            ),

          ),

        ),
       

      ),
    );

    /* Header Shortcodes */
    $options[]     = array(
      'title'      => esc_html__('Header Shortcodes', 'charitio'),
      'shortcodes' => array(

        // header Social
        array(
          'name'          => 'charitio_header_socials',
          'title'         => esc_html__('Header Social', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_header_social',
          'clone_title'   => esc_html__('Add New Social', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'social_title',
              'type'      => 'text',
              'title'     => esc_html__('Social Title', 'charitio'),
            ),

          ),
          'clone_fields'  => array(
            array(
              'id'        => 'social_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Social Icon', 'charitio')
            ),
            array(
              'id'        => 'social_icon_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Icon Color', 'charitio'),
            ),
            array(
              'id'        => 'social_link',
              'type'      => 'text',
              'title'     => esc_html__('Social Link', 'charitio')
            ),
            array(
              'id'        => 'target_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'yes'     => esc_html__('Yes', 'charitio'),
              'no'     => esc_html__('No', 'charitio'),
            ),

          ),

        ),
        // header Social End

        // header Middle Infos
        array(
          'name'          => 'charitio_header_middle_infos',
          'title'         => esc_html__('Header Middle Info', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_header_middle_info',
          'clone_title'   => esc_html__('Add New Info', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

          ),
          'clone_fields'  => array(
            array(
              'id'        => 'social_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Social Icon', 'charitio')
            ),
            array(
              'id'        => 'social_icon_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Icon Color', 'charitio'),
            ),
            array(
              'id'        => 'address_text',
              'type'      => 'text',
              'title'     => esc_html__('Address Text', 'charitio')
            ),
            array(
              'id'        => 'address_desc',
              'type'      => 'text',
              'title'     => esc_html__('Address Details', 'charitio')
            ),
          ),

        ),
        // header Middle Infos End



      ),
    );

    /* Content Shortcodes */
    $options[]     = array(
      'title'      => esc_html__('Content Shortcodes', 'charitio'),
      'shortcodes' => array(

        // Spacer
        array(
          'name'          => 'vc_empty_space',
          'title'         => esc_html__('Spacer', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'height',
              'type'      => 'text',
              'title'     => esc_html__('Height', 'charitio'),
              'attributes' => array(
                'placeholder'     => '20px',
              ),
            ),

          ),
        ),
        // Spacer

        // Social Icons
        array(
          'name'          => 'charitio_socials',
          'title'         => esc_html__('Social Icons', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_social',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),  
            array(
              'id'        => 'section_title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio'),
            ),

            // Colors
            array(
              'type'    => 'notice',
              'class'   => 'info',
              'content' => esc_html__('Colors', 'charitio')
            ),
            array(
              'id'        => 'icon_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Icon Color', 'charitio'),
              'wrap_class' => 'column_third',
            ),
            array(
              'id'        => 'icon_hover_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Icon Hover Color', 'charitio'),
              'wrap_class' => 'column_third',
              'dependency'  => array('social_select', '!=', 'style-three'),
            ),
            array(
              'id'        => 'bg_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Backrgound Color', 'charitio'),
              'wrap_class' => 'column_third',
              'dependency'  => array('social_select', '!=', 'style-one'),
            ),
            array(
              'id'        => 'bg_hover_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Backrgound Hover Color', 'charitio'),
              'wrap_class' => 'column_third',
              'dependency'  => array('social_select', '==', 'style-two'),
            ),
            array(
              'id'        => 'border_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Border Color', 'charitio'),
              'wrap_class' => 'column_third',
              'dependency'  => array('social_select', '==', 'style-three'),
            ),

            // Icon Size
            array(
              'id'        => 'icon_size',
              'type'      => 'text',
              'title'     => esc_html__('Icon Size', 'charitio'),
              'wrap_class' => 'column_full',
            ),

          ),
          'clone_fields'  => array(

            array(
              'id'        => 'social_link',
              'type'      => 'text',
              'attributes' => array(
                'placeholder'     => 'http://',
              ),
              'title'     => esc_html__('Link', 'charitio')
            ),
            array(
              'id'        => 'social_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Social Icon', 'charitio')
            ),
            array(
              'id'        => 'target_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'on_text'     => esc_html__('Yes', 'charitio'),
              'off_text'     => esc_html__('No', 'charitio'),
            ),

          ),

        ),
        // Social Icons

        // Useful Links
        array(
          'name'          => 'charitio_useful_links',
          'title'         => esc_html__('Useful Links', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_useful_link',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'column_width',
              'type'      => 'select',
              'title'     => esc_html__('Column Width', 'charitio'),
              'options'        => array(
                'full-width' => esc_html__('One Column', 'charitio'),
                'half-width' => esc_html__('Two Column', 'charitio'),
                'third-width' => esc_html__('Three Column', 'charitio'),
              ),
            ),
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

          ),
          'clone_fields'  => array(

            array(
              'id'        => 'title_link',
              'type'      => 'text',
              'title'     => esc_html__('Link', 'charitio')
            ),
            array(
              'id'        => 'target_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'on_text'     => esc_html__('Yes', 'charitio'),
              'off_text'     => esc_html__('No', 'charitio'),
            ),
            array(
              'id'        => 'link_title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio')
            ),

          ),

        ),
        // Useful Links

        // Simple Image List
        array(
          'name'          => 'charitio_image_lists',
          'title'         => esc_html__('Simple Image List', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_image_list',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

          ),
          'clone_fields'  => array(

            array(
              'id'        => 'get_image',
              'type'      => 'upload',
              'title'     => esc_html__('Image', 'charitio')
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'attributes' => array(
                'placeholder'     => 'http://',
              ),
              'title'     => esc_html__('Link', 'charitio')
            ),
            array(
              'id'    => 'open_tab',
              'type'  => 'switcher',
              'std'   => false,
              'title' => esc_html__('Open link to new tab?', 'charitio')
            ),

          ),

        ),
        // Simple Image List

        // Simple Link
        array(
          'name'          => 'charitio_simple_link',
          'title'         => esc_html__('Simple Link', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'link_style',
              'type'      => 'select',
              'title'     => esc_html__('Link Style', 'charitio'),
              'options'        => array(
                'link-underline' => esc_html__('Link Underline', 'charitio'),
                'link-arrow-right' => esc_html__('Link Arrow (Right)', 'charitio'),
                'link-arrow-left' => esc_html__('Link Arrow (Left)', 'charitio'),
              ),
            ),
            array(
              'id'        => 'link_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Icon', 'charitio'),
              'value'      => 'fa fa-caret-right',
              'dependency'  => array('link_style', '!=', 'link-underline'),
            ),
            array(
              'id'        => 'link_text',
              'type'      => 'text',
              'title'     => esc_html__('Link Text', 'charitio'),
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'title'     => esc_html__('Link', 'charitio'),
              'attributes' => array(
                'placeholder'     => 'http://',
              ),
            ),
            array(
              'id'        => 'target_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'on_text'     => esc_html__('Yes', 'charitio'),
              'off_text'     => esc_html__('No', 'charitio'),
            ),
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

            // Normal Mode
            array(
              'type'    => 'notice',
              'class'   => 'info',
              'content' => esc_html__('Normal Mode', 'charitio')
            ),
            array(
              'id'        => 'text_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Text Color', 'charitio'),
              'wrap_class' => 'column_half el-hav-border',
            ),
            array(
              'id'        => 'border_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Border Color', 'charitio'),
              'wrap_class' => 'column_half el-hav-border',
              'dependency'  => array('link_style', '==', 'link-underline'),
            ),
            // Hover Mode
            array(
              'type'    => 'notice',
              'class'   => 'info',
              'content' => esc_html__('Hover Mode', 'charitio')
            ),
            array(
              'id'        => 'text_hover_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Text Hover Color', 'charitio'),
              'wrap_class' => 'column_half el-hav-border',
            ),
            array(
              'id'        => 'border_hover_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Border Hover Color', 'charitio'),
              'wrap_class' => 'column_half el-hav-border',
              'dependency'  => array('link_style', '==', 'link-underline'),
            ),

            // Size
            array(
              'type'    => 'notice',
              'class'   => 'info',
              'content' => esc_html__('Font Sizes', 'charitio')
            ),
            array(
              'id'        => 'text_size',
              'type'      => 'text',
              'title'     => esc_html__('Text Size', 'charitio'),
              'attributes' => array(
                'placeholder'     => 'Eg: 14px',
              ),
            ),

          ),
        ),
        // Simple Link

        // Blockquotes
        array(
          'name'          => 'charitio_blockquote',
          'title'         => esc_html__('Blockquote', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'blockquote_style',
              'type'      => 'select',
              'title'     => esc_html__('Blockquote Style', 'charitio'),
              'options'        => array(
                '' => esc_html__('Select Blockquote Style', 'charitio'),
                'style-one' => esc_html__('Style One', 'charitio'),
                'style-two' => esc_html__('Style Two', 'charitio'),
              ),
            ),
            array(
              'id'        => 'text_size',
              'type'      => 'text',
              'title'     => esc_html__('Text Size', 'charitio'),
            ),
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'content_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Content Color', 'charitio'),
            ),
            array(
              'id'        => 'left_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Left Border Color', 'charitio'),
            ),
            array(
              'id'        => 'border_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Border Color', 'charitio'),
            ),
            array(
              'id'        => 'bg_color',
              'type'      => 'color_picker',
              'title'     => esc_html__('Background Color', 'charitio'),
            ),
            // Content
            array(
              'id'        => 'content',
              'type'      => 'textarea',
              'title'     => esc_html__('Content', 'charitio'),
            ),

          ),

        ),
        // Blockquotes

      ),
    );

    /* Widget Shortcodes */
    $options[]     = array(
      'title'      => esc_html__('Widget Shortcodes', 'charitio'),
      'shortcodes' => array(

        // widget Contact info
        array(
          'name'          => 'charitio_widget_contact_info',
          'title'         => esc_html__('Contact info', 'charitio'),
          'fields'        => array(
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
             array(
              'id'        => 'image_url',
              'type'      => 'image',
              'title'     => esc_html__('Image background', 'charitio'),
            ),
            array(
              'id'        => 'title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio'),
            ),
            array(
              'id'        => 'desc',
              'type'      => 'textarea',
              'title'     => esc_html__('Description', 'charitio'),
            ),
            array(
              'id'        => 'link_text',
              'type'      => 'text',
              'title'     => esc_html__('Link text', 'charitio'),
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'title'     => esc_html__('Link', 'charitio'),
            ),

          ),
        ),

        // widget Testimonials
        array(
          'name'          => 'charitio_widget_testimonial',
          'title'         => esc_html__('Testimonial', 'charitio'),
          'fields'        => array(
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
             array(
              'id'        => 'image_url',
              'type'      => 'image',
              'title'     => esc_html__('Image background', 'charitio'),
            ),
            array(
              'id'        => 'subtitle',
              'type'      => 'text',
              'title'     => esc_html__('Sub Title', 'charitio'),
            ),
            array(
              'id'        => 'title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio'),
            ),
            array(
              'id'        => 'desc',
              'type'      => 'textarea',
              'title'     => esc_html__('Description', 'charitio'),
            ),

          ),
        ),

       // About widget Block
        array(
          'name'          => 'charitio_about_widget',
          'title'         => esc_html__('About Widget Block', 'charitio'),
          'fields'        => array(
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'title',
              'type'      => 'text',
              'title'     => esc_html__('Title', 'charitio'),
            ),
            array(
              'id'        => 'image_url',
              'type'      => 'image',
              'title'     => esc_html__('About Block Image', 'charitio'),
            ),
            array(
              'id'        => 'desc',
              'type'      => 'textarea',
              'title'     => esc_html__('Description', 'charitio'),
            ),
            array(
              'id'        => 'link_text',
              'type'      => 'text',
              'title'     => esc_html__('Link text', 'charitio'),
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'title'     => esc_html__('Link', 'charitio'),
            ),

          ),
        ),


      // Cause Contact Widget
        array(
          'name'          => 'charitio_causes_widget_contacts',
          'title'         => esc_html__('Cause CTA Widget', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_causes_widget_contact',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'case_bg',
              'type'      => 'image',
              'title'     => esc_html__('Atached Image', 'charitio'),
            ),
          ),
          'clone_fields'  => array(
           
             array(
              'id'        => 'info_title',
              'type'      => 'text',
              'title'     => esc_html__('Contact title', 'charitio')
            ),
             array(
              'id'        => 'info_desc',
              'type'      => 'text',
              'title'     => esc_html__('Contact Desc', 'charitio')
            ),

          ),

        ),
      // Service Contact Widget End
        // widget download-widget
        array(
          'name'          => 'charitio_download_widgets',
          'title'         => esc_html__('Download Widget', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_download_widget',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
          ),
          'clone_fields'  => array(

            array(
              'id'        => 'download_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Download Icon', 'charitio')
            ),
            array(
              'id'        => 'title',
              'type'      => 'text',
              'title'     => esc_html__('Download Title', 'charitio')
            ),
            array(
              'id'        => 'link',
              'type'      => 'text',
              'title'     => esc_html__('Download Link', 'charitio')
            ),

          ),

        ),

      ),
    );

    /* Footer Shortcodes */
    $options[]     = array(
      'title'      => esc_html__('Footer Shortcodes', 'charitio'),
      'shortcodes' => array(

        // Footer Menus
        array(
          'name'          => 'charitio_footer_menus',
          'title'         => esc_html__('Footer Menu Links', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_footer_menu',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

          ),
          'clone_fields'  => array(

            array(
              'id'        => 'menu_title',
              'type'      => 'text',
              'title'     => esc_html__('Menu Title', 'charitio')
            ),
            array(
              'id'        => 'menu_link',
              'type'      => 'text',
              'title'     => esc_html__('Menu Link', 'charitio')
            ),
            array(
              'id'        => 'target_tab',
              'type'      => 'switcher',
              'title'     => esc_html__('Open New Tab?', 'charitio'),
              'on_text'     => esc_html__('Yes', 'charitio'),
              'off_text'     => esc_html__('No', 'charitio'),
            ),

          ),

        ),
        // Footer Menus
        array(
          'name'          => 'footer_infos',
          'title'         => esc_html__('footer logo and Text', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'footer_info',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(
            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),
            array(
              'id'        => 'footer_logo',
              'type'      => 'image',
              'title'     => esc_html__('Footer logo', 'charitio'),
            ),
            array(
              'id'        => 'desc',
              'type'      => 'textarea',
              'title'     => esc_html__('Description', 'charitio'),
            ),
            
          ),
          'clone_fields'  => array(
            array(
              'id'        => 'social_icon',
              'type'      => 'icon',
              'title'     => esc_html__('Social Icon', 'charitio')
            ),
            array(
              'id'        => 'social_link',
              'type'      => 'text',
              'title'     => esc_html__('Social Link', 'charitio')
            ),
          ),

        ),

      // footer contact info
      array(
        'name'          => 'charitio_footer_contact_infos',
        'title'         => esc_html__('Contact info', 'charitio'),
        'view'          => 'clone',
        'clone_id'      => 'charitio_footer_contact_info',
        'clone_title'   => esc_html__('Add New', 'charitio'),
        'fields'        => array(

          array(
            'id'        => 'custom_class',
            'type'      => 'text',
            'title'     => esc_html__('Custom Class', 'charitio'),
          ),
          array(
            'id'        => 'title',
            'type'      => 'textarea',
            'title'     => esc_html__('Heading Title', 'charitio'),
          ),

        ),
        'clone_fields'  => array(

          array(
            'id'        => 'item_icon',
            'type'      => 'icon',
            'title'     => esc_html__('Contact info icon', 'charitio')
          ),
          array(
            'id'        => 'item',
            'type'      => 'text',
            'title'     => esc_html__('Contact info item', 'charitio')
          ),
        ),

      ),

      // footer Address
       array(
          'name'          => 'charitio_footer_address_item',
          'title'         => esc_html__('Address', 'charitio'),
          'view'          => 'clone',
          'clone_id'      => 'charitio_footer_address_items',
          'clone_title'   => esc_html__('Add New', 'charitio'),
          'fields'        => array(

            array(
              'id'        => 'custom_class',
              'type'      => 'text',
              'title'     => esc_html__('Custom Class', 'charitio'),
            ),

          ),
          'clone_fields'  => array(
            array(
              'id'        => 'item',
              'type'      => 'text',
              'title'     => esc_html__('Address item', 'charitio')
            ),
          ),
        ),

      ),
    );

  return $options;

  }
  add_filter( 'cs_shortcode_options', 'charitio_shortcodes' );
}