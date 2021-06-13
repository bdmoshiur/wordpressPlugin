<?php

namespace Woo\Multipart\Checkout;

/**
 * The admin main Class
 */
class Admin {

    /**
     * Constructor function
     */
    function __construct() {
        new Admin\Auto_add_product();
        new Admin\Related_product_tab();
    }
}
