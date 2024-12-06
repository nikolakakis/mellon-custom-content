<?php
/*
Template Name: Mellon Material Archive
Template Post Type: mellon_material
*/


get_header(); 

if ( have_posts() ) : 
    ?>
    <div class="material-grid-holder"> 
    <div id="mellon-filter"> 
            <div class="category-buttons">
                <button type="button" class="category-button active" data-category="">Όλα</button> 
                <?php
                $terms = get_terms( array(
                    'taxonomy' => 'mellon_material_category', 
                    'hide_empty' => true, // Hide categories with no posts
                ) );

                foreach ( $terms as $term ) {
                    ?>
                    <button type="button" class="category-button" data-category="<?php echo esc_attr( $term->slug ); ?>">
                        <?php echo esc_html( $term->name ) . ' (' . $term->count . ')'; ?>
                    </button>
                    <?php
                }
                ?>
            </div>
        </div> 

        <div class="mellon-grid-container" id="mellon-grid"> 
            <?php
            while ( have_posts() ) : the_post(); 
                ?>
                <div class="mellon-item"> 
                    <a href="<?php the_permalink(); ?>">
                    <div class="mellon-item-inner"><?php the_post_thumbnail( 'medium' ); ?></div> 
                        <h3><?php the_title(); ?></h3>
                        <?php // the_excerpt(); ?>
                    </a>
                    <div class="mellon-item-categories"> 
                        <?php
                        $categories = get_the_terms( get_the_ID(), 'mellon_material_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) {
                            $category_names = array();
                            foreach ( $categories as $category ) {
                                $category_names[] = $category->name;
                            }
                            echo implode( ', ', $category_names ); // Join with commas
                        }
                        ?>
                    </div> 
                </div>
                <?php
            endwhile; 
            ?>
        </div>

        <?php the_posts_navigation(); ?> 
    </div>
    <?php

else : 
    // Content to display if no mellon_material posts are found
endif;

get_footer(); 
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script>    
jQuery(document).ready(function($) {
    var currentPage = 1;

    // Function to perform the AJAX filtering
    function filterMellonMaterial(selectedCategories) {
        $.ajax({
            url: "/wp-json/mellon/v1/material",
            type: 'GET',
            data: {
                action: 'filter_mellon_material', 
                category: selectedCategories,
                page: currentPage
            },
            success: function(response) {
                var html = '';
                $.each(response, function(index, post) {
                    html += '<div class="mellon-item">';
                    html += '<a href="' + post.url + '">'; 
                    html += '<div class="mellon-item-inner">'; 
                    html += '<img width="' + post.image_width + '" height="' + post.image_height + '" src="' + post.image_src + '" class="' + post.image_class + '" alt="' + post.image_alt + '" decoding="async" loading="lazy" srcset="' + post.image_srcset + '" sizes="' + post.image_sizes + '">';
                    html += '</div>'; 
                    html += '<h3>' + post.title + '</h3>';                    
                    html += '</a>'; 

                    // Add categories
                    html += '<div class="mellon-item-categories">';
                    if (post.MellonCategory && post.MellonCategory.length > 0) {
                        var categoryNames = [];
                        $.each(post.MellonCategory, function(i, cat) {
                            categoryNames.push(cat.name); 
                        });
                        html += categoryNames.join(', '); // Join with commas
                    }
                    html += '</div>';

                    html += '</div>';
                });
                $('#mellon-grid').html(html); 
                // Apply animations AFTER the grid is updated
                $('.mellon-item').each(function(index) {
                    gsap.fromTo(
                        this, 
                        { opacity: 0, scale: 0.95 }, 
                        { 
                        opacity: 1, 
                        scale: 1, 
                        duration: 0.3, 
                        ease: "back.out(1.2)",
                        delay: index * 0.05 // Add a small delay for each item
                        }
                    );
                    });
            }
        });
    }

    // Handle category button clicks
    $('.category-buttons').on('click', '.category-button', function() {
        $(this).toggleClass('active'); 

        // "All" button handling
        if ($(this).data('category') === '') {
            if ($(this).hasClass('active')) {
                $('.category-button').addClass('active'); 
            } else {
                $('.category-button').removeClass('active'); 
            }
        } else {
            $('.category-button[data-category=""]').removeClass('active');
        }

        var selectedCategories = [];
        $('.category-button.active').each(function() {
            selectedCategories.push($(this).data('category'));
        });

        filterMellonMaterial(selectedCategories); 
    });

    // Pagination click handler (assuming you have "next page" links)
    $(document).on('click', '.next-page a', function(e) { 
        e.preventDefault();
        currentPage++;

        var selectedCategories = [];
        $('.category-button.active').each(function() {
            selectedCategories.push($(this).data('category'));
        });

        filterMellonMaterial(selectedCategories);
    });
});
</script>
