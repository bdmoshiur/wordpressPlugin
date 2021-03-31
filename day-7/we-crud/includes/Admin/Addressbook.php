<?php
namespace We\Crud\Admin;
use We\Crud\Traits\Form_Error;

/**
 * Addressbook class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Addressbook {

    /**
     * From Error traits use
     */
    use Form_Error;

    /**
     * Plugin Page handaler 
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function plugin_page() {
        /**
         * Check action then template set
         * 
         * @since 1.0.0
         */
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/address-new.php';
                break;

            case 'edit':
                $address = wp_fp_edit_address( $id );
                $template = __DIR__ . '/views/address-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/address-view.php';
                break;

            default:
            $template = __DIR__ . '/views/address-list.php';
                break;
        }

        /**
         * Template loaded
         * 
         * @since 1.0.0
         */
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Form_handler function
     * 
     * @since 1.0.0
     * 
     * @return mixed
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_address'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-addrss' ) ) {
            wp_die( 'Are you Cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you Cheating?' );
        }
        $id      = isset( $_POST[ 'id' ] ) ? intval( $_POST[ 'id' ] )                           : 0 ;
        $name    = isset( $_POST[ 'name' ] ) ? sanitize_text_field( $_POST[ 'name' ] )          : '' ;
        $address = isset( $_POST[ 'address' ] ) ? sanitize_textarea_field( $_POST[ 'address' ] ): '' ;
        $phone   = isset( $_POST[ 'phone' ] ) ? sanitize_text_field( $_POST[ 'phone' ] )        : '' ;

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a Name', 'we-crud' );
        }

        if ( empty( $phone ) ) {
            $this->errors['phone'] = __( 'Please provide a phone number', 'we-crud' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'name'    => $name,
            'address' => $address,
            'phone'   => $phone,
        ];

        if( $id ) {
            $args['id'] = $id;
        }
        $inser_id = wp_fp_insert_address( $args );

        if ( is_wp_error( $inser_id ) ) {
            wp_die( $inser_id->get_error_message() );
        }

        if( $id ) {
            $redirect_to  = admin_url( 'admin.php?page=we-crud&action=edit&address-updated=true&id=' . $id );
        } else {
            $redirect_to  = admin_url( 'admin.php?page=we-crud&inserted=true' );
        }

        wp_redirect( $redirect_to );
        exit;
    }

    /**
     * Address delete function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function delete_address() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-fp-delete-address' ) ) {
            wp_die( 'Are you Cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you Cheating?' );
        }

        $id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST[ 'id' ] ) : 0 ;
        
        if( wp_fp_delete_address( $id ) ) {
            $redirect_to  = admin_url( 'admin.php?page=we-crud&address-deleted=true' );
        } else {
            $redirect_to  = admin_url( 'admin.php?page=we-crud&address-deleted=false' );
        }

        wp_redirect( $redirect_to );
        exit;
    }
}
