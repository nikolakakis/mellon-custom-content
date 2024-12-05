<?php

/**
 * Enqueue scripts and styles.
 */
function mellon_custom_content_scripts() {
    // Enqueue the compiled JavaScript file.
    wp_enqueue_script( 
        'mellon-custom-content-js', 
        plugins_url( 'build/index.js', __FILE__ ), 
        array(), // Dependencies (if any)
        '1.0', // Version number
        true // Load in the footer
    );

    // Enqueue the compiled CSS file.
    wp_enqueue_style( 
        'mellon-custom-content-css', 
        plugins_url( 'build/index.css', __FILE__ ) 
    );
}
add_action( 'wp_enqueue_scripts', 'mellon_custom_content_scripts' );

