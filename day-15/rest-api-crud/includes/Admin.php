<?php

namespace Rest\Product;

/**
 * Admin Class
 */
class Admin {

    /**
     * constructor function
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
     * Bind addressbook class function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function dispatch_actions( $addressbook ) {
        add_action( 'admin_init', [ $addressbook, 'form_handler'] );
        add_action( 'admin_post_wd-ac-delete-address', [ $addressbook, 'delete_address'] );
    }
} 