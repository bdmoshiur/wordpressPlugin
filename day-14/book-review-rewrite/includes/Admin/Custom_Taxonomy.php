<?php

namespace Book\Review\Rewrite\Admin;

/**
 * Handle the custom texonomy class
 */
class Custom_Taxonomy {

    /**
     * Initialize the class
     *
     * @since  1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'init', [ $this, 'custom_taxonomy_genre' ] );
    }

    /**
     * Custom taxonomy function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function custom_taxonomy_genre() {
        /**
         * Labels array for custom taxonomy
         * 
         * @since 1.0.0
         */
        $labels = [
            'name'              => _x( 'Genres', 'taxonomy general name', 'nbr-book-review' ),
            'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'nbr-book-review' ),
            'search_items'      => __( 'Search Genres', 'nbr-book-review' ),
            'all_items'         => __( 'All Genres', 'nbr-book-review' ),
            'parent_item'       => __( 'Parent Genre', 'nbr-book-review' ),
            'parent_item_colon' => __( 'Parent Genre:', 'nbr-book-review' ),
            'edit_item'         => __( 'Edit Genre', 'nbr-book-review' ),
            'update_item'       => __( 'Update Genre', 'nbr-book-review' ),
            'add_new_item'      => __( 'Add New Genre', 'nbr-book-review' ),
            'new_item_name'     => __( 'New Genre Name', 'nbr-book-review' ),
            'menu_name'         => __( 'Genre', 'nbr-book-review' ),
        ];

        /**
         * Arguments array for custom taxonomy
         * 
         * @since 1.0.0
         */
        $args = [
            'labels'            => $labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'genre' ),
        ];

        /**
         * Register custom taxonomy
         * 
         * @since 1.0.0
         */
        register_taxonomy( 'genre', array( 'book' ), $args );
    }
}
