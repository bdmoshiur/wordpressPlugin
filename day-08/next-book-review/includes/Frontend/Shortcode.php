<?php

namespace Nbr\Book\Review\Frontend;

/**
 * Handle the shortcode class
 */
class Shortcode {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_shortcode( 'nbr_book_search', [ $this, 'render_shortcode_form' ] );
    }

    /**
     * Shortcode renderer function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function render_shortcode_form() {
        ob_start();
        require_once NBR_BOOK_REVIEW_PATH . "/templates/shortcode_search_form.php";
        echo ob_get_clean();

        $this->post_meta_search_handler();
    }

    /**
     * Post meta search handler function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function post_meta_search_handler() {
        if ( ! isset( $_REQUEST['book-post-meta-search'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'book-review-search' ) ) {
            wp_die( 'Nonce verification failed!' );
        }

        if ( ! isset( $_REQUEST['keyword'] ) ) {
            return;
        }

        $search_keyword = $_REQUEST['keyword'];

        $book_meta_query_args =  array(
            'post_type'   => 'book',
            'post_status' => 'publish',
            'meta_query'  => array(
                'relation' => 'OR',
                array(
                    'key'     => 'book_meta_key_name',
                    'value'   => $search_keyword,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => 'book_meta_key_date',
                    'value'   => $search_keyword,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => 'book_meta_key_code',
                    'value'   => $search_keyword,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => 'book_meta_key_price',
                    'value'   => $search_keyword,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => 'book_meta_key_description',
                    'value'   => $search_keyword,
                    'compare' => 'LIKE',
                ),
            ),
        );

        $this->post_meta_query_handler( $book_meta_query_args );
    }

    /**
     * Post meta query handler function
     *
     * @since 1.0.0
     *
     * @param array $query_args
     *
     * @return void
     */
    public function post_meta_query_handler( $query_args) {
        $book_meta_query = new \WP_Query( $query_args );

        if ( $book_meta_query->have_posts() ) {
            $posts = $book_meta_query->posts;

            foreach( $posts as $post ) {
                ob_start();
                include NBR_BOOK_REVIEW_PATH . "/templates/shortcode_search_result_viewer.php";
                echo ob_get_clean();
            }
            
        } else {
            echo __( 'No book review matched!', 'nbr-book-review' );
        }
    }
}
