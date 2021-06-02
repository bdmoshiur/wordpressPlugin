<?php

namespace Author\Box;

/**
 * The admin main Class
 */
class Admin {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     */
    function __construct() {
        new Admin\User_Meta_field();
    }
}
