<?php

namespace Woo\Referral\Frontend;

/**
 * The Shortcode class of plugin
 */
class Generate_Coupon {
    
    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'init', [ $this, 'generate_coupon_add_endpoint' ] );
        add_action( 'query_vars', [ $this, 'generate_coupon_query_vars' ] );

        add_filter( 'woocommerce_account_menu_items', [ $this, 'generate_coupon_add_link_my_account'], 99, 1 );
        add_action( 'woocommerce_account_generate-coupon_endpoint', [ $this, 'generate_coupon_content' ] );
    }

    /**
     * Generate coupon add endpoint function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function generate_coupon_add_endpoint() {
        add_rewrite_endpoint( 'generate-coupon', EP_ROOT | EP_PAGES );
    }

    /**
     * Generate coupon query vars function
     *
     * @since 1.0.0
     * 
     * @param array $vars
     * 
     * @return array
     */
    public function generate_coupon_query_vars( $vars ) {
        $vars[] = 'generate-coupon';
        
        return $vars;
    }

    /**
     * Generate coupon add link my account function
     *
     * @since 1.0.0
     * 
     * @param array $items
     * 
     * @return array
     */
    public function generate_coupon_add_link_my_account( $items ) {
        $items['generate-coupon'] = 'Generate Coupon';

        return $items;
    }

    /**
     * Generate coupon content function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function generate_coupon_content() {
        wp_enqueue_script( 'front-script' );

        $conversions      = woo_coupon_conversion();
        $generate_coupons = get_generate_coupons();

        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'id',
            'order'            => 'asc',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );
        $coupon_codes = get_posts( $args );

        $template = __DIR__ . '/views/generate_coupon_view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
        
    }
}
