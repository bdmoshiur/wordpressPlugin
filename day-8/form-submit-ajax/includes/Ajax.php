<?php
namespace Formsubmit\Ajax;

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
        $form_data = json_encode( $_REQUEST );

        if ( ! wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'nonce_from_shortcode' ) ) {
            wp_send_json_error( [
                'error' => 'Nonce Verification Failed',
            ] );
        }
        wp_send_json_success( [
            'message' => 'Data Submit Successfully',
            'form_data' => $form_data,
        ] );

        wp_send_json_error( [
            'error' => 'something went worng',
        ] );
    }
}
