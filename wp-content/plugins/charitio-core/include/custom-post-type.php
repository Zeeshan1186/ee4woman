<?php

/**
 * Initialize Custom Post Type - Charitio Theme
 */

function charitio_custom_post_type() {

  
  // Event Start
  
  $event_cpt = (charitio_framework_active()) ? cs_get_option('theme_event_name') : '';
  $event_slug = (charitio_framework_active()) ? cs_get_option('theme_event_slug') : '';
  $event_cpt_slug = (charitio_framework_active()) ? cs_get_option('theme_event_cat_slug') : '';

  $base = (isset($event_cpt_slug) && $event_cpt_slug !== '') ? sanitize_title_with_dashes($event_cpt_slug) : ((isset($event_cpt) && $event_cpt !== '') ? strtolower($event_cpt) : 'event');
  $base_slug = (isset($event_slug) && $event_slug !== '') ? sanitize_title_with_dashes($event_slug) : ((isset($event_cpt) && $event_cpt !== '') ? strtolower($event_cpt) : 'event');
  $label = ucfirst((isset($event_cpt) && $event_cpt !== '') ? strtolower($event_cpt) : 'event');

  // Register custom post type - Event
  register_post_type('event',
    array(
      'labels' => array(
        'name' => $label,
        'singular_name' => sprintf(esc_html__('%s Post', 'charitio-core' ), $label),
        'all_items' => sprintf(esc_html__('All %s', 'charitio-core' ), $label),
        'add_new' => esc_html__('Add New', 'charitio-core') ,
        'add_new_item' => sprintf(esc_html__('Add New %s', 'charitio-core' ), $label),
        'edit' => esc_html__('Edit', 'charitio-core') ,
        'edit_item' => sprintf(esc_html__('Edit %s', 'charitio-core' ), $label),
        'new_item' => sprintf(esc_html__('New %s', 'charitio-core' ), $label),
        'view_item' => sprintf(esc_html__('View %s', 'charitio-core' ), $label),
        'search_items' => sprintf(esc_html__('Search %s', 'charitio-core' ), $label),
        'not_found' => esc_html__('Nothing found in the Database.', 'charitio-core') ,
        'not_found_in_trash' => esc_html__('Nothing found in Trash', 'charitio-core') ,
        'parent_item_colon' => ''
      ) ,
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 10,
      'menu_icon' => 'dashicons-portfolio',
      'rewrite' => array(
        'slug' => $base_slug,
        'with_front' => false
      ),
      'has_archive' => true,
      'capability_type' => 'post',
      'hierarchical' => true,
      'supports' => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'trackbacks',
        'custom-fields',
        'comments',
        'revisions',
        'sticky',
        'page-attributes'
      )
    )
  );
  // Registered

  // Add Category Taxonomy for our Custom Post Type - Event
  register_taxonomy(
    'event_category',
    'event',
    array(
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'labels' => array(
        'name' => sprintf(esc_html__( '%s Categories', 'charitio-core' ), $label),
        'singular_name' => sprintf(esc_html__('%s Category', 'charitio-core'), $label),
        'search_items' =>  sprintf(esc_html__( 'Search %s Categories', 'charitio-core'), $label),
        'all_items' => sprintf(esc_html__( 'All %s Categories', 'charitio-core'), $label),
        'parent_item' => sprintf(esc_html__( 'Parent %s Category', 'charitio-core'), $label),
        'parent_item_colon' => sprintf(esc_html__( 'Parent %s Category:', 'charitio-core'), $label),
        'edit_item' => sprintf(esc_html__( 'Edit %s Category', 'charitio-core'), $label),
        'update_item' => sprintf(esc_html__( 'Update %s Category', 'charitio-core'), $label),
        'add_new_item' => sprintf(esc_html__( 'Add New %s Category', 'charitio-core'), $label),
        'new_item_name' => sprintf(esc_html__( 'New %s Category Name', 'charitio-core'), $label)
      ),
      'rewrite' => array( 'slug' => $base . '_cat' ),
    )
  );

  $event_custom_taxonomies = (charitio_framework_active()) ? cs_get_option('event_custom_taxonomies') : '';
  $counter = 0;
  if ($event_custom_taxonomies) {
    foreach ($event_custom_taxonomies as $key => $custom_taxonomy) {
      $counter++;
      $heading = $custom_taxonomy['taxonomy_name'];
      $own_id = preg_replace('/[^a-z]/', "_", strtolower($heading));

      register_taxonomy(
        'event_'.$own_id,
        'event',
        array(
          'hierarchical' => true,
          'public' => true,
          'show_ui' => true,
          'show_admin_column' => true,
          'show_in_nav_menus' => true,
          'labels' => array(
            'name' => sprintf(esc_html__( '%s '.$heading, 'charitio-core' ), $label),
            'singular_name' => sprintf(esc_html__('%s '.$heading, 'charitio-core'), $label),
            'search_items' =>  sprintf(esc_html__( 'Search %s '.$heading, 'charitio-core'), $label),
            'all_items' => sprintf(esc_html__( 'All %s '.$heading, 'charitio-core'), $label),
            'parent_item' => sprintf(esc_html__( 'Parent %s '.$heading, 'charitio-core'), $label),
            'parent_item_colon' => sprintf(esc_html__( 'Parent %s :.$heading', 'charitio-core'), $label),
            'edit_item' => sprintf(esc_html__( 'Edit %s '.$heading, 'charitio-core'), $label),
            'update_item' => sprintf(esc_html__( 'Update %s '.$heading, 'charitio-core'), $label),
            'add_new_item' => sprintf(esc_html__( 'Add New %s '.$heading, 'charitio-core'), $label),
            'new_item_name' => sprintf(esc_html__( 'New %s '.$heading.' Name', 'charitio-core'), $label)
          ),
          'rewrite' => array( 'slug' => 'event_'.$own_id),
        )
      );
    }
  }






  // Project Start
  
  $project_cpt = (charitio_framework_active()) ? cs_get_option('theme_project_name') : '';
  $project_slug = (charitio_framework_active()) ? cs_get_option('theme_project_slug') : '';
  $project_cpt_slug = (charitio_framework_active()) ? cs_get_option('theme_project_cat_slug') : '';

  $base = (isset($project_cpt_slug) && $project_cpt_slug !== '') ? sanitize_title_with_dashes($project_cpt_slug) : ((isset($project_cpt) && $project_cpt !== '') ? strtolower($project_cpt) : 'project');
  $base_slug = (isset($project_slug) && $project_slug !== '') ? sanitize_title_with_dashes($project_slug) : ((isset($project_cpt) && $project_cpt !== '') ? strtolower($project_cpt) : 'project');
  $label = ucfirst((isset($project_cpt) && $project_cpt !== '') ? strtolower($project_cpt) : 'project');

  // Register custom post type - Project
  register_post_type('project',
    array(
      'labels' => array(
        'name' => $label,
        'singular_name' => sprintf(esc_html__('%s Post', 'charitio-core' ), $label),
        'all_items' => sprintf(esc_html__('All %s', 'charitio-core' ), $label),
        'add_new' => esc_html__('Add New', 'charitio-core') ,
        'add_new_item' => sprintf(esc_html__('Add New %s', 'charitio-core' ), $label),
        'edit' => esc_html__('Edit', 'charitio-core') ,
        'edit_item' => sprintf(esc_html__('Edit %s', 'charitio-core' ), $label),
        'new_item' => sprintf(esc_html__('New %s', 'charitio-core' ), $label),
        'view_item' => sprintf(esc_html__('View %s', 'charitio-core' ), $label),
        'search_items' => sprintf(esc_html__('Search %s', 'charitio-core' ), $label),
        'not_found' => esc_html__('Nothing found in the Database.', 'charitio-core') ,
        'not_found_in_trash' => esc_html__('Nothing found in Trash', 'charitio-core') ,
        'parent_item_colon' => ''
      ) ,
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 10,
      'menu_icon' => 'dashicons-portfolio',
      'rewrite' => array(
        'slug' => $base_slug,
        'with_front' => false
      ),
      'has_archive' => true,
      'capability_type' => 'post',
      'hierarchical' => true,
      'supports' => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'trackbacks',
        'custom-fields',
        'comments',
        'revisions',
        'sticky',
        'page-attributes'
      )
    )
  );
  // Registered

  // Add Category Taxonomy for our Custom Post Type - Project
  register_taxonomy(
    'project_category',
    'project',
    array(
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'labels' => array(
        'name' => sprintf(esc_html__( '%s Categories', 'charitio-core' ), $label),
        'singular_name' => sprintf(esc_html__('%s Category', 'charitio-core'), $label),
        'search_items' =>  sprintf(esc_html__( 'Search %s Categories', 'charitio-core'), $label),
        'all_items' => sprintf(esc_html__( 'All %s Categories', 'charitio-core'), $label),
        'parent_item' => sprintf(esc_html__( 'Parent %s Category', 'charitio-core'), $label),
        'parent_item_colon' => sprintf(esc_html__( 'Parent %s Category:', 'charitio-core'), $label),
        'edit_item' => sprintf(esc_html__( 'Edit %s Category', 'charitio-core'), $label),
        'update_item' => sprintf(esc_html__( 'Update %s Category', 'charitio-core'), $label),
        'add_new_item' => sprintf(esc_html__( 'Add New %s Category', 'charitio-core'), $label),
        'new_item_name' => sprintf(esc_html__( 'New %s Category Name', 'charitio-core'), $label)
      ),
      'rewrite' => array( 'slug' => $base . '_cat' ),
    )
  );

  $project_custom_taxonomies = (charitio_framework_active()) ? cs_get_option('project_custom_taxonomies') : '';
  $counter = 0;
  if ($project_custom_taxonomies) {
    foreach ($project_custom_taxonomies as $key => $custom_taxonomy) {
      $counter++;
      $heading = $custom_taxonomy['taxonomy_name'];
      $own_id = preg_replace('/[^a-z]/', "_", strtolower($heading));

      register_taxonomy(
        'project_'.$own_id,
        'project',
        array(
          'hierarchical' => true,
          'public' => true,
          'show_ui' => true,
          'show_admin_column' => true,
          'show_in_nav_menus' => true,
          'labels' => array(
            'name' => sprintf(esc_html__( '%s '.$heading, 'charitio-core' ), $label),
            'singular_name' => sprintf(esc_html__('%s '.$heading, 'charitio-core'), $label),
            'search_items' =>  sprintf(esc_html__( 'Search %s '.$heading, 'charitio-core'), $label),
            'all_items' => sprintf(esc_html__( 'All %s '.$heading, 'charitio-core'), $label),
            'parent_item' => sprintf(esc_html__( 'Parent %s '.$heading, 'charitio-core'), $label),
            'parent_item_colon' => sprintf(esc_html__( 'Parent %s :.$heading', 'charitio-core'), $label),
            'edit_item' => sprintf(esc_html__( 'Edit %s '.$heading, 'charitio-core'), $label),
            'update_item' => sprintf(esc_html__( 'Update %s '.$heading, 'charitio-core'), $label),
            'add_new_item' => sprintf(esc_html__( 'Add New %s '.$heading, 'charitio-core'), $label),
            'new_item_name' => sprintf(esc_html__( 'New %s '.$heading.' Name', 'charitio-core'), $label)
          ),
          'rewrite' => array( 'slug' => 'project_'.$own_id),
        )
      );
    }
  }

  // Team Start

  $team_cpt = (charitio_framework_active()) ? cs_get_option('theme_team_name') : '';
  $team_slug = (charitio_framework_active()) ? cs_get_option('theme_team_slug') : '';
  $team_cpt_slug = (charitio_framework_active()) ? cs_get_option('theme_team_cat_slug') : '';

  $base = (isset($team_cpt_slug) && $team_cpt_slug !== '') ? sanitize_title_with_dashes($team_cpt_slug) : ((isset($team_cpt) && $team_cpt !== '') ? strtolower($team_cpt) : 'team');
  $base_slug = (isset($team_slug) && $team_slug !== '') ? sanitize_title_with_dashes($team_slug) : ((isset($team_cpt) && $team_cpt !== '') ? strtolower($team_cpt) : 'team');
  $label = ucfirst((isset($team_cpt) && $team_cpt !== '') ? strtolower($team_cpt) : 'team');

  // Register custom post type - Team
  register_post_type('team',
    array(
      'labels' => array(
        'name' => $label,
        'singular_name' => sprintf(esc_html__('%s Post', 'charitio-core' ), $label),
        'all_items' => sprintf(esc_html__('All %s', 'charitio-core' ), $label),
        'add_new' => esc_html__('Add New', 'charitio-core') ,
        'add_new_item' => sprintf(esc_html__('Add New %s', 'charitio-core' ), $label),
        'edit' => esc_html__('Edit', 'charitio-core') ,
        'edit_item' => sprintf(esc_html__('Edit %s', 'charitio-core' ), $label),
        'new_item' => sprintf(esc_html__('New %s', 'charitio-core' ), $label),
        'view_item' => sprintf(esc_html__('View %s', 'charitio-core' ), $label),
        'search_items' => sprintf(esc_html__('Search %s', 'charitio-core' ), $label),
        'not_found' => esc_html__('Nothing found in the Database.', 'charitio-core') ,
        'not_found_in_trash' => esc_html__('Nothing found in Trash', 'charitio-core') ,
        'parent_item_colon' => ''
      ) ,
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 10,
      'menu_icon' => 'dashicons-portfolio',
      'rewrite' => array(
        'slug' => $base_slug,
        'with_front' => false
      ),
      'has_archive' => true,
      'capability_type' => 'post',
      'hierarchical' => true,
      'supports' => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'trackbacks',
        'custom-fields',
        'comments',
        'revisions',
        'sticky',
        'page-attributes'
      )
    )
  );
  // Registered

  // Add Category Taxonomy for our Custom Post Type - Team
  register_taxonomy(
    'team_category',
    'team',
    array(
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'labels' => array(
        'name' => sprintf(esc_html__( '%s Categories', 'charitio-core' ), $label),
        'singular_name' => sprintf(esc_html__('%s Category', 'charitio-core'), $label),
        'search_items' =>  sprintf(esc_html__( 'Search %s Categories', 'charitio-core'), $label),
        'all_items' => sprintf(esc_html__( 'All %s Categories', 'charitio-core'), $label),
        'parent_item' => sprintf(esc_html__( 'Parent %s Category', 'charitio-core'), $label),
        'parent_item_colon' => sprintf(esc_html__( 'Parent %s Category:', 'charitio-core'), $label),
        'edit_item' => sprintf(esc_html__( 'Edit %s Category', 'charitio-core'), $label),
        'update_item' => sprintf(esc_html__( 'Update %s Category', 'charitio-core'), $label),
        'add_new_item' => sprintf(esc_html__( 'Add New %s Category', 'charitio-core'), $label),
        'new_item_name' => sprintf(esc_html__( 'New %s Category Name', 'charitio-core'), $label)
      ),
      'rewrite' => array( 'slug' => $base . '_cat' ),
    )
  );

  $team_custom_taxonomies = (charitio_framework_active()) ? cs_get_option('team_custom_taxonomies') : '';
  $counter = 0;
  if ($team_custom_taxonomies) {
    foreach ($team_custom_taxonomies as $key => $custom_taxonomy) {
      $counter++;
      $heading = $custom_taxonomy['taxonomy_name'];
      $own_id = preg_replace('/[^a-z]/', "_", strtolower($heading));

      register_taxonomy(
        'team_'.$own_id,
        'team',
        array(
          'hierarchical' => true,
          'public' => true,
          'show_ui' => true,
          'show_admin_column' => true,
          'show_in_nav_menus' => true,
          'labels' => array(
            'name' => sprintf(esc_html__( '%s '.$heading, 'charitio-core' ), $label),
            'singular_name' => sprintf(esc_html__('%s '.$heading, 'charitio-core'), $label),
            'search_items' =>  sprintf(esc_html__( 'Search %s '.$heading, 'charitio-core'), $label),
            'all_items' => sprintf(esc_html__( 'All %s '.$heading, 'charitio-core'), $label),
            'parent_item' => sprintf(esc_html__( 'Parent %s '.$heading, 'charitio-core'), $label),
            'parent_item_colon' => sprintf(esc_html__( 'Parent %s :.$heading', 'charitio-core'), $label),
            'edit_item' => sprintf(esc_html__( 'Edit %s '.$heading, 'charitio-core'), $label),
            'update_item' => sprintf(esc_html__( 'Update %s '.$heading, 'charitio-core'), $label),
            'add_new_item' => sprintf(esc_html__( 'Add New %s '.$heading, 'charitio-core'), $label),
            'new_item_name' => sprintf(esc_html__( 'New %s '.$heading.' Name', 'charitio-core'), $label)
          ),
          'rewrite' => array( 'slug' => 'team_'.$own_id),
        )
      );
    }
  }

}




