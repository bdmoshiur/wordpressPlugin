<?php

namespace Woo\Multipart\Form\Admin;

/**
 * The Menu Handale Class
 */
class Multipart_checkout {

    /**
     * Initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this,  'enqueue_script_site' ] );
        add_filter( 'woocommerce_locate_template', [ $this, 'custom_woocommerce_locate_template'], 10, 3 );
    }

    /**
     * Enqueue script function
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_script_site() {
        wp_enqueue_style( 'multipart-checkout-form-style1', WMPCF_ASSETS . '/css/main.css' );
        wp_enqueue_style( 'multipart-checkout-form-style2', WMPCF_ASSETS . '/css/jquery.steps.css' );

        wp_enqueue_script( 'multipart-checkout-form-script1', WMPCF_ASSETS . '/js/jquery.steps.js', array( 'jquery' ), time(), true );
        wp_enqueue_script( 'multipart-checkout-form-script2', WMPCF_ASSETS . '/js/main.js', array( 'multipart-checkout-form-script1' ), time(), true );
    }

    /**
     * Custom woocommerce locate template function
     * 
     * @since 1.0.0
     * 
     * @param string $template
     * @param string $template_name
     * @param string $template_path
     * 
     * @return string
     */
    public function custom_woocommerce_locate_template( $template, $template_name, $template_path ) {
        $basename = basename( $template );

        if ( $basename == 'form-checkout.php' ) {
            $template = trailingslashit( WMPCF_PATH ) . 'includes/admin/views/multipart-checkout-form.php';
        }

        return $template;
    }
}