<?php
namespace Formsubmit\Ajax\Frontend;

/**
 * The Shortcode class of plugin
 */
class Mrm_Ajax_Form_Shortcode {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'form_short', [ $this, 'ajax_form_render' ] );
    }

    /**
     * form field add function
     *
     * @param array $atts
     * @param string/array $content
     * 
     * @return string
     */
    public function ajax_form_render( $atts, $content = '' ) {
        
        wp_enqueue_script( 'form-script' );
        wp_enqueue_style( 'form-style' );

        ob_start();
        include __DIR__ . '/views/shortcode.php';

        return ob_get_clean();
    }
}
