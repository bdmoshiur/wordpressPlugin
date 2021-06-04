<?php

namespace Ubrp\Book\Review\Admin;

/**
 * The Shortcode Handale Class
 * 
 * @since 1.0.0
 */
class Shortcode {

    /**
     * Constructor function
     *
     * @since 1.0.0
     * 
     * @return  void
     */
    public function __construct() {
        add_shortcode( 'edit_book_search', [ $this, 'search_book_reviews' ] );
    }

    /**
     *  Book search function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function search_book_reviews( ) {
        ob_start();
        ?>
            <form  method="post">
                <input type="text" value="" name="book_search" />
                <input type="submit" name="btn_search" value="<?php esc_attr_e( 'Search', 'edit-book-reviews' ) ?>" />
            </form>
        <?php
        $data = ob_get_clean();
        echo $data;
        $search_value = '';

        if ( isset( $_POST['btn_search'] ) ) {
            
            $search_value = ( $_POST['book_search'] ) ? $_POST['book_search'] : '';
            $args = [
                'post_type'  => 'book',
                'post_status' => 'publish',
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key'     => 'br_book_name',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => 'br_book_date',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => 'br_book_code',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => 'br_book_author_name',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => 'br_book_email',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => 'br_book_address',
                        'value'   => $search_value,
                        'compare' => 'LIKE',
                    ],
                ],
            ];
            $query = new \WP_Query( $args ); 
            echo '<ol>';

             while ( $query->have_posts() ) {
                $query->the_post();
                $title      = get_the_title();
                $excerpt    = get_the_excerpt();
                $purma_link = get_the_permalink();
                $image      = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
                printf( '<li><img src="%s" width="150px" height="150px" >',  $image );
                printf( '<p> %s <a href="%s">Read More</a> </p>', $title, $purma_link );
                printf( '<p> %s </p></li>', $excerpt );
            }

            echo '</ol>';

            wp_reset_postdata();
        }
    }
}