// After Theme Setup
function charitio_custom_flush_rules() {
	// Enter post type function, so rewrite work within this function
	charitio_custom_post_type();
	// Flush it
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'charitio_custom_flush_rules');
add_action('init', 'charitio_custom_post_type');


/* ---------------------------------------------------------------------------
 * Custom columns - case
 * --------------------------------------------------------------------------- */
add_filter("manage_edit-event_columns", "charitio_event_edit_columns");
function charitio_event_edit_columns($columns) {
  $new_columns['cb'] = '<input type="checkbox" />';
  $new_columns['title'] = esc_html__('Title', 'charitio-core' );
  $new_columns['thumbnail'] = esc_html__('Image', 'charitio-core' );
  $new_columns['date'] = esc_html__('Date', 'charitio-core' );

  return $new_columns;
}

add_action('manage_event_posts_custom_column', 'charitio_manage_event_columns', 10, 2);
function charitio_manage_event_columns( $column_name ) {
  global $post;

  switch ($column_name) {

    /* If displaying the 'Image' column. */
    case 'thumbnail':
      echo get_the_post_thumbnail( $post->ID, array( 100, 100) );
    break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
    break;

  }
}


// Team Slug
function charitio_custom_event_slug() {
  $event_cpt = (charitio_framework_active()) ? cs_get_option('theme_event_name') : '';
  if ($event_cpt === '') $event_cp = 'event';
  $rules = get_option( 'rewrite_rules' );
  if ( ! isset( $rules['('.$event_cpt.')/(\d*)$'] ) ) {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }
}
add_action( 'cs_validate_save_after','charitio_custom_event_slug' );


