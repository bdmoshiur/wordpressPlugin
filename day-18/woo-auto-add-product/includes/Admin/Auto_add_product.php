<?php

namespace Woo\Multipart\Checkout\Admin;

/**
 * The Menu Handale Class
 */
class Auto_add_product {

    /**
     * Initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_filter( 'single_template', [ $this, 'auto_add_product'] );
    }

    /**
     * Undocumented function
     *
     * @since 1.0.0
     * 
     * @param string $template
     * 
     * @return void
     */
    public function auto_add_product( $template ) {
        if ( is_singular( 'product' ) ) {

            global $post;
            
            $product_id = $post->ID;

            if ( ! $this->check_product( $product_id ) ) {
                WC()->cart->add_to_cart( $product_id );
            }
            
        }

        return $template;
    }

    /**
     * check product function
     *
     * @since 1.0.0
     * 
     * @param int $id
     * 
     * @return void
     */
    public function check_product( $id ) {
        $test = false;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $_product = $values['product_id'];

            if ( $_product == $id ){
                $test = true;
            }
            
        }

        return $test;
    }
}
