<?php
/**
 * Plugin Name: Mellon Custom Content
 * Description: This plugin adds and modifies a new content type with ACF fields.
 * Version: 1.0
 * Author: Nikolakakis Manolis
 * Text Domain: mellon-custom-content 
 */

// Your plugin code will go here... 




// Single Template Hook
add_action('single_template', 'mellon_posts_single_template');

function mellon_posts_single_template($original_template) {
    global $post;

    if ($post->post_type == 'mellon_material') {
        $single_template = plugin_dir_path(__FILE__) . 'templates/single-mellon_material.php';
        if (file_exists($single_template)) {
            return $single_template;
        }
    }
	
    return $original_template;
}

// Archive Template Hook
add_action('archive_template', 'mellon_posts_archive_template');

function mellon_posts_archive_template($original_archive_template) {
    global $post;

    if (is_post_type_archive('mellon_material')) {
        $archive_template = plugin_dir_path(__FILE__) . 'templates/archive-mellon_material.php';
        if (file_exists($archive_template)) {
            return $archive_template;
        }
    }
	
    return $original_archive_template;
}


require_once plugin_dir_path( __FILE__ ) . 'includes/content_types.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/scripts.php';