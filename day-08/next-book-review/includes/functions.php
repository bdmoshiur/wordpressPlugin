<?php
/**
 * Get the User IP function
 *
 * @since 1.0.0
 *
 * @return string
 */
function nbr_get_the_user_ip() {
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
function nbr_insert_rating( $args = [] ) {
    global $wpdb;

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'nbr-book-review' ) );
    }

    $defaults = [
        'post_id'    => '',
        'user_id'    => get_current_user_id(),
        'ip'         => nbr_get_the_user_ip(),
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
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'nbr-book-review' ) );
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
function nbr_update_rating( $args = [] ) {
    global $wpdb;

    $id = $args['id'];

    if ( '' === $id ) {
        return new \WP_Error( 'no-rating-id', __( 'Rating ID must not be empty', 'nbr-book-review' ) );
    }

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'nbr-book-review' ) );
    }

    $defaults = [
        'ip'         => nbr_get_the_user_ip(),
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
        return new \WP_Error( 'failed-to-update', __( 'Failed to update data', 'nbr-book-review' ) );
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
function nbr_get_rating( $args = [] ) {
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
