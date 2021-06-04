<?php

namespace We\Crud\Admin;

/**
 * The Menu Handale Class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Menu {

    /**
     * Addressbook variable
     *
     * @var object
     */
    public $addressbook;

    /**
     * Cronstructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct( $addressbook ) {
        $this->addressbook = $addressbook;
        add_action( 'admin_menu', [ $this,'admin_menu'] );
    }

    /**
     * Admin_menu function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function admin_menu () {
        $parent_slug = 'we-crud';
        $capability  = 'manage_options';

        add_menu_page( __('We Crud','we-crud'), __('We Crud','we-crud'), $capability, $parent_slug, [  $this->addressbook, 'plugin_page'], 'dashicons-admin-customizer' );
        add_submenu_page( $parent_slug, __('Address Book','we-crud'), __('Addtess Book','we-crud'), $capability, $parent_slug,[  $this->addressbook,'plugin_page' ] );
        add_submenu_page( $parent_slug, __('Settings','we-crud'), __('Settings Book','we-crud'), $capability, 'we-crud-settings',[ $this,'settings_page' ] );
    }
    
    /**
     * handle the setting class
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function settings_page() {
        echo "Hello Settings";
    }
}
