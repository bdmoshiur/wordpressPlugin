<?php

namespace Featured\Posts;

/**
 * The admin main Class
 */
class Admin {
    function __construct() {
        new Admin\Featured_Post_Settings();
    }
}
