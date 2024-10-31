<?php
// Control core classes for avoid errors
if (class_exists('CSF')) {

    //
    // Set a unique slug-like ID
    $prefix = 'seox_metabox';

    //
    // Create a metabox
    CSF::createMetabox($prefix, array(
        'title'     =>  __('SEO X', 'seox'),
        'post_type' =>  array('post', 'page', 'product'),
        'context'   =>  'normal', // The context within the screen where the boxes should display. `normal`, `side`, `advanced`
        'nav'       =>  'inline',
        'theme'     =>  'light',
    ));

    //
    // Create a section
    CSF::createSection($prefix, array(
        'title'     =>  __( 'SEO', 'seox' ),
        'fields' => array(
            //
            // A text field
            array(
                'id'    => 'meta-title',
                'type'  => 'text',
                'title' => __('Meta Title', 'seox'),
            ),

            array(
                'id'    => 'meta-description',
                'type'  => 'textarea',
                'title' => __('Meta Description', 'seox'),
            ),

        )
    ));

    //
    // Set a unique slug-like ID
    $prefix = 'seox_metabox_tax';

    // Create taxonomy options
    CSF::createTaxonomyOptions( $prefix, array(
        'title'     => __('SEO X', 'seox'),
        'taxonomy'  => array( 'category', 'product_cat', 'product_tag', 'post_tag' ),
        'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
        'nav'       =>  'inline',
        'theme'     => 'light',
    ) );

    //
    // Create a section
    CSF::createSection($prefix, array(
        'title'     =>  __( 'SEO', 'seox' ),
        'fields' => array(

            // A text field
            array(
                'id'    => 'meta-title',
                'type'  => 'text',
                'title' => __('Meta Title', 'seox'),
            ),
            // textarea
            array(
                'id'    => 'meta-description',
                'type'  => 'textarea',
                'title' => __('Meta Description', 'seox'),
            ),

        )
    ));
}
