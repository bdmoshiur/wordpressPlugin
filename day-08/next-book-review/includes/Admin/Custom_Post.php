<?php

namespace Nbr\Book\Review\Admin;

/**
 * Handler the custom post class
 */
class Custom_Post {

    /**
     * Class constructor function
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'init', [ $this, 'custom_post_book' ] );
    }

    /**
     * Custom post book function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function custom_post_book() {
        $labels = [
            'name'               => _x( 'Books', 'post type general name', 'nbr-book-review' ),
            'singular_name'      => _x( 'Book', 'post type singular name', 'nbr-book-review' ),
            'add_new'            => __( 'Add New', 'book', 'nbr-book-review' ),
            'add_new_item'       => __( 'Add New Book', 'nbr-book-review' ),
            'edit_item'          => __( 'Edit Book', 'nbr-book-review' ),
            'new_item'           => __( 'New Book', 'nbr-book-review' ),
            'all_items'          => __( 'All Books', 'nbr-book-review' ),
            'view_item'          => __( 'View Book', 'nbr-book-review' ),
            'search_items'       => __( 'Search Books', 'nbr-book-review' ),
            'not_found'          => __( 'No books found', 'nbr-book-review' ),
            'not_found_in_trash' => __( 'No books found in the Trash', 'nbr-book-review' ),
            'menu_name'          => __( 'Books', 'nbr-book-review' ),
        ];

        /**
         * Arguments array for custom post type
         * 
         * @since 1.0.0
         */
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'book' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
            'taxonomies'         => [ 'category' ],
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-book',
        ];

        /**
         * Register post type book
         * 
         * @since 1.0.0
         */
        register_post_type( 'book', $args );
    }
}
