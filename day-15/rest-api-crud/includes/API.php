<?php

namespace Rest\Product;

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
        add_action( 'rest_api_init', [ $this,'registet_api' ] );
    }

    /**
     * Register Api function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function registet_api() {
        $product = new API\Product();
        $product->register_routes();
    }
} 