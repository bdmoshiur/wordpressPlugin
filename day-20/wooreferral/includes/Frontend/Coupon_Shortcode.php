<?php

namespace Woo\Referral\Frontend;

/**
 * The Shortcode class of plugin
 */
class Coupon_Shortcode {
    
    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'coupon_shortcode', [ $this, 'coupon_shortcodes_render'] );
    }

    function coupon_shortcodes_render( $atts = [] ) {
        wp_enqueue_style( 'front-style' );

        $coupon_atts = shortcode_atts( [
                'posts_per_page' => -1,
                'orderby' => 'id',
                'order' => 'asc',
                'post_type' => 'shop_coupon',
                'post_status' => 'publish',
        ], $atts );

        $args = array(
            'posts_per_page'   => $coupon_atts['posts_per_page'],
            'orderby'          => $coupon_atts['orderby'],
            'order'            => $coupon_atts['order'],
            'post_type'        => $coupon_atts['post_type'],
            'post_status'      => $coupon_atts['post_status'],
        );
        $coupon_codes = get_posts( $args );

        $template = __DIR__ . '/views/coupon_shortcode_view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}
