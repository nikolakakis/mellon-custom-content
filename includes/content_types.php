<?php

/**
 * Register the Mellon custom types.
 */
function mellon_post_types() {
	
	register_post_type('mellon_material',array(
		'supports' => array('title','editor','excerpt', 'thumbnail', 'revisions'),
		'has_archive' => true,		
		'rewrite' => array('slug' => 'material'),
		'public' => true,
		'show_in_rest' => true,	
		'menu_icon' => 'dashicons-smiley',
		'labels' => array(
			'name' => 'Υλικό',
			'add_new_item' => 'Προσθήκη Υλικού',
			'edit_item' => 'Επεξεργασία Υλικού',
			'all_items' => 'Όλο το Υλικό',
			'singular_name' => 'Υλικό'
        ),
        'taxonomies' => array('mellon_material_tag','mellon_material_category'),
	));	
	
	
}
add_action( 'init', 'mellon_post_types' );




function add_mellon_tags_categories() {
    // Register 'geotour_people_category' taxonomy
    register_taxonomy('mellon_material_category', 'mellon_material', array(
        'labels' => array(
            'name' => 'Κατηγορίες Υλικού',
            'singular_name' => 'Κατηγορία Υλικού',
        ),
        'hierarchical' => true, // This makes it behave like categories
        'public' => true,
        'show_in_rest' => true, 
    ));

    // Register 'geotour_people_tag' taxonomy
    register_taxonomy('geotour_people_tag', 'mellon_material', array(
        'labels' => array(
            'name' => 'Ετικέτες Υλικού',
            'singular_name' => 'Ετικέτα Υλικού',
        ),
        'hierarchical' => false, // This makes it behave like tags
        'public' => true,
        'show_in_rest' => true, 
    ));   

}
add_action('init', 'add_mellon_tags_categories');


