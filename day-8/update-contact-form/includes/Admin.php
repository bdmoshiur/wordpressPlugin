<?php

namespace Formsubmit\Ajax;

/**
 * The frontend main Class
 * 
 * @since 1.0.0
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
        $this->wd_dispatch_actions( $addressbook );
        new Admin\Menu( $addressbook );
    }

    /**
     * User info delete function render
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function wd_dispatch_actions( $addressbook ) {
        add_action( 'admin_post_wd-af-delete-address', [ $addressbook, 'delete_address'] );
        
    }
}
