<?php
/**
 * Data inset function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
if ( ! function_exists( 'coupon_conversion_insert' ) ) {

    function coupon_conversion_insert( $args = [] ) {
        global $wpdb;

        $defaults = [
            'amount' => '',
            'point'  => '',
            'expiry_date'  => current_time( 'mysql' ),
        ];

        $data = wp_parse_args( $args, $defaults );

        $inserted = $wpdb->insert(
            "{$wpdb->prefix}woo_coupon_conversion",
            $data,
            [
                '%d',
                '%d',
                '%s',
            ]
        );

        if ( ! $inserted  ) {
            return new \WP_Error( 'fail-to-insert', __( 'Fail to insert data', 'woo-referral' ) );
        }

        return $wpdb->insert_id;
    }
}

/**
 * Data fatch function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
if ( ! function_exists( 'woo_referral_coupon_codes' ) ) {

    function woo_referral_coupon_codes( $args = [] ) {
        global $wpdb;

        $defaults = [
            'number' => 20,
            'offset' => 0,
            'orderby' => 'id',
            'order' => 'ASC',
        ];
        $args = wp_parse_args( $args, $defaults );
        $sql  = $wpdb->prepare(
            "SELECT DISTINCT ccode FROM {$wpdb->prefix}woo_referrals
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
            );
        $items = $wpdb->get_results( $sql, ARRAY_A );

        $coupon_codes = [];
        
        foreach ( $items as $item ) {
            $coupon_codes[] = $item['ccode'];
        }

        return $coupon_codes;
    }
}

/**
 * Data fatch function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
if ( ! function_exists( 'woo_coupon_conversion' ) ) {

    function woo_coupon_conversion( $args = [] ) {
        global $wpdb;

        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'ASC',
        ];
        $args = wp_parse_args( $args, $defaults );
        $sql  = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}woo_coupon_conversion
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
            );
        $items = $wpdb->get_results( $sql );

        return $items;
    }
}

/**
 * get_referral_coupons function
 * 
 * @since 1.0.0
 * 
 * @return integer
 */
if ( ! function_exists( 'get_referral_coupons' ) ) {

    function get_referral_coupons( $user_id = '' ) {
        
        if ( $user_id == '' ) {
            $user_id = get_current_user_id();
        }

        global $wpdb;

        $sql     = $wpdb->prepare( "SELECT coupon_code FROM {$wpdb->prefix}woo_visits WHERE user_id = %d", $user_id );
        $coupons = $wpdb->get_results( $sql, ARRAY_A );

        return $coupons;
    }
}

if ( ! function_exists( 'get_generate_coupons' ) ) {

    function get_generate_coupons( $user_id = '' ) {

        if ( $user_id == '' ) {
            $user_id = get_current_user_id();
        }

        global $wpdb;

        $sql     = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}woo_generate_coupon WHERE user_id = %d", $user_id );
        $coupons = $wpdb->get_results( $sql );

        return $coupons;
    }
}

if ( ! function_exists( 'get_woo_transition' ) ) {

    function get_woo_transition( $user_id = '' ) {

        if ( $user_id == '' ) {
            $user_id = get_current_user_id();
        }

        global $wpdb;

        $sql     = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}woo_transition WHERE user_id = %d", $user_id );
        $coupons = $wpdb->get_results( $sql );

        return $coupons;
    }
}