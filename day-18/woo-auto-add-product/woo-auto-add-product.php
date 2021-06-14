<?php
/**
 * Plugin Name:       Woo Auto Add Product
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Demo test plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-auto-add-product
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
final class Woo_Auto_Add_Product {

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
     * @return \Woo_Auto_Add_Product
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
        define( 'WMPCP_VERSION', self::VERSION );
        define( 'WMPCP_FILE', __FILE__ );
        define( 'WMPCP_PATH', __DIR__ );
        define( 'WMPCP_URL', plugins_url( '', WMPCP_FILE ) );
        define( 'WMPCP_ASSETS',  WMPCP_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function init_plugin() {
        new Woo\Multipart\Checkout\Admin();
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

        update_option( 'wmpcp_version', WMPCP_VERSION );
    }
}

/**
 * Initialize the main plugin
 * 
 * @since 1.0.0
 * 
 * @return \Woo_Auto_Add_Product
 */
function woo_auto_add_product() {
    return Woo_Auto_Add_Product::init();
}
 
/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */
woo_auto_add_product();