// Avoid event post type as 404 page while it change
function thx_cpt_avoid_error_event() {
  $event_cpt = (charitio_framework_active()) ? cs_get_option('theme_event_name') : '';
  if ($event_cpt === '') $event_cp = 'event';
  $set = get_option('post_type_rules_flased_' . $event_cpt);
  if ($set !== true){
    flush_rewrite_rules(false);
    update_option('post_type_rules_flased_' . $event_cpt,true);
  }
}
add_action('init', 'thx_cpt_avoid_error_event');

// Add Filter by Category in Team Type
add_action('restrict_manage_posts', 'charitio_filter_event_categories');
function charitio_filter_event_categories() {
  global $typenow;
  $post_type = 'event'; // Team post type
  $taxonomy  = 'event_category'; // Team category taxonomy
  if ($typenow == $post_type) {
    $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);
    wp_dropdown_categories(array(
      'show_option_all' => sprintf(esc_html__("Show All %s", 'charitio-core'), $info_taxonomy->label),
      'taxonomy'        => $taxonomy,
      'name'            => $taxonomy,
      'orderby'         => 'name',
      'selected'        => $selected,
      'show_count'      => true,
      'hide_empty'      => true,
    ));
  };
}




// Team Slug
function charitio_custom_team_slug() {
  $team_cpt = (charitio_framework_active()) ? cs_get_option('theme_team_name') : '';
  if ($team_cpt === '') $team_cp = 'team';
  $rules = get_option( 'rewrite_rules' );
  if ( ! isset( $rules['('.$team_cpt.')/(\d*)$'] ) ) {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }
}
add_action( 'cs_validate_save_after','charitio_custom_team_slug' );


