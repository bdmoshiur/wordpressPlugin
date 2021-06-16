<?php
/**
 * Plugin Name:       Customer Total Purchase
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Customer Total Purchase.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       customer-total-purchase
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
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
final class CTP_Customer_Total_Purchase {

    /**
     * plugin Version
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    const VERSION = '1.0.0';

    /**
     * Contructor function
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
     * @return \CTP_Customer_Total_Purchase
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
        define( 'CTP_VERSION', self::VERSION );
        define( 'CTP_FILE', __FILE__ );
        define( 'CTP_PATH', __DIR__ );
        define( 'CTP_URL', plugins_url( '', CTP_FILE ) );
        define( 'CTP_ASSETS',  CTP_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function init_plugin() {
        new CTP\Total\Purchase\Admin();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
        $installed = get_option( 'wmpcp_time' );

        if ( ! $installed ) {
            update_option( 'wmpcp_time', time() );
        }

        update_option( 'wmpcp_version', CTP_VERSION );
    }
}

/**
 * initialize the main plugin
 * 
 * @since 1.0.0
 * 
 * @return \CTP_Customer_Total_Purchase
 */
function ctp_customer_total_purchase() {
    return CTP_Customer_Total_Purchase::init();
}
 
/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */
ctp_customer_total_purchase();


