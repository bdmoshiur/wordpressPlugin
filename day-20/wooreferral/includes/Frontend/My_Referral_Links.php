<?php

namespace Woo\Referral\Frontend;

/**
 * The Shortcode class of plugin
 */
class My_Referral_Links {
    
    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'init', [ $this, 'my_referral_links_add_endpoint' ] );
        add_action( 'query_vars', [ $this, 'my_referral_links_query_vars' ] );
        add_filter( 'woocommerce_account_menu_items', [ $this, 'my_referral_links_add_link_my_account'], 99, 1 );
        add_action( 'woocommerce_account_my-referral-links_endpoint', [ $this, 'my_referral_links_content' ] );
    }

    /**
     * My referral links add endpoint function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function my_referral_links_add_endpoint() {
        add_rewrite_endpoint( 'my-referral-links', EP_ROOT | EP_PAGES );
    }

    /**
     * My referral links query vars function
     *
     * @since 1.0.0
     * 
     * @param array $vars
     * 
     * @return array
     */
    public function my_referral_links_query_vars( $vars ) {
        $vars[] = 'my-referral-links';

        return $vars;
    }

    /**
     * My referral links add link my account function
     *
     * @since 1.0.0
     * 
     * @param array $items
     * 
     * @return array
     */
    public function my_referral_links_add_link_my_account( $items ) {
        $items['my-referral-links'] = 'My Referral Links';
        
        return $items;
    }

    /**
     * My referral links content function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function my_referral_links_content() {
        wp_enqueue_script( 'front-script' );

        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'id',
            'order'            => 'asc',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );
        $referrals = get_posts( $args );
        
        if ( ! empty( $referrals ) ) {
            $home_url = home_url();
            $template = __DIR__ . '/views/my_referral_links_view.php';

            if ( file_exists( $template ) ) {
                include $template;
            }
        }
    }
}
