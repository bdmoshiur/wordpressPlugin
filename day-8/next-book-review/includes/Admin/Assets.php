<?php

namespace Nbr\Book\Review\Admin;

/**
 * Handle the assets class
 */
class Assets {

    /**
     * Constructor function
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All Scripts getter function
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'nbr-rating-plugin-script' => [
                'src'       => NBR_BOOK_REVIEW_ASSETS . '/js/rater.min.js',
                'version'   => filemtime( NBR_BOOK_REVIEW_PATH . '/assets/js/rater.min.js' ),
                'deps'      => [ 'jquery' ],
                'in_footer' => true,
            ],
            'nbr-rating-handler-script' => [
                'src'       => NBR_BOOK_REVIEW_ASSETS . '/js/rating-handler.js',
                'version'   => filemtime( NBR_BOOK_REVIEW_PATH . '/assets/js/rating-handler.js' ),
                'deps'      => [ 'jquery' ],
                'in_footer' => true,
            ],
        ];
    }

    /**
     * All styles getter function
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_styles() {
        return [
            'nbr-book-review-style' => [
                'src'     => NBR_BOOK_REVIEW_ASSETS . '/css/book-review.css',
                'version' => filemtime( NBR_BOOK_REVIEW_PATH . '/assets/css/book-review.css' ),
            ],
        ];
    }

    /**
     * All assets register function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : [];
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            
            wp_register_script( $handle, $script['src'], $deps, $script['version'], $in_footer);
        }

        foreach ($styles as $handle => $style) {
            $deps  = isset( $style['deps'] ) ? $style['deps'] : [];
            $media = isset( $style['media'] ) ? $style['media'] : 'all';

            wp_register_style( $handle, $style['src'], $deps, $style['version'], $media );
        }

        wp_localize_script( 'nbr-rating-handler-script', 'objRating', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'book-review-nonce' ),
            'action'  => 'nbr-book-rating',
            'error'   => __( 'Something went wrong!', 'nbr-book-review' ),
        ] );
    }
}