// Avoid team post type as 404 page while it change
function thx_cpt_avoid_error_team() {
  $team_cpt = (charitio_framework_active()) ? cs_get_option('theme_team_name') : '';
  if ($team_cpt === '') $team_cp = 'team';
  $set = get_option('post_type_rules_flased_' . $team_cpt);
  if ($set !== true){
    flush_rewrite_rules(false);
    update_option('post_type_rules_flased_' . $team_cpt,true);
  }
}
add_action('init', 'thx_cpt_avoid_error_team');

// Add Filter by Category in Team Type
add_action('restrict_manage_posts', 'charitio_filter_team_categories');
function charitio_filter_team_categories() {
  global $typenow;
  $post_type = 'team'; // Team post type
  $taxonomy  = 'team_category'; // Team category taxonomy
  if ($typenow == $post_type) {
    $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);
    wp_dropdown_categories(array(
      'show_option_all' => sprintf(esc_html__("Show All %s", 'charitio-core'), $info_taxonomy->label),
      'taxonomy'        => $taxonomy,
      'name'            => $taxonomy,
      'orderby'         => 'name',
      'selected'        => $selected,
      'show_count'      => true,
      'hide_empty'      => true,
    ));
  };
}

// Team Search => ID to Term
add_filter('parse_query', 'charitio_team_id_term_search');
function charitio_team_id_term_search($query) {
  global $pagenow;
  $post_type = 'team'; // Team post type
  $taxonomy  = 'team_category'; // Team category taxonomy
  $q_vars    = &$query->query_vars;
  if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
    $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
    $q_vars[$taxonomy] = $term->slug;
  }
}

