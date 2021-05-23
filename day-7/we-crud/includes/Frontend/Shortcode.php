<?php

namespace We\Crud\Frontend;

/**
 * shortcode handle class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class shortcode {

    /**
     * initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'we-crud', [ $this, 'render_shortcode' ] );
    }
    
    /**
     * shortcode handle class
     * 
     * @since 1.0.0
     * 
     * @param array $atts
     * @param string $content
     * 
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        return "Hello From shortcode";
    }
}
