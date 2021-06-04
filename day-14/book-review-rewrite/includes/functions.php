<?php
/**
 * Get the User IP function
 *
 * @since 1.0.0
 *
 * @return string
 */
function nrr_get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

        $ip = $_SERVER['HTTP_CLIENT_IP'];

    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

    } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {

        $ip = $_SERVER['REMOTE_ADDR'];

    } else {

        $ip = 'UNKNOWN';

    }

    return $ip;
}

/**
 * Inserter the rating  function
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function nrr_insert_rating( $args = [] ) {
    global $wpdb;

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'nrr-book-review' ) );
    }

    $defaults = [
        'post_id'    => '',
        'user_id'    => get_current_user_id(),
        'ip'         => nrr_get_the_user_ip(),
        'rating'     => '',
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'wedevs_book_review_rating',
        $data,
        [
            '%d',
            '%d',
            '%s',
            '%f',
            '%s',
        ]
    );

    if ( ! $inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'nrr-book-review' ) );
    }

    return $wpdb->insert_id;
}


/**
 * Rating updater function
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function nrr_update_rating( $args = [] ) {
    global $wpdb;

    $id = $args['id'];

    if ( '' === $id ) {
        return new \WP_Error( 'no-rating-id', __( 'Rating ID must not be empty', 'nrr-book-review' ) );
    }

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'nrr-book-review' ) );
    }

    $defaults = [
        'ip'         => nrr_get_the_user_ip(),
        'rating'     => '',
        'updated_at' => current_time( 'mysql' ),
    ];

    unset( $args['id'] );
    unset( $args['post_id'] );

    $data = wp_parse_args( $args, $defaults );

    $updated = $wpdb->update(
        $wpdb->prefix . 'wedevs_book_review_rating',
        $data,
        [ 'id' => $id ],
        [
            '%s',
            '%f',
            '%s',
        ],
        [ '%d' ]
    );

    if ( ! $updated ) {
        return new \WP_Error( 'failed-to-update', __( 'Failed to update data', 'nrr-book-review' ) );
    }
}

/**
 * Rating getter function
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return object
 */
function nrr_get_rating( $args = [] ) {
    global $wpdb;

    $defaults = [
        'post_id' => '',
        'user_id' => get_current_user_id(),
    ];

    $args = wp_parse_args( $args, $defaults );

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wedevs_book_review_rating WHERE post_id = %d AND user_id = %d", $args['post_id'], $args['user_id'] )
    );
}

/**
 * Fetch Ratings by post id group by post_id
 *
 * @param  int  $post_id
 *
 * @return array
 */
function get_all_rating_by_group( $args = [] ) {
    global $wpdb;

    if ( ! isset( $args['post_id'] ) && empty( $args['post_id'] ) ) {
        $defaults = [
            'number'  => 10,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
        ];

        $args = wp_parse_args( $args, $defaults );

        $sql = $wpdb->prepare(
            "SELECT DISTINCT (post_id) FROM {$wpdb->prefix}wedevs_book_review_rating
             ORDER BY {$args['orderby']} {$args['order']} 
             LIMIT %d, %d",
             $args['offset'], $args['number']
        );

        $items = $wpdb->get_results( $sql, ARRAY_A );

        return $items;
    }

    $defaults = [
        'number'  => 2,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC',
        'post_id' => 0
    ];

    $args = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}wedevs_book_review_rating
            WHERE post_id = %d
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $$args['post_id'],
            $args['offset'], $args['number']
    );

    $items = $wpdb->get_results( $sql, ARRAY_A );

    return $items;
}

/**
 * Fetch Ratings by post id
 *
 * @param  int  $post_id
 *
 * @return array
 */
function get_all_rating_by_post_id( $post_id ) {
    global $wpdb;

    $args = [
        'number'  => 10,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC'
    ];

    $sql = $wpdb->prepare(
            "SELECT avg(rating) FROM {$wpdb->prefix}wedevs_book_review_rating
            WHERE post_id = %d",
            $post_id
    );

    $avg = $wpdb->get_var( $sql );

    return round($avg, 2);
}
