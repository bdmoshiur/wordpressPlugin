<?php
/**
 * Plugin Name:       Edit Book Reviews
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Edit Book Reviews plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       edit-book-reviews
 * Domain Path:       /languages
*/

/**
 * The Main Plugin class
 * 
 * @since 1.0.0
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit;
}

/**
 * composer file loaded
 * 
 * @since 1.0.0
*/
require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The main class of plugin
*/
final class Demo_Test {

    /**
     * plugin Version
     * 
     * @since 1.0.0
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
     * @return \Demo_Test
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
        define( 'DEMO_TEST_VERSION', self::VERSION );
        define( 'DEMO_TEST_FILE', __FILE__  );
        define( 'DEMO_TEST_PATH', __DIR__  );
        define( 'DEMO_TEST_URL', plugins_url('', DEMO_TEST_FILE ) );
        define( 'DEMO_TEST_ASSETS',  DEMO_TEST_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * return void
    */
    public function init_plugin() {
        new Demo\Test\Admin();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
    */
    public function activate() {
        $installed = get_option( 'demo_test_time' );

        if ( ! $installed ) {
           update_option( 'demo_test_time', time() );
        }
        update_option( 'demo_test_version', DEMO_TEST_VERSION );
    }
}

/**
 * initialize the main plugin
 *
 * @since 1.0.0
 *
 * @return \Demo_Test 
*/
function mrm_demo_test() {

    return Demo_Test::init();
}
 
/**
 * Kick of The Plugin
 *
 * @since 1.0.0
*/
mrm_demo_test();


