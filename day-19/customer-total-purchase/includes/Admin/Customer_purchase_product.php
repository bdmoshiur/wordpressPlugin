<?php

namespace CTP\Total\Purchase\Admin;

/**
 * The Menu Handale Class
 */
class Customer_purchase_product {

    /**
     * Construct function
     * 
     * @since 1.0.0
     */
    function __construct( ){
        add_action( 'dokan_order_detail_after_order_notes', [ $this, 'dokan_order_detail_after_order_notes_render'] );
    }


    /**
     * dokan order detail after order notes function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function dokan_order_detail_after_order_notes_render ( $order_id ) {
        $order   = wc_get_order( $order_id );
        $user_id = $order->get_customer_id();
        $data    = wc_get_customer_total_spent( $user_id );

        $template = CTP_PATH . '/includes/admin/views/product_purchase_total.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}