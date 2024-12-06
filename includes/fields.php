<?php

// ... your existing code for registering the custom post type ...


// Add the "kmz_route" field using ACF (Advanced Custom Fields)
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_654a038e8d12d', // Generate a unique key
        'title' => 'Στοιχεία αναπηρικού υλικού',
        'fields' => array(
            array(
                'key' => 'field_654a03969873a', // Generate a unique key
                'label' => 'Κωδικός', 
                'name' => 'material_code',
                'type' => 'text',
                'instructions' => 'Προσθέστε εδώ τον κωδικό του υλικού',
                'required' => 0, 
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array', // Return file array
                'library' => 'all', 
                'min_size' => '', 
                'max_size' => '', 
                
            ),            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'mellon_material', // Your custom post type name
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0, // You might want to enable this for REST API access
    ));

endif;