/* ---------------------------------------------------------------------------
 * Custom columns - Team
 * --------------------------------------------------------------------------- */
add_filter("manage_edit-team_columns", "charitio_team_edit_columns");
function charitio_team_edit_columns($columns) {
  $new_columns['cb'] = '<input type="checkbox" />';
  $new_columns['title'] = __('Title', 'charitio-core' );
  $new_columns['thumbnail'] = __('Image', 'charitio-core' );
  $new_columns['team_category'] = __('Categories', 'charitio-core' );
  $new_columns['team_order'] = __('Order', 'charitio-core' );
  $new_columns['date'] = __('Date', 'charitio-core' );

  return $new_columns;
}
add_action('manage_team_posts_custom_column', 'charitio_manage_team_columns', 10, 2);
function charitio_manage_team_columns( $column_name ) {
  global $post;

  switch ($column_name) {

    /* If displaying the 'Image' column. */
    case 'thumbnail':
      echo get_the_post_thumbnail( $post->ID, array( 100, 100) );
    break;

    /* If displaying the 'Categories' column. */
    case 'team_category' :

      $terms = get_the_terms( $post->ID, 'team_category' );

      if ( !empty( $terms ) ) {

        $out = array();
        foreach ( $terms as $term ) {
            $out[] = sprintf( '<a href="%s">%s</a>',
              esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'team_category' => $term->slug ), 'edit.php' ) ),
              esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'team_category', 'display' ) )
            );
        }
        /* Join the terms, separating them with a comma. */
        echo join( ', ', $out );
      }

      /* If no terms were found, output a default message. */
      else {
        echo '&macr;';
      }

    break;

    case "team_order":
      echo $post->menu_order;
    break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
    break;

  }
}


/* ---------------------------------------------------------------------------
 * Custom columns - case
 * --------------------------------------------------------------------------- */
add_filter("manage_edit-project_columns", "charitio_project_edit_columns");
function charitio_project_edit_columns($columns) {
  $new_columns['cb'] = '<input type="checkbox" />';
  $new_columns['title'] = esc_html__('Title', 'charitio-core' );
  $new_columns['thumbnail'] = esc_html__('Image', 'charitio-core' );
  $new_columns['date'] = esc_html__('Date', 'charitio-core' );

  return $new_columns;
}

add_action('manage_project_posts_custom_column', 'charitio_manage_project_columns', 10, 2);
function charitio_manage_project_columns( $column_name ) {
  global $post;

  switch ($column_name) {

    /* If displaying the 'Image' column. */
    case 'thumbnail':
      echo get_the_post_thumbnail( $post->ID, array( 100, 100) );
    break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
    break;

  }
}

