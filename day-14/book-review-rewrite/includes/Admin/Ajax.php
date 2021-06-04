<?php

namespace Book\Review\Rewrite\Admin;

/**
 * All assets handler class
 */
class Ajax {

    /**
     * Constructor function
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'wp_ajax_nbr-book-rating', [ $this, 'book_rating_request_handler' ] );
        add_action( 'wp_ajax_nopriv_nbr-book-rating', [ $this, 'book_rating_frontend_handler' ] );
    }

    /**
     * Book rating request handler function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function book_rating_request_handler() {
        if ( ! wp_verify_nonce( $_REQUEST['_ajax_nonce'], 'book-review-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'verification nonce failed!', 'nbr-book-review' ),
            ] );
        }

        if ( ! isset( $_REQUEST['rating'] ) ) {
            wp_send_json_error( [
                'message' => __( 'Rating can not be empty!', 'nbr-book-review' ),
            ] );
        }

        if ( ! isset( $_REQUEST['post_id'] ) ) {
            wp_send_json_error( [
                'message' => __( 'Post id can not be empty!', 'nbr-book-review' ),
            ] );
        }

        $args = [
            'post_id' => $_REQUEST['post_id'],
            'rating'  => $_REQUEST['rating'],
        ];

        if ( '' !== $_REQUEST['rating_id'] ) {
            $args['id'] = $_REQUEST['rating_id'];

            nbr_update_rating( $args );
            wp_send_json_success( [
                'message' => __( 'Book rating updated successfully!', 'nbr-book-review' ),
            ] );
        } else {
            $insert_id = nbr_insert_rating( $args );

            wp_send_json_success( [
                'message' => __( 'Your rating added successfully!', 'nbr-book-review' ),
                'rating_id' => $insert_id,
            ] );
        }

        wp_send_json_error( [
            'message' => __(  'Your request failed!', 'nbr-book-review' ),
        ] );
    }

    /**
     * Book rating frontend handler function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function book_rating_frontend_handler() {
        wp_send_json_error( [
            'message' => __( 'Please first login then give to rating!', 'nbr-book-review' ),
        ] );
    }
}
