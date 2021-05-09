<?php

/**
 * Data inset function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
function wp_af_insert_address( $args = [] ) {
    global $wpdb;

    if ( empty( $args['fname'] ) ){
        return new \WP_Error( 'no-name', __( 'You must provide a first name', 'form_submit_ajax' ) );
    }

    $defaults = [
        'fname'       => '',
        'lname'       => '',
        'email'      => '',
        'message'    => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}af_address",
        $data,
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
        ]
    );

    if ( ! $inserted  ) {
        return new \WP_Error( 'fail-to-insert', __( 'Fail to insert data', 'form_submit_ajax' ) );
    }

    return $wpdb->insert_id;
}

/**
 * Data fatch function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
function wp_af_get_address( $args = [] ) {
    global $wpdb;
    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];
    $args = wp_parse_args( $args, $defaults );
    $sql = $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}af_address
        ORDER BY {$args['orderby']} {$args['order']}
        LIMIT %d, %d",
        $args['offset'], $args['number']
        );
    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Row count function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
function wp_af_count_address() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}af_address" );
}

/**
 * Data Delete Function
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function wp_af_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'af_address',
        [ 'id' => $id ],
        [ '%d' ]
    );
}

