<?php
namespace Demo\Test\Admin;

/**
 * The Taxonomy Handale Class
 * 
 * @since 1.0.0
 */
class Taxonomy {
    /**
     * Constructor function
     *
     * @since 1.0.0
     */
    function __construct() {
       add_action( 'init', [ $this, 'books_custom_taxonomy' ] );
    }

    /**
     * Taxonomy Function
     * 
     * @since 1.0.0
     */
    public function books_custom_taxonomy() {
        $labels = [
            'name'              => _x( 'Subjects', 'taxonomy general name' ),
            'singular_name'     => _x( 'Subject', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Subjects' ),
            'all_items'         => __( 'All Subjects' ),
            'parent_item'       => __( 'Parent Subject' ),
            'parent_item_colon' => __( 'Parent Subject: ' ),
            'edit_item'         => __( 'Edit Subject' ), 
            'update_item'       => __( 'Update Subject' ),
            'add_new_item'      => __( 'Add New Subject' ),
            'new_item_name'     => __( 'New Subject Name' ),
            'menu_name'         => __( 'Subjects' ),
        ];    
        register_taxonomy( 'subjects',['book'], [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'subject'],
        ] );
    }
}
