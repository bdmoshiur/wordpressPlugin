<?php

/**
 * Insert a new address
 * 
 * @since 1.0.0
 * 
 * @param array $args
 * 
 * @return int/Wp_Error
 */
function wp_fp_insert_address( $args = [] ) {
    global $wpdb;

    if ( empty( $args[ 'name' ] ) ) {

        return New \WP_Error( 'no-name', __( 'You must provide a Name', 'we-crud') );
    }
    $defaults = [
        'name'       => '',
        'address'    => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];
    $data     = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {

        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            "{$wpdb->prefix}fp_addresses",
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
            "{$wpdb->prefix}fp_addresses",
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ]
        );

        if ( ! $inserted ) {
            return  new \WP_Error( 'failed-to-insert', __( 'Fail to Insert Data', 'we-crud' ) );
        }

        return $wpdb->insert_id;
    }
}

/**
 * Fatch Address
 * 
 * 
 * @since 1.0.0
 * 
 * @param array $args
 * 
 * @return array
 */
function wp_fp_get_address( $args = [] ) {
    global $wpdb;
    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC',
    ];
    $args  = wp_parse_args( $args, $defaults );
    $sql   = $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}fp_addresses ORDER BY {$args['orderby']} {$args['order']} LIMIT %d, %d",
         $args['offset'], $args['number']
    );
    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Get the  count of total Address
 * 
 * @since 1.0.0
 * 
 * @return int
 */
function wp_fp_count_address() {
     global $wpdb;

     return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}fp_addresses" );
}

/**
 * Edit Address function
 * 
 * @since 1.0.0
 * 
 * @param int $id
 * 
 * @return array
 */
function wp_fp_edit_address( $id ) {
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}fp_addresses WHERE id = %d", $id )
    );
}

/**
 * Delete address function
 * 
 * @since 1.0.0
 * 
 * @param int $id
 * 
 * @return array
 */
function wp_fp_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'fp_addresses',
        ['id' => $id ],
        [ '%d' ]
    );
}