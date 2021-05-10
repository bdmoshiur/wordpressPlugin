<?php
namespace Wedevs\Academy;

/**
 * Api class
 */
class API {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'rest_api_init', 'registet_api');
    }

    /**
     * Register Api function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function registet_api() {
        $addressbook = new API\Addressbook();
        $addressbook->register_routes();
    }
} 