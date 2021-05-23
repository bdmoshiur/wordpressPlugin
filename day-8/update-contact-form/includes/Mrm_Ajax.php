<?php

namespace Formsubmit\Ajax;

/**
 * The main ajax Class
 */
class Mrm_Ajax {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'wp_ajax_from_shortcode', [ $this, 'handled_request' ] );
        add_action( 'wp_ajax_nopriv_from_shortcode', [ $this, 'handled_request' ] );
    }

    /**
     * ajax request handeler function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function handled_request() {
        if ( ! wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'nonce_from_shortcode' ) ) {
            wp_send_json_error( [
                'error' => __( 'Nonce Verification Failed', 'form_submit_ajax' ),
            ] );
        }
        
        if ( empty( $_REQUEST ) ) {
            wp_send_json_error( [
                'error' => __( 'Sorry data can not be empty', 'form_submit_ajax' )
            ] );
        }

        $args = [
            'fname'       => sanitize_text_field( $_REQUEST['fname'] ),
            'lname'       => sanitize_text_field( $_REQUEST['lname'] ),
            'email'      => sanitize_email( $_REQUEST['email'] ),
            'message'    => sanitize_textarea_field( $_REQUEST['message'] ),
        ];
        $inserted = wp_af_insert_address( $args );

        if ( is_wp_error( $inserted ) ) {
            wp_send_json_error( [
                'error' => __( 'Something went wrong', 'form_submit_ajax' )
            ] );
        }

        wp_send_json_success( [
            'message' => __( 'Data save successfuly', 'form_submit_ajax' )
        ] );
    }
}
