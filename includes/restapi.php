<?php
function register_mellon_material_endpoint() {
    register_rest_route( 'mellon/v1', '/material', array(
        'methods' => 'GET',
        'callback' => 'mellon_material_get_data',
    ) );
}
add_action( 'rest_api_init', 'register_mellon_material_endpoint' );

function mellon_material_get_data( $data ) {
    // Check to see if there is an ID set to the query, if not then plot all listings
    //$idarray=array(); 
    if ($data['theid']) {
        $args=array(
            'post_type' => 'mellon_material',
            'post_status'    => 'publish',	
            'posts_per_page' => 999,            
            's' => sanitize_text_field($data['search']),
            'p' => $data['theid']
        );
        $theid=$data["theid"];
        $reorder=1;
    } else {
        $args=array(
            'post_type' => 'mellon_material',
            'post_status'    => 'publish',	
            'posts_per_page' => 999,
            'lang' => $thelang,
            's' => sanitize_text_field($data['search'])
        );
        $reorder=0;
    }
    // Get the category from the request parameters
    if ( isset( $data['category'] ) && ! empty( $data['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'mellon_material_category',
                'field' => 'slug', 
                'terms' => $data['category'] 
            )
        );
    }
     // Get the page number from the request parameters
     if ( isset( $data['page'] ) && ! empty( $data['page'] ) ) {
        $args['paged'] = $data['page'];
    }

    $mellon = new WP_Query( $args ); 
    $mellonarray = array();

    while ( $mellon->have_posts() ) {
        $mellon->the_post();
        $theid = get_the_id();

        // Get featured image data
        $image_id = get_post_thumbnail_id( $theid );
        $image_data = wp_get_attachment_image_src( $image_id, 'medium' ); // Or your desired image size

        array_push($mellonarray, array(
            'listingID' => $theid,             
            'title' => get_the_title(),           
            'url' => get_the_permalink(),         
            'mellonThumbUrl' => get_the_post_thumbnail_url(), 
            'MellonCategory' => get_the_terms($theid,'mellon_material_category'),
            // Add image data
            'image_width' => $image_data[1],  // Image width
            'image_height' => $image_data[2], // Image height
            'image_src' => $image_data[0],    // Image URL 
            'image_class' => 'attachment-medium size-medium wp-post-image', // Or get the actual class
            'image_alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ), // Get alt text
            'image_srcset' => wp_get_attachment_image_srcset( $image_id, 'medium' ), // Or your desired size
            'image_sizes' => wp_get_attachment_image_sizes( $image_id, 'medium' ),  // Or your desired size  
            'excerpt' => get_the_excerpt(),
        ));
    }

    wp_reset_postdata();
    return $mellonarray;   
}
