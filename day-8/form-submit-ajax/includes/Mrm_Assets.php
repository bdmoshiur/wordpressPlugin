<?php
namespace Formsubmit\Ajax;

/**
 * The Assets main Class
 */
class Mrm_Assets {

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
     * Scripts get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'form-script' => [
                'src'     => FORM_AJAX_SUBMIT_ASSETS . '/js/frontend.js',
                'version' => filemtime( FORM_AJAX_SUBMIT_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery', 'wp-util' ],
            ]
        ];
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
            'form-style'  => [
                'src'     => FORM_AJAX_SUBMIT_ASSETS . '/css/frontend.css',
                'version' => filemtime( FORM_AJAX_SUBMIT_PATH . '/assets/css/frontend.css' ),
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
        
        //Scripts register
        $scripts = $this->get_scripts();
        foreach ( $scripts as $handale => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handale, $script['src'], $deps, $script['version'], true );
        }

        //Styles register 
        $styles = $this->get_styles();
        foreach ( $styles as $handale => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handale, $style['src'], $deps, $style['version'] );
        }

        //scripts localize function
        wp_localize_script( 'form-script', 'obj', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ] );
    }
}