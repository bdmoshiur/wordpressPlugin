<?php

namespace Rest\Product\Admin;

/**
 * Addressbook menu class
 */
class Menu {

    /**
     * Set variable
     *
     * @since 1.0.0
     * 
     * @var object
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
     * Menu set function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'wedevs-academy';
        $capability  = 'manage_options';
        add_menu_page( 'Wedevs Academy', 'Academy', $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ], 'dashicons-amazon' );
        add_submenu_page( $parent_slug, 'Address Books', 'Address Book', $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ] );
        add_submenu_page( $parent_slug, 'Address Setting', 'Setting', $capability, 'address-setting', [ $this, 'wd_menu_setting' ] );
    }

    /**
     * Menu page render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function wd_menu_setting() {
        echo __( 'Address book Setting Page', 'wedevs-academy' );
    }
} 