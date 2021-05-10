<?php
namespace Wedevs\Academy\Admin;
use Wedevs\Academy\Traits\Form_Error;

/**
 * The main class of address book
 */
class Addressbook {

    use Form_Error;

    /**
     * Plugin Page load function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function plugin_page() {

        $action = isset( $_GET['action'] ) ? $_GET['action']: 'list';
        $id     = isset( $_GET['id'] ) ? $_GET['id']        : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/address-new.php';
                break;
            case 'edit':
                $address = wp_ac_edit_address( $id );
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
     * Form handler function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function form_handler() {
        
        if ( ! isset( $_POST['submit_address'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-address' ) ) {
            wp_die( 'Aru you Cheating nonce' );
        }

        if ( ! current_user_can( 'manage_options') ) {
            wp_die( 'Aru you Cheating not user');
        }

        $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] )          : '';
        $address = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] ): '';
        $phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] )        : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a name', 'wedevs-academy' );
        }
        if ( empty( $address ) ) {
            $this->errors['address'] = __( 'Please provide a address', 'wedevs-academy' );
        }
        if ( empty( $phone ) ) {
            $this->errors['phone'] = __( 'Please provide a phone no', 'wedevs-academy' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }


        $insert_id = wp_ac_insert_address( [
           'name'    => $name,
           'address' => $address,
           'phone'   => $phone,
        ] );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        $redirect_to = admin_url( 'admin.php?page=wedevs-academy&inserted=true' );
        wp_redirect( $redirect_to );
    }
}    