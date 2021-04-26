<?php

namespace Formsubmit\Ajax\Admin;

/**
 * The main menu class
 * 
 * @since 1.0.0
 */
class Menu {

    /**
     * Addressbook class instance
     * 
     * @since 1.0.0
     */
    public $addressbook;

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct( $addressbook ) {
        $this->addressbook = $addressbook;
        add_action( 'admin_menu', [ $this, 'admin_menu'] );
    }

    /**
     * The main menu add function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'user-information';
        $capability = 'manage_options';
        add_menu_page( __( 'User Information', 'form_submit_ajax' ), __( 'Contact Form info', 'form_submit_ajax' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ], 'dashicons-admin-users' );
        add_submenu_page( $parent_slug, __('Users Address', 'form_submit_ajax' ), __( 'User Information', 'form_submit_ajax' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ] );
        add_submenu_page( $parent_slug, __( 'Address Setting', 'form_submit_ajax' ), __( 'Setting', 'form_submit_ajax' ), $capability, 'address-setting', [ $this, 'wd_menu_setting' ] );
    }

    /**
     * Setting page render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function wd_menu_setting() {
        echo '<h2>' . __( 'Setting Page', 'form_submit_ajax' ) . '</h2>';
    }
} 