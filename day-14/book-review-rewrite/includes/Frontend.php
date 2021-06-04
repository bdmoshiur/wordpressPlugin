<?php

namespace Book\Review\Rewrite;

/**
 * The frontend main Class
 */
class Frontend {

    /**
     * Construct function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    function __construct() {
        new Frontend\Shortcode();
    }
}
