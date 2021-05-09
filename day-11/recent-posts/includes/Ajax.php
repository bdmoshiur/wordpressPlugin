<?php
namespace Recent\Posts;

/**
 * Ajax class
 */
class Ajax {
    /**
     * Class constructor
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_ajax_dashboard_form_handle', [ $this, 'form_handle_dashboard_request' ] );
    }

    /**
     * Handle ajax request
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function form_handle_dashboard_request() {
        if ( ! isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( $_REQUEST['nonce'], 'dashboard_form_handle' ) ) {
            wp_send_json_error( [
                'message' => __( 'invalid request', 'recent-posts' )
            ] );
        }

        if ( ! current_user_can( 'edit_dashboard' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry you  not have permission', 'recent-posts' )
            ] );
        }
        
        $options = [];
        parse_str( $_REQUEST['data'], $options );

        if ( isset( $options['mrm_posts_no'] ) ) {
            update_option( 'mrm_posts_no', sanitize_text_field( $options['mrm_posts_no'] ) );
        }

        if ( isset( $options['mrm_order'] ) ) {
            update_option( 'mrm_order', sanitize_text_field( $options['mrm_order'] ) );
        }

        if ( isset( $options['mrm_category_items'] ) ) {
            update_option( 'mrm_category_items', $options['mrm_category_items'] );
        }

        wp_send_json_success();
    }
}