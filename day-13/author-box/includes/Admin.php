<?php
namespace Author\Box;

/**
 * The admin main Class
 */
class Admin {
    function __construct() {
        new Admin\User_Meta_field();
    }
}
