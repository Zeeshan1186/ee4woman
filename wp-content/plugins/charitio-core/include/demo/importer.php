<?php


/**
 * One Click Install
 * @return Import Demos - Needed Import Demo's
 */
function charitio_import_files() {
  return array(
    array(
      'import_file_name'           => 'Charitio',
      'import_file_url'            => trailingslashit( CHARITIO_PLUGIN_URL ) . 'include/demo/content.xml',
      'local_import_csf'           => array(
        array(
          'file_path'   => trailingslashit( CHARITIO_PLUGIN_URL ) . 'include/demo/theme-options.json',
          'option_name' => '_cs_options',
        ),
      ),
      'import_widget_file_url'     => trailingslashit( CHARITIO_PLUGIN_URL ) . 'include/demo/widget.wie',
      'preview_url'                => 'http://charitio.themegeniuslab.com/',
      'import_notice'                => '',
      'import_preview_image_url'   => 'http://charitio.themegeniuslab.com/wp-content/themes/charitio/screenshot.png',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'charitio_import_files' );

/**
 * One Click Import Function for CodeStar Framework
 */
if ( ! function_exists( 'csf_after_content_import_execution' ) ) {
  function csf_after_content_import_execution( $selected_import_files, $import_files, $selected_index ) {

    $downloader = new OCDI\Downloader();

    if( ! empty( $import_files[$selected_index]['import_csf'] ) ) {

      foreach( $import_files[$selected_index]['import_csf'] as $index => $import ) {
        $file_path = $downloader->download_file( $import['file_url'], 'demo-csf-import-file-'. $index . '-'. date( 'Y-m-d__H-i-s' ) .'.json' );
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    } else if( ! empty( $import_files[$selected_index]['local_import_csf'] ) ) {

      foreach( $import_files[$selected_index]['local_import_csf'] as $index => $import ) {
        $file_path = $import['file_path'];
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    }
    // Put info to log file.
    $ocdi       = OCDI\OneClickDemoImport::get_instance();
    $log_path   = $ocdi->get_log_file_path();

    OCDI\Helpers::append_to_file( 'Codestar Framework files loaded.'. $logs, $log_path );

  }
  add_action('pt-ocdi/after_content_import_execution', 'csf_after_content_import_execution', 3, 99 );
}

/**
 * charitio_after_import_setup
 * @return Front Page, Post Page & Menu Set
 */
function charitio_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'slug', 'main-menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
        'primary' => $main_menu->term_id,
      )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id = get_page_by_title( 'Blog' );

    update_option( 'date_format', 'M j' );
    update_option( 'selection', '/%postname%/' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'charitio_after_import_setup' );

$locations = get_theme_mod( 'nav_menu_locations' );


// Install Demos Menu - Menu Edited
function charitio_core_one_click_page( $default_settings ) {
  $default_settings['parent_slug'] = 'themes.php';
  $default_settings['page_title']  = esc_html__( 'Install Demo', 'charitio-core' );
  $default_settings['menu_title']  = esc_html__( 'Install Demo', 'charitio-core' );
  $default_settings['capability']  = 'import';
  $default_settings['menu_slug']   = 'install_demos';

  return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'charitio_core_one_click_page' );

// Model Popup - Width Increased
function charitio_ocdi_confirmation_dialog_options ( $options ) {
  return array_merge( $options, array(
    'width'       => 600,
    'dialogClass' => 'wp-dialog',
    'resizable'   => false,
    'height'      => 'auto',
    'modal'       => true,
  ) );
}
add_filter( 'pt-ocdi/confirmation_dialog_options', 'charitio_ocdi_confirmation_dialog_options', 10, 1 );


function charitio_ocdi_plugin_intro_text( $default_text ) {
    $default_text .= '
  <h1>Import Demo</h1>
    <div class="one-click-import-img">
      <img src="http://charitio.themegeniuslab.com/wp-content/themes/charitio/screenshot.png" alt="img">
    </div>
    <div class="charitio-core_intro-text demo-one-click">
      <div id="poststuff" class="postbox-wrap clearfix">
        <div class="single-postbox first-box">
        <div class="box-inner important-notes">
          <h3><span>Important notes:</span></h3>
          <div class="inside">
            <ol>
              <li>This import process will take time. Please be patient.</li>
              <li>Please make sure you\'ve installed recommended plugins before you import this content.</li>
              <li>All images are demo purposes only. So, images may repeat in your site content.</li>
            </ol>
          </div>
        </div>
        </div>
        <div class="single-postbox second-box">
        <div class="box-inner important-notes">
          <h3><span>Don\'t Edit Parent Theme Files:</span></h3>
          <div class="inside">
            <p>Don\'t edit any files from parent theme! Use only a <strong>Child Theme</strong> files for your customizations!</p>
            <p>If you get future updates from our theme, you\'ll lose edited customization from your parent theme.</p>
          </div>
        </div>
        </div>
        <div class="single-postbox third-box">
        <div class="box-inner important-notes">
          <h3><span>Need Support?</span></h3>
          <div class="inside">
            <p>Have any doubts regarding this installation or any other issues? Please feel free to open a ticket in our support center.</p>
            <a href="http://themegeniuslab.com/docs/charitio/documentation" class="button-primary" target="_blank">Docs</a>
            <a href="https://support.themegeniuslab.com" class="button-primary" target="_blank">Support</a>
            <a href="https://themeforest.net/user/wpoceans/portfolio" class="button-primary" target="_blank">Item Page</a>
          </div>
        </div>
        </div>
      </div>
    </div>';

  return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'charitio_ocdi_plugin_intro_text' );