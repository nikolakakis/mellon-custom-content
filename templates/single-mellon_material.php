<?php
/*
Template Name: Geotour People Single
Template Post Type: geotour_people
*/
 get_header(); 

 if ( have_posts() ) : 
     while ( have_posts() ) : the_post(); 
         // Your code to display the single geotour_people post content
         the_title();
        

        

        


         the_content();
        
        
         // Add more fields as needed (e.g., featured image, custom meta fields)
     endwhile;

 else : 
     // Content to display if the geotour_people post is not found
 endif;

 get_footer(); 
 ?>





