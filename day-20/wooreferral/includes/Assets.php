<?php

namespace Woo\Referral;

/**
 * The Assets main Class
 */
class Assets {

    /**
     * constructor function 
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

     /**
     * Styles get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_styles() {
        return [
            'front-style' => [
                'src'     => WOO_REFERRAL_ASSETS . '/css/frontend.css',
                'version' => filemtime( WOO_REFERRAL_PATH . '/assets/css/frontend.css' ),
            ],
            'admin-style' => [
                'src'     => WOO_REFERRAL_ASSETS . '/css/admin.css',
                'version' => filemtime( WOO_REFERRAL_PATH . '/assets/css/admin.css' ),
            ]
        ];
    }

    /**
     * Scripts get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'front-script' => [
                'src'     => WOO_REFERRAL_ASSETS . '/js/frontend.js',
                'version' => filemtime( WOO_REFERRAL_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery', 'wp-util' ],
            ],
            'admin-script' => [
                'src'     => WOO_REFERRAL_ASSETS . '/js/admin.js',
                'version' => filemtime( WOO_REFERRAL_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ],
            ]
        ];
    }
    
    /**
     * Assets enqueue function
     * 
     * @since 1.0.0
     * 
     * @return mixed
     */
    public function enqueue_assets() {
        //Styles register 
        $styles = $this->get_styles();
        
        foreach ( $styles as $handale => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handale, $style['src'], $deps, $style['version'] );
        }

          //Scripts register
          $scripts = $this->get_scripts();
          
          foreach ( $scripts as $handale => $script ) {
              $deps = isset( $script['deps'] ) ? $script['deps'] : false;
              wp_register_script( $handale, $script['src'], $deps, $script['version'], true );
          }

        //scripts localize function
        wp_localize_script( 'front-script', 'WOOF', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'woo-referral' ),
        ] );
        
        //scripts localize function
        wp_localize_script( 'admin-script', 'WOOF', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ] );
    }
}