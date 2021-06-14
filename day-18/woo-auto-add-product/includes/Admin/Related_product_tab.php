<?php

namespace Woo\Multipart\Checkout\Admin;

/**
 * The Menu Handale Class
 */
class Related_product_tab {
    
    /**
     * Initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_filter( 'woocommerce_product_tabs', [ $this, 'woocommerce_product_tabs_render' ] );
        add_action( 'woocommerce_shop_loop_item_title', [ $this, 'woocommerce_shop_loop_item_title_render' ], 9 );
    }

    /**
     * woocommerce product tabs render function
     * 
     * @since 1.0.0
     * 
     * @param array $tabs
     * 
     * @return array
     */
    public function woocommerce_product_tabs_render( $tabs = array() ) {
        global $post;

        if ( $post->post_content ) {
			$tabs['relatedproduct'] = [
				'title'    => __( 'Related Product Show', 'woocommerce' ),
				'priority' => 150,
				'callback' => [ $this, 'woocommerce_product_relatedproduct_tab_render' ],
            ];
		}

        return $tabs;
    }

    /**
     * woocommerce product relatedproduct tab render
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function woocommerce_product_relatedproduct_tab_render() {
        wc_set_loop_prop( 'related_product_loops', 'one' );
        
        woocommerce_related_products( [
            'posts_per_page' => 5,
            'columns'        => 4,
            'orderby'        => 'rand'
        ] );

        wc_set_loop_prop( 'related_product_loops', '' );
    }

    /**
     * Render the woocommerce shop loop item title function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function woocommerce_shop_loop_item_title_render() {
        global $product;

        $loop_info = wc_get_loop_prop( 'related_product_loops' );
         
        if ( is_product() && $loop_info === 'one' ) {
             echo $product->get_short_description();
        }

    }
}