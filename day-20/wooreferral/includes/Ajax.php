<?php

namespace Woo\Referral;

/**
 * The main ajax Class
 */
class Ajax {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'wp_ajax_coupon-create', [ $this, 'coupon_create' ] );
        add_action( 'wp_ajax_coupon-conversion', [ $this, 'coupon_conversion' ] );
        add_action( 'wp_ajax_coupon-generate', [ $this, 'coupon_generate' ] );
    }

    /**
     * coupon_create function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function coupon_create() {
        $response = [];

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'woo-referral' ) ) {
            $response['status']  = 0;
            $response['message'] = __( 'Unauthorized!', 'woo-referral' );
            wp_send_json( $response );
        }

        $ename         = isset( $_POST['ename'] ) ? sanitize_text_field( $_POST['ename'] )            : '';
        $ccode         = isset( $_POST['ccode'] ) ? sanitize_text_field( $_POST['ccode'] )            : '';
        $camount       = isset( $_POST['camount'] ) ? sanitize_text_field( $_POST['camount'] )        : '';
        $cpoint        = isset( $_POST['cpoint'] ) ? sanitize_text_field( $_POST['cpoint'] )          : '';
        $ulimit        = isset( $_POST['ulimit'] ) ? sanitize_text_field( $_POST['ulimit'] )          : '';
        $edate         = isset( $_POST['edate'] ) ? sanitize_text_field( $_POST['edate'] )            : '';
        $mimspend      = isset( $_POST['mimspend'] ) ? sanitize_text_field( $_POST['mimspend'] )      : '';
        $maxspend      = isset( $_POST['maxspend'] ) ? sanitize_text_field( $_POST['maxspend'] )      : '';
        $description   = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ): '';
        $discount_type = 'fixed_cart';
        global $current_user;
        $id = $current_user->ID;

        if ( empty( $ename ) || empty( $ccode ) || empty( $camount ) || empty( $cpoint ) ) {
            $response['message'] = __( 'The field required', 'woo-referral' );
            $response['status']  = 0;
            wp_send_json( $response );
        }

        if ( in_array( $ccode, woo_referral_coupon_codes() ) ) {
            $response['message'] = __( 'Coupon code already exists', 'woo-referral' );
            $response['status']  = 0;
            wp_send_json( $response );
        }

                            
        $coupon = array(
            'post_title'   => $ccode,
            'post_excerpt' => $description,
            'post_status'  => 'publish',
            'post_author'  => $id,
            'post_type'	   => 'shop_coupon'
        );
                            
        $new_coupon_id = wp_insert_post( $coupon );
                            
        // Add meta
        update_post_meta( $new_coupon_id, 'ename', $ename );
        update_post_meta( $new_coupon_id, 'cpoint', $cpoint );
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $camount );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', $ulimit );
        update_post_meta( $new_coupon_id, 'date_expires', $edate );
        update_post_meta( $new_coupon_id, 'mimspend', $mimspend );
        update_post_meta( $new_coupon_id, 'maxspend', $maxspend );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

        if ( is_wp_error( $new_coupon_id ) ) {
            $response['message'] = $new_coupon_id->get_error_message();
            $response['status']  = 0;
            wp_send_json( $_POST );
        }
        
        $response['message'] = __( 'Coupon create Successfully!', 'woo-referral' );
        $response['status']  = 1;
        wp_send_json( $response );
    }

    /**
     * ajax request handeler function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function coupon_conversion() {
        $response = [];

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'woo-referral' ) ) {
            $response['status']  = 0;
            $response['message'] = __( 'Unauthorized!', 'woo-referral' );
            wp_send_json( $response );
        }

        $amount      = isset( $_POST['amount'] ) ? sanitize_text_field( $_POST['amount'] )          : '';
        $point       = isset( $_POST['point'] ) ? sanitize_text_field( $_POST['point'] )            : '';
        $expiry_date = isset( $_POST['expiry_date'] ) ? sanitize_text_field( $_POST['expiry_date'] ): '';

        if ( empty( $amount ) || empty( $point ) ) {
            $response['message'] = __( 'The field required', 'woo-referral' );
            $response['status']  = 0;
            wp_send_json( $response );
        }

        $args = [
            'amount'      => $amount,
            'point'       => $point,
            'expiry_date' => $expiry_date,
        ];

        $insert_id = coupon_conversion_insert( $args );

        if ( is_wp_error( $insert_id ) ) {
            $response['message'] = $insert_id->get_error_message();
            $response['status']  = 0;
            wp_send_json( $_POST );
        }
        
        $response['message'] = __( 'Add new Conversion', 'woo-referral' );
        $response['status']  = 1;
        wp_send_json( $response );
    }

    /**
     * ajax request handeler function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function coupon_generate() {
        $response = [];

        if ( ! wp_verify_nonce( $_POST['nonce'], 'woo-referral' ) ) {
            $response['status']  = 0;
            $response['message'] = __( 'Unauthorized!', 'woo-referral' );
            wp_send_json( $response );
        }

        extract( $_POST );

        global $wpdb;

        $characters  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomized  = str_shuffle( $characters );
        $coupon_code = substr( $randomized, 0, 5);
        $user_id     = get_current_user_id();

        $wpdb->insert(
            $wpdb->prefix . 'woo_generate_coupon',
            [
                'user_id'       => $user_id,
                'amount'        => $amount,
                'point'         => $point,
                'coupon_code'   => $coupon_code,
                'purchase_date' => time(),
                'expiry_date'   => $expiry_date
            ],
            [
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%d',
            ]
        );

        $wpdb->insert(
            $wpdb->prefix . 'woo_transition',
            [
                'event_name'  => __( 'Topup', 'woo-referral' ),
                'coupon_code' => $coupon_code,
                'user_id'     => $user_id,
                'point'       => -$point,
                'type'        => __( 'Coupon Purchase', 'woo-referral' ),
                'time'        => time(),
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
            ]
        );
        
        $response['message'] = __( 'Generate coupon Successfully!', 'woo-referral' );
        $response['status']  = 1;
        wp_send_json( $response );
    }
}
