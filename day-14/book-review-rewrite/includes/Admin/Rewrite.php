<?php

namespace Book\Review\Rewrite\Admin;

/**
 * The main rewrite class
 */
class Rewrite {

    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'init', [ $this, 'cpt_custom_permalink' ] );

        add_filter( 'query_vars', [ $this, 'query_var_register' ] );

        add_filter( 'template_include', [ $this, 'post_review_display' ] );

        add_filter( 'template_include', [ $this, 'post_review_display_details' ] );
    }

    /**
     * Add custom rewrite roles for book cpt
     * 
     * @return void
     */
    public function cpt_custom_permalink() {
        add_rewrite_rule( 
            'book/rating/view/([0-9]{1,})/?$', 
            'index.php?post_type=book&pagename=view&rating_post_id=$matches[1]', 
            'top' 
        );
        add_rewrite_rule( 
            'book/rating/([0-9]{1,})/?$', 
            'index.php?post_type=book&pagename=rating&paged=$matches[1]', 
            'top' 
        );
    }

    /**
     * Register custom query var
     * 
     * @param array $vars Query vars
     * 
     * @return array
     */
    public function query_var_register( $vars ) {
        $vars[] = 'view';
        $vars[] = 'rating';
        $vars[] = 'rating_post_id';

        return $vars;
    }

    /**
     * Display book review page
     * 
     * @param string $template  Template to display
     * 
     * @return void
     */
    public function post_review_display( $template ) {
        if ( 'rating' === get_query_var( 'pagename' ) ) {
            $current_page = ( ! empty( get_query_var( 'paged' ) ) ) ? get_query_var( 'paged' ) : 1;

            $per_page = 5;

            $args = [
                'number'  => $per_page,
                'offset'  => ( $current_page - 1 ) * $per_page,
                'orderby' => 'id',
                'order'   => 'DESC'
            ];

            $all_ratings = get_all_rating_by_group( $args );

            if ( empty( $all_ratings ) ) {
                return get_404_template();
            }

            $unique_posts = [];

            foreach( $all_ratings as $ratings ) {
                $unique_posts[] = $ratings['post_id'];
            }

            $template = BRR_BOOK_REVIEW_PATH . '/templates/rating-template.php';

            if ( $template ) {
                include $template;
            }
            
            return $template;
        }

        return $template;
    }

    /**
     * Display book review details page
     * 
     * @param string $template  Template to display
     * 
     * @return void
     */
    public function post_review_display_details( $template ) {
        if ( 'view' === get_query_var( 'pagename' )  && get_query_var( 'rating_post_id' ) ) {
            $rating_post_id = get_query_var( 'rating_post_id' );

            if ( empty( $rating_post_id ) ) {
                return get_404_template();
            }

            $all_ratings = get_all_rating_by_post_id( $rating_post_id );

            $template = BRR_BOOK_REVIEW_PATH . '/templates/single-rating-content.php';

            if ( $template ) {
                include $template;
            }

            return $template;
        }

        return $template;
    }
}