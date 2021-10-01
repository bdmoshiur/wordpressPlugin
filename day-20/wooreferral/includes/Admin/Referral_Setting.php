<?php

namespace Woo\Referral\Admin;

/**
 * The main addressbook class
 */
class Referral_Setting {

    /**
     * Construct function
     * 
     * @since 1.0.0
     */
    public function __construct(){
        add_action( 'admin_menu', [ $this, 'admin_menu'] );
    }

    /**
     * The main menu add function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'referral-coupon';
        $capability  = 'manage_options';
        
        add_menu_page( __( 'WooReferral', 'woo-referral' ), __( 'WooReferral', 'woo-referral' ), $capability, $parent_slug, [ $this, 'woo_referral_menu_render' ], 'dashicons-cart' );
        add_submenu_page( $parent_slug, __('Woo General Referral', 'woo-referral' ), __( 'General Referral Rules', 'woo-referral' ), $capability, $parent_slug, [ $this, 'woo_referral_menu_render' ] );
        add_submenu_page( $parent_slug, __( 'Woo Coupon Conversion', 'woo-referral' ), __( 'Coupon Conversion', 'woo-referral' ), $capability, 'coupon-conversion', [ $this, 'woo_coupon_conversion_render' ] );
    }

    /**
     * woo referral menu render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function woo_referral_menu_render() {
        wp_enqueue_style( 'admin-style' );
        wp_enqueue_script( 'admin-script' );
        
        $template = __DIR__ . '/views/referral-seting-view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }

    }

    /**
     * woo coupon conversion render function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function woo_coupon_conversion_render() {
        wp_enqueue_style( 'admin-style' );
        wp_enqueue_script( 'admin-script' );
        
        $template = __DIR__ . '/views/coupon-conversion-view.php';

        if ( file_exists( $template ) ) {
            include $template;
        }

    }
}    