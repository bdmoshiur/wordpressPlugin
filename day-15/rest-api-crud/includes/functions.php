<?php

/**
 * Data insert function
 * 
 * @since 1.0.0
 * 
 * @return int
 */
function wp_ac_insert_address( $args = [] ) {
    global $wpdb;

    if ( empty( $args['name'] )  ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name', 'wedevs-academy' ) );
    }

    $defaults = [
        'name'       => '',
        'address'    => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( $data['id'] ) {
        
        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            "{$wpdb->prefix}ac_address",
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ],
            [ '%d' ]
        );

        return $updated;
    } else {

        $inserted = $wpdb->insert(
            "{$wpdb->prefix}ac_address",
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ]
        );

        if ( ! $inserted  ) {
            return new \WP_Error( 'fail-to-insert', __( 'Fail to insert data', 'wedevs-academy' ) );
        }

        return $wpdb->insert_id;
    }
}

/**
 * Data get function
 * 
 * @since 1.0.0
 * 
 * @return object
 */
function wp_ac_get_address( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];
    $args = wp_parse_args( $args, $defaults );
    $sql = $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}ac_address
        ORDER BY {$args['orderby']} {$args['order']}
        LIMIT %d, %d",
        $args['offset'], $args['number']
        );

    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Data count function
 * 
 * @since 1.0.0
 * 
 * @return int
 */
function wp_ac_count_address() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}ac_address" );
}

/**
 * Data edit function
 * 
 * @since 1.0.0
 * 
 * @return int
 */
function wp_ac_edit_address( $id ) {
    global $wpdb;
    
    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ac_address WHERE id= %d",  $id
        )
    );
}

/**
 * Data delete function
 * 
 * @since 1.0.0
 * 
 * @return int
 */
function wp_ac_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'ac_address',
        [ 'id' => $id ],
        [ '%d' ]
    );
}

