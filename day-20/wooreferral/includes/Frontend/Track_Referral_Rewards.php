<?php

namespace Woo\Referral\Frontend;

/**
 * The Shortcode class of plugin
 */
class Track_Referral_Rewards {
    
    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'init', [ $this, 'set_token' ] );
        add_action( 'init', [ $this, 'track_referral_rewards_add_endpoint' ] );
        add_action( 'query_vars', [ $this, 'track_referral_rewards_query_vars' ] );
        add_filter( 'woocommerce_account_menu_items', [ $this, 'track_referral_rewards_add_link_my_account'], 99, 1 );
        add_action( 'woocommerce_account_track-referral-rewards_endpoint', [ $this, 'track_referral_rewards_content' ] );
    }

    /**
     * Track referral rewards add endpoint function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function track_referral_rewards_add_endpoint() {
        add_rewrite_endpoint( 'track-referral-rewards', EP_ROOT | EP_PAGES );
    }

    /**
     * Track referral rewards query vars function
     *
     * @since 1.0.0
     * 
     * @param array $vars
     * 
     * @return void
     */
    public function track_referral_rewards_query_vars( $vars ) {
        $vars[] = 'track-referral-rewards';
        
        return $vars;
    }

    /**
     * Track referral rewards add link my account function
     *
     * @since 1.0.0
     * 
     * @param array $items
     * 
     * @return array
     */
    public function track_referral_rewards_add_link_my_account( $items ) {
        $items['track-referral-rewards'] = 'Track Referral Rewards';

        return $items;   
    }

    /**
     * Track referral rewards content function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function track_referral_rewards_content() {
        $transitions = get_woo_transition();
        
        $coupons      = get_referral_coupons();
        $coupon_codes = [];
       
        foreach ( $coupons as $coupon ) {

            if ( ! isset( $coupon_codes[ $coupon['coupon_code'] ] ) ) {
                $coupon_codes[ $coupon['coupon_code'] ] = 0;
            }

            $coupon_codes[ $coupon['coupon_code'] ]++;
        }

        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'id',
            'order'            => 'asc',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );
        $coupon_codes = get_posts( $args );
        
        $template    = __DIR__ . '/views/tracks_referral_rewards_view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    public static function set_token() {

        if ( is_admin() ) return;

        $user_id = isset( $_GET[ 'ref' ] ) ? sanitize_text_field( $_GET[ 'ref' ] )      : '';
        $coupon  = isset( $_GET[ 'coupon' ] ) ? sanitize_text_field( $_GET[ 'coupon' ] ): '';
        
        if ( ! empty( $user_id ) && !empty( $coupon ) ) {
        
            global $wpdb;
            $wpdb->insert(
                $wpdb->prefix . 'woo_visits',
                [
                    'user_id'     => $user_id,
                    'coupon_code' => $coupon,
                    'time'        => current_time( 'timestamp' ),
                ],
                [
                    '%d',
                    '%s',
                    '%d',
                ]
            );
        }
    }
}
