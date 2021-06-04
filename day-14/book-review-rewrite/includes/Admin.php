<?php

namespace Book\Review\Rewrite;

/**
 * The admin main Class
 */
class Admin {

    /**
     * Construct function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    function __construct() {
        new Admin\Ajax();
        new Admin\Assets();
        new Admin\Metabox();
        new Admin\Custom_Post();
        new Admin\Rewrite();
        new Admin\Custom_Taxonomy();
    }
}
