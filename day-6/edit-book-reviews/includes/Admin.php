<?php

namespace Ubrp\Book\Review;

/**
 * The admin Class
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
    public function __construct() {
        new Admin\Taxonomy();
        new Admin\Book_Reviews();
        new Admin\Shortcode();
    }
}
