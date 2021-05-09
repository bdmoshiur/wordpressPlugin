<?php
/**
 * Plugin Name:       Update Contact Form
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Update contact form plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       form_submit_ajax
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 * 
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * composer loaded
 * 
 * @since 1.0.0
 */
require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The Main Plugin class
 */
final class Mrm_Form_Submit_Ajax {
    /**
     * plugin Version
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    const VERSION = '1.0.0';

    /**
     * class contructor
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__,  [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
     }

    /**
     * initialize a singleton instance
     *  
     * @since 1.0.0
     * 
     * @return \Mrm_Form_Submit_Ajax
     */
    public static function init() {
        static $instance = false;

        if( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the Required Plugin Constants
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function define_constants() {
        define( 'FORM_AJAX_SUBMIT_VERSION', self::VERSION );
        define( 'FORM_AJAX_SUBMIT_FILE', __FILE__ );
        define( 'FORM_AJAX_SUBMIT_PATH', __DIR__ );
        define( 'FORM_AJAX_SUBMIT_URL', plugins_url( '', FORM_AJAX_SUBMIT_FILE ) );
        define( 'FORM_AJAX_SUBMIT_ASSETS',  FORM_AJAX_SUBMIT_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * return void
     */
    public function init_plugin() {
        new Formsubmit\Ajax\Mrm_Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
            new Formsubmit\Ajax\Mrm_Ajax();
        }
        
        if ( is_admin() ) {
            new Formsubmit\Ajax\Admin();
        } else {
            new Formsubmit\Ajax\Frontend();
        }
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
        $installer = new Formsubmit\Ajax\Installer();
        $installer->run();
    }
}

/**
 * initialize the main plugin
 *
 * @since 1.0.0
 *  
 * @return \Mrm_Form_Submit_Ajax
 */
function mrm_form_submit_ajax() {
     
    return Mrm_Form_Submit_Ajax::init();
}
 
/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */
mrm_form_submit_ajax();


