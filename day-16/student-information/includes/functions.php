<?php
/**
 * Insert student info function
 *
 * @since 1.0.0
 * 
 * @param array $args
 * 
 * @return int
 */
function insert_student_info( $args = [] ) {
    global $wpdb;
    
    $defaults = [
        'first_name' => '',
        'last_name'  => '',
        'class'      => '',
        'roll'       => '',
        'reg_no'     => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];
    
    $data = wp_parse_args( $args, $defaults );

        $inserted = $wpdb->insert( 
            "{$wpdb->prefix}students",
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ]
        );

        if ( ! $inserted ) {
            return  new \WP_Error( 'failed-to-insert', __( 'Fail to Insert Data', 'student-info' ) );
        }

    return $wpdb->insert_id;
}

/**
 * Student count function
 *
 * @since 1.0.0
 * 
 * @return void
 */
function si_student_count() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}students" );
}

/**
 * student info get function
 * 
 * @since 1.0.0
 * 
 * @param array $args
 * 
 * @return object
 */
function si_get_student_info( $args = [] ) {
    global $wpdb;
    
    $defaults = [
        'paged'  => 5,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC',
    ];
    $args  = wp_parse_args( $args, $defaults );
    
    $sql   = $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}students, {$wpdb->prefix}studentmeta WHERE {$wpdb->prefix}students.id = {$wpdb->prefix}studentmeta .student_id ORDER BY {$args['orderby']} {$args['order']} LIMIT %d, %d",
        $args['offset'], $args['paged']
    );
    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Student info metadata function
 * 
 * @since 1.0.0
 */
function add_student_meta( $student_id, $meta_key, $meta_value, $unique = false ) {
    return add_metadata( 'student', $student_id, $meta_key, $meta_value, $unique );
}

function get_student_meta( $student_id, $meta_key = '', $single = false ) {
    return get_metadata( 'student', $student_id, $meta_key, $single );
}

function update_student_meta( $student_id, $meta_key, $meta_value, $prev_value = '' ) {
    return update_metadata( 'student', $student_id, $meta_key, $meta_value, $prev_value );
}

function delete_student_meta( $student_id, $meta_key, $meta_value = '', $delete_all = false ) {
    return delete_metadata( 'student', $student_id, $meta_key, $meta_value, $delete_all );
}