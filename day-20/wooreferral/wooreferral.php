<?php
/**
 * Plugin Name:       WooReferral
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       WooReferral plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-referral
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
final class Woo_Referral {

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
     * @return \Woo_Referral
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
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
        define( 'WOO_REFERRAL_VERSION', self::VERSION );
        define( 'WOO_REFERRAL_FILE', __FILE__ );
        define( 'WOO_REFERRAL_PATH', __DIR__ );
        define( 'WOO_REFERRAL_URL', plugins_url( '', WOO_REFERRAL_FILE ) );
        define( 'WOO_REFERRAL_ASSETS',  WOO_REFERRAL_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * return void
     */
    public function init_plugin() {
        new Woo\Referral\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Woo\Referral\Ajax();
        }
        
        new Woo\Referral\Admin();
        new Woo\Referral\Frontend();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
        $installer = new Woo\Referral\Installer();
        $installer->run();
    }
}

/**
 * initialize the main plugin
 *
 * @since 1.0.0
 *  
 * @return \Woo_Referral
 */
function wr_woo_referral() {
    return Woo_Referral::init();
}
 
/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */
wr_woo_referral();


