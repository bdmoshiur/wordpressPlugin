<?php
namespace Subscription\Form;

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
        if ( ! wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'from_nonce_shortcode' ) ) {
            wp_send_json_error( [
                'error' => __( 'Nonce Verification Failed', 'my-subscription-form' ),
            ] );
        }

        if ( empty( $_REQUEST['email'] ) ) {
            wp_send_json_error( [
                'error' => __( 'Sorry Email can not be empty', 'my-subscription-form' )
            ] );
        }

        $email   = isset( $_REQUEST['email'] ) ? $_REQUEST['email']    : '' ;
        $list_id = isset( $_REQUEST['list_id'] ) ? $_REQUEST['list_id']: '' ;
        $api_key = get_option( 'mailchimp_link' );
        $status  = 'subscribed';
        
        $args = array(
            'method'  => 'POST',
            'headers' => array(
                'Authorization' => "apikey $api_key",
                'Content-Type' => "application/json;charset=utf-8",
            ),
            'body' => json_encode( array(
                'email_address' => $email,
                'status'        => $status
            ) )
        );

        $response = wp_remote_post( 'https: //' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/', $args );
        $body     = json_decode( $response['body'] );
        
        if ( $response['response']['code'] == 200 && $body->status == $status ) {
            echo 'The user has been successfully ' . $status . '.';
        } else {
            echo '<b>' . $response['response']['code'] . $body->title . ':</b> ' . $body->detail;
        }
        
        die();
    }
}
