<?php

namespace Woo\Referral;

/**
 * The frontend main Class
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
        new Admin\Referral_Setting();
    }
}
