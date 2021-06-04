<?php

namespace We\Crud;

/**
 * The admin Class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Admin {
    
    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        $addressbook = new Admin\Addressbook();

        $this->dispatch_actions( $addressbook );
        
        new Admin\Menu( $addressbook );
    }

    /**
     * Dispath action function
     *
     * @since 1.0.0
     * 
     * @param mixd $addressbook
     * 
     * @return void
     */
    public function dispatch_actions( $addressbook ) {
        add_action( 'admin_init', [ $addressbook, 'form_handler' ] );
        add_action( 'admin_post_wd-fp-delete-address', [ $addressbook, 'delete_address' ] );
    }
}

