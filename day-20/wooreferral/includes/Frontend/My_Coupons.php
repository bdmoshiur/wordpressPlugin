<?php

namespace Woo\Referral\Frontend;

/**
 * The Shortcode class of plugin
 */
class My_Coupons {
    
    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'init', [ $this, 'my_coupons_add_endpoint' ] );
        add_action( 'query_vars', [ $this, 'my_coupons_query_vars' ] );
        add_filter( 'woocommerce_account_menu_items', [ $this, 'my_coupons_add_link_my_account'], 99, 1 );
        add_action( 'woocommerce_account_my-coupon_endpoint', [ $this, 'my_coupons_content' ] );
    }

    /**
     * My coupons add endpoint function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function my_coupons_add_endpoint() {
        add_rewrite_endpoint( 'my-coupon', EP_ROOT | EP_PAGES );
    }

    /**
     * My coupons query vars function
     *
     * @since 1.0.0
     * 
     * @param array $vars
     * 
     * @return array
     */
    public function my_coupons_query_vars( $vars ) {
        $vars[] = 'my-coupon';
        
        return $vars;
    }

    /**
     * My coupons add link my account function
     *
     * @since 1.0.0
     * 
     * @param array $items
     * 
     * @return array
     */
    public function my_coupons_add_link_my_account( $items ) {
        $items['my-coupon'] = 'My Coupons';

        return $items;
    }

    /**
     * My coupons content function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function my_coupons_content() {

        wp_enqueue_style( 'front-style' );

        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'id',
            'order'            => 'asc',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );
        $coupon_codes = get_posts( $args );

        $template = __DIR__ . '/views/my_coupon_view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
        
    }
}
