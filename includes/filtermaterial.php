<?php

add_action( 'wp_ajax_filter_mellon_material', 'filter_mellon_material_callback' );
add_action( 'wp_ajax_nopriv_filter_mellon_material', 'filter_mellon_material_callback' );

function filter_mellon_material_callback() {
  $category = $_POST['category'];

  $args = array(
    'post_type' => 'mellon-material',
  );
  if ( $category ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'mellon_material_category',
        'field' => 'slug',
        'terms' => $category,
      )
    );
  }

  $query = new WP_Query( $args );

  // Loop through posts and generate HTML for the grid
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      // ... your code to display post data in the grid ...
    }
  } else {
    // ... your code to display a "no posts found" message ...
  }

  wp_die(); // Always use wp_die() in AJAX callbacks
}