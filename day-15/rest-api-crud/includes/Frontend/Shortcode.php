<?php

namespace Rest\Product\Frontend;

/**
 * Frontend render shortcode class
 */
class Shortcode {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'address_book', [ $this, 'shortcode_render' ] );
    }
    
    /**
     * shortcode render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function shortcode_render() {
        echo "<div>". __( 'Hello from shortcode', 'wedevs-academy' )."</div>";
    }
} 