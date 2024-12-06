<?php
/*
Template Name: Mellon Material Single
Template Post Type: mellon_material
*/

get_header(); 

if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>

<div class="material-container">
    <div class="main-content"> 
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">
                <?php the_post_thumbnail( 'large' ); ?> 
            </div>
        <?php endif; ?>

        <div class="post-content">
            <h2><?php the_title(); ?></h2>
            <div class="description">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    <div class="materials-sidebar">
        <h3><a href="/material/">Όλο το Υλικό</a></h3>
        <ul class="mellon-material-categories">
            <?php
            $categories = get_terms( array(
                'taxonomy' => 'mellon_material_category', 
                'hide_empty' => true, // Hide categories with no posts
            ) );

            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                foreach ( $categories as $category ) {
                    //$category_link = get_term_link( $category );
                    $post_count = $category->count; 

                    echo '<li>' . esc_html( $category->name ) . ' (' . $post_count . ')</li>';
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="related-material">
    <h2>Σχετικά</h2>
    <div class="material-grid">
        <?php
        $current_post_id = get_the_ID();
        $categories = get_the_category($current_post_id);
        $category_ids = array();

        if ( $categories ) {
            foreach ( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }
        }

        $args = array(
            'post_type' => 'mellon_material',
            'posts_per_page' => 3,
            'post__not_in' => array( $current_post_id ),  // Exclude the current post
            'category__in' => $category_ids,  // Show posts from the same category
            'orderby' => 'rand' // Random order
        );

        $related_posts = new WP_Query( $args );

        if ( $related_posts->have_posts() ) :
            while ( $related_posts->have_posts() ) : $related_posts->the_post();
            ?>
                <div class="material">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'medium' ); ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>
            <?php
            endwhile;
            wp_reset_postdata(); 
        else :
            echo '<p>Δεν βρέθηκε σχετικό υλικό.</p>';
        endif;
        ?>
    </div>
</div>

<?php
    endwhile;
else : 
    // Content to display if the mellon_material post is not found
endif;

get_footer(); 
?>