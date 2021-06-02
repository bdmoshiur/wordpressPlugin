<?php

namespace Author\Box;

/**
 * The frontend main class
 */
class Frontend {

    /**
     * Construct function
     * 
     * @since 1.0.0
     */
    function __construct() {
        new Frontend\User_Meta_Bio();
    }
}
