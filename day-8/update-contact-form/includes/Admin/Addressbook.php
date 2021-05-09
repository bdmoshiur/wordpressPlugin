<?php
namespace Formsubmit\Ajax\Admin;

/**
 * The main addressbook class
 */
class Addressbook {
    /**
     * Plugin template render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';

        switch ( $action ) {
            case 'edit':
                $template = __DIR__ . '/views/address-edit.php';
                break;
            case 'view':
                $template = __DIR__ . '/views/address-view.php';
                break;
            default:
                $template = __DIR__ . '/views/address-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * User info delete function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function delete_address() {

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-af-delete-address' ) ) {
            wp_die( 'Aru you Cheating nonce' );
        }

        if ( ! current_user_can( 'manage_options') ) {
            wp_die( 'Aru you Cheating not user');
        }

        $id    = isset( $_REQUEST['id'] ) ? sanitize_text_field( $_REQUEST['id'] ) : 0;
        if ( wp_af_delete_address( $id ) ){
            $redirect_to = admin_url( 'admin.php?page=user-information&address_deleted=true' );
        } else{
            $redirect_to = admin_url( 'admin.php?page=user-information&address_deleted=false' );
        }

        wp_redirect( $redirect_to );
    }
}    