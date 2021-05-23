<?php

namespace Recent\Posts;

/**
 * Assets class
 */
class Assets {
    
    /**
     * Class constructor
     * 
     * @since 1.0.0
     * @return void
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_script' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_script' ] );
    }

    /**
     * Register scripts
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function register_script() {
        wp_register_script( 'mrm-main', RECENT_POSTS_ASSETS . '/js/mrm-main.js', [ 'jquery' ], filemtime( RECENT_POSTS_PATH . '/assets/js/mrm-main.js' ), true );

        wp_localize_script( 'mrm-main', 'mrmobj', [
            'ajax_url' => \admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'dashboard_form_handle' ),
        ] );
    }
}