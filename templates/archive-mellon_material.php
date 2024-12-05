<?php
/*
Template Name: Geotour People Archive
Template Post Type: geotour_people
*/


 get_header(); 

 if ( have_posts() ) : 
    ?>
    <!-- START people content -->
    <div class="btContentHolder">
            <div class="btPostContentHolder">		
    <?php
     while ( have_posts() ) : the_post(); 
         // Your code to display each geotour_people post in the archive
        // the_title();
        // the_excerpt();
                






         // Add more fields as needed 
     endwhile;



     the_posts_navigation(); 

 else : 
     // Content to display if no geotour_people posts are found
 endif;

 get_footer(); 
 ?>
