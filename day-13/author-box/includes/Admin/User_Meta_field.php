<?php

namespace Author\Box\Admin;

/**
 * The Menu Handale Class
 */
class User_Meta_field {
    
    /**
     * Initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_filter( 'user_contactmethods', [ $this, 'render_user_contact_methods' ] );
    }

    /**
     * User metafield generate function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function render_user_contact_methods( $methods ) {
        $methods[ 'facebook' ] = __( 'Facebook', 'author-box' );
        $methods[ 'twitter' ]  = __( 'Twitter', 'author-box' );
        $methods[ 'linkedin' ] = __( 'Linkedin', 'author-box' );

        return $methods;
    }
}
